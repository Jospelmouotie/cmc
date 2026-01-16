<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration {

    public function up()
    {
        Schema::create('patients', function(Blueprint $table)
        {
            $table->id(); // BigInt Unsigned indispensable
            $table->unsignedBigInteger('user_id')->nullable(); // Doit matcher l'ID de users
            $table->integer('numero_dossier')->unique();
            $table->string('name')->unique();
            $table->string('prenom')->nullable();
            $table->string('assurance')->nullable();
            $table->string('numero_assurance')->nullable();
            $table->string('prise_en_charge')->nullable();
            $table->integer('reste')->nullable();
            $table->integer('assurancec')->nullable();
            $table->integer('assurec')->nullable();
            $table->string('demarcheur')->nullable();
            $table->string('motif')->nullable();
            $table->date('date_insertion')->nullable();
            $table->integer('montant')->nullable();
            $table->integer('avance')->nullable();
            $table->integer('medecin_r')->nullable();
            $table->text('details_motif')->nullable()->default('Consultation');
            $table->timestamps();

            // Optionnel : ajouter la relation vers users si nécessaire
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
