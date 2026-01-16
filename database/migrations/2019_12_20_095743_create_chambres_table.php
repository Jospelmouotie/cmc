<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChambresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('chambres', function(Blueprint $table)
		{
			$table->integer('id', true, true);
			$table->integer('user_id');
			$table->string('numero');
			$table->string('categorie');
			$table->string('patient')->nullable()->default('Vide');
			$table->integer('prix')->nullable();
			$table->integer('jour')->nullable();
			$table->string('statut')->default('libre');
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
		Schema::drop('chambres');
	}

}
