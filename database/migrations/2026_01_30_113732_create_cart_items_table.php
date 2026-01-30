<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
{
    Schema::dropIfExists('cart_items');

    Schema::create('cart_items', function (Blueprint $table) {
        $table->id(); // Cet ID peut rester en BigInt

        // CORRECTION ICI : On utilise unsignedInteger() au lieu de foreignId()
        // pour correspondre au integer(..., true, true) de la table produits
        $table->unsignedInteger('produit_id');

        $table->unsignedBigInteger('user_id'); // Garde BigInt pour la table users (standard Laravel)

        $table->integer('quantite')->default(1);
        $table->integer('prix_unitaire'); // Utilise integer comme dans ta table produits
        $table->timestamps();

        // Les contraintes
        $table->foreign('produit_id')->references('id')->on('produits')->onDelete('cascade');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}
 public function down()
    {
        Schema::dropIfExists('cart_items');
    }
};
