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
        Schema::table('days', function (Blueprint $table) {
            // Drop the existing unique constraint on day_number
            $table->dropUnique(['day_number']);
            
            // Add a compound unique constraint for day_number + user_id
            $table->unique(['day_number', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('days', function (Blueprint $table) {
            // Drop the compound unique constraint
            $table->dropUnique(['day_number', 'user_id']);
            
            // Restore the original unique constraint on day_number only
            $table->unique('day_number');
        });
    }
};
