<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('events', function (Blueprint $table) {
			$table->integer('id', true, true);
			$table->string('title');
			$table->date('date');
			$table->time('start_time');
			$table->time('end_time')->nullable();
			$table->string('color');
			$table->timestamps();
			$table->integer('user_id')->nullable();
			$table->integer('patient_id')->nullable();
			// Add indexes on date columns and foreign keys
			$table->index(['date', 'start_time']); // Composite index for date queries
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('events', function(Blueprint $table) {
			$table->dropIndex(['date', 'start_time']);
		});
		Schema::drop('events');
	}
}
