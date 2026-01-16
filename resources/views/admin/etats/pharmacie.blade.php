<!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <link href="{{ public_path('vendor/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" media="all" />
                <style>
                    body { font-size: 7px }

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
                        width: 30px;
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
                        text-align: left
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
                        padding-left: 6px;
                        border-left: 6px solid #3989c6
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
                        padding: 15px;
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
                        border-top: 1px solid #aaa;
                        padding: 8px 0
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
                    <strong>VALLEE MANGA BELL DOUALA-BALI</strong><br>
                    <strong>TEL: (+ 237) 233 423 389 / 674 068 988 / 698 873 945</strong><br>
                    <strong>www.cmcu-cm.com</strong><br>
                </div>

                <div id="inventory-invoice">
                    <div class="invoice overflow-auto">
                        <div style="min-width: 300px">
                            <main>
                                <div class="row contacts">

                                    <div  class="col invoice-details ">
                                        <h4 class="invoice-id">FACTURE N°{{ $facture->numero }}</h4>
                                        <br>

                                        <div class="date">{{ $date = \Carbon\Carbon::now()->toDateTimeString() }}</div>
                                    </div>
                                </div>
                                <table border="0" cellspacing="0" cellpadding="0">
                                    <thead>
                                    <tr>
                                        <th class="text-left">DESIGNATION</th>
                                        <th class="text-left">QUANTITE</th>
                                        <th class="text-left">PRIX UNITAIRE</th>
                                        <th class="text-left">TOTAL</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($produits as $produit)
                                        <tr>
                                            <td class="text-left"><h3> {{ $produit['item']['designation'] }}</h3></td>
                                            <td class="text-left"><h3> {{ $produit['quantite'] }}</h3></td>
                                            <td class="text-left"><h3> {{ $produit['prix_unitaire'] }}</h3></td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-left"><h3> {{ $totalPrix }} XAF</h3></td>
                                    </tr>
                                    <tr>
                                        @if(auth()->user()->role_id === '5')
                                        <div class="notices">
                                            <H4><div>LA PHARMACIE</div></H4>
                                            <div class="notice"><b>Pharmacien :</b>{{ auth()->user()->name }} {{ auth()->user()->prenom }}</div>
                                            <div class="notice"><b>Patient : </b>{{ $patient }}</div>
                                        </div>
                                        @endif
                                        @if(auth()->user()->role_id === '2')
                                        <div class="notices">
                                            <H4><div>LA PHARMACIE</div></H4>
                                            <div class="notice"><b>Anesthésiste :</b>{{ auth()->user()->name }} {{ auth()->user()->prenom }}</div>
                                            <div class="notice"><b>Patient : </b>{{ $patient }}</div>
                                        </div>
                                        @endif
                                    </tr>
                                    </tbody>
                                </table>
                            </main>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
            </body>
            </html>

