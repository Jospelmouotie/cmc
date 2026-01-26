@extends('layouts.admin')

@section('title', 'CMCU | dossier patient')


@section('content')
<style>
        .grid-container {
            display: grid;
            grid-gap: 30px 60px;
            grid-template-columns: auto auto auto;
            padding: 10px;
        }
        .grid-item {
            background-color: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(0, 0, 0, 0.8);
            padding: 10px;
            font-size: 12px;
            margin-right: 1px;

        }

        .center-div{
            margin: 0 auto 0px;
            width: 100px;

            
        }
    </style>
    <body>


    <div class="wrapper">
    @include('partials.side_bar')

    <!-- Page Content Holder -->
        @include('partials.header')
       

    <div class="row">
          
            <div class="col-md-7 ">
                <!-- resumt -->
                <div class="card text-center mb-3">
                    <div class="card-header resume-heading">
                        <div class="row">
                            <div class="col-xl-12">
                      
                                <div class="col-12 col-md-9">
                                    <ul class="list-group">
                                        <li class="list-group-item">MEDECIN :  {{("$consultations->medecin_r")}}</li>
                                        <li class="list-group-item">GROUPE SANGUIN : {{("$consultations->groupe")}}</li>
                                        <li class="list-group-item">ALLERGIE : {{("$consultations->allergie")}}</li>
                                        <li class="list-group-item">ANTECEDENT MEDICAL : {{("$consultations->antecedent_m")}}</li>
                                        <li class="list-group-item">ANTECEDENT CHIRURGICAUX : {{("$consultations->antecedent_c")}}</li>
                                        <li class="list-group-item"><i class="fa fa-envelope"></i> john@example.com</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> <br>
                    <div class="bs-callout bs-callout-danger ">
                        <h4>DIAGNOSTIQUE</h4>
                        <p>{{("$consultations->diagnostic")}}</p>
                        
                    </div><br>
                    <div class="bs-callout bs-callout-danger">
                        <h4>INTERROGATOIRE</h4>
                        <p> {{("$consultations->interrogatoire")}}</p>
                    </div><br>
                    <div class="bs-callout bs-callout-danger">
                            <h4>PROPOSITION</h4>
                       
                            <p >{{("$consultations->proposition")}}</p>

                    </div><br>

                    <div class="bs-callout bs-callout-danger">
                            <h4>MOTIF DE LA CONSULTATION</h4>
                       
                            <p >{{("$consultations->motif_c")}}</p>

                    </div>   
                     <p></p>

                            </a>
                </div>
            </div>
            <!-- resume -->
        </div>

    </div>



</div>


       


    </body>

@stop
