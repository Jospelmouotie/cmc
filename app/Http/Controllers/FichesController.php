<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fiche;
// use ZanySoft\LaravelPDF\PDF;
use ZanySoft\LaravelPDF\Facades\PDF;
use Illuminate\Support\Facades\Log;
use App\Services\PdfService;

class FichesController extends Controller
{

    public function index()
    {

        $fiche = Fiche::orderBy('id', 'asc')->paginate(50);
        return view('admin.fiches.index', compact('fiche'));
    }


    public function create()
    {
        return view('admin.fiches.create');
    }


    public function store(Request $request)
    {
        $this->authorize('create', Fiche::class);

        $request->validate([
            'nom'=>'required',
            'prenom'=> 'required',
            'chambre_numero'=> 'required|integer',
            'age'=> 'required|integer',
            'service'=> 'required',
            'infirmier_charge'=> 'required',
            'accueil'=> 'required',
            'restauration'=> 'required',
            'chambre'=> 'required',
            'soins'=> 'required',
            'notes'=> 'required|integer',
            'quizz'=> 'required',
            'remarque_suggestion'=> 'required'

        ]);
        $fiche = new Fiche([
            'nom' => $request->get('nom'),
            'prenom' => $request->get('prenom'),
            'chambre_numero' => $request->get('chambre_numero'),
            'age' => $request->get('age'),
            'service' => $request->get('service'),
            'infirmier_charge' => $request->get('infirmier_charge'),
            'accueil' => $request->get('accueil'),
            'restauration' => $request->get('restauration'),
            'chambre' => $request->get('chambre'),
            'soins' => $request->get('soins'),
            'notes' => $request->get('notes'),
            'quizz'=> $request->get('quizz'),
            'remarque_suggestion'=> $request->get('remarque_suggestion')

        ]);
        $fiche->save();

        return redirect()->route('fiches.index')->with('success', 'La fiche de satisfaction a bien été ajouté');
    }


    public function show($id)
    {
        $fiche = Fiche::findOrFail($id);
        return view('admin.fiches.show', compact('fiche'));
    }


    public function edit($id)
    {
        $fiche = Fiche::findOrFail($id);

        return view('admin.fiches.edit', compact('fiche'));
    }


    public function update(Request $request, Fiche $fiche)
    {
        $this->authorize('create', Fiche::class);
        $request->validate([
            'nom'=>'required',
            'prenom'=> 'required',
            'chambre_numero'=> 'required|integer',
            'age'=> 'required|integer',
            'service'=> 'required',
            'infirmier_charge'=> 'required',
            'accueil'=> 'required',
            'restauration'=> 'required',
            'chambre'=> 'required',
            'soins'=> 'required',
            'notes'=> 'required|integer',
            'quizz'=> 'required',
            'remarque_suggestion'=> 'required'

        ]);

        $fiche->update();
        return redirect()->route('fiches.index')->with('success', 'La fiche de satisfaction a bien été modifié');
    }


    public function destroy($id)
    {
        $fiche = Fiche::find($id);
        $fiche->delete();

        return redirect()->route('fiches.index')->with('success', 'Le produit a bien été supprimé');
    }

   
    public function export_pdf($id)
    {
        set_time_limit(120);
        ini_set('memory_limit', '256M');

        try {
            // Fetch the model directly
            $fiche = Fiche::select([
                    'id', 'nom', 'prenom', 'chambre_numero', 'age', 'service',
                    'infirmier_charge', 'accueil', 'restauration', 'chambre',
                    'soins', 'notes', 'quizz', 'remarque_suggestion'
                ])
                ->findOrFail($id);

            // Clear any existing output
            if (ob_get_length()) {
                ob_end_clean();
            }

            // Read PdfService options
            $orientation = request()->input('orientation', 'portrait');
            $format = request()->input('format', 'A4');
            $delivery = request()->input('delivery', 'stream');

            // Safe filename
            $nom = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $fiche->nom ?? 'patient');
            $prenom = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $fiche->prenom ?? '');
            $filename = "fiche_satisfaction_{$fiche->id}_{$nom}_{$prenom}.pdf";

            return PdfService::generate('admin.etats.fiche', [
                'fiche' => $fiche
            ], $filename, $orientation, $format, $delivery);

        } catch (\Exception $e) {
            Log::error('Fiche PDF Error: ' . $e->getMessage());

            if (ob_get_length()) {
                ob_end_clean();
            }

            return redirect()->back()->with('error', 'Erreur PDF fiche');
        }
    }
}
