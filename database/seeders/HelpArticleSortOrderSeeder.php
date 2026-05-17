<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Sets sort_order values to match the admin sidebar menu structure:
 *
 *  MENÜ (10–39)
 *    10  fooldal
 *    20  kapcsolatok
 *    30  csoportok
 *    35  csoportok-fajlok-naptar
 *
 *  SZERVEZŐ (40–99)
 *    40  esemenyek
 *    50  adomanyok
 *    60  projektek
 *    70  feladatok
 *    80  email-kampanyok
 *    85  drip-kampanyok
 *
 *  ADMINISZTRÁCIÓ (100–)
 *   100  felhasznalok
 *   110  audit-naplo
 *   120  beallitasok
 *   130  verziokovetes
 *   140  sugo-kezeles
 *   150  nyelvvalto-zaszlo
 */
class HelpArticleSortOrderSeeder extends Seeder
{
    public function run(): void
    {
        $orders = [
            'fooldal'                 => 10,
            'kapcsolatok'             => 20,
            'csoportok'               => 30,
            'csoportok-fajlok-naptar' => 35,
            'esemenyek'               => 40,
            'adományok'               => 50,
            'projektek'               => 60,
            'feladatok'               => 70,
            'email-kampanyok'         => 80,
            'drip-kampanyok'          => 85,
            'felhasznalok'            => 100,
            'audit-naplo'             => 110,
            'beallitasok'             => 120,
            'verziokovetes'           => 130,
            'sugo-kezeles'            => 140,
            'nyelvvalto-zaszlo'       => 150,
        ];

        foreach ($orders as $menuKey => $sortOrder) {
            $updated = DB::table('help_articles')
                ->where('menu_key', $menuKey)
                ->update(['sort_order' => $sortOrder, 'updated_at' => now()]);

            $icon = $updated ? '✓' : '?';
            $this->command->line("  {$icon} {$menuKey} → {$sortOrder}");
        }
    }
}
