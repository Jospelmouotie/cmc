<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFactureClientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('facture_clients', function(Blueprint $table)
		{
			$table->integer('id', true, true);
			$table->integer('user_id')->index();
			$table->integer('client_id')->index();
			$table->string('nom');
			$table->string('prenom')->nullable();
			$table->string('montant');
			$table->string('avance')->nullable();
			$table->string('reste')->nullable();
			$table->string('motif')->nullable();
			$table->timestamps();
			$table->integer('partassurance')->nullable();
			$table->integer('partpatient')->nullable();
			$table->integer('assurance')->nullable();
			$table->string('demarcheur')->nullable();
			$table->string('numero_assurance')->nullable();
			$table->string('prise_en_charge')->nullable();
			$table->string('date_insertion')->nullable();
			$table->string('medecin_r')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('facture_clients');
	}

}
