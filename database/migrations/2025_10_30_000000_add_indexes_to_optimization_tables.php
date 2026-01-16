<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Patients table optimization
        if (Schema::hasTable('patients')) {
            Schema::table('patients', function (Blueprint $table) {
                if (!$this->indexExists('patients', 'patients_created_at_index')) {
                    $table->index('created_at');
                }
                if (!$this->indexExists('patients', 'patients_date_insertion_index')) {
                    $table->index('date_insertion');
                }
                if (!$this->indexExists('patients', 'patients_assurance_index')) {
                    $table->index('assurance');
                }
            });
        }

        // Consultations table optimization
        if (Schema::hasTable('consultations')) {
            Schema::table('consultations', function (Blueprint $table) {
                if (!$this->indexExists('consultations', 'consultations_date_consultation_index')) {
                    $table->index('date_consultation');
                }
                if (!$this->indexExists('consultations', 'consultations_date_intervention_index')) {
                    $table->index('date_intervention');
                }
                if (!$this->indexExists('consultations', 'consultations_medecin_r_index')) {
                    $table->index('medecin_r');
                }
                if (!$this->indexExists('consultations', 'consultations_created_at_index')) {
                    $table->index('created_at');
                }
            });
        }

        // Clients table optimization
        if (Schema::hasTable('clients')) {
            Schema::table('clients', function (Blueprint $table) {
                if (!$this->indexExists('clients', 'clients_created_at_index')) {
                    $table->index('created_at');
                }
                if (!$this->indexExists('clients', 'clients_date_insertion_index')) {
                    $table->index('date_insertion');
                }
                if (!$this->indexExists('clients', 'clients_assurance_index')) {
                    $table->index('assurance');
                }
            });
        }

        // Facture_clients table optimization
        if (Schema::hasTable('facture_clients')) {
            Schema::table('facture_clients', function (Blueprint $table) {
                if (!$this->indexExists('facture_clients', 'facture_clients_created_at_index')) {
                    $table->index('created_at');
                }
                if (!$this->indexExists('facture_clients', 'facture_clients_date_insertion_index')) {
                    $table->index('date_insertion');
                }
                if (!$this->indexExists('facture_clients', 'facture_clients_assurance_index')) {
                    $table->index('assurance');
                }
            });
        }

        // Factures table optimization
        if (Schema::hasTable('factures')) {
            Schema::table('factures', function (Blueprint $table) {
                if (!$this->indexExists('factures', 'factures_created_at_index')) {
                    $table->index('created_at');
                }
                if (!$this->indexExists('factures', 'factures_numero_index')) {
                    $table->index('numero');
                }
                if (!$this->indexExists('factures', 'factures_patient_index')) {
                    $table->index('patient');
                }
            });
        }

        // Events table optimization (appointment system)
        if (Schema::hasTable('events')) {
            Schema::table('events', function (Blueprint $table) {
                if (!$this->indexExists('events', 'events_date_index')) {
                    $table->index('date');
                }
                if (!$this->indexExists('events', 'events_created_at_index')) {
                    $table->index('created_at');
                }
            });
        }

        // Chambres table optimization
        if (Schema::hasTable('chambres')) {
            Schema::table('chambres', function (Blueprint $table) {
                if (!$this->indexExists('chambres', 'chambres_statut_index')) {
                    $table->index('statut');
                }
                if (!$this->indexExists('chambres', 'chambres_categorie_index')) {
                    $table->index('categorie');
                }
            });
        }

        // Devis table optimization
        if (Schema::hasTable('devis')) {
            Schema::table('devis', function (Blueprint $table) {
                if (!$this->indexExists('devis', 'devis_created_at_index')) {
                    $table->index('created_at');
                }
            });
        }

        // Examens table optimization
        if (Schema::hasTable('examens')) {
            Schema::table('examens', function (Blueprint $table) {
                if (!$this->indexExists('examens', 'examens_type_index')) {
                    $table->index('type');
                }
                if (!$this->indexExists('examens', 'examens_created_at_index')) {
                    $table->index('created_at');
                }
            });
        }

        // Produits table optimization
        if (Schema::hasTable('produits')) {
            Schema::table('produits', function (Blueprint $table) {
                if (!$this->indexExists('produits', 'produits_categorie_index')) {
                    $table->index('categorie');
                }
                if (!$this->indexExists('produits', 'produits_qte_stock_index')) {
                    $table->index('qte_stock');
                }
            });
        }

        // Fiches table optimization
        if (Schema::hasTable('fiches')) {
            Schema::table('fiches', function (Blueprint $table) {
                if (!$this->indexExists('fiches', 'fiches_created_at_index')) {
                    $table->index('created_at');
                }
            });
        }

        // Users table optimization
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (!$this->indexExists('users', 'users_specialite_index')) {
                    $table->index('specialite');
                }
            });
        }

        // Prescriptions table optimization
        if (Schema::hasTable('prescriptions')) {
            Schema::table('prescriptions', function (Blueprint $table) {
                if (!$this->indexExists('prescriptions', 'prescriptions_created_at_index')) {
                    $table->index('created_at');
                }
            });
        }

        // Ordonances table optimization
        if (Schema::hasTable('ordonances')) {
            Schema::table('ordonances', function (Blueprint $table) {
                if (!$this->indexExists('ordonances', 'ordonances_user_id_index')) {
                    $table->index('user_id');
                }
                if (!$this->indexExists('ordonances', 'ordonances_patient_id_index')) {
                    $table->index('patient_id');
                }
                if (!$this->indexExists('ordonances', 'ordonances_created_at_index')) {
                    $table->index('created_at');
                }
            });
        }

        // Interventions table optimization
        if (Schema::hasTable('interventions')) {
            Schema::table('interventions', function (Blueprint $table) {
                if (!$this->indexExists('interventions', 'interventions_created_at_index')) {
                    $table->index('created_at');
                }
            });
        }

        // Dossiers table optimization
        if (Schema::hasTable('dossiers')) {
            Schema::table('dossiers', function (Blueprint $table) {
                if (!$this->indexExists('dossiers', 'dossiers_sexe_index')) {
                    $table->index('sexe');
                }
                if (!$this->indexExists('dossiers', 'dossiers_date_naissance_index')) {
                    $table->index('date_naissance');
                }
                if (!$this->indexExists('dossiers', 'dossiers_created_at_index')) {
                    $table->index('created_at');
                }
            });
        }

        // Imageries table optimization
        if (Schema::hasTable('imageries')) {
            Schema::table('imageries', function (Blueprint $table) {
                if (!$this->indexExists('imageries', 'imageries_created_at_index')) {
                    $table->index('created_at');
                }
            });
        }

        // Adaptation_traitements table optimization
        if (Schema::hasTable('adaptation_traitements')) {
            Schema::table('adaptation_traitements', function (Blueprint $table) {
                if (!$this->indexExists('adaptation_traitements', 'adaptation_traitements_date_index')) {
                    $table->index('date');
                }
            });
        }

        // Visite_preanesthesiques table optimization
        if (Schema::hasTable('visite_preanesthesiques')) {
            Schema::table('visite_preanesthesiques', function (Blueprint $table) {
                if (!$this->indexExists('visite_preanesthesiques', 'visite_preanesthesiques_date_visite_index')) {
                    $table->index('date_visite');
                }
                if (!$this->indexExists('visite_preanesthesiques', 'visite_preanesthesiques_created_at_index')) {
                    $table->index('created_at');
                }
            });
        }

        // Soins table optimization
        if (Schema::hasTable('soins')) {
            Schema::table('soins', function (Blueprint $table) {
                if (!$this->indexExists('soins', 'soins_user_id_index')) {
                    $table->index('user_id');
                }
                if (!$this->indexExists('soins', 'soins_patient_id_index')) {
                    $table->index('patient_id');
                }
                if (!$this->indexExists('soins', 'soins_contexte_index')) {
                    $table->index('contexte');
                }
                if (!$this->indexExists('soins', 'soins_created_at_index')) {
                    $table->index('created_at');
                }
            });
        }

        // Premedications table optimization
        if (Schema::hasTable('premedications')) {
            Schema::table('premedications', function (Blueprint $table) {
                if (!$this->indexExists('premedications', 'premedications_created_at_index')) {
                    $table->index('created_at');
                }
            });
        }

        // Optimize tables (MySQL specific)
        if (DB::connection()->getDriverName() === 'mysql') {
            $tables = [
                'patients', 'consultations', 'clients', 'facture_clients', 
                'factures', 'events', 'chambres', 'devis', 'examens', 
                'produits', 'fiches', 'users', 'roles', 'prescriptions',
                'ordonances', 'interventions', 'dossiers', 'imageries',
                'adaptation_traitements', 'visite_preanesthesiques', 'soins',
                'premedications'
            ];
            foreach ($tables as $table) {
                if (Schema::hasTable($table)) {
                    DB::statement("OPTIMIZE TABLE {$table}");
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Patients
        if (Schema::hasTable('patients')) {
            Schema::table('patients', function (Blueprint $table) {
                $table->dropIndex(['created_at']);
                $table->dropIndex(['date_insertion']);
                $table->dropIndex(['assurance']);
            });
        }

        // Consultations
        if (Schema::hasTable('consultations')) {
            Schema::table('consultations', function (Blueprint $table) {
                $table->dropIndex(['date_consultation']);
                $table->dropIndex(['date_intervention']);
                $table->dropIndex(['medecin_r']);
                $table->dropIndex(['created_at']);
            });
        }

        // Clients
        if (Schema::hasTable('clients')) {
            Schema::table('clients', function (Blueprint $table) {
                $table->dropIndex(['created_at']);
                $table->dropIndex(['date_insertion']);
                $table->dropIndex(['assurance']);
            });
        }

        // Facture_clients
        if (Schema::hasTable('facture_clients')) {
            Schema::table('facture_clients', function (Blueprint $table) {
                $table->dropIndex(['created_at']);
                $table->dropIndex(['date_insertion']);
                $table->dropIndex(['assurance']);
            });
        }

        // Factures
        if (Schema::hasTable('factures')) {
            Schema::table('factures', function (Blueprint $table) {
                $table->dropIndex(['created_at']);
                $table->dropIndex(['numero']);
                $table->dropIndex(['patient']);
            });
        }

        // Events
        if (Schema::hasTable('events')) {
            Schema::table('events', function (Blueprint $table) {
                $table->dropIndex(['date']);
                $table->dropIndex(['created_at']);
            });
        }

        // Chambres
        if (Schema::hasTable('chambres')) {
            Schema::table('chambres', function (Blueprint $table) {
                $table->dropIndex(['statut']);
                $table->dropIndex(['categorie']);
            });
        }

        // Devis
        if (Schema::hasTable('devis')) {
            Schema::table('devis', function (Blueprint $table) {
                $table->dropIndex(['created_at']);
            });
        }

        // Examens
        if (Schema::hasTable('examens')) {
            Schema::table('examens', function (Blueprint $table) {
                $table->dropIndex(['type']);
                $table->dropIndex(['created_at']);
            });
        }

        // Produits
        if (Schema::hasTable('produits')) {
            Schema::table('produits', function (Blueprint $table) {
                $table->dropIndex(['categorie']);
                $table->dropIndex(['qte_stock']);
            });
        }

        // Fiches
        if (Schema::hasTable('fiches')) {
            Schema::table('fiches', function (Blueprint $table) {
                $table->dropIndex(['created_at']);
            });
        }

        // Users
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropIndex(['specialite']);
            });
        }

        // Prescriptions
        if (Schema::hasTable('prescriptions')) {
            Schema::table('prescriptions', function (Blueprint $table) {
                $table->dropIndex(['created_at']);
            });
        }

        // Ordonances
        if (Schema::hasTable('ordonances')) {
            Schema::table('ordonances', function (Blueprint $table) {
                $table->dropIndex(['user_id']);
                $table->dropIndex(['patient_id']);
                $table->dropIndex(['created_at']);
            });
        }

        // Interventions
        if (Schema::hasTable('interventions')) {
            Schema::table('interventions', function (Blueprint $table) {
                $table->dropIndex(['created_at']);
            });
        }

        // Dossiers
        if (Schema::hasTable('dossiers')) {
            Schema::table('dossiers', function (Blueprint $table) {
                $table->dropIndex(['sexe']);
                $table->dropIndex(['date_naissance']);
                $table->dropIndex(['created_at']);
            });
        }

        // Imageries
        if (Schema::hasTable('imageries')) {
            Schema::table('imageries', function (Blueprint $table) {
                $table->dropIndex(['created_at']);
            });
        }

        // Adaptation_traitements
        if (Schema::hasTable('adaptation_traitements')) {
            Schema::table('adaptation_traitements', function (Blueprint $table) {
                $table->dropIndex(['date']);
            });
        }

        // Visite_preanesthesiques
        if (Schema::hasTable('visite_preanesthesiques')) {
            Schema::table('visite_preanesthesiques', function (Blueprint $table) {
                $table->dropIndex(['date_visite']);
                $table->dropIndex(['created_at']);
            });
        }

        // Soins
        if (Schema::hasTable('soins')) {
            Schema::table('soins', function (Blueprint $table) {
                $table->dropIndex(['user_id']);
                $table->dropIndex(['patient_id']);
                $table->dropIndex(['contexte']);
                $table->dropIndex(['created_at']);
            });
        }

        // Premedications
        if (Schema::hasTable('premedications')) {
            Schema::table('premedications', function (Blueprint $table) {
                $table->dropIndex(['created_at']);
            });
        }
    }

    /**
     * Check if an index exists.
     */
    private function indexExists(string $table, string $index): bool
    {
        try {
            $connection = Schema::getConnection();
            $schemaManager = $connection->getDoctrineSchemaManager();
            $indexes = $schemaManager->listTableIndexes($table);
            
            return isset($indexes[$index]);
        } catch (\Exception $e) {
            return false;
        }
    }
};






















































