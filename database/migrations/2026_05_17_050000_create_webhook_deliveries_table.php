<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('webhook_deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('webhook_id')->constrained()->cascadeOnDelete();
            $table->string('event_type', 60);
            $table->json('payload');
            $table->unsignedSmallInteger('response_code')->nullable();
            $table->text('response_body')->nullable();
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->unsignedTinyInteger('attempt_count')->default(1);
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('created_at')->nullable();

            $table->index(['webhook_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('webhook_deliveries');
    }
};
