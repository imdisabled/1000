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
        Schema::create('days', function (Blueprint $table) {
            $table->id();
            $table->integer('day_number')->unique(); // 1 to 1000
            $table->date('date'); // The actual date for this day
            $table->text('task_description'); // Description of work to do
            $table->boolean('is_completed')->nullable()->default(null);
            $table->timestamp('completed_at')->nullable();
            $table->text('quote')->nullable(); // Quote from n8n
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('days');
    }
};
