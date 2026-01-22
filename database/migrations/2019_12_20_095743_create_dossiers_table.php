<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDossiersTable extends Migration {

    public function up()
    {
        Schema::create('dossiers', function(Blueprint $table)
        {
            $table->id(); // BigInt Unsigned

            // Correction du type pour matcher patients.id
            $table->unsignedBigInteger('patient_id')->index();

            $table->string('sexe');
            $table->string('personne_confiance')->nullable();
            $table->string('tel_personne_confiance')->nullable(); // String est mieux pour les numéros
            $table->string('portable_1')->nullable();
            $table->string('portable_2')->nullable();
            $table->string('personne_contact')->nullable();
            $table->string('tel_personne_contact')->nullable();
            $table->string('profession')->nullable();
            $table->string('email')->nullable();
            $table->string('fax')->nullable();
            $table->string('adresse')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->date('date_naissance')->nullable();
            $table->timestamps();

            // On ajoute la contrainte ici
            $table->foreign('patient_id')
                  ->references('id')
                  ->on('patients')
                  ->onUpdate('CASCADE')
                  ->onDelete('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dossiers');
    }
}
