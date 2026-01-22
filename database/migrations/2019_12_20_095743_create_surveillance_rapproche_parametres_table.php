<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSurveillanceRapprocheParametresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('surveillance_rapproche_parametres', function(Blueprint $table)
		{
			$table->integer('id', true, true);
			$table->integer('user_id')->index();
			$table->integer('patient_id')->index();
			$table->date('date');
			$table->time('heure');
			$table->string('ta');
			$table->string('fr')->nullable();
			$table->integer('pouls')->nullable();
			$table->integer('spo2');
			$table->integer('temperature')->nullable();
			$table->string('diurese')->nullable();
			$table->string('conscience');
			$table->string('douleur')->nullable();
			$table->string('observation_plainte')->nullable();
			$table->string('periode');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('surveillance_rapproche_parametres');
	}

}
