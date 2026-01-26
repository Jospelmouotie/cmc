<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture Consultation</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 0;
        }
        .facture-copy {
            border: 1px solid #000;
            padding: 12px;
            margin-bottom: 20px;
            page-break-inside: avoid;
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
    <div class="facture-copy">
        @include('admin.etats.partials.facture_content', ['facture' => $facture, 'patient' => $patient])
    </div>
    <div class="facture-copy">
        @include('admin.etats.partials.facture_content', ['facture' => $facture, 'patient' => $patient])
    </div>
</body>
</html>
