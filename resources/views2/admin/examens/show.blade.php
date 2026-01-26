@extends('layouts.admin')

@section('title', 'CMCU | dossier patient')


@section('content')

    <body>
    <div class="wrapper">
    @include('partials.side_bar')

    <!-- Page Content Holder -->
        @include('partials.header')
  <div class="row" style="text-align:center; pading-top: 50px;">
 
    
        <div class="col-sm-9" style="pading-top: 30px;">
            <img   src="{{ asset('images/' . $examens->image) }}" heigth="1000px" width="800px" >
            
            <div style="text-align:center; pading-top: 50px; ">
                <br>
                <h3>TYPE D'EXAMEN : {{$examens->type}}</h3>
            </div>
          
        </div>
        
    </div>
   
   
    </body>

@stop
