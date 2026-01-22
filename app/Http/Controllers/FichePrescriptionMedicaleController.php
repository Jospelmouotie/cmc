<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\User;
// use MercurySeries\Flash\Flash;
use Laracasts\Flash\Flash;
use App\Models\PrescriptionMedicale;
use App\Models\FichePrescriptionMedicale;
use App\Models\AdminPrescriptionMedicale;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class FichePrescriptionMedicaleController extends Controller
{
    public function index($patient_id)
    {
        $this->authorize('infirmier_chirurgien', Patient::class);

        $cacheKey = "fiche_prescription_medicale_$patient_id";

        $data = Cache::remember($cacheKey, 600, function () use ($patient_id) {
            return [
                'fiche_prescription_medicale' => FichePrescriptionMedicale::with('prescription_medicales')
                    ->firstOrCreate(['patient_id' => $patient_id]),
                'prescription_medicales' => PrescriptionMedicale::select(['id', 'patient_id', 'user_id', 'medicament', 'posologie', 'voie', 'created_at'])
                    ->with('patient:id,name,prenom', 'user:id,name')
                    ->where('patient_id', $patient_id)
                    ->latest()
                    ->paginate(20)
            ];
        });

        $infirmieres = Cache::remember('infirmieres_role_4', 30, function () {
            return User::where('role_id', 4)
                ->select(['id', 'name'])
                ->get();
        });

        return view('admin.consultations.infirmiers.index_prescription_medicale', array_merge([
            'patient' => Patient::select(['id', 'name', 'prenom'])->findOrFail($patient_id),
            'infirmieres' => $infirmieres,
        ], $data));
    }

    // public function store($patient_id)
    // {
    //     $this->authorize('medecin', Patient::class);
    //     DB::transaction(function () use ($patient_id) {
    //         $fiche_prescription_medicale = FichePrescriptionMedicale::where('patient_id', $patient_id)->first() ?: new FichePrescriptionMedicale();
    //         $fiche_prescription_medicale->fill([
    //             'patient_id' => $patient_id,
    //             'allergie' => request('allergie'),
    //             'regime' => request('regime'),
    //             'consultation_specialise' => request('consultation_specialise'),
    //             'protocole' => request('protocole'),
    //         ]);
    //         $fiche_prescription_medicale->save();
    //         Cache::forget("fiche_prescription_medicale_$patient_id");
    //     });
    //     Flash::info('Bien enregistré');
    //     return back();
    // }



    public function store($patient_id)
    {
        $this->authorize('medecin', Patient::class);

        $validated = request()->validate([
            'allergie' => 'required|string',
            'regime' => 'required|string',
            'consultation_specialise' => 'required|string',
            'protocole' => 'nullable|string',
        ]);

        DB::transaction(function () use ($patient_id, $validated) {
            FichePrescriptionMedicale::updateOrCreate(
                ['patient_id' => $patient_id],
                $validated
            );

            Cache::forget("fiche_prescription_medicale_$patient_id");
        });

        // Flash::success('Informations enregistrées avec succès');
        // return back();
        return redirect()
        ->back()
        ->with('success', 'Informations enregistrées avec succès');

    }



    public function prescriptionMedicaleStore(Request $request, $fiche_id)
    {
        $this->authorize('medecin', Patient::class);
        $request->validate([
            'medicament' => 'required',
            'posologie' => 'required',
            'horaire' => 'required|array',
            'voie' => 'required',
        ]);
        DB::transaction(function () use ($request, $fiche_id) {
            $fiche_prescription_medicale = FichePrescriptionMedicale::findOrFail($fiche_id);
            $prescriptionMedicale = new PrescriptionMedicale([
                'user_id' => auth()->id(),
                'medicament' => $request->input('medicament'),
                'posologie' => $request->input('posologie'),
                'voie' => $request->input('voie'),
                'horaire' => json_encode($request->input('horaire')),
            ]);
            $fiche_prescription_medicale->prescription_medicales()->save($prescriptionMedicale);
            Cache::forget("fiche_prescription_medicale_{$fiche_prescription_medicale->patient_id}");
        });
        // Flash::info('Prescription enregistrée avec succès !');
        // return back();
        return redirect()
        ->back()
        ->with('success', 'Informations enregistrées avec succès');
    }


    public function AdminPMStore(Request $request, $prescription_medicale_id)
    {
        $this->authorize('infirmier', Patient::class);
        $request->validate([
            'matin' => 'required_without_all:apre_midi,soir,nuit',
            'apre_midi' => 'required_without_all:matin,soir,nuit',
            'soir' => 'required_without_all:matin,apre_midi,nuit',
            'nuit' => 'required_without_all:matin,apre_midi,soir',
        ]);
        $prescription_medicale = PrescriptionMedicale::firstOrCreate(['id' => $prescription_medicale_id]);
        $adminPrescriptionMedicale = new AdminPrescriptionMedicale([
            'prescription_medicale_id' => $prescription_medicale_id,
            'user_id' => auth()->id(),
            'matin' => request('matin'),
            'apre_midi' => request('apre_midi'),
            'soir' => request('soir'),
            'nuit' => request('nuit'),
        ]);
        // if(null !== request('date')){
        //     $adminPrescriptionMedicale->created_at = request('date');
        // }

        if(request('date') && !empty(request('date'))){
            $adminPrescriptionMedicale->created_at = request('date') . ' ' . now()->format('H:i:s');
        }

        $prescription_medicale->adminPrescriptionMedicales()->save($adminPrescriptionMedicale);

        $patient_id = $prescription_medicale->patient_id;
        Cache::forget("fiche_prescription_medicale_$patient_id");

        // Flash::info('Administration enregistrée avec succès');
        // return back();

        return redirect()
        ->back()
        ->with('success', 'Administration enregistrée avec succès');

    }


    public function edit($id)
    {
        try {
            $prescription_medicale = PrescriptionMedicale::findOrFail($id);
            $patient_id = request('patient');
            $patient = Patient::findOrFail($patient_id);

            // Vérifier que la prescription appartient bien au patient
            $fiche = FichePrescriptionMedicale::where('id', $prescription_medicale->fiche_prescription_medicale_id)
                                              ->where('patient_id', $patient->id)
                                              ->first();

            if (!$fiche) {
                // Flash('Cette prescription n\'appartient pas à ce patient.');
                return redirect()->back()->with('error', 'Cette prescription n\'appartient pas à ce patient.');
                // return redirect()->back();
            }

            return view('admin.consultations.infirmiers.form.prescription_medicale_edit',
                       compact('prescription_medicale', 'patient'));

        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'édition de la prescription médicale: ' . $e->getMessage());
            // Flash('Erreur lors du chargement de la prescription médicale.');
            return redirect()->back()->with('error', 'Erreur lors du chargement de la prescription médicale.'. $e->getMessage());
            // return redirect()->back();
        }
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'fiche_prescription_medicale_id' => 'required|exists:fiche_prescription_medicales,id',
            'medicament' => 'required|string|max:255',
            'posologie' => 'required|string|max:255',
            'horaire' => 'required|array|min:1',
            'horaire.*' => 'required|string',
            'voie' => 'required|string|max:100',
        ], [
            'horaire.required' => 'Veuillez sélectionner au moins un horaire d\'administration.',
            'horaire.min' => 'Veuillez sélectionner au moins un horaire d\'administration.',
        ]);

        try {

            $patient_id = $request->input('patient_id');

            DB::transaction(function () use ($request, $id,  $patient_id) {
                $prescription_medicale = PrescriptionMedicale::findOrFail($id);
                $patient = Patient::findOrFail($request->input('patient_id'));

                // Vérifier que la prescription appartient au patient
                $fiche = FichePrescriptionMedicale::where('id', $prescription_medicale->fiche_prescription_medicale_id)
                                                  ->where('patient_id', $patient->id)
                                                  ->first();

                if (!$fiche) {
                    throw new \Exception('Prescription non valide pour ce patient.');
                }

                $prescription_medicale->update([
                    'medicament' => $request->input('medicament'),
                    'posologie' => $request->input('posologie'),
                    'horaire' => json_encode($request->input('horaire')),
                    'voie' => $request->input('voie'),
                ]);

                // Invalider le cache
                Cache::forget('prescription_medicale_' . $id);
                Cache::forget('fiche_prescription_medicale_' . $fiche->id);
                Cache::forget("fiche_prescription_medicale_$patient_id"); // ⬅️ AJOUT IMPORTANT
            });

            // Flash('La prescription médicale a été modifiée avec succès !!');
            // return redirect()->back()
            // ->with('success', 'La prescription médicale a été modifiée avec succès !!');
            return redirect()
            ->route('fiche.prescription_medicale.index', $request->input('patient_id'))
            ->with('success', 'La prescription médicale a été modifiée avec succès !!');



        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour de la prescription médicale: ' . $e->getMessage());
            // Flash('Erreur lors de la mise à jour de la prescription médicale.');
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour de la prescription médicale.')
            ->withInput();
        }
    }

}













