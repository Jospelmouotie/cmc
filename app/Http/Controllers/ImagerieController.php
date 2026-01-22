<?php

namespace App\Http\Controllers;

use App\Models\Imagerie;
use Illuminate\Http\Request;
use App\Models\Patient;
use ZanySoft\LaravelPDF\Facades\PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ImagerieController extends Controller
{
    public function create(Patient $patient)
    {
        $cacheKey = "imageries_patient_{$patient->id}_page_" . request('page', 1);
        
        $imageries = Cache::remember($cacheKey, 600, function () use ($patient) {
            return Imagerie::select(['id', 'radiographie', 'echographie', 'scanner', 'irm', 'scintigraphie', 'autre', 'patient_id', 'created_at'])
                ->with('patient:id,name,prenom')
                ->where('patient_id', $patient->id)
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        });
        
        return view('admin.consultations.partials.feuille_examen_imagerie', compact('patient', 'imageries'));
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $patient = Patient::select('id')->findOrFail($request->input('patient_id'));
            
            $imageries = new Imagerie();
            
            // Helper function to handle both array and string inputs
            $processInput = function($input) {
                if (is_array($input)) {
                    return implode(',', $input);
                }
                return $input ?? '';
            };
            
            $imageries->radiographie = $processInput($request->input('radiographie'));
            $imageries->echographie = $processInput($request->input('echographie'));
            $imageries->scanner = $processInput($request->input('scanner'));
            $imageries->irm = $processInput($request->input('irm'));
            $imageries->scintigraphie = $processInput($request->input('scintigraphie'));
            $imageries->autre = $request->input('autre');
            $imageries->patient_id = $patient->id;
            $imageries->user_id = Auth::id(); 
            $imageries->save();
            
            // Clear specific cache instead of all
            Cache::forget("imageries_patient_{$patient->id}_page_1");
            Cache::forget("imageries_patient_{$patient->id}");
        });

        // Flash('La nouvelle prescription a été créée avec succès !!');
        return redirect()->back()->with('success', 'La nouvelle prescription a été créée avec succès !!');
        // return back();
    }

    public function show(Request $request, $id)
    {
        $cacheKey = "imagerie_{$id}";
        
        $imageries = Cache::remember($cacheKey, 3600, function () use ($id) {
            return Imagerie::select(['id', 'patient_id', 'user_id', 'radiographie', 'echographie', 'scanner', 'irm', 'scintigraphie', 'autre', 'created_at'])
                ->with('patient:id,name,prenom', 'user:id,name')
                ->find($id);
        });

        return view('admin.imageries.show', compact('imageries'));
    }

    public function export_imageries($id)
    {
        set_time_limit(120);
        ini_set('memory_limit', '256M');

        try {
            // Fetch model with relationships
            $imagerie = Imagerie::with([
                    'patient:id,name,prenom',
                    'user:id,name'
                ])
                ->select([
                    'id', 'patient_id', 'user_id', 'radiographie', 'echographie',
                    'scanner', 'irm', 'scintigraphie', 'autre', 'created_at'
                ])
                ->findOrFail($id);

            // Pass model with the CORRECT variable name that matches the view
            $pdf = PDF::loadView('admin.etats.imageries', [
                'imageries' => $imagerie  // Changed from 'imagerie' to 'imageries'
            ]);

            return $pdf->stream('imageries_' . $id . '.pdf');

        } catch (\Exception $e) {
            Log::error('Imagerie PDF Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur PDF imagerie');
        }
    }

}



















