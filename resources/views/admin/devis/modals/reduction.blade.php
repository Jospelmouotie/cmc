<!-- Reduction Modal -->
<div class="modal fade" id="reductionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="reductionForm" method="POST">
                @csrf
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">Appliquer une Réduction</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Montant actuel:</strong> <span id="montant_actuel">0</span> FCFA
                    </div>
                    
                    <div class="mb-3">
                        <label for="pourcentage_reduction" class="form-label">
                            Pourcentage de réduction <span class="text-danger">*</span>
                        </label>
                        <select class="form-select form-select-lg" name="pourcentage_reduction" id="pourcentage_reduction" required>
                            <option value="0">Aucune réduction (0%)</option>
                            <option value="5">5%</option>
                            <option value="10">10%</option>
                            <option value="15">15%</option>
                            <option value="20">20%</option>
                            <option value="25">25%</option>
                            <option value="30">30%</option>
                            <option value="35">35%</option>
                            <option value="40">40%</option>
                            <option value="45">45%</option>
                            <option value="50">50%</option>
                        </select>
                    </div>
                    
                    <div class="alert alert-success">
                        <strong>Nouveau montant:</strong> <span id="nouveau_montant">0</span> FCFA
                        <br>
                        <small>Économie: <span id="economie">0</span> FCFA</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="commentaire_reduction" class="form-label">Commentaire</label>
                        <textarea class="form-control" name="commentaire" id="commentaire_reduction" rows="3" 
                                  placeholder="Raison de la réduction (optionnel)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-info">Appliquer la réduction</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Wait for jQuery and Bootstrap to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    waitForjQuery(function() {
        // Calculate reduction when percentage changes
        $('#pourcentage_reduction').on('change', function() {
            calculateReduction();
        });
        
        // When modal is shown, initialize values
        $('#reductionModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const deviId = button.data('devi-id');
            const montant = parseFloat(button.data('montant')) || 0;
            
            console.log('Reduction modal opened:', {deviId, montant});
            
            // Set form action
            $('#reductionForm').attr('action', '/admin/devis/appliquer-reduction/' + deviId);
            
            // Set initial values
            $('#montant_actuel').text(montant.toLocaleString('fr-FR'));
            $('#pourcentage_reduction').val('0');
            $('#commentaire_reduction').val('');
            
            // Calculate with initial 0%
            calculateReduction();
        });
        
        function calculateReduction() {
            const montantText = $('#montant_actuel').text().replace(/\s/g, '').replace(/\u202F/g, '');
            const montantActuel = parseFloat(montantText) || 0;
            const pourcentage = parseInt($('#pourcentage_reduction').val()) || 0;
            const reduction = (montantActuel * pourcentage) / 100;
            const nouveauMontant = montantActuel - reduction;
            
            console.log('Calculating:', {montantActuel, pourcentage, reduction, nouveauMontant});
            
            $('#nouveau_montant').text(nouveauMontant.toLocaleString('fr-FR'));
            $('#economie').text(reduction.toLocaleString('fr-FR'));
        }
    });
});
</script>