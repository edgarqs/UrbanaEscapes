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
            $table->enum('tipus', ['estandar', 'deluxe', 'suite','adaptada']);
            $table->enum('llits', ['1', '2', '3','4']);
            $table->enum('llits_supletoris', ['0', '1', '2']);
            $table->decimal('preu', 10, 2);
            $table->integer('numHabitacio');
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
