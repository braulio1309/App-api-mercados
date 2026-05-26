<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mercados', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_establecimiento');
            $table->string('numero_local');
            $table->string('img_puesto')->nullable();
            $table->json('horario_atencion')->nullable();
            $table->string('nombre_dueno');
            $table->string('ruc', 11)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mercados');
    }
};
