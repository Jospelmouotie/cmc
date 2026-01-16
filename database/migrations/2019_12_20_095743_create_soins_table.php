<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
			$table->integer('id', true, true);
			$table->integer('user_id');
			$table->integer('patient_id');
			$table->text('content');
			$table->string('contexte');
			$table->timestamps();

			// Add indexes on foreign keys and frequently queried columns
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('patient_id')->references('id')->on('patients');
			$table->index(['contexte', 'created_at']); // Composite index for common queries
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('soins', function(Blueprint $table) {
			$table->dropForeign(['user_id']);
			$table->dropForeign(['patient_id']); 
			$table->dropIndex(['contexte', 'created_at']);
		});
		Schema::drop('soins');
	}

}


