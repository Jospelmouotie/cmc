<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddModePaiementToPatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
  // xxxx_xx_xx_add_mode_paiement_to_patients_table.php
public function up()
{
    Schema::table('patients', function (Blueprint $table) {
        // Ajout de la colonne pour matcher : $request->input('mode_paiement')
        $table->string('mode_paiement')->default('espèce')->after('motif');
    });
}
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn('mode_paiement');
        });
    }
}
