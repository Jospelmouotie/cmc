@extends('layouts.admin') @section('title', 'CMCU | Liste des chambres') @section('content')

    <body>
    {{--<div class="se-pre-con"></div>--}}
    <div class="wrapper">
    @include('partials.side_bar')

    <!-- Page Content Holder -->
    @include('partials.header')
    <!--// top-bar -->
        @can('create', \App\Models\chambre::class)
        <div class="container">
            <h1 class="text-center">LISTE DES CHAMBRES</h1>
        </div>
        <hr>
        <div class="container">
            <div class="col-12">
                <div class="row">
                    <div class="col-md-4">
                        <a href="{{ url('/admin/chambres/?categorie=VIP') }}" class="btn btn-success">VIP</a>
                        <a href="{{ url('/admin/chambres/?categorie=CLASSIQUE') }}" class="btn btn-primary">CLASSIQUE</a>
                        <a href="{{ url('/admin/chambres/?categorie=BLOC OPERATOIRE') }}" class="btn btn-info">BLOC</a>
                        <a href="{{ url('/admin/chambres') }}" class="btn btn-info"><i class="fas fa-rotate"></i></a>
                    </div>
                </div>
            </div>
            <br>
            <div class="col-lg-12">
                <div class="table-responsive">
                    <!--  -->
                    <i class="table_info">Les montants sont exprimés en <b> FCFA</b></i>
                    <table id="myTable" class="table table-bordered table-hover" width="100%">
                        <thead>
                        <tr>
                            <td>ID</td>
                            <td>NUMERO</td>
                            <td>CATEGORIE</td>
                            <td>PRIX</td>
                            <td>STATUT</td>
                            <td>PATIENT</td>
                            <td>DUREE</td>
                            <td>ACTION</td>
                        </tr>
                        <tbody>
                        @foreach($chambres as $chambre)
                            <tr>
                                <td>{{$chambre->id}}</td>
                                <td>{{$chambre->numero}}</td>
                                <td>{{$chambre->categorie}}</td>
                                <td>{{$chambre->prix}}</td>
                                @if($chambre->statut == 'occupé')
                                    <td><span class="badge badge-danger">{{$chambre->statut}}</span></td>
                                @elseif($chambre->statut == 'libre')
                                    <td><span class="badge badge-primary">{{$chambre->statut}}</span></td>
                                @endif
                                <td>
                                    @if($chambre->patient && $chambre->patient != 'null')
                                        <strong>{{ $chambre->patient }}</strong>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($chambre->jour && $chambre->jour != 'null')
                                        {{ $chambre->jour }} jour(s)
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @can('update', \App\Models\User::class)
                                    <a href="{{ route('chambres.edit',$chambre->id)}}" class="btn btn-primary btn-sm" title="Modifier les informations de la chambre"><i class="far fa-edit"></i>
                                    </a>
                                    @endcan
                                    @if($chambre->statut == 'occupé')
                                        <form style="display: inline-flex;" action="{{ route('chambres_minus.update',$chambre->id)}}" method="post">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="patient" value="null">
                                            <input type="hidden" name="statut" value="libre">
                                            <input type="hidden" name="jour" value="null">
                                            <p data-bs-placement="top" data-bs-toggle="tooltip" title="Liberer la chambre">
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-minus"></i></button>
                                            </p>
                                        </form>
                                    @endif
                                    @if($chambre->statut == 'libre')
                                        <a href="{{ route('chambres.attribute',$chambre->id)}}" class="btn btn-success btn-sm" title="Attribuer cette chambre à un patient"><i class="fas fa-plus"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{--{{ $chambres->links() }}--}}
                </div>

            </div>
        </div> </br>
        <div class="col-md-3 offset-md-4 text-center">
            @can('update', \App\Models\User::class)
            <a href="{{ route('chambres.create') }}" class="btn btn-primary table_link_right">Ajouter une nouvelle chambre</a>
            @endcan
        </div>
       @endcan
    </div>
    </div>
    </body>

@endsection