<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>LETTRE DE CONSULTATION {{ $patient->name }} {{ $patient->prenom }}</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 14px;
            line-height: 1.4;
            color: #333;
        }
        .logo {
            width: 100px;
            height: auto;
        }
        .header-center {
            text-align: center;
            line-height: 1.3;
        }
        .footer {
            position: fixed;
            bottom: 80px;
            width: 100%;
        }
        .footer-info {
            text-align: center;
            margin-top: 50px;
            font-size: 12px;
        }
        .underline {
            text-decoration: underline;
        }
        .bold {
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .mb-2 { margin-bottom: 0.5rem; }
        .mt-2 { margin-top: 0.5rem; }
        hr {
            border-top: 2px solid #4463dc; /* Bootstrap primary */
            margin: 1.5rem 0;
        }
        .text-right { text-align: right; }
        .underline { text-decoration: underline; }
        .bold { font-weight: bold; }
        .footer {
            position: fixed;
            bottom: 80px;
            width: 100%;
        }
        .footer-info {
            text-align: center;
            margin-top: 50px;
            font-size: 12px;
        }
    </style>
</head>
<body>
<div class="container">
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
                <p>ONMC : N° 5531 007/10/D/ONMC</p>
                <p>Arrêté N° 3203/A/MINSANTE/SG/DOSTS/SDOS/SFSP</p>
                <p>VALLEE MANGA BELL DOUALA-BALI</p>
                <small>TEL: (+237) 233 423 389 / 674 068 988 / 698 873 945</small><br>
                <small>Consultation sur RDV</small><br>
                <small>Email : info@cmcu-cm.com</small><br>
                <small>www.cmcu-cm.com</small>
            </td>
        </tr>
    </table>

    <hr>

    <div style="display: flex; justify-content: space-between;">
        <div>
            
                <span>Dr <small>{{ $consultations->user->name }} {{ $consultations->user->prenom }}</small></span><br>
                <span><small>{{ $consultations->user->specialite }}</small></span><br>
                <span>Onmc: <small>{{ $consultations->user->onmc }}</small></span>
           
        </div>
        <div class="text-right">
            <p>Douala, le {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        </div>
    </div>

    <div>
        Ref: {{ $patient->numero_dossier }}/{{ $consultations->id ?? 'N/A' }}
    </div>

    <br>

    <div style="text-align: center; margin: 20px 0;">
        <h4 class="underline">LETTRE DE CONSULTATION</h4>
    </div>

    @php
        $civilite = $dossier && $dossier->sexe === 'Masculin' ? 'M.' : 'Mme';
    @endphp

    <div style="text-align: center; margin-bottom: 20px;">
        <p>Concernant {{ $civilite }} {{ $patient->name }} {{ $patient->prenom }}</p>
    </div>

    <p>Cher confrère, {{ $consultations->medecin ?? '...' }}</p>

    <p style="line-height: 140%;">
        Je vois à la consultation d’urologie ce {{ $consultations ? \Carbon\Carbon::parse($consultations->created_at)->translatedFormat('d F Y') : '[date inconnue]' }}
        {{ $civilite }}
        <span class="bold">{{ $patient->name }} {{ $patient->prenom }}</span>
        @if($dossier && $dossier->date_naissance)
            né{{ $civilite === 'Mme' ? 'e' : '' }} le {{ \Carbon\Carbon::parse($dossier->date_naissance)->translatedFormat('d F Y') }}.
        @else
            [date de naissance inconnue].
        @endif
    </p>

    @if($consultations)
        @if($consultations->motif_c)
            <p><span class="bold underline">MOTIF DE CONSULTATION :</span> {{ $consultations->motif_c }}</p>
            @if($consultations->antecedent_m)
                <p>Signalons également les antécédents suivants :<br>{!! nl2br(e($consultations->antecedent_m)) !!}</p>
            @endif
        @endif

        @if($consultations->examen_c)
            <p><span class="bold underline">EXAMEN(S) COMPLEMENTAIRE(S) :</span><br>{!! nl2br(e($consultations->examen_c)) !!}</p>
        @endif

        @if($consultations->proposition_therapeutique)
            <p><span class="bold underline">PROPOSITION THERAPEUTIQUE :</span><br>{!! nl2br(e($consultations->proposition_therapeutique)) !!}</p>
        @endif

        @if($consultations->diagnostic)
            <p><span class="bold underline">DIAGNOSTIC :</span><br>{!! nl2br(e($consultations->diagnostic)) !!}.</p>
        @endif

        @if($consultations->proposition)
            @switch($consultations->proposition)
                @case('Hospitalisation')
                    <p>Le patient sera hospitalisé pour un suivi médical.</p>
                    @break
                @case('Consultation')
                    <p>Le patient sera revu en consultation le {{ $consultations->date_consultation ? \Carbon\Carbon::parse($consultations->date_consultation)->translatedFormat('d F Y') : 'date non précisée' }}.</p>
                    @break
                @case('Consultation d\'anesthésiste')
                    <p>Le patient est programmé pour une consultation avec l'anesthésiste en date du {{ $consultations->date_consultation ? \Carbon\Carbon::parse($consultations->date_consultation)->translatedFormat('d F Y') : 'date non précisée' }}.</p>
                    @break
                @case('Intervention chirurgicale')
                    <p>Il a été clairement expliqué au patient la nécessité de recourir à un geste chirurgical dont les détails sont contenus dans la fiche d'intervention.</p>
                    @break
                @case('Actes à réaliser')
                    @if($consultations->acte)
                        <p><span class="bold underline">ACTES A REALISER :</span><br>{!! nl2br(e($consultations->acte)) !!}</p>
                    @endif
                    @break
            @endswitch
        @endif
    @else
        <p><em>Aucune donnée de consultation disponible.</em></p>
    @endif

    <br><br>
    <p>Je reste bien entendu à votre entière disposition pour tout échange d'informations.</p>
    <br>
    <p>Bien Confraternellement,</p>

</div>
</body>
</html>









