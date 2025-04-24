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
        Schema::create('carrinhos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cliente_id')->unsigned();
            $table->bigInteger('produto_id')->unsigned();
            $table->integer('quantidade');
            $table->decimal('valor', 10, 2);
            $table->timestamps();
        });

        Schema::table('carrinhos', function (Blueprint $table) {
            $table->foreign('cliente_id')->references('id')->on('clientes');
        });

        Schema::table('carrinhos', function (Blueprint $table) {
            $table->foreign('produto_id')->references('id')->on('produtos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrinhos');
    }
};
