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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('plan_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['trialing', 'active', 'past_due', 'canceled'])->default('active');
            $table->datetime('current_period_start');
            $table->datetime('current_period_end');
            $table->boolean('cancel_at_period_end')->default(false);
            $table->enum('gateway', ['flutterwave', 'stripe', 'paypal'])->nullable();
            $table->string('gateway_customer_id', 128)->nullable();
            $table->timestamps();
            
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
