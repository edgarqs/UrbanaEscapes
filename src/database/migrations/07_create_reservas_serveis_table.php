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
        Schema::create('reservas_serveis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reservas_id');
            $table->foreign('reservas_id')->references('id')->on('reservas')->onDelete('cascade');
            $table->unsignedBigInteger('serveis_id');
            $table->foreign('serveis_id')->references('id')->on('serveis')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habitacion_serveis');
    }
};