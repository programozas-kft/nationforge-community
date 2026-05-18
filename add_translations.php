<?php
$file = 'c:/xampp/htdocs/nationforge/resources/views/admin/partials/changelog_content.blade.php';
$content = file_get_contents($file);

// 1. Fix locale line
$content = str_replace(
    "in_array(app()->getLocale(), ['hu', 'en'])",
    "in_array(app()->getLocale(), ['hu', 'en', 'de', 'ro', 'sk'])",
    $content
);

// 2. Badge text translations
$badgeMap = [
    "'text'  => ['hu' => 'Aktuális, Legújabb', 'en' => 'Current, Latest']," =>
        "'text'  => ['hu' => 'Aktuális, Legújabb', 'en' => 'Current, Latest', 'de' => 'Aktuell, Neueste', 'ro' => 'Curent, Cel mai nou', 'sk' => 'Aktuálne, Najnovšie'],",
    "'text'  => ['hu' => 'Új modul', 'en' => 'New module']," =>
        "'text'  => ['hu' => 'Új modul', 'en' => 'New module', 'de' => 'Neues Modul', 'ro' => 'Modul nou', 'sk' => 'Nový modul'],",
    "'text'  => ['hu' => 'Fejlesztés', 'en' => 'Improvement']," =>
        "'text'  => ['hu' => 'Fejlesztés', 'en' => 'Improvement', 'de' => 'Verbesserung', 'ro' => 'Îmbunătățire', 'sk' => 'Vylepšenie'],",
    "'text'  => ['hu' => 'Hibajavítás', 'en' => 'Bug Fix']," =>
        "'text'  => ['hu' => 'Hibajavítás', 'en' => 'Bug Fix', 'de' => 'Fehlerbehebung', 'ro' => 'Remediere erori', 'sk' => 'Oprava chyby'],",
    "'text'  => ['hu' => 'Mérföldkő', 'en' => 'Milestone']," =>
        "'text'  => ['hu' => 'Mérföldkő', 'en' => 'Milestone', 'de' => 'Meilenstein', 'ro' => 'Etapă majoră', 'sk' => 'Míľnik'],",
];
foreach ($badgeMap as $from => $to) {
    $content = str_replace($from, $to, $content);
}

// 3. Date translations
$dateMap = [
    "'date' => ['hu' => '2026. május 17.', 'en' => 'May 17, 2026']," =>
        "'date' => ['hu' => '2026. május 17.', 'en' => 'May 17, 2026', 'de' => '17. Mai 2026', 'ro' => '17 mai 2026', 'sk' => '17. mája 2026'],",
    "'date' => ['hu' => '2026. május 16.', 'en' => 'May 16, 2026']," =>
        "'date' => ['hu' => '2026. május 16.', 'en' => 'May 16, 2026', 'de' => '16. Mai 2026', 'ro' => '16 mai 2026', 'sk' => '16. mája 2026'],",
    "'date' => ['hu' => '2026. május 12.', 'en' => 'May 12, 2026']," =>
        "'date' => ['hu' => '2026. május 12.', 'en' => 'May 12, 2026', 'de' => '12. Mai 2026', 'ro' => '12 mai 2026', 'sk' => '12. mája 2026'],",
    "'date' => ['hu' => '2026. május 10.', 'en' => 'May 10, 2026']," =>
        "'date' => ['hu' => '2026. május 10.', 'en' => 'May 10, 2026', 'de' => '10. Mai 2026', 'ro' => '10 mai 2026', 'sk' => '10. mája 2026'],",
    "'date' => ['hu' => '2026. május 8.', 'en' => 'May 8, 2026']," =>
        "'date' => ['hu' => '2026. május 8.', 'en' => 'May 8, 2026', 'de' => '8. Mai 2026', 'ro' => '8 mai 2026', 'sk' => '8. mája 2026'],",
    "'date' => ['hu' => '2026. május 6.', 'en' => 'May 6, 2026']," =>
        "'date' => ['hu' => '2026. május 6.', 'en' => 'May 6, 2026', 'de' => '6. Mai 2026', 'ro' => '6 mai 2026', 'sk' => '6. mája 2026'],",
    "'date' => ['hu' => '2026. május 5.', 'en' => 'May 5, 2026']," =>
        "'date' => ['hu' => '2026. május 5.', 'en' => 'May 5, 2026', 'de' => '5. Mai 2026', 'ro' => '5 mai 2026', 'sk' => '5. mája 2026'],",
    "'date' => ['hu' => '2026. május 3.', 'en' => 'May 3, 2026']," =>
        "'date' => ['hu' => '2026. május 3.', 'en' => 'May 3, 2026', 'de' => '3. Mai 2026', 'ro' => '3 mai 2026', 'sk' => '3. mája 2026'],",
    "'date' => ['hu' => '2026. május 2.', 'en' => 'May 2, 2026']," =>
        "'date' => ['hu' => '2026. május 2.', 'en' => 'May 2, 2026', 'de' => '2. Mai 2026', 'ro' => '2 mai 2026', 'sk' => '2. mája 2026'],",
    "'date' => ['hu' => '2026. május 1.', 'en' => 'May 1, 2026']," =>
        "'date' => ['hu' => '2026. május 1.', 'en' => 'May 1, 2026', 'de' => '1. Mai 2026', 'ro' => '1 mai 2026', 'sk' => '1. mája 2026'],",
    "'date' => ['hu' => '2026. április', 'en' => 'April 2026']," =>
        "'date' => ['hu' => '2026. április', 'en' => 'April 2026', 'de' => 'April 2026', 'ro' => 'Aprilie 2026', 'sk' => 'Apríl 2026'],",
    "'date' => ['hu' => 'Indulás, Alaprendszer', 'en' => 'Launch, Core system']," =>
        "'date' => ['hu' => 'Indulás, Alaprendszer', 'en' => 'Launch, Core system', 'de' => 'Start, Kernsystem', 'ro' => 'Lansare, Sistem de bază', 'sk' => 'Štart, Základný systém'],",
];
foreach ($dateMap as $from => $to) {
    $content = str_replace($from, $to, $content);
}

file_put_contents($file, $content);
echo "Phase 1 done (locale, badges, dates)\n";
echo "File size: " . strlen($content) . "\n";
// Verify locale line
preg_match("/in_array.*?\)/", $content, $m);
echo "Locale line: " . $m[0] . "\n";
