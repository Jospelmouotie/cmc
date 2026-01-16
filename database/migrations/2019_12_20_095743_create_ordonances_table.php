<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdonancesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ordonances', function(Blueprint $table)
		{
			$table->integer('id', true, true);
			$table->integer('user_id');
			$table->integer('patient_id');
			$table->text('description');
			$table->text('medicament');
			$table->text('quantite');
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
		Schema::drop('ordonances');
	}

}
