<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <meta name="viewport"  http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <!-- <link href="{{ public_path('admin/css/bootstrap5.3.8.css') }}" rel="stylesheet" type="text/css" media="all" /> -->
    <link href="{{ public_path('vendor/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" media="all" />
    <style>
        body { font-size: 3px }
        thead > tr > th {
            text-align: center;
            padding: 5px;
        }
        td {
            vertical-align: middle;
        }
        .container{
            border: 1px solid #000;
        }
        .logo{
            width: 40px;
            padding-top: 10px;
        }
        #inventory-invoice{
            padding: 20px;
        }
        #inventory-invoice a{text-decoration:none ! important;}
        .invoice {
            position: relative;
            background-color: #FFF;
            min-height: 480px;
            padding: 12px
        }
        .invoice header {
            padding: 10px 0;
            margin-bottom: 10px;
            border-bottom: 1px solid #3989c6
        }
        .invoice .company-details {
            text-align: right
        }
        .invoice .company-details .name {
            margin-top: 0;
            margin-bottom: 0
        }
        .invoice .contacts {
            margin-bottom: 10px;
            text-align: center
        }
        .invoice .invoice-to {
            text-align: start
        }
        .invoice .invoice-to .to {
            margin-top: 0;
            margin-bottom: 0
        }
        .invoice .invoice-details {
            text-align: right
        }
        .invoice .invoice-details .invoice-id {
            margin-top: 0;
            text-align: center;
            color: #3989c6
        }
        .invoice main {
            padding-bottom: 30px
        }
        .invoice main .thanks {
            margin-top: -50px;
            font-size: 2em;
            margin-bottom: 50px
        }
        .invoice main .notices {
            padding-start: 6px;
            border-start: 6px solid #3989c6
        }
        .invoice main .notices .notice {
            font-size: 1.2em
        }
        .invoice table {
            width: 90%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px
        }
        .invoice table td,.invoice table th {
            padding: 10px;
            background: #eee;
            border-bottom: 1px solid #fff
        }
        .invoice table th{
            white-space: nowrap;
            font-weight: 300;
            font-size: 14px;
            border:1px solid #fff;
        }
        .invoice table td{
            border:1px solid #fff;
        }
        .invoice table td h3 {
            margin: 0;
            font-weight: 300;
            color: #3989c6;
            font-size: 1.2em
        }
        .invoice table .tax,.invoice table .total,.invoice table .unit {
            text-align: right;
            font-size: 1.2em
        }
        .invoice table .no {
            color: #fff;
            font-size: 1.6em;
            background: #17a2b8
        }
        .invoice table .unit {
            background: #ddd
        }
        .invoice table .total {
            background: #17a2b8;
            color: #fff
        }
        .invoice table tfoot td {
            background: 0 0;
            border-bottom: none;
            white-space: nowrap;
            text-align: right;
            padding: 10px 20px;
            font-size: 1.2em;
            border-top: 1px solid #aaa
        }
        .invoice table tfoot tr:first-child td {
            border-top: none
        }
        .invoice table tfoot tr:last-child td {
            color: #3989c6;
            font-size: 1.4em;
            border-top: 1px solid #3989c6
        }
        .invoice table tfoot tr td:first-child {
            border: none
        }
        .invoice footer {
            width: 90%;
            text-align: center;
            color: #777;
            font-size: 6px;
            border-top: 1px solid #aaa;
            padding: 4px 0
        }
        @media print {
            .invoice {
                font-size: 11px!important;
                overflow: hidden!important
            }
            .invoice footer {
                position: absolute;
                bottom: 10px;
                page-break-after: always
            }
            .invoice>div:last-child {
                page-break-before: always
            }
        }
        
    </style>
</head>
<body>

<div class="container">
    <div class="row text-center">
        <img class="logo" src="{{ public_path('admin/images/logo.jpg') }}" alt="">
        <h6><strong>CENTRE MEDICO-CHIRURGICAL D'UROLOGIE</strong></h6>
        <h6>VALLEE MANGA BELL DOUALA-BALI</h6>
        <h6>TEL: (+ 237) 233 423 389 / 674 068 988 / 698 873 945</h6>
        <p><h6>www.cmcu-cm.com</h6></p>
    </div>

<div id="inventory-invoice">

    <div class="invoice overflow-auto">
        <div style="min-width: 500px">
            <main>
                <div class="row contacts">

                    <div  class="col invoice-details ">
                        <h6 class="invoice-id">RECU:{{ $clients->motif }}</h6>
                        <br>
                    </div>
                </div>
                @if($clients->assurance)
                <h6 class="text-center">ASSURANCE:{{ $clients->assurance }}</h6>
                @else
                @endif
                <h6 class="text-center">{{ $clients->demarcheur }}</h6>
                @if($clients->assurance)
                <h6>PART PATIENT: {{ $clients->partpatient }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PART ASSURANCE: {{ $clients->partassurance }}</h6>
                @else
            @endif  
                <table border="0" cellspacing="0" cellpadding="0">
                <thead>
                        <tr>
                            <th class="text-start">NOM</th>
                            <th class="text-start">PRENOM</th>
                            <th class="text-start"> MONTANT (FCFA)</th>
                            <th class="text-start"> AVANCE </th>
                            <th class="text-start"> RESTE </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-start" ><h5> {{ $clients->nom }}</h5></td>
                            <td class="text-start" ><h5> {{ $clients->prenom }}</h5></td>
                            <td class="text-start"><h4> {{ $clients->montant }}</h4></td>
                            @if($clients->avance)
                            <td class="text-start"><h4>{{ $clients->avance }}</h4></td>
                            @else
                            <td class="text-start"><h4>0</h4></td>
                            @endif
                            @if($clients->avance)
                            <td class="text-start"><h4>{{ $clients->reste }}</h4></td>
                            @else
                                <td class="text-start"><h4>0</h4></td>
                            @endif
                        </tr>
                    <tr>
                        <div class="notices">
                            <H6><div>LA CAISSE:{{ $clients->user->prenom }} {{ $clients->user->nom }}</div></H6>
                            <H6><div class="notice">Douala,{{ $clients->created_at->toFormattedDateString() }}</div></H6>
                        </div>
                    </tr>
                    </tbody>
                  </table>
                </main>
            <footer>
                Centre Medico-churirgical d'urologie situé à la Vallée Douala Manga Bell Douala-Bali.
                            TEL: (+ 237) 233 423 389 / 674 068 988 / 698 873 945.
                            SITE WEB: http://www.cmcu-cm.com
            </footer>
        </div>
    </div>
</div>
    <div class="row text-center">
        <img class="logo" src="{{ asset('admin/images/logo.jpg') }}" alt="">
        <h6><strong>CENTRE MEDICO-CHIRURGICAL D'UROLOGIE</strong></h6>
        <h6>VALLEE MANGA BELL DOUALA-BALI</h6>
        <h6>TEL: (+ 237) 233 423 389 / 674 068 988 / 698 873 945</h6>
        <p><h6>www.cmcu-cm.com</h6></p>
    </div>
    <div id="inventory-invoice">

    <div class="invoice overflow-auto">
        <div style="min-width: 300px">
            <main>
                <div class="row contacts">

                    <div  class="col invoice-details ">
                        <h6 class="invoice-id">RECU:{{ $clients->motif }}</h6>
                        <br>
                    </div>
                </div>
                @if($clients->assurance)
                <h6 class="text-center">ASSURANCE:{{ $clients->assurance }}</h6>
                @else
                @endif
                <h6 class="text-center">{{ $clients->demarcheur }}</h6>
                @if($clients->assurance)
                  <h6>PART ASSURANCE: {{ $clients->partpatient }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PART PATIENT: {{ $clients->partassurance }}</h6>
                  @else
               @endif  
                 <table border="0" cellspacing="0" cellpadding="0">
                <thead>
                        <tr>
                            <th class="text-start">NOM</th>
                            <th class="text-start">PRENOM</th>
                            <th class="text-start"> MONTANT (FCFA)</th>
                            <th class="text-start"> AVANCE </th>
                            <th class="text-start"> RESTE </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-start" ><h5> {{ $clients->nom }}</h5></td>
                            <td class="text-start" ><h5> {{ $clients->prenom }}</h5></td>
                            <td class="text-start"><h4> {{ $clients->montant }}</h4></td>
                            @if($clients->avance)
                            <td class="text-start"><h4>{{ $clients->avance }}</h4></td>
                            @else
                            <td class="text-start"><h4>0</h4></td>
                            @endif
                            @if($clients->avance)
                            <td class="text-start"><h4>{{ $clients->reste }}</h4></td>
                            @else
                                <td class="text-start"><h4>0</h4></td>
                            @endif
                        </tr>
                    <tr>
                        <div class="notices">
                           <H6><div>LA CAISSE:{{ $clients->user->prenom }} {{ $clients->user->nom }}</div></H6>
                           <H6><div class="notice">Douala,{{ $clients->created_at->toFormattedDateString() }}</div></H6>
                        </div>
                    </tr>
                    </tbody>
                  </table>
                </main>
            <footer>
                Centre Medico-churirgical d'urologie situé a la Vallée Douala Manga Bell Douala-Bali.
                              TEL: (+ 237) 233 423 389 / 674 068 988 / 698 873 945.
                              SITE WEB: http://www.cmcu-cm.com
            </footer>
        </div>
     </div>
</div>
</div>
    </div>
</div>
</body>
</html>


















