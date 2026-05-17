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

        if (str_starts_with($article->content, '![')) {
            $this->command->warn('Image already present, skipping.');
            return;
        }

        DB::table('help_articles')->where('menu_key', 'drip-kampanyok')->update([
            'content'    => $img . $article->content,
            'content_en' => $img . $article->content_en,
            'updated_at' => now(),
        ]);

        $this->command->info('  ✓ drip-kampanyok — screenshot hozzáadva');
    }
}
