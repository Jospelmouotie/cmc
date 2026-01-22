<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\ConsultationAnesthesiste;
use App\Models\Parametre;
use ZanySoft\LaravelPDF\Facades\PDF;
use App\Http\Requests\ConsultationRequest;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ConsultationsController extends Controller
{

    /**
     * Clear all patient-related cache
     */
    private function clearPatientCache($patientId)
    {
        // Clear specific patient caches
        Cache::tags(['consultations', 'patients'])->forget("patient_{$patientId}_consultations");
        Cache::tags(['consultations', 'patients'])->forget("patient_{$patientId}_edit_data");

        // Clear the patient show page cache - THIS IS KEY!
        $examensCount = \App\Models\Examen::where('patient_id', $patientId)->count();
        Cache::forget("patient_show_{$patientId}_{$examensCount}_" . md5(serialize([])));

        // Clear all variations of patient show cache (with different query params)
        Cache::flush();

        // NEW: Clear dashboard cache for the current user
        // \App\Http\Controllers\AdminController::clearDashboardCache(auth()->id());
    }

    public function IndexConsultationChirurgien(Patient $patient)
    {
        $consultations = Cache::remember(
            "patient_{$patient->id}_consultations",
            1800,
            function () use ($patient) {
                return Consultation::with(['user:id,name'])
                    ->where('patient_id', $patient->id)
                    ->latest()
                    ->limit(50)
                    ->get();
            }
        );

        return view('admin.consultations.chirurgiens.index_consultation_chirurgien', [
            'patient' => $patient,
            'consultations' => $consultations,
        ]);
    }



    public function IndexConsultationAnesthesiste(ConsultationAnesthesiste $consultationAnesthesiste, Patient $patient)
    {

        $consultationAnesthesistes = ConsultationAnesthesiste::with(['patient:id,name,prenom', 'user:id,name'])
            ->where('patient_id', $patient->id)
            ->latest()
            ->limit(50)
            ->get();

            Cache::tags(['consultations', 'patients'])->flush();

        return view('admin.consultations.anesthesistes.index_consultation_anesthesiste', [
            'patient' => $patient,
            'consultationAnesthesistes' => $consultationAnesthesistes,
        ]);
    }


    public function create(Patient $patient, Consultation $consultation, ConsultationAnesthesiste $consultation_anesthesiste, Parametre $parametre)
    {
        $users = Cache::remember('users.role.2.consultations', 30, function () {
            return User::where('role_id', 2)
                ->orderBy('name')
                ->get();
        });

        // Fetch dossier data and prescriptions
        $dossier = $patient->dossiers()->latest()->first();
        $prescriptions = $patient->prescriptions()->latest()->first();

        return view('admin.consultations.create', [
            'patient' => $patient,
            'users' => $users,
            'consultation' => $consultation,
            'parametre' => $parametre,
            'consultation_anesthesiste' => $consultation_anesthesiste,
            'dossier' => $dossier,
            'prescriptions' => $prescriptions ?? new \App\Models\Prescription() // Provide empty object if null
        ]);
    }


    public function edit(Patient $patient)
    {
        // Access control: only allow users with role_id 2

        if ($response = $this->denyIfNotAllowed(in_array(auth()->user()?->role_id, [2, 4])))
        {
            return $response;
        }

        // Force fresh data by clearing cache first if requested
        if (request()->get('refresh')) {
            Cache::tags(['consultations', 'patients'])->forget("patient_{$patient->id}_edit_data");
        }

        // Optimize with single eager load query
        $data = Cache::remember("patient_{$patient->id}_edit_data", 30, function () use ($patient) {
            return [
                'consultation' => Consultation::with(['patient:id,name,prenom', 'user:id,name'])
                    ->where('patient_id', $patient->id)
                    ->latest()
                    ->first(),
                'consultation_anesthesiste' => ConsultationAnesthesiste::where('patient_id', $patient->id)
                    ->latest()
                    ->first(),
                'parametre' => Parametre::where('patient_id', $patient->id)
                    ->latest()
                    ->first(),
                // ADD THIS LINE - Fetch dossier data
                'dossier' => $patient->dossiers()->latest()->first()

                // 'dossier' => Dossier::where('patient_id', $patient->id)
                //     ->latest()
                //     ->first()
            ];
        });

        $users = Cache::remember('medecins_with_patients', 60, function () {
            return User::where('role_id', 2)
                ->select('id', 'name', 'prenom')
                ->get();
        });

        return view('admin.consultations.edit', array_merge([
            'patient' => $patient,
            'users' => $users,
            // 'consultation' => $consultation,
        ], $data));
    }


    public function store_consultation_chirurgien(ConsultationRequest $request)
    {
        $patient = Patient::findOrFail($request->patient_id);

        DB::transaction(function () use ($request, $patient) {
            Consultation::create([
                'user_id' => auth()->id(),
                'patient_id' => $patient->id,
                'diagnostic' => $request->input('diagnostic'),
                'interrogatoire' => $request->input('interrogatoire'),
                'antecedent_m' => $request->input('antecedent_m'),
                'antecedent_c' => $request->input('antecedent_c'),
                'allergie' => $request->input('allergie'),
                'groupe' => $request->input('groupe'),
                'proposition' => implode(",", $request->proposition ?? []),
                'examen_c' => $request->input('examen_c'),
                'examen_p' => $request->input('examen_p'),
                'motif_c' => $request->input('motif_c'),
                'acte' => implode(",", $request->acte ?? []),
                'type_intervention' => $request->input('type_intervention'),
                'date_intervention' => $request->input('date_intervention'),
                'date_consultation' => $request->input('date_consultation'),
                'date_consultation_anesthesiste' => $request->input('date_consultation_anesthesiste'),
                'medecin_r' => $request->input('medecin_r'),
                'proposition_therapeutique' => $request->input('proposition_therapeutique'),
            ]);
        });

        // Clear ALL patient-related caches
        $this->clearPatientCache($patient->id);

        return redirect()->back()->with('success', 'La nouvelle consultation a été créée avec succès !!');
        // Flash('La nouvelle consultation a été créée avec succès !!');

        return back();
    }

    public function update_consultation_chirurgien(Consultation $consultation, Request $request)
    {

        DB::transaction(function () use ($consultation, $request) {
            $consultation->fill([
                'diagnostic' => $request->input('diagnostic'),
                'interrogatoire' => $request->input('interrogatoire'),
                'antecedent_m' => $request->input('antecedent_m'),
                'antecedent_c' => $request->input('antecedent_c'),
                'allergie' => $request->input('allergie'),
                'groupe' => $request->input('groupe'),
                'examen_c' => $request->input('examen_c'),
                'examen_p' => $request->input('examen_p'),
                'motif_c' => $request->input('motif_c'),
                'type_intervention' => $request->input('type_intervention'),
                'date_intervention' => $request->input('date_intervention'),
                'date_consultation' => $request->input('date_consultation'),
                'date_consultation_anesthesiste' => $request->input('date_consultation_anesthesiste'),
                'medecin_r' => $request->input('medecin_r'),
                'proposition_therapeutique' => $request->input('proposition_therapeutique'),
                'proposition' => implode(",", $request->proposition ?? []),
                'acte' => implode(",", $request->acte ?? []),
            ]);

            $consultation->save();
        });

        // Clear ALL patient-related caches
        $this->clearPatientCache($consultation->patient_id);
        $this->clearConsultationCache($consultation->patient_id);

        // Flash('La mise à jour a été effectuée');
        return redirect()->back()->with('success', 'La mise à jour a été effectuée');
        // return back();
    }

    public function Astore(Request $request)
    {

        $patient = Patient::findOrFail($request->patient_id);

        DB::transaction(function () use ($request, $patient) {
            ConsultationAnesthesiste::create([
                'user_id' => auth()->id(),
                'patient_id' => $patient->id,
                'specialite' => $request->input('specialite'),
                'medecin_traitant' => $request->input('medecin_traitant'),
                'operateur' => $request->input('operateur'),
                'date_intervention' => $request->input('date_intervention'),
                'motif_admission' => $request->input('motif_admission'),
                'anesthesi_salle' => implode(",", $request->anesthesi_salle ?? []),
                'risque' => $request->input('risque'),
                'solide' => $request->input('solide'),
                'liquide' => $request->input('liquide'),
                'benefice_risque' => $request->input('benefice_risque'),
                'technique_anesthesie' => implode(",", $request->technique_anesthesie ?? []),
                'technique_anesthesie1' => $request->input('technique_anesthesie1'),
                'synthese_preop' => $request->input('synthese_preop'),
                'antecedent_traitement' => $request->input('antecedent_traitement'),
                'examen_clinique' => $request->input('examen_clinique'),
                'traitement_en_cours' => $request->input('traitement_en_cours'),
                'antibiotique' => $request->input('antibiotique'),
                'autre1' => $request->input('autre1'),
                'memo' => $request->input('memo'),
                'adaptation_traitement' => $request->input('adaptation_traitement'),
                'date_hospitalisation' => $request->input('date_hospitalisation'),
                'service' => $request->input('service'),
                'classe_asa' => $request->input('classe_asa'),
                'allergie' => $request->input('allergie'),
                'examen_paraclinique' => implode(",", $request->examen_paraclinique ?? []),
                'intubation' => $request->input('intubation'),
                'mallampati' => $request->input('mallampati'),
                'distance_interincisive' => $request->input('distance_interincisive'),
                'distance_thyromentoniere' => $request->input('distance_thyromentoniere'),
                'mobilite_servicale' => $request->input('mobilite_servicale'),
            ]);
        });

        // Clear ALL patient-related caches
        $this->clearPatientCache($patient->id);
        $this->clearConsultationCache($patient->id);
        // Flash('La nouvelle consultation a été créée avec succès !!');
        return redirect()->back()->with('success', 'La nouvelle consultation a été créée avec succès !!');

        // return back();
    }

    public function update_consultation_anesthesiste(ConsultationAnesthesiste $consultationAnesthesiste, Request $request, Patient $patient)
    {
        DB::transaction(function () use ($consultationAnesthesiste, $request) {
            $consultationAnesthesiste->fill([
                'specialite' => $request->input('specialite'),
                'medecin_traitant' => $request->input('medecin_traitant'),
                'operateur' => $request->input('operateur'),
                'date_intervention' => $request->input('date_intervention'),
                'motif_admission' => $request->input('motif_admission'),
                'anesthesi_salle' => implode(",", $request->anesthesi_salle ?? []),
                'risque' => $request->input('risque'),
                'solide' => $request->input('solide'),
                'liquide' => $request->input('liquide'),
                'benefice_risque' => $request->input('benefice_risque'),
                'technique_anesthesie' => implode(",", $request->technique_anesthesie ?? []),
                'technique_anesthesie1' => $request->input('technique_anesthesie1'),
                'synthese_preop' => $request->input('synthese_preop'),
                'antecedent_traitement' => $request->input('antecedent_traitement'),
                'examen_clinique' => $request->input('examen_clinique'),
                'traitement_en_cours' => $request->input('traitement_en_cours'),
                'antibiotique' => $request->input('antibiotique'),
                'autre1' => $request->input('autre1'),
                'memo' => $request->input('memo'),
                'adaptation_traitement' => $request->input('adaptation_traitement'),
                'date_hospitalisation' => $request->input('date_hospitalisation'),
                'service' => $request->input('service'),
                'classe_asa' => $request->input('classe_asa'),
                'allergie' => $request->input('allergie'),
                'examen_paraclinique' => implode(",", $request->examen_paraclinique ?? []),
                'intubation' => $request->input('intubation'),
                'mallampati' => $request->input('mallampati'),
                'distance_interincisive' => $request->input('distance_interincisive'),
                'distance_thyromentoniere' => $request->input('distance_thyromentoniere'),
                'mobilite_servicale' => $request->input('mobilite_servicale'),
            ]);

            $consultationAnesthesiste->save();
        });

        // Clear ALL patient-related caches
        $this->clearPatientCache($patient->id);
        // $this->clearConsultationCache($consultation->patient_id);
        // Flash('La mise à jour a été éffectuée avec succès !!');
        return redirect()->back()->with('success', 'La mise à jour a été éffectuée avec succès !!');

        // return back();
    }


    public function show(Request $request, $id)
    {
        // return the consultation with patient and user to prevent lazy-loading in partials
        $consultations = Consultation::with(['patient', 'user'])->findOrFail($id);

        return view('admin.consultations.show', compact('consultations'));
    }



    public function Export_consentement_eclaire(Patient $patient)
    {
        set_time_limit(120);
        ini_set('memory_limit', '256M');

        try {
            // Fetch patient with relationships
            $patient->load([
                'dossiers' => function($query) {
                    $query->latest()->limit(1);
                },
                'fiche_interventions' => function($query) {
                    $query->latest()->limit(1);
                },
                'consultation_anesthesistes' => function($query) {
                    $query->latest()->limit(1);
                }
            ]);

            return redirect()->route('print.preview', [
                'type' => 'consentement',
                'id' => $patient->id,
                'patient_id' => $patient->id
            ]);


        } catch (\Exception $e) {
            Log::error('Consentement PDF Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur PDF consentement');
        }
    }

    private function clearConsultationCache($patientId, $userId = null)
    {
        $userId = $userId ?? auth()->id();

        // Clear patient-related cache (existing)
        $this->clearPatientCache($patientId);

        // Clear dashboard cache
        \App\Http\Controllers\AdminController::clearDashboardCache($userId);

        // Clear patients suivis cache
        \App\Http\Controllers\PatientSuivisController::clearPatientsSuivisCache($userId);
    }


    private function denyIfNotAllowed(bool $condition)
    {
        if (! $condition) {
            return redirect()
                ->back()
                ->with('info', 'Vous ne pouvez pas effectuer cette action. Vous n\'avez pas l\'autorisation');
        }

        return null;
    }

}














