<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactureConsultationsTable extends Migration {

    public function up()
    {
        Schema::create('facture_consultations', function(Blueprint $table)
        {
            // Passage en BigInt Unsigned (Standard Laravel)
            $table->id();

            // Correction pour matcher users.id et patients.id
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('patient_id')->index();

            $table->integer('numero');
            $table->string('motif');
            $table->string('montant');
            $table->integer('avance')->nullable();
            $table->integer('reste')->nullable();
            $table->string('assurance')->nullable();
            $table->integer('assurancec')->nullable();
            $table->integer('assurec')->nullable();
            $table->string('demarcheur')->nullable();
            $table->string('prenom')->nullable();
            $table->date('date_insertion')->nullable();
            $table->string('medecin_r')->nullable();
            $table->timestamps();

            // Clés étrangères
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('facture_consultations');
    }
}
