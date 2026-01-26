<link href="{{ public_path('vendor/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" media="all" />
<style>
    .cpi-titulo3 { font-size: 10px; }
    .logo { width: 100px; height: auto; }
    p {
        line-height: 1.4;
        font-family: 'Crimson Text', sans-serif !important;
        margin: 0;
    }
    hr {
        border-top: 2px solid #4463dc; /* Bootstrap primary */
        margin: 1.5rem 0;
    }
    .h4 { text-align: center; }
    .force { margin-top: -10px !important; margin-right: 50px !important; }
    .type_interve { margin-top: -50px !important; }
    .footer {
        padding-top: 1px;
        padding-bottom: 80px;
        position: fixed;
        bottom: 5px;
        width: 100%;
    }
</style>

<div class="container-fluid">
    <!-- Header -->
    <table width="100%" style="margin-bottom: 10px;">
        <tr>
            <!-- Logo -->
            <td width="20%" valign="top">
                <img class="logo" src="{{ public_path('admin/images/logo.jpg') }}" alt="Clinic Logo">
            </td>

            <!-- Clinic Info -->
            <td width="80%" align="right" valign="top">
                <p><b>CENTRE MEDICO-CHIRURGICAL D'UROLOGIE</b></p>
                <p>VALLEE MANGA BELL DOUALA-BALI</p>
                <small>TEL:(+237) 233 423 389 / 674 068 988 / 698 873 945</small><br>
                <small>www.cmcu-cm.com</small>
            </td>
        </tr>
    </table>

    <hr>

    <p class="force"><h4 class="h4"><u>COMPTE-RENDU OPERATOIRE</u></h4></p>

    <div class="row col-md-5 offset-3">
        <div class="row">
            <p>CONCERNANT LE PATIENT : <b>{{ $patient->name }} {{ $patient->prenom }}</b></p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <span><small><b>CHIRURGIEN :</b> Dr. {{ $crbo->chirurgien ?? 'N/A' }}</small></span><br>
            <span><small><b>AIDE OPERATOIRE:</b> Dr. {{ $crbo->aide_op ?? 'N/A' }}</small></span><br>
            <span><small><b>ANESTHESISTE :</b> Dr. {{ $crbo->anesthesiste ?? 'N/A' }}</small></span><br>
            <span><small><b>INFIRMIER ANESTHESISTE:</b> {{ $crbo->infirmier_anesthesiste ?? 'N/A' }}</small></span>
        </div>
        <div class="col-md-2 offset-7">
            <span><small><b>DATE D'ENTREE :</b> {{ $crbo->date_e ?? 'N/A' }}</small></span><br>
            <span><small><b>TYPE D'ENTREE :</b> {{ $crbo->type_e ?? 'N/A' }}</small></span><br>
            <span><small><b>DATE DE SORTIE :</b> {{ $crbo->date_s ?? 'N/A' }}</small></span><br>
            <span><small><b>TYPE DE SORTIE :</b> {{ $crbo->type_s ?? 'N/A' }}</small></span><br>
        </div>
    </div>

    <h6 class="type_interve"><u>TYPE D'INTERVENTION :</u></h6>
    <div class="">
        <p>
            <b>{!! nl2br(e($consultation->type_intervention ?? 'N/A')) !!}</b>
        </p>
    </div>

    <h6 class="text-"><u>DATE D'INTERVENTION :</u> {{ $crbo->date_intervention ?? 'N/A' }}</h6>

    <h6 class="text-"><u>INDICATIONS OPERATOIRES :</u></h6>
    <div class="">
        <p>
            {!! nl2br(e($crbo->indication_operatoire ?? '')) !!}
        </p>
    </div>

    <h6 class="text-"><u>COMPTE-RENDU OPERATOIRE :</u></h6>
    <div class="">
        <p>
            {!! nl2br(e($crbo->compte_rendu_o ?? '')) !!}
        </p>
    </div>

    <h6 class="text-"><u>SUITES OPERATOIRES :</u></h6>
    <div class="">
        <p>
            {!! nl2br(e($crbo->suite_operatoire ?? '')) !!}
        </p>
    </div>

    <h6 class="text-"><u>CONCLUSIONS :</u></h6>
    <div class="">
        <p>
            {!! nl2br(e($crbo->conclusion ?? '')) !!}
        </p>
    </div>

    <h6 class="text-"><u>PROPOSITION DE SUIVI :</u></h6>
    <div class="">
        <p>
            {!! nl2br(e($crbo->proposition_suivi ?? '')) !!}
        </p>
    </div>

    <footer class="footer">
        <p class="offset-8"><b>Dr {{ auth()->user()->name ?? '' }}</b></p>
        <div class="text-center col-6 offset-2">
            <!-- <small>TEL:(+237) 233 423 389 / 674 068 988 / 698 873 945</small> -->
            <!-- <small>www.cmcu-cm.com</small> -->
        </div>
    </footer>
</div>



