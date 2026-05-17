<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Comprehensive help article update:
 *  - Creates 3 new articles: feladatok, drip-kampanyok, audit-naplo
 *  - Updates 4 existing articles with complete, accurate content:
 *    projektek, email-kampanyok, felhasznalok, beallitasok
 */
class HelpArticleCompleteSeeder extends Seeder
{
    public function run(): void
    {
        // ── NEW ARTICLES ─────────────────────────────────────────────────────────

        $this->insertIfMissing('feladatok', [
            'title'      => 'Feladatok',
            'title_en'   => 'Tasks',
            'sort_order' => 85,
            'content'    => <<<'MD'
## Feladatok

A Feladatok modul a szervezet teendőinek kezelésére szolgál. Minden feladat projekthez rendelhető, felelős személyt és határidőt kaphat.

---

### Feladat létrehozása

Kattints az **+ Új feladat** gombra. Megadható:

- **Cím** – rövid, egyértelmű megnevezés
- **Leírás** – részletes útmutató vagy háttér-információ
- **Státusz** – Nyitott / Folyamatban / Kész
- **Prioritás** – Alacsony / Közepes / Magas / Sürgős
- **Felelős** – melyik felhasználóhoz tartozik a feladat
- **Projekt** – melyik projekthez kapcsolódik (opcionális)
- **Határidő** – a tervezett teljesítési dátum

### Feladatok listája

A listát szűrheted:

| Szűrő | Leírás |
|---|---|
| Státusz | Nyitott / Folyamatban / Kész |
| Prioritás | Alacsony – Sürgős |
| Felelős | Melyik felhasználóhoz tartozik |
| Projekt | Melyik projekthez kapcsolódik |

A fejlécben látható a nyitott és folyamatban lévő feladatok száma.

### Feladat részletoldala

A feladat sorára kattintva megnyílik a részletoldal:

**Státusz gyorsváltás** – Közvetlenül a részletoldalon átállítható Nyitott → Folyamatban → Kész anélkül, hogy megnyitnád a szerkesztőt.

**Megjegyzések** – Hozzáfűzhetsz szöveges megjegyzéseket a feladathoz. Minden megjegyzésnél látható a szerző neve és időpont.

**Mellékletek** – Fájlokat tölthetsz fel a feladathoz (dokumentumok, képek). A feltöltött fájlok letölthetők, és szükség esetén törölhetők.

### Prioritások

| Prioritás | Leírás |
|---|---|
| Alacsony | Nem sürgős, ráér |
| Közepes | Normál ütemű elvégzés |
| Magas | Előnyt élvez más feladatokkal szemben |
| Sürgős | Azonnal kezelendő |

A feladatlista alapértelmezés szerint prioritás és határidő szerint rendez (Sürgős legelöl).
MD,
            'content_en' => <<<'MD'
## Tasks

The Tasks module is used for managing your organisation's to-do items. Each task can be assigned to a project, a responsible person, and given a deadline.

---

### Creating a Task

Click **+ New task**. You can fill in:

- **Title** – short, clear name
- **Description** – detailed instructions or background information
- **Status** – Open / In Progress / Done
- **Priority** – Low / Medium / High / Urgent
- **Assigned to** – which user is responsible
- **Project** – which project it belongs to (optional)
- **Deadline** – the planned completion date

### Task List

You can filter the list by:

| Filter | Description |
|---|---|
| Status | Open / In Progress / Done |
| Priority | Low – Urgent |
| Assigned to | Which user it belongs to |
| Project | Which project it is linked to |

The header shows the count of open and in-progress tasks.

### Task Detail Page

Click any task row to open the detail page:

**Quick status change** – Switch directly between Open → In Progress → Done without opening the editor.

**Comments** – Add text comments to the task. Each comment shows the author name and timestamp.

**Attachments** – Upload files to the task (documents, images). Uploaded files can be downloaded and deleted if needed.

### Priorities

| Priority | Description |
|---|---|
| Low | Not urgent, can wait |
| Medium | Normal pace completion |
| High | Takes precedence over other tasks |
| Urgent | Must be handled immediately |

The task list is sorted by priority and deadline by default (Urgent first).
MD,
        ]);

        $this->insertIfMissing('drip-kampanyok', [
            'title'      => 'Drip kampányok',
            'title_en'   => 'Drip Campaigns',
            'sort_order' => 86,
            'content'    => <<<'MD'
## Drip kampányok

A Drip kampány automatikus email sorozatot küld a kiválasztott kapcsolatoknak, előre beállított időközönként – emberi beavatkozás nélkül.

**Példa:** Valaki feliratkozik egy csoportba → kap egy üdvözlő emailt azonnal, majd 3 nap múlva egy másikat, majd 7 nap múlva egy harmadikat.

---

### Kampány létrehozása

Kattints az **+ Új kampány** gombra. Megadható:

- **Neve** – belső azonosítóként szolgál
- **Leírás** – opcionális megjegyzés
- **Trigger típusa** (mi indítja el a sorozatot):

| Trigger | Leírás |
|---|---|
| Manuális | Te döntöd el, kit iratsz be |
| Csoport csatlakozás | Ha valaki bekerül egy adott csoportba |
| Cimke hozzáadása | Ha egy adott tag kerül egy kapcsolatra |

### Lépések hozzáadása (Steps)

Minden lépés = egy elküldendő email. A kampány részletoldalán add hozzá a lépéseket:

- **Email tárgy**
- **Feladó neve / email** (opcionális – ha üresen hagyod, az alapértelmezett feladót használja)
- **Tartalom** – Markdown formázás támogatott
- **Késleltetés (napokban)** – hány nappal az előző lépés után küldődjön el (0 = azonnal)

A lépések sorrendben kerülnek elküldésre.

### Kampány aktiválása

Lépések hozzáadása után kattints az **Aktiválás** gombra. Aktív kampányt szüneteltetni is lehet.

> Lépések nélkül a kampány nem aktiválható.

### Beiratkozás (Enrollment)

A kampány részletoldalán az **Emberek beiratkoztatása** gombbal adhatsz hozzá kapcsolatokat:

| Szegmens | Leírás |
|---|---|
| Összes feliratkozott | Mindenki, akinek aktív hírlevél feliratkozása van |
| Csoport | Egy adott csoport tagjai |
| Cimke | Egy adott cimkével rendelkező kapcsolatok |
| Státusz | Státusz szerint (pl. Tag, Támogató) |
| Egyéni személy | Egyetlen konkrét kapcsolat |

Már beiratkozott személyek nem kerülnek be újra (duplikátum védelem).

### Beiratkozások állapotai

| Állapot | Leírás |
|---|---|
| Aktív | Sorozat folyamatban, következő email esedékes |
| Befejezett | Az összes lépés elküldve |
| Lemondott | Kézzel lemondott beiratkozás |

A beiratkozást bármikor le lehet mondani az **×** gombbal – a leiratkozott személy nem kap több emailt.

### Automatikus feldolgozás

A háttérben naponta egyszer lefut a rendszer, amely:
1. Automatikusan beiratkoztatja azokat, akik megfelelnek a trigger feltételnek
2. Elküldi az esedékes emaileket (ahol a várakozási idő eltelt)

### Mire jó a drip?

- Új tag üdvözlő sorozat
- Adományozás után köszönő + follow-up
- Esemény előtti emlékeztető sorozat
- Inaktív kapcsolatok reaktiválása
MD,
            'content_en' => <<<'MD'
## Drip Campaigns

A drip campaign automatically sends a series of emails to selected contacts at preset intervals — without any manual intervention.

**Example:** Someone joins a group → receives a welcome email immediately, another 3 days later, and a third one 7 days after that.

---

### Creating a Campaign

Click **+ New campaign**. You can fill in:

- **Name** – used as an internal identifier
- **Description** – optional note
- **Trigger type** (what starts the sequence):

| Trigger | Description |
|---|---|
| Manual | You decide who to enrol |
| Group join | When someone is added to a specific group |
| Tag added | When a specific tag is added to a contact |

### Adding Steps

Each step = one email to be sent. Add steps on the campaign detail page:

- **Email subject**
- **Sender name / email** (optional – if empty, the default sender is used)
- **Content** – Markdown formatting supported
- **Delay (days)** – how many days after the previous step to send (0 = immediately)

Steps are sent in order.

### Activating a Campaign

Once steps are added, click **Activate**. Active campaigns can be paused.

> A campaign cannot be activated without steps.

### Enrollment

On the campaign detail page, use the **Enrol people** button to add contacts:

| Segment | Description |
|---|---|
| All subscribers | Everyone with an active newsletter subscription |
| Group | Members of a specific group |
| Tag | Contacts with a specific tag |
| Status | By status (e.g. Member, Supporter) |
| Individual | A single specific contact |

Already enrolled contacts are not added again (duplicate protection).

### Enrollment Statuses

| Status | Description |
|---|---|
| Active | Sequence in progress, next email pending |
| Completed | All steps sent |
| Cancelled | Manually cancelled enrolment |

Enrolments can be cancelled at any time with the **×** button — the cancelled contact will receive no further emails.

### Automatic Processing

The system runs once daily in the background to:
1. Automatically enrol contacts that match the trigger condition
2. Send due emails (where the waiting period has elapsed)

### Use Cases

- New member welcome sequence
- Thank you + follow-up after a donation
- Pre-event reminder series
- Re-engagement of inactive contacts
MD,
        ]);

        $this->insertIfMissing('audit-naplo', [
            'title'      => 'Audit napló',
            'title_en'   => 'Audit Log',
            'sort_order' => 87,
            'content'    => <<<'MD'
## Audit napló

Az Audit napló rögzíti az adminisztrációs rendszerben végzett összes fontos műveletet. Látható, hogy ki, mikor és mit módosított.

> **Hozzáférés:** Csak admin és super-admin szerepkörű felhasználók láthatják.

---

### Mit rögzít a rendszer?

Minden létrehozás, módosítás és törlés automatikusan naplózódik az alábbi adatokkal:

| Mező | Leírás |
|---|---|
| Felhasználó | Melyik admin végezte a műveletet |
| Művelettípus | Létrehozás / Módosítás / Törlés |
| Érintett rekord | Milyen típusú adat változott (pl. Person, Event, Donation) |
| Dátum / idő | Mikor történt a művelet |

### Szűrés

A naplóban szűrhetsz:

- **Művelettípus** szerint (Létrehozás, Módosítás, Törlés)
- **Rekord típusa** szerint (Kapcsolat, Esemény, Adomány, stb.)
- **Felhasználó neve** szerint (részleges egyezés)
- **Dátumtartomány** szerint (tól / ig)

### Mire jó?

- Ellenőrizheted, hogy ki törölte véletlenül a kapcsolatot
- Nyomon követheted az adatmódosítások történetét
- Visszakeresheted, mikor lett egy esemény létrehozva
- Biztonsági felügyelet: gyanús vagy véletlen változtatások azonosítása
MD,
            'content_en' => <<<'MD'
## Audit Log

The Audit Log records all significant actions performed in the administration system. You can see who did what and when.

> **Access:** Only users with admin or super-admin roles can view this page.

---

### What does the system record?

Every create, update, and delete action is automatically logged with the following data:

| Field | Description |
|---|---|
| User | Which admin performed the action |
| Action type | Created / Updated / Deleted |
| Affected record | What type of data changed (e.g. Person, Event, Donation) |
| Date / time | When the action occurred |

### Filtering

You can filter the log by:

- **Action type** (Created, Updated, Deleted)
- **Record type** (Contact, Event, Donation, etc.)
- **User name** (partial match)
- **Date range** (from / to)

### What is it for?

- Check who accidentally deleted a contact
- Track the history of data changes
- Find out when an event was created
- Security oversight: identify suspicious or unintended changes
MD,
        ]);

        // ── UPDATED ARTICLES ─────────────────────────────────────────────────────

        $this->updateArticle('projektek', [
            'content' => <<<'MD'
![Screenshot](/img/sugo/projektek.png)

## Projektek

A Projektek modul a szervezet belső projektjeinek és feladatainak kezelésére szolgál. Minden projekthez felelős személy, határidő, prioritás és tagok rendelhetők.

---

### Projekt létrehozása

Kattints az **+ Új projekt** gombra. Megadható:

- **Cím** – a projekt megnevezése
- **Leírás** – részletes háttér-információ
- **Státusz** – Tervezés / Aktív / Szüneteltetett / Lezárt
- **Prioritás** – Alacsony / Közepes / Magas
- **Felelős** – melyik felhasználó vezeti a projektet
- **Kezdési dátum** és **Befejezési dátum**

### Projekt részletoldala

A projektre kattintva megnyílik a részletoldal, ahol:

**Tagok kezelése** – Felhasználókat adhatsz hozzá a projekthez „tag" szerepkörrel. A tagok eltávolíthatók az × gombbal.

**Feladatok** – A projekt összes feladata listázva jelenik meg prioritás és státusz szerint. Új feladatot közvetlenül itt is létrehozhatsz a projekthez rendelve.

**Feladat státuszok gyors áttekintése** – A fejlécben látható az összes / nyitott / folyamatban / kész feladatok száma.

### Státuszok

| Státusz | Leírás |
|---|---|
| Tervezés | Előkészítési fázisban |
| Aktív | Folyamatban van |
| Szüneteltetett | Átmenetileg leállítva |
| Lezárt | Projekt befejeződött |

### Projekt törlése

Projekt törlésekor a hozzá tartozó feladatok nem törlődnek — csupán leválnak a projektről és „projekt nélküli" feladatként megmaradnak.
MD,
            'content_en' => <<<'MD'
![Screenshot](/img/sugo/projektek.png)

## Projects

The Projects module is used to manage your organisation's internal projects and tasks. Each project can have a responsible person, deadline, priority, and members.

---

### Creating a Project

Click **+ New project**. You can fill in:

- **Title** – the project name
- **Description** – detailed background information
- **Status** – Planning / Active / On Hold / Closed
- **Priority** – Low / Medium / High
- **Responsible** – which user leads the project
- **Start date** and **End date**

### Project Detail Page

Click a project to open the detail page, where you can:

**Manage members** – Add users to the project as "members". Members can be removed with the × button.

**Tasks** – All tasks belonging to the project are listed by priority and status. New tasks can be created directly here, already linked to the project.

**Task status overview** – The header shows the count of total / open / in-progress / done tasks.

### Statuses

| Status | Description |
|---|---|
| Planning | In the preparation phase |
| Active | Currently in progress |
| On Hold | Temporarily paused |
| Closed | Project has been completed |

### Deleting a Project

When a project is deleted, its tasks are **not** deleted — they are simply detached from the project and remain as unassigned tasks.
MD,
        ]);

        $this->updateArticle('email-kampanyok', [
            'content' => <<<'MD'
![Screenshot](/img/sugo/kampanyok.png)

## Email kampányok

Az **Email kampányok** modul lehetővé teszi, hogy hírleveleket és értesítőket küldj a kapcsolataidnak. Szegmentálhatsz csoport, cimke, státusz vagy feliratkozás alapján.

---

### Kampány létrehozása

1. Kattints az **+ Új kampány** gombra
2. Töltsd ki a mezőket:
   - **Kampány neve** – belső azonosítóként szolgál
   - **Email tárgy** – a fogadók postaládájában megjelenő tárgy
   - **Feladó neve / email** – ha üresen hagyod, az alapértelmezett értéket használja
   - **Tartalom** – Markdown formázás támogatott
3. **Célközönség beállítása** (szegmentálás):

| Szegmens | Leírás |
|---|---|
| Összes feliratkozott | Minden `is_subscribed = true` kapcsolat |
| Csoport | Egy adott csoport tagjai |
| Cimke | Egy adott cimkével rendelkező kapcsolatok |
| Státusz | Státusz szerint (pl. Tag, Támogató) |

A **„Várható fogadók"** gomb megmutatja, hány személy kapná meg az emailt a jelenlegi szegmens beállítással.

4. Mentsd el → a kampány **Piszkozat** állapotba kerül

### Kampány küldése

- A listában kattints a **✉ Küldés** gombra
- Megerősítés után a rendszer elküldi az emailt a szegmens alapján szűrt kapcsolatoknak
- Küldés után a kampány **Elküldve** állapotba kerül; megjelenik a sikeres / sikertelen küldések száma

> Elküldött kampány nem szerkeszthető és nem küldhető el újra.

### Email nyomon követés

Az elküldött emailekben automatikusan elhelyezésre kerül:
- **Megnyitás követés** – 1×1 pixeles transzparens kép, amely rögzíti a megnyitást
- **Kattintás követés** – a linkek átirányítón mennek át, így rögzítve a kattintást

A kampány listában látható az összes megnyitás és kattintás száma.

### Email sablonok

Az **Email sablonok** almenüben (Kampányok menü alatt) menthetsz és kezelhetsz újrahasználható email tartalmakat:

- **Sablon mentése** – adj nevet és tartalmat a sablonnak
- **Sablon betöltése** – új kampány szerkesztésekor kiválasztható egy sablon; a tartalom automatikusan betöltődik
- **Szerkesztés / Törlés** – a sablonok bármikor módosíthatók vagy törölhetők

### Állapotok

| Állapot | Leírás |
|---|---|
| Piszkozat | Szerkeszthető, még nem lett elküldve |
| Küldés alatt | Küldés folyamatban |
| Elküldve | Sikeresen elküldve |
| Sikertelen | Minden küldési kísérlet meghiúsult |

### Resend integráció

Az emailek küldéséhez a **Resend** transactional email szolgáltatás szükséges. Állítsd be a Beállítások → Email beállítások menüpontban.
MD,
            'content_en' => <<<'MD'
![Screenshot](/img/sugo/kampanyok.png)

## Email Campaigns

The **Email Campaigns** module lets you send newsletters and notifications to your contacts. You can segment recipients by group, tag, status, or newsletter subscription.

---

### Creating a Campaign

1. Click **+ New campaign**
2. Fill in the fields:
   - **Campaign name** – used as an internal identifier
   - **Email subject** – the subject line recipients will see
   - **Sender name / email** – if left empty, the system default is used
   - **Content** – Markdown formatting supported
3. **Set the audience** (segmentation):

| Segment | Description |
|---|---|
| All subscribers | Every contact with `is_subscribed = true` |
| Group | Members of a specific group |
| Tag | Contacts with a specific tag |
| Status | By status (e.g. Member, Supporter) |

The **"Expected recipients"** button shows how many people would receive the email with the current segment settings.

4. Save → the campaign enters **Draft** status

### Sending a Campaign

- Click the **✉ Send** button in the campaign list
- After confirmation, the system sends the email to contacts filtered by the segment
- After sending, the campaign status changes to **Sent**; the sent / failed counts are displayed

> A sent campaign cannot be edited or resent.

### Email Tracking

Sent emails automatically include:
- **Open tracking** – a 1×1 transparent pixel that records when the email is opened
- **Click tracking** – links pass through a redirect that records the click

The total open and click counts are visible in the campaign list.

### Email Templates

In the **Email Templates** submenu (under Campaigns), you can save and manage reusable email content:

- **Save a template** – give it a name and add content
- **Load a template** – when editing a new campaign, select a template; the content is loaded automatically
- **Edit / Delete** – templates can be modified or deleted at any time

### Statuses

| Status | Description |
|---|---|
| Draft | Editable, not yet sent |
| Sending | Send in progress |
| Sent | Successfully dispatched |
| Failed | All send attempts failed |

### Resend Integration

Sending emails requires the **Resend** transactional email service. Configure it under Settings → Email settings.
MD,
        ]);

        $this->updateArticle('felhasznalok', [
            'content' => <<<'MD'
![Screenshot](/img/sugo/felhasznalok.png)

## Felhasználók

A Felhasználók oldalon az adminisztrációs rendszer hozzáférései kezelhetők.

> **Hozzáférés:** Csak admin és super-admin szerepkörű felhasználók láthatják és kezelhetik.

---

### Új felhasználó meghívása

Kattints a **Meghívó küldése** gombra. Add meg az email-címet és a szerepkört. A rendszer küld egy meghívó emailt, amelyen keresztül az illető jelszót állít be és aktiválja a fiókját.

### Közvetlen felhasználó létrehozása

Kattints az **+ Új felhasználó** gombra. Kötelező adatok:
- Teljes név
- Email cím
- Jelszó
- Szerepkör

Profilkép is feltölthető.

### Szerepkörök

| Szerepkör | Admin panel | Felhasználók / Beállítások |
|---|---|---|
| super-admin | ✅ teljes hozzáférés | ✅ |
| admin | ✅ teljes hozzáférés | ✅ |
| editor | ✅ (korlátozott) | ❌ nem látja |
| member | ❌ nem léphet be | ❌ |

**Szerkesztő (editor)** – Hozzáfér a kapcsolatokhoz, eseményekhez, csoportokhoz, adományokhoz, projektekhez, feladatokhoz és kampányokhoz, de a Felhasználókat, Beállításokat és Audit naplót nem látja.

### Felhasználó szerkesztése

Kattints a felhasználó sorára. A jelszó mezőt üresen hagyva a régi jelszó megmarad.

### Felhasználó törlése

A bejelentkezett felhasználó saját fiókját nem lehet törölni.

### Meghívók

A meghívó linkek egyszeri használatúak. Ha valaki nem élt a meghívóval, **újraküldés** gombbal új linket generálhatsz, vagy **törölheted** a meghívót.
MD,
            'content_en' => <<<'MD'
![Screenshot](/img/sugo/felhasznalok.png)

## Users

The Users page manages access accounts for the administration system.

> **Access:** Only users with admin or super-admin roles can view and manage this page.

---

### Inviting a New User

Click the **Send invitation** button. Enter the email address and role. The system sends an invitation email through which the recipient sets a password and activates their account.

### Creating a User Directly

Click **+ New user**. Required fields:
- Full name
- Email address
- Password
- Role

A profile photo can also be uploaded.

### Roles

| Role | Admin panel | Users / Settings |
|---|---|---|
| super-admin | ✅ full access | ✅ |
| admin | ✅ full access | ✅ |
| editor | ✅ (limited) | ❌ cannot see |
| member | ❌ cannot log in | ❌ |

**Editor** – Has access to contacts, events, groups, donations, projects, tasks, and campaigns, but cannot see Users, Settings, or the Audit Log.

### Editing a User

Click the user row. Leaving the password field empty keeps the existing password.

### Deleting a User

A logged-in user cannot delete their own account.

### Invitations

Invitation links are single-use. If someone has not used their invitation, you can **resend** it to generate a new link, or **delete** the invitation.
MD,
        ]);

        $this->updateArticle('beallitasok', [
            'content' => <<<'MD'
![Screenshot](/img/sugo/beallitasok.png)

## Beállítások

A Beállítások oldalon a rendszer alap konfigurációja módosítható.

> **Hozzáférés:** Csak admin és super-admin szerepkörű felhasználók láthatják.

---

### Általános beállítások

- **Rendszer neve** – a böngésző fülön és az admin felületen megjelenő szervezeti név
- **Alkalmazás URL** – a szerver `.env` fájlban konfigurált alap URL
- **Alapértelmezett nyelv** – az 5 elérhető nyelv közül választható (Magyar, English, Deutsch, Română, Slovenčina). Ez az az nyelv, amelyen az adminisztrációs felület megjelenik az első belépéskor.

### Márkabeállítások (Branding)

- **Szervezet neve** – megjelenik az oldalsávban és az emailekben
- **Elsődleges szín** – a rendszer fő kiemelő színe (pl. oldalsáv háttere)
- **Logó feltöltése** – saját szervezeti logó az oldalsávhoz

### Email beállítások

- **Feladó neve** – kimenő emaileknél ez jelenik meg feladóként
- **Feladó email** – a válasz erre az email-re érkezik

Az emailek küldéséhez **Resend** transactional email fiók szükséges. Az API kulcs és a mailer típus a szerver `.env` fájlban állítható be.

### Heti riport beállítások

A rendszer képes heti összefoglaló emailt küldeni az adminisztrátoroknak. Beállítható:
- Heti riport engedélyezése / letiltása
- A riport fogadójának email-címe
- Küldés napja és időpontja

A **Teszt riport küldése** gombbal azonnal ellenőrizheted, hogy a riport email megérkezik-e.

### Adományozási oldal beállításai

A nyilvános `/donate` adományozási oldal testreszabható:
- Szervezet neve és logója az oldalon
- Befogadható fizetési módok (Stripe / Barion)

### Fizetési beállítások

Stripe és Barion integrációhoz szükséges API kulcsok itt adhatók meg (vagy a szerver `.env` fájlban).

### Rendszerinformáció

Az oldal alján látható a PHP verzió, a Laravel verzió és a jelenlegi környezet (pl. production).
MD,
            'content_en' => <<<'MD'
![Screenshot](/img/sugo/beallitasok.png)

## Settings

The Settings page allows you to modify the basic configuration of the system.

> **Access:** Only users with admin or super-admin roles can view this page.

---

### General Settings

- **System name** – the organisational name displayed on the browser tab and in the admin panel
- **Application URL** – the base URL configured in the server's `.env` file
- **Default language** – choose from 5 available languages (Magyar, English, Deutsch, Română, Slovenčina). This is the language in which the admin interface appears on first login.

### Branding Settings

- **Organisation name** – displayed in the sidebar and in emails
- **Primary colour** – the main accent colour of the system (e.g. sidebar background)
- **Upload logo** – your own organisation logo for the sidebar

### Email Settings

- **Sender name** – this appears as the sender on outgoing emails
- **Sender email** – replies are delivered to this email address

Sending emails requires a **Resend** transactional email account. The API key and mailer type are configured in the server's `.env` file.

### Weekly Report Settings

The system can send a weekly summary email to administrators. Configurable:
- Enable / disable the weekly report
- Recipient email address
- Day and time of sending

Use the **Send test report** button to immediately verify that the report email arrives.

### Donation Page Settings

The public `/donate` donation page can be customised:
- Organisation name and logo on the page
- Accepted payment methods (Stripe / Barion)

### Payment Settings

API keys for Stripe and Barion integration can be entered here (or in the server's `.env` file).

### System Information

The bottom of the page shows the PHP version, Laravel version, and current environment (e.g. production).
MD,
        ]);

        $this->command->info('Kész! Új cikkek: feladatok, drip-kampanyok, audit-naplo. Frissítve: projektek, email-kampanyok, felhasznalok, beallitasok.');
    }

    private function insertIfMissing(string $menuKey, array $data): void
    {
        if (DB::table('help_articles')->where('menu_key', $menuKey)->exists()) {
            $this->command->warn("  ~ {$menuKey} — már létezik, kihagyva");
            return;
        }

        DB::table('help_articles')->insert(array_merge(['menu_key' => $menuKey], $data, [
            'created_at' => now(),
            'updated_at' => now(),
        ]));
        $this->command->info("  + {$menuKey} — létrehozva");
    }

    private function updateArticle(string $menuKey, array $data): void
    {
        $updated = DB::table('help_articles')
            ->where('menu_key', $menuKey)
            ->update(array_merge($data, ['updated_at' => now()]));

        if ($updated) {
            $this->command->info("  ✓ {$menuKey} — frissítve");
        } else {
            $this->command->warn("  ? {$menuKey} — nem található");
        }
    }
}
