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
        Schema::table('users', function (Blueprint $table) {
            //drop "name" column to be able to have first, middle, and last name
            if(Schema::hasColumn('users','name')) {
                $table->dropColumn('name');  
            }

            //add new columns
            $table->string('lastname')->after('id');
            $table->string('firstname')->after('lastname');
            $table->string('middlename')->nullable()->after('firstname');
            $table->string('nickname')->after('middlename');
            $table->date('birthdate')->nullable()->after('nickname');
            $table->string('user_type')->after('birthdate');
            $table->string('address')->after('user_type');
            $table->string('cellphone')->after('address');
            $table->string('accommodation_type')->after('password');
            $table->string('payment_schedule')->after('accommodation_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //recreate the defaul name column if rolled back
            $table->string('name')->after('id');

            //drop all custom columns
            $table->dropColumn([
                'lastname',
                'firstname',
                'middlename',
                'nickname',
                'birthdate',
                'user_type',
                'address',
                'cellphone',
                'accommodation_type',
                'payment_schedule',
            ]);
        });
    }
};
