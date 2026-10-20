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
        Schema::create('pass_slips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->constrained('residents');
            $table->foreignId('approved_by_user_id')->nullable()->constrained('users');
            $table->text('purpose');
            $table->date('requested_date_out');
            $table->date('requested_date_in');
            $table->time('requested_time_out');
            $table->time('requested_time_in');
            $table->enum('status', ['Pending', 'Approved', 'Rejected', 'Cancelled'])->default('Pending');
            $table->timestamp('approved_at')->nullable();
            $table->enum('status', ['Pending', 'Approved', 'Rejected', 'Cancelled', 'Expired'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pass_slips');
    }
};
