<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactureClientsTable extends Migration {

    public function up()
    {
        Schema::create('facture_clients', function(Blueprint $table)
        {
            // Utilisation de id() standard Laravel pour éviter les soucis d'auto-incrément
            $table->id();

            // On utilise foreignId pour l'intégrité avec les autres tables
            $table->integer('user_id')->index();
            $table->integer('client_id')->index();

            $table->string('nom');
            $table->string('prenom')->nullable();

            // CHANGEMENT ICI : Passage en DECIMAL pour tous les montants
            $table->decimal('montant', 15, 2)->default(0);
            $table->decimal('avance', 15, 2)->default(0)->nullable();
            $table->decimal('reste', 15, 2)->default(0)->nullable();
            $table->decimal('partassurance', 15, 2)->default(0)->nullable();
            $table->decimal('partpatient', 15, 2)->default(0)->nullable();

            $table->string('motif')->nullable();
            $table->string('assurance')->nullable(); // Gardé en string car peut être un nom
            $table->string('demarcheur')->nullable();
            $table->string('numero_assurance')->nullable();
            $table->string('prise_en_charge')->nullable();
            $table->string('date_insertion')->nullable();
            $table->string('medecin_r')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('facture_clients');
    }
}
