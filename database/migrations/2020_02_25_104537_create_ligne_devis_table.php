<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLigneDevisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
{
     Schema::create('ligne_devis', function (Blueprint $table) {
        $table->id();
        $table->foreignId('devi_id')->constrained('devis')->onDelete('cascade');
        $table->string('element');
        $table->integer('quantite');
        $table->integer('prix_u');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ligne_devis');
    }
}
