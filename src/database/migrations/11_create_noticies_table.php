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
        Schema::create('noticies', function (Blueprint $table) {
            $table->id();
            $table->string('titol');
            $table->string('descripcio_curta');
            $table->text('descripcio_llarga');
            $table->boolean('publicada')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('noticies');
    }
};
