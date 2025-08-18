<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('announcements', function (Blueprint $table) {
            // Drop old columns if they exist
            if (Schema::hasColumn('announcements', 'body')) {
                $table->dropColumn('body');
            }
            if (Schema::hasColumn('announcements', 'published_at')) {
                $table->dropColumn('published_at');
            }
            if (Schema::hasColumn('announcements', 'created_by')) {
                $table->dropForeign(['created_by']);
                $table->dropColumn('created_by');
            }
            
            // Add new columns
            if (!Schema::hasColumn('announcements', 'content')) {
                $table->text('content')->after('title');
            }
            if (!Schema::hasColumn('announcements', 'priority')) {
                $table->enum('priority', ['low', 'medium', 'high'])->default('medium')->after('content');
            }
            if (!Schema::hasColumn('announcements', 'status')) {
                $table->enum('status', ['draft', 'published', 'archived'])->default('draft')->after('priority');
            }
            if (!Schema::hasColumn('announcements', 'scheduled_at')) {
                $table->timestamp('scheduled_at')->nullable()->after('status');
            }
            if (!Schema::hasColumn('announcements', 'author_id')) {
                $table->foreignId('author_id')->constrained('users')->after('scheduled_at');
            }
        });
    }

    public function down()
    {
        Schema::table('announcements', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['author_id']);
            
            // Drop new columns
            $table->dropColumn(['content', 'priority', 'status', 'scheduled_at', 'author_id']);
            
            // Add old columns
            $table->text('body')->after('title');
            $table->timestamp('published_at')->nullable();
            $table->foreignId('created_by')->constrained('users');
        });
    }
};
