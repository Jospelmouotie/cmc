<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateObservationMedicalesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('observation_medicales', function(Blueprint $table)
		{
			$table->integer('id', true, true);
			$table->integer('user_id');
			$table->integer('patient_id');
			$table->string('observation');
			$table->string('anesthesiste');
			$table->date('date');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('observation_medicales');
	}

}
