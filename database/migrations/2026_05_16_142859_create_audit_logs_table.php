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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('user_name', 150)->nullable();
            $table->string('action', 20);                  // created|updated|deleted|restored
            $table->string('auditable_type', 100);         // Person, Group, Event …
            $table->unsignedBigInteger('auditable_id');
            $table->string('model_label', 250)->nullable(); // display name of the record
            $table->json('changes')->nullable();            // [{field:{old,new}}]
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }

    // No updated_at — append-only log
};
