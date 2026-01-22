<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProduitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('produits', function(Blueprint $table)
		{
			$table->integer('id', true, true);
			$table->string('designation')->unique();
			$table->string('categorie');
			$table->integer('qte_stock')->default(0);
			$table->integer('qte_alerte');
			$table->integer('prix_unitaire');
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
		Schema::drop('produits');
	}

}
