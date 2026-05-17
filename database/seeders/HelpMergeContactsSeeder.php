<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Merges "kapcsolatok-halado" into "kapcsolatok" and deletes the separate article.
 */
class HelpMergeContactsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('help_articles')
            ->where('menu_key', 'kapcsolatok')
            ->update([
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
3. Adj nevet a szűrőnek (pl. „Aktív tagok Budapesten")
4. Az elmentett szűrőkre bármikor visszatölthetsz a **Mentett szűrők** legördülőből

> A mentett szűrők felhasználónkéntiek – csak te látod a saját szűrőidet.

---

## Duplikátum-keresés és összevonás

A **Duplikátumok** gombra kattintva a `/admin/people/duplicates` oldalra kerülsz.

A rendszer három egyezési elv alapján azonosítja a valószínű duplikátumokat:
- **Email egyezés** – azonos emailcím
- **Telefon egyezés** – azonos telefonszám
- **Névegyezés** – azonos teljes név (kis-/nagybetű-független)

### Összevonás lépései

1. A kártyán kattints az **Összevonás** gombra
2. Válaszd ki, **melyiket tartod meg** (bal vagy jobb)
3. Erősítsd meg

Az üres mezők automatikusan kitöltődnek a másik profilból. Az adományok, esemény RSVP-k és csoporttagságok átkerülnek a megtartott profilra. A duplikátum soft-delete-elve lesz (visszaállítható).

---

## Aktivitás napló

Minden kapcsolat részletoldalán elérhető az **Aktivitás napló** szekció.

Rögzíthető interakció típusok: Telefonhívás, Email, Megbeszélés, Feljegyzés, Feladat, SMS, Egyéb.

Minden bejegyzésnél megadható: típus, rövid megjegyzés, időpont (alapértelmezés: most). A bejegyzések vertikális idővonalként jelennek meg típusonként eltérő színnel és ikonnal.

---

## Lead scoring

Minden kapcsolat részletoldalán a bal oszlopban megjelenik a **Kapcsolatfelvétel / Értékelés** kártya.

### Értékesítési fázisok

| Fázis | Leírás |
|---|---|
| Új érdeklődő | Frissen bekerült, még nem szólítottuk meg |
| Kapcsolatba lépve | Megkerestük / válaszolt |
| Minősített | Potenciális tag / támogató |
| Ajánlat küldve | Küldtünk ajánlatot vagy meghívót |
| Megnyert | Csatlakozott / adományozott / önkéntes lett |
| Elveszett | Nem érdekelt / lemondta |

### Pontszám (1–5 csillag)

Kattints a csillagokra a pontszám beállításához (ugyanarra kattintva töröl). A kapcsolatok listán a **Fázis** és **Min. pontszám** szűrőkkel gyorsan megtalálhatod a legforróbb érdeklődőket.
MD,
                'content_en' => <<<'MD'
![Screenshot](/img/sugo/kapcsolatok.png)

## Contacts

The Contacts module is used for the complete management of people and organisations.

**Add a new contact** – Click the "New contact" button. In the pop-up you can enter the name, email, phone, city, status, source, and notes. A profile photo can also be uploaded.

**Edit** – Click any row in the table; the editor window opens immediately with the current data.

**Statuses:**
- **Member** – active organisational member
- **Supporter** – sympathiser, but not a member
- **Donor** – financially supporting person
- **VIP** – highlighted contact
- **Inactive** – currently not active

**Newsletter** – The subscription checkbox shows who receives email communication.

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

Click the **Filter ▾** button to open the filter panel.

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
4. Reload any saved filter from the **Saved filters** dropdown

> Saved filters are per-user — only you can see your own saved filters.

---

## Duplicate Detection and Merge

Click the **Duplicates** button to navigate to `/admin/people/duplicates`.

The system identifies probable duplicates using three matching criteria:
- **Email match** – identical email address
- **Phone match** – identical phone number
- **Name match** – identical full name (case-insensitive)

### Merge Steps

1. Click the **Merge** button on the pair card
2. Choose **which one to keep** (left or right)
3. Confirm the action

Empty fields are auto-filled from the other profile. Donations, event RSVPs, and group memberships are transferred to the kept profile. The duplicate is soft-deleted (can be restored).

---

## Activity Log

The **Activity log** section is available on every contact's detail page.

Recordable interaction types: Phone call, Email, Meeting, Note, Task, SMS, Other.

For each entry: type, short notes, timestamp (defaults to now). Entries appear as a colour-coded vertical timeline.

---

## Lead Scoring

The **Contact intake / Evaluation** card appears in the left column on every contact's detail page.

### Pipeline Stages

| Stage | Description |
|---|---|
| New Lead | Just added, not yet reached out to |
| Contacted | We reached out / they responded |
| Qualified | Potential member / supporter identified |
| Proposal Sent | Sent a proposal or invitation |
| Converted | Joined / donated / became a volunteer |
| Lost | Not interested / declined |

### Score (1–5 stars)

Click the stars to set the score (clicking the same star again clears it). Use the **Stage** and **Min. score** filters on the contacts list to quickly find the hottest leads.
MD,
                'updated_at' => now(),
            ]);

        DB::table('help_articles')->where('menu_key', 'kapcsolatok-halado')->delete();

        $this->command->info('  ✓ kapcsolatok — kibővítve a haladó tartalommal');
        $this->command->info('  ✗ kapcsolatok-halado — törölve');
    }
}
