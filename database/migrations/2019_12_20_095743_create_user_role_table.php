<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserRoleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
{
    Schema::create('user_role', function(Blueprint $table)
    {
        // On utilise unsignedBigInteger pour matcher users.id et roles.id
        $table->unsignedBigInteger('role_id');
        $table->unsignedBigInteger('user_id');

        // Ajout des clés étrangères ici
        $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        // Optionnel mais recommandé : une clé primaire composée
        $table->primary(['role_id', 'user_id']);
    });
}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_role');
	}

}
