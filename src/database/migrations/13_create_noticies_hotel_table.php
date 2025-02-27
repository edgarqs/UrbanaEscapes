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
        Schema::create('noticies_hotel', function (Blueprint $table) {
            $table->unsignedBigInteger('noticia_id');
            $table->unsignedBigInteger('hotel_id');

            $table->foreign('noticia_id')->references('id')->on('noticies')->onDelete('cascade');
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');

            $table->primary(['noticia_id', 'hotel_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('noticies_hotel');
    }
};
