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

        if (str_starts_with($article->content, '![')) {
            $this->command->warn('Image already present, skipping.');
            return;
        }

        DB::table('help_articles')->where('menu_key', 'audit-naplo')->update([
            'content'    => $img . $article->content,
            'content_en' => $img . $article->content_en,
            'updated_at' => now(),
        ]);

        $this->command->info('  ✓ audit-naplo — screenshot hozzáadva');
    }
}
