@extends('layouts.admin')

@section('title', 'CMCU | Modifier ordonnance')

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
                    <div class="col-md-12 toppad offset-md-0">
                        <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-success float-end">
                            <i class="fas fa-arrow-left"></i> Retour au dossier patient
                        </a>
                    </div>
                    <div class="container">
                        <br />
                        <h3 align="center">MODIFIER ORDONNANCE - {{ $patient->name }} {{ $patient->prenom }}</h3>
                        <br />
                        <div class="table-responsive">
                            <form method="post" id="dynamic_form" action="{{ route('ordonances.update', $ordonance->id) }}">
                                @csrf
                                @method('PUT')
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
                                        @php
                                            $medicaments = explode(',', $ordonance->medicament);
                                            $quantites = explode(',', $ordonance->quantite);
                                            $descriptions = explode(',', $ordonance->description);
                                            $count = count($medicaments);
                                        @endphp

                                        @foreach($medicaments as $index => $medicament)
                                        <tr>
                                            <td>
                                                <input type="text" 
                                                       name="medicament[]" 
                                                       class="form-control" 
                                                       value="{{ trim($medicament) }}" 
                                                       required />
                                            </td>
                                            <td>
                                                <input type="text" 
                                                       name="quantite[]" 
                                                       class="form-control" 
                                                       value="{{ trim($quantites[$index] ?? '') }}" 
                                                       required />
                                            </td>
                                            <td>
                                                <textarea name="description[]" 
                                                          class="form-control" 
                                                          cols="30" 
                                                          rows="3" 
                                                          required>{{ trim($descriptions[$index] ?? '') }}</textarea>
                                            </td>
                                            <td>
                                                @if($index == 0)
                                                    <button type="button" name="add" id="add" class="btn btn-success">
                                                        <i class="far fa-plus-square"></i>
                                                    </button>
                                                @else
                                                    <button type="button" name="remove" class="btn btn-danger remove">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="2" align="right">&nbsp;</td>
                                        <td colspan="1" align="right">&nbsp;</td>
                                        <td>
                                            <input type="submit" name="save" id="save" class="btn btn-primary" value="Modifier" />
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

            var count = {{ $count }};

            function dynamic_field(number)
            {
                html = '<tr>';
                html += '<td><input type="text" name="medicament[]" class="form-control" required /></td>';
                html += '<td><input type="text" name="quantite[]" class="form-control" required /></td>';
                html += '<td><textarea name="description[]" class="form-control" cols="30" rows="3" required></textarea></td>';
                html += '<td><button type="button" name="remove" class="btn btn-danger remove"><i class="fas fa-minus"></i></button></td></tr>';
                $('tbody').append(html);
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