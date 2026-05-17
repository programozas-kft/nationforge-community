<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Fixes Hungarian (HU) content in help_articles:
 *  - Original 7 articles created without accented characters → proper Hungarian
 *  - csoportok-fajlok-naptar → English text was placed in HU content by mistake
 */
class HelpArticleHungarianFixSeeder extends Seeder
{
    public function run(): void
    {
        $fixes = [

            'fooldal' => [
                'content' => <<<'MD'
![Screenshot](/img/sugo/fooldal-v2.png)

## Főoldal

A Főoldal áttekintést nyújt a rendszer legfontosabb adatairól.

**Statisztikai kártyák** – Az oldal tetején négy összesítő kártya látható:
- **Összes kapcsolat** – a rendszerben nyilvántartott személyek száma, plusz az adott havi új felvételek
- **Közelgő esemény** – jövőbeli események száma
- **Összes adomány** – a beérkezett adományok összege
- **Hírlevél feliratkozó** – az aktív feliratkozók száma

**Legújabb kapcsolatok** – A legutóbb felvett személyek listája. Kattintással megnyílik a részletes profil.

**Közelgő események** – A legközelebbi programok dátummal, időponttal és helyszínnel.
MD,
            ],

            'kapcsolatok' => [
                'content' => <<<'MD'
![Screenshot](/img/sugo/kapcsolatok.png)

## Kapcsolatok

A Kapcsolatok modul a személyek és szervezetek teljes nyilvántartására szolgál.

**Új kapcsolat felvétele** – Kattints az „Új kapcsolat" gombra. A felugró ablakban megadható a név, email, telefon, város, státusz, forrás és megjegyzés. Profilkép is feltölthető.

**Szerkesztés** – Kattints bármelyik sorra a táblázatban; a szerkesztő ablak azonnal megnyílik az aktuális adatokkal.

**Státuszok:**
- **Tag** – aktív szervezeti tag
- **Támogató** – szimpatizáns, de nem tag
- **Adományozó** – pénzügyileg támogató személy
- **VIP** – kiemelt kapcsolat
- **Inaktív** – jelenleg nem aktív személy

**Hírlevél** – A feliratkozás jelölőnégyzet mutatja, ki kap email kommunikációt.
MD,
            ],

            'esemenyek' => [
                'content' => <<<'MD'
![Screenshot](/img/sugo/esemenyek.png)

## Események

Az Események modul az összes szervezett program kezelésére szolgál.

**Új esemény létrehozása** – Kattints az „Új esemény" gombra. Megadható:
- Esemény neve és típusa
- Kezdés és befejezés időpontja
- Helyszín (város, cím) vagy Online jelölő
- Leírás és egyéb részletek

**Szerkesztés** – Kattints az esemény sorára a táblázatban.

**Törlés** – A törlés gombra kattintva megerősítés után az esemény véglegesen törlődik.

**Közelgő események** – A Főoldalon is megjelennek a hamarosan esedékesek.
MD,
            ],

            'csoportok' => [
                'content' => <<<'MD'
![Screenshot](/img/sugo/cdoportok.png)

## Csoportok

A Csoportok modul a kapcsolatok tematikus szervezésére szolgál.

**Új csoport létrehozása** – Kattints az „Új csoport" gombra, add meg a csoport nevét és leírását.

**Tagok kezelése** – A csoport szerkesztőfelületen tagok adhatók hozzá és távolíthatók el.

**Felhasználás** – Csoportokkal könnyen szűrhető és célozható a kommunikáció, például hírlevél-küldésnél vagy esemény-meghívásoknál.
MD,
            ],

            'adományok' => [
                'content' => <<<'MD'
![Screenshot](/img/sugo/adomanyok.png)

## Adományok

Az Adományok modul az összes beérkező pénzügyi támogatás nyilvántartására szolgál.

**Adományok listája** – A táblázatban látható az adományozó neve, az összeg, a beérkezés dátuma és a fizetési mód.

**Részletek** – Az adományra kattintva megjelennek a részletes információk.

**Törlés** – Téves bejegyzés a törlés gombbal eltávolítható.

**Összesítő** – Az összes adomány összege a Főoldalon a statisztikai kártyán is látható.
MD,
            ],

            'felhasznalok' => [
                'content' => <<<'MD'
![Screenshot](/img/sugo/felhasznalok.png)

## Felhasználók

A Felhasználók oldalon az adminisztrációs rendszer hozzáférései kezelhetők.

**Új felhasználó** – Kattints az „Új felhasználó" gombra. Kötelező adatok: teljes név, email cím, jelszó, szerepkör. Profilkép is feltölthető.

**Szerepkörök:**
- **super-admin** – teljes hozzáférés mindenhez
- **admin** – adminisztrációs jogosultság
- **editor** – tartalom szerkesztési jog
- **member** – alapszintű hozzáférés

**Szerkesztés** – Kattints a felhasználó sorára. A jelszó mezőt üresen hagyva a régi jelszó megmarad.

**Saját fiók** – A bejelentkezett felhasználó saját fiókját nem lehet törölni.
MD,
            ],

            'beallitasok' => [
                'content' => <<<'MD'
![Screenshot](/img/sugo/beallitasok.png)

## Beállítások

A Beállítások oldalon a rendszer alap konfigurációja módosítható.

**Általános beállítások:**
- **Rendszer neve** – a böngésző fülön és az admin felületen megjelenő név
- **Alkalmazás URL** – csak a szerveren lévő `.env` fájlban módosítható
- **Alapértelmezett nyelv** – az 5 elérhető nyelv közül választható

**Email beállítások:**
- **Feladó neve** – kimenő emaileknél ez jelenik meg feladóként
- **Feladó email** – a válasz erre az email-re érkezik

**Rendszerinformáció** – Az oldal alján látható a PHP verzió, a Laravel verzió és a jelenlegi környezet.
MD,
            ],

            'csoportok-fajlok-naptar' => [
                'content' => <<<'MD'
## Fájlmegosztás és naptár csoportokon belül

Minden csoport rendelkezik egy **Fájlok** és egy **Naptár** füllel, amelyek a csoport részletoldalán érhetők el.

---

## Fájlmegosztás

### Fájl feltöltése

1. Nyisd meg a csoport részletoldalát
2. Kattints a **Fájlok** fülre
3. Kattints a **Feltöltés** gombra
4. Válaszd ki a fájlt a számítógépedről (max. 10 MB)
5. A feltöltött fájl azonnal megjelenik a listában

### Fájlok letöltése

- Kattints a fájl neve melletti **Letöltés** gombra
- A fájl azonnal letöltődik a böngésződbe

### Fájlok törlése

- A fájl sorában kattints a **Törlés** (kuka) ikonra
- Megerősítés után a fájl véglegesen törlődik

> **Megjegyzés:** A fájlok csak a csoport tagjai számára elérhetők.

---

## Csoportnaptár

### Az eseménynaptár megjelenítése

A **Naptár** fül megmutatja az összes olyan eseményt, amelyet a csoporthoz rendeltek.

### Esemény hozzáadása a csoporthoz

1. Hozd létre az eseményt az **Események** menüpontban
2. Az esemény részletoldalán rendeld hozzá a csoporthoz, **vagy**
3. A csoport részletoldalán kattints az **Esemény hozzárendelése** gombra és válaszd ki a meglévő eseményt

### Naptár navigáció

- **Előző / Következő** nyilakkal léphetsz a hónapok között
- Az esemény nevére kattintva megnyílik az esemény adminisztrációs oldala

MD,
            ],

        ];

        foreach ($fixes as $menuKey => $data) {
            $updated = DB::table('help_articles')
                ->where('menu_key', $menuKey)
                ->update(array_merge($data, ['updated_at' => now()]));

            if ($updated) {
                $this->command->info("  ✓ {$menuKey}");
            } else {
                $this->command->warn("  ? {$menuKey} — nem található");
            }
        }
    }
}
