<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\FactureChambre;
use App\Models\FactureDevi;
use ZanySoft\LaravelPDF\Facades\PDF;
use App\Models\FactureConsultation;
use App\Models\FactureClient;
use App\Models\HistoriqueFacture;
use App\Models\Patient;
use App\Models\Produit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

// Import du service pour la génération PDF
use App\Services\PdfService;

class FactureController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view', User::class);
        $perPage = (int) $request->input('per_page', 50);
        $page = (int) $request->input('page', 1);

        $cacheKey = "factures.index.{$page}.{$perPage}";

        $factures = Cache::remember($cacheKey, 60, function () use ($perPage) {
            return Facture::select(['id', 'numero', 'patient', 'prix_total', 'created_at'])
                ->latest()
                ->paginate($perPage);
        });

        return view('admin.factures.index', compact('factures'));
    }

    public function destroy($id)
    {
        $this->authorize('view', User::class);
        $facture = FactureConsultation::findOrFail($id);

        DB::transaction(function () use ($facture) {
            $facture->delete();
        });

        Cache::tags(['factures'])->flush();
        return redirect()->action('FactureController@FactureConsultation')->with('info', 'La facture n° '.$id.' a bien été supprimée');
    }

    public function show(Facture $facture, Produit $produit)
    {
        return view('admin.factures.show', [
            'facture' => $facture
        ]);
    }

    public function FactureConsultation(Request $request)
    {
        $this->authorize('view', User::class);

        $startDate = $request->input('start-date')
            ? Carbon::parse($request->input('start-date'))->startOfDay()
            : Carbon::now()->startOfMonth();

        $endDate = $request->input('end-date')
            ? Carbon::parse($request->input('end-date'))->endOfDay()
            : Carbon::now()->endOfMonth();

        $lists = [];
        $currentDate = Carbon::now()->subMonths(3);
        while ($currentDate <= Carbon::now()) {
            $lists[] = $currentDate->format('Y-m-d');
            $currentDate->addDay();
        }
        $lists = array_reverse($lists);

        $perPage = (int) $request->input('per_page', 50);

        $factureConsultations = FactureConsultation::with([
                'patient:id,name,prenom,numero_dossier',
                'user:id,name'
            ])
            ->select([
                'id', 'numero', 'patient_id', 'user_id', 'montant',
                'avance', 'reste', 'statut', 'motif', 'created_at',
                'assurec', 'assurancec', 'mode_paiement', 'mode_paiement_info_sup',
                'details_motif', 'medecin_r', 'demarcheur'
            ])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->paginate($perPage);

        $users = Cache::remember('medecins_list', 3600, function () {
            return User::where('role_id', 2)->select('id', 'name')->get();
        });

        return view('admin.factures.consultation', compact(
            'factureConsultations',
            'startDate',
            'endDate',
            'users',
            'lists'
        ));
    }

    public function FactureConsultationUpdate(Request $request, $id)
    {
        $this->authorize('update', new FactureConsultation);

        $request->validate([
            'mode_paiement' => 'required',
            'num_cheque' => 'required_if:mode_paiement,chèque',
            'emetteur_cheque' => 'required_if:mode_paiement,chèque',
            'banque_cheque' =>  'required_if:mode_paiement,chèque',
            'emetteur_bpc' =>  'required_if:mode_paiement,bon de prise en charge',
            'reste' => 'required|numeric|min:0',
            'percu' => 'required|numeric|min:0',
            'montant' => 'required|numeric|min:0',
        ]);

        if ($request->input('percu') > $request->input('reste')) {
            return redirect()->back()
                ->withErrors(['percu' => 'Le montant perçu ne peut pas dépasser le reste à payer.'])
                ->withInput();
        }

        $facture = FactureConsultation::with('patient:id,prise_en_charge')->findOrFail($id);

        $modePaiementInfo = $request->input('mode_paiement') === 'chèque'
            ? collect([
                $request->input('num_cheque'),
                $request->input('emetteur_cheque'),
                $request->input('banque_cheque')
            ])->filter()->implode(' // ')
            : ($request->input('mode_paiement') === 'bon de prise en charge'
                ? $request->input('emetteur_bpc')
                : '');

        DB::transaction(function () use ($facture, $request, $modePaiementInfo) {
            $historiqueFacture = new HistoriqueFacture([
                'reste' => $facture->reste - $request->input('percu'),
                'montant' => $facture->montant,
                'percu'   => $request->input('percu'),
                'assurec'  => $facture->assurec,
                'mode_paiement'  => $request->input('mode_paiement'),
                'mode_paiement_info_sup' => $modePaiementInfo,
            ]);

            $facture->montant = $request->input('montant');
            $facture->avance += $request->input('percu');
            $facture->mode_paiement = $request->input('mode_paiement');
            $facture->mode_paiement_info_sup = $modePaiementInfo;
            $facture->assurec = FactureConsultation::calculAssurec($request->input('montant'), $facture->patient->prise_en_charge);
            $facture->assurancec = FactureConsultation::calculAssuranceC($request->input('montant'), $facture->patient->prise_en_charge);
            $facture->reste = FactureConsultation::calculReste($facture->assurec, $facture->avance);
            $facture->statut = $facture->reste == 0 ? 'Soldée' : 'Non soldée';
            $facture->save();

            $facture->historiques()->save($historiqueFacture);
        });

        Cache::tags(['factures'])->flush();

        return redirect()->action('FactureController@FactureConsultation')
            ->with('info', 'La facture n° '.$id.' a bien été mise à jour');
    }

    /**
     * Export de la facture de consultation en PDF
     */
    public function export_consultation($id, Request $request)
    {
        // Augmentation des limites pour éviter les plantages
        set_time_limit(120);
        ini_set('memory_limit', '512M');

        try {
            // Vérification des droits (important)
            $this->authorize('print', Patient::class);

            $layout = $request->input('layout', 'double-vertical');
            $autoPrint = $request->input('auto_print', false);

            $facture = FactureConsultation::with([
                    'patient:id,name,prenom,numero_dossier,demarcheur,avance,assurec,assurancec,created_at,user_id',
                    'patient.user:id,name,prenom'
                ])
                ->findOrFail($id);

            // Appel au PdfService. S'il n'existe pas, utilisez PDF::loadView
            if (class_exists('App\Services\PdfService')) {
                return PdfService::generateInvoice($facture, $layout, $autoPrint);
            }

            // Fallback si le Service n'est pas trouvé
            $pdf = PDF::loadView('admin.etats.facture_consultation', compact('facture', 'layout'));
            return $pdf->stream("facture_{$facture->numero}.pdf");

        } catch (\Exception $e) {
            Log::error('PDF Generation Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la génération du PDF. Détails: ' . $e->getMessage());
        }
    }

    public function export_bilan_consultation(Request $request)
    {
        set_time_limit(180);
        ini_set('memory_limit', '512M');

        try {
            $service = $request->input('service') === 'Tout' ? "" : $request->input('service');
            $day = $request->input('day');

            $factures = HistoriqueFacture::with([
                'facture_consultation:id,numero,patient_id,montant,motif,medecin_r,demarcheur,assurancec,assurec',
                'facture_consultation.patient:id,name'
            ])
            ->where('created_at', 'LIKE', $day.'%')
            ->whereHas('facture_consultation', function ($query) use ($service) {
                $query->where('motif', 'LIKE', '%'.$service)
                    ->whereNull('deleted_at');
            })
            ->get()
            ->groupBy('facture_consultation_id');

            // Logique de calcul des totaux...
            $totalPercu = 0; $totalMontant = 0; $totalReste = 0;
            $totalPartAssurance = 0; $totalPartPatient = 0;
            $tFactures = collect();
            $mode_paiement = collect();

            foreach ($factures as $historique_factures) {
                $first = $historique_factures->first();
                $factureData = (object)[
                    'numero' => $first->facture_consultation->numero,
                    'name' => $first->facture_consultation->patient->name,
                    'montant' => $first->facture_consultation->montant,
                    'percu' => $historique_factures->sum('percu'),
                    'reste' => $historique_factures->last()->reste,
                    'partAssurance' => $first->facture_consultation->assurancec ?? 0,
                    'partPatient' => $first->facture_consultation->assurec ?? 0,
                    'medecin' => $first->facture_consultation->medecin_r ?? '',
                    'demarcheur' => $first->facture_consultation->demarcheur ?? ''
                ];

                foreach($historique_factures as $h) {
                    $key = $this->getModePaiementKey($h->mode_paiement);
                    $existing = $mode_paiement->firstWhere('key', $key);
                    if ($existing) { $existing->val += $h->percu; }
                    else { $mode_paiement->push((object)['key' => $key, 'val' => $h->percu, 'name' => $h->mode_paiement]); }
                    $totalPercu += $h->percu;
                }

                $tFactures->push($factureData);
                $totalMontant += $factureData->montant;
                $totalReste += $factureData->reste;
                $totalPartAssurance += $factureData->partAssurance;
                $totalPartPatient += $factureData->partPatient;
            }

            $pdf = PDF::loadView('admin.etats.bilan_consultation', [
                'mode_paiement' => $mode_paiement,
                'service' => $service,
                'tFactures' => $tFactures,
                'totalPercu' => $totalPercu,
                'totalMontant' => $totalMontant,
                'totalReste' => $totalReste,
                'totalPartAssurance' => $totalPartAssurance,
                'totalPartPatient' => $totalPartPatient
            ])->setPaper('a4', 'landscape');

            return $pdf->stream("bilan_{$day}.pdf");

        } catch (\Exception $e) {
            Log::error('Bilan PDF Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur bilan PDF');
        }
    }

    private function getModePaiementKey($modePaiement)
    {
        $normalizedMap = [
            'espèce' => 'espece', 'chèque' => 'cheque', 'orange money' => 'om',
            'mtn mobile money' => 'momo', 'virement' => 'virement',
            'bon de prise en charge' => 'bondepriseencharge'
        ];
        return $normalizedMap[strtolower($modePaiement)] ?? 'autre';
    }
}
