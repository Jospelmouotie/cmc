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
    Schema::create('prescription_medicales', function (Blueprint $table) {
        $table->id(); // BigInt
        $table->unsignedBigInteger('fiche_prescription_medicale_id')->nullable();
        $table->unsignedBigInteger('user_id')->index();
        $table->string('medicament');
        $table->string('posologie');
        $table->string('voie');
        $table->string('horaire');
        $table->timestamps();

        $table->foreign('fiche_prescription_medicale_id', 'fk_fiche_presc')
              ->references('id')->on('fiche_prescription_medicales')
              ->onDelete('cascade');
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
