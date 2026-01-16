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
			$table->integer('id', true, true);
			$table->string('name');
			$table->string('prenom');
			$table->string('login')->unique();
			$table->integer('telephone')->unique();
			$table->string('sexe');
			$table->string('lieu_naissance');
			$table->date('date_naissance');
			$table->string('specialite')->nullable();
			$table->string('onmc')->nullable();
			$table->string('password');
			$table->string('remember_token')->nullable();
			$table->timestamps();
			$table->integer('role_id')->nullable();
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
