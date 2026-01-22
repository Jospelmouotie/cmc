<link href="{{ asset('admin/css/bootstrap.css') }}" rel="stylesheet" type="text/css" media="all" />
<style>
    .cpi-titulo3 {
        font-size: 12px;
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
    .footer {
        padding-top: 1px;
        padding-bottom: 15px;
        position:fixed;
        bottom:5;
        width:100%;
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
    <h4 class="text-danger text-center"><b><u>Compte rendu d'hospitalisation</u></b></h4>
    <div class="row">
        <div class="col-10">
            <h4><b><u>Nom du patient:</u></b> {{ $patient->name }}</h4>
            <br>
            <h4><b><u>Médécin traitant:</u></b> {{ $patient->compte_rendu_bloc_operatoires->last()->chirurgien }}</h4>
        </div>
    </div>
    <br>
    <br>
    <br>
    <h4 class=""><u>Suite opératoire :</u></h4>
    <br>
        <p>{!! nl2br(e($patient->compte_rendu_hospitalisations->last()->suite_operatoire)) !!}</p>
    <br>
    <h4 class="text-"><u>Détails d'intervention:</u></h4>
    <div class="">
        <h5>
            {!! nl2br(e($patient->compte_rendu_bloc_operatoires->last()->detail_intervention)) !!}
        </h5>
    </div>
    <br>
    <h4 class="text-"><u>Traitement de sortie:</u></h4>
    <div class="">
        <h5>
            {!! nl2br(e($patient->compte_rendu_hospitalisations->last()->traitement_sortie)) !!}
        </h5>
    </div>
    
</div>
