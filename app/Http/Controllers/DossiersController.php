<?php


namespace App\Http\Controllers;

use App\Models\Dossier;
use App\Http\Requests\DossierRequest;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DossiersController extends Controller
{

    public function create(Patient $patient)
    {
        $dossier = Cache::remember("dossier_patient_{$patient->id}", 600, function () use ($patient) {
            return Dossier::where('patient_id', $patient->id)->first();
        });
        if ($dossier) {
            return view('admin.dossiers.edit', ['patient'=>$patient, 'dossier'=>$dossier]);
        }
        return view('admin.dossiers.create',['patient'=>$patient]);
    }

    public function store(DossierRequest $request)
    {
        $user = auth()->user();
        $patient = Patient::select('id')->findOrFail($request->input('patient_id'));
        DB::transaction(function () use ($request, $patient) {
            Dossier::create([
                'patient_id' => $patient->id,
                'sexe'=> $request->input('sexe'),
                'date_naissance'=> $request->input('date_naissance'),
                'lieu_naissance'=> $request->input('lieu_naissance'),
                'adresse'=> $request->input('adresse'),
                'profession'=> $request->input('profession'),
                'personne_contact'=> $request->input('personne_contact'),
                'tel_personne_contact'=> $request->input('tel_personne_contact'),
                'personne_confiance'=> $request->input('personne_confiance'),
                'tel_personne_confiance'=> $request->input('tel_personne_confiance'),
                'portable_1'=> $request->input('portable_1'),
                'portable_2'=> $request->input('portable_2'),
                'fax'=> $request->input('fax'),
                'email'=> $request->input('email'),
            ]);
            Cache::forget("dossier_patient_{$patient->id}");
            Cache::flush();
        });
        // Redirection pour le médecin
        if ($user->role_id == 2) {
            return redirect()->route('patients.show', ['patient'=> $patient])->with('info', 'Le dossier du patient a bien été mis à jour !');
        }
        // Redirection pour l'infirmier
        if ($user->role_id == 4) {
            return redirect()->route('consultations.create', ['patient'=> $patient]);
        }

        return redirect()->route('patients.index')->with('info', 'Le dossier du patient a bien été mis à jour !');
    }

    public function update(Dossier $dossier, DossierRequest $request)
    {
        $patient = Patient::select('id')->findOrFail($request->input('patient_id'));
        DB::transaction(function () use ($dossier, $request, $patient) {
            $dossier->patient_id = $patient->id;
            $dossier->sexe = $request->input('sexe');
            $dossier->date_naissance = $request->input('date_naissance');
            $dossier->lieu_naissance = $request->input('lieu_naissance');
            $dossier->adresse = $request->input('adresse');
            $dossier->portable_1 = $request->input('portable_1');
            $dossier->portable_2 = $request->input('portable_2');
            $dossier->profession = $request->input('profession');
            $dossier->personne_contact = $request->input('personne_contact');
            $dossier->tel_personne_contact = $request->input('tel_personne_contact');
            $dossier->update();
            Cache::forget("dossier_patient_{$patient->id}");
            Cache::flush();
        });

        return redirect()->route('patients.show', ['patient'=> $patient])->with('info', 'Le dossier du patient a bien été mis à jour !');
    }

}



