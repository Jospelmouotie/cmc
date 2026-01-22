<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevisTable extends Migration {

// database/migrations/xxxx_xx_xx_create_devis_table.php
public function up()
{
    Schema::create('devis', function(Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id')->nullable();
        $table->unsignedBigInteger('patient_id')->nullable();
        $table->string('nom'); 
        $table->string('code')->nullable();
        $table->string('acces')->default('acte'); // acte ou bloc
        
        // Champs pour l'hospitalisation
        $table->integer('nbr_chambre')->default(0);
        $table->integer('nbr_visite')->default(0);
        $table->integer('nbr_ami_jour')->default(0);
        $table->integer('pu_chambre')->default(30000);
        $table->integer('pu_visite')->default(10000);
        $table->integer('pu_ami_jour')->default(9000);

        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        $table->foreign('patient_id')->references('id')->on('patients')->onDelete('set null');
    });

  
}
    public function down()
    {
        Schema::dropIfExists('devis');
    }
}
