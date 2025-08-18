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
        Schema::table('events', function (Blueprint $table) {
            // Drop the old enum column
            $table->dropColumn('location_type');
        });
        
        Schema::table('events', function (Blueprint $table) {
            // Add the new enum column with updated values
            $table->enum('location_type', ['online', 'physical', 'hybrid'])->default('online')->after('ends_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Drop the updated column
            $table->dropColumn('location_type');
        });
        
        Schema::table('events', function (Blueprint $table) {
            // Add back the original enum column
            $table->enum('location_type', ['online', 'venue'])->default('online')->after('ends_at');
        });
    }
};
