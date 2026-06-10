<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resenas_repartidor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repartidor_id')->constrained('repartidores')->cascadeOnDelete();
            $table->foreignId('usuario_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedTinyInteger('calificacion')->comment('Calificación del 1 al 5');
            $table->text('comentario')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resenas_repartidor');
    }
};
