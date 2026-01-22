<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$migrations = [
    '2019_12_20_095743_create_adaptation_traitements_table',
    '2019_12_20_095743_create_chambres_table',
    '2019_12_20_095743_create_cle_activations_table',
    '2019_12_20_095743_create_clients_table',
    '2019_12_20_095743_create_compte_rendu_bloc_operatoires_table',
    '2019_12_20_095743_create_consultation_anesthesistes_table',
    '2019_12_20_095743_create_consultation_suivis_table',
    '2019_12_20_095743_create_consultations_table',
    '2019_12_20_095743_create_devis_images_table',
    '2019_12_20_095743_create_devis_table',
    '2019_12_20_095743_create_devisds_table',
    '2019_12_20_095743_create_dossiers_table',
    '2019_12_20_095743_create_events_table',
    '2019_12_20_095743_create_examens_table',
    '2019_12_20_095743_create_facture_chambres_table',
    '2019_12_20_095743_create_facture_clients_table',
    '2019_12_20_095743_create_facture_consultations_table',
    '2019_12_20_095743_create_facture_devis_table',
    '2019_12_20_095743_create_facture_produit_table',
    '2019_12_20_095743_create_factures_table',
    '2019_12_20_095743_create_fiche_consommables_table',
    '2019_12_20_095743_create_fiche_interventions_table',
    '2019_12_20_095743_create_fiches_table',
    '2019_12_20_095743_create_imageries_table',
    '2019_12_20_095743_create_interventions_table',
    '2019_12_20_095743_create_licences_table',
    '2019_12_20_095743_create_observation_medicales_table',
    '2019_12_20_095743_create_ordonances_table',
    '2019_12_20_095743_create_parametres_table',
    '2019_12_20_095743_create_patients_table',
    '2019_12_20_095743_create_premedications_table',
    '2019_12_20_095743_create_prescription_medicales_table',
    '2019_12_20_095743_create_prescriptions_table',
    '2019_12_20_095743_create_produits_table',
    '2019_12_20_095743_create_roles_table',
    '2019_12_20_095743_create_soins_infirmiers_table',
    '2019_12_20_095743_create_soins_table',
    '2019_12_20_095743_create_surveillance_post_anesthesiques_table',
    '2019_12_20_095743_create_surveillance_rapproche_parametres_table',
    '2019_12_20_095743_create_surveillance_scores_table',
    '2019_12_20_095743_create_traitement_hospitalisations_table',
    '2019_12_20_095743_create_user_role_table',
    '2019_12_20_095743_create_users_table',
    '2019_12_20_095743_create_visite_preanesthesiques_table',
    '2019_12_20_095751_add_foreign_keys_to_chambres_table',
    '2019_12_20_095751_add_foreign_keys_to_clients_table',
    '2019_12_20_095751_add_foreign_keys_to_consultation_suivis_table',
    '2019_12_20_095751_add_foreign_keys_to_devis_images_table',
    '2019_12_20_095751_add_foreign_keys_to_devis_table',
    '2019_12_20_095751_add_foreign_keys_to_devisds_table',
    '2019_12_20_095751_add_foreign_keys_to_dossiers_table',
    '2019_12_20_095751_add_foreign_keys_to_examens_table',
    '2019_12_20_095751_add_foreign_keys_to_imageries_table',
    '2019_12_20_095751_add_foreign_keys_to_ordonances_table',
    '2019_12_20_095751_add_foreign_keys_to_parametres_table',
    '2019_12_20_095751_add_foreign_keys_to_patients_table',
    '2019_12_20_095751_add_foreign_keys_to_prescriptions_table',
    '2019_12_20_095751_add_foreign_keys_to_soins_table',
    '2019_12_20_095751_add_foreign_keys_to_user_role_table',
    '2020_02_07_141011_rename_avance_to_percu_on_historique_factures_table',
    '2025_11_06_000000_comprehensive_database_index_optimization',
    '2025_12_18_132554_add_performance_indexes_to_events_system'
    
];

foreach ($migrations as $migration) {
    DB::table('migrations')->insert(['migration' => $migration, 'batch' => 1]);
}

echo "Migrations marked as run.\n";