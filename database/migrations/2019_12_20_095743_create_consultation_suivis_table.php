<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultationSuivisTable extends Migration {

    public function up()
    {
        Schema::create('consultation_suivis', function(Blueprint $table)
        {
            $table->id(); // BigInt

            // Correction des types pour matcher les tables parentes
            $table->unsignedBigInteger('patient_id')->nullable()->index();
            $table->unsignedBigInteger('user_id')->index();

            $table->text('interrogatoire');
            $table->text('commentaire');
            $table->date('date_creation');
            $table->timestamps(); // Toujours utile de les avoir

            // Ajout des contraintes directement ici pour éviter les erreurs de fichiers séparés
            $table->foreign('patient_id')
                  ->references('id')
                  ->on('patients')
                  ->onUpdate('CASCADE')
                  ->onDelete('CASCADE');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('CASCADE')
                  ->onDelete('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('consultation_suivis');
    }
}
