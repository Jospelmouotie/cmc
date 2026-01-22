<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoinsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soins', function(Blueprint $table)
        {
            // On utilise id() pour le BigInt standard
            $table->id();

            // IMPORTANT : unsignedBigInteger pour matcher users.id et patients.id
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('patient_id');

            $table->text('content');
            $table->string('contexte');
            $table->timestamps();

            // Définition des clés étrangères
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');

            // Index de performance
            $table->index(['contexte', 'created_at']);
        });
    }

    /**a
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('soins');
    }
}
