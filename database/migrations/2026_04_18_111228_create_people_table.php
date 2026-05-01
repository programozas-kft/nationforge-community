<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->date('birthdate')->nullable();
            $table->enum('gender', ['male', 'female', 'other', 'unknown'])->default('unknown');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('county')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->default('HU');
            $table->string('occupation')->nullable();
            $table->string('employer')->nullable();
            $table->text('bio')->nullable();
            $table->string('avatar')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('website')->nullable();
            $table->enum('status', ['prospect', 'supporter', 'member', 'volunteer', 'donor', 'vip', 'inactive'])->default('prospect');
            $table->decimal('total_donated', 10, 2)->default(0);
            $table->integer('donation_count')->default(0);
            $table->timestamp('last_donated_at')->nullable();
            $table->timestamp('last_contacted_at')->nullable();
            $table->boolean('is_subscribed')->default(true);
            $table->string('unsubscribe_token')->nullable()->unique();
            $table->json('custom_fields')->nullable();
            $table->string('source')->nullable();
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['last_name', 'first_name']);
            $table->index('status');
            $table->index('city');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
