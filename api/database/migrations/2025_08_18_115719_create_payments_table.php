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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('subscription_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('gateway', ['flutterwave', 'stripe', 'paypal']);
            $table->string('txn_id', 128);
            $table->unsignedInteger('amount_cents');
            $table->char('currency', 3)->default('KES');
            $table->enum('status', ['succeeded', 'failed', 'pending', 'refunded']);
            $table->json('payload')->nullable();
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('txn_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
