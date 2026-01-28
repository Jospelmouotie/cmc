<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\ConsultationAnesthesiste;
use App\Models\Dossier;
use App\Models\FactureConsultation;
use App\Models\FicheConsommable;
use App\Models\FicheIntervention;
use App\Models\Lettre;
use App\Models\Patient;
use App\Models\Ordonance;
use App\Models\Produit;
use App\Models\SoinsInfirmier;
use App\Models\SurveillancePostAnesthesique;
use App\Models\HistoriqueFacture;
use App\Models\User;
use App\Models\VisitePreanesthesique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
use ZanySoft\LaravelPDF\Facades\PDF;
use Illuminate\Support\Facades\Log;
use App\Services\PdfService;

class PatientsController extends Controller
{
    /**
     * Display a listing of patients
     */
    public function index(Request $request)
    {
        $this->authorize('update', Patient::class);
        
        $name = $request->input('name');
        $perPage = (int) $request->input('per_page', 50);
        $page = (int) $request->input('page', 1);

        // Driver 'file' : Clé de cache plate (pas de tags)
        $cacheKey = sprintf('patients.index.%s.%s.%s', auth()->id(), $name ?: 'all', $page);

        $patients = Cache::remember($cacheKey, 90, function () use ($name, $perPage) {
            $query = Patient::select([
                'id', 'numero_dossier', 'name', 'prenom', 'montant', 
                'reste', 'assurance', 'prise_en_charge', 'date_insertion', 'created_at'
            ]);

            if ($name) {
                $query->where(function ($q) use ($name) {
                    $q->where('name', 'like', "%{$name}%")
                      ->orWhere('prenom', 'like', "%{$name}%")
                      ->orWhere('numero_dossier', 'like', "%{$name}%");
                });
            }

            return $query->latest()->paginate($perPage);
        });

        if ($patients instanceof \Illuminate\Contracts\Pagination\Paginator && $name) {
            $patients->appends(['name' => $name]);
        }

        return view('admin.patients.index', compact('patients', 'name', 'perPage'));
    }

    /**
     * Show the form for creating a new patient
     */
    public function create(User $user)
    {
        $this->authorize('update', Patient::class);
        
        // Utilisation d'une clé simple pour le driver file
        $users = Cache::remember('users.role.2.list', 30, function () {
            return User::where('role_id', 2)
                ->select('id', 'name', 'prenom')
                ->orderBy('name')
                ->get();
        });
        
        return view('admin.patients.create', compact('users'));
    }

    /**
     * Store a newly created patient in storage
     */
    public function store(Request $request)
    {
        $this->authorize('update', Patient::class);

        $request->validate([
            'name' => 'required|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'mode_paiement' => 'required|string',
            'assurance' => 'nullable|string|max:255',
            'motif' => 'required|string',
            'details_motif' => 'required|string',
            'montant' => 'required|numeric|min:0',
            'avance' => 'required|numeric|min:0',
            'numero_assurance' => 'required_with:assurance|nullable|string',
            'prise_en_charge' => 'required_with:assurance|numeric|between:0,100',
            'num_cheque' => 'required_if:mode_paiement,chèque',
            'medecin_r' => 'required|string',
        ]);

        $modePaiementInfo = $this->buildModePaiementInfo($request);

        try {
            DB::transaction(function () use ($request, $modePaiementInfo) {
                $montant = $request->input('montant');
                $priseEnCharge = $request->input('prise_en_charge', 0);
                $avance = $request->input('avance');

                return Patient::create([
                    'numero_dossier' => mt_rand(1000000, 9999999) - 1,
                    'name' => $request->input('name'),
                    'prenom' => $request->input('prenom'),
                    'montant' => $montant,
                    'assurance' => $request->input('assurance'),
                    'avance' => $avance,
                    'motif' => $request->input('motif'),
                    'mode_paiement' => $request->input('mode_paiement'),
                    'mode_paiement_info_sup' => $modePaiementInfo,
                    'details_motif' => $request->input('details_motif'),
                    'numero_assurance' => $request->input('numero_assurance'),
                    'prise_en_charge' => $priseEnCharge,
                    'assurec' => FactureConsultation::calculAssurec($montant, $priseEnCharge),
                    'assurancec' => FactureConsultation::calculAssuranceC($montant, $priseEnCharge),
                    'reste' => FactureConsultation::calculReste(
                        FactureConsultation::calculAssurec($montant, $priseEnCharge), $avance
                    ),
                    'demarcheur' => $request->input('demarcheur'),
                    'date_insertion' => now()->toDateString(),
                    'medecin_r' => $request->input('medecin_r'),
                    'user_id' => Auth::id(),
                ]);
            });

            // Driver file : On vide tout ou on supprime manuellement les clés connues
            Cache::flush(); 

            return redirect()->route('patients.index')->with('success', 'Le patient a été ajouté avec succès !');

        } catch (\Exception $e) {
            Log::error('Patient Store Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Erreur lors de l\'ajout du patient');
        }
    }

    /**
     * Display the specified patient
     */
    public function show(Patient $patient, Consultation $consultation)
    {
        $this->authorize('update', Patient::class);
        
        $latestConsultation = $patient->consultations()->latest()->value('updated_at');
        $latestParametre = $patient->parametres()->latest()->value('updated_at');
        $examensCount = $patient->examens()->count();

        // Clé de cache complexe pour simuler le cache busting sans tags
        $cacheKey = "patient_show_{$patient->id}_" . strtotime($latestConsultation ?: 'now') . "_" . $examensCount;

        $data = Cache::remember($cacheKey, 30, function () use ($patient) {
            $examens_scannes = $patient->examens()
                ->select(['id', 'patient_id', 'nom', 'description', 'image', 'created_at'])
                ->latest()->paginate(4);
            
            $patient->load([
                'consultations' => function ($query) { $query->with(['user:id,name'])->latest()->limit(5); },
                'consultation_anesthesistes' => function ($query) { $query->with(['user:id,name'])->latest()->limit(5); },
                'dossiers' => function ($query) { $query->latest()->limit(1); }
            ]);
            
            return [
                'examens_scannes' => $examens_scannes,
                'consultations' => $patient->consultations->first(),
                'consultation_anesthesistes' => $patient->consultation_anesthesistes->first(),
                'dossiers' => $patient->dossiers->first(),
                'parametres' => $patient->parametres()->latest()->first(),
                'ordonances' => $patient->ordonances()->with(['user:id,name'])->latest()->paginate(5),
                'prescriptions' => $patient->prescriptions()->with(['user:id,name'])->latest()->paginate(5),
                'compte_rendu_bloc_operatoires' => $patient->compte_rendu_bloc_operatoires()->latest()->first()
            ];
        });

        $medecin = Cache::remember('medecins_list_full', 3600, function () {
            return User::where('role_id', 2)->select('id', 'name', 'prenom')->orderBy('name')->get();
        });

        return view('admin.patients.show', array_merge([
            'patient' => $patient,
            'medecin' => $medecin,
            'consultation' => $consultation,
        ], $data));
    }

    /**
     * Update the specified patient in storage
     */
    public function update(Request $request, $id)
    {
        $this->authorize('update', Patient::class);
        
        $request->validate([
            'details_motif' => 'required|string',
            'prise_en_charge' => 'nullable|numeric|between:0,100',
        ]);

        try {
            $patient = Patient::findOrFail($id);

            DB::transaction(function () use ($patient, $request) {
                $patient->update($request->all() + ['user_id' => Auth::id()]);
            });

            Cache::flush(); // Nécessaire pour mettre à jour l'index et le show

            return redirect()->route('patients.show', $patient->id)->with('success', 'Mise à jour réussie !');

        } catch (\Exception $e) {
            Log::error('Patient Update Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour');
        }
    }

    /**
     * Update patient motif and montant
     */
    public function motifMontantUpdate(Request $request, $id)
    {
        $this->authorize('update', Patient::class);
        $request->validate(['motif' => 'required', 'montant' => 'required', 'avance' => 'required']);

        try {
            $patient = Patient::findOrFail($id);
            $modePaiementInfo = $this->buildModePaiementInfo($request);

            DB::transaction(function () use ($patient, $request, $modePaiementInfo) {
                $montant = $request->input('montant');
                $priseEnCharge = $request->input('prise_en_charge');
                $avance = $request->input('avance');
                $assurec = FactureConsultation::calculAssurec($montant, $priseEnCharge);

                $patient->update([
                    'name' => $request->input('name'),
                    'prenom' => $request->input('prenom'),
                    'medecin_r' => $request->input('medecin_r'),
                    'mode_paiement_info_sup' => $modePaiementInfo,
                    'montant' => $montant,
                    'details_motif' => $request->input('details_motif'),
                    'avance' => $avance,
                    'mode_paiement' => $request->input('mode_paiement'),
                    'prise_en_charge' => $priseEnCharge,
                    'assurec' => $assurec,
                    'assurancec' => FactureConsultation::calculAssuranceC($montant, $priseEnCharge),
                    'reste' => FactureConsultation::calculReste($assurec, $avance),
                    'user_id' => Auth::id(),
                ]);
            });

            Cache::flush();

            return redirect()->route('patients.show', $patient->id)->with('success', 'Motif et montant mis à jour !');

        } catch (\Exception $e) {
            Log::error('Motif Update Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour');
        }
    }

    /**
     * Generate consultation invoice for patient
     */
    public function generate_consultation(Request $request, $id)
    {
        try {
            $this->authorize('update', Patient::class);
            $patient = Patient::findOrFail($id);
            $statutFacture = $patient->reste == 0 ? 'Soldée' : 'Non soldée';

            $facture = DB::transaction(function () use ($patient, $statutFacture) {
                $facture = FactureConsultation::create([
                    'numero' => $patient->numero_dossier,
                    'patient_id' => $patient->id,
                    'assurancec' => $patient->assurancec,
                    'assurec' => $patient->assurec,
                    'mode_paiement' => $patient->mode_paiement,
                    'motif' => $patient->motif,
                    'montant' => $patient->montant,
                    'avance' => $patient->avance,
                    'reste' => $patient->reste,
                    'medecin_r' => $patient->medecin_r,
                    'date_insertion' => now()->toDateString(),
                    'user_id' => auth()->id(),
                    'statut' => $statutFacture,
                ]);

                $facture->historiques()->create([
                    'reste' => $facture->reste,
                    'montant' => $facture->montant,
                    'percu' => $facture->avance,
                ]);

                return $facture;
            });

            Cache::flush();

            return redirect()->route('factures.consultation')->with('success', 'Facture générée !');

        } catch (\Exception $e) {
            Log::error('Generate Facture Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur de génération');
        }
    }

    /**
     * Print patient discharge letter
     */
    public function print_sortie(Patient $patient)
    {
        try {
            $consultation = Consultation::where('patient_id', $patient->id)->latest()->first();
            if (!$consultation) {
                return redirect()->back()->with('error', 'Aucune consultation trouvée.');
            }

            return redirect()->route('print.preview', [
                'type' => 'lettre',
                'id' => $patient->id,
                'patient_id' => $patient->id
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur PDF');
        }
    }

    /**
     * Export prescription to PDF
     */
    public function export_ordonance($id)
    {
        return redirect()->route('print.preview', ['type' => 'ordonance', 'id' => $id]);
    }

    /**
     * Search for patients
     */
    public function search(Request $request)
    {
        $this->authorize('update', Patient::class);
        $name = $request->input('name');
        
        $patients = Patient::where('prenom', 'like', "%{$name}%")
            ->orWhere('name', 'like', "%{$name}%")
            ->orWhere('numero_dossier', 'like', "%{$name}%")
            ->latest()->paginate(25);
        
        return view('admin.patients.index', compact('patients', 'name'));
    }

    /**
     * Manage fiche consommable
     */
    public function FicheConsommableCreate(FicheConsommable $consommable, Patient $patient)
    {
        $consommables = $patient->fiche_consommables()->latest()->paginate(20);
        $produits = Produit::select(['id', 'designation', 'qte_stock'])->orderBy('designation')->get();

        return view('admin.patients.fiche_consommable', compact('produits', 'consommable', 'consommables', 'patient'));
    }

    /**
     * Autocomplete for products
     */
    public function Autocomplete(Request $request)
    {
        $results = Produit::where('designation', 'LIKE', "%{$request->input('query')}%")
            ->limit(10)->pluck('designation');
        return response()->json($results);
    }

    /**
     * Store fiche consommable
     */
    public function FicheConsommableStore(Request $request)
    {
        $request->validate([
            'patient_id' => ['required', 'exists:patients,id'],
            'consommable' => ['required'],
            'date' => ['required', 'date'],
        ]); 

        if (((int)$request->input('jour') + (int)$request->input('nuit')) < 1) {
            return back()->with('error', 'Quantité invalide.');
        }

        try {
            FicheConsommable::create($request->all() + ['user_id' => auth()->id()]);
            Cache::flush();
            return back()->with('success', 'Enregistré avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'enregistrement.');
        }
    }

    public function FicheConsommableUpdate(Request $request, FicheConsommable $consommable)
    {
        try {
            $consommable->update($request->all());
            Cache::flush();
            return back()->with('success', 'Modifié avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur de modification.');
        }
    }

    public function FicheConsommableDestroy(FicheConsommable $consommable)
    {
        $consommable->delete();
        Cache::flush();
        return back()->with('success', 'Supprimé.');
    }

    /**
     * Store soins infirmier
     */
    public function SoinsInfirmierStore(Request $request)
    {
        try {
            SoinsInfirmier::create($request->all() + ['user_id' => auth()->id()]);
            Cache::flush();
            return redirect()->back()->with('info', 'Enregistrement réussi');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur');
        }
    }

    /**
     * Display lettres index
     */
    public function index_sortie()
    {
        $lettres = Lettre::all();
        return view('admin.lettres.index', compact('lettres'));
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
            Cache::flush();
            return redirect()->route('patients.index')->with('success', "Supprimé");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur');
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
        return ($request->input('mode_paiement') === 'bon de prise en charge') ? $request->input('emetteur_bpc') : '';
    }
}