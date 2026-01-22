<?php

namespace App\Http\Controllers;
use App\Models\Patient;
use App\Http\Requests\ImagRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Examen;

class PatientimageController extends Controller
{

    public function store(ImagRequest $request)
    {
        DB::transaction(function () use ($request) {
            $patient = Patient::select('id')->findOrFail($request->input('patient_id'));
            $path = $request->file('image')->store('examens_scannes', 'public');

            // Copy to public/storage for Windows PHP server compatibility
            $source = storage_path('app/public/' . $path);
            $destinationDir = public_path('storage/examens_scannes');
            if (!file_exists($destinationDir)) {
                mkdir($destinationDir, 0755, true);
            }
            $destination = $destinationDir . '/' . basename($path);
            copy($source, $destination);

            $examen = new Examen([
                'nom'  => $request->input('nom'),
                'description' => $request->input('description'), 
                'image'=> $path,
            ]);

            $patient->examens()->save($examen);
        });

        return redirect()->route('patients.show', $request->input('patient_id'))->with('success', 'examen scanné ajouté avec succès !');
    }

    public function destroy($id, Request $request)
    {
        $this->authorize('update', Patient::class);
        $image = Examen::select(['id', 'image', 'patient_id'])->findOrFail($id);
        Storage::disk('public')->delete($image->image);

        // Also delete from public/storage for Windows compatibility
        $publicPath = public_path('storage/' . $image->image);
        if (file_exists($publicPath)) {
            unlink($publicPath);
        }

        $image->delete();
        return redirect()->route('patients.show', $request->get('patient_id'))->with('success', 'examen scanné supprimé avec succès !');
    }
    
}