<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Facture;
use App\Models\Patient;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Services\PdfService;

class ProduitsController extends Controller
{
    /**
     * Affiche la liste complète de tous les produits
     */
  public function index()
{
    $page = request('page', 1);
    $cacheKey = "produits_all_page_{$page}";

    // On récupère les produits paginés (50 par page)
    $produits = Cache::remember($cacheKey, 600, function () {
        return Produit::orderBy('designation', 'asc')->paginate(50);
    });

    // IMPORTANT : On récupère le vrai total depuis l'objet de pagination
    // ou on force le rafraîchissement du cache
    $produitCount = $produits->total();

    return view('admin.produits.index', compact('produits', 'produitCount'));
}

    public function create()
    {
        $this->authorize('create', Produit::class);
        return view('admin.produits.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Produit::class);

        $request->validate([
            'designation'   => ['required', 'unique:produits'],
            'categorie'     => 'required|string',
            'qte_alerte'    => 'required|integer|min:0',
            'qte_stock'     => 'required|integer|min:0',
            'prix_unitaire' => 'required|integer|min:0'
        ]);

        DB::transaction(function () use ($request) {
            Produit::create([
                'designation'   => $request->designation,
                'categorie'     => $request->categorie,
                'qte_stock'     => $request->qte_stock,
                'qte_alerte'    => $request->qte_alerte,
                'prix_unitaire' => $request->prix_unitaire,
                'user_id'       => Auth::id(),
            ]);

            $this->clearProduitCache();
        });

        return redirect()->route('produits.index')->with('success', 'Le produit a été ajouté avec succès !');
    }

    public function edit(Produit $produit)
    {
        $this->authorize('update', $produit);
        return view('admin.produits.edit', compact('produit'));
    }

    public function update(Request $request, Produit $produit)
    {
        $this->authorize('update', $produit);

        $request->validate([
            'qte_stock' => 'required|integer|min:0'
        ]);

        DB::transaction(function () use ($produit, $request) {
            // Logique d'addition au stock existant
            $produit->qte_stock += $request->input('qte_stock');
            $produit->user_id = Auth::id();
            $produit->save();

            $this->clearProduitCache();
        });

        return redirect()->route('produits.index')->with('success', 'Le stock a été mis à jour avec succès !');
    }

    public function destroy(Produit $produit)
    {
        $this->authorize('delete', $produit);

        DB::transaction(function () use ($produit) {
            $produit->delete();
            $this->clearProduitCache();
        });

        return redirect()->route('produits.index')->with('success', 'Le produit a bien été supprimé');
    }

    // --- VUES PAR CATÉGORIES ---

    public function stock_pharmaceutique()
    {
        $page = request('page', 1);
        $cacheKey = "produits_pharma_page_{$page}";

        $produits = Cache::remember($cacheKey, 600, function () {
            return Produit::where('categorie', 'PHARMACEUTIQUE')
                ->select('id', 'designation', 'qte_stock', 'qte_alerte', 'prix_unitaire')
                ->orderBy('designation')
                ->paginate(50);
        });

        $pharmaCount = Cache::remember('pharma_count', 3600, function () {
            return Produit::where('categorie', 'PHARMACEUTIQUE')->count();
        });

        return view('admin.produits.pharmaceutique', compact('produits', 'pharmaCount'));
    }

    public function stock_materiel()
    {
        $page = request('page', 1);
        $cacheKey = "produits_materiel_page_{$page}";

        $produits = Cache::remember($cacheKey, 600, function () {
            return Produit::where('categorie', 'MATERIEL')
                ->select('id', 'designation', 'qte_stock', 'qte_alerte', 'prix_unitaire')
                ->orderBy('designation')
                ->paginate(50);
        });

        $materielCount = Cache::remember('materiel_count', 3600, function () {
            return Produit::where('categorie', 'MATERIEL')->count();
        });

        return view('admin.produits.materiel', compact('produits', 'materielCount'));
    }

    public function stock_anesthesiste()
    {
        $page = request('page', 1);
        $cacheKey = "produits_anesthesiste_page_{$page}";

        $produits = Cache::remember($cacheKey, 600, function () {
            return Produit::where('categorie', 'ANESTHESISTE')
                ->select('id', 'designation', 'qte_stock', 'qte_alerte', 'prix_unitaire')
                ->orderBy('designation')
                ->paginate(50);
        });

        $pharmaCount = Cache::remember('anesthesiste_count', 3600, function () {
            return Produit::where('categorie', 'ANESTHESISTE')->count();
        });

        return view('admin.produits.anesthesiste', compact('produits', 'pharmaCount'));
    }

    // --- FACTURATION & PANIER ---

    public function add_to_cart(Request $request, $id)
    {
        $produit = Produit::findOrFail($id);

        if ($produit->qte_stock <= 0) {
            $msg = 'Le produit n\'est plus disponible en stock';
            return $request->ajax()
                ? response()->json(['success' => false, 'message' => $msg])
                : redirect()->back()->with('error', $msg);
        }

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $cart->add($produit, $produit->id);

        Session::put('cart', $cart);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'items' => $cart->items,
                'totalPrix' => $cart->totalPrix,
                'totalQte' => $cart->totalQte
            ]);
        }

        return redirect()->route('pharmaceutique.facturation')->with('success', "Facture mise à jour");
    }

    public function facturation()
    {
        if (!Session::has('cart')) {
            return view('admin.produits.facturation');
        }

        $cart = new Cart(Session::get('cart'));
        $produit = Produit::whereIn('id', array_keys($cart->items))->get();
        $patient = Patient::orderBy('name')->get();

        return view('admin.produits.facturation', [
            'produit' => $produit,
            'produits' => $cart->items,
            'totalPrix' => $cart->totalPrix,
            'patient' => $patient
        ]);
    }

    // --- PDF & EXPORT ---

    public function export_pdf(Request $request)
    {
        if (!Session::has('cart')) {
            return redirect()->back()->with('error', 'Votre panier est vide');
        }

        try {
            $cart = new Cart(Session::get('cart'));
            $patientName = $request->input('patient');

            $facture = DB::transaction(function () use ($cart, $patientName) {
                $f = Facture::create([
                    'numero' => mt_rand(10000, 999999),
                    'quantite_total' => $cart->totalQte,
                    'prix_total' => $cart->totalPrix,
                    'patient' => $patientName,
                    'user_id' => Auth::id(),
                ]);
                $f->produits()->attach($cart->items);
                return $f;
            });

            $produitsData = collect($cart->items)->map(function ($item) {
                return (object)[
                    'designation'   => $item['item']['designation'] ?? 'N/A',
                    'prix_unitaire' => $item['item']['prix_unitaire'] ?? 0,
                    'qty'           => $item['qty'] ?? 0,
                    'price'         => $item['price'] ?? 0,
                ];
            });

            Session::forget('cart');

            return PdfService::generate('admin.etats.pharmacie', [
                'patient'   => $patientName,
                'produits'  => $produitsData,
                'totalPrix' => $cart->totalPrix,
                'totalQte'  => $cart->totalQte,
                'facture'   => $facture,
            ], 'pharmacie_'.$facture->numero.'.pdf');

        } catch (\Exception $e) {
            Log::error('Pharmacie PDF Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la génération du PDF');
        }
    }

    /**
     * Helper pour vider tous les caches liés aux produits
     */
    private function clearProduitCache()
    {
        // On vide les compteurs
        Cache::forget('produits_total_count');
        Cache::forget('pharma_count');
        Cache::forget('materiel_count');
        Cache::forget('anesthesiste_count');

        // Note: Pour vider les paginations, il est souvent plus simple d'utiliser
        // des tags de cache si votre driver le supporte (Redis/Memcached).
        // Sinon, on peut forcer l'expiration courte (600s) comme fait plus haut.
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $produits = Produit::where('designation', 'LIKE', "%{$query}%")
            ->where('qte_stock', '>', 0)
            ->select('id', 'designation', 'prix_unitaire', 'qte_stock')
            ->limit(10)
            ->get();

        return response()->json($produits);
    }
}
