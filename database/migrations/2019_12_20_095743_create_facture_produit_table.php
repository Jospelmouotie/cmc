<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFactureProduitTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('facture_produit', function(Blueprint $table)
		{
			$table->integer('facture_id');
			$table->integer('produit_id');
			$table->integer('item');
			$table->integer('prix_unitaire');
			$table->integer('quantite');
			$table->timestamps();
			$table->primary(['facture_id','produit_id'], 'primary');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('facture_produit');
	}

}
