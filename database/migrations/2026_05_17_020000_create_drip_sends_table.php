<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('drip_sends', function (Blueprint $table) {
            $table->id();
            $table->foreignId('drip_step_id')->constrained('drip_steps')->cascadeOnDelete();
            $table->foreignId('drip_enrollment_id')->constrained('drip_enrollments')->cascadeOnDelete();
            $table->foreignId('person_id')->constrained('people')->cascadeOnDelete();
            $table->string('tracking_token', 64)->unique();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('clicked_at')->nullable();
            $table->timestamps();

            $table->index(['drip_step_id', 'person_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drip_sends');
    }
};
