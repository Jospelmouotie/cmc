<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFactureConsultationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('facture_consultations', function(Blueprint $table)
		{
			$table->integer('id', true, true);
			$table->integer('user_id')->index();
			$table->integer('patient_id')->index();
			$table->integer('numero');
			$table->string('motif');
			$table->string('montant');
			$table->timestamps();
			$table->integer('avance')->nullable();
			$table->integer('reste')->nullable();
			$table->string('assurance')->nullable();
			$table->integer('assurancec')->nullable();
			$table->integer('assurec')->nullable();
			$table->string('demarcheur')->nullable();
			$table->string('prenom')->nullable();
			$table->date('date_insertion')->nullable();
			$table->string('medecin_r')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('facture_consultations');
	}

}
