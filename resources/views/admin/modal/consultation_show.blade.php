<div class="modal fade" id="consultationAll" tabindex="-1" role="dialog" aria-labelledby="consultationAll" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabe">LISTE DES CONSULTATIONS</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
            @if (count($patient->consultations))
                    <h3>consultation</h3>
                    <br>
                    <div class="table-responsive">
                        <table id="myTable" class="table table-bordred table-striped">
                            <thead>
                            <th>DIAGNOSTIC</th>
                            <th>DATE</th>
                            <th>DETAILS</th>
                            </thead>
                            <tbody>

                            @foreach($patient->consultations as $consultation)

                                <tr>
                                    <td>{{ $consultation->diagnostic }}</td>
                                    
                                    <td>{{ $consultation->created_at->toFormattedDateString() }}</td>
                                    <td>
                                        <a class="btn btn-success btn-sm" title=" plus de details" href="{{ route('consultations.show', $consultation->id) }}">
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

