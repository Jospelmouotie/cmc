<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamensTable extends Migration {

    public function up()
    {
        Schema::create('examens', function(Blueprint $table)
        {
            // ID en BigInt Unsigned
            $table->id();

            // patient_id en unsignedBigInteger pour matcher patients.id
            $table->unsignedBigInteger('patient_id')->index();

            $table->string('type');
            $table->string('image')->nullable();
            $table->timestamps();

            // Ajout de la contrainte directement ici
            $table->foreign('patient_id')
                  ->references('id')
                  ->on('patients')
                  ->onUpdate('NO ACTION')
                  ->onDelete('NO ACTION');
        });
    }

    public function down()
    {
        Schema::dropIfExists('examens');
    }
}
