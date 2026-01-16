<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePrescriptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('prescriptions', function(Blueprint $table)
		{
			$table->integer('id', true, true);
			$table->integer('user_id')->nullable()->index();
			$table->integer('patient_id')->nullable()->index();
			$table->string('hematologie')->nullable();
			$table->string('hemostase')->nullable();
			$table->string('biochimie')->nullable();
			$table->string('hormonologie')->nullable();
			$table->string('marqueurs')->nullable();
			$table->string('bacteriologie')->nullable();
			$table->string('spermiologie')->nullable();
			$table->string('urines')->nullable();
			$table->string('serologie')->nullable();
			$table->string('examen')->nullable();
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
		Schema::drop('prescriptions');
	}

}
