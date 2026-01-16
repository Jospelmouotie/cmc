<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConsultationSuivisTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('consultation_suivis', function(Blueprint $table)
		{
			$table->integer('id', true, true);
			$table->integer('patient_id')->nullable()->index();
			$table->integer('user_id')->index();
			$table->text('interrogatoire');
			$table->text('commentaire');
			$table->date('date_creation');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('consultation_suivis');
	}

}
