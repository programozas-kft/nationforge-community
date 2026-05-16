<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_registrations', function (Blueprint $table) {
            $table->string('payment_status', 20)->default('free')->after('waitlist_position');
            $table->string('payment_provider', 20)->nullable()->after('payment_status');
            $table->string('payment_intent_id', 250)->nullable()->after('payment_provider');
            $table->unsignedInteger('paid_amount')->nullable()->after('payment_intent_id');
        });
    }

    public function down(): void
    {
        Schema::table('event_registrations', function (Blueprint $table) {
            $table->dropColumn(['payment_status', 'payment_provider', 'payment_intent_id', 'paid_amount']);
        });
    }
};
