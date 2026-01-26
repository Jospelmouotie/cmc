@extends('layouts.admin')

@section('title', 'CMCU | Ajouter un devis')

@section('content')
<style>
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

</style>
    <body>
    <div class="se-pr-con"></div>
    <div class="wrapper">
    @include('partials.side_bar')

    <!-- Page Content Holder -->
    @include('partials.header')
    <!--// top-bar -->
    @can('create', \App\Models\Patient::class)
        <div class="container">
            <h1 class="text-center">AJOUTER UN DEVIS</h1>
            <hr>
            <!--  -->

            <div class="card" style="width: 60rem;">
                <div class="card-body">
                    <h5 class="card-title">Ajouter un devis</h5>
                    <small class="text-info" title="Les champs marqués par une étoile rouge sont obligatoire"><i class="fas fa-info-circle"></i></small>
                    <hr>
                    <form class="form-group col-md-12" action="{{ route('devis.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div >
                            
                            <div class="box-part ">
                            <div class="form-group ">
                                <label for="nom" class="col-form-label text-md-right">NOM DU DEVIS <span class="text-danger"></span></label>
                                <input name="nom" class="form-control" value="{{ old('nom') }}" type="text" placeholder="nom du dévis" >
                            </div>
                            </div>
                            
                            </div>
                            <div class="box-a">
                            <div class="form-group">
                                <label for="arreter" class="col-form-label text-md-right">MONTANT TOTAL <span class="text-danger"></span></label>
                                <input name="arreter" class="form-control" value="{{ old('arreter') }}" type="text" placeholder=" (EN LETTRES)" >
                            </div>
                            </div>
                            
                        </div>
                       
                        <div class="col-md-12">
                        <div class="row">
                            <div >
                            
                            <div class="box-part ">
                                <div class="form-group">
                                    <label for="elements" class="col-form-label text-md-right">Element 1 <span class="text-danger"></span></label>
                                    <input name="elements" class="form-control" value="{{ old('elements') }}" type="text" placeholder="element 1" >
                                </div>
                            </div>
                            
                            </div>
                            <div class="box-a">
                            <div class="form-group">
                                <label for="qte1" class="col-form-label text-md-right">Quantité 1<span class="text-danger"></span></label>
                                <input name="qte1" class="form-control" value="{{ old('qte1') }}" type="text" placeholder="Quantité 1" >
                            </div>
                            </div>
                            <div class="box-a">
                            <div class="form-group">
                                <label for="prix_u" class="col-form-label text-md-right">Prix Unitaire 1 <span class="text-danger"></span></label>
                                <input name="prix_u" class="form-control" value="{{ old('prix_u') }}" type="text" placeholder="Prix Unitaire 1" >
                            </div>
                            </div>
                           
                        </div>

                        <div class="row">
                            <div >
                            
                            <div class="box-part ">
                                <div class="form-group">
                                    <label for="elements1" class="col-form-label text-md-right">Element 2 <span class="text-danger"></span></label>
                                    <input name="elements1" class="form-control" value="{{ old('elements1') }}" type="text" placeholder="Element 2" >
                                </div>
                            </div>
                            
                            </div>
                            <div class="box-a">
                            <div class="form-group">
                                <label for="qte2" class="col-form-label text-md-right">Quantité 2<span class="text-danger"></span></label>
                                <input name="qte2" class="form-control" value="{{ old('qte2') }}" type="text" placeholder="Quantité 2" >
                            </div>
                            </div>
                            <div class="box-a">
                            <div class="form-group">
                                <label for="prix_u1" class="col-form-label text-md-right">Prix unitaire 2 <span class="text-danger"></span></label>
                                <input name="prix_u1" class="form-control" value="{{ old('prix_u1') }}" type="text" placeholder="Prix unitaire 2" >
                            </div>
                            </div>
                            
                        </div>

                        <div class="row">
                            <div >
                            
                            <div class="box-part ">
                                <div class="form-group">
                                    <label for="elements2" class="col-form-label text-md-right">Element 3 <span class="text-danger"></span></label>
                                    <input name="elements2" class="form-control" value="{{ old('elements2') }}" type="text" placeholder="Element 3" >
                                </div>
                            </div>
                            
                            </div>
                            <div class="box-a">
                            <div class="form-group">
                                <label for="qte3" class="col-form-label text-md-right">Quantité 3 <span class="text-danger"></span></label>
                                <input name="qte3" class="form-control" value="{{ old('qte3') }}" type="text" placeholder="Quantité 3" >
                            </div>
                            </div>
                            <div class="box-a">
                            <div class="form-group">
                                <label for="prix_u2" class="col-form-label text-md-right">Prix unitaire 3<span class="text-danger"></span></label>
                                <input name="prix_u2" class="form-control" value="{{ old('prix_u2') }}" type="text" placeholder="Prix unitaire 3" >
                            </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div >
                            
                            <div class="box-part ">
                                <div class="form-group">
                                    <label for="elements3" class="col-form-label text-md-right">Element 4<span class="text-danger"></span></label>
                                    <input name="elements3" class="form-control" value="{{ old('elements3') }}" type="text" placeholder="Element 4" >
                                </div>
                            </div>
                            
                            </div>
                            <div class="box-a">
                            <div class="form-group">
                                <label for="qte4" class="col-form-label text-md-right">Quantité 4 <span class="text-danger"></span></label>
                                <input name="qte4" class="form-control" value="{{ old('qte4') }}" type="text" placeholder="Quantité 4" >
                            </div>
                            </div>
                            <div class="box-a">
                            <div class="form-group">
                                <label for="prix_u3" class="col-form-label text-md-right">Prix unitaire 4<span class="text-danger"></span></label>
                                <input name="prix_u3" class="form-control" value="{{ old('prix_u3') }}" type="text" placeholder="Prix unitaire 4" >
                            </div>
                            </div>
                           
                        </div>
                        <div class="row">
                            <div >
                            
                            <div class="box-part ">
                                <div class="form-group">
                                    <label for="elements4" class="col-form-label text-md-right">Element 5<span class="text-danger"></span></label>
                                    <input name="elements4" class="form-control" value="{{ old('elements4') }}" type="text" placeholder="Element 5" >
                                </div>
                            </div>
                            
                            </div>
                            <div class="box-a">
                            <div class="form-group">
                                <label for="qte5" class="col-form-label text-md-right">Quantité 5 <span class="text-danger"></span></label>
                                <input name="qte5" class="form-control" value="{{ old('qte5') }}" type="text" placeholder="Quantité 5" >
                            </div>
                            </div>
                            <div class="box-a">
                            <div class="form-group">
                                <label for="prix_u4" class="col-form-label text-md-right">Prix unitaire 5<span class="text-danger"></span></label>
                                <input name="prix_u4" class="form-control" value="{{ old('prix_u4') }}" type="text" placeholder="Prix unitaire 5" >
                            </div>
                            </div>
                           
                        </div>
                        
                        <div class="row">
                            <div >
                            
                            <div class="box-part ">
                                <div class="form-group">
                                    <label for="elements5" class="col-form-label text-md-right">Element 6 <span class="text-danger"></span></label>
                                    <input name="elements5" class="form-control" value="{{ old('elements5') }}" type="text" placeholder="Element 6" >
                                </div>
                            </div>
                            
                            </div>
                            <div class="box-a">
                            <div class="form-group">
                                <label for="qte6" class="col-form-label text-md-right">Quantité 6 <span class="text-danger"></span></label>
                                <input name="qte6" class="form-control" value="{{ old('qte6') }}" type="text" placeholder="Quantité 6" >
                            </div>
                            </div>
                            <div class="box-a">
                            <div class="form-group">
                                <label for="prix_u5" class="col-form-label text-md-right">Prix unitaire 6<span class="text-danger"></span></label>
                                <input name="prix_u5" class="form-control" value="{{ old('prix_u5') }}" type="text" placeholder="Prix unitaire 6" >
                            </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div >
                            
                            <div class="box-part ">
                                <div class="form-group">
                                    <label for="elements6" class="col-form-label text-md-right">Element 7 <span class="text-danger"></span></label>
                                    <input name="elements6" class="form-control" value="{{ old('elements6') }}" type="text" placeholder="Element 7 " >
                                </div>
                            </div>
                            
                            </div>
                            <div class="box-a">
                            <div class="form-group">
                                <label for="qte7" class="col-form-label text-md-right">Quantité 7<span class="text-danger"></span></label>
                                <input name="qte7" class="form-control" value="{{ old('qte7') }}" type="text" placeholder="Quantité 7" >
                            </div>
                            </div>
                            <div class="box-a">
                            <div class="form-group">
                                <label for="prix_u6" class="col-form-label text-md-right">Prix unitaire 7 <span class="text-danger"></span></label>
                                <input name="prix_u6" class="form-control" value="{{ old('prix_u6') }}" type="text" placeholder="Prix unitaire 8" >
                            </div>
                            </div>
                            
                        </div>
                       
                        <div class="row">
                            <div >
                            
                            <div class="box-part ">
                                <div class="form-group">
                                    <label for="elements7" class="col-form-label text-md-right">Element 8 <span class="text-danger"></span></label>
                                    <input name="elements7" class="form-control" value="{{ old('elements7') }}" type="text" placeholder="Element 8 " >
                                </div>
                            </div>
                            
                            </div>
                            <div class="box-a">
                            <div class="form-group">
                                <label for="qte8" class="col-form-label text-md-right">Quantité 8 <span class="text-danger"></span></label>
                                <input name="qte8" class="form-control" value="{{ old('qte8') }}" type="text" placeholder="Quantité 8" >
                            </div>
                            </div>
                            <div class="box-a">
                            <div class="form-group">
                                <label for="prix_u7" class="col-form-label text-md-right">Prix unitaire 8 <span class="text-danger"></span></label>
                                <input name="prix_u7" class="form-control" value="{{ old('prix_u7') }}" type="text" placeholder="Prix unitaire 8 " >
                            </div>
                            </div>
                           
                        </div>
                        <div class="row">
                            <div >
                            
                            <div class="box-part ">
                                <div class="form-group">
                                    <label for="elements8" class="col-form-label text-md-right">Element 9 <span class="text-danger"></span></label>
                                    <input name="elements8" class="form-control" value="{{ old('elements8') }}" type="text" placeholder="elements8" >
                                </div>
                            </div>
                            
                            </div>
                            <div class="box-a">
                            <div class="form-group">
                                <label for="qte9" class="col-form-label text-md-right">Quantité 9 <span class="text-danger"></span></label>
                                <input name="qte9" class="form-control" value="{{ old('qte9') }}" type="text" placeholder="Quantité 9 " >
                            </div>
                            </div>
                            <div class="box-a">
                            <div class="form-group">
                                <label for="prix_u8" class="col-form-label text-md-right">Prix unitaire 9 <span class="text-danger"></span></label>
                                <input name="prix_u8" class="form-control" value="{{ old('prix_u8') }}" type="text" placeholder="Prix unitaire 9" >
                            </div>
                            </div>
                           
                        </div>
                        <h6 class="btn btn-primary" >HOSPITALISATION </h6>
                        <div class="row">
                            <div >
                            
                            <div class="box-part ">
                                <div class="form-group">
                                    <label for="elements9" class="col-form-label text-md-right">Element 10 <span class="text-danger"></span></label>
                                    <input name="elements9" class="form-control" value="{{ old('elements9') }}" type="text" placeholder="Element 10" >
                                </div>
                            </div>
                            
                            </div>
                            <div class="box-a">
                            <div class="form-group">
                                <label for="qte10" class="col-form-label text-md-right">Quantité 10 <span class="text-danger"></span></label>
                                <input name="qte10" class="form-control" value="{{ old('qte10') }}" type="text" placeholder="Quantité 10" >
                            </div>
                            </div>
                            <div class="box-a">
                            <div class="form-group">
                                <label for="prix_u9" class="col-form-label text-md-right">Prix unitaire 10 <span class="text-danger"></span></label>
                                <input name="prix_u9" class="form-control" value="{{ old('prix_u9') }}" type="text" placeholder="Prix unitaire 10" >
                            </div>
                            </div>
                            
                        </div>

                        <div class="row">
                            <div >
                            
                            <div class="box-part ">
                                <div class="form-group">
                                    <label for="elements10" class="col-form-label text-md-right">Element 11 <span class="text-danger"></span></label>
                                    <input name="elements10" class="form-control" value="{{ old('elements10') }}" type="text" placeholder="Element 10" >
                                </div>
                            </div>
                            
                            </div>
                            <div class="box-a">
                            <div class="form-group">
                                <label for="qte11" class="col-form-label text-md-right">Quantité 11 <span class="text-danger"></span></label>
                                <input name="qte11" class="form-control" value="{{ old('qte11') }}" type="text" placeholder="Quantité 11" >
                            </div>
                            </div>
                            <div class="box-a">
                            <div class="form-group">
                                <label for="prix_u10" class="col-form-label text-md-right">Prix unitaire 10 <span class="text-danger"></span></label>
                                <input name="prix_u10" class="form-control" value="{{ old('prix_u10') }}" type="text" placeholder="Prix unitaire 10" >
                            </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div >
                            
                            <div class="box-part ">
                                <div class="form-group">
                                    <label for="elements11" class="col-form-label text-md-right">Element 12 <span class="text-danger"></span></label>
                                    <input name="elements11" class="form-control" value="{{ old('elements11') }}" type="text" placeholder="Element 11" >
                                </div>
                            </div>
                            
                            </div>
                            <div class="box-a">
                            <div class="form-group">
                                <label for="qte12" class="col-form-label text-md-right">Quantité 12 <span class="text-danger"></span></label>
                                <input name="qte12" class="form-control" value="{{ old('qte12') }}" type="text" placeholder="Quantité 12" >
                            </div>
                            </div>
                            <div class="box-a">
                            <div class="form-group">
                                <label for="prix_u11" class="col-form-label text-md-right">Prix unitaire 11 <span class="text-danger"></span></label>
                                <input name="prix_u11" class="form-control" value="{{ old('prix_u11') }}" type="text" placeholder="Prix unitaire 11" >
                            </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div >
                            
                            <div class="box-part ">
                                <div class="form-group">
                                    <label for="elements12" class="col-form-label text-md-right">Element 13 <span class="text-danger"></span></label>
                                    <input name="elements12" class="form-control" value="{{ old('elements12') }}" type="text" placeholder="Element 12" >
                                </div>
                            </div>
                            
                            </div>
                            <div class="box-a">
                            <div class="form-group">
                                <label for="qte13" class="col-form-label text-md-right">Quantité 13 <span class="text-danger"></span></label>
                                <input name="qte13" class="form-control" value="{{ old('qte13') }}" type="text" placeholder="Quantité 13" >
                            </div>
                            </div>
                            <div class="box-a">
                            <div class="form-group">
                                <label for="prix_u12" class="col-form-label text-md-right">Prix unitaire 12 <span class="text-danger"></span></label>
                                <input name="prix_u12" class="form-control" value="{{ old('prix_u12') }}" type="text" placeholder="Prix unitaire 12" >
                            </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div >
                            
                            <div class="box-part ">
                                <div class="form-group">
                                    <label for="elements13" class="col-form-label text-md-right">Element 14 <span class="text-danger"></span></label>
                                    <input name="elements13" class="form-control" value="{{ old('elements13') }}" type="text" placeholder="Element 13" >
                                </div>
                            </div>
                            
                            </div>
                            <div class="box-a">
                            <div class="form-group">
                                <label for="qte14" class="col-form-label text-md-right">Quantité 14 <span class="text-danger"></span></label>
                                <input name="qte14" class="form-control" value="{{ old('qte14') }}" type="text" placeholder="Quantité 14" >
                            </div>
                            </div>
                            <div class="box-a">
                            <div class="form-group">
                                <label for="prix_u13" class="col-form-label text-md-right">Prix unitaire 13 <span class="text-danger"></span></label>
                                <input name="prix_u13" class="form-control" value="{{ old('prix_u13') }}" type="text" placeholder="Prix unitaire 13" >
                            </div>
                            </div>
                            
                        </div>
                            </br>

                            <button type="submit" class="btn btn-primary btn-lg col-md-3" title="enregistrer un nouveau devis">Ajouter</button>
                            <a href="{{ route('devis.index') }}" class="btn btn-warning btn-lg col-md-3 offset-md-1" title="Retour à la liste des devis">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    @endcan
    </body>

@stop
