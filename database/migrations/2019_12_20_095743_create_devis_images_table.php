<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDevisImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('devis_images', function(Blueprint $table)
		{
			$table->integer('id', true, true);
			$table->integer('patient_id')->nullable()->index();
			$table->integer('user_id')->nullable()->index();
			$table->string('devis_p');
			$table->string('image');
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
		Schema::drop('devis_images');
	}

}
