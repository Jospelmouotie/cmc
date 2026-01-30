<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProduitRequest;
use App\Models\CartItem; // Nouveau modèle
use App\Models\Facture;
use App\Models\Patient;
use App\Models\Produit;
use App\Services\PdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProduitsController extends Controller
{
    public function index()
    {
        $cacheKey = 'produits_page_'.request('page', 1);
        $produits = Cache::remember($cacheKey, 600, function () {
            return Produit::select(['id', 'designation', 'categorie', 'qte_stock', 'qte_alerte', 'prix_unitaire'])
                ->orderBy('created_at', 'asc')
                ->paginate(10);
        });

        $produitCount = Cache::remember('produits_count', 3600, function () {
            return Produit::count();
        });

        return view('admin.produits.index', compact('produits', 'produitCount'));
    }

    public function create()
    {
        $this->authorize('create', Produit::class);

        return view('admin.produits.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'designation' => 'required|unique:produits,designation',
            'categorie' => 'required',
            'qte_stock' => 'required|integer|min:0',
            'qte_alerte' => 'required|integer|min:0',
            'prix_unitaire' => 'required|integer|min:0',
        ]);

        try {
            $produit = new Produit;
            $produit->designation = $request->designation;
            $produit->categorie = $request->categorie;
            $produit->qte_stock = $request->qte_stock;
            $produit->qte_alerte = $request->qte_alerte;
            $produit->prix_unitaire = $request->prix_unitaire;
            $produit->user_id = auth()->id() ?? 1;
            $produit->save();

            Cache::flush();

            return redirect()->route('produits.index')->with('success', 'Produit créé avec succès');
        } catch (\Exception $e) {
            if (str_contains($e->getMessage(), 'duplicate key')) {
                \DB::statement("SELECT setval(pg_get_serial_sequence('produits', 'id'), coalesce(max(id),0) + 1, false) FROM produits;");
                $produit->save();

                return redirect()->route('produits.index');
            }

            return redirect()->back()->with('error', 'Erreur : '.$e->getMessage());
        }
    }

    public function edit(Produit $produit)
    {
        $this->authorize('update', $produit);

        return view('admin.produits.edit', compact('produit'));
    }

    public function update(ProduitRequest $request, Produit $produit)
    {
        $this->authorize('update', $produit);
        DB::transaction(function () use ($request, $produit) {
            $produit->update(array_merge($request->validated(), ['user_id' => Auth::id()]));
            Cache::flush();
        });

        return redirect()->route('produits.index')->with('success', 'Le produit a été mis à jour !');
    }

    public function destroy(Produit $produit)
    {
        $this->authorize('delete', $produit);
        DB::transaction(function () use ($produit) {
            // Supprimer d'abord les références dans les paniers pour éviter les erreurs de FK
            CartItem::where('produit_id', $produit->id)->delete();
            $produit->delete();
            Cache::flush();
        });

        return redirect()->route('produits.index')->with('success', 'Produit supprimé du catalogue et des paniers.');
    }

    // --- LOGIQUE PANIER VIA BASE DE DONNÉES ---

    public function add_to_cart(Request $request, $id)
    {
        $produit = Produit::findOrFail($id);

        if ($produit->qte_stock <= 0) {
            return $request->ajax()
                ? response()->json(['success' => false, 'message' => 'Stock épuisé'])
                : redirect()->back()->with('error', 'Stock épuisé');
        }

        $cartItem = CartItem::where('user_id', auth()->id())->where('produit_id', $id)->first();

        if ($cartItem) {
            $cartItem->increment('quantite');
        } else {
            CartItem::create([
                'user_id' => auth()->id(),
                'produit_id' => $id,
                'quantite' => 1,
                'prix_unitaire' => $produit->prix_unitaire,
            ]);
        }

        if ($request->ajax()) {
            return $this->getCartJsonResponse();
        }

        return redirect()->route('pharmaceutique.facturation')->with('success', 'Facture mise à jour');
    }

    public function facturation()
    {
        $cartItems = CartItem::where('user_id', auth()->id())->with('produit')->get();
        $totalPrix = $cartItems->sum(fn ($item) => $item->quantite * $item->prix_unitaire);
        $patient = Patient::all();

        return view('admin.produits.facturation', compact('cartItems', 'totalPrix', 'patient'));
    }

    public function getReduceByOne(Request $request, $id)
    {
        $cartItem = CartItem::where('user_id', auth()->id())->where('produit_id', $id)->first();

        if ($cartItem) {
            if ($cartItem->quantite > 1) {
                $cartItem->decrement('quantite');
            } else {
                $cartItem->delete();
            }
        }

        return $request->ajax() ? $this->getCartJsonResponse() : redirect()->back();
    }

    public function getRemoveItem(Request $request, $id)
    {
        CartItem::where('user_id', auth()->id())->where('produit_id', $id)->delete();

        return $request->ajax() ? $this->getCartJsonResponse() : redirect()->back();
    }

    private function getCartJsonResponse()
    {
        $items = CartItem::where('user_id', auth()->id())->with('produit')->get();
        $totalPrix = $items->sum(fn ($i) => $i->quantite * $i->prix_unitaire);
        $totalQte = $items->sum('quantite');

        // Formater pour ton JavaScript qui attend une structure précise
        $formattedItems = [];
        foreach ($items as $item) {
            $formattedItems[$item->produit_id] = [
                'qty' => $item->quantite,
                'price' => $item->quantite * $item->prix_unitaire,
                'item' => $item->produit,
            ];
        }

        return response()->json([
            'success' => true,
            'items' => $formattedItems,
            'totalPrix' => $totalPrix,
            'totalQte' => $totalQte,
            'cartEmpty' => $items->isEmpty(),
        ]);
    }

  public function export_pdf(Request $request)
{
    // 1. Récupérer les items du panier en base de données
    $cartItems = \App\Models\CartItem::where('user_id', auth()->id())->with('produit')->get();

    if ($cartItems->isEmpty()) {
        return redirect()->route('pharmaceutique.facturation')->with('error', 'Votre panier est vide');
    }

    $patientName = $request->input('patient');
    $totalPrix = $cartItems->sum(fn($i) => $i->quantite * $i->prix_unitaire);
    $totalQte = $cartItems->sum('quantite');

    try {
        $facture = DB::transaction(function () use ($cartItems, $patientName, $totalPrix, $totalQte) {
            // 2. Création de la facture (uniquement des chiffres pour le numéro)
            $f = Facture::create([
                'numero' => mt_rand(100000, 999999),
                'quantite_total' => $totalQte,
                'prix_total' => $totalPrix,
                'patient' => $patientName,
                'user_id' => auth()->id(),
            ]);

            // 3. Liaison des produits avec la table pivot
            foreach ($cartItems as $ci) {
                $f->produits()->attach($ci->produit_id, [
                    'quantite' => $ci->quantite,
                    'prix_unitaire' => $ci->prix_unitaire,
                    // Correction de l'erreur : on remplit la colonne 'item' demandée par ta DB
                    // On y met l'ID du produit ou une valeur par défaut
                    'item' => $ci->produit_id,
                ]);
            }

            return $f;
        });

        // 4. Préparer le nom du fichier
        $filename = 'facture_' . $facture->numero . '.pdf';

        // 5. Nettoyer le panier SQL AVANT de générer le PDF pour éviter les doublons
        \App\Models\CartItem::where('user_id', auth()->id())->delete();

        // 6. Génération du PDF
        return PdfService::generate('admin.etats.pharmacie', [
            'patient' => $patientName,
            'produits' => $cartItems,
            'totalPrix' => $totalPrix,
            'totalQte' => $totalQte,
            'facture' => $facture,
        ], $filename);

    } catch (\Exception $e) {
        Log::error('Erreur lors de la facturation : ' . $e->getMessage());
        return redirect()->back()->with('error', 'Erreur lors de la génération : ' . $e->getMessage());
    }
}
    // --- MÉTHODES DE STOCK ---

    public function stock_pharmaceutique()
    {
        return $this->viewByCategory('PHARMACEUTIQUE', 'admin.produits.pharmaceutique');
    }

   public function stock_materiel()
{
    $cacheKey = 'produits_materiel_page_' . request('page', 1);

    $produits = Cache::remember($cacheKey, 600, function () {
        return Produit::where('categorie', 'MATERIEL')
            ->select('id', 'designation', 'qte_stock', 'qte_alerte', 'prix_unitaire')
            ->orderBy('designation')
            ->paginate(50);
    });

    // On récupère le count
    $materielCount = Cache::remember('materiel_count', 3600, function () {
        return Produit::where('categorie', 'MATERIEL')->count();
    });

    // TRÈS IMPORTANT : compact('produits', 'materielCount')
    // envoie une variable nommée $materielCount à la vue.
    return view('admin.produits.materiel', compact('produits', 'materielCount'));
}

    public function stock_anesthesiste()
    {
        return $this->viewByCategory('ANESTHESISTE', 'admin.produits.anesthesiste');
    }

    private function viewByCategory($cat, $view)
    {
        $produits = Produit::where('categorie', $cat)->orderBy('designation')->paginate(50);
        $pharmaCount = Produit::where('categorie', $cat)->count();

        return view($view, compact('produits', 'pharmaCount'));
    }
}
