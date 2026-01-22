<div class="modal fade" id="ficheSuiviAll" tabindex="-1" role="dialog" aria-labelledby="ficheSuiviAll" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">CONSULTATION DE SUIVI</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            @if (count($patient->consultationdesuivi))

                    <div class="table-responsive">
                        <table id="myTable" class="table table-bordred table-striped">
                            <thead>
                            <th>INTERROGATOIRE</th>
                            <th>COMMENTAIRE</th>
                            <th>DATE</th>
                            <th>VOIR</th>
                            </thead>
                            <tbody>

                            @foreach($patient->consultationdesuivi as $consultationdesuivis)

                                <tr>
                                    
                                    <td>{{ $consultationdesuivis->interrogatoire }}</td>
                                    <td> {{ $consultationdesuivis->commentaire }}</td>
                                    <td>{{ $consultationdesuivis->date_creation }}</td>
                                       
                                    
                                    <td>
                                        <a class="btn btn-primary btn-sm" title="voir" href="{{ route('consultationsdesuivi.show', $consultationdesuivis->id) }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr></tr>
                            @endforeach


                            </tbody>
                        </table>
                        <div class="clearfix"></div>
                      

                    </div>
            @endif
            </div>
        </div>
    </div>
</div>
