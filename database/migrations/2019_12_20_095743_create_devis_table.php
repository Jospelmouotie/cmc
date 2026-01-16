<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDevisTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
public function up()
    {
        Schema::create('devis', function(Blueprint $table)
        {
            // ID de la table devis (Auto-increment, Unsigned)
            $table->integer('id', true, true);

            // CLÉS ÉTRANGÈRES :
            // Le 3ème paramètre 'true' est CRITIQUE car l'ID dans 'users' et 'patients' est 'unsigned'
            $table->integer('user_id', false, true)->nullable()->index();
            $table->integer('patient_id', false, true)->nullable()->index();

            $table->string('nom')->unique();
            $table->integer('qte1')->nullable();
            $table->integer('qte2')->nullable()->default(1);
            $table->integer('qte3')->nullable()->default(1);
            $table->integer('qte4')->nullable()->default(1);
            $table->string('qte5')->nullable()->default('1');
            $table->string('qte6')->nullable()->default('1');
            $table->string('qte7')->nullable()->default('1');
            $table->integer('qte8')->nullable();
            $table->integer('qte9')->nullable();
            $table->integer('qte10')->nullable();
            $table->integer('qte11')->nullable();
            $table->integer('prix_u')->nullable();
            $table->integer('prix_u1')->nullable();
            $table->integer('prix_u2')->nullable();
            $table->integer('prix_u3')->nullable();
            $table->integer('prix_u4')->nullable();
            $table->integer('prix_u5')->nullable();
            $table->integer('prix_u6')->nullable();
            $table->integer('prix_u7')->nullable();
            $table->integer('prix_u8')->nullable();
            $table->integer('prix_u9')->nullable();
            $table->integer('prix_u10')->nullable();
            $table->integer('montant')->nullable();
            $table->integer('montant1')->nullable();
            $table->integer('montant2')->nullable();
            $table->integer('montant3')->nullable();
            $table->integer('montant4')->nullable();
            $table->integer('montant5')->nullable();
            $table->integer('montant6')->nullable();
            $table->integer('montant7')->nullable();
            $table->integer('montant8')->nullable();
            $table->integer('montant9')->nullable();
            $table->integer('montant10')->nullable();
            $table->integer('montant11')->nullable();
            $table->string('elements')->nullable();
            $table->string('elements1')->nullable();
            $table->string('elements2')->nullable();
            $table->string('elements3')->nullable();
            $table->string('elements4')->nullable();
            $table->string('elements5')->nullable();
            $table->string('elements6')->nullable();
            $table->string('elements7')->nullable();
            $table->string('elements8')->nullable();
            $table->string('elements9')->nullable();
            $table->string('elements10')->nullable();
            $table->string('arreter')->nullable();
            $table->integer('total1')->nullable();
            $table->integer('total2')->nullable();
            $table->integer('total3')->nullable();
            $table->timestamps();
            $table->integer('qte12')->nullable();
            $table->integer('qte13')->nullable();
            $table->integer('qte14')->nullable();
            $table->integer('prix_u11')->nullable();
            $table->integer('prix_u12')->nullable();
            $table->integer('prix_u13')->nullable();
            $table->integer('montant12')->nullable();
            $table->integer('montant13')->nullable();
            $table->integer('montant14')->nullable();
            $table->string('elements11')->nullable();
            $table->string('elements12')->nullable();
            $table->string('elements13')->nullable();

            // Définition des contraintes de clés étrangères
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('set null');

            $table->index('created_at');
        });
    }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('devis');
	}

}
