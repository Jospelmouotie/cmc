 public function export_devis(Request $request, $montant_en_lettre)
    {
        set_time_limit(120);
        ini_set('memory_limit', '256M');

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

            // Calculate totals
            $prixChambre = $request->input('nbr_chambre') * $request->input('pu_chambre');
            $prixVisite = $request->input('nbr_visite') * $request->input('pu_visite');
            $prixAmiJour = $request->input('nbr_ami_jour') * $request->input('pu_ami_jour');
            $total2 = $prixChambre + $prixVisite + $prixAmiJour;

            $total1 = 0;
            $ligneDevis = [];

            foreach ($request->input('ligneDevi') as $ligne) {
                $prixTotal = $ligne["prix_u"] * $ligne["quantite"];
                $total1 += $prixTotal;

                // Use actual LigneDevi MODEL instance (not stdClass, not array)
                $ligneDevis[] = new LigneDevi([
                    'element' => $ligne["element"],
                    'quantite' => $ligne["quantite"],
                    'prix_u' => $ligne["prix_u"],
                    'prix' => $prixTotal, // Custom attribute (not in DB, but OK for view)
                ]);
            }

            // Use actual Devi MODEL instance
            $devis = new Devi([
                'nom' => $request->input('nom_devis'),
                'nbr_chambre' => $request->input('nbr_chambre'),
                'nbr_visite' => $request->input('nbr_visite'),
                'nbr_ami_jour' => $request->input('nbr_ami_jour'),
                'pu_chambre' => $request->input('pu_chambre'),
                'pu_visite' => $request->input('pu_visite'),
                'pu_ami_jour' => $request->input('pu_ami_jour'),
                'code' => $request->input('code_devis') ?? now()->format('Y-m-d') . '/' . substr($request->input('nom_devis'), 0, 4),
                'user_id' => Auth::id(),
            ]);

            // Add computed properties (not in DB, but safe to attach for view)
            $devis->total1 = $total1;
            $devis->total2 = $total2;
            $devis->total = $montant_en_lettre; // This is the amount in words

            // Build safe filename
            $filename = 'devis_' . preg_replace('/[^a-zA-Z0-9_\-]/', '_', $devis->code) . '.pdf';
            
            // NEW: read options and use PdfService
            $orientation = $request->input('orientation', 'portrait');
            $format = $request->input('format', 'A4');
            $delivery = $request->input('delivery', 'stream');
            
            return PdfService::generate('admin.etats.devis', [
                'devis' => $devis,
                'ligneDevis' => $ligneDevis,
                'nomPatient' => $request->input('patient'),
                'currentDate' => now()->locale('fr_FR')->isoFormat('DD MMMM YYYY'),
            ], $filename, $orientation, $format, $delivery);

            return $pdf->stream('devis_' . $devis->code . '.pdf');

        } catch (\Exception $e) {
            Log::error('Devis PDF Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Erreur lors de la génération du devis PDF.');
        }
    }