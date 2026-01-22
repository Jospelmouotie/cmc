<?php

namespace App\Http\Controllers;

use App\Models\FicheIntervention;
use App\Http\Requests\ParametreRequest;

use App\Models\Parametre;
use App\Models\Patient;
use App\Models\PrescriptionMedicale;
use App\Models\SurveillanceRapprocheParametre;
use App\Models\SurveillanceScore;
use Carbon\Carbon;
use Laracasts\Flash\Flash;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;


class ParametresController extends Controller
{

    public function SurveillanceRapprocheParametre(Patient $patient)
    {
        $cacheKey = "patient_{$patient->id}_surveillance_params";
        $data = Cache::remember($cacheKey, 300, function () use ($patient) {
            return [
                'paramPre' => SurveillanceRapprocheParametre::with('patient:id,name,prenom')
                    ->where('patient_id', $patient->id)
                    ->where('periode', 'preoperatoire')
                    ->latest()
                    ->first(),
                'paramPost' => SurveillanceRapprocheParametre::with('patient:id,name,prenom')
                    ->where('patient_id', $patient->id)
                    ->where('periode', 'postoperatoire')
                    ->latest()
                    ->first(),
                'age_patient' => Parametre::where('patient_id', $patient->id)
                    ->latest()
                    ->value('age'),
                'intervention' => FicheIntervention::where('patient_id', $patient->id)
                    ->value('type_intervention')
            ];
        });
        return view('admin.consultations.infirmiers.surveillance_rapproche_param',
         array_merge(['patient' => $patient],$data)
        );
    }

    public function IndexSurveillanceRapprocheParametre(Patient $patient)
    {
        $cacheKey = "patient_{$patient->id}_surveillance_params_list";
        $data = Cache::remember($cacheKey, 300, function () use ($patient) {
            return [
                'paramPosts' => SurveillanceRapprocheParametre::with('patient:id,name,prenom')
                    ->where('patient_id', $patient->id)
                    ->where('periode', 'postoperatoire')
                    ->orderBy('created_at', 'desc')
                    ->paginate(15),
                'paramPres' => SurveillanceRapprocheParametre::with('patient:id,name,prenom')
                    ->where('patient_id', $patient->id)
                    ->where('periode', 'preoperatoire')
                    ->orderBy('created_at', 'desc')
                    ->paginate(15)
            ];
        });

        return view('admin.consultations.infirmiers.index_surveillance_rapproche_param', 
            array_merge(['patient' => $patient],$data)
        );
    }

    public function IndexParametrePatient(Patient $patient)
    {
        $cacheKey = 'patient_{$patient->id}_parametres_page_' . request('page', 1);
        $parametres = Cache::remember($cacheKey, 300, function () use ($patient) {
            return Parametre::with('patient:id,name,prenom')
                ->where('patient_id', $patient->id)
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        });
        return view('admin.consultations.infirmiers.index_fiche_parametre', 
        compact('patient', 'parametres')
        );
    }

    public function IndexSurveillanceScore(Patient $patient)
    {
        $cacheKey = 'patient_{$patient->id}_score_page_' . request('page', 1);
        $surveillance_scores = Cache::remember($cacheKey, 300, function () use ($patient) {
            return SurveillanceScore::with('patient:id,name,prenom')
                ->where('patient_id', $patient->id)
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        });
        
        return view('admin.consultations.infirmiers.index_scrore_aptitude', 
        compact('patient', 'surveillance_scores')
        );
    }


    public function fiche_parametre_store(ParametreRequest $request)
    {
    
        $patient = Patient::select('id')->findOrFail($request->patient_id);

        // Auto-fill date_naissance from dossier if not provided
        if (!$request->filled('date_naissance')) {
            $dossier = Dossier::where('patient_id', $patient->id)->latest()->first();
            if ($dossier && $dossier->date_naissance) {
                $request->merge(['date_naissance' => $dossier->date_naissance]);
            }
        }

        $request->validate([
            'taille' => ['required', 'regex:/^[0-2]\.\d{0,2}$|^[0-2]$/'],
            'poids' => 'required',
            'date_naissance' => 'required',
        ]);
        
        Parametre::create([
            'user_id' => auth()->id(),
            'patient_id' => $patient->id,
            'fr' => request('fr'),
            'fc' => request('fc'),
            'bras_gauche' => request('bras_gauche'),
            'bras_droit' => request('bras_droit'),
            'taille' => request('taille'),
            'inc_bmi' => number_format(request('poids')/((request('taille'))*(request('taille'))), 2),
            'date_naissance' => request('date_naissance'),
            'age' => Carbon::parse(request('date_naissance'))->age,
            'glycemie' => request('glycemie'),
            'spo2' => request('spo2'),
            'poids' => request('poids'),
            'temperature' => request('temperature'),
        ]);
        
        Cache::forget("patient_{$patient->id}_parametres_page_1");
        Cache::forget("patient_{$patient->id}_surveillance_params");

        // Flash('Les nouveaux paramètres ont bien été ajouté avec succès !!');
        return redirect()->back()->with('success', 'Les nouveaux paramètres ont bien été ajouté avec succès !!');

        // return back();
    }

    public function fiche_parametre_update(ParametreRequest $request, Parametre $parametre)
    {

        $parametre->update($request->all());

        // Flash('Les paramètres ont bien été modifiés');
        return redirect()->back()
        ->with('success', 'Les nouveaux paramètres ont bien été ajouté avec succès !!');


        // return back();
    }

    public function SurveillanceRapprocheStore()
    {
        $patientId = request('patient_id');
        SurveillanceRapprocheParametre::create([

            'patient_id' => $patientId,
            'user_id' => auth()->id(),
            'date' => request('date'),
            'heure' => request('heure'),
            'ta' => request('ta'),
            'fr' => request('fr'),
            'spo2' => request('spo2'),
            'temperature' => request('temperature'),
            'diurese' => request('diurese'),
            'pouls' => request('pouls'),
            'conscience' => request('conscience'),
            'douleur' => request('douleur'),
            'observation_plainte' => request('observation_plainte'),
            'periode' => request('periode'),
        ]);

        Cache::forget("patient_{$patientId}_surveillance_params");
        Cache::forget("patient_{$patientId}_surveillance_params_list_page");

        Cache::tags(['patients'])->flush();
        // Flash::info('Les paramètres ont été enregistrés');

        return redirect()->back()->with('info', 'Votre enregistrement a bien été pris en compte');

    }

    public function SurveillanceScoreStore()
    {
        $patientId = request('patient_id');
        SurveillanceScore::create([
            
            'user_id' => auth()->id(),
            'patient_id' => $patientId,
            'horaire' => request('horaire'),
            'ta' => request('ta'),
            'fc' => request('fc'),
            'spo2' => request('spo2'),
            'fr' => request('fr'),
            'douleur' => request('douleur'),
            'temperature' => request('temperature'),
            'glycemie' => request('glycemie'),
            'sedation' => request('sedation'),
            'nausee' => request('nausee'),
            'vomissement' => request('vomissement'),
            'saignement' => request('saignement'),
            'pansement' => request('pansement'),
            'conscience' => request('conscience'),
            'drains' => request('drains'),
            'miction' => request('miction'),
            'lever' => request('lever'),
            'score' => request('score'),
        ]);

        // Flash::info('Votre enregistrement a bien été pris en compte');
        return redirect()
        ->back()
        ->with('info', 'Votre enregistrement a bien été pris en compte');


        // return back();
    }
}










