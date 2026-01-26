<?php

namespace App\Http\Controllers;

use App\Models\DevisElement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class DevisElementsController extends Controller
{
    /**
     * Display a listing of devis elements
     */
    public function index()
    {
        $this->authorize('viewAny', DevisElement::class);
        
        $elements = Cache::remember('devis_elements_list', 600, function () {
            return DevisElement::with('user:id,name')
                ->orderBy('nom')
                ->paginate(50);
        });
        
        return view('admin.devis_elements.index', compact('elements'));
    }

    /**
     * Store a newly created element
     */
    public function store(Request $request)
    {
        $this->authorize('create', DevisElement::class);
        
        $request->validate([
            'nom' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'prix_unitaire' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'actif' => 'boolean'
        ]);

        try {
            DevisElement::create([
                'nom' => $request->input('nom'),
                'code' => $request->input('code'),
                'prix_unitaire' => $request->input('prix_unitaire'),
                'description' => $request->input('description'),
                'actif' => $request->input('actif', true),
                'user_id' => Auth::id()
            ]);

            Cache::forget('devis_elements_list');
            Cache::forget('devis_elements_actifs');

            return redirect()->route('devis_elements.index')
                ->with('success', 'Élément ajouté avec succès !');

        } catch (\Exception $e) {
            Log::error('DevisElement Store Error: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de l\'ajout de l\'élément');
        }
    }

    /**
     * Update the specified element
     */
    public function update(Request $request, $id)
    {
        $this->authorize('update', DevisElement::class);
        
        $request->validate([
            'nom' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'prix_unitaire' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'actif' => 'boolean'
        ]);

        try {
            $element = DevisElement::findOrFail($id);
            
            $element->update([
                'nom' => $request->input('nom'),
                'code' => $request->input('code'),
                'prix_unitaire' => $request->input('prix_unitaire'),
                'description' => $request->input('description'),
                'actif' => $request->input('actif', true)
            ]);

            Cache::forget('devis_elements_list');
            Cache::forget('devis_elements_actifs');

            return redirect()->route('devis_elements.index')
                ->with('success', 'Élément modifié avec succès !');

        } catch (\Exception $e) {
            Log::error('DevisElement Update Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erreur lors de la modification');
        }
    }

    /**
     * Remove the specified element
     */
    public function destroy($id)
    {
        $this->authorize('delete', DevisElement::class);

        try {
            $element = DevisElement::findOrFail($id);
            $element->delete();

            Cache::forget('devis_elements_list');
            Cache::forget('devis_elements_actifs');

            return redirect()->route('devis_elements.index')
                ->with('success', 'Élément supprimé avec succès !');

        } catch (\Exception $e) {
            Log::error('DevisElement Delete Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression');
        }
    }

    /**
     * Get active elements for autocomplete (AJAX)
     */
    public function getActifs(Request $request)
    {
        $search = $request->input('q', '');
        
        $elements = Cache::remember("devis_elements_search_{$search}", 300, function () use ($search) {
            $query = DevisElement::actif()->orderBy('nom');
            
            if ($search) {
                $query->search($search);
            }
            
            return $query->limit(20)->get(['id', 'nom', 'code', 'prix_unitaire']);
        });
        
        return response()->json($elements);
    }
}