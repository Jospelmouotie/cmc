<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateParametresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('parametres', function(Blueprint $table)
		{
			$table->integer('id', true, true);
			$table->integer('user_id');
			$table->integer('patient_id');
			$table->float('poids', 10, 0);
			$table->float('taille', 10, 0);
			$table->string('bras_gauche');
			$table->string('bras_droit');
			$table->string('inc_bmi');
			$table->date('date_naissance');
			$table->integer('age');
			$table->string('temperature');
			$table->string('fr')->nullable();
			$table->string('fc')->nullable();
			$table->string('spo2')->nullable();
			$table->string('glycemie')->nullable();
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
		Schema::drop('parametres');
	}

}
