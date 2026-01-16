<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Models\Patient;
use ZanySoft\LaravelPDF\Facades\PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PrescriptionController extends Controller
{
    public function create(Patient $patient)
    {
        $cacheKey = 'prescriptions_patient_{$patient->id}_page_' . request('page', 1);
        $prescriptions = Cache::remember($cacheKey, 300, function () use ($patient) {
            return Prescription::select(['id', 'patient_id', 'created_at'])
                ->with('patient:id,name,prenom')
                ->where('patient_id', $patient->id)
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        });

        return view('admin.prescriptions.create', compact('patient', 'prescriptions'));
    }


    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $patient = Patient::select('id')->findOrFail($request->input('patient_id'));

            $prescription = new Prescription();

            $prescription->hematologie = implode(',', $request->input('hematologie', []));
            $prescription->hemostase = implode(',', $request->input('hemostase', []));
            $prescription->biochimie = implode(',', $request->input('biochimie', []));
            $prescription->hormonologie = implode(',', $request->input('hormonologie', []));
            $prescription->marqueurs = implode(',', $request->input('marqueurs', []));
            $prescription->bacteriologie = implode(',', $request->input('bacteriologie', []));
            $prescription->spermiologie = implode(',', $request->input('spermiologie', []));
            $prescription->urines = implode(',', $request->input('urines', []));
            $prescription->serologie = implode(',', $request->input('serologie', []));
            $prescription->examen = implode(',', $request->input('examen', []));

            $prescription->patient_id = $request->input('patient_id');
            $prescription->user_id = Auth::id();

            $prescription->save();

            // Invalidate cache for patient's prescriptions
            Cache::forget("prescriptions_patient_{$patient->id}_page_1");
            Cache::forget("prescription_{$prescription->id}");

            // Flash('La nouvelle prescription a été crée avec succès !!');
            return redirect()->back()->with('success', 'La nouvelle prescription a été crée avec succès !!');

            // return back();
        });
    }

    public function show(Request $request, $id)
    {
        $prescription = Cache::remember("prescription_{$id}", 3600, function () use ($id) {
            return Prescription::with('patient:id,name,prenom')
                ->findOrFail($id);
        });

        return view('admin.prescriptions.show', compact('prescription'));
    }

    public function export_prescription($id)
    {
        set_time_limit(120);
        ini_set('memory_limit', '256M');

        try {
            $prescription = Prescription::with([
                    'patient:id,name,prenom',
                    'user:id,name,prenom,specialite,onmc' // ← critical!
                ])
                ->select([
                    'id', 'patient_id', 'user_id', 'hematologie', 'hemostase',
                    'biochimie', 'hormonologie', 'marqueurs', 'bacteriologie',
                    'spermiologie', 'urines', 'serologie', 'examen', 'created_at'
                ])
                ->findOrFail($id);

            return redirect()->route('print.preview', [
                'type' => 'prescription',
                'id' => $id
            ]);

        } catch (\Exception $e) {
            Log::error('Prescription PDF Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur PDF prescription');
        }
    }

}
