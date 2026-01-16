<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePatientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('patients', function(Blueprint $table)
		{
			$table->integer('id', true, true);
			$table->integer('user_id');
			$table->integer('numero_dossier')->unique();
			$table->string('name')->unique();
			$table->string('assurance')->nullable();
			$table->string('numero_assurance')->nullable();
			$table->string('prise_en_charge')->nullable();
			$table->timestamps();
			$table->integer('reste')->nullable();
			$table->integer('assurancec')->nullable();
			$table->integer('assurec')->nullable();
			$table->string('demarcheur')->nullable();
			$table->string('motif')->nullable();
			$table->string('prenom')->nullable();
			$table->date('date_insertion')->nullable();
			$table->integer('montant')->nullable();
			$table->integer('avance')->nullable();
			$table->integer('medecin_r')->nullable();
			$table->text('details_motif')->nullable()->default('Consultation');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('patients');
	}

}
