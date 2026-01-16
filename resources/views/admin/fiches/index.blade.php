@extends('layouts.admin') @section('title', 'CMCU | Liste des produits') @section('content')

<body>
{{--<div class="se-pre-con"></div>--}}
<div class="wrapper">
    @include('partials.side_bar')

    <!-- Page Content Holder -->
    @include('partials.header')
    <!--// top-bar -->
    <div class="container">
        <h1 class="text-center ">LISTE DE FICHES DE SATISFACTIONS</h1>
    </div>
    <hr>
        <div class="col-3 offset-8 text-center">
            <a href="" class=" btn btn-danger "><span class="glyphicon glyphicon-ok-sign"></span>&#xA0;
                <h2>TOTAL FICHES :</h2>
                <h1><P>{{ $fiche->total() }}</P> </h1>
            </a>
        </div>
        <br>
    <div class="container">
        <div class="col-lg-12">
            <div class="table-responsive">
                <!--  -->
                <table id="myTable" class="table table-bordered table-striped" width="100%">
                    <thead>
                    <tr>
                        <td>ID</td>
                        <td>NOM</td>
                        <td>PRENOM</td>

                        <td>INFIRMIER EN CHARGE</td>
                        <td>ACCUEIL</td>
                        <td>RESTAURANT</td>
                        <td>CHAMBRE</td>
                        <td>SOINS</td>
                        <td>UNE NOTE</td>
                        <td>VOIR</td>
                        <td>EDITER</td>
                        <td>IMPRIMER</td>
                        <td>SUPPRIMER</td>
                    </tr>
                    <tbody>
                    @foreach($fiche as $fiches)
                    <tr>
                        <td>{{$fiches->id}}</td>
                        <td>{{$fiches->nom}}</td>
                        <td>{{$fiches->prenom}}</td>

                        <td>{{$fiches->infirmier_charge}}</td>
                        <td>{{$fiches->accueil}}</td>
                        <td>{{$fiches->restauration}}</td>
                        <td>{{$fiches->chambre}}</td>
                        <td>{{$fiches->soins}}</td>
                        <td>{{$fiches->notes}}</td>
                        <td><a href="{{ Route('fiches.show', $fiches->id)}}" class="btn btn-primary"><i class="fas fa-eye"></i></a></td>
                        <td><a href="{{ Route('fiches.edit', $fiches->id)}}" class="btn btn-primary"><i class="far fa-edit"></i></a></td>
                        <td>
                            <p data-bs-placement="top" data-bs-toggle="tooltip" title="Imprimer">
                                <a class="btn btn-success btn-sm" title="Imprimer" href="{{ route('fiche.pdf', $fiches->id) }}"><i class="fas fa-print"></i></a>
                            </p>
                        </td>
                        <td>
                            <form action="{{ route('fiches.destroy', $fiches->id)}}" method="post">
                                @csrf @method('DELETE')
                                <p data-bs-placement="top" data-bs-toggle="tooltip" title="Delete">
                                    <button type="submit" class="btn btn-danger btn-sm"  onclick="return myFunction()"><i class="fas fa-trash-alt"></i></button>
                                </p>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                {{--{{ $fiche->links() }}--}}
            </div>

        </div>
    </div> </br>
    <div class="table_link_right text-center">
        <a href="{{ Route('fiches.create')}}" class="btn btn-primary" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>&#xA0;AJOUTER UNE NOUVELLE FICHE</a>
    </div>
</div>
</div>
<script src="{{ asset('admin/js/main.js') }}"></script>
</body>

@endsection
