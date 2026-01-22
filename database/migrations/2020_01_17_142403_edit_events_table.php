<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('objet')->nullable();
			$table->string('description')->nullable();
            $table->datetime('start')->nullable();
            $table->datetime('end')->nullable();
			$table->string('state')->default('aucun');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['objet', 'description', 'end', 'state', 'start']);
			$table->time('start_time')->nullable();
			$table->time('end_time')->nullable();
            //$table->renameColumn('start', 'date');
            //$table->renameColumn('statut', 'color');
        });
    }
}
