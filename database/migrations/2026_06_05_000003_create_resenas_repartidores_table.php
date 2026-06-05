<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resenas_repartidores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->restrictOnDelete();
            $table->foreignId('usuario_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('repartidor_id')->constrained('repartidores')->restrictOnDelete();
            $table->unsignedTinyInteger('calificacion');
            $table->text('comentario')->nullable();
            $table->timestamps();

            $table->unique('pedido_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resenas_repartidores');
    }
};
