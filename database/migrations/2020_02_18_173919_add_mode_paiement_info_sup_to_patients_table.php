<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddModePaiementInfoSupToPatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   // xxxx_xx_xx_add_mode_paiement_info_sup_to_patients_table.php
public function up()
{
    Schema::table('patients', function (Blueprint $table) {
        // Ajout de la colonne pour matcher : 'mode_paiement_info_sup' => $modePaiementInfo
        $table->text('mode_paiement_info_sup')->nullable()->after('mode_paiement');
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
            $table->dropColumn('mode_paiement_info_sup');
        });
    }
}
