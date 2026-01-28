<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Facture;
use App\Http\Requests\ProduitRequest;
use App\Models\Patient;
use App\Models\Produit;
use ZanySoft\LaravelPDF\Facades\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\Input;
use App\Services\PdfService;
use Illuminate\Support\Facades\Validator;

class ProduitsController extends Controller
{
    public function index()
    {
        $cacheKey = 'produits_page_' . request('page', 1);

        $produits = Cache::remember($cacheKey,600, function () {
            return Produit::select(['id', 'designation', 'categorie', 'qte_stock', 'qte_alerte', 'prix_unitaire'])
            // ->get()
            ->orderBy('created_at','asc')
            ->paginate(50);
        });
        // Cache product count
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
    $this->authorize('create', Produit::class);

    $request->validate([
        'designation'   => ['required', 'unique:produits'],
        'categorie'     => 'required|string',
        'qte_alerte'    => 'required|integer|min:0', // Force un entier positif
        'qte_stock'     => 'required|integer|min:0',  // Force un entier positif
        'prix_unitaire' => 'required|integer|min:0'
    ]);

    DB::transaction(function () use ($request) {
        $produit = Produit::create([
            'designation'   => $request->get('designation'),
            'categorie'     => $request->get('categorie'),
            'qte_stock'     => $request->get('qte_stock'),
            'qte_alerte'    => $request->get('qte_alerte'),
            'prix_unitaire' => $request->get('prix_unitaire'),
            'user_id'       => Auth::id(),
        ]);

        Cache::forget('produits_page_1');
        Cache::forget('produits_count');
        Cache::forget($produit->categorie . '_count');
    });

    return redirect()->route('produits.index')->with('success', 'Le produit a été ajouté avec succès !');
}
    public function edit(Produit $produit)
    {
        $this->authorize('create', Produit::class);

//        $produit = Produit::find($id);

        return view('admin.produits.edit', compact('produit'));
    }


  public function update(Request $request, Produit $produit)
{
    $this->authorize('update', $produit);

    // On ne valide que la quantité car c'est le seul champ modifiable
    $request->validate([
        'qte_stock' => 'required|integer|min:0'
    ]);

    $ajoutStock = $request->input('qte_stock');
    $stockActuel = $produit->qte_stock;

    DB::transaction(function () use ($produit, $ajoutStock, $stockActuel) {
        // Logique d'addition : on ajoute la nouvelle saisie au stock existant
        $produit->qte_stock = $stockActuel + $ajoutStock;
        $produit->user_id = Auth::id();
        $produit->save();

        Cache::forget('produits_page_1');
        Cache::forget($produit->categorie . '_count');
    });

    return redirect()->route('produits.index')->with('success', 'Le stock a été mis à jour avec succès !');
}

    public function destroy(Produit $produit)
    {
        $this->authorize('delete', $produit);

        DB::transaction(function () use ($produit) {
            $produit->delete();
            Cache::forget('produit_page_1');
            Cache::forget('produits_count');
            Cache::forget($produit->categorie . '_count');
        });

        return redirect()->route('produits.index')->with('success', 'Le produit a bien été supprimé');
    }

     public function stock_pharmaceutique()
    {
        $cacheKey = 'produits_pharma_page_' . request('page', 1);

        $produits= Cache::remember(''. $cacheKey, 600, function () {
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
        $cacheKey = 'produits_materiel_page_' . request('page', 1);
        $produits = Cache::remember( $cacheKey, 600, function () {

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
//        $this->authorize('anesthesiste', Produit::class);
//        $this->authorize('update', Produit::class);
        $cacheKey = 'produits_anesthesiste_page_' . request('page', 1);
        $produits = Cache::remember( $cacheKey, 600, function () {
            return Produit::where('categorie', 'ANESTHESISTE')
                ->select('id', 'designation', 'qte_stock', 'qte_alerte', 'prix_unitaire')
                ->orderBy('designation')
                ->paginate(50);

            });
            $pharmaCount = Cache::remember('anesthesiste_count', 3600, function () {
                return Produit::where('categorie', 'ANESTHESISTE')->count();
            });

        // return view('admin.produits.anesthesiste', array_merge(['produits' => $produits], ['pharmaCount' => $pharmaCount]));
        return view('admin.produits.anesthesiste', compact('produits' , 'pharmaCount'));

    }

    public function add_to_cart(Request $request, $id)
    {
        $produit = Produit::select(['id', 'designation', 'qte_stock', 'qte_alerte', 'prix_unitaire', 'categorie'])
            ->findOrFail($id);

        if ($produit->qte_stock == 0) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Le produit n\'est plus disponible en stock'
                ]);
            }

            $route = auth()->user()->role_id === 7
                ? 'produits.pharmaceutique'
                : 'produits.anesthesiste';

            return redirect()->route($route)
                ->with('error', 'Le produit n\'est plus disponible en stock');
        }

        $oldCart = Session::get('cart', null);
        $cart = new Cart($oldCart);
        $cart->add($produit, $produit->id);

        $request->session()->put('cart', $cart);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'items' => $cart->items,
                'totalPrix' => $cart->totalPrix,
                'totalQte' => $cart->totalQte
            ]);
        }

        flash()->success("La facture vient d'être mise à jour");
        return redirect()->route('pharmaceutique.facturation');
    }

    public function facturation()
    {

        if(!Session::has('cart')){

            return view('admin.produits.facturation');
        }

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $produit = Produit::whereIn('id', array_keys($cart->items))->get();
        $patient = Patient::all();

        return view('admin.produits.facturation',
            [
                'produit' => $produit,
                'produits' => $cart->items,
                'totalPrix' => $cart->totalPrix,
                'patient' => $patient
            ]);
    }

    public function getReduceByOne(Request $request, $id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->reduceByOne($id);

        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'items' => $cart->items,
                'totalPrix' => $cart->totalPrix,
                'totalQte' => $cart->totalQte
            ]);
        }

        flash()->success("La facture vient d'être mise à jour");
        return redirect()->route('pharmaceutique.facturation');
    }

    public function getRemoveItem(Request $request, $id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);

        if (count($cart->items) > 0) {
            Session::put('cart', $cart);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'items' => $cart->items,
                    'totalPrix' => $cart->totalPrix,
                    'totalQte' => $cart->totalQte
                ]);
            }
        } else {
            Session::forget('cart');

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'items' => [],
                    'totalPrix' => 0,
                    'totalQte' => 0,
                    'cartEmpty' => true  // Add this flag
                ]);
            }
        }

        flash()->info("Le produit a bien été supprimé de la facture");
        return redirect()->route('pharmaceutique.facturation');
    }


    public function export_pdf(Request $request, Produit $produit, Patient $patient)
    {
        set_time_limit(120);
        ini_set('memory_limit', '256M');

        try {
            if (!Session::has('cart')) {
                return redirect()->route('pharmaceutique.facturation')
                    ->with('error', 'Votre panier est vide');
            }

            $oldCart = Session::get('cart');
            $cart = new Cart($oldCart);

            $patientName = $request->input('patient');

            $facture = DB::transaction(function () use ($cart, $patientName) {
                $facture = Facture::create([
                    'numero' => mt_rand(10000, 999999),
                    'quantite_total' => $cart->totalQte,
                    'prix_total' => $cart->totalPrix,
                    'patient' => $patientName,
                    'user_id' => auth()->user()->id,
                ]);

                $facture->produits()->attach($cart->items);

                return $facture;
            });

            // Convert cart items to collection of objects
            $produits = collect();
            foreach ($cart->items as $item) {
                $produits->push((object)[
                    'designation' => $item['item']['designation'] ?? 'N/A',
                    'prix_unitaire' => $item['item']['prix_unitaire'] ?? 0,
                    'qty' => $item['qty'] ?? 0,
                    'price' => $item['price'] ?? 0,
                ]);
            }

            // Clear any existing output
            if (ob_get_length()) {
                ob_end_clean();
            }

            // PdfService options
            $orientation = request()->input('orientation', 'portrait');
            $format = request()->input('format', 'A4');
            $delivery = request()->input('delivery', 'stream');

            $filename = 'pharmacie_' . $facture->numero . '.pdf';

            // Clear cart after building data
            Session::forget('cart');

            return PdfService::generate('admin.etats.pharmacie', [
                'patient' => $patientName,
                'produits' => $produits,
                'totalPrix' => $cart->totalPrix,
                'totalQte' => $cart->totalQte,
                'facture' => $facture,
            ], $filename, $orientation, $format, $delivery);

        } catch (\Exception $e) {
            Log::error('Pharmacie PDF Error: ' . $e->getMessage());

            if (ob_get_length()) {
                ob_end_clean();
            }

            return redirect()->back()->with('error', 'Erreur lors de la génération de la facture pharmacie');
        }
    }


/**
 * Recherche de produits pour l'autocomplétion des devis
 */
public function search(\Illuminate\Http\Request $request)
{
    $query = $request->get('q');

    // Recherche dans la désignation
    // Ajuste 'designation' par le nom exact de ta colonne en base de données
    $produits = \App\Models\Produit::where('designation', 'LIKE', "%{$query}%")
        ->select('id', 'designation', 'prix_unitaire', 'qte_stock')
        ->where('qte_stock', '>', 0) // Optionnel: ne montrer que ce qui est en stock
        ->limit(10)
        ->get();

    return response()->json($produits);
}


}









