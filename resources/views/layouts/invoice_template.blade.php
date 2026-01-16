<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('vendor/datatables/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/css/bootstrap.min.css') }}">
    <style>
        body { font-size: 11px }

        thead > tr > th {
            text-align: center;
            padding: 5px;
        }
        .border-top-2{
            border-top: 2px solid brown;
        }
        .page-section{
            margin-top: 5px;
            margin-bottom: 5px;
        }
        .padding-top-10{
            padding-top: 10px;
        }
        .text-bold{
            font-weight: bold;
            color: #000;
        }
        .red {
            color: red;
            font-weight: bold;
        }
        .orange{
            color: orange;
            font-weight: bold;
        }
        .green {
            color: green;
            font-weight: bold;
        }
        td {
            vertical-align: middle;
        }
        .container{
            border: 1px solid #000;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row text-center" style="background: yellow">
        <h5><strong>CHIMAF SERVICES SARL</strong></h5>
        <strong>Transformation et Vente des Produits Chimique</strong><br>
        <strong>D'Entretiens Industriels - Prestation de services - Divers</strong><br>
        <strong>RC/N DLN A4235 NCP17000471717DBP: 12198 Tél: 675 97 88 26</strong><br>
        <strong>Email-mail: chimafservices@yahoo.com</strong><br>
    </div>
    <table width="100%" border="0" class="border-top-2 padding-top-10">
        <tbody>
        <tr>
            <td>DA N°5236</td>
            <td width="60%"></td>
            <td>
                Douala, le {{ facture.dateFacture|date('d/m/Y') }} <br>
                DOIT: CICAM
            </td>
        </tr>
        </tbody>
    </table>
    <br><br><br>
    <br><br><br>

    <table width="100%" border="1" class="text-center padding-top-10">
        <caption class="text-center text-bold">FACTURE PROFORMA N°{{ facture.numero }}</caption>
        <thead>
        <tr>
            <th>QTE</th>
            <th>Désignation</th>
            <th>P.U</th>
            <th>Montant</th>
        </tr>
        </thead>
        <tbody>
        <!-- LOOP -->
        {% set totalHT = 0 %}
        {% for  produitFacture in  produitsDeLaFacture %}
        {% set totalHT = totalHT + produitFacture.prixTotal %}
        <tr>
            <td>{{ produitFacture.quantite }}</td>
            <td>{{ produitFacture.produit.designation }}</td>
            <td>{{ produitFacture.prix }}</td>
            <td>{{ produitFacture.prixTotal }}</td>
        </tr>
        {% endfor %}

        <!-- LOOP -->

        <tr>
            <td></td>
            <td class="orange"><i>MHT</i></td>
            <td></td>
            <td class="orange"><i>{{ totalHT }}</i></td>
        </tr>
        <tr>
            <td></td>
            <td class="text-bold"><i>TVA</i></td>
            <td class="text-bold"><i>{{ tva }} %</i></td>
            <td class="text-bold"><i>{{ ((totalHT * tva)/100)|round(0, 'ceil') }}</i></td>
        </tr>
        <tr>
            <td></td>
            <td class="green"><i>MTTC</i></td>
            <td></td>
            <td class="green"><i>{{ (((totalHT * tva)/100) + totalHT)|round(0, 'ceil') }}</i></td>
        </tr>
        </tbody>
    </table>
    <br>

    <div class="page-section text-bold text-center">
        <u>La direction</u>
    </div>
    <br><br><br><br>

    <div class="page-section text-bold text-left">
        Arrêté la présente facture proformat à la somme de:
        <span style="color: #0000ed">{{ (((totalHT * tva)/100) + totalHT )|round(0, 'ceil') }} FCFA</span>
    </div>
    <br><br><br><br>

    <div class="page-section text-bold text-right">
        <u>La direction</u>
    </div>
    <br><br><br><br>

    <table width="100%" border="0" class="border-top-2 padding-top-10 text-center">
        <tbody>
        <tr>
            <td>Domiciliation bancaire/ATLANTICBANK</td>
        </tr>
        <tr>
            <td>Régime TVA: REEL</td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
