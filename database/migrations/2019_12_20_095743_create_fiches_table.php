<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFichesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fiches', function(Blueprint $table)
		{
			$table->integer('id', true, true);
			$table->string('nom');
			$table->string('prenom');
			$table->string('chambre_numero');
			$table->integer('age');
			$table->string('service');
			$table->string('infirmier_charge');
			$table->string('accueil');
			$table->string('restauration');
			$table->string('chambre');
			$table->string('soins');
			$table->integer('notes');
			$table->string('quizz');
			$table->string('remarque_suggestion');
			$table->timestamps();
			$table->integer('user_id')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('fiches');
	}

}
