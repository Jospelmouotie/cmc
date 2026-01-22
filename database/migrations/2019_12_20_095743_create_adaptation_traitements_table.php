<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdaptationTraitementsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('adaptation_traitements', function(Blueprint $table)
		{
			$table->integer('id', true, true);
			$table->integer('user_id')->index();
			$table->integer('patient_id')->index();
			$table->string('medicament_posologie_dosage');
			$table->string('arret')->nullable();
			$table->string('poursuivre')->nullable();
			$table->string('continuer')->nullable();
			$table->string('j')->nullable();
			$table->string('j0')->nullable();
			$table->string('j1')->nullable();
			$table->string('j2')->nullable();
			$table->string('m')->nullable();
			$table->string('mi')->nullable();
			$table->string('n')->nullable();
			$table->string('s')->nullable();
			$table->string('m1')->nullable();
			$table->string('mi1')->nullable();
			$table->string('s1')->nullable();
			$table->string('n1')->nullable();
			$table->dateTime('date');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('adaptation_traitements');
	}

}
