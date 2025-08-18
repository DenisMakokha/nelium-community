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
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('title', 190);
            $table->enum('type', ['pdf', 'video', 'link']);
            $table->string('slug', 200)->unique();
            $table->text('description')->nullable();
            $table->string('file_url')->nullable();
            $table->string('link_url')->nullable();
            $table->enum('tier_min', ['FREE', 'IND', 'INST'])->default('FREE');
            $table->json('tags')->nullable();
            $table->datetime('published_at')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
