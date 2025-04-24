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
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cliente_id')->unsigned();
            $table->string('uuid', 40);
            $table->decimal('valor', 10, 2)->nullable();
            $table->bigInteger('forma_pagamento_id')->unsigned();
            $table->date('data_vencimento')->nullable();
            $table->date('data_pagamento')->nullable();
            $table->timestamps();
        });

        Schema::table('compras', function (Blueprint $table) {
            $table->foreign('cliente_id')->references('id')->on('clientes');
        });

        Schema::table('compras', function (Blueprint $table) {
            $table->foreign('forma_pagamento_id')->references('id')->on('forma_pagamentos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};
