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
        Schema::table('resources', function (Blueprint $table) {
            // First drop existing columns that conflict
            $table->dropColumn(['type', 'tags']);
        });
        
        Schema::table('resources', function (Blueprint $table) {
            // Add new columns
            $table->string('category', 100)->after('slug');
            $table->string('file_path')->nullable()->after('link_url');
            $table->string('file_name')->nullable()->after('file_path');
            $table->bigInteger('file_size')->nullable()->after('file_name');
            $table->string('file_type')->nullable()->after('file_size');
            $table->string('tags')->nullable()->after('file_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->dropColumn(['category', 'file_path', 'file_name', 'file_size', 'file_type', 'tags']);
        });
        
        Schema::table('resources', function (Blueprint $table) {
            $table->enum('type', ['pdf', 'video', 'link'])->after('title');
            $table->json('tags')->nullable()->after('tier_min');
        });
    }
};
