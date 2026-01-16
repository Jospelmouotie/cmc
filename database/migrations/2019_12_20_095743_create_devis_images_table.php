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
        $table->id();
        // Utilisation de unsignedBigInteger pour la compatibilité
        $table->unsignedBigInteger('patient_id')->nullable()->index();
        $table->unsignedBigInteger('user_id')->nullable()->index();
        $table->string('devis_p');
        $table->string('image');
        $table->timestamps();

        // Ajout des clés ici directement
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
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
