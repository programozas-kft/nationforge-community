<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HelpArticleFromProSeeder extends Seeder
{
    public function run(): void
    {
        $raw = file_get_contents(__DIR__ . '/pro_help_export.json');
        // Strip BOM (UTF-8 and UTF-16)
        $raw = preg_replace('/^\xEF\xBB\xBF/', '', $raw);
        $raw = preg_replace('/^\xFF\xFE|^\xFE\xFF/', '', $raw);
        // Convert UTF-16 LE to UTF-8 if needed
        if (mb_detect_encoding($raw, 'UTF-16LE', true)) {
            $raw = mb_convert_encoding($raw, 'UTF-8', 'UTF-16LE');
        }
        $json = trim($raw);
        $articles = json_decode($json, true);
        if ($articles === null) {
            $this->command->error('JSON parse error: ' . json_last_error_msg());
            return;
        }

        foreach ($articles as $article) {
            $data = [
                'menu_key'   => $article['menu_key'],
                'title'      => $article['title'],
                'title_en'   => $article['title_en'],
                'title_de'   => $article['title_de'],
                'title_ro'   => $article['title_ro'],
                'title_sk'   => $article['title_sk'],
                'content'    => $article['content'],
                'content_en' => $article['content_en'],
                'content_de' => $article['content_de'],
                'content_ro' => $article['content_ro'],
                'content_sk' => $article['content_sk'],
                'sort_order' => $article['sort_order'],
                'video_url'  => $article['video_url'],
            ];

            $existing = DB::table('help_articles')->where('menu_key', $article['menu_key'])->first();

            if ($existing) {
                DB::table('help_articles')
                    ->where('menu_key', $article['menu_key'])
                    ->update(array_merge($data, ['updated_at' => now()]));
            } else {
                DB::table('help_articles')
                    ->insert(array_merge($data, ['created_at' => now(), 'updated_at' => now()]));
            }
        }

        $this->command->info('Imported ' . count($articles) . ' help articles from Pro.');
    }
}
