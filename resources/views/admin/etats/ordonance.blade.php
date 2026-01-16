<link href="{{ public_path('vendor/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" media="all" />
<style>
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

    .footer {
        position: fixed;
        bottom: 5px;
        width: 100%;
        padding: 1px 0 15px;
    }
    table.ordonance-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    .ordonance-table th,
    .ordonance-table td {
        border: 1px solid #000;
        padding: 8px 10px;
        text-align: left;
        vertical-align: top;
    }
    .ordonance-table th {
        background-color: #f8f9fa;
        font-weight: bold;
    }



</style>


<div class="container-fluid">
    <table width="100%" style="margin-bottom: 10px;">
        <tr>
            <td width="20%" valign="top">
                <img class="logo" src="{{ public_path('admin/images/logo.jpg') }}">
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

    <div class="row mt-3">
        <div class="col-4">
            <p><strong>Dr. {{ $user->prenom ?? '' }} {{ $user->name }}</strong></p>
            <p><small><strong>{{ $user->specialite }}</strong></small></p>
            <p><strong>Onmc: <small>{{ $user->onmc }}</small></strong></p>
        </div>
        <div class="col-5 offset-3 text-right">
            <p><small><strong>{{ \Carbon\Carbon::parse($ordonance->created_at)->format('l, d M Y H:i:s T') }}</strong></small></p>
            <p class="mt-4">
                <strong>{{ $patient->name }} {{ $patient->prenom }}</strong>
            </p>
        </div>
    </div>
<br>
    <div class="row mt-4">
        <h5 class="text-center"><u>ORDONNANCE</u></h5>
    </div>

    @php
        $medicaments = explode(',', $ordonance->medicament ?? '');
        $quantites   = explode(',', $ordonance->quantite ?? '');
        $descriptions = explode(',', $ordonance->description ?? '');
        $rowCount = max(count($medicaments), count($quantites), count($descriptions));
    @endphp

    <table class="ordonance-table">
        <thead>
            <tr>
                <th style="width: 5%">SN</th>
                <th>Médicament</th>
                <th style="width: 15%">Quantité</th>
                <th>Posologie / Description</th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 0; $i < $rowCount; $i++)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $medicaments[$i] ?? '' }}</td>
                    <td>{{ $quantites[$i] ?? '' }}</td>
                    <td>{{ $descriptions[$i] ?? '' }}</td>
                </tr>
            @endfor
        </tbody>
    </table>

    
</div>








