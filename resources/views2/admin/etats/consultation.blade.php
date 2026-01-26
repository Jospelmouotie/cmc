<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Facture Consultation</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #000;
        }
        .container {
            border: 1px solid #000;
            padding: 12px;
            margin-bottom: 20px;
        }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        h6 { margin: 3px 0; font-size: 11px; }
        h5 { margin: 5px 0; font-size: 12px; }
        h4 { margin: 5px 0; font-size: 13px; }
        .bold { font-weight: bold; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 12px 0;
        }
        th, td {
            padding: 8px;
            border: 1px solid #000;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .invoice-id {
            color: #000;
            margin: 10px 0;
            font-size: 14px;
        }
        .notices {
            margin-top: 15px;
            padding-left: 6px;
        }
        footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #aaa;
            text-align: center;
            font-size: 10px;
            color: #333;
        }
        .logo {
            width: 40px;
            display: block;
            margin: 0 auto 8px;
        }
        @media print {
            body { font-size: 11px !important; }
        }
    </style>
</head>
<body>
    <!-- FIRST COPY -->
    <div class="container">
        <div class="text-center">
            @if(file_exists(public_path('admin/images/logo.jpg')))
                <img class="logo" src="{{ public_path('admin/images/logo.jpg') }}" alt="">
            @endif
            <h6 class="bold">CENTRE MEDICO-CHIRURGICAL D'UROLOGIE</h6>
            <h6>VALLEE MANGA BELL DOUALA-BALI</h6>
            <h6>TEL: (+ 237) 233 423 389 / 674 068 988 / 698 873 945</h6>
            <h6>www.cmcu-cm.com</h6>
        </div>

        <div class="text-center">
            <h6 class="invoice-id">
                RECU {{ strtoupper($facture['details_motif'] ?? 'CONSULTATION') }}
                N° {{ $patient['numero_dossier'] }}
            </h6>
        </div>

        @if(!empty($facture['assurancec']))
            <h6 class="text-center">ASSURANCE: {{ $facture['assurance'] ?? '' }}</h6>
        @endif

        @if(!empty($patient['demarcheur']))
            <h6 class="text-center">{{ $patient['demarcheur'] }}</h6>
        @endif

        @if(!empty($facture['assurancec']))
            <h6 class="text-center">
                PART ASSURANCE: {{ $facture['assurancec'] }} |
                PART PATIENT: {{ $patient['assurec'] ?? 0 }}
            </h6>
        @endif

        <table>
            <thead>
                <tr>
                    <th class="text-left">NOM</th>
                    <th class="text-left">PRENOM</th>
                    <th class="text-left">MONTANT (FCFA)</th>
                    <th class="text-left">AVANCE</th>
                    <th class="text-left">RESTE</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-left"><h5>{{ $patient['name'] }}</h5></td>
                    <td class="text-left"><h5>{{ $patient['prenom'] }}</h5></td>
                    <td class="text-left"><h4>{{ number_format($facture['montant'], 0, ',', ' ') }}</h4></td>
                    <td class="text-left"><h4>{{ number_format($facture['avance'] ?? 0, 0, ',', ' ') }}</h4></td>
                    <td class="text-left"><h4>{{ number_format($facture['reste'] ?? 0, 0, ',', ' ') }}</h4></td>
                </tr>
            </tbody>
        </table>

        <div class="notices">
            <h6>LA CAISSE: {{ ($patient['user']['prenom'] ?? '') . ' ' . ($patient['user']['name'] ?? 'N/A') }}</h6>
            <h6>Douala, {{ isset($patient['created_at']) ? \Carbon\Carbon::parse($patient['created_at'])->format('d/m/Y') : date('d/m/Y') }}</h6>
        </div>

        <footer>
            Centre Medico-chirurgical d'urologie situé à la Vallée Douala Manga Bell Douala-Bali.<br>
            TEL: (+ 237) 233 423 389 / 674 068 988 / 698 873 945<br>
            SITE WEB: http://www.cmcu-cm.com
        </footer>
    </div>

    <!-- SECOND COPY -->
    <div style="page-break-before: always;"></div>

    <div class="container">
        <div class="text-center">
            @if(file_exists(public_path('admin/images/logo.jpg')))
                <img class="logo" src="{{ public_path('admin/images/logo.jpg') }}" alt="">
            @endif
            <h6 class="bold">CENTRE MEDICO-CHIRURGICAL D'UROLOGIE</h6>
            <h6>VALLEE MANGA BELL DOUALA-BALI</h6>
            <h6>TEL: (+ 237) 233 423 389 / 674 068 988 / 698 873 945</h6>
            <h6>www.cmcu-cm.com</h6>
        </div>

        <div class="text-center">
            <h6 class="invoice-id">
                RECU {{ strtoupper($facture['details_motif'] ?? 'CONSULTATION') }}
                N° {{ $patient['numero_dossier'] }}
            </h6>
        </div>

        @if(!empty($facture['assurancec']))
            <h6 class="text-center">ASSURANCE: {{ $facture['assurance'] ?? '' }}</h6>
        @endif

        @if(!empty($patient['demarcheur']))
            <h6 class="text-center">{{ $patient['demarcheur'] }}</h6>
        @endif

        @if(!empty($facture['assurancec']))
            <h6 class="text-center">
                PART ASSURANCE: {{ $facture['assurancec'] }} |
                PART PATIENT: {{ $patient['assurec'] ?? 0 }}
            </h6>
        @endif

        <table>
            <thead>
                <tr>
                    <th class="text-left">NOM</th>
                    <th class="text-left">PRENOM</th>
                    <th class="text-left">MONTANT (FCFA)</th>
                    <th class="text-left">AVANCE</th>
                    <th class="text-left">RESTE</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-left"><h5>{{ $patient['name'] }}</h5></td>
                    <td class="text-left"><h5>{{ $patient['prenom'] }}</h5></td>
                    <td class="text-left"><h4>{{ number_format($facture['montant'], 0, ',', ' ') }}</h4></td>
                    <td class="text-left"><h4>{{ number_format($facture['avance'] ?? 0, 0, ',', ' ') }}</h4></td>
                    <td class="text-left"><h4>{{ number_format($facture['reste'] ?? 0, 0, ',', ' ') }}</h4></td>
                </tr>
            </tbody>
        </table>

        <div class="notices">
            <h6>LA CAISSE: {{ ($patient['user']['prenom'] ?? '') . ' ' . ($patient['user']['name'] ?? 'N/A') }}</h6>
            <h6>Douala, {{ isset($patient['created_at']) ? \Carbon\Carbon::parse($patient['created_at'])->format('d/m/Y') : date('d/m/Y') }}</h6>
        </div>

        <footer>
            Centre Medico-chirurgical d'urologie situé à la Vallée Douala Manga Bell Douala-Bali.<br>
            TEL: (+ 237) 233 423 389 / 674 068 988 / 698 873 945<br>
            SITE WEB: http://www.cmcu-cm.com
        </footer>
    </div>
</body>
</html>