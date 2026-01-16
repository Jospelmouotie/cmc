<div class="modal fade" id="FicheInterventionAll" tabindex="-1" role="dialog" aria-labelledby="ordonanceAll" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">FICHES D'INTERVENTION</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if (count($patient->fiche_interventions))

                    <h3>FICHES D'INTERVENTION</h3>
                    <br>
                    <div class="table-responsive">
                        @if(count($fiche_interventions))
                            <table id="myTable" class="table table-bordred table-striped">
                                <thead>
                                <th>TYPE D'INTERVENTION</th>
                                <th>POSITION PATIENT</th>
                                <th>ANESTHESIE</th>
                                <th>DATE INTERVENTION</th>
                                <th>IMPPRIMER</th>
                                </thead>
                                <tbody>

                                @foreach($patient->fiche_interventions as $fiche_intervention)

                                    <tr>
                                        <td>{{ $fiche_intervention->type_intervention }}</td>
                                        <td>{{ $fiche_intervention->position_patient }}</td>
                                        <td>{{ $fiche_intervention->anesthesie }}</td>
                                        <td>{{ $fiche_intervention->date_intervention }}</td>
                                        <td>
                                            <a class="btn btn-success btn-sm" title="Imprimer la fiche d'intervention" href="{{ route('fiche_intervention.pdf', $fiche_intervention->id) }}">
                                                <i class="fas fa-print"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr></tr>
                                @endforeach


                                </tbody>
                            </table>
                        @endif
                        <div class="clearfix"></div>
                        {{--{{ $fiche_intervention->links() }}--}}

                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

