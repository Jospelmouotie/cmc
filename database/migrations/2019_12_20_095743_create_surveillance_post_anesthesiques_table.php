<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSurveillancePostAnesthesiquesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('surveillance_post_anesthesiques', function(Blueprint $table)
		{
			$table->integer('id', true, true);
			$table->integer('user_id')->index();
			$table->integer('patient_id')->index();
			$table->string('surveillance')->nullable();
			$table->string('traitement')->nullable();
			$table->text('examen_paraclinique')->nullable();
			$table->string('observation')->nullable();
			$table->date('date_creation')->nullable();
			$table->date('date_sortie')->nullable();
			$table->time('heur_sortie')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('surveillance_post_anesthesiques');
	}

}
