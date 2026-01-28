<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Devi;
use App\Models\LigneDevi;
use App\Models\DevisElement;
use App\Models\User;
use App\Models\Produit;
use App\Models\FicheConsommable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class DevisController extends Controller
{
    /**
     * Display a listing of devis
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role_id == 3) {
            $devis = Devi::with(['patient:id,name,prenom', 'medecin:id,name,prenom', 'ligneDevis'])
                ->latest()
                ->paginate(50);
        }
        elseif ($user->role_id == 2) {
            $devis = Devi::with(['patient:id,name,prenom', 'user:id,name', 'ligneDevis'])
                ->where('medecin_id', $user->id)
                ->latest()
                ->paginate(50);
        }
        else {
            $devis = Devi::with(['patient:id,name,prenom', 'medecin:id,name,prenom', 'user:id,name', 'ligneDevis'])
                ->latest()
                ->paginate(50);
        }

        $patients = Patient::orderBy('created_at', 'DESC')
            ->select('id', 'name', 'prenom', 'medecin_r')
            ->get();

        $medecins = User::where('role_id', 2)
            ->orderBy('name')
            ->select('id', 'name', 'prenom')
            ->get();

        return view('admin.devis.index', compact('devis', 'patients', 'medecins'));
    }

    /**
     * Store a newly created devis
     */
 public function store(Request $request)
{
    $this->authorize('create', Devi::class);

    $request->validate([
        'patient_id' => 'required|exists:patients,id',
        'code_devis' => 'nullable|string',
        'nbr_chambre' => 'required|numeric|min:0',
        'nbr_visite' => 'required|numeric|min:0',
        'nbr_ami_jour' => 'required|numeric|min:0',
        'pu_chambre' => 'required|numeric|min:0',
        'pu_visite' => 'required|numeric|min:0',
        'pu_ami_jour' => 'required|numeric|min:0',
        'nom_devis' => 'required|string',
        'acces_devis' => 'required|in:acte,bloc',
        'ligneDevi' => 'array|required|min:1',
        'ligneDevi.*.element' => 'required|string',
        'ligneDevi.*.quantite' => 'required|numeric|min:1',
        'ligneDevi.*.prix_u' => 'required|numeric|min:0',
        'ligneDevi.*.type' => 'nullable|in:procedure,medication,material,anesthesie',
        'ligneDevi.*.produit_id' => 'nullable|exists:produits,id',
    ]);

    try {
        $devis = DB::transaction(function () use ($request) {
            $patient = Patient::findOrFail($request->input('patient_id'));
            $medecin = $this->findMedecinByName($patient->medecin_r);

            // 1. Création du Devis
            $devis = Devi::create([
                'nom' => $request->input('nom_devis'),
                'patient_id' => $patient->id,
                'medecin_id' => $medecin ? $medecin->id : null,
                'nbr_chambre' => $request->input('nbr_chambre'),
                'nbr_visite' => $request->input('nbr_visite'),
                'nbr_ami_jour' => $request->input('nbr_ami_jour'),
                'pu_chambre' => $request->input('pu_chambre'),
                'pu_visite' => $request->input('pu_visite'),
                'pu_ami_jour' => $request->input('pu_ami_jour'),
                'code' => $request->input('code_devis') ?? now()->format('Ymd') . '/' . strtoupper(substr($request->input('nom_devis'), 0, 4)),
                'acces' => $request->input('acces_devis'),
                'statut' => 'brouillon',
                'user_id' => Auth::id(),
            ]);

            // 2. Traitement des lignes de devis
            foreach ($request->input('ligneDevi') as $ligneData) {
                $type = $ligneData['type'] ?? 'procedure';
                $produitId = $ligneData['produit_id'] ?? null;

                // Vérification du stock en temps réel si c'est un produit
                if ($produitId) {
                    $produit = Produit::find($produitId);
                    if ($produit && $produit->qte_stock < $ligneData['quantite']) {
                        throw new \Exception("Stock insuffisant pour {$produit->designation}. Disponible: {$produit->qte_stock}");
                    }
                }

                // Création de la ligne
                $devis->ligneDevis()->create([
                    'type' => $type,
                    'element' => $ligneData['element'],
                    'quantite' => $ligneData['quantite'],
                    'prix_u' => $ligneData['prix_u'],
                    'produit_id' => $produitId,
                    'stock_deducted' => false, // Ne sera déduit qu'à la validation médicale
                ]);

                // Enregistrement comme élément réutilisable (si c'est une procédure)
                if ($type === 'procedure') {
                    DevisElement::firstOrCreate(
                        ['nom' => $ligneData['element']],
                        [
                            'prix_unitaire' => $ligneData['prix_u'],
                            'actif' => true,
                            'user_id' => Auth::id()
                        ]
                    );
                }
            }

            // 3. Calcul automatique des montants totaux
            $devis->montant_avant_reduction = $devis->calculerMontantAvantReduction();
            $devis->montant_apres_reduction = $devis->montant_avant_reduction;
            $devis->save();

            // 4. Nettoyage du cache (Simple forget car File/DB ne supportent pas les tags)
            Cache::forget('devis_list');
            Cache::forget('devis_elements_actifs');

            return $devis;
        });

        Log::info("Devis #{$devis->id} créé par l'utilisateur " . Auth::id());

        return redirect()->route('devis.index')
            ->with('success', 'Devis créé avec succès !');

    } catch (\Exception $e) {
        Log::error('Erreur Store Devis: ' . $e->getMessage());

        return redirect()->back()
            ->withInput()
            ->with('error', 'Erreur : ' . $e->getMessage());
    }
}

    /**
     * Update existing devis
     */
    public function edit(Request $request, $id)
    {
        $this->authorize('update', Devi::class);

        $request->validate([
            'code_devis' => 'nullable|string',
            'nbr_chambre' => 'required|numeric|min:0',
            'nbr_visite' => 'required|numeric|min:0',
            'nbr_ami_jour' => 'required|numeric|min:0',
            'pu_chambre' => 'required|numeric|min:0',
            'pu_visite' => 'required|numeric|min:0',
            'pu_ami_jour' => 'required|numeric|min:0',
            'nom_devis' => 'required|string',
            'acces_devis' => 'required|in:acte,bloc',
            'ligneDevi' => 'array|required',
            'ligneDevi.*.element' => 'required|string',
            'ligneDevi.*.quantite' => 'required|numeric|min:1',
            'ligneDevi.*.prix_u' => 'required|numeric|min:0',
            'ligneDevi.*.type' => 'nullable|in:procedure,medication,material,anesthesie',
            'ligneDevi.*.produit_id' => 'nullable|exists:produits,id',
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                $devi = Devi::findOrFail($id);

                if ($devi->statut == 'valide') {
                    throw new \Exception('Ce devis est déjà validé et ne peut plus être modifié');
                }

                $devi->update([
                    'nom' => $request->input('nom_devis'),
                    'nbr_chambre' => $request->input('nbr_chambre'),
                    'nbr_visite' => $request->input('nbr_visite'),
                    'nbr_ami_jour' => $request->input('nbr_ami_jour'),
                    'pu_chambre' => $request->input('pu_chambre'),
                    'pu_visite' => $request->input('pu_visite'),
                    'pu_ami_jour' => $request->input('pu_ami_jour'),
                    'code' => $request->input('code_devis') ?? now()->format('Ymd') . '/' . substr($request->input('nom_devis'), 0, 4),
                    'acces' => $request->input('acces_devis'),
                ]);

                // Delete old lines
                LigneDevi::where('devi_id', $id)->delete();

                // Create new lines
                $lignedevis = $request->input('ligneDevi');
                foreach ($lignedevis as $ligneDevi) {
                    $type = $ligneDevi['type'] ?? 'procedure';
                    $produitId = $ligneDevi['produit_id'] ?? null;

                    // Validate stock for products
                    if ($produitId) {
                        $produit = Produit::find($produitId);
                        if ($produit && $produit->qte_stock < $ligneDevi['quantite']) {
                            throw new \Exception("Stock insuffisant pour {$produit->designation}");
                        }
                    }

                    $devi->ligneDevis()->create([
                        'type' => $type,
                        'element' => $ligneDevi['element'],
                        'quantite' => $ligneDevi['quantite'],
                        'prix_u' => $ligneDevi['prix_u'],
                        'produit_id' => $produitId,
                        'stock_deducted' => false,
                    ]);
                }

                // Recalculate totals
                $devi->montant_avant_reduction = $devi->calculerMontantAvantReduction();
                $devi->montant_apres_reduction = $devi->calculerMontantApresReduction();
                $devi->save();

                Cache::forget('devis_list');
                Cache::tags(['devis'])->flush();
            });

            return redirect()->route('devis.index')
                ->with('success', 'Devis modifié avec succès !');

        } catch (\Exception $e) {
            Log::error('Devis Edit Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }



    /**
     * Delete devis - NOW WITH STOCK RESTORATION
     */
    public function destroy($id)
    {
        $this->authorize('delete', Devi::class);

        try {
            DB::transaction(function () use ($id) {
                $devis = Devi::with('ligneDevis.produit')->findOrFail($id);

                // Only allow deletion of brouillon or refused devis
                if (!in_array($devis->statut, ['brouillon', 'refuse'])) {
                    throw new \Exception('Seuls les devis en brouillon ou refusés peuvent être supprimés');
                }

                // RESTORE STOCK if it was deducted
                if ($devis->statut === 'refuse') {
                    foreach ($devis->ligneDevis as $ligne) {
                        if ($ligne->isProduct() && $ligne->produit_id && $ligne->stock_deducted) {
                            $produit = $ligne->produit;
                            $produit->qte_stock += $ligne->quantite;
                            $produit->save();

                            Log::info('Stock restored after devis deletion', [
                                'devis_id' => $devis->id,
                                'produit_id' => $produit->id,
                                'quantite_restored' => $ligne->quantite
                            ]);
                        }
                    }
                }

                // Delete line items first
                $devis->ligneDevis()->delete();

                // Delete the devis
                $devis->delete();

                Log::info('Devis deleted', [
                    'devis_id' => $id,
                    'deleted_by' => Auth::id()
                ]);
            });

            Cache::forget('devis_list');
            Cache::tags(['devis'])->flush();

            return redirect()->route('devis.index')
                ->with('success', 'Devis supprimé avec succès !');

        } catch (\Exception $e) {
            Log::error('Delete Devis Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }


    /**
     * Send devis for validation to doctor
     */
    public function envoyerValidation($id)
    {
        $this->authorize('update', Devi::class);

        try {
            $devis = Devi::with('medecin')->findOrFail($id);

            if ($devis->statut != 'brouillon') {
                return redirect()->back()
                    ->with('error', 'Ce devis a déjà été envoyé');
            }

            // VALIDATION: Must have an assigned doctor
            if (!$devis->medecin_id) {
                return redirect()->back()
                    ->with('error', 'Impossible d\'envoyer : aucun médecin assigné à ce patient');
            }

            $devis->envoyerValidation();

            Log::info('Devis sent for validation', [
                'devis_id' => $devis->id,
                'medecin_id' => $devis->medecin_id,
                'medecin_name' => $devis->medecin ? "{$devis->medecin->name} {$devis->medecin->prenom}" : 'Unknown'
            ]);

            return redirect()->route('devis.index')
                ->with('success', 'Devis envoyé au médecin pour validation !');

        } catch (\Exception $e) {
            Log::error('Devis Send Validation Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erreur lors de l\'envoi');
        }
    }

    /**
     * Unvalidate devis (by doctor)
     */
    public function annulerValidation($id)
    {
        try {
            $devis = Devi::findOrFail($id);

            // AUTHORIZATION: Only the assigned doctor can undo validation
            if ($devis->medecin_id != Auth::id()) {
                return redirect()->back()
                    ->with('error', 'Non autorisé : vous n\'êtes pas le médecin assigné à ce devis');
            }

            if ($devis->statut != 'valide') {
                return redirect()->back()
                    ->with('error', 'Ce devis n\'est pas validé');
            }

            $devis->statut = 'en_attente';
            $devis->date_validation = null;
            $devis->save();

            return redirect()->route('devis.index')
                ->with('success', 'Validation annulée. Vous pouvez maintenant appliquer une réduction.');

        } catch (\Exception $e) {
            Log::error('Unvalidate Devis Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erreur lors de l\'annulation');
        }
    }

    /**
     * Cancel sending for validation (by gestionnaire)
     * Returns devis from "en_attente" back to "brouillon"
     */
    public function annulerEnvoi($id)
    {
        $this->authorize('update', Devi::class);

        try {
            $devis = Devi::findOrFail($id);

            // Only allow cancelling if status is "en_attente"
            if ($devis->statut != 'en_attente') {
                return redirect()->back()
                    ->with('error', 'Seuls les devis en attente peuvent être annulés');
            }

            // AUTHORIZATION: Only the gestionnaire who created can cancel
            if ($devis->user_id != Auth::id() && !Auth::user()->isAdmin()) {
                return redirect()->back()
                    ->with('error', 'Vous n\'êtes pas autorisé à annuler cet envoi');
            }

            // Return to brouillon status
            $devis->statut = 'brouillon';
            $devis->save();

            Log::info('Devis send cancelled', [
                'devis_id' => $devis->id,
                'cancelled_by' => Auth::id()
            ]);

            return redirect()->route('devis.index')
                ->with('success', 'Envoi annulé. Le devis est de nouveau en brouillon.');

        } catch (\Exception $e) {
            Log::error('Cancel Send Devis Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erreur lors de l\'annulation');
        }
    }



        /**
     * Cancel refusal and return to brouillon for re-editing (by gestionnaire)
     * Returns devis from "refuse" back to "brouillon"
     */
    public function annulerRefus($id)
    {
        $this->authorize('update', Devi::class);

        try {
            $devis = Devi::findOrFail($id);

            // Only allow cancelling if status is "refuse"
            if ($devis->statut != 'refuse') {
                return redirect()->back()
                    ->with('error', 'Seuls les devis refusés peuvent être réinitialisés');
            }

            // AUTHORIZATION: Only the gestionnaire who created can cancel refusal
            if ($devis->user_id != Auth::id() && !Auth::user()->isAdmin()) {
                return redirect()->back()
                    ->with('error', 'Vous n\'êtes pas autorisé à modifier ce devis');
            }

            // Return to brouillon status (clear refusal data)
            $devis->annulerRefus();

            Log::info('Devis refusal cancelled', [
                'devis_id' => $devis->id,
                'cancelled_by' => Auth::id(),
                'previous_comment' => $devis->commentaire_medecin
            ]);

            return redirect()->route('devis.index')
                ->with('success', 'Refus annulé. Vous pouvez maintenant modifier et renvoyer le devis.');

        } catch (\Exception $e) {
            Log::error('Cancel Refusal Devis Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erreur lors de l\'annulation du refus');
        }
    }



    /**
     * Apply reduction (by doctor) - DEDUCT STOCK HERE
     */


    public function appliquerReduction(Request $request, $id)
    {
        // First find the devis
        $devis = Devi::findOrFail($id);

        // Then authorize with the devis instance
        $this->authorize('applyReduction', $devis);

        $request->validate([
            'pourcentage_reduction' => 'required|integer|min:0|max:100|in:0,5,10,15,20,25,30,35,40,45,50',
            'commentaire' => 'nullable|string'
        ]);

        try {
            // AUTHORIZATION: Only the assigned doctor can apply reduction
            if ($devis->medecin_id != Auth::id()) {
                return redirect()->back()
                    ->with('error', 'Vous n\'êtes pas autorisé à modifier ce devis (médecin non assigné)');
            }

            // Apply reduction
            $devis->pourcentage_reduction = $request->input('pourcentage_reduction');
            $devis->montant_apres_reduction = $devis->calculerMontantApresReduction();
            $devis->commentaire_medecin = $request->input('commentaire');
            $devis->save();

            Log::info('Reduction applied', [
                'devis_id' => $devis->id,
                'medecin_id' => Auth::id(),
                'reduction' => $request->input('pourcentage_reduction')
            ]);

            return redirect()->route('devis.index')
                ->with('success', 'Réduction appliquée avec succès !');

        } catch (\Exception $e) {
            Log::error('Apply Reduction Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erreur lors de l\'application de la réduction');
        }
    }

    /**
     * Validate devis (by doctor)
     */
    public function valider(Request $request, $id)
    {
        $request->validate([
            'commentaire' => 'nullable|string'
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                $devis = Devi::with('ligneDevis.produit')->findOrFail($id);

                // AUTHORIZATION: Only the assigned doctor can validate
                if ($devis->medecin_id != Auth::id()) {
                    throw new \Exception('Vous n\'êtes pas autorisé à valider ce devis');
                }

                // Deduct stock for products
                foreach ($devis->ligneDevis as $ligne) {
                    if ($ligne->isProduct() && $ligne->produit_id && !$ligne->stock_deducted) {
                        $produit = $ligne->produit;

                        if ($produit->qte_stock < $ligne->quantite) {
                            throw new \Exception("Stock insuffisant pour {$produit->designation}. Disponible: {$produit->qte_stock}, Requis: {$ligne->quantite}");
                        }

                        $produit->qte_stock -= $ligne->quantite;
                        $produit->save();

                        // Mark as deducted
                        $ligne->stock_deducted = true;
                        $ligne->save();

                        Log::info('Stock deducted for devis validation', [
                            'devis_id' => $devis->id,
                            'produit_id' => $produit->id,
                            'quantite' => $ligne->quantite,
                            'new_stock' => $produit->qte_stock
                        ]);
                    }
                }

                // Validate the devis
                $devis->valider(Auth::id(), $request->input('commentaire'));

                Log::info('Devis validated', [
                    'devis_id' => $devis->id,
                    'medecin_id' => Auth::id()
                ]);
            });

            return redirect()->route('devis.index')
                ->with('success', 'Devis validé avec succès ! Le stock a été mis à jour.');

        } catch (\Exception $e) {
            Log::error('Validate Devis Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Refuse devis (by doctor)
     */
    public function refuser(Request $request, $id)
    {
        $request->validate([
            'commentaire' => 'required|string'
        ]);

        try {
            $devis = Devi::findOrFail($id);

            // AUTHORIZATION: Only the assigned doctor can refuse
            if ($devis->medecin_id != Auth::id()) {
                return redirect()->back()
                    ->with('error', 'Vous n\'êtes pas autorisé à refuser ce devis');
            }

            $devis->refuser(Auth::id(), $request->input('commentaire'));

            Log::info('Devis refused', [
                'devis_id' => $devis->id,
                'medecin_id' => Auth::id()
            ]);

            return redirect()->route('devis.index')
                ->with('success', 'Devis refusé');

        } catch (\Exception $e) {
            Log::error('Refuse Devis Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erreur lors du refus');
        }
    }


     /**
     * Get patient consumed products (for import)
     */
    public function getPatientProducts($patientId)
    {
        try {
            $ficheConsommables = FicheConsommable::where('patient_id', $patientId)
                ->select('consommable', DB::raw('SUM(jour + nuit) as total_quantite'))
                ->groupBy('consommable')
                ->get();

            $products = [];

            foreach ($ficheConsommables as $fiche) {
                // Try exact match first
                $produit = Produit::where('designation', $fiche->consommable)->first();

                // If not found, try LIKE search
                if (!$produit) {
                    $produit = Produit::where('designation', 'LIKE', '%' . $fiche->consommable . '%')
                        ->first();
                }

                if ($produit) {
                    // Determine type based on category
                    $type = 'material';
                    if (strtolower($produit->categorie) === 'pharmaceutique') {
                        $type = 'medication';
                    } elseif (strtolower($produit->categorie) === 'anesthesiste') {
                        $type = 'anesthesie';
                    }

                    $products[] = [
                        'produit_id' => $produit->id,
                        'element' => $produit->designation,
                        'quantite' => $fiche->total_quantite,
                        'prix_u' => $produit->prix_unitaire,
                        'type' => $type,
                        'stock_available' => $produit->qte_stock
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'products' => $products
            ]);

        } catch (\Exception $e) {
            Log::error('Get Patient Products Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des produits'
            ], 500);
        }
    }


    /**
     * Search products (AJAX endpoint)
     */
    public function searchProducts(Request $request)
    {
        try {
            $query = $request->input('q', '');
            $category = $request->input('category', null);

            $products = Produit::select('id', 'designation', 'categorie', 'qte_stock', 'prix_unitaire')
                ->where('designation', 'LIKE', "%{$query}%")
                ->when($category, function($q) use ($category) {
                    return $q->where('categorie', $category);
                })
                ->where('qte_stock', '>', 0) // Only products in stock
                ->orderBy('designation')
                ->limit(20)
                ->get();

            return response()->json([
                'success' => true,
                'products' => $products
            ]);

        } catch (\Exception $e) {
            Log::error('Search Products Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la recherche'
            ], 500);
        }
    }

    /**
     * Get product details by ID (AJAX endpoint)
     */
    public function getProductDetails($id)
    {
        try {
            $produit = Produit::select('id', 'designation', 'categorie', 'qte_stock', 'prix_unitaire')
                ->findOrFail($id);

            // Determine type based on category
            $type = 'material';
            if (strtolower($produit->categorie) === 'pharmaceutique') {
                $type = 'medication';
            } elseif (strtolower($produit->categorie) === 'anesthesiste') {
                $type = 'anesthesie';
            }

            return response()->json([
                'success' => true,
                'product' => [
                    'id' => $produit->id,
                    'designation' => $produit->designation,
                    'type' => $type,
                    'stock' => $produit->qte_stock,
                    'prix_unitaire' => $produit->prix_unitaire
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Get Product Details Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Produit introuvable'
            ], 404);
        }
    }

    /**
     * Export devis to PDF
     */
    public function export_devis(Request $request, $montant_en_lettre)
    {
        try {
            $this->authorize('print', Devi::class);

            // **RELAXED VALIDATION for export (allow defaults)**
            $request->validate([
                'patient_id' => 'required|exists:patients,id',
                'nbr_chambre' => 'nullable|numeric|min:0',
                'nbr_visite' => 'nullable|numeric|min:0',
                'nbr_ami_jour' => 'nullable|numeric|min:0',
                'pu_chambre' => 'nullable|numeric|min:0',
                'pu_visite' => 'nullable|numeric|min:0',
                'pu_ami_jour' => 'nullable|numeric|min:0',
                'nom_devis' => 'required',
                'ligneDevi' => 'array|required|min:1', // **At least 1 line required**
                'ligneDevi.*.element' => 'required',
                'ligneDevi.*.quantite' => 'required|numeric|min:1',
                'ligneDevi.*.prix_u' => 'required|numeric|min:0',
            ]);

            // **Get patient object**
            $patient = Patient::findOrFail($request->input('patient_id'));

            $devisData = $request->all();

            // **Apply defaults for missing hospitalization fields**
            $devisData['nbr_chambre'] = $devisData['nbr_chambre'] ?? 0;
            $devisData['nbr_visite'] = $devisData['nbr_visite'] ?? 0;
            $devisData['nbr_ami_jour'] = $devisData['nbr_ami_jour'] ?? 0;
            $devisData['pu_chambre'] = $devisData['pu_chambre'] ?? 30000;
            $devisData['pu_visite'] = $devisData['pu_visite'] ?? 10000;
            $devisData['pu_ami_jour'] = $devisData['pu_ami_jour'] ?? 9000;

            $devisData['montant_en_lettre'] = $montant_en_lettre;
            $devisData['patient'] = $patient; // **Include full patient object**

            $previewId = 'devis_' . time() . '_' . uniqid();
            session(["devis_preview_{$previewId}" => $devisData]);

            return redirect()->route('print.preview', [
                'type' => 'devis',
                'id' => $previewId
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // **Better error reporting**
            Log::error('Devis Export Validation Failed', [
                'errors' => $e->errors(),
                'request_data' => $request->except(['_token'])
            ]);

            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Validation échouée: ' . implode(', ', array_keys($e->errors())));

        } catch (\Exception $e) {
            Log::error('Devis Preview Redirect Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Erreur lors de la préparation du devis');
        }
    }


    public function printExisting($id)
    {
        try {
            $this->authorize('print', Devi::class);

            $devis = Devi::with(['patient', 'ligneDevis'])->findOrFail($id);

            $montantEnLettre = NumberToLetter($devis->montant_apres_reduction);

            $previewId = 'devis_existing_' . $id . '_' . time();

            $devisData = [
                'patient' => $devis->patient,
                'patient_id' => $devis->patient_id,
                'nom_devis' => $devis->nom,
                'code_devis' => $devis->code,
                'acces_devis' => $devis->acces,
                'nbr_chambre' => $devis->nbr_chambre,
                'nbr_visite' => $devis->nbr_visite,
                'nbr_ami_jour' => $devis->nbr_ami_jour,
                'pu_chambre' => $devis->pu_chambre,
                'pu_visite' => $devis->pu_visite,
                'pu_ami_jour' => $devis->pu_ami_jour,
                'ligneDevi' => $devis->ligneDevis->toArray(),
                'montant_en_lettre' => $montantEnLettre
            ];

            session(["devis_preview_{$previewId}" => $devisData]);

            return redirect()->route('print.preview', [
                'type' => 'devis',
                'id' => $previewId
            ]);

        } catch (\Exception $e) {
            Log::error('Print Existing Devis Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de l\'impression du devis');
        }
    }


    /**
     * Find medecin by name
     * Handles name variations: "Dr. Name Prenom", "Name Prenom", etc.
     */
    private function findMedecinByName($medecinName)
    {
        if (!$medecinName) {
            return null;
        }

        $cleanName = preg_replace('/^(Dr\.?|Docteur)\s*/i', '', trim($medecinName));
        $parts = preg_split('/\s+/', $cleanName, -1, PREG_SPLIT_NO_EMPTY);

        if (empty($parts)) {
            return null;
        }

        $query = User::where('role_id', 2);

        if (count($parts) === 1) {
            $query->where(function($q) use ($parts) {
                $q->where('name', 'LIKE', "%{$parts[0]}%")
                  ->orWhere('prenom', 'LIKE', "%{$parts[0]}%");
            });
        } else if (count($parts) >= 2) {
            $nom = $parts[0];
            $prenom = implode(' ', array_slice($parts, 1));

            $query->where(function($q) use ($nom, $prenom) {
                $q->where(function($subQ) use ($nom, $prenom) {
                    $subQ->where('name', 'LIKE', "%{$nom}%")
                         ->where('prenom', 'LIKE', "%{$prenom}%");
                })
                ->orWhere(function($subQ) use ($nom, $prenom) {
                    $subQ->where('name', 'LIKE', "%{$prenom}%")
                         ->where('prenom', 'LIKE', "%{$nom}%");
                });
            });
        }

        return $query->first();
    }
}


