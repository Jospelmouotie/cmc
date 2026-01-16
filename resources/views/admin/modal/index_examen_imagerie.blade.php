<div class="modal fade" id="imagerieAll" tabindex="-1" role="dialog" aria-labelledby="feuilleAll" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">EXAMENS IMAGERIE</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if (count($patient->imageries))

                    <div class="table-responsive">
                        <table id="myTable" class="table table-bordred table-striped">
                            <thead>
                            <th>DESCRIPTION</th>
                            <th>DATE</th>
                            <th>IMPPRIMER</th>
                            </thead>
                            <tbody>

                            @foreach($patient->imageries as $imagerie)

                                <tr>
                                    <td>
                                        {{ $imagerie->radiographie }}
                                        {{ $imagerie->echographie }}
                                        {{ $imagerie->scanner }}
                                        {{ $imagerie->irm }}
                                        {{ $imagerie->scintigraphie }}
                                        {{ $imagerie->autre }}
                                    </td>
                                    <td>{{ $imagerie->created_at->toFormattedDateString() }}</td>
                                    <td>
                                        <a class="btn btn-success btn-sm" title="Imprimer l'ordonance" href="{{ route('imageries_examens.pdf', $imagerie->id) }}">
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
