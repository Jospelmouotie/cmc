<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePrescriptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
{
    Schema::create('prescriptions', function(Blueprint $table)
    {
        $table->id();
        $table->unsignedBigInteger('user_id')->nullable()->index();
        $table->unsignedBigInteger('patient_id')->nullable()->index();
        $table->string('hematologie')->nullable();
        $table->string('hemostase')->nullable();
        $table->string('biochimie')->nullable();
        $table->string('hormonologie')->nullable();
        $table->string('marqueurs')->nullable();
        $table->string('bacteriologie')->nullable();
        $table->string('spermiologie')->nullable();
        $table->string('urines')->nullable();
        $table->string('serologie')->nullable();
        $table->string('examen')->nullable();
        $table->timestamps();

        // Ajout des clés étrangères
        $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        $table->foreign('patient_id')->references('id')->on('patients')->onDelete('set null');
    });
}
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('prescriptions');
	}

}
