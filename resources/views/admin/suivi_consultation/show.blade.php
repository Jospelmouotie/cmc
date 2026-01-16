@extends('layouts.admin')
@section('title', 'CMCU | Renseignement du dossier patient')
@section('content')
  
    {{--<div class="se-pre-con"></div>--}}
    <div class="wrapper">
    @include('partials.side_bar')
    <!-- Page Content Holder -->
        @include('partials.header')
        @can('chirurgien', \App\Models\Patient::class)
        <div id="products" class="row view-group">
                <div class="item col-xs-4 col-lg-4">
                    <div class="thumbnail card">
                        
                        <div class="caption card-body">
                            <h4 class="group card-title inner list-group-item-heading">
                                Interrogatoire</h4>
                            <p class="group inner list-group-item-text">
                                    {{ $consultationdesuivi->interrogatoire }}</p>
                                <br>
                                <div class="row">
                               
                                <div class="col-xs-12 col-md-6">
                                    <a class="btn btn-success">{{ $consultationdesuivi->date_creation }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item col-xs-4 col-lg-4">
                    <div class="thumbnail card">
                        
                        <div class="caption card-body">
                            <h4 class="group card-title inner list-group-item-heading">
                                Commentaire</h4>
                            <p class="group inner list-group-item-text">
                               {{ $consultationdesuivi->commentaire }}</p>
                                <br>
                                <div class="row">
                                
                                <div class="col-xs-4 col-md-6">
                                    <a class="btn btn-success">{{ $consultationdesuivi->date_creation }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
              
            </div>
        @endcan
@stop
