<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFichePrescriptionMedicalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
{
    Schema::create('fiche_prescription_medicales', function (Blueprint $table) {
        $table->id(); // Sera référencé par les autres
        $table->unsignedBigInteger('patient_id')->index();
        $table->text('regime')->nullable();
        $table->text('consultation_specialise')->nullable();
        $table->text('protocole')->nullable();
        $table->string('allergie')->nullable();
        $table->timestamps();

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
        Schema::dropIfExists('fiche_prescription_medicales');
    }
}
