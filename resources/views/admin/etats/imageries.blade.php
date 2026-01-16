<link href="{{ public_path('vendor/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" media="all" />
<style>

    body{
        background:  #FFF;;
    }
    span{
        font-size:15px;
    }
    .text{
        margin:20px 0px;
    }

    .fa{
        color:#4183D7;
    }
.cpi-titulo3 {
        font-size: 12px;
    }
    
    .logo {
        width: 100px;
    }
    
    p {
        line-height: 43%;
    }
    
    hr {
        display: block;
        height: 1px;
        border: 0;
        border-top: 1px solid red;
        margin: 1em 0;
        padding: 0;
    }
    
    .footer {
        padding-top: 1px;
        padding-bottom: 15px;
        position: fixed;
        bottom: 5;
        width: 100%;
    }
    
    background: #eee;
}
span {
    font-size: 15px;
}
a {
    text-decoration: none;
    color: #0062cc;
    border-bottom: 2px solid #0062cc;
}
.box {
    padding: 30px 0px;
}
.box-part {
    background: #FFF;
    border-radius: 0;
    padding: 20px 6px;
    margin: 10px 0px;
    
}
.box-a {
    background: #FFF;
    border-radius: 0;
    padding: 20px 6px;
    margin: 10px 0px;
    float:right;
}
.text {
    margin: 5px 0px;
}
.fa {
    color: #4183D7;
}


</style>
<div class="container-fluid">

    <div class="row">
        <div class="col-2">
            <img class="logo img-responsive float-left" src="{{ public_path('admin/images/logo.jpg') }}">
        </div>
        <div class="col-6 offset-3">
            <div class="text-center">
                <h4>CENTRE MEDICO-CHIRURGICAL D'UROLOGIE</h4>
                <p class="mt-2"><small>ONMC : N° 5531 007/10/D/ONMC</small></p>
                <p><small> Arrêté N° 3203/A/MINSANTE/SG/DOSTS/SDOS/SFSP </small></p>
                <p>VALLEE MANGA BELL DOUALA-BALI</p>
                <p>Consultation sur RDV </p>
                <p><small>TEL:(+237) 233 423 389 / 674 068 988 / 698 873 945</small></p>
                <p>Email : <small> contac@yahoo.fr</small></p>
                <p>Site internet : <small> www.cmcu-cm.com</small></p>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <hr class="text-danger">
    </div>
    <br>
    <br>
    <div class="row">
    <div class="box-a ">
            <p><small><u>Douala:</u><b> {{ $date = \Carbon\Carbon::now()->toFormattedDateString() }}</b></small></p>
        </div>
     </div><br>
     <br>
     <br>
        <div class="row">
        <div >
        
        <div class="box-part ">
           <div class="title">
            <p> <u>PATIENT</u>: <small>{{ $imageries->patient->name }}</small></p>
           
             </div>
            
        </div>
        
        </div>
        <div class="box-a">
            
            <div class="title">
            <p><u>DR</u> : <small> {{ $imageries->user->prenom }} {{ $imageries->user->name }} </small></p>

                </div>
            
        </div>
       </div>
    <br>
    <br>
     <div class="text-center"><h3><u>EXAMEN(S) IMAGERIE(S)</u> </h3></div>
    <br>
    <di>
    <div class="row">
        <div >
            
                <div class="title">
                    @if($imageries->radiographie)
                    <h5><u>RADIOGRAPHIE</u></h5>
                    {{$imageries->radiographie}}
                    @else
                    @endif

                </div><br>
                <div class="title">
                    @if($imageries->echographie)
                    <h5><u>ECHOGRAPHIE</u></h5>
                    {{$imageries->echographie}}
                    @else
                    @endif
                </div> <br>   
                <div class="title">
                    @if($imageries->scanner)
                    <h5><u>SCANNER</u></h5>
                    {{$imageries->scanner}}
                    @else
                    @endif
                </div><br>
                <div class="title">
                    @if($imageries->irm)
                    <h5><u>IRM</u></h5>
                    {{$imageries->irm}}
                    @else
                    @endif
                </div><br>
                <div class="title">
                    @if($imageries->scintigraphie)
                    <h5><u>SCINTIGRAPHIE</u></h5>
                    {{$imageries->scintigraphie}}
                    @else
                    @endif
                </div><br>
                <div class="title">
                    @if($imageries->autre)
                    <h5><u>AUTRES</u></h5>
                    {{$imageries->autre}}
                    @else
                    @endif
                </div>
                
        </div>
            
    </div>
