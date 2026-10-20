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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_image');
            $table->string('room_number');
            $table->enum('dorm_name', ['Le Berceau', 'Maison Paul', 'Nini Dorm']);
            $table->unsignedTinyInteger('capacity');
            $table->unique(['dorm_name', 'room_number']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
