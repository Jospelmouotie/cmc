<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecreatePrescriptionMedicalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescription_medicales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fiche_prescription_medicale_id')->nullable();
            $table->integer('user_id')->index();
			$table->string('medicament');
			$table->string('posologie');
			$table->string('voie');
			$table->string('horaire');
            $table->timestamps();

            $table->foreign('fiche_prescription_medicale_id')->references('id')->on('fiche_prescription_medicales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescription_medicales');
    }
}
