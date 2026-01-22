<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSoinsInfirmiersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('soins_infirmiers', function(Blueprint $table)
		{
			$table->integer('id', true, true);
			$table->integer('user_id');
			$table->integer('patient_id');
			$table->string('observation');
			$table->string('patient_externe')->nullable();
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
		Schema::drop('soins_infirmiers');
	}

}
