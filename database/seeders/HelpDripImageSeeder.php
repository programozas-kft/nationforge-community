<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Adds screenshot image to the drip-kampanyok help article.
 */
class HelpDripImageSeeder extends Seeder
{
    public function run(): void
    {
        $article = DB::table('help_articles')->where('menu_key', 'drip-kampanyok')->first();

        if (!$article) {
            $this->command->warn('drip-kampanyok article not found.');
            return;
        }

        $img = "![Screenshot](/img/sugo/drip-kampanyok.png)\n\n";
        $update = ['updated_at' => now()];
        foreach (['content', 'content_en', 'content_de', 'content_ro', 'content_sk'] as $col) {
            $val = $article->$col;
            if (!empty($val) && !str_starts_with($val, '![')) {
                $update[$col] = $img . $val;
            } elseif (empty($val)) {
                // leave NULL columns alone — multilingual seeder handles them
            }
        }
        DB::table('help_articles')->where('menu_key', 'drip-kampanyok')->update($update);

        $this->command->info('  ✓ drip-kampanyok — screenshot hozzáadva (HU/EN/DE/RO/SK)');
    }
}
