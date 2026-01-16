<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration {

    public function up()
    {
        Schema::create('clients', function(Blueprint $table)
        {
            // ID en BigInt (standard Laravel)
            $table->id();

            // user_id en unsignedBigInteger pour matcher users.id
            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('nom');
            $table->string('prenom')->nullable();
            $table->string('motif')->nullable();
            $table->integer('montant')->nullable();
            $table->integer('avance')->nullable();
            $table->integer('reste')->nullable();
            $table->integer('partassurance')->nullable();
            $table->integer('partpatient')->nullable();
            $table->integer('assurance')->nullable();
            $table->string('demarcheur')->nullable();
            $table->string('numero_assurance')->nullable();
            $table->string('prise_en_charge')->nullable();
            $table->string('date_insertion')->nullable();
            $table->string('medecin_r')->nullable();
            $table->timestamps();

            // AJOUT DE LA CLÉ ÉTRANGÈRE ICI
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('CASCADE')
                  ->onDelete('CASCADE');

            // INDEX
            $table->index(['nom', 'prenom']);
            $table->index(['assurance', 'numero_assurance']);
            $table->index('medecin_r');
        });
    }

    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
