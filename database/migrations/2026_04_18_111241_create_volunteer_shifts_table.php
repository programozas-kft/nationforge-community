<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('volunteer_shifts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('event_id')->nullable()->constrained()->nullOnDelete();
            $table->datetime('starts_at');
            $table->datetime('ends_at');
            $table->string('location')->nullable();
            $table->integer('slots')->default(1);
            $table->integer('filled_slots')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('volunteer_signups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shift_id')->constrained('volunteer_shifts')->cascadeOnDelete();
            $table->foreignId('person_id')->constrained('people')->cascadeOnDelete();
            $table->enum('status', ['confirmed', 'waitlisted', 'cancelled'])->default('confirmed');
            $table->text('notes')->nullable();
            $table->boolean('attended')->nullable();
            $table->timestamps();
            $table->unique(['shift_id', 'person_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('volunteer_signups');
        Schema::dropIfExists('volunteer_shifts');
    }
};
