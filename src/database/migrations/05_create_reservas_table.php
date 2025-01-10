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
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('habitacion_id')->constrained()->onDelete('cascade');
            $table->foreignId('usuari_id')->constrained()->onDelete('cascade');
            $table->date('data_entrada');
            $table->date('data_sortida');
            $table->decimal('preu_total', 10, 2);
            $table->enum('estat', ['Reservada', 'Checkin', 'Checkout', 'Cancelada'])->default('Reservada');
            $table->string('comentaris')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
