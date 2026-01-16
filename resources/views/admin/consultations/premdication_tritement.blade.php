@extends('layouts.admin')

@section('title', 'CMCU | Prémédication / Traitement')

@section('content')

    <style type="text/css">
        .tt-dropdown-menu {
            width: 100% !important;
        }
        .tt-menu {
            width: 422px;
            margin: 12px 0;
            padding: 8px 0;
            background-color: #fff;
            border: 1px solid #ccc;
            border: 1px solid rgba(0, 0, 0, 0.2);
            -webkit-border-radius: 8px;
            -moz-border-radius: 8px;
            border-radius: 8px;
            -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
            -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
            box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
        }
        .tt-suggestion:hover {
            cursor: pointer;
            color: #fff;
            background-color: #0097cf;
        }
        #scrollable-dropdown-menu {
            max-height: 150px;
            overflow-y: auto;
        }
        .tt-suggestion p {
            margin: 0;
        }
    </style>

    <div class="wrapper">
        @include('partials.side_bar')

        @include('partials.header')
        @can('show', \App\Models\User::class)
            <div class="col-md-12  toppad  offset-md-0 ">
                @can('infirmier', App\Models\Patient::class)
                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#DetailPremedication" title="Détails prémédication / préparation" data-whatever="@mdo">
                    <i class="fas fa-eye"></i> Consignes IDE / Préparations
                </button>
                @endcan
                @can('anesthesiste', App\Models\Patient::class)
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#DetailPremedication" title="Détails prémédication / préparation" data-whatever="@mdo">
                            <i class="fas fa-eye"></i> Détails
                        </button>
                @endcan
                <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-success float-end">
                    <i class="fas fa-arrow-left"></i>  Retour au dossier patient
                </a>
            </div>
            <div class="container">
                @can('anesthesiste', \App\Models\Patient::class)
                <div class="row col-md-12">
                    <div class="container">
                        <h3 align="center">PREMEDICATION</h3>
                        <div class="row">
                            <div class="table-responsive col-md-12">
                                <form method="post" action="{{ route('premedication_consigne_preparation.store') }}">
                                    @csrf
                                    <!--  -->
                                    <table class="table table-bordered table-striped" id="user_table">
                                        <thead>
                                        <tr>
                                            <th width="35%">MEDICAMENT</th>
                                            <th width="35%">CONSIGNE IDE</th>
                                            <th width="35%">PREPARATION</th>
                                            <th width="30%">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <input type="search" name="medicament" class="form-control typeahead tt-query" id="search" autocomplete="off" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" value="{{ old('consigne_ide') }}" name="consigne_ide" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" value="{{ old('premedication') }}" name="preparation" required>
                                            </td>
                                            <td>
                                                <input type="submit" class="btn btn-primary" value="Enregistrer" />
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <input name="patient_id" value="{{ $patient->id }}" type="hidden">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan
                    <br>
                    <hr>
                    <h1 class="text-center">Traitement à l'hospitalistion</h1>
                    @can('med_inf_anes', \App\Models\Patient::class)
                        <div class="row">
                            <div class="container">
                                <div class="table-responsive">
                                    <form method="post" id="dynamic_form" action="{{ route('traitement_hospitalisation.store') }}">
                                        @csrf
                                        <span id="result"></span>
                                        <table class="table table-bordered table-striped" id="user_table">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" width="80%">Médicament, dosage, posologie</th>
                                                    <th width="40%">Durée (j)</th>
                                                    <th>J (-1)</th>
                                                    <th>J (0)</th>
                                                    <th>J (1)</th>
                                                    <th>J (2)</th>
                                                    <th>M</th>
                                                    <th>MI</th>
                                                    <th>S</th>
                                                    <th>N</th>
                                                    <th>M+1</th>
                                                    <th>MI+1</th>
                                                    <th>S+1</th>
                                                    <th>N+1</th>
                                                    <th>Date / Heure</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <!-- FIXED: Removed 'disabled' and made it editable with readonly as fallback -->
                                                        <textarea name="medicament_posologie_dosage" cols="50" class="form-control" rows="2" readonly>@if(!empty($medicament)){{ $medicament->medicament }}@endif</textarea>
                                                        <small class="text-muted">Ce champ est pré-rempli avec le dernier médicament de prémédication</small>
                                                    </td>
                                                    <td><input type="number" class="form-control" name="duree" min="0"></td>
                                                    <td><input type="checkbox" value="Ok" name="j"></td>
                                                    <td><input type="checkbox" value="Ok" name="j0"></td>
                                                    <td><input type="checkbox" value="Ok" name="j1"></td>
                                                    <td><input type="checkbox" value="Ok" name="j2"></td>
                                                    <td><input type="checkbox" value="Ok" name="m"></td>
                                                    <td><input type="checkbox" value="Ok" name="mi"></td>
                                                    <td><input type="checkbox" value="Ok" name="s"></td>
                                                    <td><input type="checkbox" value="Ok" name="n"></td>
                                                    <td><input type="checkbox" value="Ok" name="m1"></td>
                                                    <td><input type="checkbox" value="Ok" name="mi1"></td>
                                                    <td><input type="checkbox" value="Ok" name="s1"></td>
                                                    <td><input type="checkbox" value="Ok" name="n1"></td>
                                                    <td><input type="datetime-local" value="{{ Carbon\Carbon::now()->format('Y-m-d\TH:i') }}" class="form-control" name="date" required></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <input type="submit" class="btn btn-primary mb-2 float-end" value="Enregistrer" />
                                        <input name="patient_id" value="{{ $patient->id }}" type="hidden">
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endcan
                <table class="table">
                    <thead>
                    <tr>
                        <th><div class="text-center">Médicament, dosage, posologie</div></th>
                        <th><div class="text-center">Durée (j)</div></th>
                        <th><div>J (-1)</div></th>
                        <th><div>J (0)</div></th>
                        <th><div>J (1)</div></th>
                        <th><div>J (2)</div></th>
                        <th><div>M</div></th>
                        <th><div>MI</div></th>
                        <th><div>S</div></th>
                        <th><div>N</div></th>
                        <th><div>M+1</div></th>
                        <th><div>MI+1</div></th>
                        <th><div>S+1</div></th>
                        <th><div>N+1</div></th>
                        <th><div>Date</div></th>
                        <th><div>IDE</div></th>
                    </tr>
                    </thead>
                    <tfoot>
                    @foreach($TraitementHospitalisations as $TraitementHospitalisation)
                    <tr>
                        <td>{{ $TraitementHospitalisation->medicament_posologie_dosage }}</td>
                        <td>{{ $TraitementHospitalisation->duree }} Jour(s)</td>
                        <td>{{ $TraitementHospitalisation->j }}</td>
                        <td>{{ $TraitementHospitalisation->j0 }}</td>
                        <td>{{ $TraitementHospitalisation->j1 }}</td>
                        <td>{{ $TraitementHospitalisation->j2 }}</td>
                        <td>{{ $TraitementHospitalisation->m }}</td>
                        <td>{{ $TraitementHospitalisation->mi }}</td>
                        <td>{{ $TraitementHospitalisation->s }}</td>
                        <td>{{ $TraitementHospitalisation->n }}</td>
                        <td>{{ $TraitementHospitalisation->m1 }}</td>
                        <td>{{ $TraitementHospitalisation->mi1 }}</td>
                        <td>{{ $TraitementHospitalisation->s1 }}</td>
                        <td>{{ $TraitementHospitalisation->n1 }}</td>
                        <td>{{ $TraitementHospitalisation->date }}</td>
                        <td>{{ $TraitementHospitalisation->user->name }} {{ $TraitementHospitalisation->user->prenom }}</td>
                    </tr>
                    @endforeach
                    </tfoot>
                </table>
                    <br>
                    <hr class="pb-3 pt-3">
                    <h1 class="text-center">Adaptation du traitement personnel</h1>
                    @can('med_inf_anes', \App\Models\Patient::class)
                    <div class="table-responsive">
                        <form method="post" action="{{ route('adaptation_traitement.store') }}">
                            @csrf
                            <table class="table table-bordered table-striped" id="user_table">
                                <thead>
                                <tr>
                                    <th class="text-center" width="80%">Médicament, dosage, posologie</th>
                                    <th>Arrêt</th>
                                    <th class="text-center">Poursuivre j'usqu'a la veille au soir</th>
                                    <th class="text-center">A continuer le matin</th>
                                    <th>J (-1)</th>
                                    <th>J (0)</th>
                                    <th>J (1)</th>
                                    <th>J (2)</th>
                                    <th>M</th>
                                    <th>MI</th>
                                    <th>S</th>
                                    <th>N</th>
                                    <th>M+1</th>
                                    <th>MI+1</th>
                                    <th>S+1</th>
                                    <th>N+1</th>
                                    <th width="5%">Date / Heure</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <textarea name="medicament_posologie_dosage" id="" cols="50" class="form-control" rows="2" required>{{ old('medicament_posologie_dosage') }}</textarea>
                                    </td>
                                    <td><input type="checkbox" value="Oui" name="arret"></td>
                                    <td><input type="checkbox" value="Oui" name="poursuivre"></td>
                                    <td><input type="checkbox" value="Oui" name="continuer"></td>
                                    <td><input type="checkbox" value="Ok" name="j"></td>
                                    <td><input type="checkbox" value="Ok" name="j0"></td>
                                    <td><input type="checkbox" value="Ok" name="j1"></td>
                                    <td><input type="checkbox" value="Ok" name="j2"></td>
                                    <td><input type="checkbox" value="Ok" name="m"></td>
                                    <td><input type="checkbox" value="Ok" name="mi"></td>
                                    <td><input type="checkbox" value="Ok" name="s"></td>
                                    <td><input type="checkbox" value="Ok" name="n"></td>
                                    <td><input type="checkbox" value="Ok" name="m1"></td>
                                    <td><input type="checkbox" value="Ok" name="mi1"></td>
                                    <td><input type="checkbox" value="Ok" name="s1"></td>
                                    <td><input type="checkbox" value="Ok" name="n1"></td>
                                    <td><input type="datetime-local" value="{{ Carbon\Carbon::now()->ToDateString() }}" class="form-control" name="date" required></td>
                                </tr>
                                </tbody>
                            </table>
                            <input type="submit" class="btn btn-primary mb-2 float-end" value="Enregistrer" />
                            <input name="patient_id" value="{{ $patient->id }}" type="hidden">
                        </form>
                    </div>
                    @endcan
                    <table class="table">
                        <thead>
                        <tr>
                            <th><div class="text-center">Médicament, dosage, posologie</div></th>
                            <th><div class="text-center">Arrêt</div></th>
                            <th><div class="text-center">Poursuivre j'usqu'a la veille au soir</div></th>
                            <th><div class="text-center">A continuer le matin</div></th>
                            <th><div>J (-1)</div></th>
                            <th><div>J (0)</div></th>
                            <th><div>J (1)</div></th>
                            <th><div>J (2)</div></th>
                            <th><div>M</div></th>
                            <th><div>MI</div></th>
                            <th><div>S</div></th>
                            <th><div>N</div></th>
                            <th><div>M+1</div></th>
                            <th><div>MI+1</div></th>
                            <th><div>S+1</div></th>
                            <th><div>N+1</div></th>
                            <th><div>Date</div></th>
                            <th><div>IDE</div></th>
                        </tr>
                        </thead>
                        <tfoot>
                        @foreach($AdaptationTraitements as $AdaptationTraitement)
                        <tr>
                            <td>{{ $AdaptationTraitement->medicament_posologie_dosage }}</td>
                            <td>{{ $AdaptationTraitement->arret }}</td>
                            <td>{{ $AdaptationTraitement->poursuivre }}</td>
                            <td>{{ $AdaptationTraitement->continuer }}</td>
                            <td>{{ $AdaptationTraitement->j }}</td>
                            <td>{{ $AdaptationTraitement->j0 }}</td>
                            <td>{{ $AdaptationTraitement->j1 }}</td>
                            <td>{{ $AdaptationTraitement->j2 }}</td>
                            <td>{{ $AdaptationTraitement->m }}</td>
                            <td>{{ $AdaptationTraitement->mi }}</td>
                            <td>{{ $AdaptationTraitement->s }}</td>
                            <td>{{ $AdaptationTraitement->n }}</td>
                            <td>{{ $AdaptationTraitement->m1 }}</td>
                            <td>{{ $AdaptationTraitement->mi1 }}</td>
                            <td>{{ $AdaptationTraitement->s1 }}</td>
                            <td>{{ $AdaptationTraitement->n1 }}</td>
                            <td>{{ $AdaptationTraitement->date }}</td>
                            <td>{{ $AdaptationTraitement->user->name }} {{ $AdaptationTraitement->user->prenom }}</td>
                        </tr>
                        @endforeach
                        </tfoot>
                    </table>
            </div>
            @include('admin.modal.detail_premedication_preparation')
        @endcan
    </div>

@stop
