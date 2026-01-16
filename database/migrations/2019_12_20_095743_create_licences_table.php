<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLicencesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('licences', function(Blueprint $table)
		{
			$table->integer('id', true, true);
			$table->string('license_key');
			$table->string('client');
			$table->date('create_date');
			$table->date('active_date')->nullable();
			$table->dateTime('expire_date')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('licences');
	}

}
