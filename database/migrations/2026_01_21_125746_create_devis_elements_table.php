<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevisElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devis_elements', function (Blueprint $table) {
            $table->id(); // Utilise BigIncrements par défaut
            $table->string('nom');
            $table->string('code')->nullable();
            $table->integer('prix_unitaire')->default(0);
            $table->text('description')->nullable();
            $table->boolean('actif')->default(true);

            // CHANGEMENT ICI : unsignedBigInteger pour matcher users.id
            $table->unsignedBigInteger('user_id')->nullable();

            $table->timestamps();

            // La contrainte fonctionnera maintenant
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devis_elements');
    }
}
