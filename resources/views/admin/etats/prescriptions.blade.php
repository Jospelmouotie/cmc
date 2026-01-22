<link href="{{ public_path('vendor/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" media="all" />

@php
    \Carbon\Carbon::setLocale('fr');
    $printDate = \Carbon\Carbon::now()->translatedFormat('d F Y');
@endphp

<style>
    body {
        background: #FFF;
    }
    span {
        font-size: 15px;
    }
    .text {
        margin: 20px 0px;
    }
    .fa {
        color: #4183D7;
    }
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
        position: fixed;
        bottom: 100;
        width: 100%;
    }
    a {
        text-decoration: none;
        color: #0062cc;
        border-bottom: 2px solid #0062cc;
    }
    .box-part {
        background: #FFF;
        border-radius: 0;
        padding: 20px 6px;
        margin: 10px 0px;
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
    <br>

    <div class="row">
        <div class="col-4 pl-0">
            <span>Dr <small>{{ $prescription->user->name }} {{ $prescription->user->prenom }}</small></span><br>
            <span><small>{{ $prescription->user->specialite ?? '' }}</small></span><br>
            <span>Onmc: <small>{{ $prescription->user->onmc ?? '' }}</small></span>
        </div>
        <div class="col-6 offset-6">
            <p>Douala, le {{ $printDate }}</p>
        </div>
    </div>

    <br>
    <div class="row">
        <div>
            <div class="box-part">
                <p><u>PATIENT</u>: <small>{{ $prescription->patient->name }} {{ $prescription->patient->prenom }}</small></p>
            </div>
        </div>
    </div>

    <br><br>
    <div class="text-center">
        <h3><u>BULLETIN EXAMEN(S)</u></h3>
    </div>
    <br>

    <div class="row">
        <div>
            @if($prescription->hematologie)
                <div class="title">
                    <h5><u>HEMATOLOGIE</u></h5>
                    {{ $prescription->hematologie }}
                </div><br>
            @endif

            @if($prescription->hemostase)
                <div class="title">
                    <h5><u>HEMOSTASE</u></h5>
                    {{ $prescription->hemostase }}
                </div><br>
            @endif

            @if($prescription->biochimie)
                <div class="title">
                    <h5><u>BIOCHIMIE</u></h5>
                    {{ $prescription->biochimie }}
                </div><br>
            @endif

            @if($prescription->serologie)
                <div class="title">
                    <h5><u>SEROLOGIE</u></h5>
                    {{ $prescription->serologie }}
                </div><br>
            @endif

            @if($prescription->hormonologie)
                <div class="title">
                    <h5><u>HORMONOLOGIE</u></h5>
                    {{ $prescription->hormonologie }}
                </div><br>
            @endif

            @if($prescription->marqueurs)
                <div class="title">
                    <h5><u>MARQUEURS</u></h5>
                    {{ $prescription->marqueurs }}
                </div><br>
            @endif

            @if($prescription->bacteriologie)
                <div class="title">
                    <h5><u>BACTERIOLOGIE</u></h5>
                    {{ $prescription->bacteriologie }}
                </div><br>
            @endif

            @if($prescription->spermiologie)
                <div class="title">
                    <h5><u>SPERMIOLOGIE</u></h5>
                    {{ $prescription->spermiologie }}
                </div><br>
            @endif

            @if($prescription->urines)
                <div class="title">
                    <h5><u>URINES</u></h5>
                    {{ $prescription->urines }}
                </div>
            @endif
        </div>
    </div>

    
</div>