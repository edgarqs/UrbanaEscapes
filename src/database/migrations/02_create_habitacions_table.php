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
        Schema::create('habitacions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade');
            $table->enum('tipus', ['Estandar', 'Deluxe', 'Suite','Adaptada']);
            $table->integer('llits');
            $table->integer('llits_supletoris');
            $table->decimal('preu', 10, 2);
            $table->integer('numHabitacion');
            $table->enum('estat', ['Lliure', 'Ocupada', 'Bloquejada'])->default('Lliure');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habitacions');
    }
};
