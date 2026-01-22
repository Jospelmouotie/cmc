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

// INSERT: PdfService import
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

        // Generate date list for the date selector
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

        // First validate basic fields
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

        // Custom validation: percu must be <= reste
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

    public function FactureChambre(Patient $patient)
    {
        $this->authorize('view', User::class);

        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        $start_date = "01-" . $month . "-" . $year;
        $start_time = strtotime($start_date);
        $end_time = strtotime("+1 month", $start_time);

        $lists = [];
        for ($i = $start_time; $i < $end_time; $i += 86400) {
            $lists[] = date('Y-m-d', $i);
        }

        $factureChambres = FactureChambre::with('patient')->get();

        return view('admin.factures.chambre', compact('factureChambres', 'lists'));
    }

    /**
     * Export consultation invoice with layout options
     *
     * @param int $id Invoice ID
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function export_consultation($id, Request $request)
    {
        set_time_limit(120);
        ini_set('max_execution_time', 120);
        ini_set('memory_limit', '256M');

        try {
            $this->authorize('update', Patient::class);
            $this->authorize('print', Patient::class);

            // Get layout preference from request (default: double-vertical)
            $layout = $request->input('layout', 'double-vertical');
            $autoPrint = $request->input('auto_print', false);

            // Fetch facture with necessary relationships
            $facture = FactureConsultation::with([
                    'patient:id,name,prenom,numero_dossier,demarcheur,avance,assurec,assurancec,created_at,user_id',
                    'patient.user:id,name,prenom'
                ])
                ->select([
                    'id', 'numero', 'patient_id', 'montant', 'avance',
                    'reste', 'motif', 'details_motif', 'date_insertion',
                    'assurance', 'assurancec', 'assurec'
                ])
                ->findOrFail($id);

            // Use PdfService for generation
            return PdfService::generateInvoice($facture, $layout, $autoPrint);


        } catch (\Exception $e) {
            Log::error('PDF Generation Error', [
                'id' => $id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return redirect()->back()->with('error', 'Erreur PDF: ' . $e->getMessage());
        }
    }

    public function export_client($id)
    {
        set_time_limit(120);
        ini_set('memory_limit', '256M');

        try {
            $client = FactureClient::with('user:id,name,prenom')->findOrFail($id);

            return PdfService::generate(
                'admin.etats.clientP',
                ['clients' => $client],
                "facture_client_{$id}.pdf"
            );


        } catch (\Exception $e) {
            Log::error('Client PDF Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur PDF client');
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
            ->select([
                'id', 'facture_consultation_id', 'montant', 'percu',
                'reste', 'mode_paiement', 'created_at'
            ])
            ->get()
            ->groupBy('facture_consultation_id');

            $totalPercu = 0;
            $totalMontant = 0;
            $totalReste = 0;
            $totalPartAssurance = 0;
            $totalPartPatient = 0;
            $tFactures = collect();
            $mode_paiement = collect();

            foreach ($factures as $key => $historique_factures) {
                $factureData = (object)[
                    'numero' => '',
                    'name' => '',
                    'montant' => 0,
                    'percu' => 0,
                    'reste' => 0,
                    'partAssurance' => 0,
                    'partPatient' => 0,
                    'medecin' => '',
                    'demarcheur' => ''
                ];

                foreach ($historique_factures as $historique_facture) {
                    $factureData->numero = $historique_facture->facture_consultation->numero;
                    $factureData->name = $historique_facture->facture_consultation->patient->name;
                    $factureData->montant = $historique_facture->facture_consultation->montant;
                    $factureData->percu += $historique_facture->percu;
                    $factureData->reste = $historique_facture->reste;
                    $factureData->partAssurance = $historique_facture->facture_consultation->assurancec ?? 0;
                    $factureData->partPatient = $historique_facture->facture_consultation->assurec ?? 0;
                    $factureData->medecin = $historique_facture->facture_consultation->medecin_r ?? '';
                    $factureData->demarcheur = $historique_facture->facture_consultation->demarcheur ?? '';

                    $modePaiementKey = $this->getModePaiementKey($historique_facture->mode_paiement);

                    $existingMode = $mode_paiement->firstWhere('key', $modePaiementKey);
                    if ($existingMode) {
                        $existingMode->val += $historique_facture->percu;
                    } else {
                        $mode_paiement->push((object)[
                            'key' => $modePaiementKey,
                            'val' => $historique_facture->percu,
                            'name' => $historique_facture->mode_paiement
                        ]);
                    }

                    $totalPercu += $historique_facture->percu;
                }

                $tFactures->push($factureData);
                $totalMontant += $factureData->montant;
                $totalReste += $factureData->reste;
                $totalPartAssurance += $factureData->partAssurance;
                $totalPartPatient += $factureData->partPatient;
            }

            return PdfService::generate(
                'admin.etats.bilan_consultation',
                [
                    'mode_paiement' => $mode_paiement,
                    'service' => $service,
                    'tFactures' => $tFactures,
                    'totalPercu' => $totalPercu,
                    'totalMontant' => $totalMontant,
                    'totalReste' => $totalReste,
                    'totalPartAssurance' => $totalPartAssurance,
                    'totalPartPatient' => $totalPartPatient
                ],
                "bilan_{$day}.pdf",
                'landscape'
            );

        } catch (\Exception $e) {
            Log::error('Bilan PDF Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur bilan PDF');
        }
    }

    private function getModePaiementKey($modePaiement)
    {
        $normalizedMap = [
            'espèce' => 'espece',
            'chèque' => 'cheque',
            'orange money' => 'om',
            'mtn mobile money' => 'momo',
            'virement' => 'virement',
            'bon de prise en charge' => 'bondepriseencharge'
        ];

        return $normalizedMap[strtolower($modePaiement)] ?? 'autre';
    }

    public function export_bilan_clientexterne(Request $request)
    {
        set_time_limit(120);
        ini_set('memory_limit', '256M');

        try {
            $day = $request->input('day');

            $factures = FactureClient::with('client:id,name')
                ->where('date_insertion', '=', $day)
                ->get();

            $totalPercu = FactureClient::where('date_insertion', '=', $day)->sum('montant');
            $avances = FactureClient::where('date_insertion', '=', $day)->sum('avance');
            $restes = FactureClient::where('date_insertion', '=', $day)->sum('reste');
            $assurances = FactureClient::where('date_insertion', '=', $day)->sum('partassurance');
            $clients = FactureClient::where('date_insertion', '=', $day)->sum('partpatient');

            return PdfService::generate(
                'admin.etats.bilan_clientexterne',
                [
                    'factures' => $factures,
                    'totalPercu' => $totalPercu,
                    'avances' => $avances,
                    'restes' => $restes,
                    'assurances' => $assurances,
                    'clients' => $clients,
                ],
                "bilan_client_{$day}.pdf"
            );

        } catch (\Exception $e) {
            Log::error('Bilan Client PDF Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur bilan client PDF');
        }
    }
}














