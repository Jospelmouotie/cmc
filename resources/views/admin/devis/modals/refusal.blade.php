<!-- Refusal Modal -->
<div class="modal fade" id="refuserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="refuserForm" method="POST">
                @csrf
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="fas fa-times-circle me-2"></i>Refuser le Devis</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Vous êtes sur le point de refuser ce devis. Veuillez indiquer la raison du refus.
                    </div>
                    
                    <div class="mb-3">
                        <label for="commentaire_refus" class="form-label">
                            Raison du refus <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" name="commentaire" id="commentaire_refus" rows="4" 
                                  placeholder="Expliquez pourquoi ce devis est refusé..." required></textarea>
                        <small class="text-muted">Ce commentaire sera visible par le gestionnaire</small>
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="confirmer_refus" required>
                        <label class="form-check-label" for="confirmer_refus">
                            Je confirme vouloir refuser ce devis
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times me-2"></i>Refuser le devis
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
waitForjQuery(function() {
    $('#refuserModal').on('show.bs.modal', function(event) {
        const button = $(event.relatedTarget);
        const deviId = button.data('devi-id');
        
        $('#refuserForm').attr('action', '/admin/devis/refuser/' + deviId);
        $('#commentaire_refus').val('');
        $('#confirmer_refus').prop('checked', false);
    });
});
</script>