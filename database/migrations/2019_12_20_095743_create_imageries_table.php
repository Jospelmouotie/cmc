<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateImageriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
public function up() {
    Schema::create('imageries', function(Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id')->nullable()->index();
        $table->unsignedBigInteger('patient_id')->nullable()->index();
        $table->string('radiographie')->nullable();
        $table->string('echographie')->nullable();
        $table->string('scanner')->nullable();
        $table->string('irm')->nullable();
        $table->string('scintigraphie')->nullable();
        $table->string('autre')->nullable();
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
    });
}
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('imageries');
	}

}
