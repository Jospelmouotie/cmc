<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// Note : J'ai ajouté 'V2' pour éviter le conflit de nom de classe
class createPrescriptionMedicalesTable extends Migration
{
    public function up()
    {
        Schema::create('prescription_medicales', function (Blueprint $table) {
            // Utilisation de id() pour BigInt Unsigned
            $table->id();

            // Doit être unsignedBigInteger pour matcher fiche_prescription_medicales.id
            $table->unsignedBigInteger('fiche_prescription_medicale_id')->nullable();

            // Doit être unsignedBigInteger pour matcher users.id
            $table->unsignedBigInteger('user_id')->index();

            $table->string('medicament');
            $table->string('posologie');
            $table->string('voie');
            $table->string('horaire');
            $table->timestamps();

            // La contrainte de clé étrangère
            $table->foreign('fiche_prescription_medicale_id', 'fk_fiche_presc')
                  ->references('id')
                  ->on('fiche_prescription_medicales')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('prescription_medicales');
    }
}
