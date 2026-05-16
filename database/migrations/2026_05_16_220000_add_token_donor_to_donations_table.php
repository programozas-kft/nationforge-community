<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->string('token', 64)->nullable()->unique()->after('id');
            $table->string('donor_name', 150)->nullable()->after('person_id');
            $table->string('donor_email', 150)->nullable()->after('donor_name');
        });
    }

    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn(['token', 'donor_name', 'donor_email']);
        });
    }
};
