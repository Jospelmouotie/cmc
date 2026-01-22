<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriqueFacturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
{
    Schema::create('historique_factures', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('facture_consultation_id');
        $table->unsignedBigInteger('user_id')->nullable();
        $table->unsignedBigInteger('patient_id')->nullable();

        $table->integer('numero')->nullable();
        $table->string('motif')->nullable();
        $table->string('montant')->nullable();
        // On ne garde que 'percu' ou 'avance', pas les deux si ils représentent la même chose
        $table->integer('percu')->nullable();
        $table->integer('reste')->nullable();

        $table->string('assurance')->nullable();
        $table->integer('assurancec')->nullable();
        $table->integer('assurec')->nullable();
        $table->string('demarcheur')->nullable();
        $table->string('prenom')->nullable();
        $table->date('date_insertion')->nullable();
        $table->string('medecin_r')->nullable();
        $table->timestamps();

        // Contraintes
        $table->foreign('facture_consultation_id')->references('id')->on('facture_consultations')->onDelete('CASCADE');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        $table->foreign('patient_id')->references('id')->on('patients')->onDelete('set null');
    });
}
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historique_factures');
    }
}
