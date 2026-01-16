<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDevisdsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('devisds', function(Blueprint $table)
		{
			$table->integer('id', true, true);
			$table->integer('user_id')->index();
			$table->integer('devis_id')->index();
			$table->integer('patient_id')->nullable()->index();
			$table->string('categorie')->nullable();
			$table->string('produit');
			$table->integer('quantite');
			$table->integer('prix_unit');
			$table->integer('prix');
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
		Schema::drop('devisds');
	}

}
