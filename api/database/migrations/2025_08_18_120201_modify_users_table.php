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
            $table->string('name', 160)->change();
            $table->string('email', 190)->change();
            $table->string('org', 190)->nullable()->after('email_verified_at');
            $table->enum('role', ['member', 'admin'])->default('member')->after('org');
            $table->string('country', 120)->nullable()->after('role');
            $table->string('profession', 120)->nullable()->after('country');
            $table->text('bio')->nullable()->after('profession');
            $table->string('avatar_url')->nullable()->after('bio');
            $table->boolean('privacy_opt_out')->default(false)->after('avatar_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['org', 'role', 'country', 'profession', 'bio', 'avatar_url', 'privacy_opt_out']);
        });
    }
};
