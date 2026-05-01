<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('help_articles', function (Blueprint $table) {
            $table->id();
            $table->string('menu_key')->unique();
            $table->string('title');
            $table->text('content');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        $now = now();

        $fooldal = <<<'EOT'
A Fooldal attekintost nyujt a rendszer legfontosabb adatairol.

**Statisztikai kartyak** - Az oldal teten negy osszesito kartya lathato:
- **Osszes kapcsolat** - a rendszerben nyilvantartott szemelyek szama, plusz az adott havi uj felvetelk
- **Kozelgo esemeny** - jovobeli esemenyek szama
- **Osszes adomany** - a beerkezett adományok forint osszege
- **Hirlevel feliratkozo** - az aktiv feliratkozok szama

**Legujabb kapcsolatok** - A legutobb felvett szemelyek listaja. Kattintassal megnyilik a reszletes profil.

**Kozelgo esemenyek** - A legkozelebbi programok datummal, idoponttal es helyszinnel.
EOT;

        $kapcsolatok = <<<'EOT'
A Kapcsolatok modul a szemelyek es szervezetek teljes nyilvantartasara szolgal.

**Uj kapcsolat felvetele** - Kattints az "Uj kapcsolat" gombra. A felugro ablakban megadhato a nev, email, telefon, varos, statusz, forras es megjegyzes. Profilkep is feltoltheto.

**Szerkesztes** - Kattints barmelyik sorra a tablazatban; a szerkeszto ablak azonnal megnyilik az aktualis adatokkal.

**Statuszok:**
- **Tag** - aktiv szervezeti tag
- **Tamogato** - szimpatizans, de nem tag
- **Adományozo** - penzugyileg tamogato szemely
- **VIP** - kiemelt kapcsolat
- **Inaktiv** - jelenleg nem aktiv szemely

**Hirlevel** - A feliratkozas jelolonegyzet mutatja, ki kap email kommunikaciot.
EOT;

        $esemenyek = <<<'EOT'
Az Esemenyek modul az osszes szervezett program kezelesere szolgal.

**Uj esemeny letrehozasa** - Kattints az "Uj esemeny" gombra. Megadhato:
- Esemeny neve es tipusa
- Kezdes es befejezes idopontja
- Helyszin (varos, cim) vagy Online jelolo
- Leiras es egyeb reszletek

**Szerkesztes** - Kattints az esemeny sorar a tablazatban.

**Torles** - A torles gombra kattintva megerosites utan az esemeny veglegesen torlodik.

**Kozelgo esemenyek** - A Foolalon is megjelennek a hamarosan esedekesek.
EOT;

        $csoportok = <<<'EOT'
A Csoportok modul a kapcsolatok tematikus szervezesere szolgal.

**Uj csoport letrehozasa** - Kattints az "Uj csoport" gombra, add meg a csoport nevet es leirassat.

**Tagok kezelese** - A csoport szerkesztofeluleten tagok adhatoak hozza es tavolithatoak el.

**Felhasznalás** - Csoportokkal konnyen szurodheto es celozható a kommunikacio, peldaul hirlevel-kuldesnel vagy esemeny-meghivasoknál.
EOT;

        $adományok = <<<'EOT'
Az Adományok modul az osszes beerkező penzugyi tamogatas nyilvantartasara szolgal.

**Adományok listaja** - A tablazatban lathato az adomanyozo neve, az osszeg (Ft), a beérkezes datuma es a fizetesi mod.

**Reszletek** - Az adomanyra kattintva megjelennek a reszletes informaciok.

**Torles** - Teves bejegyzes a torles gombbal eltavolithato.

**Osszesito** - Az osszes adomany forint osszege a Foolalon a statisztikai kartyan is lathato.
EOT;

        $felhasznalok = <<<'EOT'
A Felhasznalok oldalon az adminisztracios rendszer hozzaferesei kezelhetok.

**Uj felhasznalo** - Kattints az "Uj felhasznalo" gombra. Kotelezo adatok: teljes nev, email cim, jelszo, szerepkor. Profilkep is feltoltheto.

**Szerepkorok:**
- **super-admin** - teljes hozzaferes mindenhez
- **admin** - adminisztracios jogosultsag
- **editor** - tartalom szerkesztesi jog
- **member** - alapszintu hozzaferes

**Szerkesztes** - Kattints a felhasznalo sorar. A jelszo mezot uresen hagyva a regi jelszo megmarad.

**Sajat fiok** - A bejelentkezett felhasznalo sajat fiokjat nem lehet torolni.
EOT;

        $beallitasok = <<<'EOT'
A Beallitasok oldalon a rendszer alap konfiguracioja modosithato.

**Altalanos beallitasok:**
- **Rendszer neve** - a bongeszo fulon es az admin feluleten megjelenoő nev
- **Alkalmazas URL** - csak a szerveren levo .env fajlban modosithato
- **Nyelv** - jelenleg csak .env-ben allithato

**Email beallitasok:**
- **Felado neve** - kimeno emaileknel ez jelenik meg felladokent
- **Felado email** - a valasz erre az email-re erkezik

**Rendszerinformacio** - Az oldal aljan lathato a PHP verzio, a Laravel verzio es a jelenlegi kornyezet.
EOT;

        DB::table('help_articles')->insert([
            ['menu_key' => 'fooldal',      'title' => 'Főoldal',      'content' => $fooldal,      'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['menu_key' => 'kapcsolatok',  'title' => 'Kapcsolatok',  'content' => $kapcsolatok,  'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['menu_key' => 'esemenyek',    'title' => 'Események',    'content' => $esemenyek,    'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['menu_key' => 'csoportok',    'title' => 'Csoportok',    'content' => $csoportok,    'sort_order' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['menu_key' => 'adományok',   'title' => 'Adományok',   'content' => $adományok,   'sort_order' => 5, 'created_at' => $now, 'updated_at' => $now],
            ['menu_key' => 'felhasznalok', 'title' => 'Felhasználók', 'content' => $felhasznalok, 'sort_order' => 6, 'created_at' => $now, 'updated_at' => $now],
            ['menu_key' => 'beallitasok',  'title' => 'Beállítások',  'content' => $beallitasok,  'sort_order' => 7, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('help_articles');
    }
};
