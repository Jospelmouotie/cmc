<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePrescriptionMedicalesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
    Schema::create('prescription_medicales', function(Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id')->index();
        $table->unsignedBigInteger('patient_id')->index();
        $table->string('allergie')->nullable();
        $table->date('date');
        $table->string('medicament');
        $table->string('posologie'); // Corrigé ici
        $table->string('voie');
        $table->integer('heure');
        $table->string('matin')->nullable();
        $table->string('apre_midi')->nullable();
        $table->string('soir')->nullable();
        $table->string('nuit')->nullable();
        $table->text('regime')->nullable();
        $table->text('consultation_specialise')->nullable();
        $table->text('protocole')->nullable();
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
		Schema::drop('prescription_medicales');
	}

}
