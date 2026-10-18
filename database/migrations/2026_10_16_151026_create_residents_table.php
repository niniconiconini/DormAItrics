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
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users');
            $table->foreignId('room_id')->nullable()->constrained('rooms');
            $table->enum('resident_type', ['Student', 'Employee']);
            $table->enum('accommodation_type', ['Resident', 'Transient']);
            $table->enum('payment_schedule', ['Full Payment', '2 Payments', '3 Payments', '4 Payments', 'Per day']);
            $table->date('check_in_date');
            $table->date('check_out_date')->nullable();
            $table->enum('status', ['Active', 'Inactive', 'Pending']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};
