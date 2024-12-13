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
        Schema::create('serveis', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->float('preu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar primero las tablas que dependen de serveis
        Schema::dropIfExists('habitacion_serveis');
        Schema::dropIfExists('serveis');
    }
};