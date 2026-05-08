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
        Schema::table('email_campaigns', function (Blueprint $table) {
            if (! Schema::hasColumn('email_campaigns', 'name')) {
                $table->string('name')->after('id')->default('');
            }
            if (! Schema::hasColumn('email_campaigns', 'failed_count')) {
                $table->unsignedInteger('failed_count')->default(0)->after('sent_count');
            }
        });
    }

    public function down(): void
    {
        Schema::table('email_campaigns', function (Blueprint $table) {
            $table->dropColumn(array_filter(['name', 'failed_count'], function ($col) {
                return Schema::hasColumn('email_campaigns', $col);
            }));
        });
    }
};
