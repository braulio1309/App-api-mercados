<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendedor_mercado', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendedor_id')->constrained('vendedores')->cascadeOnDelete();
            $table->foreignId('mercado_id')->constrained('mercados')->cascadeOnDelete();
            $table->string('numero_puesto');
            $table->string('dni_vendedor', 20)->nullable();
            $table->timestamps();

            $table->unique(['vendedor_id', 'mercado_id', 'numero_puesto']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendedor_mercado');
    }
};
