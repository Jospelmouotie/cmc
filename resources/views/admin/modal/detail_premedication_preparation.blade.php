<div class="modal fade" id="DetailPremedication" tabindex="-1" role="dialog" aria-labelledby="ordonanceAll" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">PREMEDICATION</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if (count($patient->premedications))

                    <h3>PREMEDICATION</h3>
                    <br>
                    <div class="table-responsive">
                        @if(count($premedications))
                            <table id="myTable" class="table table-bordred table-striped">
                                <thead>
                                <th>MEDICAMENT</th>
                                <th>CONSIGNES IDE</th>
                                <th>PREPARATION</th>
                                <th>DATE DE CREATION</th>
                                </thead>
                                <tbody>

                                @foreach($patient->premedications as $premedication)

                                    <tr>
                                        <td>{{ $premedication->medicament }}</td>
                                        <td>{{ $premedication->consigne_ide }}</td>
                                        <td>{{ $premedication->preparation }}</td>
                                        <td>{{ $premedication->created_at }}</td>
                                    </tr>
                                    <tr></tr>
                                @endforeach


                                </tbody>
                            </table>
                        @endif
                        <div class="clearfix"></div>

                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

