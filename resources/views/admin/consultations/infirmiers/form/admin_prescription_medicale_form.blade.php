<div class="modal fade" id="admin_prescription_medicale_form">
    <div class="modal-dialog ">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Nouveau soin</h4>
                <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
            </div>

            <form id="apm_form" method="POST" action="#">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="date" class="form-label"><b>Date:</b></label>
                                <input type="date" class="form-control" name="date" id="date">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label><b>Période:</b></label><br>
                            <div class="form-check-inline">
                                <label class="form-check-label"><input class="form-check-input" type="checkbox" name="matin">M</label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label"><input class="form-check-input" type="checkbox" name="apre_midi">AM</label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label"><input class="form-check-input" type="checkbox" name="soir">S</label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label"><input class="form-check-input" type="checkbox" name="nuit">N</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" name="prescription_id" value="">
                    <input type="submit" class="btn btn-primary" value="Enregistrer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
