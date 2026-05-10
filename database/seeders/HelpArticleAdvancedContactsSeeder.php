<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HelpArticleAdvancedContactsSeeder extends Seeder
{
    public function run(): void
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

Minden kapcsolat részletoldalán (bal oldali gomb → Megnyitás) elérhető az **Aktivitás napló** szekció.

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

Kattints az egyik fázis-chipre a beállításhoz:

| Fázis | Leírás |
|---|---|
| Új érdeklődő | Frissen bekerült, még nem szólítottuk meg |
| Kapcsolatba lépve | Megkerestük / válaszolt |
| Minősített | Kiderült, hogy potenciális tag / támogató |
| Ajánlat küldve | Küldtünk neki ajánlatot vagy meghívót |
| Megnyert | Csatlakozott / adományozott / önkéntes lett |
| Elveszett | Nem érdekelt / lemondta |

### Pontszám (1–5 csillag)

- **1 ★** – Hideg
- **2 ★★** – Langyos
- **3 ★★★** – Érdeklődő
- **4 ★★★★** – Forró
- **5 ★★★★★** – Nagyon forró

Kattints a csillagokra a pontszám beállításához (ugyanarra kattintva töröl). Mentsd el a **Mentés** gombbal.

### Szűrés értékelés szerint

A kapcsolatok listán a **Fázis** és **Min. pontszám** szűrőkkel gyorsan megtalálhatod a legforróbb érdeklődőket vagy az ajánlatban lévőket.

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

The export saves the results of the current filter (or all contacts if no filter is active).

### Import

1. Click the **Import** button
2. Choose a CSV or XLSX file
3. The system maps columns by name (e.g. `email`, `first_name`, `last_name`, `phone`, `city`, `status`)
4. Existing email addresses are skipped
5. After a successful import, feedback shows the number of imported rows

> **Tip:** You can use an exported file as a starting point for import — the header names match exactly.

---

## Filters and Saved Searches

Click the **Filter ▾** button in the contacts list to open the filter panel.

### Available Filters

| Filter | Description |
|---|---|
| Search | Searches name, email, phone |
| Status | One or more statuses selectable (chip buttons) |
| City | Partial match |
| Source | Partial match |
| Newsletter | Subscribed / Not subscribed / All |
| Group | Contacts belonging to a specific group |
| Registered (from / to) | Date range by creation date |
| Stage | By lead stage (see Lead Scoring) |
| Min. score | By minimum star rating |

### Saving a Filter

1. Set up the desired filters
2. Click the **Save** button in the filter panel
3. Give the filter a name (e.g. "Active members in Budapest")
4. You can reload any saved filter in one click from the **Saved filters** dropdown

> Saved filters are per-user — only you can see your own saved filters.

---

## Duplicate Detection and Merge

Click the **Duplicates** button to navigate to `/admin/people/duplicates`.

### How It Works

The system identifies probable duplicates using three matching criteria:
- **Email match** – identical email address
- **Phone match** – identical phone number
- **Name match** – identical full name (case-insensitive)

Each pair is shown on a card with a badge indicating the reason for the match.

### Merge Steps

1. Click the **Merge** button on the pair card
2. Choose **which one to keep** (left or right)
3. Confirm the action

**What happens on merge:**
- Empty fields are auto-filled from the other profile
- Donations, event RSVPs and group memberships are transferred to the kept profile
- The duplicate is soft-deleted (not permanently removed — can be restored)

---

## Activity Log

The **Activity log** section is available on every contact's detail page.

### Recording an Interaction

Fill in the quick-entry row:
- **Type** – Phone call, Email, Meeting, Note, Task, SMS, Other
- **Notes** – short text description
- **Time** – defaults to current date and time

Click **Record**.

### Timeline View

Entries appear as a vertical timeline with a different colour and icon per type. Each entry shows:
- The type name and date/time
- The name of the recording user
- The notes text
- A delete button (trash icon)

---

## Lead Scoring (Contact Intake / Evaluation)

The **Contact intake / Evaluation** card appears in the left column on every contact's detail page.

### Pipeline Stages

Click one of the stage chips to set it:

| Stage | Description |
|---|---|
| New Lead | Just added, not yet reached out to |
| Contacted | We reached out / they responded |
| Qualified | Identified as a potential member / supporter |
| Proposal Sent | Sent them a proposal or invitation |
| Converted | Joined / donated / became a volunteer |
| Lost | Not interested / declined |

### Score (1–5 stars)

- **1 ★** – Cold
- **2 ★★** – Lukewarm
- **3 ★★★** – Interested
- **4 ★★★★** – Hot
- **5 ★★★★★** – Very hot

Click the stars to set the score (clicking the same star again clears it). Save with the **Save** button.

### Filtering by Evaluation

Use the **Stage** and **Min. score** filters on the contacts list to quickly find the hottest leads or those in the proposal stage.

MD,
            'sort_order' => $maxOrder + 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
