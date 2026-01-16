<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFicheInterventionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fiche_interventions', function(Blueprint $table)
		{
			$table->integer('id', true, true);
			$table->integer('user_id')->index();
			$table->integer('patient_id')->index();
			$table->string('nom_patient');
			$table->string('prenom_patient');
			$table->string('sexe_patient');
			$table->date('date_naiss_patient');
			$table->integer('portable_patient');
			$table->string('type_intervention');
			$table->time('dure_intervention');
			$table->string('position_patient');
			$table->string('decubitus')->nullable();
			$table->string('laterale')->nullable();
			$table->string('lombotomie')->nullable();
			$table->date('date_intervention');
			$table->string('medecin');
			$table->string('aide_op');
			$table->string('hospitalisation')->nullable();
			$table->string('ambulatoire')->nullable();
			$table->string('anesthesie');
			$table->text('recommendation')->nullable();
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
		Schema::drop('fiche_interventions');
	}

}
