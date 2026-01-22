<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ObservationMedicale;
use App\Models\Patient;
use App\Models\SoinsInfirmier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ChirurgienController extends Controller
{

    public function AbservationMedicaleCreate(Patient $patient)
    {
        $cacheKey = "patient_{$patient->id}_medical_obs";

        $data = Cache::remember($cacheKey, 600, function () use ($patient) {
            return [
                'observation_medicales' => ObservationMedicale::with('patient:id,name,prenom', 'user:id,name')
                    ->where('patient_id', $patient->id)
                    ->paginate(15),
                'soins_infirmiers' => SoinsInfirmier::with('patient:id,name,prenom', 'user:id,name')
                    ->where('patient_id', $patient->id)
                    ->paginate(15)
            ];
        });

        $anesthesistes = Cache::remember('anesthesistes_cache', 30, function () {
            return User::whereIn('name', ['TENKE', 'SANDJON'])
                ->select(['id', 'name'])
                ->get();
        });

        $users = Cache::remember('users_role_2_obs', 30, function () {
            return User::where('role_id', 2)
                ->select(['id', 'name'])
                ->get();
        });

        $patients_externes = Cache::remember('clients_all', 60, function () {
            return Client::orderBy('nom', 'asc')
                ->select(['id', 'nom'])
                ->get();
        });

        return view('admin.consultations.observation_medicale', array_merge([
            'anesthesistes' => $anesthesistes,
            'users' => $users,
            'patient' => $patient,
            'patient_externes' => $patients_externes,
        ], $data));
    }
    public function AbservationMedicaleStore(Request $request)
    {
        $observationMedicale = new ObservationMedicale();
        $observationMedicale->user_id = $request->input('user_id');
        $observationMedicale->patient_id = $request->input('patient_id');
        $observationMedicale->observation = $request->input('observation');
        $observationMedicale->date = $request->input('date');
        $observationMedicale->anesthesiste = $request->input('anesthesiste');
        $observationMedicale->save();
        Cache::forget("observation_medicales_patient_{$observationMedicale->patient_id}");
        Cache::flush();
       
        return back()->with('success', 'Votre enregistrement a bien été pris en compte');
    }

    public function AbservationMedicaleEdit()
    {

    }

    public function AbservationMedicaleUpdate()
    {

    }
}


