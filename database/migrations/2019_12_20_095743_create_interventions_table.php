<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInterventionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('interventions', function(Blueprint $table)
		{
			$table->integer('id', true, true);
			$table->integer('patient_id')->index();
			$table->text('traitement_sortie');
			$table->string('suite_operatoire');
			$table->text('sortie');
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
		Schema::drop('interventions');
	}

}
