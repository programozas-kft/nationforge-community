<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Adds screenshot image to the feladatok help article.
 */
class HelpFeladatokImageSeeder extends Seeder
{
    public function run(): void
    {
        $article = DB::table('help_articles')->where('menu_key', 'feladatok')->first();

        if (!$article) {
            $this->command->warn('feladatok article not found.');
            return;
        }

        $img = "![Screenshot](/img/sugo/feladatok.png)\n\n";

        if (str_starts_with($article->content, '![')) {
            $this->command->warn('Image already present, skipping.');
            return;
        }

        DB::table('help_articles')->where('menu_key', 'feladatok')->update([
            'content'    => $img . $article->content,
            'content_en' => $img . $article->content_en,
            'updated_at' => now(),
        ]);

        $this->command->info('  ✓ feladatok — screenshot hozzáadva');
    }
}
