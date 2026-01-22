<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTypeToNomToExamensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('examens', function (Blueprint $table) {
            $table->renameColumn('type', 'nom');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('examens', function (Blueprint $table) {
            $table->renameColumn('nom', 'type');
        });
    }
}
