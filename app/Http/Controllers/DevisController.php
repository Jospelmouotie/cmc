<?php

namespace App\Http\Controllers;
use App\Models\Patient;
use ZanySoft\LaravelPDF\Facades\PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Devi;
use App\Models\LigneDevi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
// INSERT: PdfService import
use App\Services\PdfService;

class DevisController extends Controller
{
    public function index()
    {
        $devis = Cache::remember('devis_list', 600, function () {
            return Devi::select(['id', 'code', 'acces', 'user_id', 'nom', 'nbr_chambre', 'nbr_visite', 'nbr_ami_jour', 'pu_chambre', 'pu_visite', 'pu_ami_jour', 'created_at'])
                ->with('ligneDevis:id,element,quantite,prix_u,devi_id')
                ->latest()
                ->limit(100)
                ->get();
        });
        $patients = Patient::orderBy('created_at', 'DESC')->select('id','name', 'prenom')->get();
        return view('admin.devis.index', compact('devis','patients'));
    }

    public function edit(Request $request, $id)
    {
        $this->authorize('update', Devi::class);
        $request->validate([
            'code_devis' => '',
            'nbr_chambre' => 'required|numeric|min:0',
            'nbr_visite' => 'required|numeric|min:0',
            'nbr_ami_jour' => 'required|numeric|min:0',
            'pu_chambre' => 'required|numeric|min:0',
            'pu_visite' => 'required|numeric|min:0',
            'pu_ami_jour' => 'required|numeric|min:0',
            'nom_devis' => 'required',
            'acces_devis' => 'required',
            'ligneDevi' => 'array|required',
            'ligneDevi.*.element' => 'required',
            'ligneDevi.*.quantite' => 'required|numeric|min:1',
            'ligneDevi.*.prix_u' => 'required|numeric|min:1',
        ]);
        DB::transaction(function () use ($request, $id) {
            $devi = Devi::findOrFail($id);
            $devi->nom = $request->input('nom_devis');
            $devi->nbr_chambre = $request->input('nbr_chambre');
            $devi->nbr_visite = $request->input('nbr_visite');
            $devi->nbr_ami_jour = $request->input('nbr_ami_jour');
            $devi->pu_chambre = $request->input('pu_chambre');
            $devi->pu_visite = $request->input('pu_visite');
            $devi->pu_ami_jour = $request->input('pu_ami_jour');
            $devi->code = $request->input('code_devis') ?? \Carbon\Carbon::now()->toDateString().'/'.substr($request->input('nom_devis'),0,4);
            $devi->acces = $request->input('acces_devis');
            $lignedevis = $request->input('ligneDevi');
            $devi->save();
            LigneDevi::where('devi_id',$id)->delete();
            foreach ($lignedevis as $ligneDevi) {
                $devi->ligneDevis()->save(new LigneDevi([
                    "element" => $ligneDevi["element"],
                    "quantite" => $ligneDevi["quantite"],
                    "prix_u" => $ligneDevi["prix_u"],
                ]));
            }
            Cache::forget('devis_list');
            Cache::flush();
        });
        return redirect()->route('devis.index')->with('success', 'Devis modifier avec succes !');
    }


    public function store(Request $request)
{
    $this->authorize('create', Devi::class);

    $request->validate([
        'code_devis' => 'nullable|string',
        'nbr_chambre' => 'required|numeric|min:0',
        'nbr_visite' => 'required|numeric|min:0',
        'nbr_ami_jour' => 'required|numeric|min:0',
        'pu_chambre' => 'required|numeric|min:0',
        'pu_visite' => 'required|numeric|min:0',
        'pu_ami_jour' => 'required|numeric|min:0',
        'nom_devis' => 'required',
        'acces_devis' => 'required',
        'ligneDevi' => 'array|required',
        'ligneDevi.*.element' => 'required',
        'ligneDevi.*.quantite' => 'required|numeric|min:1',
        'ligneDevi.*.prix_u' => 'required|numeric|min:1',
    ]);

    try {
        DB::transaction(function () use ($request) {
            $devis = Devi::create([
                'nom' => $request->input('nom_devis'),
                'nbr_chambre' => $request->input('nbr_chambre'),
                'nbr_visite' => $request->input('nbr_visite'),
                'nbr_ami_jour' => $request->input('nbr_ami_jour'),
                'pu_chambre' => $request->input('pu_chambre'),
                'pu_visite' => $request->input('pu_visite'),
                'pu_ami_jour' => $request->input('pu_ami_jour'),
                'code' => $request->input('code_devis') ?? \Carbon\Carbon::now()->toDateString().'/'.substr($request->input('nom_devis'), 0, 4),
                'acces' => $request->input('acces_devis'),
                'user_id' => Auth::id(),
            ]);

            $lignedevis = $request->input('ligneDevi');
            foreach ($lignedevis as $ligneDevi) {
                $devis->ligneDevis()->save(new LigneDevi([
                    "element" => $ligneDevi["element"],
                    "quantite" => $ligneDevi["quantite"],
                    "prix_u" => $ligneDevi["prix_u"],
                ]));
            }

            // CORRECTION CACHE (DRIVER FILE)
            // On supprime la clé spécifique et on vide le cache global car tags() n'existe pas
            Cache::forget('devis_list');
            Cache::flush();
        });

        // CORRECTION DU RETURN
        return redirect()->route('devis.index')->with('success', 'Devis enregistré avec succès !');

    } catch (\Exception $e) {
        return redirect()->back()->withInput()->with('error', 'Erreur lors de l\'enregistrement : ' . $e->getMessage());
    }
}


public function export_devis(Request $request, $montant_en_lettre)
{
    try {
        $this->authorize('print', Devi::class);

        $request->validate([
            'patient' => 'required',
            'nbr_chambre' => 'required|numeric|min:0',
            'nbr_visite' => 'required|numeric|min:0',
            'nbr_ami_jour' => 'required|numeric|min:0',
            'pu_chambre' => 'required|numeric|min:0',
            'pu_visite' => 'required|numeric|min:0',
            'pu_ami_jour' => 'required|numeric|min:0',
            'nom_devis' => 'required',
            'ligneDevi' => 'array|required',
            'ligneDevi.*.element' => 'required',
            'ligneDevi.*.quantite' => 'required|numeric|min:1',
            'ligneDevi.*.prix_u' => 'required|numeric|min:1',
        ]);

        // Store devis data in session for preview
        $devisData = $request->all();
        $devisData['montant_en_lettre'] = $montant_en_lettre;

        // Generate unique ID for this devis preview
        $previewId = 'devis_' . time() . '_' . uniqid();
        session(["devis_preview_{$previewId}" => $devisData]);

        return redirect()->route('print.preview', [
            'type' => 'devis',
            'id' => $previewId
        ])->with($devisData);

    } catch (\Exception $e) {
        Log::error('Devis Preview Redirect Error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Erreur lors de la préparation du devis');
    }
}

}
