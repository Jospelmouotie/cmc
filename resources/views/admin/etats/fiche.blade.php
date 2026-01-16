<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ public_path('vendor/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" media="all" />
    <style>
        body { font-size: 10px }

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
        td {
            vertical-align: middle;
        }
        .container{
            border: 1px solid #000;
        }
        .logo{
            width: 50px;
            padding-top: 10px;
        }

        h2{
            width: 50%;
            margin: auto;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row text-center">
        <img class="logo" src="{{ public_path('admin/images/logo.jpg') }}" alt="">
        <h5><strong>CENTRE MEDICO-CHIRURGICAL D'UROLOGIE</strong></h5>
        <strong>VALLEE MANGA BELL DOUALA-BALI</strong><br>
        <strong>TEL: (+ 237) 233 423 389 / 674 068 988 / 698 873 945</strong><br>
        <strong>www.cmcu-cm.com</strong><br>
    </div>
    <h1> FICHE DE SATISFACTION</h1>
    <br>

                <h2 class ="btn btn-primary text-bold text-center" > INFORMATION DU PATIENT </class>  </h2>
            <br>
            <br>
            <h6>NOM : .............................................................................. <h8>{{$fiche->nom}}</h8></h6>
            <br>
            <h6>PRENOM : .............................................................................. {{$fiche->prenom}} </h6>
            <br>
             <h6>NUMERO DE CHAMBRE : .............................................................................. {{$fiche->chambre_numero}} </h6>
            <br>
            <h6>AGE : .............................................................................. {{$fiche->age}}</h6>
            <br>
                <h2 class= "btn btn-success text-bold text-center" > AVIS  DU PATIENT </class> </h2>
                <br>
                <br>
            <h6>SERVICE : .............................................................................. {{$fiche->service}} </h6>
            <br>
            <h6>INFIRMIER EN CHARGE : .............................................................................. {{$fiche->infirmier_charge}} </h6>
            <br>
            <h6>ACCUEIL : .............................................................................. {{$fiche->accueil}} </h6>
            <br>
            <h6>RESTAURANT : .............................................................................. {{$fiche->restauration}} </h6>
            <br>
            <h6>CHAMBRE : .............................................................................. {{$fiche->chambre}} </h6>
            <br>
            <h6>SOINS : .............................................................................. {{$fiche->soins}} </h6>

             <h2 class= "btn btn-danger text-bold text-center" > REMARQUE ET SUGGESTION</class> </h2>
            <h6>UNE NOTE : .............................................................................. {{$fiche->notes}} </h6>
            <br>
            <h6>SUGGEREZ VOUS LE CMCU A QUELQU'UN ? : .............................................................................. {{$fiche->quizz}} </h6>
            <br>
            <h6>SUUGESTIONS ET REMARQUES : .............................................................................. {{$fiche->remarque_suggestion}} </h6>

</div>
</body>
</html>
