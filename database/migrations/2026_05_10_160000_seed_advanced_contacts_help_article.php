<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::table('help_articles')->where('menu_key', 'kapcsolatok-halado')->exists()) {
            return;
        }

        $maxOrder = DB::table('help_articles')->max('sort_order') ?? 0;

        DB::table('help_articles')->insert([
            'menu_key'   => 'kapcsolatok-halado',
            'title'      => 'Kapcsolatok – Haladó funkciók',
            'title_en'   => 'Contacts – Advanced Features',
            'content'    => <<<'MD'
## Kapcsolatok – Haladó CRM funkciók

Ez az oldal a Kapcsolatok modul haladó funkcióit mutatja be: importálás és exportálás, mentett szűrők, duplikátum-keresés, aktivitás napló és lead scoring.

---

## Import és Export

A Kapcsolatok listán (felső jobb sarok) elérhető az **Export ▾** gomb és az **Import** gomb.

### Export

- **CSV** – UTF-8 BOM kódolású, pontosvessző elválasztójú fájl, azonnal megnyitható Excelben
- **Excel (XLSX)** – félkövér fejlécsorral, sortörések nélkül

Az export az éppen aktív szűrők eredményét menti ki (vagy az összeset, ha nincs szűrő).

### Import

1. Kattints az **Import** gombra
2. Válassz CSV vagy XLSX fájlt
3. A rendszer oszlopnév alapján illeszti a mezőket (pl. `email`, `first_name`, `last_name`, `phone`, `city`, `status`)
4. Már létező emailcímek kihagyásra kerülnek
5. A sikeres import után visszajelzés jelenik meg az importált sorok számáról

> **Tipp:** Az export fájlját kiindulópontként használhatod az importhoz – a fejlécsor pontos nevei megegyeznek.

---

## Szűrők és mentett keresések

A listán a **Szűrő ▾** gombra kattintva nyílik meg a szűrőpanel.

### Elérhető szűrők

| Szűrő | Leírás |
|---|---|
| Keresés | Névre, emailre, telefonra keres |
| Státusz | Egy vagy több státusz kiválasztható (chip-gombok) |
| Város | Részleges egyezés |
| Forrás | Részleges egyezés |
| Hírlevél | Feliratkozott / Nem feliratkozott / Mind |
| Csoport | Adott csoporthoz tartozó kapcsolatok |
| Regisztrálva (tól / ig) | Létrehozás dátum szerinti tartomány |
| Fázis | Lead fázis szerint (ld. Lead scoring) |
| Min. pontszám | Minimum csillagszám szerint |

### Szűrő mentése

1. Állítsd be a kívánt szűrőket
2. Kattints a **Mentés** gombra a szűrőpanelen
3. Adj nevet a szűrőnek (pl. "Aktív tagok Budapesten")
4. Az elmentett szűrőkre bármikor visszatölthetsz a **Mentett szűrők** legördülőből

> A mentett szűrők felhasználónkéntiek – csak te látod a saját szűrőidet.

---

## Duplikátum-keresés és összevonás

A **Duplikátumok** gombra kattintva a `/admin/people/duplicates` oldalra kerülsz.

### Hogyan működik?

A rendszer három egyezési elv alapján azonosítja a valószínű duplikátumokat:
- **Email egyezés** – azonos emailcím
- **Telefon egyezés** – azonos telefonszám
- **Névegyezés** – azonos teljes név (kis-/nagybetű-független)

Minden pár kártyán jelenik meg az egyezés okát jelző badge-dzsel.

### Összevonás lépései

1. A kártyán kattints az **Összevonás** gombra
2. Válaszd ki, **melyiket tartod meg** (bal vagy jobb)
3. Erősítsd meg

**Mi történik összevonáskor:**
- Az üres mezők automatikusan kitöltődnek a másik profilból
- Az adományok, esemény RSVP-k és csoporttagságok átkerülnek a megtartott profilra
- A duplikátum soft-delete-elve lesz (nem törlődik véglegesen, visszaállítható)

---

## Aktivitás napló

Minden kapcsolat részletoldalán elérhető az **Aktivitás napló** szekció.

### Interakció rögzítése

Töltsd ki a gyorsbeviteli sort:
- **Típus** – Telefonhívás, Email, Megbeszélés, Feljegyzés, Feladat, SMS, Egyéb
- **Megjegyzés** – rövid szöveges leírás
- **Időpont** – alapértelmezés az aktuális időpont

Kattints a **Rögzítés** gombra.

### Timeline nézet

A bejegyzések vertikális idővonalként jelennek meg, típusonként eltérő színnel és ikonnal. Minden bejegyzésnél látható:
- A típus neve és dátum/idő
- A rögzítő felhasználó neve
- A megjegyzés szövege
- Törlés gomb (kuka ikon)

---

## Lead scoring (kapcsolatfelvétel / érdeklődőértékelés)

Minden kapcsolat részletoldalán a bal oszlopban megjelenik a **Kapcsolatfelvétel / Értékelés** kártya.

### Értékesítési fázisok

| Fázis | Leírás |
|---|---|
| Új érdeklődő | Frissen bekerült, még nem szólítottuk meg |
| Kapcsolatba lépve | Megkerestük / válaszolt |
| Minősített | Kiderült, hogy potenciális tag / támogató |
| Ajánlat küldve | Küldtünk neki ajánlatot vagy meghívót |
| Megnyert | Csatlakozott / adományozott / önkéntes lett |
| Elveszett | Nem érdekelt / lemondta |

### Pontszám (1–5 csillag)

| Csillag | Szint |
|---|---|
| 1 ★ | Hideg |
| 2 ★★ | Langyos |
| 3 ★★★ | Érdeklődő |
| 4 ★★★★ | Forró |
| 5 ★★★★★ | Nagyon forró |

Kattints a csillagokra a pontszám beállításához (ugyanarra kattintva töröl). Mentsd el a **Mentés** gombbal.

MD,
            'content_en' => <<<'MD'
## Contacts – Advanced CRM Features

This page covers the advanced features of the Contacts module: import & export, saved filters, duplicate detection, activity log, and lead scoring.

---

## Import and Export

The **Export ▾** and **Import** buttons are available in the top-right corner of the Contacts list.

### Export

- **CSV** – UTF-8 BOM encoded, semicolon-delimited file, opens directly in Excel
- **Excel (XLSX)** – bold header row, no line breaks

### Import

1. Click the **Import** button
2. Choose a CSV or XLSX file
3. The system maps columns by name (e.g. `email`, `first_name`, `last_name`, `phone`, `city`, `status`)
4. Existing email addresses are skipped
5. After a successful import, feedback shows the number of imported rows

> **Tip:** You can use an exported file as a starting point for import — the header names match exactly.

---

## Filters and Saved Searches

Click **Filter ▾** to open the filter panel. Available filters: text search, status (multi-chip), city, source, newsletter, group, registration date range, lead stage, min. score.

**Save a filter set:** Set your filters → click **Save** → give it a name. Reload any saved filter from the **Saved filters** dropdown. Presets are per-user.

---

## Duplicate Detection & Merge

Click the **Duplicates** button to open `/admin/people/duplicates`.

Matches by: identical email, identical phone, identical full name (case-insensitive).

To merge: click **Merge** on the pair card → choose which to keep → confirm. Empty fields are auto-filled, donations/RSVPs/group memberships are transferred, duplicate is soft-deleted.

---

## Activity Log

On any contact's detail page, record interactions: Phone call, Email, Meeting, Note, Task, SMS, Other — with timestamp, notes and recording user. Shown as a colour-coded vertical timeline.

---

## Lead Scoring

Set a **pipeline stage** (New Lead → Contacted → Qualified → Proposal Sent → Converted → Lost) and a **1–5 star score** (Cold → Very hot) on each contact's detail page. Filter the contacts list by Stage and Min. score.

MD,
            'sort_order' => $maxOrder + 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('help_articles')->where('menu_key', 'kapcsolatok-halado')->delete();
    }
};
