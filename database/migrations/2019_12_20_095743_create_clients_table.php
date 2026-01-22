<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();

            // On utilise foreignId pour plus de clarté, matching users.id
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('nom');
            $table->string('prenom')->nullable();
            $table->string('motif')->nullable();

            // Utilisation de bigint si les montants peuvent être très élevés
            // Remplacez les integer par decimal pour accepter les chiffres précis
            $table->decimal('montant', 15, 2)->default(0)->nullable();
            $table->decimal('avance', 15, 2)->default(0)->nullable();
            $table->decimal('reste', 15, 2)->default(0)->nullable();
            $table->decimal('partassurance', 15, 2)->default(0)->nullable();
            $table->decimal('partpatient', 15, 2)->default(0)->nullable();
            $table->string('assurance')->nullable(); // Bien en string ici
            $table->string('demarcheur')->nullable();
            $table->string('numero_assurance')->nullable();
            $table->string('prise_en_charge')->nullable();

            // Changement en type DATE pour permettre des tris/filtres SQL efficaces
            $table->date('date_insertion')->nullable();

            $table->string('medecin_r')->nullable();
            $table->timestamps();

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
