<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePrescriptionMedicalesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('prescription_medicales', function(Blueprint $table)
		{
			$table->integer('id', true, true);
			$table->integer('user_id')->index();
			$table->integer('patient_id')->index();
			$table->string('allergie')->nullable();
			$table->date('date');
			$table->string('medicament');
			$table->string('posologie');
			$table->string('voie');
			$table->integer('heure');
			$table->string('matin')->nullable();
			$table->string('apre_midi')->nullable();
			$table->string('soir')->nullable();
			$table->text('regime')->nullable();
			$table->text('consultation_specialise')->nullable();
			$table->text('protocole')->nullable();
			$table->string('nuit')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('prescription_medicales');
	}

}
