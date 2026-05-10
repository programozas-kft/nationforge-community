<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $imageMap = [
        'fooldal'       => '/img/sugo/fooldal-v2.png',
        'kapcsolatok'   => '/img/sugo/kapcsolatok.png',
        'esemenyek'     => '/img/sugo/esemenyek.png',
        'csoportok'     => '/img/sugo/cdoportok.png',
        'adományok'     => '/img/sugo/adomanyok.png',
        'felhasznalok'  => '/img/sugo/felhasznalok.png',
        'beallitasok'   => '/img/sugo/beallitasok.png',
        'projektek'     => '/img/sugo/projektek.png',
        'verziokovetes' => '/img/sugo/verziokovetes.png',
        'sugo-kezeles'  => '/img/sugo/sugo-kezelese.png',
    ];

    public function up(): void
    {
        // 1. Fix localhost-specific URL prefix in existing content
        DB::statement("UPDATE help_articles SET
            content    = REPLACE(content,    '/nationforge/public/', '/'),
            content_en = REPLACE(content_en, '/nationforge/public/', '/')
            WHERE content LIKE '%/nationforge/public/%'
               OR content_en LIKE '%/nationforge/public/%'");

        // 2. Add image to HU and EN content where missing
        $articles = DB::table('help_articles')->get(['id', 'menu_key', 'content', 'content_en']);

        foreach ($articles as $article) {
            $img = $this->imageMap[$article->menu_key] ?? null;
            if (! $img) {
                continue;
            }

            $imgMd  = "![Screenshot]({$img})\n\n";
            $update = [];

            if ($article->content !== null && ! str_contains($article->content, '![')) {
                $update['content'] = $imgMd . $article->content;
            }

            if ($article->content_en !== null && ! str_contains($article->content_en, '![')) {
                $update['content_en'] = $imgMd . $article->content_en;
            }

            if ($update) {
                $update['updated_at'] = now();
                DB::table('help_articles')->where('id', $article->id)->update($update);
            }
        }
    }

    public function down(): void
    {
        foreach ($this->imageMap as $menuKey => $img) {
            $imgMd = "![Screenshot]({$img})\n\n";
            DB::table('help_articles')
                ->where('menu_key', $menuKey)
                ->update([
                    'content'    => DB::raw("REPLACE(content, " . DB::connection()->getPdo()->quote($imgMd) . ", '')"),
                    'content_en' => DB::raw("REPLACE(content_en, " . DB::connection()->getPdo()->quote($imgMd) . ", '')"),
                ]);
        }
    }
};
