<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompteRenduBlocOperatoiresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('compte_rendu_bloc_operatoires', function(Blueprint $table)
		{
			$table->integer('id', true, true);
			$table->integer('patient_id')->index();
			$table->string('chirurgien');
			$table->string('aide_op');
			$table->string('anesthesiste');
			$table->string('infirmier_anesthesiste');
			$table->date('date_intervention');
			$table->time('dure_intervention');
			$table->text('compte_rendu_o');
			$table->text('indication_operatoire');
			$table->text('resultat_histo')->nullable();
			$table->text('suite_operatoire');
			$table->text('traitement_propose')->nullable();
			$table->text('soins')->nullable();
			$table->date('date_e');
			$table->date('date_s');
			$table->string('type_e');
			$table->string('type_s');
			$table->text('conclusion');
			$table->timestamps();
			$table->string('type_intervention')->nullable();
			$table->string('titre_intervention')->nullable();
			$table->string('proposition_suivi')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('compte_rendu_bloc_operatoires');
	}

}
