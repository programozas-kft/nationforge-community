<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HelpArticleFlagIconsSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('help_articles')->where('menu_key', 'nyelvvalto-zaszlo')->exists()) {
            return;
        }

        $maxOrder = DB::table('help_articles')->max('sort_order') ?? 0;

        DB::table('help_articles')->insert([
            'menu_key'   => 'nyelvvalto-zaszlo',
            'title'      => 'Nyelvváltó és zászló ikonok',
            'title_en'   => 'Language Switcher & Flag Icons',
            'content'    => <<<'MD'
## Nyelvváltó és zászló ikonok

Az admin panel oldalsávjának alján egy **HU / EN** nyelvváltó található. A gombok mellett SVG zászló ikonok jelennek meg, amelyek a [flag-icons](https://flagicons.lipis.dev) könyvtár segítségével minden böngészőben és operációs rendszeren (Windows, Linux, macOS) egységesen jelennek meg.

### A nyelvváltó használata

1. Kattints a **HU** gombra a magyar felület megjelenítéséhez.
2. Kattints az **EN** gombra az angol felület megjelenítéséhez.
3. A kiválasztott nyelv a munkamenet végéig megmarad.

### Miért nem emoji?

A korábbi verzióban a zászlók emoji karakterek (`🇭🇺`, `🇬🇧`) voltak, amelyek **Windows rendszeren nem jelennek meg** — a Chrome és Edge böngészők sem rendereli a regionális jelző emoji-kat Windows alatt, mert a Microsoft operációs rendszere nem tartalmaz ilyen fontot.

A v1.12.0-tól kezdve a zászlók SVG alapú képek, amelyek minden platformon helyesen jelennek meg.

### Új nyelv hozzáadása

Ha egy új nyelvet szeretnél hozzáadni a rendszerhez:

1. Hozd létre a `lang/<nyelvkód>/` mappát (pl. `lang/de/`)
2. Másold át az összes `.php` fájlt és fordítsd le
3. Add hozzá az új gombot az `resources/views/admin/layouts/app.blade.php` fájlban
4. Az új zászlóhoz használj `<span class="fi fi-<iso2>">` elemet (pl. `fi-de` a német zászlóhoz)

Az elérhető zászlókódok listája: [flagicons.lipis.dev](https://flagicons.lipis.dev)

MD,
            'content_en' => <<<'MD'
## Language Switcher & Flag Icons

At the bottom of the admin panel sidebar there is a **HU / EN** language switcher. Flag icons appear next to the buttons, rendered via the [flag-icons](https://flagicons.lipis.dev) library — they display consistently across all browsers and operating systems (Windows, Linux, macOS).

### Using the language switcher

1. Click **HU** to switch the interface to Hungarian.
2. Click **EN** to switch the interface to English.
3. The selected language persists for the duration of the session.

### Why not emoji?

In earlier versions the flags were emoji characters (`🇭🇺`, `🇬🇧`), which **do not render on Windows** — Chrome and Edge do not support regional indicator emoji sequences on Windows because Microsoft's OS does not ship a font with country flag support.

Starting from v1.12.0, flags are SVG-based images that render correctly on all platforms.

### Adding a new language

To add a new language to the system:

1. Create the `lang/<code>/` directory (e.g. `lang/de/`)
2. Copy all `.php` files and translate them
3. Add the new button in `resources/views/admin/layouts/app.blade.php`
4. Use a `<span class="fi fi-<iso2>">` element for the flag (e.g. `fi-de` for German)

A full list of available flag codes: [flagicons.lipis.dev](https://flagicons.lipis.dev)

MD,
            'sort_order' => $maxOrder + 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
