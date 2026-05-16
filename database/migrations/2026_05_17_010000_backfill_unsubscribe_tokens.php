<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('people')
            ->whereNull('unsubscribe_token')
            ->orWhere('unsubscribe_token', '')
            ->orderBy('id')
            ->chunkById(500, function ($rows) {
                foreach ($rows as $row) {
                    DB::table('people')
                        ->where('id', $row->id)
                        ->update(['unsubscribe_token' => Str::random(40)]);
                }
            });
    }

    public function down(): void {}
};
