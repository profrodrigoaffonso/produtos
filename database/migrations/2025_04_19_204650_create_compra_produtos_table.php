<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('compra_produtos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('compra_id')->unsigned();
            $table->bigInteger('produto_id')->unsigned();
            $table->decimal('valor_unitario', 10, 2)->nullable();
            $table->decimal('valor', 10, 2);
            $table->integer('quantidade');
            $table->timestamps();
        });

        Schema::table('compra_produtos', function (Blueprint $table) {
            $table->foreign('compra_id')->references('id')->on('compras');
        });

        Schema::table('compra_produtos', function (Blueprint $table) {
            $table->foreign('produto_id')->references('id')->on('produtos');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compra_produtos');
    }
};
