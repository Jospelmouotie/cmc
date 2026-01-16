<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminPrescriptionMedicalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_prescription_medicales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('prescription_medicale_id');
            $table->integer('user_id')->index();
            $table->string('matin')->nullable();
			$table->string('apre_midi')->nullable();
			$table->string('soir')->nullable();
			$table->string('nuit')->nullable();
            $table->timestamps();

            $table->foreign('prescription_medicale_id')->references('id')->on('prescription_medicales')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_prescription_medicales');
    }
}
