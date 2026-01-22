<?php

namespace App\Http\Controllers;

use App\Models\AdaptationTraitement;
use App\Models\Patient;
use App\Models\Premedication;
use App\Models\SurveillancePostAnesthesique;
use App\Models\TraitementHospitalisation;
use App\Models\VisitePreanesthesique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;
use Laracasts\Flash\Flash;

class AnesthesisteController extends Controller
{
    public function Premdication_Traitement(Patient $patient)
    {
        $cacheKey = "patient_{$patient->id}_premedications";

        $data = Cache::remember($cacheKey, 600, function () use ($patient) {
            return [
                'premedications' => $patient->premedications()
                    ->select('id', 'patient_id', 'medicament', 'user_id', 'created_at')
                    ->with('user:id,name')
                    ->latest()
                    ->paginate(20),

                    // In AnesthesisteController.php
                'TraitementHospitalisations' => $patient->traitement_hospitalisations() // ← snake_case
                    ->select('id', 'patient_id', 'medicament_posologie_dosage', 'user_id', 'created_at')
                    ->with('user:id,name')
                    ->latest()
                    ->paginate(20),

                'AdaptationTraitements' => $patient->adaptation_traitements()
                ->select('id', 'patient_id', 'medicament_posologie_dosage', 'user_id', 'created_at')
                ->with('user:id,name')
                ->latest()
                ->paginate(20),

                'medicament' => $patient->premedications()
                    ->latest()
                    ->first(['medicament']),
            ];
        });

        return view('admin.consultations.premdication_tritement', [
            'patient' => $patient,
            ...$data,
        ]);
    }

    public function VisitePreanesthesiqueStore(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'date_visite' => 'required|date',
            'element_nouveaux' => 'nullable|string',
        ]);

        VisitePreanesthesique::create([
            'user_id' => auth()->id(),
            'patient_id' => $validated['patient_id'],
            'date_visite' => $validated['date_visite'],
            'element_nouveaux' => $validated['element_nouveaux'],
        ]);


        Cache::flush();
        // Flash::success('Les nouveaux éléments ont bien été pris en compte !');
        // return back();
        return redirect()
            ->back()
            ->with('success', 'Les nouveaux éléments ont bien été pris en compte !');
    }

    public function PremedicationConsignePreparationStore(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'consigne_ide' => 'nullable|string',
            'preparation' => 'nullable|string',
            'medicament' => 'required|string',
        ]);

        Premedication::create([
            'user_id' => auth()->id(),
            'patient_id' => $validated['patient_id'],
            'consigne_ide' => $validated['consigne_ide'],
            'preparation' => $validated['preparation'],
            'medicament' => $validated['medicament'],
        ]);

        Cache::flush();
        // Flash::success('Les nouveaux éléments ont bien été pris en compte !');
        // return back();
        return redirect()
            ->back()
            ->with('success', 'Les nouveaux éléments ont bien été pris en compte !');
    }

    public function TraitementHospitalisationStore(Request $request, Patient $patient)
    {
        // Validate input first
        $validated = $request->validate([
            'duree' => 'nullable|string',
            'j' => 'nullable|string',
            'j0' => 'nullable|string',
            'j1' => 'nullable|string',
            'j2' => 'nullable|string',
            'm' => 'nullable|string',
            'mi' => 'nullable|string',
            'n' => 'nullable|string',
            's' => 'nullable|string',
            'm1' => 'nullable|string',
            'mi1' => 'nullable|string',
            's1' => 'nullable|string',
            'n1' => 'nullable|string',
            'date' => 'nullable|date',
        ]);

        // Get latest premedication medicament
        $latestPremedication = $patient->premedications()->latest()->first();

        if (! $latestPremedication || empty($latestPremedication->medicament)) {
            // Flash::error('Aucun médicament trouvé. Veuillez d\'abord créer une prémédication.');
            // return back();

            return redirect()
            ->back()
            ->with('error', 'Aucun médicament trouvé. Veuillez d\'abord créer une prémédication.');

        }

        TraitementHospitalisation::create(array_merge($validated, [
            'user_id' => auth()->id(),
            'patient_id' => $patient->id,
            'medicament_posologie_dosage' => $latestPremedication->medicament,
        ]));

        Cache::forget("patient_{$patient->id}_premedications");
        Cache::flush();
        // Flash::success('Le traitement à l\'hospitalisation a bien été enregistré !');
        // return back();
        return redirect()
            ->back()
            ->with('success', 'Le traitement à l\'hospitalisation a bien été enregistré !');
    }

    public function AdaptationTraitementPersoStore(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'medicament_posologie_dosage' => 'required|string',
            'arret' => 'nullable|string',
            'poursuivre' => 'nullable|string',
            'continuer' => 'nullable|string',
            'j' => 'nullable|string',
            'j0' => 'nullable|string',
            'j1' => 'nullable|string',
            'j2' => 'nullable|string',
            'm' => 'nullable|string',
            'mi' => 'nullable|string',
            'n' => 'nullable|string',
            's' => 'nullable|string',
            'm1' => 'nullable|string',
            'mi1' => 'nullable|string',
            's1' => 'nullable|string',
            'n1' => 'nullable|string',
            'date' => 'nullable|date',
        ]);

        AdaptationTraitement::create(array_merge($validated, [
            'user_id' => auth()->id(),
        ]));


        Cache::flush();
        // Flash::success('L\'adaptation de traitement a bien été enregistrée !');
        // return back();
        return redirect()
            ->back()
            ->with('success', 'Le traitement à l\'hospitalisation a bien été enregistré !');
    }

    public function IndexSurveillancePostAnesthesise(Patient $patient)
    {
        $surveillance_post_anesthesiques = $patient->surveillance_post_anesthesiques()
            ->with('user:id,name')
            ->get();

        Cache::forget("patient_{$patient->id}_premedications");
        Cache::flush();

        return view('admin.consultations.index_surveillance_post_anesthesique', compact(
            'patient',
            'surveillance_post_anesthesiques'
        ));
    }

    public function SurveillancePostAnesthesiseStore(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'date_creation' => 'required|date',
            'surveillance' => 'nullable|string',
            'traitement' => 'nullable|string',
            'examen_paraclinique' => 'nullable|string',
            'observation' => 'nullable|string',
            'date_sortie' => 'nullable|date',
            'heur_sortie' => 'nullable|string',
        ]);

        SurveillancePostAnesthesique::create(array_merge($validated, [
            'user_id' => auth()->id(),
        ]));


        Cache::flush();
        // Flash::info('Votre enregistrement a bien été pris en compte.');
        // return back();
        return redirect()
        ->back()
        ->with('info', 'Votre enregistrement a bien été pris en compte');

    }

    public function SurveillancePostAnesthesiseUpdate(Request $request, SurveillancePostAnesthesique $surveillancePostAnesthesique)
    {
        $validated = $request->validate([
            'date_creation' => 'required|date',
            'surveillance' => 'nullable|string',
            'traitement' => 'nullable|string',
            'examen_paraclinique' => 'nullable|string',
            'observation' => 'nullable|string',
            'date_sortie' => 'nullable|date',
            'heur_sortie' => 'nullable|string',
        ]);

        $surveillancePostAnesthesique->update($validated);

        // Flash::success('Les informations ont bien été mises à jour.');
        // return back();
        return redirect()
        ->back()
        ->with('success', 'Les informations ont bien été mises à jour.');

    }
}
