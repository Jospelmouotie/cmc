<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            padding: 15px;
        }

        .header-section {
            margin-bottom: 20px;
        }

        .header-row {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }

        .logo-section {
            display: table-cell;
            width: 120px;
            vertical-align: top;
        }

        .logo {
            width: 100px;
            height: auto;
        }

        .company-info {
            display: table-cell;
            text-align: center;
            vertical-align: top;
            padding-left: 20px;
        }

        .company-info p {
            margin: 3px 0;
            font-size: 12px;
            font-weight: bold;
        }

        .company-info small {
            font-size: 10px;
        }

        .divider {
            border: none;
            border-top: 2px solid #dc3545;
            margin: 15px 0;
        }

        .document-title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin: 20px 0;
            text-transform: uppercase;
        }

        .document-title u {
            text-decoration: underline;
            text-decoration-color: #000;
        }

        /* Main Table Styles */
        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            border: 2px solid #000;
        }

        .main-table th,
        .main-table td {
            border: 1px solid #000;
            padding: 8px 6px;
            text-align: left;
            vertical-align: middle;
        }

        .main-table thead th {
            background-color: #f8f9fa;
            font-weight: bold;
            text-align: center;
            font-size: 10px;
            text-transform: uppercase;
            border: 2px solid #000;
        }

        .main-table tbody td {
            font-size: 10px;
        }

        .main-table tbody td small {
            font-size: 9px;
        }

        /* Column widths */
        .col-id { width: 5%; text-align: center; }
        .col-patient { width: 15%; }
        .col-montant { width: 10%; text-align: right; }
        .col-avance { width: 10%; text-align: right; }
        .col-reste { width: 9%; text-align: right; }
        .col-part-patient { width: 10%; text-align: right; }
        .col-part-ass { width: 10%; text-align: right; }
        .col-dmh { width: 12%; text-align: center; }
        .col-medecin { width: 12%; }
        .col-numero { width: 7%; text-align: center; }

        /* Total row styles */
        .total-row {
            background-color: #e9ecef;
            font-weight: bold;
        }

        .total-row th {
            text-align: left;
            padding-left: 10px;
            font-size: 11px;
            border: 2px solid #000;
        }

        .total-row td {
            font-size: 11px;
            font-weight: bold;
            border: 2px solid #000;
        }

        /* Payment mode section */
        .payment-mode-row {
            background-color: #f8f9fa;
        }

        .payment-mode-row th {
            border: 2px solid #000;
            font-size: 10px;
            text-transform: uppercase;
        }

        .payment-mode-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        .payment-mode-table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
            font-weight: bold;
            font-size: 10px;
        }

        .payment-mode-table tr:first-child td {
            background-color: #e9ecef;
            text-transform: uppercase;
            font-size: 9px;
        }

        .payment-mode-table tr:last-child td {
            font-size: 11px;
        }

        /* Signature section */
        .signature-section {
            margin-top: 40px;
            display: table;
            width: 100%;
        }

        .signature-box {
            display: table-cell;
            text-align: center;
            width: 33.33%;
            padding: 10px;
        }

        .signature-box p {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 50px;
        }

        /* Footer */
        .footer {
            position: fixed;
            bottom: 10px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            padding: 10px;
            border-top: 1px solid #ccc;
        }

        .footer small {
            display: block;
            margin: 2px 0;
        }

        /* Print specific styles */
        @media print {
            body {
                padding: 10px;
            }
            
            .main-table {
                page-break-inside: avoid;
            }

            .footer {
                position: fixed;
                bottom: 0;
            }
        }

        /* Number formatting */
        .amount {
            font-family: 'Courier New', monospace;
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <div class="header-section">
        <div class="header-row">
            <div class="logo-section">
                <img class="logo img-responsive float-start" src="{{ public_path('admin/images/logo.jpg') }}">
            </div>
            <div class="company-info">
                <p>CENTRE MEDICO-CHIRURGICAL D'UROLOGIE</p>
                <p>VALLEE MANGA BELL DOUALA-BALI</p>
                <small>TEL: (+237) 233 423 389 / 674 068 988 / 698 873 945</small>
                <p><small>www.cmcu-cm.com</small></p>
            </div>
        </div>
        <hr class="divider">
    </div>

    <!-- Document Title -->
    <h5 class="document-title">
        <u>FICHE DE SUIVI DES ENCAISSEMENTS JOURNALIERS - CONSULTATION</u>
    </h5>

    <!-- Main Data Table -->
    <table class="main-table">
        <thead>
            <tr>
                <th class="col-id">SN</th>
                <th class="col-patient">PATIENT</th>
                <th class="col-montant">MONTANT</th>
                <th class="col-avance">AVANCE</th>
                <th class="col-reste">RESTE</th>
                <th class="col-part-patient">PART PATIENT</th>
                <th class="col-part-ass">PART ASS.</th>
                <th class="col-dmh">DÉMARCHEUR</th>
                <th class="col-medecin">MÉDECIN</th>
                <th class="col-numero">N°</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tFactures as $facture)
            <tr>
                <td class="col-id">1</td>
                <td class="col-patient"><small>{{ $facture->name }}</small></td>
                <td class="col-montant"><span class="amount">{{ number_format($facture->montant, 0, ',', ' ') }}</span></td>
                <td class="col-avance"><span class="amount">{{ number_format($facture->percu, 0, ',', ' ') }}</span></td>
                <td class="col-reste"><span class="amount">{{ number_format($facture->reste, 0, ',', ' ') }}</span></td>
                <td class="col-part-patient"><span class="amount">{{ number_format($facture->partPatient, 0, ',', ' ') }}</span></td>
                <td class="col-part-ass"><span class="amount">{{ number_format($facture->partAssurance, 0, ',', ' ') }}</span></td>
                <td class="col-dmh"><small>{{ $facture->demarcheur ?? '' }}</small></td>
                <td class="col-medecin"><small>{{ $facture->medecin ?? '' }}</small></td>
                <td class="col-numero">{{ $facture->numero }}</td>
            </tr>
            @endforeach
            <!-- Total Row -->
            <tr class="total-row">
                <th colspan="2">TOTAL EN FCFA:</th>
                <td class="col-montant"><span class="amount">{{ number_format($totalMontant, 0, ',', ' ') }}</span></td>
                <td class="col-avance"><span class="amount">{{ number_format($totalPercu, 0, ',', ' ') }}</span></td>
                <td class="col-reste"><span class="amount">{{ number_format($totalReste, 0, ',', ' ') }}</span></td>
                <td class="col-part-patient"><span class="amount">{{ number_format($totalPartPatient, 0, ',', ' ') }}</span></td>
                <td class="col-part-ass"><span class="amount">{{ number_format($totalPartAssurance, 0, ',', ' ') }}</span></td>
                <td colspan="3"></td>
            </tr>

            <!-- Payment Mode Row -->
            <tr class="payment-mode-row">
                <th colspan="10" style="padding: 0;">
                    <table class="payment-mode-table">
                        <tr>
                            <td colspan="5" style="text-align: left; padding-left: 10px; background-color: transparent; border: none; font-weight: bold;">MODE DE PAIEMENT:</td>
                        </tr>
                        <tr>
                            @if($mode_paiement && $mode_paiement->count() > 0)
                                @foreach($mode_paiement as $mp)
                                    <td align="center">{{ $mp->name }}</td>
                                @endforeach
                            @else
                                <td align="center">Aucun</td>
                            @endif
                        </tr>
                        <tr>
                            @if($mode_paiement && $mode_paiement->count() > 0)
                                @foreach($mode_paiement as $mp)
                                    <td align="center">{{ number_format($mp->val, 0, ',', ' ') }}</td>
                                @endforeach
                            @else
                                <td align="center">0</td>
                            @endif
                        </tr>
                    </table>
                </th>
            </tr>
        </tbody>
    </table>

    <!-- Signature Section -->
    <div class="signature-section">
        <div class="signature-box">
            <p>GESTIONNAIRE</p>
        </div>
        <div class="signature-box">
            <p>COMPTABLE</p>
        </div>
        <div class="signature-box">
            <p>ASSISTANTE</p>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <small>TEL: (+237) 233 423 389 / 674 068 988 / 698 873 945</small>
        <small>www.cmcu-cm.com</small>
    </footer>
</body>
</html>









