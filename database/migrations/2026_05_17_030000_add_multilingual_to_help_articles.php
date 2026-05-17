<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('help_articles', function (Blueprint $table) {
            $table->string('title_de')->nullable()->after('title_en');
            $table->text('content_de')->nullable()->after('content_en');
            $table->string('title_ro')->nullable()->after('title_de');
            $table->text('content_ro')->nullable()->after('content_de');
            $table->string('title_sk')->nullable()->after('title_ro');
            $table->text('content_sk')->nullable()->after('content_ro');
        });
    }

    public function down(): void
    {
        Schema::table('help_articles', function (Blueprint $table) {
            $table->dropColumn(['title_de','content_de','title_ro','content_ro','title_sk','content_sk']);
        });
    }
};
