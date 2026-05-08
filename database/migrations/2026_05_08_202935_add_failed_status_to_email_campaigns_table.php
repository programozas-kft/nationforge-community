<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE email_campaigns MODIFY COLUMN status ENUM('draft','scheduled','sending','sent','failed','cancelled') NOT NULL DEFAULT 'draft'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE email_campaigns MODIFY COLUMN status ENUM('draft','scheduled','sending','sent','cancelled') NOT NULL DEFAULT 'draft'");
    }
};
