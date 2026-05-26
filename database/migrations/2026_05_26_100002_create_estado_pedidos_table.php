<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estado_pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 80)->unique();
            $table->string('descripcion', 300)->nullable();
            $table->string('color', 20)->nullable()->comment('Color hex para UI, ej: #FFA500');
            $table->unsignedTinyInteger('orden')->default(0)->comment('Orden de progresion del estado');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estado_pedidos');
    }
};
