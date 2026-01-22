<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\Chambre;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ChambresController extends Controller
{

    public function index()
    {
        $query = Chambre::query();

        if (request()->has('categorie')) {
            $query->where('categorie', request('categorie'));
        }

        if (request()->has('order')) {
            $query->orderBy('id', request('order'));
        }

        // Use select to reduce data retrieval
        $chambres = $query->select('id', 'numero', 'categorie', 'prix', 'statut', 'patient', 'jour')
            ->paginate(50)
            ->appends([
                'categorie' => request('categorie'),
                'order' => request('order'),
            ]);

        return view('admin.chambres.index', compact('chambres'));
    }

    public function create()
    {
        return view('admin.chambres.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'numero'=>'required|integer',
            'categorie'=> 'required|string',
            'prix'=>'required|integer'
        ]);

        $chambre = new Chambre();

            $chambre->numero = $request->get('numero');
            $chambre->categorie = $request->get('categorie');
            $chambre->prix = $request->get('prix');
            $chambre->user_id = Auth::id();
            $chambre->save();
        return  redirect()->route('chambres.index')->with('success', 'chambre ajoutée avec succes');
    }


    public function attribute($id)
    {
        $chambre = Chambre::select(['id', 'numero', 'categorie', 'prix', 'statut'])
            ->findOrFail($id);
        
        // Cache patient list
        $patients = Cache::remember('patients_for_chambers', 600, function () {
            return Patient::select(['id', 'name', 'prenom', 'numero_dossier'])
                ->orderBy('name')
                ->get();
        });

        return view('admin.chambres.attribute', compact('chambre', 'patients'));
    }


    public function edit($id)
    {
        $chambre = Chambre::findOrFail($id);

        return view('admin.chambres.edit', compact('chambre'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'numero'=> ['required'],
            'categorie'=> ['required'],
            'prix'=> ['required', 'integer', 'numeric'],

        ]);

        $chambre = Chambre::findOrFail($id);

        $chambre->numero = $request->get('numero');
        $chambre->categorie = $request->get('categorie');
        $chambre->prix = $request->get('prix');

        $chambre->save();

        return redirect()->route('chambres.index')->with('success', 'La mise à jour a bien été éffectuer');
    }

  
    public function updateStatus(Request $request, Chambre $chambre)
    {
        $chambre->update($request->only(['patient', 'statut', 'jour']));
        
        // Clear cache
        Cache::forget('chambres_list');

        return redirect()->route('chambres.index')
            ->with('success', 'La chambre a bien été attribuée');
    }

    public function updateMinus(Request $request, Chambre $chambre, Patient $patient)
    {
        $chambre->update($request->only(
            [
                'patient',
                'statut',
                'jour'
            ]));

        return redirect()->route('chambres.index')->with('success', 'La chambre a bien été liberer');
    }

}





