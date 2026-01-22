<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration {

    // xxxx_xx_xx_create_patients_table.php
public function up()
{
    Schema::create('patients', function(Blueprint $table)
    {
        $table->id();
        $table->unsignedBigInteger('user_id')->nullable();
        $table->integer('numero_dossier')->unique();
        $table->string('name'); // RETIRÉ : unique() -> car deux patients peuvent avoir le même nom
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
        $table->string('medecin_r')->nullable(); // CHANGÉ : integer -> string (pour matcher le contrôleur)
        $table->text('details_motif')->nullable()->default('Consultation');
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
    });
}

    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
