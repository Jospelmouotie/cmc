<?php
\Carbon\Carbon::setLocale('fr');
?>
<link href="{{ public_path('vendor/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" media="all" />

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 14px;
        color: #333;
        background-color: #fff;
    }

    .logo {
        width: 100px;
        height: auto;
    }

    hr {
        border-top: 2px solid #4463dc;
        margin: 1.5rem 0;
    }

    p, small {
        line-height: 1.5;
        margin: 0;
    }

    /* Table Styling */
    .table {
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 2rem;
        width: 100%;
        background-color: #fff;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    .table thead th {
        background-color: #4463dc;
        color: #fff;
        text-align: center;
        font-weight: 600;
        font-size: 14px;
        padding: 14px;
        border: 1px solid #dee2e6;
        letter-spacing: 0.5px;
    }

    .table tbody td {
        vertical-align: middle;
        font-size: 13px;
        padding: 12px 14px;
        border: 1px solid #dee2e6;
    }

    /* Zebra striping */
    .table tbody tr:nth-child(odd):not(.table-secondary):not(.table-primary):not(.section-header) {
        background-color: #f9f9f9;
    }

    /* Section headers */
    .section-header td {
        background-color: #e3f2fd !important;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 14px;
        padding: 10px 14px !important;
    }

    /* Section totals */
    .table-secondary td {
        background-color: #e9ecef !important;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-top: 2px solid #dee2e6;
    }

    /* Grand total row */
    .table-primary td {
        background-color: #dbeafe !important;
        font-weight: 700;
        border-top: 2px solid #4463dc;
    }

    .table-primary h5 {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: #4463dc;
    }

    .text-right {
        text-align: right !important;
    }
    .text-center {
        text-align: center !important;
    }

    h4 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .text-primary {
        color: #0d6efd !important;
    }

    .footer {
        position: fixed;
        bottom: 40px;
        width: 100%;
        font-size: 12px;
        color: #555;
        padding-top: 1rem;
        border-top: 1px solid #ccc;
    }

    u {
        font-weight: 500;
        font-size: 14px;
    }
</style>

<div class="container-fluid">
    <!-- Header --> 
    <table width="100%" style="margin-bottom: 10px;">
        <tr>
            <td width="20%" valign="top">
                <img class="logo" src="{{ public_path('admin/images/logo.jpg') }}" >
            </td>
            <td width="80%" align="right" valign="top">
                <p><b>CENTRE MEDICO-CHIRURGICAL D'UROLOGIE</b></p>
                <p>007/10/D/ONMC</p>
                <p>VALLEE MANGA BELL DOUALA-BALI</p>
                <p>Arrêté N° 3203/A/MINSANTE/SG/DOSTS/SDOS/SFSP</p>
                <small>TEL:(+237) 233 423 389 / 674 068 988 / 698 873 945</small><br>
                <small>Email : info@cmcu-cm.com</small><br>
                <small>www.cmcu-cm.com / cmcu_cmcu@yahoo.fr</small>
            </td>
        </tr>
    </table>

    <hr>

    <!-- Patient & Date -->
    <div class="row">
        <div class="col-md-6">
            @php
                $patientName = isset($nomPatient) ? $nomPatient : '';
                if (!empty($nomPatient)) {
                    if (is_numeric($nomPatient)) {
                        $patient = \App\Models\Patient::find((int) $nomPatient);
                        if ($patient) {
                            $patientName = ($patient->name ?? '') . ' ' . ($patient->prenom ?? '');
                        }
                    } elseif (is_object($nomPatient)) {
                        $patientName = ($nomPatient->name ?? '') . ' ' . ($nomPatient->prenom ?? '');
                    }
                }
            @endphp
            <p><b style="color: #012c6dff">Patient : {{ $patientName }}</b></p>
        </div>
        <div class="col-md-6 text-right">
            <p><b>Douala, {{ now()->translatedFormat('d F Y') }}</b></p>
        </div>
    </div>

    <!-- Devis Title -->
    <div class="text-center text-primary">
        <h4><u>DEVIS : {{ $devis->nom }}</u> (N°{{ $devis->code }})</h4>
    </div>
    <br>

    <!-- Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ÉLÉMENTS</th>
                <th>QTES</th>
                <th>PRIX UNIT.</th>
                <th>MONTANT</th>
            </tr>
        </thead>
        <tbody>
            @php
                $proceduresTotal = 0;
                $productsTotal = 0;
                $procedures = [];
                $products = [];
                
                // Separate procedures and products
                foreach($ligneDevis as $ligne) {
                    if ($ligne->type === 'procedure') {
                        $procedures[] = $ligne;
                        $proceduresTotal += $ligne->prix;
                    } else {
                        $products[] = $ligne;
                        $productsTotal += $ligne->prix;
                    }
                }
            @endphp

            {{-- PROCEDURES SECTION --}}
            @if(count($procedures) > 0)
                <tr class="section-header">
                    <td colspan="4"><b>PROCÉDURES MÉDICALES</b></td>
                </tr>
                @foreach($procedures as $ligne)
                    <tr>
                        <td>{{ $ligne->element }}</td>
                        <td class="text-center">{{ $ligne->quantite }}</td>
                        <td class="text-right">{{ number_format($ligne->prix_u, 0, ',', ' ') }}</td>
                        <td class="text-right">{{ number_format($ligne->quantite * $ligne->prix_u, 0, ',', ' ') }}</td>
                    </tr>
                @endforeach

                <tr class="table-secondary">
                    <td colspan="3" class="text-center"><b>SOUS-TOTAL ELEMENTS</b></td>
                    <td class="text-right"><b>{{ number_format($proceduresTotal, 0, ',', ' ') }}</b></td>
                </tr>
            @endif

            {{-- PRODUCTS SECTION --}}
            @if(count($products) > 0)
                <tr class="section-header">
                    <td colspan="4"><b>PRODUITS ET MATÉRIELS</b></td>
                </tr>
                @foreach($products as $ligne)
                    <tr>
                        <td>
                            {{ $ligne->element }}
                            @if($ligne->type === 'medication')
                                <small class="text-muted">(Médicament)</small>
                            @elseif($ligne->type === 'anesthesie')
                                <small class="text-muted">(Anesthésie)</small>
                            @elseif($ligne->type === 'material')
                                <small class="text-muted">(Matériel)</small>
                            @endif
                        </td>
                        <td class="text-center">{{ $ligne->quantite }}</td>
                        <td class="text-right">{{ number_format($ligne->prix_u, 0, ',', ' ') }}</td>
                        <td class="text-right">{{ number_format($ligne->quantite * $ligne->prix_u, 0, ',', ' ') }}</td>
                    </tr>
                @endforeach

                <tr class="table-secondary">
                    <td colspan="3" class="text-center"><b>SOUS-TOTAL PRODUITS</b></td>
                    <td class="text-right"><b>{{ number_format($productsTotal, 0, ',', ' ') }}</b></td>
                </tr>
            @endif

            {{-- TOTAL SECTION 1 --}}
            <tr class="table-secondary">
                <td colspan="3" class="text-center"><b>TOTAL 1 (PROCÉDURES + PRODUITS)</b></td>
                <td class="text-right"><b>{{ number_format($devis->total1, 0, ',', ' ') }}</b></td>
            </tr>

            {{-- HOSPITALIZATION SECTION --}}
            <tr class="section-header">
                <td colspan="4"><b>HOSPITALISATION {{ $devis->nbr_chambre }} JOUR(S)</b></td>
            </tr>
            <tr>
                <td>CHAMBRE</td>
                <td class="text-center">{{ $devis->nbr_chambre }}</td>
                <td class="text-right">{{ number_format($devis->pu_chambre, 0, ',', ' ') }}</td>
                <td class="text-right">{{ number_format($devis->nbr_chambre * $devis->pu_chambre, 0, ',', ' ') }}</td>
            </tr>
            <tr>
                <td>AMI-JOUR (750x12)</td>
                <td class="text-center">{{ $devis->nbr_ami_jour }}</td>
                <td class="text-right">{{ number_format($devis->pu_ami_jour, 0, ',', ' ') }}</td>
                <td class="text-right">{{ number_format($devis->nbr_ami_jour * $devis->pu_ami_jour, 0, ',', ' ') }}</td>
            </tr>
            <tr>
                <td>VISITE</td>
                <td class="text-center">{{ $devis->nbr_visite }}</td>
                <td class="text-right">{{ number_format($devis->pu_visite, 0, ',', ' ') }}</td>
                <td class="text-right">{{ number_format($devis->nbr_visite * $devis->pu_visite, 0, ',', ' ') }}</td>
            </tr>

            <tr class="table-secondary">
                <td colspan="3" class="text-center"><b>TOTAL 2 (HOSPITALISATION)</b></td>
                <td class="text-right"><b>{{ number_format($devis->total2, 0, ',', ' ') }}</b></td>
            </tr>

            {{-- GRAND TOTAL --}}
            <tr></tr>
            <tr class="table-primary">
                <td colspan="3" class="text-center"><h5><b>TOTAL GÉNÉRAL</b></h5></td>
                <td class="text-right"><h5><b>{{ number_format($devis->total1 + $devis->total2, 0, ',', ' ') }}</b></h5></td>
            </tr>
        </tbody>
    </table>

    <!-- Total in words -->
    <p>Arrêté le présent devis à la somme de : <b>{{ $devis->total }}</b> Francs CFA</p>
    <br>

    <!-- Signatures -->
    <div class="row">
        <div class="col-md-6 text-left"><u>LE MEDECIN TRAITANT:</u></div>
        <div class="col-md-6 text-center"><u>LA DIRECTION:</u></div>
    </div>

    <!-- Footer -->
    <footer class="footer text-center">
        <small>
            <b>N.B :</b> <i>Il est à noter que ceci n'est qu'une estimation du coût de l'intervention chirurgicale et de l'hospitalisation.
            Nous ne sommes pas tenus responsables des imprévus, ni des examens de laboratoire que vous pourriez effectuer éventuellement. Merci.</i>
        </small>
    </footer>
</div>