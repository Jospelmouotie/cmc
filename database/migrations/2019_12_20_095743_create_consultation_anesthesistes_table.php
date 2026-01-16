<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConsultationAnesthesistesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('consultation_anesthesistes', function(Blueprint $table)
		{
			$table->integer('id', true, true);
			$table->integer('user_id')->index();
			$table->integer('patient_id')->index();
			$table->string('specialite');
			$table->string('medecin_traitant');
			$table->string('operateur');
			$table->date('date_intervention');
			$table->string('motif_admission');
			$table->text('memo')->nullable();
			$table->text('anesthesi_salle');
			$table->text('risque');
			$table->text('solide')->nullable();
			$table->text('liquide')->nullable();
			$table->text('benefice_risque');
			$table->text('adaptation_traitement')->nullable();
			$table->string('technique_anesthesie');
			$table->string('technique_anesthesie1');
			$table->text('synthese_preop');
			$table->date('date_hospitalisation')->nullable();
			$table->string('service')->nullable();
			$table->string('classe_asa')->nullable();
			$table->text('antecedent_traitement');
			$table->text('examen_clinique');
			$table->text('allergie')->nullable();
			$table->text('traitement_en_cours');
			$table->string('antibiotique')->nullable();
			$table->string('autre1')->nullable();
			$table->text('examen_paraclinique')->nullable();
			$table->string('intubation')->nullable();
			$table->string('mallampati')->nullable();
			$table->string('distance_interincisive')->nullable();
			$table->string('distance_thyromentoniere')->nullable();
			$table->string('mobilite_servicale')->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('consultation_anesthesistes');
	}

}
