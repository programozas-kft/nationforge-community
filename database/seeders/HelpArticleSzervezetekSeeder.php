<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HelpArticleSzervezetekSeeder extends Seeder
{
    public function run(): void
    {
        $existing = DB::table('help_articles')->where('menu_key', 'szervezetek')->first();

        $data = [
            'menu_key'   => 'szervezetek',
            'sort_order' => 59,
            'title'      => 'Szervezetek',
            'content'    => <<<'MD'
## Szervezetek

A Szervezetek oldal a rendszerben regisztrált szervezetek kezelésére szolgál.

![Szervezetek oldal](/img/sugo/organizations.png)

---

### Szervezetek listája

A táblázat minden szervezetet megjelenít a következő adatokkal:

| Oszlop | Leírás |
|---|---|
| **Szervezet neve** | A szervezet neve és logója |
| **Felhasználók** | Hány felhasználó tartozik ehhez a szervezethez |
| **Állapot** | Aktív vagy Inaktív |
| **Létrehozva** | A szervezet létrehozásának dátuma |

---

### Új szervezet létrehozása

Kattints a **+ Új szervezet** gombra a jobb felső sarokban. Add meg a szervezet nevét, majd mentsd el.

---

### Pro funkció

Több szervezet kezelése csak a **Pro verzióban** érhető el. A Community kiadásban egyetlen szervezet működik – ez az alapértelmezett NationForge szervezet, amelynek adatai a Beállítások oldalon módosíthatók.

---

### Szervezetek és felhasználók

Minden felhasználó egy szervezethez tartozik. A felhasználók kezelése a **Felhasználók** oldalon érhető el.
MD,
            'title_en'   => 'Organizations',
            'content_en' => <<<'MD'
## Organizations

The Organizations page is used to manage the organizations registered in the system.

![Organizations page](/img/sugo/organizations.png)

---

### Organizations List

The table displays all organizations with the following columns:

| Column | Description |
|---|---|
| **Organization name** | The organization's name and logo |
| **Users** | How many users belong to this organization |
| **Status** | Active or Inactive |
| **Created** | The date the organization was created |

---

### Creating a New Organization

Click the **+ New organization** button in the top right corner. Enter the organization name and save.

---

### Pro Feature

Managing multiple organizations is only available in the **Pro edition**. In the Community edition, a single organization is available — the default NationForge organization, whose details can be modified on the Settings page.

---

### Organizations and Users

Every user belongs to one organization. User management is available on the **Users** page.
MD,
            'title_de'   => 'Organisationen',
            'content_de' => <<<'MD'
## Organisationen

Die Seite „Organisationen" dient der Verwaltung der im System registrierten Organisationen.

![Organisationen](/img/sugo/organizations.png)

---

### Organisationsliste

Die Tabelle zeigt alle Organisationen mit folgenden Spalten:

| Spalte | Beschreibung |
|---|---|
| **Organisationsname** | Name und Logo der Organisation |
| **Benutzer** | Anzahl der Benutzer in dieser Organisation |
| **Status** | Aktiv oder Inaktiv |
| **Erstellt** | Erstellungsdatum der Organisation |

---

### Pro-Funktion

Die Verwaltung mehrerer Organisationen ist nur in der **Pro-Edition** verfügbar.
MD,
            'title_ro'   => 'Organizații',
            'content_ro' => <<<'MD'
## Organizații

Pagina Organizații este utilizată pentru gestionarea organizațiilor înregistrate în sistem.

![Organizații](/img/sugo/organizations.png)

---

### Lista organizațiilor

Tabelul afișează toate organizațiile cu următoarele coloane:

| Coloană | Descriere |
|---|---|
| **Nume organizație** | Numele și logo-ul organizației |
| **Utilizatori** | Câți utilizatori aparțin acestei organizații |
| **Status** | Activ sau Inactiv |
| **Creat** | Data creării organizației |

---

### Funcție Pro

Gestionarea mai multor organizații este disponibilă numai în **ediția Pro**.
MD,
            'title_sk'   => 'Organizácie',
            'content_sk' => <<<'MD'
## Organizácie

Stránka Organizácie slúži na správu organizácií zaregistrovaných v systéme.

![Organizácie](/img/sugo/organizations.png)

---

### Zoznam organizácií

Tabuľka zobrazuje všetky organizácie s nasledujúcimi stĺpcami:

| Stĺpec | Popis |
|---|---|
| **Názov organizácie** | Názov a logo organizácie |
| **Používatelia** | Počet používateľov patriacich do tejto organizácie |
| **Stav** | Aktívny alebo Neaktívny |
| **Vytvorené** | Dátum vytvorenia organizácie |

---

### Pro funkcia

Správa viacerých organizácií je dostupná iba v **Pro edícii**.
MD,
            'video_url'  => null,
        ];

        if ($existing) {
            DB::table('help_articles')->where('menu_key', 'szervezetek')->update(
                array_merge($data, ['updated_at' => now()])
            );
        } else {
            DB::table('help_articles')->insert(
                array_merge($data, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }
}
