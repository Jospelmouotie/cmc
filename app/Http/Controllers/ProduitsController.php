<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProduitRequest;
use App\Models\Cart;
use App\Models\Facture;
use App\Models\Patient;
use App\Models\Produit;
use App\Services\PdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
// use Illuminate\Support\Facades\Input;
use ZanySoft\LaravelPDF\Facades\PDF;

class ProduitsController extends Controller
{
    public function index()
    {
        $cacheKey = 'produits_page_'.request('page', 1);

        $produits = Cache::remember($cacheKey, 600, function () {
            return Produit::select(['id', 'designation', 'categorie', 'qte_stock', 'qte_alerte', 'prix_unitaire'])
            // ->get()
                ->orderBy('created_at', 'asc')
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
        // 1. Débogage : Décommente la ligne suivante pour voir si les données arrivent bien du formulaire
        // dd($request->all(), Session::get('cart'));

        if (! Session::has('cart')) {
            return redirect()->back()->with('error', 'Le panier est vide.');
        }

        // Validation des données du formulaire
        $request->validate([
            'patient' => 'required', // Nom ou ID envoyé par ton select
            // 'mode_paiement' => 'required' // Décommente si tu as ajouté ce champ
        ]);

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        try {
            // Début de la transaction pour sécuriser la base de données
            $facture = DB::transaction(function () use ($cart, $request) {

                // A. Création de la facture
                $facture = new Facture;
                $facture->numero = 'PH-'.time();

                // On cherche l'ID du patient par son nom (puisque ton select envoie le nom)
                $patient = Patient::where('name', $request->patient)->first();
                $facture->patient_id = $patient ? $patient->id : null;

                $facture->prix_total = $cart->totalPrix;
                $facture->user_id = Auth::id();
                $facture->statut = 'Payée';
                $facture->save();

                // B. Boucle sur les produits du panier
                foreach ($cart->items as $item) {
                    // On extrait l'ID de manière brute pour être sûr qu'aucun objet ne passe
                    $produitIdRaw = is_array($item['item']) ? $item['item']['id'] : $item['item']->id;
                    $qty = $item['qty'];

                    $produit = Produit::lockForUpdate()->find($produitIdRaw);

                    if (! $produit || $produit->qte_stock < $qty) {
                        throw new \Exception('Stock insuffisant pour : '.($produit->designation ?? 'Produit inconnu'));
                    }

                    // 🛡️ FORCE L'ID EN ENTIER (Correction de l'erreur SQL 1366)
                    // C. Insertion dans la table pivot 'facture_produit'
                    $facture->produits()->attach($produitIdRaw, [
                        'item' => (int) $produitIdRaw, // Force l'ID en entier
                        'prix_unitaire' => $item['item']['prix_unitaire'],
                        'quantite' => (int) $qty,
                        'produit_id' => (int) $produitIdRaw,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $produit->decrement('qte_stock', $qty);
                }

                return $facture;
            });

            // 2. Préparation des données pour le PDF avant de vider le panier
            $produitsData = [];
            foreach ($cart->items as $item) {
                $produitsData[] = (object) [
                    'designation' => $item['item']['designation'],
                    'prix_unitaire' => $item['item']['prix_unitaire'],
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                ];
            }

            $patientName = $request->patient;

            // 3. Nettoyage
            Cache::flush();
            Session::forget('cart');

            // 🚀 GÉNÉRATION ET TÉLÉCHARGEMENT DU PDF
            // On utilise ob_end_clean pour éviter les caractères parasites dans le fichier
            if (ob_get_length()) {
                ob_end_clean();
            }

            return PdfService::generate('admin.etats.pharmacie', [
                'patient' => $patientName,
                'produits' => $produitsData,
                'totalPrix' => $cart->totalPrix,
                'totalQte' => $cart->totalQte,
                'facture' => $facture,
            ], 'facture_pharmacie_'.$facture->numero.'.pdf');

        } catch (\Exception $e) {
            Log::error('Erreur Facturation : '.$e->getMessage());

            // Décommente pour voir l'erreur exacte si ça plante
            // dd("Erreur : " . $e->getMessage());

            return redirect()->back()->with('error', 'Erreur lors de la facturation : '.$e->getMessage());
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
            $produit->update(array_merge(
                $request->validated(),
                ['user_id' => Auth::id()]
            ));

            Cache::forget('produits_page_1');
            Cache::forget('produits_count');
            Cache::forget($produit->categorie.'_count');
        });

        return redirect()->route('produits.index')
            ->with('success', 'Le produit a été mis à jour avec succès !');
    }

    public function destroy(Produit $produit)
    {
        $this->authorize('delete', $produit);

        DB::transaction(function () use ($produit) {
            $produit->delete();
            Cache::forget('produit_page_1');
            Cache::forget('produits_count');
            Cache::forget($produit->categorie.'_count');
        });

        return redirect()->route('produits.index')->with('success', 'Le produit a bien été supprimé');
    }

    public function stock_pharmaceutique()
    {
        $cacheKey = 'produits_pharma_page_'.request('page', 1);

        $produits = Cache::remember(''.$cacheKey, 600, function () {
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
        $cacheKey = 'produits_materiel_page_'.request('page', 1);
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
        //        $this->authorize('anesthesiste', Produit::class);
        //        $this->authorize('update', Produit::class);
        $cacheKey = 'produits_anesthesiste_page_'.request('page', 1);
        $produits = Cache::remember($cacheKey, 600, function () {
            return Produit::where('categorie', 'ANESTHESISTE')
                ->select('id', 'designation', 'qte_stock', 'qte_alerte', 'prix_unitaire')
                ->orderBy('designation')
                ->paginate(50);

        });
        $pharmaCount = Cache::remember('anesthesiste_count', 3600, function () {
            return Produit::where('categorie', 'ANESTHESISTE')->count();
        });

        // return view('admin.produits.anesthesiste', array_merge(['produits' => $produits], ['pharmaCount' => $pharmaCount]));
        return view('admin.produits.anesthesiste', compact('produits', 'pharmaCount'));

    }

    public function add_to_cart(Request $request, $id)
    {
        $produit = Produit::select(['id', 'designation', 'qte_stock', 'qte_alerte', 'prix_unitaire', 'categorie'])
            ->findOrFail($id);

        if ($produit->qte_stock == 0) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Le produit n\'est plus disponible en stock',
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
                'totalQte' => $cart->totalQte,
            ]);
        }

        flash()->success("La facture vient d'être mise à jour");

        return redirect()->route('pharmaceutique.facturation');
    }

    public function facturation()
    {
        // On récupère les patients pour le menu déroulant
        $patients = Patient::select('id', 'name', 'prenom')->orderBy('name')->get();

        if (! Session::has('cart')) {
            return view('admin.produits.facturation', [
                'produit' => collect(),
                'produits' => [],
                'totalPrix' => 0,
                'patient' => $patients,
            ]);
        }

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        // On récupère les détails des produits présents dans le panier
        $produitIds = array_keys($cart->items);
        $produit = Produit::whereIn('id', $produitIds)->get();

        return view('admin.produits.facturation', [
            'produit' => $produit,
            'produits' => $cart->items,
            'totalPrix' => $cart->totalPrix,
            'patient' => $patients,
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
                'totalQte' => $cart->totalQte,
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
                    'totalQte' => $cart->totalQte,
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
                    'cartEmpty' => true,  // Add this flag
                ]);
            }
        }

        flash()->info('Le produit a bien été supprimé de la facture');

        return redirect()->route('pharmaceutique.facturation');
    }

public function export_pdf(Request $request)
{
    set_time_limit(120);
    ini_set('memory_limit', '256M');

    try {
        if (!Session::has('cart')) {
            return redirect()->route('pharmaceutique.facturation')->with('error', 'Votre panier est vide');
        }

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $patientName = $request->input('patient');

        $facture = DB::transaction(function () use ($cart, $patientName) {
            $f = Facture::create([
                'numero' => mt_rand(10000, 999999),
                'quantite_total' => $cart->totalQte,
                'prix_total' => $cart->totalPrix,
                'patient' => $patientName,
                'user_id' => auth()->user()->id,
            ]);

            // Préparation des données pivot pour éviter l'erreur SQL "Incorrect integer value"
            $pivotData = [];
            foreach ($cart->items as $id => $item) {
                // Utilisation de ?? 0 pour éviter l'erreur "Undefined array key"
                $qte = $item['qty'] ?? ($item['quantite'] ?? 0);

                $pivotData[$id] = [
                    'item'          => (int)$id,
                    'prix_unitaire' => $item['item']['prix_unitaire'] ?? 0,
                    'quantite'      => $qte,
                    'produit_id'    => (int)$id,
                    'created_at'    => now(),
                    'updated_at'    => now()
                ];
            }
            $f->produits()->attach($pivotData);

            return $f;
        });

        // Conversion sécurisée des items pour la vue PDF
        $produits = collect();
        foreach ($cart->items as $item) {
            $produits->push((object) [
                'designation'   => $item['item']['designation'] ?? 'N/A',
                'prix_unitaire' => $item['item']['prix_unitaire'] ?? 0,
                'qty'           => $item['qty'] ?? ($item['quantite'] ?? 0),
                'price'         => $item['price'] ?? 0,
            ]);
        }

        if (ob_get_length()) ob_end_clean();

        $filename = 'pharmacie_'.$facture->numero.'.pdf';
        Session::forget('cart');

        return PdfService::generate('admin.etats.pharmacie', [
            'patient'   => $patientName,
            'produits'  => $produits,
            'totalPrix' => $cart->totalPrix,
            'totalQte'  => $cart->totalQte,
            'facture'   => $facture,
        ], $filename);

    } catch (\Exception $e) {
        Log::error('Pharmacie PDF Error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Erreur lors de la génération : ' . $e->getMessage());
    }
}

    public function generatePdf(Request $request)
    {
        // 1. Vérifier si le panier existe en session
        if (! Session::has('cart')) {
            return redirect()->back()->with('error', 'Le panier est vide, impossible de générer une facture.');
        }

        // 2. Récupérer le nom du patient depuis le formulaire
        $patientName = $request->input('patient');
        if (! $patientName) {
            return redirect()->back()->with('error', 'Veuillez sélectionner un patient avant d\'imprimer.');
        }

        try {
            $cart = new Cart(Session::get('cart'));

            // --- LOGIQUE D'ENREGISTREMENT (Optionnel si tu ne l'as pas déjà fait) ---
            // On crée une facture en base de données pour avoir un numéro officiel
            $facture = DB::transaction(function () use ($cart, $request) {
                $f = new Facture;
                $f->numero = 'PH-'.strtoupper(uniqid());
                $f->patient_id = Patient::where('name', $request->input('patient'))->first()->id ?? null;
                $f->prix_total = $cart->totalPrix;
                $f->user_id = Auth::id();
                $f->save();

                return $f;
            });

            // 3. Préparer les données pour la vue PDF
            $produitsData = [];
            foreach ($cart->items as $item) {
                $produitsData[] = [
                    'designation' => $item['item']['designation'],
                    'prix_unitaire' => $item['item']['prix_unitaire'],
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                ];
            }

            // 4. Générer le PDF via ton service
            return PdfService::generate('admin.etats.pharmacie', [
                'patient' => $patientName,
                'produits' => $produitsData,
                'totalPrix' => $cart->totalPrix,
                'totalQte' => $cart->totalQte,
                'facture' => $facture,
            ], 'facture_'.$facture->numero.'.pdf');

        } catch (\Exception $e) {
            Log::error('Erreur Impression PDF : '.$e->getMessage());

            return redirect()->back()->with('error', 'Erreur lors de la génération du PDF : '.$e->getMessage());
        }
    }
}
