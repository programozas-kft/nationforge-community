@php
$locale = app()->getLocale();

$versions = [

    [
        'version' => 'v1.25.0',
        'latest'  => true,
        'badge'   => [
            'text'  => ['hu' => 'Aktuális, Legújabb', 'en' => 'Current, Latest'],
            'style' => 'background:rgba(10,179,156,0.1);color:#0ab39c;',
        ],
        'date' => ['hu' => '2026. május 17.', 'en' => 'May 17, 2026'],
        'items' => [
            ['hu' => '<strong>Google Calendar / iCal szinkronizáció:</strong> Nyilvános iCal feed (<code>/events.ics</code>) — az összes publikált esemény előfizethetővé vált bármilyen naptáralkalmazásban (Google Calendar, Apple Calendar, Outlook). Az Integrációk oldalon megjelenő URL egyetlen kattintással a Google Naptárba is hozzáadható.',
             'en'  => '<strong>Google Calendar / iCal sync:</strong> Public iCal feed (<code>/events.ics</code>) — all published events are now subscribable in any calendar app (Google Calendar, Apple Calendar, Outlook). The URL shown on the Integrations page can be added to Google Calendar in a single click.'],
            ['hu' => '<strong>Facebook Esemény közzétevő:</strong> A publikált esemény nézetében megjelent egy <em>Közzétesz Facebookon</em> gomb, amely a Graph API v19.0 segítségével létrehozza az eseményt a beállított Facebook Oldalon. Az Integrációk oldalon adható meg az Oldal ID és a Page Access Token.',
             'en'  => '<strong>Facebook Event publisher:</strong> A <em>Publish to Facebook</em> button appears on published event pages, creating the event on the configured Facebook Page via Graph API v19.0. The Page ID and Page Access Token are configured on the Integrations page.'],
            ['hu' => '<strong>Zapier & Make (Integromat) integráció:</strong> A meglévő kimenő webhook rendszer (v1.24.0) az alapja. Az új Integrációk oldalon lépésről lépésre útmutató mutatja, hogyan kell Zapier Catch Hook és Make Custom Webhook triggert összekapcsolni a NationForge-zal — kód nélkül.',
             'en'  => '<strong>Zapier & Make (Integromat) integration:</strong> Built on the existing outgoing webhook system (v1.24.0). The new Integrations page provides a step-by-step guide on how to connect Zapier Catch Hook and Make Custom Webhook triggers to NationForge — no code required.'],
            ['hu' => '<strong>Integrációk menüpont a sidebarban:</strong> Az összes külső integráció egy dedikált <em>Integrációk</em> oldalon érhető el — Google Calendar URL másoló, Facebook token beállítás és a Zapier/Make útmutató egy helyen.',
             'en'  => '<strong>Integrations menu item in sidebar:</strong> All external integrations are accessible from a dedicated <em>Integrations</em> page — Google Calendar URL copy, Facebook token configuration, and the Zapier/Make guide all in one place.'],
        ],
    ],

    [
        'version' => 'v1.24.0',
        'badge'   => [
            'text'  => ['hu' => 'Új modul', 'en' => 'New module'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => '2026. május 17.', 'en' => 'May 17, 2026'],
        'items' => [
            ['hu' => '<strong>Kimenő webhookok:</strong> Konfigurálható HTTP POST küldés tetszőleges URL-re rendszereseményekre. 12 eseménytípus: <code>contact.*</code>, <code>event.*</code>, <code>donation.created</code>, <code>campaign.sent</code>, <code>task.*</code>, <code>drip.enrolled</code>. HMAC-SHA256 aláírás (<code>X-NationForge-Signature</code>). Kézbesítési napló per-kísérlet státusszal, HTTP kóddal és válasz törzzsel. Automatikus újrakísérlet (3 alkalom, 60 másodperces visszatartással) queue-n. Sikertelen kézbesítések manuális újraküldése az admin felületről.',
             'en'  => '<strong>Outgoing webhooks:</strong> Configurable HTTP POST to any URL on system events. 12 event types: <code>contact.*</code>, <code>event.*</code>, <code>donation.created</code>, <code>campaign.sent</code>, <code>task.*</code>, <code>drip.enrolled</code>. HMAC-SHA256 signing (<code>X-NationForge-Signature</code>). Delivery log with per-attempt status, HTTP code and response body. Automatic retry (3 attempts, 60 s backoff) via queue. Manual retry for failed deliveries from the admin UI.'],
        ],
    ],

    [
        'version' => 'v1.23.0',
        'badge'   => [
            'text'  => ['hu' => 'Fejlesztés', 'en' => 'Improvement'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => '2026. május 17.', 'en' => 'May 17, 2026'],
        'items' => [
            ['hu' => '<strong>Többnyelvű súgó (DE / RO / SK):</strong> A súgódokumentáció immár öt nyelven érhető el: magyar, angol, <em>német, román és szlovák</em>. Mind a 16 súgócikk teljes szövege le van fordítva. A nyelvváltó a súgó oldalsávjában érhető el — a kiválasztott nyelv azonnal érvényes.',
             'en'  => '<strong>Multilingual help (DE / RO / SK):</strong> The help documentation is now available in five languages: Hungarian, English, <em>German, Romanian and Slovak</em>. All 16 help articles are fully translated. The language switcher is available in the help sidebar — the selected language takes effect immediately.'],
            ['hu' => '<strong>Adatbázis-séma bővítése:</strong> A <code>help_articles</code> táblához hat új nullable szöveges oszlop adódott: <code>title_de</code>, <code>content_de</code>, <code>title_ro</code>, <code>content_ro</code>, <code>title_sk</code>, <code>content_sk</code>.',
             'en'  => '<strong>Database schema extension:</strong> Six new nullable text columns were added to the <code>help_articles</code> table: <code>title_de</code>, <code>content_de</code>, <code>title_ro</code>, <code>content_ro</code>, <code>title_sk</code>, <code>content_sk</code>.'],
            ['hu' => '<strong>Súgószerkesztő — DE / RO / SK fülek:</strong> Az admin súgókezelő szerkesztő modáljában megjelent a Deutsch, Română és Slovenčina fül, így az összes nyelvi tartalom egy helyen szerkeszthető.',
             'en'  => '<strong>Help editor — DE / RO / SK tabs:</strong> The admin help editor modal now includes Deutsch, Română and Slovenčina tabs, allowing all language content to be edited from one place.'],
            ['hu' => '<strong>Képek szinkronizálása minden nyelvre:</strong> A <code>HelpSyncImagesAllLangsSeeder</code> minden olyan cikknél, amelynek magyar tartalma képernyőképpel kezdődik, automatikusan előrészíti ugyanazt a képet a DE / RO / SK tartalomba is — duplikáció nélkül.',
             'en'  => '<strong>Image sync across all languages:</strong> The <code>HelpSyncImagesAllLangsSeeder</code> automatically prepends the same screenshot to DE / RO / SK content for every article whose Hungarian content starts with a screenshot image — without duplication.'],
        ],
    ],

    [
        'version' => 'v1.22.0',
        'badge'   => [
            'text'  => ['hu' => 'Fejlesztés', 'en' => 'Improvement'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => '2026. május 16.', 'en' => 'May 16, 2026'],
        'items' => [
            ['hu' => '<strong>Email megnyitás nyomon követése (tracking pixel):</strong> Minden elküldött kampánylevélbe és drip-levélbe egy láthatatlan 1×1 pixeles GIF-kép kerül. Ha a fogadó megnyitja az emailt, a kép lekérése rögzíti a megnyitás tényét. Az <code>email_sends</code> és <code>drip_sends</code> táblákhoz <code>opened_at</code> (nullable timestamp) mező adódott; a kampány összesítő <code>opened_count</code> számlálója automatikusan növekszik.',
             'en'  => '<strong>Email open tracking (pixel):</strong> Every sent campaign email and drip email now contains an invisible 1×1 GIF image. When the recipient opens the email, the image request records the open event. An <code>opened_at</code> (nullable timestamp) column was added to <code>email_sends</code> and <code>drip_sends</code>; the campaign summary <code>opened_count</code> counter increments automatically.'],
            ['hu' => '<strong>Link-kattintás nyomon követése:</strong> Az emailben lévő összes külső link egy átirányító proxy URL-en keresztül kerül kiszolgálásra (<code>/track/click/{token}?to=...</code>). Kattintáskor a rendszer rögzíti a <code>clicked_at</code> időpontot és növeli a kampány <code>clicked_count</code> számlálóját, majd átirányít az eredeti célra. Az unsubscribe és nyomkövetési linkek kizárva az átírásból.',
             'en'  => '<strong>Link click tracking:</strong> All external links in emails are served through a redirect proxy URL (<code>/track/click/{token}?to=...</code>). On click, the system records the <code>clicked_at</code> timestamp and increments the campaign\'s <code>clicked_count</code> counter, then redirects to the original destination. Unsubscribe and tracking links are excluded from rewriting.'],
            ['hu' => '<strong>Megnyitások és kattintások megjelenítése a kampánylistában:</strong> Az Email kampányok táblázatában két új oszlop jelent meg: <em>Megnyitások</em> (abszolút szám + százalékos arány) és <em>Kattintások</em> — zöld kiemelő színnel. A statisztikák valós adatbázis-adatokon alapulnak.',
             'en'  => '<strong>Opens and clicks displayed in campaign list:</strong> Two new columns appear in the Email Campaigns table: <em>Opens</em> (absolute count + percentage rate) and <em>Clicks</em> — highlighted in green. Statistics are based on live database data.'],
            ['hu' => '<strong>EmailTrackingService:</strong> Új <code>App\\Services\\EmailTrackingService</code> osztály, amely egységesen kezeli a link-csomagolást (<code>wrapLinks()</code>), a pixel-befűzést (<code>injectPixel()</code>) és a teljes folyamatot (<code>process()</code>). A base64-kódolt GIF konstansként tárolódik — sem fájlrendszer, sem HTTP-lekérés nem szükséges a pixelhez.',
             'en'  => '<strong>EmailTrackingService:</strong> New <code>App\\Services\\EmailTrackingService</code> class that uniformly handles link wrapping (<code>wrapLinks()</code>), pixel injection (<code>injectPixel()</code>) and the full pipeline (<code>process()</code>). The base64-encoded GIF is stored as a constant — no filesystem or HTTP request needed for the pixel.'],
            ['hu' => '<strong>TrackingController (nyilvános végpontok):</strong> <code>GET /track/open/{token}</code> — visszaadja a GIF pixelt és frissíti az <code>opened_at</code> mezőt; <code>GET /track/click/{token}?to=URL</code> — átirányít a célra és frissíti a <code>clicked_at</code> mezőt. Biztonsági ellenőrzés: a <code>to</code> paraméter csak érvényes abszolút URL esetén kerül átirányításra (<code>FILTER_VALIDATE_URL</code>).',
             'en'  => '<strong>TrackingController (public endpoints):</strong> <code>GET /track/open/{token}</code> — returns the GIF pixel and updates the <code>opened_at</code> field; <code>GET /track/click/{token}?to=URL</code> — redirects to the destination and updates the <code>clicked_at</code> field. Security check: the <code>to</code> parameter is only redirected for valid absolute URLs (<code>FILTER_VALIDATE_URL</code>).'],
        ],
    ],

    [
        'version' => 'v1.21.0',
        'badge'   => [
            'text'  => ['hu' => 'Fejlesztés', 'en' => 'Improvement'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => '2026. május 16.', 'en' => 'May 16, 2026'],
        'items' => [
            ['hu' => '<strong>Egyérintéses leiratkozási oldal (publikus):</strong> Minden hírlevél-feliratkozónak egyedi <code>unsubscribe_token</code> kerül generálásra (meglévő rekordokra visszatöltő migráció is fut). Az emailekben megjelenik az <em>Leiratkozás / Unsubscribe</em> hivatkozás, amely az <code>/unsubscribe/{token}</code> oldalra vezet. Az oldal 4 állapotot kezel: aktív feliratkozó / leiratkozott / visszairatkozás opció / ismeretlen token.',
             'en'  => '<strong>One-click unsubscribe page (public):</strong> Every newsletter subscriber receives a unique <code>unsubscribe_token</code> (a backfill migration runs for existing records). Emails now include an <em>Unsubscribe</em> link pointing to <code>/unsubscribe/{token}</code>. The page handles 4 states: active subscriber / unsubscribed / re-subscribe option / unknown token.'],
            ['hu' => '<strong>RFC 8058 <code>List-Unsubscribe</code> fejlécek:</strong> Az elküldött emailek tartalmazzák a <code>List-Unsubscribe</code> és <code>List-Unsubscribe-Post: List-Unsubscribe=One-Click</code> fejléceket a Symfony <code>using:</code> callback-en keresztül. Ez lehetővé teszi a modernebb levelezők (Gmail, Outlook) számára, hogy egy kattintással leiratkozási gombot jelenítsenek meg.',
             'en'  => '<strong>RFC 8058 <code>List-Unsubscribe</code> headers:</strong> Sent emails now include <code>List-Unsubscribe</code> and <code>List-Unsubscribe-Post: List-Unsubscribe=One-Click</code> headers via a Symfony <code>using:</code> callback. This allows modern email clients (Gmail, Outlook) to render a one-click unsubscribe button.'],
            ['hu' => '<strong>Visszairatkozási lehetőség:</strong> A leiratkozott állapotban az oldal egy <em>Visszairatkozás</em> gombot is megjelenít. A visszairatkozás egy külön POST végponton (<code>/unsubscribe/{token}/resubscribe</code>) keresztül valósul meg, és az <code>is_subscribed</code> értéket <code>true</code>-ra állítja.',
             'en'  => '<strong>Re-subscribe option:</strong> On the unsubscribed state, the page also shows a <em>Re-subscribe</em> button. Re-subscribing is handled through a separate POST endpoint (<code>/unsubscribe/{token}/resubscribe</code>) that sets <code>is_subscribed</code> back to <code>true</code>.'],
        ],
    ],

    [
        'version' => 'v1.20.0',
        'badge'   => [
            'text'  => ['hu' => 'Új modul', 'en' => 'New module'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => '2026. május 16.', 'en' => 'May 16, 2026'],
        'items' => [
            ['hu' => '<strong>Automatizált csepp (drip) kampány modul:</strong> Új <code>/admin/drip-campaigns</code> oldal. Minden drip kampányhoz tetszőleges számú lépés adható meg — tárgy, feladó, HTML tartalom, és az előző lépéstől eltelt napok száma. Indítók: <em>Manuális</em>, <em>Csoporthoz csatlakozás</em>, <em>Tag hozzáadás</em>.',
             'en'  => '<strong>Automated drip campaign module:</strong> New <code>/admin/drip-campaigns</code> page. Each drip campaign supports an unlimited number of steps — subject, sender, HTML content, and delay in days from the previous step. Triggers: <em>Manual</em>, <em>Group join</em>, <em>Tag added</em>.'],
            ['hu' => '<strong>Drip beiratkozás és feldolgozás:</strong> Kontaktok manuálisan (admin gomb) vagy automatikusan (trigger) iratkozhatnak be egy drip kampányba. Az <code>drip:process</code> Artisan parancs 15 percenként fut: megkeresi az esedékes beiratkozásokat, elküldi a következő lépést, és beállítja a következő küldési időpontot. A kampány végeztével a beiratkozás <em>completed</em> státuszt kap.',
             'en'  => '<strong>Drip enrollment and processing:</strong> Contacts can enroll in a drip campaign manually (admin button) or automatically (via trigger). The <code>drip:process</code> Artisan command runs every 15 minutes: it finds due enrollments, sends the next step, and sets the next send time. When the campaign ends, the enrollment receives <em>completed</em> status.'],
            ['hu' => '<strong>Drip kampány admin felület:</strong> A részletoldalon 4 statisztikai kártya (aktív / lezárt / lemondott beiratkozások, összes lépés), szerkeszthető lépéslista modal alapon, beiratkozások listája emberenként és lépésenként. Kampány aktiválása / szüneteltetése egy kattintással.',
             'en'  => '<strong>Drip campaign admin interface:</strong> The detail page shows 4 stat cards (active / completed / cancelled enrollments, total steps), editable step list via modals, and enrollments list per person and per step. Campaign activation / pausing with a single click.'],
            ['hu' => '<strong>Adatbázis-séma:</strong> Három új tábla: <code>drip_campaigns</code> (kampány fejadatok, trigger típus és cél-csoport/tag), <code>drip_steps</code> (lépések pozíció szerint rendezve), <code>drip_enrollments</code> (beiratkozások státusszal, <code>next_send_at</code> indexszel), valamint <code>drip_sends</code> (küldési nyomkövetés, tracking tokennel).',
             'en'  => '<strong>Database schema:</strong> Three new tables: <code>drip_campaigns</code> (campaign header, trigger type and target group/tag), <code>drip_steps</code> (steps ordered by position), <code>drip_enrollments</code> (enrollments with status, <code>next_send_at</code> index), and <code>drip_sends</code> (send tracking with tracking token).'],
        ],
    ],

    [
        'version' => 'v1.19.0',
        'badge'   => [
            'text'  => ['hu' => 'Fejlesztés', 'en' => 'Improvement'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => '2026. május 16.', 'en' => 'May 16, 2026'],
        'items' => [
            ['hu' => '<strong>Kampány célcsoport szegmentálás:</strong> A kampány létrehozás és szerkesztés modalban megjelent a <em>Célcsoport</em> szekció. Az admin négy opció közül választhat: <em>Összes hírlevél feliratkozó</em>, <em>Csoport tagjai</em> (több csoport is kijelölhető), <em>Tagelt kontaktok</em> (több tag), <em>Tag státusz szerint</em> (több státusz). A szűrőkombináció JSON formában tárolódik az <code>email_campaigns.segment_filters</code> oszlopban.',
             'en'  => '<strong>Campaign audience segmentation:</strong> A <em>Audience</em> section appeared in the campaign create and edit modal. Admins can choose from four options: <em>All newsletter subscribers</em>, <em>Group members</em> (multiple groups selectable), <em>Tagged contacts</em> (multiple tags), <em>By member status</em> (multiple statuses). The filter combination is stored as JSON in the <code>email_campaigns.segment_filters</code> column.'],
            ['hu' => '<strong>Élő fogadószám előnézet:</strong> Szegmentációs beállítás módosításakor az oldal AJAX-on keresztül (<code>GET /admin/campaigns/recipient-count</code>) valós időben kéri le a becsült fogadók számát, és 500 ms-os debounce-szal jeleníti meg. A kampánylistában megjelent a <em>Szegmens</em> oszlop a típus jelzésével.',
             'en'  => '<strong>Live recipient count preview:</strong> When the segmentation setting changes, the page fetches the estimated recipient count in real time via AJAX (<code>GET /admin/campaigns/recipient-count</code>) with a 500 ms debounce, and displays it immediately. A <em>Segment</em> column appeared in the campaign list indicating the type.'],
            ['hu' => '<strong><code>buildRecipientsQuery()</code> metódus az <code>EmailCampaign</code> modellen:</strong> Egységes lekérdezés-építő, amely a <code>segment_filters</code> JSON alapján szűri a feliratkozott, érvényes email-lel rendelkező kontaktokat — csoportszűrő esetén <code>whereHas(\'groups\')</code>, tagszűrőnél <code>whereHas(\'tags\')</code>, státuszszűrőnél <code>whereIn(\'status\')</code>.',
             'en'  => '<strong><code>buildRecipientsQuery()</code> method on <code>EmailCampaign</code> model:</strong> A unified query builder that filters subscribed contacts with valid emails based on the <code>segment_filters</code> JSON — using <code>whereHas(\'groups\')</code> for group filter, <code>whereHas(\'tags\')</code> for tag filter, <code>whereIn(\'status\')</code> for status filter.'],
        ],
    ],

    [
        'version' => 'v1.18.0',
        'badge'   => [
            'text'  => ['hu' => 'Fejlesztés', 'en' => 'Improvement'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => '2026. május 16.', 'en' => 'May 16, 2026'],
        'items' => [
            ['hu' => '<strong>Email sablonkönyvtár:</strong> Új <code>/admin/email-templates</code> oldal, amely kártyás elrendezésben mutatja a beépített (<em>Minimál, Hírlevél, Bejelentés, Promóciós</em>) és az egyéni sablonokat. Minden sablon szerkeszthető, előnézhető (iframe modal) és törlhető (kivéve a beépítetteket).',
             'en'  => '<strong>Email template library:</strong> New <code>/admin/email-templates</code> page displaying built-in (<em>Minimal, Newsletter, Announcement, Promotional</em>) and custom templates in card layout. Every template can be edited, previewed (iframe modal) and deleted (except built-ins).'],
            ['hu' => '<strong>Sablon betöltése a kampányszerkesztőbe:</strong> A kampány létrehozás és szerkesztés modalban megjelent a <em>„Sablon betöltése"</em> gomb. Megnyit egy sablonválasztó modalt, amelyből egy kattintással a kiválasztott sablon HTML tartalma betöltődik a szerkesztőbe. Az összes elérhető sablon listaszerűen és részletes előnézettel tekinthető meg.',
             'en'  => '<strong>Loading a template into the campaign editor:</strong> A <em>"Use template"</em> button appeared in the campaign create and edit modal. It opens a template picker modal, from which a single click loads the selected template\'s HTML content into the editor. All available templates are listed with a detailed preview.'],
            ['hu' => '<strong>Beépített sablonok (seeder):</strong> A telepítéskor 4 professzionális beépített sablon kerül az adatbázisba automatikusan, amelyek szervezeti arculathoz testreszabhatók. Az <code>email_templates</code> tábla tartalmazza: <code>name</code>, <code>description</code>, <code>category</code>, <code>body_html</code>, <code>is_system</code> (boolean) mezőket.',
             'en'  => '<strong>Built-in templates (seeder):</strong> At installation, 4 professional built-in templates are automatically inserted into the database and can be customized for organizational branding. The <code>email_templates</code> table contains: <code>name</code>, <code>description</code>, <code>category</code>, <code>body_html</code>, <code>is_system</code> (boolean) columns.'],
        ],
    ],

    [
        'version' => 'v1.17.0',
        'badge'   => [
            'text'  => ['hu' => 'Fejlesztés', 'en' => 'Improvement'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => '2026. május 16.', 'en' => 'May 16, 2026'],
        'items' => [
            ['hu' => '<strong>Adomány export könyveléshez (CSV, XLSX, PDF):</strong> Az Adományok oldalon megjelent az <em>Export</em> gomb. Az exportálás szűrhető: kezdési és befejezési dátum, pénznem. Három formátum érhető el: CSV (UTF-8 BOM, pontosvesszős), Excel (XLSX, félkövér fejléc) és PDF (táblázatos elrendezés). A <code>phpoffice/phpspreadsheet</code> kezeli az XLSX-t, a <code>dompdf/dompdf</code> a PDF-t.',
             'en'  => '<strong>Donation export for accounting (CSV, XLSX, PDF):</strong> An <em>Export</em> button appeared on the Donations page. Export is filterable by start date, end date and currency. Three formats are available: CSV (UTF-8 BOM, semicolon-separated), Excel (XLSX, bold header) and PDF (tabular layout). <code>phpoffice/phpspreadsheet</code> handles XLSX; <code>dompdf/dompdf</code> handles PDF.'],
            ['hu' => '<strong>Exportált mezők:</strong> Dátum, Kapcsolat neve, Email, Összeg, Pénznem, Fizetési módszer, Státusz, Tranzakció ID, Kampány, Megjegyzés — ezek a könyvelési feldolgozáshoz szükséges legfontosabb adatok kerülnek exportálásra.',
             'en'  => '<strong>Exported fields:</strong> Date, Contact name, Email, Amount, Currency, Payment method, Status, Transaction ID, Campaign, Notes — these essential data points needed for accounting processing are exported.'],
        ],
    ],

    [
        'version' => 'v1.16.0',
        'badge'   => [
            'text'  => ['hu' => 'Fejlesztés', 'en' => 'Improvement'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => '2026. május 16.', 'en' => 'May 16, 2026'],
        'items' => [
            ['hu' => '<strong>Nyilvános online adományozási oldal:</strong> A <code>/donate</code> URL bejelentkezés nélkül elérhető adományozási űrlapot jelenít meg — adományozó neve, email, összeg, pénznem, megjegyzés mezőkkel. Sikeres küldés után visszaigazoló email megy az adományozónak (<em>DonationReceiptMail</em>), és megjelenik egy köszönő oldal (<code>/donate/thanks/{token}</code>).',
             'en'  => '<strong>Public online donation form:</strong> The <code>/donate</code> URL displays a donation form accessible without login — with donor name, email, amount, currency and notes fields. On successful submission, a receipt email is sent to the donor (<em>DonationReceiptMail</em>), and a thank-you page appears (<code>/donate/thanks/{token}</code>).'],
            ['hu' => '<strong>Online fizetés Stripe / Barion integrációval:</strong> A nyilvános adományozási oldal támogatja a bankkártyás fizetést. Stripe esetén a rendszer egy Checkout Session-t hoz létre, és a visszatérési URL-en (<code>/payment/donation/stripe/success/{token}</code>) igazolja a fizetést. Barion integráció szintén elérhető (<code>/payment/donation/barion/callback/{token}</code>).',
             'en'  => '<strong>Online payment with Stripe / Barion integration:</strong> The public donation form supports card payments. For Stripe, the system creates a Checkout Session and verifies the payment on the return URL (<code>/payment/donation/stripe/success/{token}</code>). Barion integration is also available (<code>/payment/donation/barion/callback/{token}</code>).'],
        ],
    ],

    [
        'version' => 'v1.15.0',
        'badge'   => [
            'text'  => ['hu' => 'Fejlesztés', 'en' => 'Improvement'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => '2026. május 16.', 'en' => 'May 16, 2026'],
        'items' => [
            ['hu' => '<strong>Feladat megjegyzések:</strong> Minden feladathoz szöveges megjegyzések fűzhetők, megjelenítve az időpontot és a beküldő felhasználót. A megjegyzések szerkeszthetők és törölhetők. Az adatokat a <code>task_comments</code> tábla tárolja.',
             'en'  => '<strong>Task comments:</strong> Text comments can be added to every task, showing the timestamp and the submitting user. Comments can be edited and deleted. Data is stored in the <code>task_comments</code> table.'],
            ['hu' => '<strong>Feladat fájlmellékletek:</strong> Feladatokhoz fájlok csatolhatók (max. 10 MB) — a <code>task_attachments</code> tábla és a Spatie MediaLibrary kezeli a tárolást. A melléklet neve, mérete és feltöltési ideje megjelenik a feladat részletoldalán; letölthető és törölhető.',
             'en'  => '<strong>Task file attachments:</strong> Files can be attached to tasks (max. 10 MB) — the <code>task_attachments</code> table and Spatie MediaLibrary handle storage. The attachment name, size and upload time appear on the task detail page; files are downloadable and deletable.'],
            ['hu' => '<strong>Gantt-stílusú idővonal nézet (Projektek):</strong> A projekt részletoldalán megjelent egy <em>Gantt nézet</em> fül. A nézet az összes projekt-feladatot az idővonalán helyezi el — vízszintes sáv mutatja a kezdési és befejezési dátumot, határidőn túl esetén piros kiemelés.',
             'en'  => '<strong>Gantt-style timeline view (Projects):</strong> A <em>Gantt view</em> tab appeared on the project detail page. The view places all project tasks on a timeline — a horizontal bar shows the start and end date, with red highlighting for overdue tasks.'],
        ],
    ],

    [
        'version' => 'v1.14.0',
        'badge'   => [
            'text'  => ['hu' => 'Fejlesztés', 'en' => 'Improvement'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => '2026. május 16.', 'en' => 'May 16, 2026'],
        'items' => [
            ['hu' => '<strong>Német (DE), Román (RO) és Szlovák (SK) nyelvcsomag:</strong> Az admin felület teljes szöveggel bővült három új nyelvvel. A <code>lang/de/</code>, <code>lang/ro/</code> és <code>lang/sk/</code> mappákban az összes modul fordítása elérhető (<code>common</code>, <code>nav</code>, <code>people</code>, <code>events</code>, <code>groups</code>, <code>donations</code>, <code>campaigns</code>, <code>projects</code>, <code>tasks</code>, <code>users</code>, <code>settings</code>, <code>help</code>, <code>changelog</code> stb.).',
             'en'  => '<strong>German (DE), Romanian (RO) and Slovak (SK) language packs:</strong> The admin panel was extended with three new languages with full text coverage. All module translations are available in <code>lang/de/</code>, <code>lang/ro/</code> and <code>lang/sk/</code> folders (<code>common</code>, <code>nav</code>, <code>people</code>, <code>events</code>, <code>groups</code>, <code>donations</code>, <code>campaigns</code>, <code>projects</code>, <code>tasks</code>, <code>users</code>, <code>settings</code>, <code>help</code>, <code>changelog</code>, etc.).'],
            ['hu' => '<strong>Nyelvváltó frissítése:</strong> Az oldalsáv HU/EN kapcsolója kiegészült a DE, RO és SK zászlókkal (<code>fi fi-de</code>, <code>fi fi-ro</code>, <code>fi fi-sk</code> SVG ikonok, flag-icons könyvtár). A locale-váltó végpont változatlan: <code>/locale/{locale}</code>.',
             'en'  => '<strong>Language switcher updated:</strong> The HU/EN sidebar switcher was extended with DE, RO and SK flags (<code>fi fi-de</code>, <code>fi fi-ro</code>, <code>fi fi-sk</code> SVG icons, flag-icons library). The locale-switch endpoint is unchanged: <code>/locale/{locale}</code>.'],
        ],
    ],

    [
        'version' => 'v1.13.0',
        'badge'   => [
            'text'  => ['hu' => 'Fejlesztés', 'en' => 'Improvement'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => '2026. május 12.', 'en' => 'May 12, 2026'],
        'items' => [
            ['hu' => '<strong>Esemény bejelentkezés QR-kóddal:</strong> Minden regisztrációhoz egyedi QR-kód generálódik JavaScript alapon (CDN: <code>qrcode.js</code>), amelyet a résztvevő a saját jegy oldalán (<code>/e/ticket/{token}</code>) tekinthet meg. Az admin panel esemény részletoldalán megjelent a <em>Bejelentkezés (ideje)</em> oszlop és egy <em>QR Szkenner</em> gomb. A szkenner oldal (<code>/admin/events/{id}/checkin</code>) kameraalapú QR-beolvasást tesz lehetővé (<code>html5-qrcode</code> CDN, <code>v2.3.8</code>), valós idejű visszajelzéssel (sikeres / már bejelentkezett / ismeretlen token). Manuális token-beviteli mező is elérhető. Az <code>event_registrations</code> táblához <code>checked_in_at</code> (nullable timestamp) oszlop adódott. Statisztikai összesítő sor: összesen / bejelentkezett / még nem érkezett meg.',
             'en'  => '<strong>Event check-in via QR code:</strong> Every registration now has a unique JavaScript-generated QR code (CDN: <code>qrcode.js</code>) accessible on the attendee\'s personal ticket page (<code>/e/ticket/{token}</code>). The admin event detail page now shows a <em>Check-in (time)</em> column and a <em>QR Scanner</em> button. The scanner page (<code>/admin/events/{id}/checkin</code>) supports camera-based QR scanning (<code>html5-qrcode</code> CDN v2.3.8) with real-time feedback (success / already checked in / unknown token). A manual token input field is also available. A <code>checked_in_at</code> (nullable timestamp) column was added to <code>event_registrations</code>. Summary row shows: total / checked in / not yet arrived.'],
            ['hu' => '<strong>Belépőjegy oldal (publikus):</strong> Sikeres regisztráció után a megerősítő oldalon megjelenik a <em>„Jegyem megtekintése"</em> gomb (token session flash alapján). A jegy oldala tartalmazza az esemény adatait, a résztvevő nevét, kísérők számát, és a QR-kódot, amely a <code>token</code> értékét kódolja. Ha a résztvevő már be van jelentkezve, zöld sáv jelzi a bejelentkezés időpontját. Az oldal nyomtatásra optimalizált.',
             'en'  => '<strong>Personal ticket page (public):</strong> After a successful registration, a <em>"View my ticket"</em> button appears on the confirmation page (using a session flash of the token). The ticket page displays the event details, attendee name, number of guests, and the QR code encoding the <code>token</code> value. If the attendee is already checked in, a green banner shows the check-in timestamp. The page is print-optimised.'],
            ['hu' => '<strong>Várólistakezelés:</strong> Az admin esemény szerkesztő formján megjelent a <em>Várólista engedélyezve</em> kapcsoló. Ha az esemény betelt és a várólista aktív, a publikus regisztrációs oldalon sárga „Feliratkozás a várólistára" űrlap jelenik meg a várakozók aktuális számával. A várólistán szereplők pozíció szerint sorrendben jelennek meg az admin részletoldalon, ahol <em>Előléptet</em> és <em>Töröl</em> gombok is elérhetők. Ha egy adminisztrátor töröl egy megerősített regisztrációt, az első várólistás automatikusan előlép és emailes értesítést kap. Az <code>event_registrations</code> táblához <code>waitlisted</code> (boolean) és <code>waitlist_position</code> (smallint) oszlopok, az <code>events</code> táblához <code>waitlist_enabled</code> (boolean) oszlop adódott.',
             'en'  => '<strong>Waitlist management:</strong> A <em>Waitlist enabled</em> toggle was added to the admin event edit form. When the event is full and the waitlist is active, the public registration page displays a yellow "Join the waiting list" form showing the current number of waiting people. Waitlisted entries appear sorted by position on the admin detail page, with <em>Promote</em> and <em>Remove</em> buttons. When an admin deletes a confirmed registration, the first waitlisted person is automatically promoted and receives a notification email. The <code>event_registrations</code> table gained <code>waitlisted</code> (boolean) and <code>waitlist_position</code> (smallint) columns; the <code>events</code> table gained <code>waitlist_enabled</code> (boolean).'],
            ['hu' => '<strong>Várólistás email értesítők (2 db):</strong> <em>WaitlistConfirmation</em> – sárga stílusú visszaigazoló email, amelyet a várólistára kerülő személy kap, a pozíciószámával. <em>WaitlistPromotion</em> – zöld stílusú „hely felszabadult" értesítő, amelyet az előléptetett személy kap, belépőjegy linkkel. Mindkét email HU/EN kétnyelvű (a küldéskori alkalmazáslocale alapján).',
             'en'  => '<strong>Waitlist email notifications (×2):</strong> <em>WaitlistConfirmation</em> — a yellow-styled confirmation email sent to the person who joined the waitlist, including their position number. <em>WaitlistPromotion</em> — a green-styled "spot available" notification sent to the promoted person, with a ticket link. Both emails are bilingual HU/EN (driven by the application locale at send time).'],
            ['hu' => '<strong>Regisztráció törlése adminból:</strong> Az admin esemény részletoldalon minden regisztrációs sor kapott egy <em>×</em> törlés gombot. Törléskor a rendszer automatikusan ellenőrzi a várólistát, és ha van, az első pozíción lévő várólistás előléptetésre kerül és emailt kap. A várólistán lévők pozíciói automatikusan átrendeződnek.',
             'en'  => '<strong>Registration deletion from admin:</strong> Each registration row on the admin event detail page now has a <em>×</em> delete button. On deletion, the system automatically checks the waitlist and, if present, promotes the first waitlisted entry and sends them a notification email. Waitlist positions are automatically reordered after removal.'],
        ],
    ],

    [
        'version' => 'v1.12.0',
        'badge'   => [
            'text'  => ['hu' => 'Fejlesztés', 'en' => 'Improvement'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => '2026. május 10.', 'en' => 'May 10, 2026'],
        'items' => [
            ['hu' => '<strong>Zászló ikonok a nyelvváltóban (sidebar):</strong> A HU / EN nyelvváltó gombok melletti zászlók korábban emoji karakterekként (<code>🇭🇺</code>, <code>🇬🇧</code>) voltak megadva, amelyek Windows rendszeren nem jelennek meg (Chrome / Edge sem rendereli a regionális jelző emoji-kat). Javítás: a <a href="https://flagicons.lipis.dev" target="_blank">flag-icons</a> SVG könyvtár (CDN, v7.2.3) betöltésre kerül, és az emoji helyett <code>&lt;span class="fi fi-hu"&gt;</code> / <code>&lt;span class="fi fi-gb"&gt;</code> elemek kerülnek használatba. Az ikonok most minden platformon és böngészőben egységesen jelennek meg.',
             'en'  => '<strong>Flag icons in the language switcher (sidebar):</strong> The flags next to the HU / EN language switcher buttons were previously emoji characters (<code>🇭🇺</code>, <code>🇬🇧</code>), which do not render on Windows (Chrome / Edge does not support regional indicator emoji sequences). Fix: the <a href="https://flagicons.lipis.dev" target="_blank">flag-icons</a> SVG library (CDN, v7.2.3) is now loaded and <code>&lt;span class="fi fi-hu"&gt;</code> / <code>&lt;span class="fi fi-gb"&gt;</code> elements replace the emoji. Flags now render consistently across all platforms and browsers.'],
            ['hu' => '<strong>README — teljes funkciólista ✅ / 🔲 jelölésekkel:</strong> A projekt README-je gyökeresen átdolgozásra került. Az összes meglévő funkció ✅ jelöléssel, az összes tervezett fejlesztés 🔲 jelöléssel szerepel, modulonként csoportosítva: Kapcsolatok (CRM), Csoportok, Események, Email kampányok, Adományok, Projektek & Feladatok, Dashboard, Felhasználók & Szerepkörök, Link gyűjtemény, Beállítások, Súgó, Többnyelvűség, Integrációk & API, Advanced / Enterprise. Így GitHub-on bármely érdeklődő egyetlen pillantással átláthatja, mi elérhető és mi van tervezőasztalon.',
             'en'  => '<strong>README — comprehensive feature list with ✅ / 🔲 markers:</strong> The project README was comprehensively rewritten. All implemented features are marked ✅ and all planned features are marked 🔲, grouped by module: Contacts (CRM), Groups, Events, Email Campaigns, Donations, Projects & Tasks, Dashboard, Users & Roles, Link Collection, Settings, Help & Documentation, Multi-language, Integrations & API, Advanced / Enterprise. This gives anyone visiting the GitHub repo an instant overview of what is available and what is on the roadmap.'],
            ['hu' => '<strong>Open Core tábla és Advanced / Enterprise szekció szinkronizálása:</strong> A README Open Core összehasonlító táblája és a Features lista Advanced / Enterprise szekciója összhangba hozásra került. A Kétfaktoros hitelesítés (TOTP) és a REST API for mobile clients tételek kizárólag az Enterprise szekcióba kerültek (korábban a Felhasználók & Szerepkörök, ill. Integrációk & API szekciókban is szerepeltek). Az Open Core tábla bővült: Dokumentumtároló, Kérdőív & űrlapkészítő, Petíció / aláírásgyűjtés, Önkéntes órakövetés sorokkal.',
             'en'  => '<strong>Open Core table and Advanced / Enterprise section synchronised:</strong> The README Open Core comparison table and the Advanced / Enterprise section in the Features list have been brought into full alignment. Two-factor authentication (TOTP) and REST API for mobile clients are now exclusively listed under the Enterprise section (previously they also appeared under Users & Roles and Integrations & API). The Open Core table was expanded with new rows: Document storage, Survey & form builder, Petition / signature collection, Volunteer hours tracking.'],
            ['hu' => '<strong>Súgó gomb áthelyezése a gyorslinkek sávba:</strong> A Főoldal jobb felső sarkából eltávolításra került a Súgó gomb. A gyorslinkek sávba (kék topbar) kerülve az Infografikonok mellé, most bármely oldalról elérhetővé vált anélkül, hogy el kellene navigálni a Főoldalra. A bal oldali menüben a „Súgó kezelése" felirat „Súgó"-ra egyszerűsödött.',
             'en'  => '<strong>Help button moved to quick links bar:</strong> The Help button was removed from the top-right corner of the Dashboard and placed in the quick links bar (blue topbar) next to Infographics — now accessible from any page without navigating back to the Dashboard. The left sidebar label "Manage Help" was simplified to "Help".'],
            ['hu' => '<strong>CSV / Excel import &amp; export (Kapcsolatok):</strong> A <code>/admin/people</code> oldalon az összes kapcsolat exportálható CSV (UTF-8 BOM, pontosvesszős elválasztó) vagy Excel (XLSX, félkövér fejléc) formátumban. Import: CSV és XLSX fájlból, oszlopnév-alapú leképzéssel, meglévő emailcímek kihagyásával. A <code>phpoffice/phpspreadsheet</code> könyvtár kezeli az XLSX fájlokat.',
             'en'  => '<strong>CSV / Excel import &amp; export (Contacts):</strong> On the <code>/admin/people</code> page, all contacts can be exported as CSV (UTF-8 BOM, semicolon separator) or Excel (XLSX, bold header). Import: from CSV or XLSX file with column-name-based mapping, skipping existing email addresses. The <code>phpoffice/phpspreadsheet</code> library handles XLSX files.'],
            ['hu' => '<strong>Speciális szűrők és mentett keresések (Kapcsolatok):</strong> Kibővített szűrőpanel: keresés, státusz (több is), város, forrás, hírlevél, csoport, regisztrációs dátumtartomány, lead fázis és minimum pontszám. A szűrőkombinációk névvel elmenthetők és egy kattintással visszatölthetők — felhasználónkénti szűrő-előbeállítások, <code>people_saved_filters</code> tábla.',
             'en'  => '<strong>Advanced filters and saved searches (Contacts):</strong> Expanded filter panel: text search, status (multi-select chips), city, source, newsletter subscription, group, registration date range, lead stage and minimum score. Filter combinations can be saved by name and reloaded in one click — per-user filter presets stored in the <code>people_saved_filters</code> table.'],
            ['hu' => '<strong>Duplikátum-keresés és kapcsolat-összevonás:</strong> Új <code>/admin/people/duplicates</code> oldal, amely email, telefonszám és teljes név (kis-/nagybetű-független) alapján azonosítja a valószínű duplikátumokat. A párokat kártyán jeleníti meg az egyezés okával (email/telefon/név badge). Összevonáskor az üres mezők automatikusan töltődnek fel a másik profilból, az adományok, esemény RSVP-k és csoporttagságok átkerülnek, a duplikátum soft-delete-elve lesz.',
             'en'  => '<strong>Duplicate detection and contact merge:</strong> New <code>/admin/people/duplicates</code> page that identifies probable duplicates by email, phone and full name (case-insensitive). Pairs are shown on cards with the match reason (email / phone / name badge). On merge, empty fields are auto-filled from the other profile, donations, event RSVPs and group memberships are transferred, and the duplicate is soft-deleted.'],
            ['hu' => '<strong>Kapcsolatonkénti aktivitás napló:</strong> Minden kapcsolathoz interakciótörténet rögzíthető: Telefonhívás, Email, Megbeszélés, Feljegyzés, Feladat, SMS, Egyéb — időponttal, megjegyzéssel és rögzítő felhasználóval. A <code>contact_activities</code> tábla tárolja az adatokat. A kapcsolat részletoldalán szín-kódolt, ikonos vertikális timeline formában jelenik meg.',
             'en'  => '<strong>Per-contact activity log:</strong> Interaction history can be recorded for every contact: Phone call, Email, Meeting, Note, Task, SMS, Other — with timestamp, notes and the recording user. Stored in the <code>contact_activities</code> table. Displayed as a colour-coded, icon-based vertical timeline on the contact detail page.'],
            ['hu' => '<strong>Kapcsolatfelvétel / érdeklődőértékelés (Lead scoring):</strong> Minden kapcsolathoz beállítható 6 fázisú értékesítési pipeline (Új érdeklődő → Kapcsolatba lépve → Minősített → Ajánlat küldve → Megnyert → Elveszett) és 1–5 csillagos érdeklődési pontszám. A <code>people</code> tábla bővül <code>lead_stage</code> és <code>lead_score</code> oszlopokkal. A listában Értékelés oszlop jelenik meg; fázis és minimum pontszám alapján szűrhető.',
             'en'  => '<strong>Contact intake / lead scoring:</strong> Each contact can be assigned a 6-stage sales pipeline (New Lead → Contacted → Qualified → Proposal Sent → Converted → Lost) and a 1–5 star interest score. The <code>people</code> table gains <code>lead_stage</code> and <code>lead_score</code> columns. An Evaluation column appears in the contacts list; filterable by stage and minimum score.'],
        ],
    ],

    [
        'version' => 'v1.11.0',
        'badge'   => [
            'text'  => ['hu' => 'Hibajavítás', 'en' => 'Bug Fix'],
            'style' => 'background:rgba(240,101,72,0.1);color:#f06548;',
        ],
        'date' => ['hu' => '2026. május 8.', 'en' => 'May 8, 2026'],
        'items' => [
            ['hu' => '<strong>Email kampány modul — hibajavítás csomag (Pro):</strong> Az email kampány küldési funkció több kritikus hibája javításra került: a <code>is_subscribed</code> mező helyes használata (volt: <code>newsletter</code>), a <code>full_name</code> accessor használata (nem létező <code>name</code> oszlop helyett), az üres <code>\$e</code> catch változó elhárítása, valamint az utolsó <code>$campaign->update()</code> hívás köré helyezett try/catch védelem <em>failed</em> státusz esetére.',
             'en' => '<strong>Email campaign module — bug fix bundle (Pro):</strong> Several critical bugs in the email campaign send flow were fixed: correct use of the <code>is_subscribed</code> field (was: <code>newsletter</code>), use of the <code>full_name</code> accessor (instead of non-existent <code>name</code> column), removal of unused <code>$e</code> catch variable, and a try/catch wrapper around the final <code>$campaign->update()</code> call for the <em>failed</em> status case.'],
            ['hu' => '<strong>Kampány modal javítás:</strong> A kampány létrehozás és szerkesztés modaljain helytelen CSS osztály (<code>nf-modal-backdrop</code>) volt megadva, ami miatt a modalisablonok nem nyíltak meg. Javítva: <code>nf-overlay</code>.',
             'en' => '<strong>Campaign modal fix:</strong> The campaign create and edit modals had an incorrect CSS class (<code>nf-modal-backdrop</code>) that prevented them from opening. Fixed to <code>nf-overlay</code>.'],
            ['hu' => '<strong>Feliratkozók száma piszkozat kampányoknál:</strong> A kampány lista Fogadók oszlopa piszkozat állapotú kampányoknál korábban „—” jelet mutatott. Mostantól a valós hírlevél feliratkozók száma jelenik meg.',
             'en' => '<strong>Subscriber count for draft campaigns:</strong> The Recipients column in the campaign list previously showed "—" for draft campaigns. It now correctly displays the actual newsletter subscriber count.'],
            ['hu' => '<strong>Feladó cím javítása (<code>CampaignMail</code>):</strong> Az emailek küldésékor a feladó cím helytelenül, csonkítva jelent meg (pl. <code>admin@</code> domain nélkül). A <code>CampaignMail::envelope()</code> most explicitén a kampányban tárolt <code>from_email</code> és <code>from_name</code> értékeket használja (<code>Illuminate\\Mail\\Mailables\\Address</code> segítségével), config fallbackkel.',
             'en' => '<strong>Sender address fix (<code>CampaignMail</code>):</strong> When sending emails, the sender address appeared incorrectly truncated (e.g. <code>admin@</code> without domain). <code>CampaignMail::envelope()</code> now explicitly uses the campaign\'s stored <code>from_email</code> and <code>from_name</code> values (via <code>Illuminate\\Mail\\Mailables\\Address</code>), with config fallback.'],
            ['hu' => '<strong><code>failed_count</code> oszlop és ENUM bővítés (migráció):</strong> Két új migráció: az <code>email_campaigns</code> táblához hozzáadásra kerültek a <code>failed_count</code> (unsignedInteger, default 0) oszlop, valamint a <em>failed</em> státusz értéke az ENUM mezőhöz — raw <code>ALTER TABLE</code> SQL-lel, mivel a MySQL ENUM módosítás nem lehetséges Laravelblueprint-tel.',
             'en' => '<strong><code>failed_count</code> column and ENUM extension (migration):</strong> Two new migrations: the <code>failed_count</code> (unsignedInteger, default 0) column and the <em>failed</em> status value were added to the <code>email_campaigns</code> table — using raw <code>ALTER TABLE</code> SQL, as MySQL ENUM modification is not possible with Laravel Blueprint.'],
            ['hu' => '<strong>Duplikált migráció eltávolítása (Forge deployment fix):</strong> A <code>2026_05_08_190846_create_email_campaigns_table.php</code> migráció — amely lokálisan manuálisan volt hozzáadva az adatbázishoz — eltávolításra került a git repóból. A Forge szerveren ez a duplikált migráció <em>„table already exists"</em> hibával akadályozta a deployment-et.',
             'en' => '<strong>Duplicate migration removed (Forge deployment fix):</strong> The <code>2026_05_08_190846_create_email_campaigns_table.php</code> migration — which was manually added to the database locally — was removed from the git repository. On the Forge server, this duplicate migration was blocking deployment with a <em>"table already exists"</em> error.'],
            ['hu' => '<strong>Dashboard TypeError javítás (Windows / HU locale):</strong> A <code>/dashboard</code> oldal <code>TypeError: htmlspecialchars() array given</code> hibával omlott össze. Gyökérok: Windows fájlrendszer nem különbözteti meg a kis- és nagybetűket, ezért az <code>__("Dashboard")</code> hívás a <code>lang/hu/dashboard.php</code> fájlt (tömbként) adta vissza a várt szöveg helyett. Javítás: <code>__("nav.dashboard")</code> — mind a <code>dashboard.blade.php</code>, mind a <code>livewire/layout/navigation.blade.php</code> nézetekben.',
             'en' => '<strong>Dashboard TypeError fix (Windows / HU locale):</strong> The <code>/dashboard</code> page was crashing with <code>TypeError: htmlspecialchars() array given</code>. Root cause: the Windows filesystem is case-insensitive, so <code>__("Dashboard")</code> matched <code>lang/hu/dashboard.php</code> and returned the entire array instead of a string. Fix: <code>__("nav.dashboard")</code> — in both <code>dashboard.blade.php</code> and <code>livewire/layout/navigation.blade.php</code>.'],
            ['hu' => '<strong>Resend email integráció:</strong> A <code>config/services.php</code>-ben a <code>RESEND_API_KEY</code> env változó neve <code>RESEND_KEY</code>-re javítva a <code>.env</code> fájl tényleges változójának megfelelően. A Resend Laravel csomag mindkét config kulcsot ellenőrzi fallback-ként, így a javítás után az API kulcs helyesen töltődik be.',
             'en' => '<strong>Resend email integration:</strong> In <code>config/services.php</code>, the env variable name was corrected from <code>RESEND_API_KEY</code> to <code>RESEND_KEY</code> to match the actual <code>.env</code> file variable. The Resend Laravel package checks both config keys as fallback, so after the fix the API key loads correctly.'],
        ],
    ],

    [
        'version' => 'v1.10.0',
        'badge'   => [
            'text'  => ['hu' => 'Fejlesztés', 'en' => 'Improvement'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
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