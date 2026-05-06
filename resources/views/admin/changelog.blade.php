@extends('admin.layouts.app')

@section('title', __('changelog.title'))
@section('header', __('changelog.header'))
@section('breadcrumb')
    <span style="color:#dee2e6">/</span>
    <span style="color:#495057">{{ __('changelog.title') }}</span>
@endsection

@section('content')

@php
$locale = app()->getLocale();

$versions = [

    [
        'version' => 'v1.10.0',
        'latest'  => true,
        'badge'   => [
            'text'  => ['hu' => 'Aktuális, Legújabb', 'en' => 'Current, Latest'],
            'style' => 'background:rgba(10,179,156,0.1);color:#0ab39c;',
        ],
        'date' => ['hu' => '2026. május 6.', 'en' => 'May 6, 2026'],
        'items' => [
            ['hu' => '<strong>Többnyelvűség (HU/EN) — infrastruktúra:</strong> Bevezetve a <code>SetLocale</code> middleware (session-alapú locale beállítás), <code>LocaleController</code> és a <code>/language/{locale}</code> route. A felső navigációban megjelent a HU / EN nyelvváltó gomb, amely azonnal átkapcsolja az admin felület teljes szövegét.',
             'en' => '<strong>Multi-language support (HU/EN) — infrastructure:</strong> Introduced <code>SetLocale</code> middleware (session-based locale), <code>LocaleController</code> and the <code>/language/{locale}</code> route. A HU / EN language switcher button appeared in the top navigation, instantly switching all admin interface text.'],
            ['hu' => '<strong>Fordítási fájlok — teljes lefedés:</strong> Létrehozásra és feltöltésre kerültek a <code>lang/hu/</code> és <code>lang/en/</code> PHP nyelvi fájlok minden modulhoz: <code>common</code>, <code>people</code>, <code>events</code>, <code>groups</code>, <code>donations</code>, <code>projects</code>, <code>tasks</code>, <code>users</code>, <code>settings</code>, <code>links</code>, <code>cal</code> (naptár hónap- és napnevek), <code>changelog</code>.',
             'en' => '<strong>Translation files — full coverage:</strong> <code>lang/hu/</code> and <code>lang/en/</code> PHP language files created and populated for every module: <code>common</code>, <code>people</code>, <code>events</code>, <code>groups</code>, <code>donations</code>, <code>projects</code>, <code>tasks</code>, <code>users</code>, <code>settings</code>, <code>links</code>, <code>cal</code> (calendar month and day names), <code>changelog</code>.'],
            ['hu' => '<strong>Admin listaoldalak fordítása:</strong> Minden admin <em>index</em> nézet átírva <code>__()</code> helperekkel — Kapcsolatok, Események, Csoportok, Adományok, Projektek, Feladatok, Felhasználók, Beállítások. A státusz/típus/prioritás badge-ek és a dropdown opciók mostantól a kiválasztott nyelvnek megfelelően jelennek meg.',
             'en' => '<strong>Admin list pages translated:</strong> All admin <em>index</em> views rewritten with <code>__()</code> helpers — Contacts, Events, Groups, Donations, Projects, Tasks, Users, Settings. Status/type/priority badges and dropdown options now display according to the selected language.'],
            ['hu' => '<strong>Admin részletoldalak fordítása:</strong> A Projekt, Esemény, Adomány, Kapcsolat és Csoport részletoldalak (<em>show</em> nézetek) teljes szövege lefordítva. A dinamikus PHP értéktérképek (státusz, prioritás, típus, szerepkör) szintén <code>__()</code> hívásokat használnak.',
             'en' => '<strong>Admin detail pages translated:</strong> Full translation of the Project, Event, Donation, Contact and Group detail (<em>show</em>) views. Dynamic PHP value maps (status, priority, type, role) also use <code>__()</code> calls.'],
            ['hu' => '<strong>Admin űrlapok fordítása:</strong> Minden szerkesztő és létrehozó oldal (<em>form</em> nézetek) átírva — Projektek, Események (teljes oldal + modal partial), Kapcsolatok, Csoportok. A legördülő opciók értéktérképek alapján töltődnek be a megfelelő nyelven.',
             'en' => '<strong>Admin forms translated:</strong> All edit and create pages (<em>form</em> views) rewritten — Projects, Events (full page + modal partial), Contacts, Groups. Dropdown options populate from value maps in the correct language.'],
            ['hu' => '<strong>Naptár és Gantt JS-fordítás:</strong> A Projekt részletoldalon a Naptár és Gantt nézetekhez szükséges hónap/nap neveket PHP <code>__()</code> tömbök tárolják, amelyek <code>@json()</code> direktívával kerülnek a JavaScript kontextusba — így az oldal renderidejében a helyes lokalizált értékek jelennek meg.',
             'en' => '<strong>Calendar and Gantt JS translation:</strong> On the Project detail page, month/day names needed by the Calendar and Gantt views are stored in PHP <code>__()</code> arrays passed into JavaScript context via the <code>@json()</code> directive — rendering correctly localized values at page load time.'],
            ['hu' => '<strong>Nyilvános eseményoldalak fordítása:</strong> A bejelentkezés nélkül elérhető nyilvános regisztrációs oldal (<code>/e/{slug}</code>) és a visszaigazoló oldal is teljes HU/EN fordítást kapott. A <code>&lt;html lang&gt;</code> attribútum mostantól dinamikusan tükrözi az aktuális locale-t.',
             'en' => '<strong>Public event pages translated:</strong> The login-free public registration page (<code>/e/{slug}</code>) and the confirmation page received full HU/EN translation. The <code>&lt;html lang&gt;</code> attribute now dynamically reflects the current locale.'],
            ['hu' => '<strong>Verziókövetés oldal fordítása:</strong> A Changelog oldal data-driven szerkezetre váltott — a verziók bejegyzései PHP tömbökben tárolódnak <code>hu</code>/<code>en</code> kulcsokkal, a sablon locale alapján rendereli a megfelelő szöveget. Badge-ek és dátumok szintén kétnyelvűek.',
             'en' => '<strong>Changelog page translated:</strong> The Changelog page switched to a data-driven structure — version entries are stored in PHP arrays with <code>hu</code>/<code>en</code> keys, the template renders the correct text based on locale. Badges and dates are also bilingual.'],
            ['hu' => '<strong>Súgó szekció teljes kétnyelvűsítése:</strong> Létrehozásra kerültek a <code>lang/hu/help.php</code> és <code>lang/en/help.php</code> fordítási fájlok. Az admin <em>Súgó kezelése</em> oldal és a nyilvános <em>Súgó megtekintő</em> (<code>sugo.blade.php</code>) minden szövege <code>__()</code> helperekkel lett átírva. A <code>&lt;html lang&gt;</code> attribútum dinamikus, az oldal fejléce és gombok is az aktív locale-t tükrözik.',
             'en' => '<strong>Full bilingual support for Help section:</strong> <code>lang/hu/help.php</code> and <code>lang/en/help.php</code> translation files created. All text in the admin <em>Manage Help</em> page and the public <em>Help viewer</em> (<code>sugo.blade.php</code>) rewritten with <code>__()</code> helpers. The <code>&lt;html lang&gt;</code> attribute is now dynamic; the page header and buttons reflect the active locale.'],
            ['hu' => '<strong>Súgó cikkek kétnyelvű adatbázis-sémája:</strong> A <code>help_articles</code> tábla bővítésre került <code>title_en</code> és <code>content_en</code> (nullable) oszlopokkal. Három új súgó cikk jött létre teljes HU+EN tartalommal: <em>Projektek</em>, <em>Verziókövetés</em>, <em>Súgó kezelése</em>. A megjelenítő a locale alapján automatikusan vált a megfelelő nyelvre, hiányzó EN tartalom esetén a magyar verzióra esik vissza.',
             'en' => '<strong>Bilingual database schema for Help articles:</strong> The <code>help_articles</code> table was extended with nullable <code>title_en</code> and <code>content_en</code> columns. Three new help articles were created with full HU+EN content: <em>Projects</em>, <em>Changelog</em>, <em>Manage Help</em>. The viewer automatically switches to the correct language based on locale, falling back to Hungarian if EN content is missing.'],
            ['hu' => '<strong>Súgó admin szerkesztő — kétnyelvű tabos modal:</strong> A Súgó kezelése oldalon az edit modal HU és EN fülekkel bővült, így az adminisztrátor mindkét nyelv tartalmát (cím + szöveg) egymástól függetlenül szerkesztheti és mentheti egyetlen felületen.',
             'en' => '<strong>Help admin editor — bilingual tabbed modal:</strong> The edit modal on the Manage Help page gained HU and EN language tabs, allowing the administrator to edit and save both language versions (title + content) independently from a single interface.'],
            ['hu' => '<strong>Súgó cikkekhez képernyőképek:</strong> Minden súgó cikkhez (<em>Főoldal, Kapcsolatok, Események, Csoportok, Adományok, Felhasználók, Beállítások, Projektek, Verziókövetés, Súgó kezelése</em>) a leírás végére bekerült egy-egy jellemző képernyőkép (<code>/public/img/sugo/</code> mappa). A képek kattintásra teljes képernyős lightbox nézetben nyílnak meg.',
             'en' => '<strong>Screenshots added to Help articles:</strong> A representative screenshot was appended to every help article (<em>Dashboard, Contacts, Events, Groups, Donations, Users, Settings, Projects, Changelog, Manage Help</em>) from the <code>/public/img/sugo/</code> folder. Images open in a full-screen lightbox on click.'],
            ['hu' => '<strong>Súgó megtekintő görgethetőség javítása:</strong> A <code>sugo.blade.php</code> elrendezésében a <code>main</code> elem explicit <code>height: calc(100vh - 60px)</code> és <code>overflow-y: auto</code> stílust kapott, így hosszabb cikkeknél és beillesztett képeknél az oldal megfelelően görgethetővé vált.',
             'en' => '<strong>Help viewer scrolling fix:</strong> In the <code>sugo.blade.php</code> layout the <code>main</code> element received an explicit <code>height: calc(100vh - 60px)</code> and <code>overflow-y: auto</code> style, making the page properly scrollable for longer articles and embedded screenshots.'],
        ],
    ],

    [
        'version' => 'v1.9.0',
        'badge'   => [
            'text'  => ['hu' => 'Fejlesztés', 'en' => 'Improvement'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => '2026. május 6.', 'en' => 'May 6, 2026'],
        'items' => [
            ['hu' => '<strong>Open Core GitHub stratégia — repó szétválasztás:</strong> A projekt nyilvános (<code>nationforge-community</code>) és privát (<code>nationforge-pro</code>) repóra vált szét. A Community MIT licenc alatt elérhető, a Pro fejlesztések külön privát repóban folynak.',
             'en' => '<strong>Open Core GitHub strategy — repo split:</strong> The project was split into a public (<code>nationforge-community</code>) and a private (<code>nationforge-pro</code>) repo. The Community edition is available under MIT license; Pro developments continue in a separate private repo.'],
            ['hu' => '<strong>MIT LICENSE fájl hozzáadása:</strong> A Community kiadáshoz hivatalos <code>LICENSE</code> fájl került (MIT, Programozás Kft. 2026) — enélkül jogilag „minden jog fenntartva" lett volna érvényes.',
             'en' => '<strong>MIT LICENSE file added:</strong> An official <code>LICENSE</code> file (MIT, Programozás Kft. 2026) was added to the Community edition — without it, "all rights reserved" would have applied legally.'],
            ['hu' => '<strong>GitHub README — angol hero kép:</strong> A főoldalon megjelenő marketing kép angol szövegű verzióra cserélve (<em>Stronger communities. More action. Real change.</em>), a GitHub globális fejlesztői közönsége számára.',
             'en' => '<strong>GitHub README — English hero image:</strong> The marketing image on the main page replaced with an English-text version (<em>Stronger communities. More action. Real change.</em>) for GitHub\'s global developer audience.'],
            ['hu' => '<strong>README Pro-szekció linkelése:</strong> Az Open Core táblázatban a Pro oszlop és a call-to-action sor mostantól közvetlenül a <code>nationforge-pro</code> GitHub repóra hivatkozik.',
             'en' => '<strong>README Pro section linked:</strong> In the Open Core table, the Pro column and call-to-action row now link directly to the <code>nationforge-pro</code> GitHub repo.'],
            ['hu' => '<strong>Repó tisztítás — érzékeny fájlok eltávolítása:</strong> A publikus repóból eltávolításra kerültek a helyi fejlesztői eszközök: <code>.claude/</code> config, <code>gitupdate.bat</code>, <code>get_help.php</code>, <code>run_help_fix.php</code>, <code>help_dump.json</code>, <code>help_fix.json</code>. Mindegyik bekerült a <code>.gitignore</code>-ba.',
             'en' => '<strong>Repo cleanup — sensitive files removed:</strong> Local developer tools removed from the public repo: <code>.claude/</code> config, <code>gitupdate.bat</code>, <code>get_help.php</code>, <code>run_help_fix.php</code>, <code>help_dump.json</code>, <code>help_fix.json</code>. All added to <code>.gitignore</code>.'],
            ['hu' => '<strong>Pro repó automatikus Community-szinkron:</strong> A <code>nationforge-pro</code> repóhoz <code>gitupdate.bat</code> szkript készült, amely minden futtatáskor automatikusan behúzza a Community újításait (<code>git fetch community && git merge</code>), majd feltölti a Pro változásokat.',
             'en' => '<strong>Pro repo automatic Community sync:</strong> A <code>gitupdate.bat</code> script was created for the <code>nationforge-pro</code> repo that automatically pulls Community updates (<code>git fetch community && git merge</code>) on every run, then pushes Pro changes.'],
            ['hu' => '<strong>Többnyelvűség a Roadmap-ben:</strong> A tervezett fejlesztések közé bekerült a többnyelvű támogatás (angol / magyar) mint közelgő funkció.',
             'en' => '<strong>Multi-language support in Roadmap:</strong> Multi-language support (English / Hungarian) was added to the planned features as an upcoming item.'],
            ['hu' => '<strong>Nyilvános esemény-regisztráció (új funkció):</strong> Minden <em>published</em> státuszú eseményhez egyedi nyilvános regisztrációs oldal érhető el (<code>/e/{slug}</code>), bejelentkezés nélkül. A látogató megadja nevét, e-mail címét, telefonszámát, kísérők számát és megjegyzését. Kapacitáskorlát esetén vizuális töltöttségsáv jelenik meg, és ha az esemény betelt, a form helyett hibaüzenet látható. Sikeres regisztráció után visszaigazoló oldal fogadja a résztvevőt. Az admin Esemény részletoldalán megjelenik a regisztráltak listája (név, e-mail, telefon, kísérők, időpont), valamint egy „Publikus oldal" gomb.',
             'en' => '<strong>Public event registration (new feature):</strong> Every <em>published</em> event gets a unique public registration page (<code>/e/{slug}</code>), accessible without login. Visitors enter their name, email, phone, number of guests and a note. A visual capacity bar appears when a capacity limit is set; if the event is full, a notice replaces the form. A confirmation page greets the attendee after successful registration. The admin Event detail page displays the registrant list (name, email, phone, guests, time) and a "Public page" button.'],
        ],
    ],

    [
        'version' => 'v1.8.0',
        'date' => ['hu' => '2026. május 5.', 'en' => 'May 5, 2026'],
        'items' => [
            ['hu' => '<strong>Esemény 500-as hiba javítása (EventRsvp model):</strong> Az esemény részletoldal és a szerkesztés utáni átirányítás 500-as szerverhibával végződött, mert a <code>App\Models\EventRsvp</code> osztály hiányzott, noha az <code>event_rsvps</code> tábla az adatbázisban már létezett. A modell létrehozása megszüntette a hibát.',
             'en' => '<strong>Event 500 error fix (EventRsvp model):</strong> The event detail page and the redirect after editing ended with a 500 server error because the <code>App\Models\EventRsvp</code> class was missing, even though the <code>event_rsvps</code> table already existed in the database. Creating the model resolved the error.'],
            ['hu' => '<strong>Esemény létrehozás/módosítás 500-as hiba javítása (ticket_price):</strong> Production MySQL strict módban az üres jegyár mező <code>NULL</code> értékként jutott a <code>NOT NULL</code> oszlopba, ami szerverhibát okozott. A vezérlőben bevezetett <code>?? 0</code> visszavezető érték megoldja a problémát.',
             'en' => '<strong>Event create/update 500 error fix (ticket_price):</strong> In production MySQL strict mode, an empty ticket price field reached the <code>NOT NULL</code> column as <code>NULL</code>, causing a server error. A <code>?? 0</code> fallback introduced in the controller\'s <code>store()</code> and <code>update()</code> methods resolves the issue.'],
            ['hu' => '<strong>Közelgő események helyes számlálása:</strong> A főoldal „Közelgő esemény" számlálója korábban csak a <em>published</em> státuszú eseményeket vette figyelembe, holott az újonnan létrehozott események alapértelmezetten <em>draft</em> státusszal jönnek létre. Mostantól a <em>cancelled</em> és <em>completed</em> kivételével minden jövőbeli esemény beleszámít.',
             'en' => '<strong>Correct counting of upcoming events:</strong> The homepage "Upcoming events" counter previously only counted <em>published</em> events, while newly created events default to <em>draft</em>. Now all future events except <em>cancelled</em> and <em>completed</em> are counted.'],
            ['hu' => '<strong>Főoldal görgetés javítása:</strong> A layout főoszlopa explicit <code>height: calc(100vh - 38px)</code> magasságot kapott, a <code>&lt;main&gt;</code> elem pedig <code>flex:1; min-height:0</code> kombinációval tölti ki a maradék területet.',
             'en' => '<strong>Homepage scroll fix:</strong> The layout\'s main column received an explicit <code>height: calc(100vh - 38px)</code>, and the <code>&lt;main&gt;</code> element fills the remaining area with <code>flex:1; min-height:0</code> — so longer content scrolls correctly.'],
            ['hu' => '<strong>Panel padding egységesítés:</strong> Az Esemény részletoldal Részletek panelén és a főoldal Közelgő események listáján a Tailwind <code>px-5</code> osztályok helyett garantáltan érvényesülő inline <code>padding: 20px</code> stílusok kerültek be.',
             'en' => '<strong>Panel padding standardization:</strong> On the Event detail page\'s Details panel and the homepage Upcoming events list, Tailwind <code>px-5</code> classes were replaced with guaranteed inline <code>padding: 20px</code> styles.'],
            ['hu' => '<strong>Linkgyűjtemény modul (új oldal):</strong> Új <code>/admin/links</code> oldal, amely a mentett hivatkozásokat kategóriánként csoportosítva, kártyás elrendezésben jeleníti meg. Minden kártya tartalmaz színes ikont, leírást és domain-chip feliratot; kattintásra új lapon nyílik meg.',
             'en' => '<strong>Link collection module (new page):</strong> New <code>/admin/links</code> page displaying saved links grouped by category in a card layout. Each card contains a colored icon, description and domain chip label; clicking opens in a new tab.'],
            ['hu' => '<strong>Linkgyűjtemény konfigurálása a Beállításokban:</strong> A Beállítások oldal alján új szekció teszi lehetővé a linkek kezelését (hozzáadás, szerkesztés, törlés) — modal alapú felülettel, cím, URL, kategória, szín, leírás, sorrend és aktív/inaktív mezőkkel.',
             'en' => '<strong>Link collection configuration in Settings:</strong> A new section at the bottom of the Settings page enables link management (add, edit, delete) — with a modal-based interface for title, URL, category, color, description, order and active/inactive fields.'],
            ['hu' => '<strong>Gyorslinkek sáv — valódi URL-ek:</strong> A felső kék sávban lévő gyorslinkek megkapták a tényleges hivatkozásaikat: <em>YouTube</em>, <em>Google Drive</em>, <em>Instagram</em>, <em>Hírek</em>, <em>Infografikonok</em>. Minden link új lapon nyílik meg. A „Linkgyűjtemény" gomb az új <code>/admin/links</code> oldalra navigál.',
             'en' => '<strong>Quick links bar — real URLs:</strong> The quick links in the top blue bar received their actual links: <em>YouTube</em>, <em>Google Drive</em>, <em>Instagram</em>, <em>News</em>, <em>Infographics</em>. All links open in a new tab. The "Link Collection" button navigates to the new <code>/admin/links</code> page.'],
            ['hu' => '<strong>Beállítások oldal teljes szélességű elrendezése:</strong> A korábban középre igazított, korlátozott szélességű Beállítások felület mostantól a teljes rendelkezésre álló területet kitölti. Az Általános és Email szekciók kétoszlopos rácsban helyezkednek el egymás mellett.',
             'en' => '<strong>Settings page full-width layout:</strong> The previously centered, limited-width Settings interface now fills all available space. The General and Email sections are arranged side by side in a two-column grid, with info cards (PHP, Laravel, Environment) below.'],
        ],
    ],

    [
        'version' => 'v1.7.0',
        'date' => ['hu' => '2026. május 3.', 'en' => 'May 3, 2026'],
        'items' => [
            ['hu' => '<strong>Oldalsáv menü egyszerűsítése:</strong> A CRM és Adminisztráció legördülő almenük megszűntek. A Kapcsolatok, Csoportok, Felhasználók, Beállítások, Verziókövetés és Súgó kezelése mostantól közvetlen, önálló menüpontokként érhetők el.',
             'en' => '<strong>Sidebar menu simplification:</strong> The CRM and Administration dropdown submenus were removed. Contacts, Groups, Users, Settings, Changelog and Help are now directly accessible as standalone menu items — reachable in a single click.'],
            ['hu' => '<strong>Csoport részletoldal átrendezése:</strong> Az oldal bal oszlopába kerültek az Adatok és a Tagok panel egymás alatt, míg a Chat ablak a jobb oldali (kétharmados) oszlopot tölti ki — áttekinthetőbb, kétpaneles elrendezés.',
             'en' => '<strong>Group detail page rearrangement:</strong> The Data and Members panels were moved to the left column stacked vertically, while the Chat window fills the right (two-thirds) column — a clearer, two-panel layout.'],
            ['hu' => '<strong>Chat ablak viewport-kitöltés:</strong> A csoport chat ablaka mostantól a böngészőablak teljes magasságát kitölti (topbartól az aljáig), és a jobb szélre van igazítva. JavaScript alapú <code>position: fixed</code> elhelyezés gondoskodik arról, hogy a Livewire poll-frissítés sem állítja vissza a pozíciót.',
             'en' => '<strong>Chat window viewport fill:</strong> The group chat window now fills the full height of the browser window (from topbar to bottom), aligned to the right edge. JavaScript-based <code>position: fixed</code> placement ensures Livewire poll updates don\'t reset the position.'],
            ['hu' => '<strong>Szerepkörök magyar megnevezése:</strong> A Felhasználók létrehozás/szerkesztés modalban és a Csoport részletoldalon a szerepkör nevek angolról magyarra váltottak: <em>super-admin → Főadmin, admin → Admin, editor → Szerkesztő, member → Tag</em>.',
             'en' => '<strong>Localized role names:</strong> In the Users create/edit modal and the Group detail page, role names were updated to match the display locale: <em>super-admin → Főadmin, admin → Admin, editor → Szerkesztő, member → Tag</em>.'],
            ['hu' => '<strong>Dashboard grafikonok (Chart.js):</strong> A főoldalra három látványos grafikon került: <em>Havi adományok</em> oszlopdiagram (utolsó 12 hónap), <em>Kapcsolatok növekedése</em> kettős-tengelyes vonaldiagram, és <em>Kapcsolatok megoszlása</em> fánkdiagram státusz szerint. A grafikonok valós adatbázis-adatokat jelenítenek meg.',
             'en' => '<strong>Dashboard charts (Chart.js):</strong> Three charts added to the homepage: <em>Monthly donations</em> bar chart (last 12 months), <em>Contact growth</em> dual-axis line chart (contacts + donations), and <em>Contact distribution</em> donut chart by status with custom percentage legend. Charts display live database data.'],
        ],
    ],

    [
        'version' => 'v1.6.0',
        'date' => ['hu' => '2026. május 2.', 'en' => 'May 2, 2026'],
        'items' => [
            ['hu' => '<strong>Felhasználók ↔ Csoportok hozzárendelés:</strong> A rendszer felhasználói mostantól csoportokhoz rendelhetők — külön <code>group_user</code> pivot tábla és M:N kapcsolat a <code>User</code> és <code>Group</code> modellek között.',
             'en' => '<strong>Users ↔ Groups assignment:</strong> System users can now be assigned to groups — separate <code>group_user</code> pivot table and M:N relationship between the <code>User</code> and <code>Group</code> models.'],
            ['hu' => '<strong>Csoportok részletoldala — Felhasználók megjelenítése:</strong> A csoport tagok listájában mostantól a Felhasználók is szerepelnek a Kapcsolatok mellett, megjelölve a típusukat (Kapcsolat / Felhasználó), szerepkörük badge-dzsel ellátva.',
             'en' => '<strong>Group detail page — User display:</strong> Users now appear alongside Contacts in the group members list, labeled with their type (Contact / User) and a role badge.'],
            ['hu' => '<strong>Chip/pill csoport-választó:</strong> A Kapcsolatok és Felhasználók szerkesztő modaljaiban a nehézkes többválasztós listát letisztult, kattintható chip-gombok váltják fel — egyetlen kattintással aktiválható/deaktiválható minden csoport.',
             'en' => '<strong>Chip/pill group selector:</strong> In the Contacts and Users edit modals, the cumbersome multi-select list was replaced by clean, clickable chip buttons — each group can be toggled with a single click.'],
            ['hu' => '<strong>Jelszó szem ikon (Felhasználók):</strong> A Felhasználók létrehozás és szerkesztés modalokban a jelszó- és jelszó-megerősítés mezők mellé szem ikon került, amellyel a beírt jelszó láthatóvá tehető.',
             'en' => '<strong>Password eye icon (Users):</strong> An eye icon was added to the password and password confirmation fields in the Users create and edit modals, allowing the entered password to be shown/hidden.'],
            ['hu' => '<strong>Jelszó validációs javítás:</strong> Felhasználó szerkesztésekor az üres jelszó mezők már nem okoznak validációs hibát — a <code>confirmed</code> szabály csak akkor fut le, ha ténylegesen van megadott jelszó.',
             'en' => '<strong>Password validation fix:</strong> When editing a user, empty password fields no longer cause validation errors — the <code>confirmed</code> rule only runs if a password is actually entered.'],
            ['hu' => '<strong>Oldalsáv logo csere:</strong> A bal felső sarokbeli ikon lecserélve a NationForge márkaképnek megfelelő sötétkék hatszög alapú „N" logóra, világoskék szegéllyel.',
             'en' => '<strong>Sidebar logo replacement:</strong> The icon in the top-left corner was replaced with a NationForge-branded dark blue hexagon "N" logo with a light blue border.'],
            ['hu' => '<strong>Oldalsáv menü egyszerűsítése:</strong> A CRM és Adminisztráció legördülő almenük megszűntek — a Kapcsolatok, Csoportok, Felhasználók, Beállítások, Verziókövetés és Súgó mostantól közvetlen menüpontokként érhetők el.',
             'en' => '<strong>Sidebar menu simplification:</strong> The CRM and Administration dropdown submenus were removed — Contacts, Groups, Users, Settings, Changelog and Help are now directly accessible as standalone menu items.'],
        ],
    ],

    [
        'version' => 'v1.5.2',
        'date' => ['hu' => '2026. május 2.', 'en' => 'May 2, 2026'],
        'items' => [
            ['hu' => '<strong>Főoldal (Dashboard) vizuális finomítása:</strong> A "Legújabb kapcsolatok" listájának igazítása, a megjelenített tartalmak megfelelő bal oldali belső margót kaptak a szebb elrendezés érdekében.',
             'en' => '<strong>Dashboard visual refinement:</strong> Alignment of the "Latest contacts" list; displayed items received proper left padding for a cleaner layout.'],
            ['hu' => '<strong>Súgó — Dinamikus képmegjelenítés:</strong> A súgó cikkekhez integrálásra került egy teljes képernyős képnézegető (lightbox) funkció.',
             'en' => '<strong>Help — Dynamic image display:</strong> A full-screen image viewer (lightbox) function was integrated for help articles.'],
            ['hu' => '<strong>Képnagyítás élmény javítása:</strong> A lightbox finomhangolása, így a feltöltött képek kattintáskor a képernyő 90%-át dinamikusan kitöltve jelennek meg, megtartva az eredeti méretarányokat.',
             'en' => '<strong>Image zoom experience improvement:</strong> Lightbox fine-tuning so that uploaded images appear dynamically filling 90% of the screen on click, maintaining original aspect ratios.'],
        ],
    ],

    [
        'version' => 'v1.5.1',
        'date' => ['hu' => '2026. május 1.', 'en' => 'May 1, 2026'],
        'items' => [
            ['hu' => '<strong>Elrendezés és görgetés javítása:</strong> A teljes admin felület layoutjának optimalizálása (CSS <code>calc</code> használata a Flexbox korlátok helyett), így a hosszú tartalmak tökéletesen görgethetők maradnak.',
             'en' => '<strong>Layout and scroll fix:</strong> Full admin interface layout optimization (using CSS <code>calc</code> instead of Flexbox constraints) so long content scrolls correctly.'],
            ['hu' => '<strong>Dinamikus számlálók a menüben:</strong> A bal oldali menüsáv mostantól valós időben mutatja az adatbázisban lévő rekordok pontos számát a modulok (Kapcsolatok, Projektek stb.) mellett.',
             'en' => '<strong>Dynamic counters in menu:</strong> The left sidebar now shows the exact count of database records next to each module (Contacts, Projects, etc.) in real time.'],
            ['hu' => '<strong>Livewire 404 hiba javítása Forge-on:</strong> A rendszer automatikusan publikálja a Livewire asseteket telepítéskor (<code>post-autoload-dump</code>), és be lett állítva a pontos statikus fizikai elérési út, kiküszöbölve a Nginx hibás <code>.js</code> fájl kiszolgálását.',
             'en' => '<strong>Livewire 404 fix on Forge:</strong> The system automatically publishes Livewire assets on deployment (<code>post-autoload-dump</code>), and the exact static physical path was configured, eliminating Nginx\'s incorrect <code>.js</code> file serving on the production server.'],
            ['hu' => '<strong>Beragadt csomagok takarítása:</strong> A Filament végleges eltávolításának utolsó lépéseként a felesleges <code>filament:upgrade</code> parancs kikerült a Composer folyamatból, ami eddig telepítési hibát okozott.',
             'en' => '<strong>Stuck package cleanup:</strong> As the final step of removing Filament, the unnecessary <code>filament:upgrade</code> command was removed from the Composer process, which was previously causing installation errors.'],
        ],
    ],

    [
        'version' => 'v1.5.0',
        'date' => ['hu' => '2026. május 1.', 'en' => 'May 1, 2026'],
        'items' => [
            ['hu' => '<strong>Sor kattintásra szerkesztés — Csoportok:</strong> Az egész táblázatsor kattintható, megnyitja a szerkesztő modalt. Új szemikon (👁) navigál a részletoldalra az akciósávban.',
             'en' => '<strong>Row click to edit — Groups:</strong> The entire table row is clickable, opening the edit modal. A new eye icon (👁) navigates to the detail page from the action bar.'],
            ['hu' => '<strong>Sor kattintásra szerkesztés — Események:</strong> Ugyanez a viselkedés az Események listában, külön Megnyitás gombbal a részletoldalhoz.',
             'en' => '<strong>Row click to edit — Events:</strong> The same behavior in the Events list, with a separate Open button for the detail page.'],
            ['hu' => '<strong>Sor kattintásra szerkesztés — Feladatok:</strong> A feladatlista sorai kattinthatók; a státusz dropdown és a törlés gomb nem indítja el a szerkesztőt (stopPropagation).',
             'en' => '<strong>Row click to edit — Tasks:</strong> Task list rows are clickable; the status dropdown and delete button don\'t trigger the editor (stopPropagation).'],
            ['hu' => '<strong>data-* attribútum alapú megközelítés:</strong> Az inline JS argumentumok helyett HTML data-attribútumok tárolják az adatokat — megbízhatóbb, speciális karakterek és ékezetek sem okoznak problémát.',
             'en' => '<strong>data-* attribute approach:</strong> HTML data attributes store the data instead of inline JS arguments — more reliable, special characters and accented letters cause no issues.'],
            ['hu' => '<strong>URL generálás javítása (feladatok):</strong> A szerkesztő form action URL-je Blade <code>url()</code> helperrel generálódik, így XAMPP al-könyvtárban is helyes az útvonal.',
             'en' => '<strong>URL generation fix (tasks):</strong> The editor form action URL is generated with the Blade <code>url()</code> helper, so the path is correct even in XAMPP subdirectories.'],
        ],
    ],

    [
        'version' => 'v1.4.0',
        'badge' => [
            'text'  => ['hu' => 'Új modul', 'en' => 'New module'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => '2026. május 1.', 'en' => 'May 1, 2026'],
        'items' => [
            ['hu' => '<strong>Projektkezelő modul:</strong> Teljes CRUD — projektek létrehozása, szerkesztése, törlése. Státusz (tervezés / aktív / lezárt / felfüggesztve) és prioritás (alacsony / közepes / magas) kezeléssel.',
             'en' => '<strong>Project management module:</strong> Full CRUD — create, edit, delete projects. With status (planning / active / completed / on hold) and priority (low / medium / high) management.'],
            ['hu' => '<strong>Projekt–Feladat kapcsolat:</strong> Feladatok projektekhez rendelhetők; a projekt részletoldalán látható az összes kapcsolódó feladat.',
             'en' => '<strong>Project–Task relationship:</strong> Tasks can be assigned to projects; all related tasks are visible on the project detail page.'],
            ['hu' => '<strong>Haladásjelző (Progress %):</strong> A projekt előrehaladása automatikusan számítódik a kész feladatok aránya alapján, vizuális progress bar-ral.',
             'en' => '<strong>Progress indicator (Progress %):</strong> Project progress is automatically calculated based on the ratio of completed tasks, with a visual progress bar.'],
            ['hu' => '<strong>Projekt részletoldal (show):</strong> Bal oszlop: metaadatok, haladás, statisztikák (nyitott / folyamatban / kész feladatszámok). Jobb oszlop: feladatlista inline státuszváltóval.',
             'en' => '<strong>Project detail page (show):</strong> Left column: metadata, progress, statistics (open / in progress / done task counts). Right column: task list with inline status switcher.'],
            ['hu' => '<strong>Lejárt projekt jelzés:</strong> Ha a projekt határideje elmúlt és még nincs lezárva, piros „Lejárt" badge jelenik meg.',
             'en' => '<strong>Overdue project indicator:</strong> If the project deadline has passed and it\'s not yet closed, a red "Overdue" badge appears.'],
            ['hu' => '<strong>Projekt szűrő a feladatlistában:</strong> A Feladatok oldalon projekt szerint is szűrhető a lista, beleértve a „Projekt nélküli" feladatok szűrőjét.',
             'en' => '<strong>Project filter in task list:</strong> On the Tasks page, the list can be filtered by project, including a "No project" filter option.'],
        ],
    ],

    [
        'version' => 'v1.3.0',
        'badge' => [
            'text'  => ['hu' => 'Új modul', 'en' => 'New module'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => '2026. május 1.', 'en' => 'May 1, 2026'],
        'items' => [
            ['hu' => '<strong>Feladatkezelő modul:</strong> Teljes CRUD — feladatok létrehozása, szerkesztése, törlése. Prioritás (alacsony / közepes / magas / sürgős) és státusz (nyitott / folyamatban / kész) kezeléssel.',
             'en' => '<strong>Task management module:</strong> Full CRUD — create, edit, delete tasks. With priority (low / medium / high / urgent) and status (open / in progress / done) management.'],
            ['hu' => '<strong>Inline státuszváltó:</strong> A feladatlista táblázatában közvetlenül váltható a státusz legördülő menüből, oldal-újratöltés nélkül.',
             'en' => '<strong>Inline status switcher:</strong> Status can be changed directly from a dropdown in the task list table, without page reload (form submit).'],
            ['hu' => '<strong>Felelős hozzárendelés:</strong> Minden feladathoz rendelhető felelős felhasználó; az admin panel felhasználói listájából választható.',
             'en' => '<strong>Assignee assignment:</strong> Every task can be assigned to a responsible user; selectable from the admin panel\'s user list.'],
            ['hu' => '<strong>Határidő és lejárat jelzés:</strong> Lejárt feladatoknál piros dátumszín és „Lejárt" badge figyelmezteti az adminisztrátort.',
             'en' => '<strong>Deadline and overdue indicator:</strong> For overdue tasks, a red date color and "Overdue" badge warns the administrator.'],
            ['hu' => '<strong>Statisztikai kártyák:</strong> A feladatlista tetején összesítők jelennek meg: összes / nyitott / folyamatban / kész darabszámokkal, amelyek szűrőként is működnek.',
             'en' => '<strong>Statistics cards:</strong> Summaries appear at the top of the task list: total / open / in progress / done counts, which also work as filters.'],
            ['hu' => '<strong>Sidebar badge:</strong> A navigációs sávban a Feladatok menüpont mellett élő számláló mutatja az aktív (nyitott + folyamatban) feladatok számát.',
             'en' => '<strong>Sidebar badge:</strong> In the navigation bar, a live counter next to the Tasks menu item shows the number of active (open + in progress) tasks.'],
            ['hu' => '<strong>GitHub szinkronizáció:</strong> <code>gitupdate.bat</code> szkript a projekt automatikus feltöltéséhez a GitHub repóba, XAMPP jogosultsági fix-szel.',
             'en' => '<strong>GitHub synchronization:</strong> <code>gitupdate.bat</code> script for automatically pushing the project to GitHub, with XAMPP permissions fix.'],
        ],
    ],

    [
        'version' => 'v1.2.0',
        'badge' => [
            'text'  => ['hu' => 'Fejlesztés', 'en' => 'Improvement'],
            'style' => 'background:rgba(247,184,75,0.12);color:#c9920a;',
        ],
        'date' => ['hu' => '2026. május 1.', 'en' => 'May 1, 2026'],
        'items' => [
            ['hu' => '<strong>Magyar bejelentkezési felület:</strong> Az összes login oldal szövege (E-mail, Jelszó, Bejelentkezés, hibaüzenetek) teljes egészében magyarra lett fordítva JSON és PHP nyelvi fájlok segítségével.',
             'en' => '<strong>Localized login interface:</strong> All login page text (Email, Password, Login, error messages) was fully translated using JSON and PHP language files.'],
            ['hu' => '<strong>Jelszó megjelenítő szem ikon:</strong> A jelszó beviteli mező jobb szélén toggle gomb jelenik meg, amellyel a jelszó láthatóvá / elrejtetté tehető (Alpine.js <code>x-bind:type</code>).',
             'en' => '<strong>Password show eye icon:</strong> A toggle button appears on the right side of the password field, allowing the password to be shown/hidden (Alpine.js <code>x-bind:type</code>).'],
            ['hu' => '<strong>Különálló admin bejelentkezés:</strong> Az <code>/admin/login</code> route különálló Volt komponenssel rendelkezik; sikeres belépés után az admin dashboardra irányít.',
             'en' => '<strong>Separate admin login:</strong> The <code>/admin/login</code> route has a dedicated Volt component; after successful login it redirects to the admin dashboard, showing an error for non-admin users.'],
            ['hu' => '<strong>Admin login háttérkép:</strong> Az admin bejelentkezési oldalon teljes képernyős háttérkép látható, a bejelentkezési panel a jobb oldalon félátlátszó, blur-hatású kártyában helyezkedik el.',
             'en' => '<strong>Admin login background image:</strong> The admin login page features a full-screen background image, with the login panel on the right in a semi-transparent, blur-effect card.'],
            ['hu' => '<strong>AdminMiddleware javítás:</strong> Nem bejelentkezett felhasználó esetén a middleware az <code>admin.login</code> route-ra irányít (korábban 403 hibát dobott).',
             'en' => '<strong>AdminMiddleware fix:</strong> For non-logged-in users, the middleware now redirects to the <code>admin.login</code> route (previously threw a 403 error).'],
        ],
    ],

    [
        'version' => 'v1.1.0',
        'badge' => [
            'text'  => ['hu' => 'Fejlesztés', 'en' => 'Improvement'],
            'style' => 'background:rgba(247,184,75,0.12);color:#c9920a;',
        ],
        'date' => ['hu' => '2026. április', 'en' => 'April 2026'],
        'items' => [
            ['hu' => '<strong>Önálló Súgó oldal kialakítása:</strong> A súgó popup rendszert leváltotta egy elegáns, teljes oldalas megjelenítés.',
             'en' => '<strong>Standalone Help page:</strong> The help popup system was replaced by an elegant, full-page display.'],
            ['hu' => '<strong>Markdown támogatás:</strong> A súgó cikkeket mostantól Markdown formátummal is lehet rendszerezni (félkövér, címsorok stb.).',
             'en' => '<strong>Markdown support:</strong> Help articles can now use Markdown formatting (bold, headings, etc.).'],
            ['hu' => '<strong>Adatbázis korrekciók:</strong> A súgó alapértelmezett cikkei nyelvtanilag tökéletes, magyar ékezetes formában kerültek rögzítésre.',
             'en' => '<strong>Database corrections:</strong> The default help articles were stored in grammatically correct form.'],
            ['hu' => '<strong>Verziókövetés (Changelog):</strong> Létrehozásra került ez a menüpont a fejlesztések és az eddigi munka áttekintésére.',
             'en' => '<strong>Changelog:</strong> This menu item was created to track and review all developments.'],
        ],
    ],

    [
        'version' => 'v1.0.0',
        'badge' => [
            'text'  => ['hu' => 'Mérföldkő', 'en' => 'Milestone'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => 'Indulás, Alaprendszer', 'en' => 'Launch, Core system'],
        'items' => [
            ['hu' => '<strong>Környezet kialakítása:</strong> XAMPP kompatibilitás, URL routing fixek, Laravel 12.56 beállítás.',
             'en' => '<strong>Environment setup:</strong> XAMPP compatibility, URL routing fixes, Laravel 12.56 configuration.'],
            ['hu' => '<strong>Admin felület újjáépítése:</strong> Filament eltávolítása, gyorsabb, modern Velzon-stílusú egyedi Tailwind panellé.',
             'en' => '<strong>Admin interface rebuild:</strong> Filament removed, replaced with a faster, modern Velzon-style custom Tailwind panel.'],
            ['hu' => '<strong>Jogosultságkezelés:</strong> Spatie Permission alapú szerepkörök (super-admin, admin, editor, member) bevezetése.',
             'en' => '<strong>Access control:</strong> Spatie Permission-based roles (super-admin, admin, editor, member) introduced.'],
            ['hu' => '<strong>Kapcsolatok (CRM):</strong> Emberek, státuszok, előfizetések, és részletes profiladatok nyilvántartása fejlesztve.',
             'en' => '<strong>Contacts (CRM):</strong> People, statuses, subscriptions, and detailed profile data tracking developed.'],
            ['hu' => '<strong>Csoportok modul:</strong> Kapcsolatok tematikus elrendezése csoportokba M:N kapcsolatokon keresztül.',
             'en' => '<strong>Groups module:</strong> Thematic arrangement of contacts into groups through M:N relationships.'],
            ['hu' => '<strong>Események kezelése:</strong> Események CRUD felülete naptári validációval, RSVP előkészítéssel.',
             'en' => '<strong>Events management:</strong> Events CRUD interface with calendar validation and RSVP preparation.'],
            ['hu' => '<strong>Adományok megtekintése:</strong> Tranzakciólista a pénzügyi transzferek könnyű nyomonkövetéséhez.',
             'en' => '<strong>Donations view:</strong> Transaction list for easy tracking of financial transfers.'],
        ],
    ],

];
@endphp

<style>
    .timeline {
        position: relative;
        max-width: 800px;
        margin: 0 auto;
        padding-left: 30px;
    }
    .timeline::before {
        content: '';
        position: absolute;
        top: 0; bottom: 0; left: 11px;
        width: 2px;
        background: #e9ebec;
    }
    .tl-item {
        position: relative;
        margin-bottom: 40px;
    }
    .tl-dot {
        position: absolute;
        left: -30px;
        top: 4px;
        width: 24px; height: 24px;
        border-radius: 50%;
        background: #405189;
        border: 4px solid #f3f3f9;
        display: flex; align-items: center; justify-content: center;
    }
    .tl-dot.latest {
        background: #0ab39c;
        box-shadow: 0 0 0 3px rgba(10,179,156,0.15);
    }
    .tl-content {
        background: #fff;
        border: 1px solid #e9ebec;
        border-radius: 8px;
        padding: 24px;
        box-shadow: 0 2px 4px rgba(56,65,74,0.05);
    }
    .tl-header {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px; border-bottom: 1px solid #e9ebec;
    }
    .tl-title { font-size: 1.15rem; font-weight: 700; color: #2a2f45; display: flex; align-items: center; gap: 10px; }
    .tl-date { color: #878a99; font-size: 0.8rem; font-weight: 500; }
    .tl-content ul {
        list-style: none;
        padding: 0; margin: 0;
    }
    .tl-content ul li {
        position: relative;
        padding-left: 20px;
        margin-bottom: 12px;
        color: #495057;
        font-size: 0.9rem;
        line-height: 1.5;
    }
    .tl-content ul li::before {
        content: '❖';
        position: absolute;
        left: 0; top: 0px;
        color: #405189;
        font-size: 0.75rem;
    }
    .tl-badge {
        font-size: 0.65rem; padding: 3px 8px; border-radius: 4px; font-weight: 600; margin-left: 8px;
    }
</style>

<div class="timeline">
    @foreach($versions as $v)
    @php $isLatest = $v['latest'] ?? false; @endphp
    <div class="tl-item">
        <div class="tl-dot {{ $isLatest ? 'latest' : '' }}">
            <svg width="12" height="12" fill="white" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
        </div>
        <div class="tl-content">
            <div class="tl-header">
                <div class="tl-title">
                    {{ $v['version'] }}
                    @if(isset($v['badge']))
                        <span class="tl-badge" style="{{ $v['badge']['style'] }}">{{ $v['badge']['text'][$locale] }}</span>
                    @endif
                </div>
                <div class="tl-date">{{ $v['date'][$locale] }}</div>
            </div>
            <ul>
                @foreach($v['items'] as $item)
                <li>{!! $item[$locale] !!}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endforeach
</div>

@endsection
