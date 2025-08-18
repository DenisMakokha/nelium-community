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
        Schema::table('audit_logs', function (Blueprint $table) {
            // Drop old columns
            $table->dropForeign(['actor_id']);
            $table->dropColumn(['actor_id', 'entity_type', 'entity_id', 'meta']);
            
            // Add new columns
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('description')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('updated_at')->nullable();
            
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            // Reverse the changes
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'description', 'ip_address', 'user_agent', 'updated_at']);
            
            // Restore old columns
            $table->foreignId('actor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('entity_type', 80)->nullable();
            $table->unsignedBigInteger('entity_id')->nullable();
            $table->json('meta')->nullable();
            
            $table->index('actor_id');
        });
    }
};
