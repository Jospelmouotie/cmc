<?php

namespace App\Http\Controllers;

use App\Models\CompteRenduBlocOperatoire;
use App\Models\FicheIntervention;
use App\Http\Requests\CompteRenduBlocOperatoireRequest;
use App\Models\Patient;
use App\Models\User;
use App\Models\Consultation;
use ZanySoft\LaravelPDF\Facades\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
// INSERT: PdfService import
use App\Services\PdfService;

class CompteRenduBlocOperatoireController extends Controller
{

    public function index(CompteRenduBlocOperatoire $compteRenduBlocOperatoire, Patient $patient)
    {
        $compteRenduBlocOperatoires = Cache::remember("crbo_patient_{$patient->id}", 600, function () use ($patient) {
            return CompteRenduBlocOperatoire::with('patient:id,name,prenom')
                ->where('patient_id', $patient->id)

                ->latest()
                ->get();
        });

        return view('admin.consultations.chirurgiens.index_compte_rendu_operatoire', [
            'patient' => $patient,
            'compteRenduBlocOperatoires' => $compteRenduBlocOperatoires,
        ]);
    }


    public function create(CompteRenduBlocOperatoire $compteRenduBlocOperatoire, Patient $patient)
    {
        $users = Cache::remember('users.role.2.crbo', 1800, function () {
            return User::where('role_id', 2)->select('id', 'name')->orderBy('name')->get();
        });

        $anesthesistes = Cache::remember('users.anesthesistes', 1800, function () {
            return User::whereIn('users.name', ['TENKE', 'SANDJON'])->select('id', 'name')->get();
        });

        $infirmierAnesthesistes = Cache::remember('users.role.4', 1800, function () {
            return User::where('role_id', 4)->select('id', 'name')->orderBy('name')->get();
        });

        return view('admin.consultations.create_compte_rendu_operatoire', [
            'compteRenduBlocOperatoire' => $compteRenduBlocOperatoire,
            'patient' => $patient,
            'users' => $users,
            'anesthesistes' => $anesthesistes,
            'infirmierAnesthesistes' => $infirmierAnesthesistes
        ]);
    }

    public function edit(Patient $patient)
    {
        $compteRenduBlocOperatoire = CompteRenduBlocOperatoire::with('user:id,name')
            ->where('patient_id', $patient->id)
            ->latest()
            ->first();

        $users = Cache::remember('users.role.2.crbo', 1800, function () {
            return User::where('role_id', 2)->select('id', 'name')->get();
        });

        $anesthesistes = Cache::remember('users.anesthesistes', 1800, function () {
            return User::whereIn('users.name', ['TENKE', 'SANDJON'])->select('id', 'name')->get();
        });

        $infirmierAnesthesistes = Cache::remember('users.role.4', 1800, function () {
            return User::where('role_id', 4)->select('id', 'name')->get();
        });

        return view('admin.consultations.edit_compte_rendu_operatoire', [
            'compteRenduBlocOperatoire' => $compteRenduBlocOperatoire,
            'patient' => $patient,
            'users' => $users,
            'anesthesistes' => $anesthesistes,
            'infirmierAnesthesistes' => $infirmierAnesthesistes
        ]);
    }


    public function store(CompteRenduBlocOperatoireRequest $request, Patient $patient)
    {
        $patient = Patient::select('id')->findOrFail($request->input('patient_id'));

        DB::transaction(function () use ($request, $patient) {
            CompteRenduBlocOperatoire::create([
                'patient_id' => $patient->id,
                'anesthesiste' => $request->input('anesthesiste'),
                'aide_op' => $request->input('aide_op'),
                'chirurgien' => $request->input('chirurgien'),
                'infirmier_anesthesiste' => $request->input('infirmier_anesthesiste'),
                'compte_rendu_o' => $request->input('compte_rendu_o'),
                'indication_operatoire' => $request->input('indication_operatoire'),
                'resultat_histo' => $request->input('resultat_histo'),
                'suite_operatoire' => $request->input('suite_operatoire'),
                'traitement_propose' => $request->input('traitement_propose'),
                'soins' => $request->input('soins'),
                'conclusion' => $request->input('conclusion'),
                'dure_intervention' => $request->input('dure_intervention'),
                'date_intervention' => $request->input('date_intervention'),
                'titre_intervention' => $request->input('titre_intervention'),
                'type_intervention' => $request->input('type_intervention'),
                'proposition_suivi' => $request->input('proposition_suivi'),
                'date_e' => $request->input('date_e'),
                'date_s' => $request->input('date_s'),
                'type_e' => $request->input('type_e'),
                'type_s' => $request->input('type_s'),
            ]);

            Cache::forget("crbo_patient_{$patient->id}");
            // Also flush patient caches so patient-show reflects edits immediately
            Cache::flush();
        });

        // Flash('Le compte rendu du bloc opératoire a été ajouté avec succès');
         return redirect()->back()->with('success', 'Le compte rendu du bloc opératoire a été ajouté avec succès');
        // return back();
    }

    public function update(CompteRenduBlocOperatoireRequest $request, $id)
    {
        try {
            // Find the record explicitly
            $compteRenduBlocOperatoire = CompteRenduBlocOperatoire::findOrFail($id);

            DB::transaction(function () use ($request, $compteRenduBlocOperatoire) {
                $compteRenduBlocOperatoire->update([
                    'anesthesiste' => $request->input('anesthesiste'),
                    'aide_op' => $request->input('aide_op'),
                    'chirurgien' => $request->input('chirurgien'),
                    'infirmier_anesthesiste' => $request->input('infirmier_anesthesiste'),
                    'compte_rendu_o' => $request->input('compte_rendu_o'),
                    'indication_operatoire' => $request->input('indication_operatoire'),
                    'resultat_histo' => $request->input('resultat_histo'),
                    'suite_operatoire' => $request->input('suite_operatoire'),
                    'traitement_propose' => $request->input('traitement_propose'),
                    'soins' => $request->input('soins'),
                    'conclusion' => $request->input('conclusion'),
                    'dure_intervention' => $request->input('dure_intervention'),
                    'date_intervention' => $request->input('date_intervention'),
                    'titre_intervention' => $request->input('titre_intervention'),
                    'type_intervention' => $request->input('type_intervention'),
                    'proposition_suivi' => $request->input('proposition_suivi'),
                    'date_e' => $request->input('date_e'),
                    'date_s' => $request->input('date_s'),
                    'type_e' => $request->input('type_e'),
                    'type_s' => $request->input('type_s'),
                ]);

                Cache::forget("crbo_patient_{$compteRenduBlocOperatoire->patient_id}");
                // Ensure patient show cache is invalidated
                Cache::flush();
            });
            return redirect()->back()->with('success', 'Le compte rendu du bloc opératoire a été mis à jour avec succès');

            // Flash('Le compte rendu du bloc opératoire a été mis à jour avec succès');

            // return back();

        } catch (\Exception $e) {
            Log::error('CRBO Update Error: ' . $e->getMessage(), [
                'id' => $id,
                'request_data' => $request->all()
            ]);
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage());
            // return back()->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage());
        }
    }

    public function StoreFicheIntervention(Request $request, Patient $patient)
    {
        $patient = Patient::select('id')->findOrFail($request->input('patient_id'));

        DB::transaction(function () use ($request, $patient) {
            FicheIntervention::create([
                'user_id' => auth()->user()->id,
                'patient_id' => $patient->id,
                'nom_patient' => $request->input('nom_patient'),
                'prenom_patient' => $request->input('prenom_patient'),
                'sexe_patient' => $request->input('sexe_patient'),
                'date_naiss_patient' => $request->input('date_naiss_patient'),
                'portable_patient' => $request->input('portable_patient'),
                'type_intervention' => $request->input('type_intervention'),
                'dure_intervention' => $request->input('dure_intervention'),
                'position_patient' => implode(",", $request->input('position_patient', [])),
                'decubitus' => implode(",", $request->input('decubitus', [])),
                'laterale' => implode(",", $request->input('laterale', [])),
                'lombotomie' => implode(",", $request->input('lombotomie', [])),
                'date_intervention' => $request->input('date_intervention'),
                'medecin' => $request->input('medecin'),
                'aide_op' => implode(",", $request->input('aide_op', [])),
                'hospitalisation' => $request->input('hospitalisation'),
                'ambulatoire' => $request->input('ambulatoire'),
                'anesthesie' => implode(",", $request->input('anesthesie', [])),
                'recommendation' => $request->input('recommendation'),
            ]);
        });

        return redirect()->back()->with('success', 'La fiche d\'intervention a bien été enregistrée');
        // Flash('La fiche d\'intervention a bien été enregistrée');
        // return back();
    }


    /**
     * FIXED VERSION - Generates PDF properly
     */
    public function compte_rendu_bloc_pdf($id)
    {
        // Increase limits
        set_time_limit(90);
        ini_set('memory_limit', '512M');

        try {
            // Load patient with minimal data
            $patient = Patient::select(['id', 'numero_dossier', 'name', 'prenom'])
                ->findOrFail($id);

            // Load LATEST compte rendu
            $crbo = CompteRenduBlocOperatoire::where('patient_id', $id)
                ->latest()
                ->first();

            // Load LATEST consultation
            $consultation = Consultation::where('patient_id', $id)
                ->latest()
                ->first();



            // Validation
            if (!$crbo) {
                return redirect()->back()
                    ->with('error', 'Aucun compte rendu trouvé pour ce patient');
            }

            if (!$consultation) {
                return redirect()->back()
                    ->with('error', 'Aucune consultation trouvée pour ce patient');
            }

            // Clear any existing output
            if (ob_get_length()) {
                ob_end_clean();
            }

            // Generate PDF with individual objects (NOT collections)
            // $pdf = PDF::loadView('admin.etats.crbo', [
            //     'patient' => $patient,
            //     'crbo' => $crbo,
            //     'consultation' => $consultation
            // ]);
            return redirect()->route('print.preview', [
                'type' => 'crbo',
                'id' => $id,
                'patient_id' => $id
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('CRBO PDF - Patient not found', [
                'patient_id' => $id,
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Patient introuvable');

        } catch (\Exception $e) {
            Log::error('CRBO PDF Error', [
                'patient_id' => $id,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            // Clean output buffer on error
            if (ob_get_length()) {
                ob_end_clean();
            }

            return redirect()->back()
                ->with('error', 'Erreur lors de la génération du PDF: ' . $e->getMessage());

        } finally {
            // Force garbage collection
            gc_collect_cycles();
        }
    }

    public function Print_ficheIntervention($id)
    {
        set_time_limit(90);
        ini_set('memory_limit', '512M');

        try {
            $fiche_intervention = FicheIntervention::with([
                    'patient:id,numero_dossier',
                    'user:id,name'
                ])
                ->findOrFail($id);

            $numeroDossier = $fiche_intervention->patient?->numero_dossier ?? 'n_dossier';
            $nom = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $fiche_intervention->nom_patient ?? 'patient');
            $filename = "fiche_intervention_{$numeroDossier}_{$nom}.pdf";


            // $orientation = request()->input('orientation', 'portrait');
            // $format = request()->input('format', 'A4');
            // $delivery = request()->input('delivery', 'stream');

            // The redirect already handles this, but verify consistency
            return redirect()->route('print.preview', [
                'type' => 'fiche_intervention',
                'id' => $id
            ]);


        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Fiche Intervention Not Found', [
                'fiche_id' => $id
            ]);

            if (ob_get_length()) {
                ob_end_clean();
            }

            return redirect()->back()
                ->with('error', 'Fiche d\'intervention introuvable.');

        } catch (\Exception $e) {
            Log::error('Fiche Intervention PDF Error', [
                'fiche_id' => $id,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);

            if (ob_get_length()) {
                ob_end_clean();
            }

            return redirect()->back()
                ->with('error', 'Erreur lors de la génération de la fiche d\'intervention.');

        } finally {
            gc_collect_cycles();
        }
    }
}





