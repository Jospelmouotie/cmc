<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateParametresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
public function up() {
    Schema::create('parametres', function(Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('patient_id');
        $table->float('poids', 10, 2); // Changé à 2 pour la précision
        $table->float('taille', 10, 2);
        $table->string('bras_gauche');
        $table->string('bras_droit');
        $table->string('inc_bmi');
        $table->date('date_naissance');
        $table->integer('age');
        $table->string('temperature');
        $table->string('fr')->nullable();
        $table->string('fc')->nullable();
        $table->string('spo2')->nullable();
        $table->string('glycemie')->nullable();
        $table->timestamps();

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
		Schema::drop('parametres');
	}

}
