<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChambresTable extends Migration {

    public function up()
    {
        Schema::create('chambres', function(Blueprint $table)
        {
            $table->id(); // Utilise id() pour BigInt

            // Correction du type pour matcher users.id
            $table->unsignedBigInteger('user_id');

            $table->string('numero');
            $table->string('categorie');
            $table->string('patient')->nullable()->default('Vide');
            $table->integer('prix')->nullable();
            $table->integer('jour')->nullable();
            $table->string('statut')->default('libre');
            $table->timestamps();

            // On ajoute la clé étrangère directement ici pour plus de simplicité
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('CASCADE')
                  ->onDelete('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('chambres');
    }
}
