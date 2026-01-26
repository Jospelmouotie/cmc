<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Patient;
use App\Models\User;
use App\Models\Produit;
use App\Models\FicheConsommable;
use App\Models\FactureConsultation;
use App\Models\SoinsInfirmier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PatientsController extends Controller
{
    /**
     * Liste des patients avec cache intelligent
     */
    public function index(Request $request)
    {
        $this->authorize('update', Patient::class);

        $name = $request->input('name');
        $perPage = (int) $request->input('per_page', 50);
        $page = (int) $request->input('page', 1);

        // On utilise le dernier timestamp de modification des patients pour invalider le cache globalement
        $lastUpdate = Patient::latest('updated_at')->value('updated_at') ?? 'never';

        $cacheKey = sprintf('patients_idx_u%s_s%s_p%s_v%s',
            auth()->id(),
            md5($name ?? 'all'),
            $page,
            strtotime($lastUpdate)
        );

        $patients = Cache::remember($cacheKey, now()->addMinutes(60), function () use ($name, $perPage) {
            $query = Patient::query()->select([
                'id', 'numero_dossier', 'name', 'prenom', 'montant', 'reste',
                'assurance', 'prise_en_charge', 'date_insertion', 'created_at'
            ]);

            if (!empty($name)) {
                $query->where(function ($q) use ($name) {
                    $q->where('name', 'like', "%{$name}%")
                      ->orWhere('prenom', 'like', "%{$name}%")
                      ->orWhere('numero_dossier', 'like', "%{$name}%");
                });
            }

            return $query->latest()->paginate($perPage);
        });

        if ($name) {
            $patients->appends(['name' => $name, 'per_page' => $perPage]);
        }

        return view('admin.patients.index', compact('patients', 'name', 'perPage'));
    }

    /**
     * Store : Nettoyage manuel du cache lors de l'ajout
     */
    public function store(Request $request)
    {
        $this->authorize('update', Patient::class);
        // ... (votre validation reste la même)

        try {
            DB::transaction(function () use ($request) {
                // Création du patient (votre logique buildModePaiementInfo...)
                $patient = Patient::create([
                    // ... vos champs
                ]);
            });

            // On force l'expiration des listes en changeant le timestamp global indirectement
            // (Le prochain 'index' verra un nouveau timestamp 'latest updated_at')

            return redirect()->route('patients.index')->with('success', 'Patient ajouté');
        } catch (\Exception $e) {
            Log::error('Patient Store Error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Erreur lors de l\'ajout');
        }
    }

    /**
     * Show : Cache busté par les timestamps des relations
     */
    public function show(Patient $patient)
    {
        $this->authorize('update', Patient::class);

        // Stratégie de "Cache Busting" par les dates de mise à jour
        $ts = [
            'p' => strtotime($patient->updated_at),
            'c' => strtotime($patient->consultations()->latest()->value('updated_at') ?? 'now'),
            'e' => $patient->examens()->count()
        ];

        $cacheKey = "patient_v3_{$patient->id}_" . implode('_', $ts);

        $data = Cache::remember($cacheKey, 300, function () use ($patient) {
            $patient->load(['consultations.user', 'consultation_anesthesistes.user', 'dossiers']);

            return [
                'examens_scannes' => $patient->examens()->latest()->paginate(4),
                'consultations' => $patient->consultations->first(),
                'consultation_anesthesistes' => $patient->consultation_anesthesistes->first(),
                'dossiers' => $patient->dossiers->first(),
                'parametres' => $patient->parametres()->latest()->first(),
                'ordonances' => $patient->ordonances()->with('user')->latest()->paginate(5),
                'compte_rendu_bloc_operatoires' => $patient->compte_rendu_bloc_operatoires()->latest()->first()
            ];
        });

        $medecin = Cache::remember('medecins_list_select', 3600, function () {
            return User::where('role_id', 2)->select('id', 'name', 'prenom')->orderBy('name')->get();
        });

        return view('admin.patients.show', array_merge(['patient' => $patient, 'medecin' => $medecin], $data));
    }

    /**
     * Mise à jour des consommables (Gestion du stock + Cache)
     */
    public function FicheConsommableStore(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'consommable' => 'required|string',
            'date' => 'required|date',
        ]);

        try {
            DB::transaction(function () use ($request) {
                FicheConsommable::create([
                    'user_id' => auth()->id(),
                    'patient_id' => $request->patient_id,
                    'consommable' => $request->consommable,
                    'jour' => $request->input('jour', 0),
                    'nuit' => $request->input('nuit', 0),
                    'date' => $request->date,
                ]);

                // Mise à jour du stock produit
                $qty = (int)$request->input('jour', 0) + (int)$request->input('nuit', 0);
                if ($qty > 0) {
                    Produit::where('designation', $request->consommable)
                        ->decrement('qte_stock', $qty);
                }
            });

            // On touche le patient pour invalider son cache 'show'
            Patient::find($request->patient_id)->touch();

            return back()->with('success', 'Consommable enregistré et stock mis à jour.');
        } catch (\Exception $e) {
            Log::error('FicheConsommable Error: ' . $e->getMessage());
            return back()->with('error', 'Erreur de traitement.');
        }
    }


    /**
     * Remove the specified patient from storage
     */
    public function destroy(Patient $patient)
    {
        try {
            DB::transaction(function () use ($patient) {
                $patient->delete();
            });



            return redirect()->route('patients.index')
                ->with('success', "Le dossier du patient a bien été supprimé");

        } catch (\Exception $e) {
            Log::error('Patient Delete Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression');
        }
    }

    /**
     * Helper: Build mode paiement info
     */
    private function buildModePaiementInfo(Request $request)
    {
        if ($request->input('mode_paiement') === 'chèque') {
            return collect([
                $request->input('num_cheque'),
                $request->input('emetteur_cheque'),
                $request->input('banque_cheque')
            ])->filter()->implode(' // ');
        }

        if ($request->input('mode_paiement') === 'bon de prise en charge') {
            return $request->input('emetteur_bpc');
        }

        return '';
    }
}




