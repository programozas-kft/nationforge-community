<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')->constrained('people')->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('HUF');
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
            $table->enum('payment_method', ['card', 'transfer', 'cash', 'paypal', 'stripe', 'other'])->default('card');
            $table->string('transaction_id')->nullable()->unique();
            $table->string('campaign')->nullable();
            $table->text('message')->nullable();
            $table->boolean('is_recurring')->default(false);
            $table->enum('recurring_interval', ['monthly', 'quarterly', 'yearly'])->nullable();
            $table->timestamp('next_charge_at')->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->json('payment_data')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('person_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
