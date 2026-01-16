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
            $table->increments('id');
            $table->timestamps();
            $table->string('element');
            $table->integer('quantite');
            $table->integer('prix_u');
            $table->integer('devi_id')->index();
			
            $table->foreign('devi_id')->references('id')->on('devis');
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
