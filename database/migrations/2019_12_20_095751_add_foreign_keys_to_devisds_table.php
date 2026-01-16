<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToDevisdsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('devisds', function(Blueprint $table)
		{
			$table->foreign('patient_id')->references('id')->on('patients')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('user_id', '1')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('devisds', function(Blueprint $table)
		{
			$table->dropForeign('devisds_patient_id_foreign');
			$table->dropForeign('1');
		});
	}

}
