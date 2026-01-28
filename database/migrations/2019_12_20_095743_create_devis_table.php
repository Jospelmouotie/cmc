<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devis', function (Blueprint $table) {
            $table->id();
            
            // Relations et Informations de base
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->unsignedBigInteger('medecin_id')->nullable(); // Médecin assigné au devis
            $table->string('nom');
            $table->string('code')->nullable();
            $table->string('acces')->default('acte'); // acte ou bloc
            
            // Champs pour l'hospitalisation et tarifs
            $table->integer('nbr_chambre')->default(0);
            $table->integer('nbr_visite')->default(0);
            $table->integer('nbr_ami_jour')->default(0);
            $table->integer('pu_chambre')->default(30000);
            $table->integer('pu_visite')->default(10000);
            $table->integer('pu_ami_jour')->default(9000);

            // Workflow de Validation et Statut
            $table->enum('statut', ['brouillon', 'en_attente', 'valide', 'refuse'])->default('brouillon');
            $table->integer('pourcentage_reduction')->default(0);
            $table->integer('montant_avant_reduction')->default(0);
            $table->integer('montant_apres_reduction')->default(0);
            
            // Suivi de la validation
            $table->timestamp('date_validation')->nullable();
            $table->unsignedBigInteger('validateur_id')->nullable(); // Médecin ayant validé le devis
            $table->text('commentaire_medecin')->nullable();

            $table->timestamps();

            // Index et Clés étrangères
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('medecin_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('validateur_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devis');
    }
}