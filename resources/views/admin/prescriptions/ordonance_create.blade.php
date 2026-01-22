@extends('layouts.admin')

@section('title', 'CMCU | dossier patient')

@section('content')


    <style>

        .table-sortable tbody tr {
            cursor: move;
        }
    </style>
    <body>

    <div class="wrapper">
    @include('partials.side_bar')

        @include('partials.header')
        @can('show', \App\Models\User::class)
            <div class="container">
                <div class="row">
                    <div class="col-md-12  toppad  offset-md-0 ">
                        <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-success float-end">
                            <i class="fas fa-arrow-left"></i>  Retour au dossier patient
                        </a>
                    </div>
                    <div class="container">
                        <br />
                        <h3 align="center">ORDONNANCES - {{ $patient->name }} {{ $patient->prenom }}</h3>
                        <br />
                        <div class="table-responsive">
                            <form method="post" id="dynamic_form" action="{{ route('ordonances.store') }}">
                                @csrf
                                <span id="result"></span>
                                <table class="table table-bordered table-striped" id="user_table">
                                    <thead>
                                    <tr>
                                        <th width="35%">Médicaments</th>
                                        <th width="35%">Quantité</th>
                                        <th width="35%">Posologie</th>
                                        <th width="30%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="2" align="right">&nbsp;</td>
                                        <td colspan="1" align="right">&nbsp;</td>
                                        <td>
                                            <input type="submit" name="save" id="save" class="btn btn-primary" value="Enregistrer" />
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                                <input name="patient_id" value="{{ $patient->id }}" type="hidden">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
    <script src="{{ asset('vendor/js/jquery-2.2.0.min.js') }}"></script>
    <script>
        $(document).ready(function(){

            var count = 1;

            dynamic_field(count);

            function dynamic_field(number)
            {
                html = '<tr>';
                html += '<td><input id="1" type="text" name="medicament[]" class="form-control" required /></td>';
                html += '<td><input id="2" type="text" name="quantite[]" class="form-control" required /></td>';
                html += '<td><textarea id="3" name="description[]" class="form-control" cols="30" rows="3" required></textarea></td>';
                if(number > 1)
                {
                    html += '<td><button type="button" name="remove" id="" class="btn btn-danger remove"><i class="fas fa-minus"></i></button></td></tr>';
                    $('tbody').append(html);
                }
                else
                {
                    html += '<td><button type="button" name="add" id="add" class="btn btn-success"><i class="far fa-plus-square"></i></button></td></tr>';
                    $('tbody').html(html);
                }
            }

            $(document).on('click', '#add', function(){
                count++;
                dynamic_field(count);
            });

            $(document).on('click', '.remove', function(){
                count--;
                $(this).closest("tr").remove();
            });

        });
    </script>
    </body>

@stop
