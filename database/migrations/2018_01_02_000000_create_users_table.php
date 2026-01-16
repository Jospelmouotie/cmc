<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
public function up()
{
    Schema::create('users', function(Blueprint $table)
    {
        // Utilise id() qui crée un BIGINT UNSIGNED AUTO_INCREMENT
        $table->id();
        $table->string('name');
        $table->string('prenom');
        $table->string('login')->unique();
        $table->string('telephone')->unique(); // String est mieux pour les numéros de téléphone
        $table->string('sexe');
        $table->string('lieu_naissance');
        $table->date('date_naissance');
        $table->string('specialite')->nullable();
        $table->string('onmc')->nullable();
        $table->string('password');
        $table->string('remember_token', 100)->nullable();
        $table->timestamps();

        // Relation vers la table roles (doit aussi être un foreignId)
        $table->foreignId('role_id')->nullable()->constrained('roles');
    });
}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
