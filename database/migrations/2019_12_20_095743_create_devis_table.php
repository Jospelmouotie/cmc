<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevisTable extends Migration {

    public function up()
    {
        Schema::create('devis', function(Blueprint $table)
        {
            $table->id();

            // Clés étrangères en BigInt Unsigned pour matcher users.id et patients.id
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('patient_id')->nullable()->index();

            $table->string('nom')->unique();
            $table->string('arreter')->nullable();

            // On garde tes colonnes de quantités et prix
            for ($i = 1; $i <= 14; $i++) {
                $table->integer("qte$i")->nullable()->default($i <= 4 ? 1 : null);
                $table->integer("prix_u" . ($i == 1 ? "" : $i-1))->nullable();
                $table->integer("montant" . ($i == 1 ? "" : $i-1))->nullable();
                $table->string("elements" . ($i == 1 ? "" : $i-1))->nullable();
            }

            $table->integer('total1')->nullable();
            $table->integer('total2')->nullable();
            $table->integer('total3')->nullable();
            $table->timestamps();

            // Les contraintes
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('set null');

            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('devis');
    }
}
