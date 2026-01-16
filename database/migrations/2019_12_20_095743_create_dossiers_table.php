<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDossiersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dossiers', function(Blueprint $table)
		{
			$table->integer('id', true, true);
			$table->integer('patient_id')->index();
			$table->string('sexe');
			$table->string('personne_confiance')->nullable();
			$table->integer('tel_personne_confiance')->nullable();
			$table->integer('portable_1')->nullable();
			$table->integer('portable_2')->nullable();
			$table->string('personne_contact')->nullable();
			$table->integer('tel_personne_contact')->nullable();
			$table->string('profession')->nullable();
			$table->string('email')->nullable();
			$table->string('fax')->nullable();
			$table->string('adresse')->nullable();
			$table->string('lieu_naissance')->nullable();
			$table->date('date_naissance')->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('dossiers');
	}

}
