<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLigneDevisTable extends Migration
{
    public function up()
    {
        Schema::create('ligne_devis', function (Blueprint $table) {
            $table->id();

            // Relation avec le devis parent
            $table->foreignId('devi_id')->constrained('devis')->onDelete('cascade');

            // Doit être "unsignedInteger" pour correspondre à "integer(true, true)" de produits
            $table->unsignedInteger('produit_id')->nullable();

            // Champs requis par le DevisController
            $table->string('type')->default('procedure');
            $table->string('element');
            $table->integer('quantite');
            $table->integer('prix_u');
            $table->boolean('stock_deducted')->default(false);

            $table->timestamps();

            // Définition de la clé étrangère
            $table->foreign('produit_id')
                  ->references('id')
                  ->on('produits')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ligne_devis');
    }
}
