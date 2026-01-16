@extends('layouts.admin') @section('title', 'CMCU | Modifier une chambre') @section('content')

    <body>
    {{--<div class="se-pre-con"></div>--}}
    <div class="wrapper">
    @include('partials.side_bar')

    <!-- Page Content Holder -->
    @include('partials.header')
    <!--// top-bar -->
        <div class="container">
            <h1 class="text-center">MODIFIER UNE CHAMBRE</h1>
            <hr>
            <!--  -->
            <div class="col-md-6">
                <form method="post" action="{{ route('chambres.update', $chambre->id) }}">
                    @method('PATCH')
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">numero:</label>
                        <input type="text" class="form-control" name="numero" value={{ $chambre->numero }} required/>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlSelect1">CATEGORIE</label>
                        <select class="form-control" name="categorie"  id="exampleFormControlSelect1" required>
                            <option >classique</option>
                            <option>mvp</option>
                            <option>vip</option>
                            <!-- <option value="classique" {{ $chambre->categorie == 'classique' ? 'selected' : '' }}>classique</option>
                            <option value="mvp" {{ $chambre->categorie == 'mvp' ? 'selected' : '' }}>mvp</option>
                            <option value="vip" {{ $chambre->categorie == 'vip' ? 'selected' : '' }}>vip</option> -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlSelect1">PRIX</label>
                        <select class="form-control" name="prix"  id="exampleFormControlSelect1" value="{{ $chambre->prix }}" required>
                            <option >2500</option>
                            <option>5000</option>
                            <option>10000</option>
                            <!-- <option value="2500" {{ $chambre->prix == '2500' ? 'selected' : '' }}>2500</option>
                            <option value="5000" {{ $chambre->prix == '5000' ? 'selected' : '' }}>5000</option>
                            <option value="10000" {{ $chambre->prix == '10000' ? 'selected' : '' }}>10000</option> -->
                        </select>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">MODIFIER</button>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('chambres.index') }}" class="btn btn-success float-end"
                            title="Retour">
                                <i class="fas fa-arrow-left"></i> Retour
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </body>
@endsection

