<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePremedicationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('premedications', function(Blueprint $table)
		{
			$table->integer('id', true, true);
			$table->integer('user_id')->index();
			$table->integer('patient_id')->index();
			$table->string('consigne_ide');
			$table->string('preparation');
			$table->timestamps();
			$table->string('medicament')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('premedications');
	}

}
