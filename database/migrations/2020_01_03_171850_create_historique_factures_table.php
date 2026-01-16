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
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('facture_consultation_id');

            $table->integer('user_id')->nullable();
			$table->integer('patient_id')->nullable();
			$table->integer('numero')->nullable();
			$table->string('motif')->nullable();
			$table->string('montant')->nullable();
            $table->integer('avance')->nullable();
            $table->integer('percu')->nullable();
			$table->integer('reste')->nullable();
			$table->string('assurance')->nullable();
			$table->integer('assurancec')->nullable();
			$table->integer('assurec')->nullable();
			$table->string('demarcheur')->nullable();
			$table->string('prenom')->nullable();
			$table->date('date_insertion')->nullable();
			$table->string('medecin_r')->nullable();

            $table->foreign('facture_consultation_id')->references('id')->on('facture_consultations')->onUpdate('CASCADE')->onDelete('CASCADE');
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
