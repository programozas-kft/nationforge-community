<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('people', function (Blueprint $table) {
            $table->string('lead_stage', 30)->nullable()->after('status');
            $table->tinyInteger('lead_score')->unsigned()->nullable()->after('lead_stage');
        });
    }

    public function down(): void
    {
        Schema::table('people', function (Blueprint $table) {
            $table->dropColumn(['lead_stage', 'lead_score']);
        });
    }
};
