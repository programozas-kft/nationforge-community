<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->boolean('waitlist_enabled')->default(false)->after('capacity');
        });

        Schema::table('event_registrations', function (Blueprint $table) {
            $table->boolean('waitlisted')->default(false)->after('checked_in_at');
            $table->unsignedSmallInteger('waitlist_position')->nullable()->after('waitlisted');
        });
    }

    public function down(): void
    {
        Schema::table('event_registrations', function (Blueprint $table) {
            $table->dropColumn(['waitlisted', 'waitlist_position']);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('waitlist_enabled');
        });
    }
};
