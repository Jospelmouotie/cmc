<div class="modal fade" id="biologieAll" tabindex="-1" role="dialog" aria-labelledby="feuilleAll" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" >EXAMENS BIOLOGIE</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            @if (count($patient->prescriptions))

                    <div class="table-responsive">
                        <table id="myTable" class="table table-bordred table-striped">
                            <thead>
                            <th>DESCRIPTION</th>
                            <th>DATE</th>
                            <th>IMPPRIMER</th>
                            </thead>
                            <tbody>

                            @foreach($patient->prescriptions as $prescription)

                                <tr>
                                    <td>
                                        {{ $prescription->hematologie }}
                                        {{ $prescription->hemostase }}
                                        {{ $prescription->biochimie }}
                                        {{ $prescription->hormonologie }}
                                        {{ $prescription->marqeurs }}
                                        {{ $prescription->bacteriologie }}
                                        {{ $prescription->spermiologie }}
                                        {{ $prescription->serologie }}
                                        {{ $prescription->urines }}
                                        {{ $prescription->examen }}
                                    </td>
                                    <td>{{ $prescription->created_at->toFormattedDateString() }}</td>
                                    <td>
                                        <a class="btn btn-success btn-sm" title="Imprimer l'ordonance" href="{{ route('prescription_examens.pdf', $prescription->id) }}">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr></tr>
                            @endforeach


                            </tbody>
                        </table>
                        <div class="clearfix"></div>
                        {{ $ordonances->links() }}

                    </div>
            @endif
            </div>
        </div>
    </div>
</div>

