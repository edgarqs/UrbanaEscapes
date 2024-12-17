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
        Schema::create('habitacion_serveis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('habitacions_id');
            $table->foreign('habitacions_id')->references('id')->on('habitacions')->onDelete('cascade');
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