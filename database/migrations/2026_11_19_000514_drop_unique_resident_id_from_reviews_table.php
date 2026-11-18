<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['resident_id']);
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropUnique('reviews_resident_id_unique');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->index('resident_id', 'reviews_resident_id_index');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->foreign('resident_id')
                ->references('id')
                ->on('residents');
        });
    }

    public function down(): void
    {
        $hasDuplicateReviews = DB::table('reviews')
            ->select('resident_id')
            ->groupBy('resident_id')
            ->havingRaw('COUNT(*) > 1')
            ->exists();

        if ($hasDuplicateReviews) {
            throw new RuntimeException(
                'Cannot restore the unique resident_id index because residents have multiple review records.'
            );
        }

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['resident_id']);
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropIndex('reviews_resident_id_index');
            $table->unique('resident_id');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->foreign('resident_id')
                ->references('id')
                ->on('residents');
        });
    }
};