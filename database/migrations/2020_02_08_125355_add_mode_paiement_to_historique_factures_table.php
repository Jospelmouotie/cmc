<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddModePaiementToHistoriqueFacturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('historique_factures', function (Blueprint $table) {
            $table->string('mode_paiement')->default('espèce');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('historique_factures', function (Blueprint $table) {
            $table->dropColumn('mode_paiement');
        });
    }
}
