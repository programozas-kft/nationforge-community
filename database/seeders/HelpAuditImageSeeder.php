<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Adds screenshot image to the audit-naplo help article.
 */
class HelpAuditImageSeeder extends Seeder
{
    public function run(): void
    {
        $article = DB::table('help_articles')->where('menu_key', 'audit-naplo')->first();

        if (!$article) {
            $this->command->warn('audit-naplo article not found.');
            return;
        }

        $img = "![Screenshot](/img/sugo/audit-naplo.png)\n\n";
        $update = ['updated_at' => now()];
        foreach (['content', 'content_en', 'content_de', 'content_ro', 'content_sk'] as $col) {
            $val = $article->$col;
            if (!empty($val) && !str_starts_with($val, '![')) {
                $update[$col] = $img . $val;
            }
        }
        DB::table('help_articles')->where('menu_key', 'audit-naplo')->update($update);

        $this->command->info('  ✓ audit-naplo — screenshot hozzáadva (HU/EN/DE/RO/SK)');
    }
}
