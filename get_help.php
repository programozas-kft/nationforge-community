<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$articles = \App\Models\HelpArticle::orderBy('id')->get()->toArray();
file_put_contents('c:\xampp\htdocs\nationforge\help_dump.json', json_encode($articles, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "Dumped.";
