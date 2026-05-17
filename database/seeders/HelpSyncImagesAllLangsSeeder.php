<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Copies the leading screenshot image from HU content to DE/RO/SK content
 * for every help article where HU has a leading image but the other languages don't.
 * Safe to re-run: skips columns that already start with ![.
 */
class HelpSyncImagesAllLangsSeeder extends Seeder
{
    public function run(): void
    {
        $articles = DB::table('help_articles')->orderBy('sort_order')->get();

        foreach ($articles as $article) {
            $huContent = $article->content ?? '';

            // Skip articles whose HU content doesn't start with an image
            if (!str_starts_with($huContent, '![')) {
                continue;
            }

            // Extract the leading image block (e.g. "![Screenshot](/img/sugo/xyz.png)\n\n")
            preg_match('/^(!\[.*?\]\(.*?\)\n\n)/s', $huContent, $m);
            if (!isset($m[1])) {
                continue;
            }
            $imgPrefix = $m[1];

            $update = [];
            foreach (['content_de', 'content_ro', 'content_sk'] as $col) {
                $val = $article->$col ?? '';
                if (!empty($val) && !str_starts_with($val, '![')) {
                    $update[$col] = $imgPrefix . $val;
                }
            }

            if (!empty($update)) {
                $update['updated_at'] = now();
                DB::table('help_articles')->where('id', $article->id)->update($update);
                $this->command->info("  ✓ {$article->menu_key} — kép szinkronizálva (DE/RO/SK)");
            }
        }

        $this->command->info('Kész.');
    }
}
