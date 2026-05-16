<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('drip_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->string('description', 400)->nullable();
            $table->enum('status', ['draft', 'active', 'paused'])->default('draft');
            $table->enum('trigger_type', ['manual', 'group_join', 'tag_added'])->default('manual');
            $table->foreignId('trigger_group_id')->nullable()->constrained('groups')->nullOnDelete();
            $table->foreignId('trigger_tag_id')->nullable()->constrained('tags')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('drip_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('drip_campaign_id')->constrained('drip_campaigns')->cascadeOnDelete();
            $table->unsignedSmallInteger('position')->default(0);
            $table->string('subject', 255);
            $table->string('from_name', 100)->nullable();
            $table->string('from_email', 150)->nullable();
            $table->longText('body_html');
            $table->unsignedSmallInteger('delay_days')->default(0);
            $table->timestamps();

            $table->index(['drip_campaign_id', 'position']);
        });

        Schema::create('drip_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('drip_campaign_id')->constrained('drip_campaigns')->cascadeOnDelete();
            $table->foreignId('person_id')->constrained('people')->cascadeOnDelete();
            $table->enum('status', ['active', 'completed', 'cancelled'])->default('active');
            $table->unsignedSmallInteger('current_step_index')->default(0);
            $table->timestamp('next_send_at')->nullable();
            $table->timestamp('enrolled_at')->useCurrent();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'next_send_at']);
            $table->index(['drip_campaign_id', 'person_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drip_enrollments');
        Schema::dropIfExists('drip_steps');
        Schema::dropIfExists('drip_campaigns');
    }
};
