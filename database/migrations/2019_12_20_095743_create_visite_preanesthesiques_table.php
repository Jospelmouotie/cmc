<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVisitePreanesthesiquesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('visite_preanesthesiques', function(Blueprint $table)
		{
			$table->integer('id', true, true);
			$table->integer('user_id')->index();
			$table->integer('patient_id')->index();
			$table->date('date_visite');
			$table->string('element_nouveaux');
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
		Schema::drop('visite_preanesthesiques');
	}

}
