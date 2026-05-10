<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $imgMd = "![Screenshot](/img/sugo/kampanyok.png)\n\n";

        $article = DB::table('help_articles')->where('menu_key', 'email-kampanyok')->first();
        if (! $article) {
            return;
        }

        $update = [];

        if ($article->content !== null && ! str_contains($article->content, '![')) {
            $update['content'] = $imgMd . $article->content;
        }

        if ($article->content_en !== null && ! str_contains($article->content_en, '![')) {
            $update['content_en'] = $imgMd . $article->content_en;
        }

        if ($update) {
            $update['updated_at'] = now();
            DB::table('help_articles')->where('menu_key', 'email-kampanyok')->update($update);
        }
    }

    public function down(): void
    {
        $imgMd = "![Screenshot](/img/sugo/kampanyok.png)\n\n";
        $pdo   = DB::connection()->getPdo();

        DB::table('help_articles')->where('menu_key', 'email-kampanyok')->update([
            'content'    => DB::raw('REPLACE(content, ' . $pdo->quote($imgMd) . ", '')"),
            'content_en' => DB::raw('REPLACE(content_en, ' . $pdo->quote($imgMd) . ", '')"),
        ]);
    }
};
