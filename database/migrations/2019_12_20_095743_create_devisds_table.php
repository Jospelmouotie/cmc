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
        $table->id(); // Utilise id() pour être cohérent
        // Utilise foreignId pour créer automatiquement un BIGINT UNSIGNED
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('devis_id')->constrained('devis')->onDelete('cascade');
        $table->foreignId('patient_id')->nullable()->constrained()->onDelete('set null');
        
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
