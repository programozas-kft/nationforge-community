<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$data = json_decode(file_get_contents(__DIR__.'/help_fix.json'), true);
foreach($data as $item) {
    if ($article = \App\Models\HelpArticle::find($item['id'])) {
        $article->content = $item['content'];
        $article->save();
    }
}
echo "Done fixing accents!\n";
