<?php

namespace App\Http\Controllers;

use App\Models\Ordonance;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use ZanySoft\LaravelPDF\Facades\PDF;
use Illuminate\Support\Facades\Log;
use App\Services\PdfService;

class OrdonancesController extends Controller
{

    public function store(Request $request)
    {
        try{
            DB::transaction(function () use ($request) {
                $patient = Patient::select('id')->findOrFail($request->input('patient_id'));
                Ordonance::create([
                    'user_id' => auth()->id(),
                    'patient_id' => $patient->id,
                    'description'=> implode(",", $request->input('description', [])),
                    'medicament'=> implode(",", $request->input('medicament', [])),
                    'quantite'=> implode(",", $request->input('quantite', [])),
                ]);
                Cache::forget('ordonances_patient_' . $patient->id);
            });

            // Flash('La nouvelle ordonance a été crée avec succès !!');
            return redirect()->back()->with('success', 'La nouvelle ordonance a été crée avec succès !!');
            // return back();
        } catch (\Exception $e) {
            Log::error('Erreur lors de la creation  de l\odonnance: ' . $e->getMessage());
            // Flash('Erreur lors de la creation de l\'ordonnance.');
            return redirect()->back()->with('error', 'Erreur lors de la creation de l\'ordonnance.')
            ->withInput();
        }    
    }


    public function edit($id, Request $request)
    {
        try {
            $ordonance = Ordonance::findOrFail($id);
            $patient_id = $request->query('patient');
            $patient = Patient::findOrFail($patient_id);
            
        
            if ($ordonance->patient_id != $patient->id) {
                // Flash('Cette ordonnance n\'appartient pas à ce patient.');
                return with('error', 'Cette ordonnance n\'appartient pas à ce patient.');
                
            }
            
            return view('admin.prescriptions.ordonance_edit', compact('ordonance', 'patient'));
            
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'édition de l\'ordonnance: ' . $e->getMessage());
            // Flash('Erreur lors du chargement de l\'ordonnance.');
            return redirect()->back()->with('error', 'Erreur lors du chargement de l\'ordonnance.'. $e->getMessage());
            // return redirect()->back();
        }
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'medicament' => 'required|array|min:1',
            'medicament.*' => 'required|string|max:255',
            'quantite' => 'required|array|min:1',
            'quantite.*' => 'required|string|max:100',
            'description' => 'required|array|min:1',
            'description.*' => 'required|string|max:500',
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                $ordonance = Ordonance::findOrFail($id);
                $patient = Patient::select('id')->findOrFail($request->input('patient_id'));
                
                // Vérifier que l'ordonnance appartient au patient
                if ($ordonance->patient_id != $patient->id) {
                    throw new \Exception('Ordonnance non valide pour ce patient.');
                }
                
                $ordonance->update([
                    'description' => implode(",", $request->input('description', [])),
                    'medicament' => implode(",", $request->input('medicament', [])),
                    'quantite' => implode(",", $request->input('quantite', [])),
                ]);
                
                Cache::forget('ordonances_patient_' . $patient->id);
            });

            // Flash('L\'ordonnance a été modifiée avec succès !!');
            return redirect()->back()->with('success', 'L\'ordonnance a été modifiée avec succès !!');
            // return back();
            
        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour de l\'ordonnance: ' . $e->getMessage());
            // Flash('Erreur lors de la mise à jour de l\'ordonnance.');
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour de l\'ordonnance.')
            ->withInput();
        }
    }


    public function export_pdf($id)
    {
        set_time_limit(120);
        ini_set('memory_limit', '256M');

        try {
            // Fetch model with relationships
            $ordonance = Ordonance::with([
                    'patient:id,name,prenom,numero_dossier',
                    'user:id,name'
                ])
                ->select([
                    'id', 'patient_id', 'user_id', 'description',
                    'medicament', 'quantite', 'created_at'
                ])
                ->findOrFail($id);

            // Clear any existing output
            if (ob_get_length()) {
                ob_end_clean();
            }

            // PdfService options
            // $orientation = request()->input('orientation', 'portrait');
            // $format = request()->input('format', 'A4');
            // $delivery = request()->input('delivery', 'stream');

            // Safe filename generation
            $numeroDossier = $ordonance->patient->numero_dossier ?? 'unknown';
            $nomPatient = preg_replace('/[^a-zA-Z0-9_-]/', '_', $ordonance->patient->name ?? 'unknown');
           

            return redirect()->route('print.preview', [
                'type' => 'ordonance',
                'id' => $id
            ]);
           
            // Generate PDF using PdfService
            /*
            return PdfService::generate('admin.etats.ordonance', [
                'compteur' => 1,
                'ordonance' => $ordonance,
                'patient' => $ordonance->patient,
                'user' => $ordonance->user
            ], $filename, $orientation, $format, $delivery);
            */

        } catch (\Exception $e) {
            Log::error('Ordonance PDF Error: ' . $e->getMessage());

            if (ob_get_length()) {
                ob_end_clean();
            }

            return redirect()->back()->with('error', 'Erreur PDF ordonance');
        }
    }




    public function ordonance_create(Patient $patient)
    {
        return view('admin.prescriptions.ordonance_create', compact('patient'));
    }

}
