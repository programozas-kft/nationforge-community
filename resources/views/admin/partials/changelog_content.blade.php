@php
$locale = app()->getLocale();

$versions = [

    [
        'version' => 'v1.25.0',
        'latest'  => true,
        'badge'   => [
            'text'  => ['hu' => 'AktuĂˇlis, LegĂşjabb', 'en' => 'Current, Latest'],
            'style' => 'background:rgba(10,179,156,0.1);color:#0ab39c;',
        ],
        'date' => ['hu' => '2026. mĂˇjus 17.', 'en' => 'May 17, 2026'],
        'items' => [
            ['hu' => '<strong>Google Calendar / iCal szinkronizĂˇciĂł:</strong> NyilvĂˇnos iCal feed (<code>/events.ics</code>) â€” az Ă¶sszes publikĂˇlt esemĂ©ny elĹ‘fizethetĹ‘vĂ© vĂˇlt bĂˇrmilyen naptĂˇralkalmazĂˇsban (Google Calendar, Apple Calendar, Outlook). Az IntegrĂˇciĂłk oldalon megjelenĹ‘ URL egyetlen kattintĂˇssal a Google NaptĂˇrba is hozzĂˇadhatĂł.',
             'en'  => '<strong>Google Calendar / iCal sync:</strong> Public iCal feed (<code>/events.ics</code>) â€” all published events are now subscribable in any calendar app (Google Calendar, Apple Calendar, Outlook). The URL shown on the Integrations page can be added to Google Calendar in a single click.'],
            ['hu' => '<strong>Facebook EsemĂ©ny kĂ¶zzĂ©tevĹ‘:</strong> A publikĂˇlt esemĂ©ny nĂ©zetĂ©ben megjelent egy <em>KĂ¶zzĂ©tesz Facebookon</em> gomb, amely a Graph API v19.0 segĂ­tsĂ©gĂ©vel lĂ©trehozza az esemĂ©nyt a beĂˇllĂ­tott Facebook Oldalon. Az IntegrĂˇciĂłk oldalon adhatĂł meg az Oldal ID Ă©s a Page Access Token.',
             'en'  => '<strong>Facebook Event publisher:</strong> A <em>Publish to Facebook</em> button appears on published event pages, creating the event on the configured Facebook Page via Graph API v19.0. The Page ID and Page Access Token are configured on the Integrations page.'],
            ['hu' => '<strong>Zapier & Make (Integromat) integrĂˇciĂł:</strong> A meglĂ©vĹ‘ kimenĹ‘ webhook rendszer (v1.24.0) az alapja. Az Ăşj IntegrĂˇciĂłk oldalon lĂ©pĂ©srĹ‘l lĂ©pĂ©sre ĂştmutatĂł mutatja, hogyan kell Zapier Catch Hook Ă©s Make Custom Webhook triggert Ă¶sszekapcsolni a NationForge-zal â€” kĂłd nĂ©lkĂĽl.',
             'en'  => '<strong>Zapier & Make (Integromat) integration:</strong> Built on the existing outgoing webhook system (v1.24.0). The new Integrations page provides a step-by-step guide on how to connect Zapier Catch Hook and Make Custom Webhook triggers to NationForge â€” no code required.'],
            ['hu' => '<strong>IntegrĂˇciĂłk menĂĽpont a sidebarban:</strong> Az Ă¶sszes kĂĽlsĹ‘ integrĂˇciĂł egy dedikĂˇlt <em>IntegrĂˇciĂłk</em> oldalon Ă©rhetĹ‘ el â€” Google Calendar URL mĂˇsolĂł, Facebook token beĂˇllĂ­tĂˇs Ă©s a Zapier/Make ĂştmutatĂł egy helyen.',
             'en'  => '<strong>Integrations menu item in sidebar:</strong> All external integrations are accessible from a dedicated <em>Integrations</em> page â€” Google Calendar URL copy, Facebook token configuration, and the Zapier/Make guide all in one place.'],
        ],
    ],

    [
        'version' => 'v1.24.0',
        'badge'   => [
            'text'  => ['hu' => 'Ăšj modul', 'en' => 'New module'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => '2026. mĂˇjus 17.', 'en' => 'May 17, 2026'],
        'items' => [
            ['hu' => '<strong>KimenĹ‘ webhookok:</strong> KonfigurĂˇlhatĂł HTTP POST kĂĽldĂ©s tetszĹ‘leges URL-re rendszeresemĂ©nyekre. 12 esemĂ©nytĂ­pus: <code>contact.*</code>, <code>event.*</code>, <code>donation.created</code>, <code>campaign.sent</code>, <code>task.*</code>, <code>drip.enrolled</code>. HMAC-SHA256 alĂˇĂ­rĂˇs (<code>X-NationForge-Signature</code>). KĂ©zbesĂ­tĂ©si naplĂł per-kĂ­sĂ©rlet stĂˇtusszal, HTTP kĂłddal Ă©s vĂˇlasz tĂ¶rzzsel. Automatikus ĂşjrakĂ­sĂ©rlet (3 alkalom, 60 mĂˇsodperces visszatartĂˇssal) queue-n. Sikertelen kĂ©zbesĂ­tĂ©sek manuĂˇlis ĂşjrakĂĽldĂ©se az admin felĂĽletrĹ‘l.',
             'en'  => '<strong>Outgoing webhooks:</strong> Configurable HTTP POST to any URL on system events. 12 event types: <code>contact.*</code>, <code>event.*</code>, <code>donation.created</code>, <code>campaign.sent</code>, <code>task.*</code>, <code>drip.enrolled</code>. HMAC-SHA256 signing (<code>X-NationForge-Signature</code>). Delivery log with per-attempt status, HTTP code and response body. Automatic retry (3 attempts, 60 s backoff) via queue. Manual retry for failed deliveries from the admin UI.'],
        ],
    ],

    [
        'version' => 'v1.23.0',
        'badge'   => [
            'text'  => ['hu' => 'FejlesztĂ©s', 'en' => 'Improvement'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => '2026. mĂˇjus 17.', 'en' => 'May 17, 2026'],
        'items' => [
            ['hu' => '<strong>TĂ¶bbnyelvĹ± sĂşgĂł (DE / RO / SK):</strong> A sĂşgĂłdokumentĂˇciĂł immĂˇr Ă¶t nyelven Ă©rhetĹ‘ el: magyar, angol, <em>nĂ©met, romĂˇn Ă©s szlovĂˇk</em>. Mind a 16 sĂşgĂłcikk teljes szĂ¶vege le van fordĂ­tva. A nyelvvĂˇltĂł a sĂşgĂł oldalsĂˇvjĂˇban Ă©rhetĹ‘ el â€” a kivĂˇlasztott nyelv azonnal Ă©rvĂ©nyes.',
             'en'  => '<strong>Multilingual help (DE / RO / SK):</strong> The help documentation is now available in five languages: Hungarian, English, <em>German, Romanian and Slovak</em>. All 16 help articles are fully translated. The language switcher is available in the help sidebar â€” the selected language takes effect immediately.'],
            ['hu' => '<strong>AdatbĂˇzis-sĂ©ma bĹ‘vĂ­tĂ©se:</strong> A <code>help_articles</code> tĂˇblĂˇhoz hat Ăşj nullable szĂ¶veges oszlop adĂłdott: <code>title_de</code>, <code>content_de</code>, <code>title_ro</code>, <code>content_ro</code>, <code>title_sk</code>, <code>content_sk</code>.',
             'en'  => '<strong>Database schema extension:</strong> Six new nullable text columns were added to the <code>help_articles</code> table: <code>title_de</code>, <code>content_de</code>, <code>title_ro</code>, <code>content_ro</code>, <code>title_sk</code>, <code>content_sk</code>.'],
            ['hu' => '<strong>SĂşgĂłszerkesztĹ‘ â€” DE / RO / SK fĂĽlek:</strong> Az admin sĂşgĂłkezelĹ‘ szerkesztĹ‘ modĂˇljĂˇban megjelent a Deutsch, RomĂ˘nÄ Ă©s SlovenÄŤina fĂĽl, Ă­gy az Ă¶sszes nyelvi tartalom egy helyen szerkeszthetĹ‘.',
             'en'  => '<strong>Help editor â€” DE / RO / SK tabs:</strong> The admin help editor modal now includes Deutsch, RomĂ˘nÄ and SlovenÄŤina tabs, allowing all language content to be edited from one place.'],
            ['hu' => '<strong>KĂ©pek szinkronizĂˇlĂˇsa minden nyelvre:</strong> A <code>HelpSyncImagesAllLangsSeeder</code> minden olyan cikknĂ©l, amelynek magyar tartalma kĂ©pernyĹ‘kĂ©ppel kezdĹ‘dik, automatikusan elĹ‘rĂ©szĂ­ti ugyanazt a kĂ©pet a DE / RO / SK tartalomba is â€” duplikĂˇciĂł nĂ©lkĂĽl.',
             'en'  => '<strong>Image sync across all languages:</strong> The <code>HelpSyncImagesAllLangsSeeder</code> automatically prepends the same screenshot to DE / RO / SK content for every article whose Hungarian content starts with a screenshot image â€” without duplication.'],
        ],
    ],

    [
        'version' => 'v1.22.0',
        'badge'   => [
            'text'  => ['hu' => 'FejlesztĂ©s', 'en' => 'Improvement'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => '2026. mĂˇjus 16.', 'en' => 'May 16, 2026'],
        'items' => [
            ['hu' => '<strong>Email megnyitĂˇs nyomon kĂ¶vetĂ©se (tracking pixel):</strong> Minden elkĂĽldĂ¶tt kampĂˇnylevĂ©lbe Ă©s drip-levĂ©lbe egy lĂˇthatatlan 1Ă—1 pixeles GIF-kĂ©p kerĂĽl. Ha a fogadĂł megnyitja az emailt, a kĂ©p lekĂ©rĂ©se rĂ¶gzĂ­ti a megnyitĂˇs tĂ©nyĂ©t. Az <code>email_sends</code> Ă©s <code>drip_sends</code> tĂˇblĂˇkhoz <code>opened_at</code> (nullable timestamp) mezĹ‘ adĂłdott; a kampĂˇny Ă¶sszesĂ­tĹ‘ <code>opened_count</code> szĂˇmlĂˇlĂłja automatikusan nĂ¶vekszik.',
             'en'  => '<strong>Email open tracking (pixel):</strong> Every sent campaign email and drip email now contains an invisible 1Ă—1 GIF image. When the recipient opens the email, the image request records the open event. An <code>opened_at</code> (nullable timestamp) column was added to <code>email_sends</code> and <code>drip_sends</code>; the campaign summary <code>opened_count</code> counter increments automatically.'],
            ['hu' => '<strong>Link-kattintĂˇs nyomon kĂ¶vetĂ©se:</strong> Az emailben lĂ©vĹ‘ Ă¶sszes kĂĽlsĹ‘ link egy ĂˇtirĂˇnyĂ­tĂł proxy URL-en keresztĂĽl kerĂĽl kiszolgĂˇlĂˇsra (<code>/track/click/{token}?to=...</code>). KattintĂˇskor a rendszer rĂ¶gzĂ­ti a <code>clicked_at</code> idĹ‘pontot Ă©s nĂ¶veli a kampĂˇny <code>clicked_count</code> szĂˇmlĂˇlĂłjĂˇt, majd ĂˇtirĂˇnyĂ­t az eredeti cĂ©lra. Az unsubscribe Ă©s nyomkĂ¶vetĂ©si linkek kizĂˇrva az ĂˇtĂ­rĂˇsbĂłl.',
             'en'  => '<strong>Link click tracking:</strong> All external links in emails are served through a redirect proxy URL (<code>/track/click/{token}?to=...</code>). On click, the system records the <code>clicked_at</code> timestamp and increments the campaign\'s <code>clicked_count</code> counter, then redirects to the original destination. Unsubscribe and tracking links are excluded from rewriting.'],
            ['hu' => '<strong>MegnyitĂˇsok Ă©s kattintĂˇsok megjelenĂ­tĂ©se a kampĂˇnylistĂˇban:</strong> Az Email kampĂˇnyok tĂˇblĂˇzatĂˇban kĂ©t Ăşj oszlop jelent meg: <em>MegnyitĂˇsok</em> (abszolĂşt szĂˇm + szĂˇzalĂ©kos arĂˇny) Ă©s <em>KattintĂˇsok</em> â€” zĂ¶ld kiemelĹ‘ szĂ­nnel. A statisztikĂˇk valĂłs adatbĂˇzis-adatokon alapulnak.',
             'en'  => '<strong>Opens and clicks displayed in campaign list:</strong> Two new columns appear in the Email Campaigns table: <em>Opens</em> (absolute count + percentage rate) and <em>Clicks</em> â€” highlighted in green. Statistics are based on live database data.'],
            ['hu' => '<strong>EmailTrackingService:</strong> Ăšj <code>App\\Services\\EmailTrackingService</code> osztĂˇly, amely egysĂ©gesen kezeli a link-csomagolĂˇst (<code>wrapLinks()</code>), a pixel-befĹ±zĂ©st (<code>injectPixel()</code>) Ă©s a teljes folyamatot (<code>process()</code>). A base64-kĂłdolt GIF konstanskĂ©nt tĂˇrolĂłdik â€” sem fĂˇjlrendszer, sem HTTP-lekĂ©rĂ©s nem szĂĽksĂ©ges a pixelhez.',
             'en'  => '<strong>EmailTrackingService:</strong> New <code>App\\Services\\EmailTrackingService</code> class that uniformly handles link wrapping (<code>wrapLinks()</code>), pixel injection (<code>injectPixel()</code>) and the full pipeline (<code>process()</code>). The base64-encoded GIF is stored as a constant â€” no filesystem or HTTP request needed for the pixel.'],
            ['hu' => '<strong>TrackingController (nyilvĂˇnos vĂ©gpontok):</strong> <code>GET /track/open/{token}</code> â€” visszaadja a GIF pixelt Ă©s frissĂ­ti az <code>opened_at</code> mezĹ‘t; <code>GET /track/click/{token}?to=URL</code> â€” ĂˇtirĂˇnyĂ­t a cĂ©lra Ă©s frissĂ­ti a <code>clicked_at</code> mezĹ‘t. BiztonsĂˇgi ellenĹ‘rzĂ©s: a <code>to</code> paramĂ©ter csak Ă©rvĂ©nyes abszolĂşt URL esetĂ©n kerĂĽl ĂˇtirĂˇnyĂ­tĂˇsra (<code>FILTER_VALIDATE_URL</code>).',
             'en'  => '<strong>TrackingController (public endpoints):</strong> <code>GET /track/open/{token}</code> â€” returns the GIF pixel and updates the <code>opened_at</code> field; <code>GET /track/click/{token}?to=URL</code> â€” redirects to the destination and updates the <code>clicked_at</code> field. Security check: the <code>to</code> parameter is only redirected for valid absolute URLs (<code>FILTER_VALIDATE_URL</code>).'],
        ],
    ],

    [
        'version' => 'v1.21.0',
        'badge'   => [
            'text'  => ['hu' => 'FejlesztĂ©s', 'en' => 'Improvement'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => '2026. mĂˇjus 16.', 'en' => 'May 16, 2026'],
        'items' => [
            ['hu' => '<strong>EgyĂ©rintĂ©ses leiratkozĂˇsi oldal (publikus):</strong> Minden hĂ­rlevĂ©l-feliratkozĂłnak egyedi <code>unsubscribe_token</code> kerĂĽl generĂˇlĂˇsra (meglĂ©vĹ‘ rekordokra visszatĂ¶ltĹ‘ migrĂˇciĂł is fut). Az emailekben megjelenik az <em>LeiratkozĂˇs / Unsubscribe</em> hivatkozĂˇs, amely az <code>/unsubscribe/{token}</code> oldalra vezet. Az oldal 4 Ăˇllapotot kezel: aktĂ­v feliratkozĂł / leiratkozott / visszairatkozĂˇs opciĂł / ismeretlen token.',
             'en'  => '<strong>One-click unsubscribe page (public):</strong> Every newsletter subscriber receives a unique <code>unsubscribe_token</code> (a backfill migration runs for existing records). Emails now include an <em>Unsubscribe</em> link pointing to <code>/unsubscribe/{token}</code>. The page handles 4 states: active subscriber / unsubscribed / re-subscribe option / unknown token.'],
            ['hu' => '<strong>RFC 8058 <code>List-Unsubscribe</code> fejlĂ©cek:</strong> Az elkĂĽldĂ¶tt emailek tartalmazzĂˇk a <code>List-Unsubscribe</code> Ă©s <code>List-Unsubscribe-Post: List-Unsubscribe=One-Click</code> fejlĂ©ceket a Symfony <code>using:</code> callback-en keresztĂĽl. Ez lehetĹ‘vĂ© teszi a modernebb levelezĹ‘k (Gmail, Outlook) szĂˇmĂˇra, hogy egy kattintĂˇssal leiratkozĂˇsi gombot jelenĂ­tsenek meg.',
             'en'  => '<strong>RFC 8058 <code>List-Unsubscribe</code> headers:</strong> Sent emails now include <code>List-Unsubscribe</code> and <code>List-Unsubscribe-Post: List-Unsubscribe=One-Click</code> headers via a Symfony <code>using:</code> callback. This allows modern email clients (Gmail, Outlook) to render a one-click unsubscribe button.'],
            ['hu' => '<strong>VisszairatkozĂˇsi lehetĹ‘sĂ©g:</strong> A leiratkozott Ăˇllapotban az oldal egy <em>VisszairatkozĂˇs</em> gombot is megjelenĂ­t. A visszairatkozĂˇs egy kĂĽlĂ¶n POST vĂ©gponton (<code>/unsubscribe/{token}/resubscribe</code>) keresztĂĽl valĂłsul meg, Ă©s az <code>is_subscribed</code> Ă©rtĂ©ket <code>true</code>-ra ĂˇllĂ­tja.',
             'en'  => '<strong>Re-subscribe option:</strong> On the unsubscribed state, the page also shows a <em>Re-subscribe</em> button. Re-subscribing is handled through a separate POST endpoint (<code>/unsubscribe/{token}/resubscribe</code>) that sets <code>is_subscribed</code> back to <code>true</code>.'],
        ],
    ],

    [
        'version' => 'v1.20.0',
        'badge'   => [
            'text'  => ['hu' => 'Ăšj modul', 'en' => 'New module'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => '2026. mĂˇjus 16.', 'en' => 'May 16, 2026'],
        'items' => [
            ['hu' => '<strong>AutomatizĂˇlt csepp (drip) kampĂˇny modul:</strong> Ăšj <code>/admin/drip-campaigns</code> oldal. Minden drip kampĂˇnyhoz tetszĹ‘leges szĂˇmĂş lĂ©pĂ©s adhatĂł meg â€” tĂˇrgy, feladĂł, HTML tartalom, Ă©s az elĹ‘zĹ‘ lĂ©pĂ©stĹ‘l eltelt napok szĂˇma. IndĂ­tĂłk: <em>ManuĂˇlis</em>, <em>Csoporthoz csatlakozĂˇs</em>, <em>Tag hozzĂˇadĂˇs</em>.',
             'en'  => '<strong>Automated drip campaign module:</strong> New <code>/admin/drip-campaigns</code> page. Each drip campaign supports an unlimited number of steps â€” subject, sender, HTML content, and delay in days from the previous step. Triggers: <em>Manual</em>, <em>Group join</em>, <em>Tag added</em>.'],
            ['hu' => '<strong>Drip beiratkozĂˇs Ă©s feldolgozĂˇs:</strong> Kontaktok manuĂˇlisan (admin gomb) vagy automatikusan (trigger) iratkozhatnak be egy drip kampĂˇnyba. Az <code>drip:process</code> Artisan parancs 15 percenkĂ©nt fut: megkeresi az esedĂ©kes beiratkozĂˇsokat, elkĂĽldi a kĂ¶vetkezĹ‘ lĂ©pĂ©st, Ă©s beĂˇllĂ­tja a kĂ¶vetkezĹ‘ kĂĽldĂ©si idĹ‘pontot. A kampĂˇny vĂ©geztĂ©vel a beiratkozĂˇs <em>completed</em> stĂˇtuszt kap.',
             'en'  => '<strong>Drip enrollment and processing:</strong> Contacts can enroll in a drip campaign manually (admin button) or automatically (via trigger). The <code>drip:process</code> Artisan command runs every 15 minutes: it finds due enrollments, sends the next step, and sets the next send time. When the campaign ends, the enrollment receives <em>completed</em> status.'],
            ['hu' => '<strong>Drip kampĂˇny admin felĂĽlet:</strong> A rĂ©szletoldalon 4 statisztikai kĂˇrtya (aktĂ­v / lezĂˇrt / lemondott beiratkozĂˇsok, Ă¶sszes lĂ©pĂ©s), szerkeszthetĹ‘ lĂ©pĂ©slista modal alapon, beiratkozĂˇsok listĂˇja emberenkĂ©nt Ă©s lĂ©pĂ©senkĂ©nt. KampĂˇny aktivĂˇlĂˇsa / szĂĽneteltetĂ©se egy kattintĂˇssal.',
             'en'  => '<strong>Drip campaign admin interface:</strong> The detail page shows 4 stat cards (active / completed / cancelled enrollments, total steps), editable step list via modals, and enrollments list per person and per step. Campaign activation / pausing with a single click.'],
            ['hu' => '<strong>AdatbĂˇzis-sĂ©ma:</strong> HĂˇrom Ăşj tĂˇbla: <code>drip_campaigns</code> (kampĂˇny fejadatok, trigger tĂ­pus Ă©s cĂ©l-csoport/tag), <code>drip_steps</code> (lĂ©pĂ©sek pozĂ­ciĂł szerint rendezve), <code>drip_enrollments</code> (beiratkozĂˇsok stĂˇtusszal, <code>next_send_at</code> indexszel), valamint <code>drip_sends</code> (kĂĽldĂ©si nyomkĂ¶vetĂ©s, tracking tokennel).',
             'en'  => '<strong>Database schema:</strong> Three new tables: <code>drip_campaigns</code> (campaign header, trigger type and target group/tag), <code>drip_steps</code> (steps ordered by position), <code>drip_enrollments</code> (enrollments with status, <code>next_send_at</code> index), and <code>drip_sends</code> (send tracking with tracking token).'],
        ],
    ],

    [
        'version' => 'v1.19.0',
        'badge'   => [
            'text'  => ['hu' => 'FejlesztĂ©s', 'en' => 'Improvement'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => '2026. mĂˇjus 16.', 'en' => 'May 16, 2026'],
        'items' => [
            ['hu' => '<strong>KampĂˇny cĂ©lcsoport szegmentĂˇlĂˇs:</strong> A kampĂˇny lĂ©trehozĂˇs Ă©s szerkesztĂ©s modalban megjelent a <em>CĂ©lcsoport</em> szekciĂł. Az admin nĂ©gy opciĂł kĂ¶zĂĽl vĂˇlaszthat: <em>Ă–sszes hĂ­rlevĂ©l feliratkozĂł</em>, <em>Csoport tagjai</em> (tĂ¶bb csoport is kijelĂ¶lhetĹ‘), <em>Tagelt kontaktok</em> (tĂ¶bb tag), <em>Tag stĂˇtusz szerint</em> (tĂ¶bb stĂˇtusz). A szĹ±rĹ‘kombinĂˇciĂł JSON formĂˇban tĂˇrolĂłdik az <code>email_campaigns.segment_filters</code> oszlopban.',
             'en'  => '<strong>Campaign audience segmentation:</strong> A <em>Audience</em> section appeared in the campaign create and edit modal. Admins can choose from four options: <em>All newsletter subscribers</em>, <em>Group members</em> (multiple groups selectable), <em>Tagged contacts</em> (multiple tags), <em>By member status</em> (multiple statuses). The filter combination is stored as JSON in the <code>email_campaigns.segment_filters</code> column.'],
            ['hu' => '<strong>Ă‰lĹ‘ fogadĂłszĂˇm elĹ‘nĂ©zet:</strong> SzegmentĂˇciĂłs beĂˇllĂ­tĂˇs mĂłdosĂ­tĂˇsakor az oldal AJAX-on keresztĂĽl (<code>GET /admin/campaigns/recipient-count</code>) valĂłs idĹ‘ben kĂ©ri le a becsĂĽlt fogadĂłk szĂˇmĂˇt, Ă©s 500 ms-os debounce-szal jelenĂ­ti meg. A kampĂˇnylistĂˇban megjelent a <em>Szegmens</em> oszlop a tĂ­pus jelzĂ©sĂ©vel.',
             'en'  => '<strong>Live recipient count preview:</strong> When the segmentation setting changes, the page fetches the estimated recipient count in real time via AJAX (<code>GET /admin/campaigns/recipient-count</code>) with a 500 ms debounce, and displays it immediately. A <em>Segment</em> column appeared in the campaign list indicating the type.'],
            ['hu' => '<strong><code>buildRecipientsQuery()</code> metĂłdus az <code>EmailCampaign</code> modellen:</strong> EgysĂ©ges lekĂ©rdezĂ©s-Ă©pĂ­tĹ‘, amely a <code>segment_filters</code> JSON alapjĂˇn szĹ±ri a feliratkozott, Ă©rvĂ©nyes email-lel rendelkezĹ‘ kontaktokat â€” csoportszĹ±rĹ‘ esetĂ©n <code>whereHas(\'groups\')</code>, tagszĹ±rĹ‘nĂ©l <code>whereHas(\'tags\')</code>, stĂˇtuszszĹ±rĹ‘nĂ©l <code>whereIn(\'status\')</code>.',
             'en'  => '<strong><code>buildRecipientsQuery()</code> method on <code>EmailCampaign</code> model:</strong> A unified query builder that filters subscribed contacts with valid emails based on the <code>segment_filters</code> JSON â€” using <code>whereHas(\'groups\')</code> for group filter, <code>whereHas(\'tags\')</code> for tag filter, <code>whereIn(\'status\')</code> for status filter.'],
        ],
    ],

    [
        'version' => 'v1.18.0',
        'badge'   => [
            'text'  => ['hu' => 'FejlesztĂ©s', 'en' => 'Improvement'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => '2026. mĂˇjus 16.', 'en' => 'May 16, 2026'],
        'items' => [
            ['hu' => '<strong>Email sablonkĂ¶nyvtĂˇr:</strong> Ăšj <code>/admin/email-templates</code> oldal, amely kĂˇrtyĂˇs elrendezĂ©sben mutatja a beĂ©pĂ­tett (<em>MinimĂˇl, HĂ­rlevĂ©l, BejelentĂ©s, PromĂłciĂłs</em>) Ă©s az egyĂ©ni sablonokat. Minden sablon szerkeszthetĹ‘, elĹ‘nĂ©zhetĹ‘ (iframe modal) Ă©s tĂ¶rlhetĹ‘ (kivĂ©ve a beĂ©pĂ­tetteket).',
             'en'  => '<strong>Email template library:</strong> New <code>/admin/email-templates</code> page displaying built-in (<em>Minimal, Newsletter, Announcement, Promotional</em>) and custom templates in card layout. Every template can be edited, previewed (iframe modal) and deleted (except built-ins).'],
            ['hu' => '<strong>Sablon betĂ¶ltĂ©se a kampĂˇnyszerkesztĹ‘be:</strong> A kampĂˇny lĂ©trehozĂˇs Ă©s szerkesztĂ©s modalban megjelent a <em>â€žSablon betĂ¶ltĂ©se"</em> gomb. Megnyit egy sablonvĂˇlasztĂł modalt, amelybĹ‘l egy kattintĂˇssal a kivĂˇlasztott sablon HTML tartalma betĂ¶ltĹ‘dik a szerkesztĹ‘be. Az Ă¶sszes elĂ©rhetĹ‘ sablon listaszerĹ±en Ă©s rĂ©szletes elĹ‘nĂ©zettel tekinthetĹ‘ meg.',
             'en'  => '<strong>Loading a template into the campaign editor:</strong> A <em>"Use template"</em> button appeared in the campaign create and edit modal. It opens a template picker modal, from which a single click loads the selected template\'s HTML content into the editor. All available templates are listed with a detailed preview.'],
            ['hu' => '<strong>BeĂ©pĂ­tett sablonok (seeder):</strong> A telepĂ­tĂ©skor 4 professzionĂˇlis beĂ©pĂ­tett sablon kerĂĽl az adatbĂˇzisba automatikusan, amelyek szervezeti arculathoz testreszabhatĂłk. Az <code>email_templates</code> tĂˇbla tartalmazza: <code>name</code>, <code>description</code>, <code>category</code>, <code>body_html</code>, <code>is_system</code> (boolean) mezĹ‘ket.',
             'en'  => '<strong>Built-in templates (seeder):</strong> At installation, 4 professional built-in templates are automatically inserted into the database and can be customized for organizational branding. The <code>email_templates</code> table contains: <code>name</code>, <code>description</code>, <code>category</code>, <code>body_html</code>, <code>is_system</code> (boolean) columns.'],
        ],
    ],

    [
        'version' => 'v1.17.0',
        'badge'   => [
            'text'  => ['hu' => 'FejlesztĂ©s', 'en' => 'Improvement'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => '2026. mĂˇjus 16.', 'en' => 'May 16, 2026'],
        'items' => [
            ['hu' => '<strong>AdomĂˇny export kĂ¶nyvelĂ©shez (CSV, XLSX, PDF):</strong> Az AdomĂˇnyok oldalon megjelent az <em>Export</em> gomb. Az exportĂˇlĂˇs szĹ±rhetĹ‘: kezdĂ©si Ă©s befejezĂ©si dĂˇtum, pĂ©nznem. HĂˇrom formĂˇtum Ă©rhetĹ‘ el: CSV (UTF-8 BOM, pontosvesszĹ‘s), Excel (XLSX, fĂ©lkĂ¶vĂ©r fejlĂ©c) Ă©s PDF (tĂˇblĂˇzatos elrendezĂ©s). A <code>phpoffice/phpspreadsheet</code> kezeli az XLSX-t, a <code>dompdf/dompdf</code> a PDF-t.',
             'en'  => '<strong>Donation export for accounting (CSV, XLSX, PDF):</strong> An <em>Export</em> button appeared on the Donations page. Export is filterable by start date, end date and currency. Three formats are available: CSV (UTF-8 BOM, semicolon-separated), Excel (XLSX, bold header) and PDF (tabular layout). <code>phpoffice/phpspreadsheet</code> handles XLSX; <code>dompdf/dompdf</code> handles PDF.'],
            ['hu' => '<strong>ExportĂˇlt mezĹ‘k:</strong> DĂˇtum, Kapcsolat neve, Email, Ă–sszeg, PĂ©nznem, FizetĂ©si mĂłdszer, StĂˇtusz, TranzakciĂł ID, KampĂˇny, MegjegyzĂ©s â€” ezek a kĂ¶nyvelĂ©si feldolgozĂˇshoz szĂĽksĂ©ges legfontosabb adatok kerĂĽlnek exportĂˇlĂˇsra.',
             'en'  => '<strong>Exported fields:</strong> Date, Contact name, Email, Amount, Currency, Payment method, Status, Transaction ID, Campaign, Notes â€” these essential data points needed for accounting processing are exported.'],
        ],
    ],

    [
        'version' => 'v1.16.0',
        'badge'   => [
            'text'  => ['hu' => 'FejlesztĂ©s', 'en' => 'Improvement'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => '2026. mĂˇjus 16.', 'en' => 'May 16, 2026'],
        'items' => [
            ['hu' => '<strong>NyilvĂˇnos online adomĂˇnyozĂˇsi oldal:</strong> A <code>/donate</code> URL bejelentkezĂ©s nĂ©lkĂĽl elĂ©rhetĹ‘ adomĂˇnyozĂˇsi Ĺ±rlapot jelenĂ­t meg â€” adomĂˇnyozĂł neve, email, Ă¶sszeg, pĂ©nznem, megjegyzĂ©s mezĹ‘kkel. Sikeres kĂĽldĂ©s utĂˇn visszaigazolĂł email megy az adomĂˇnyozĂłnak (<em>DonationReceiptMail</em>), Ă©s megjelenik egy kĂ¶szĂ¶nĹ‘ oldal (<code>/donate/thanks/{token}</code>).',
             'en'  => '<strong>Public online donation form:</strong> The <code>/donate</code> URL displays a donation form accessible without login â€” with donor name, email, amount, currency and notes fields. On successful submission, a receipt email is sent to the donor (<em>DonationReceiptMail</em>), and a thank-you page appears (<code>/donate/thanks/{token}</code>).'],
            ['hu' => '<strong>Online fizetĂ©s Stripe / Barion integrĂˇciĂłval:</strong> A nyilvĂˇnos adomĂˇnyozĂˇsi oldal tĂˇmogatja a bankkĂˇrtyĂˇs fizetĂ©st. Stripe esetĂ©n a rendszer egy Checkout Session-t hoz lĂ©tre, Ă©s a visszatĂ©rĂ©si URL-en (<code>/payment/donation/stripe/success/{token}</code>) igazolja a fizetĂ©st. Barion integrĂˇciĂł szintĂ©n elĂ©rhetĹ‘ (<code>/payment/donation/barion/callback/{token}</code>).',
             'en'  => '<strong>Online payment with Stripe / Barion integration:</strong> The public donation form supports card payments. For Stripe, the system creates a Checkout Session and verifies the payment on the return URL (<code>/payment/donation/stripe/success/{token}</code>). Barion integration is also available (<code>/payment/donation/barion/callback/{token}</code>).'],
        ],
    ],

    [
        'version' => 'v1.15.0',
        'badge'   => [
            'text'  => ['hu' => 'FejlesztĂ©s', 'en' => 'Improvement'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => '2026. mĂˇjus 16.', 'en' => 'May 16, 2026'],
        'items' => [
            ['hu' => '<strong>Feladat megjegyzĂ©sek:</strong> Minden feladathoz szĂ¶veges megjegyzĂ©sek fĹ±zhetĹ‘k, megjelenĂ­tve az idĹ‘pontot Ă©s a bekĂĽldĹ‘ felhasznĂˇlĂłt. A megjegyzĂ©sek szerkeszthetĹ‘k Ă©s tĂ¶rĂ¶lhetĹ‘k. Az adatokat a <code>task_comments</code> tĂˇbla tĂˇrolja.',
             'en'  => '<strong>Task comments:</strong> Text comments can be added to every task, showing the timestamp and the submitting user. Comments can be edited and deleted. Data is stored in the <code>task_comments</code> table.'],
            ['hu' => '<strong>Feladat fĂˇjlmellĂ©kletek:</strong> Feladatokhoz fĂˇjlok csatolhatĂłk (max. 10 MB) â€” a <code>task_attachments</code> tĂˇbla Ă©s a Spatie MediaLibrary kezeli a tĂˇrolĂˇst. A mellĂ©klet neve, mĂ©rete Ă©s feltĂ¶ltĂ©si ideje megjelenik a feladat rĂ©szletoldalĂˇn; letĂ¶lthetĹ‘ Ă©s tĂ¶rĂ¶lhetĹ‘.',
             'en'  => '<strong>Task file attachments:</strong> Files can be attached to tasks (max. 10 MB) â€” the <code>task_attachments</code> table and Spatie MediaLibrary handle storage. The attachment name, size and upload time appear on the task detail page; files are downloadable and deletable.'],
            ['hu' => '<strong>Gantt-stĂ­lusĂş idĹ‘vonal nĂ©zet (Projektek):</strong> A projekt rĂ©szletoldalĂˇn megjelent egy <em>Gantt nĂ©zet</em> fĂĽl. A nĂ©zet az Ă¶sszes projekt-feladatot az idĹ‘vonalĂˇn helyezi el â€” vĂ­zszintes sĂˇv mutatja a kezdĂ©si Ă©s befejezĂ©si dĂˇtumot, hatĂˇridĹ‘n tĂşl esetĂ©n piros kiemelĂ©s.',
             'en'  => '<strong>Gantt-style timeline view (Projects):</strong> A <em>Gantt view</em> tab appeared on the project detail page. The view places all project tasks on a timeline â€” a horizontal bar shows the start and end date, with red highlighting for overdue tasks.'],
        ],
    ],

    [
        'version' => 'v1.14.0',
        'badge'   => [
            'text'  => ['hu' => 'FejlesztĂ©s', 'en' => 'Improvement'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => '2026. mĂˇjus 16.', 'en' => 'May 16, 2026'],
        'items' => [
            ['hu' => '<strong>NĂ©met (DE), RomĂˇn (RO) Ă©s SzlovĂˇk (SK) nyelvcsomag:</strong> Az admin felĂĽlet teljes szĂ¶veggel bĹ‘vĂĽlt hĂˇrom Ăşj nyelvvel. A <code>lang/de/</code>, <code>lang/ro/</code> Ă©s <code>lang/sk/</code> mappĂˇkban az Ă¶sszes modul fordĂ­tĂˇsa elĂ©rhetĹ‘ (<code>common</code>, <code>nav</code>, <code>people</code>, <code>events</code>, <code>groups</code>, <code>donations</code>, <code>campaigns</code>, <code>projects</code>, <code>tasks</code>, <code>users</code>, <code>settings</code>, <code>help</code>, <code>changelog</code> stb.).',
             'en'  => '<strong>German (DE), Romanian (RO) and Slovak (SK) language packs:</strong> The admin panel was extended with three new languages with full text coverage. All module translations are available in <code>lang/de/</code>, <code>lang/ro/</code> and <code>lang/sk/</code> folders (<code>common</code>, <code>nav</code>, <code>people</code>, <code>events</code>, <code>groups</code>, <code>donations</code>, <code>campaigns</code>, <code>projects</code>, <code>tasks</code>, <code>users</code>, <code>settings</code>, <code>help</code>, <code>changelog</code>, etc.).'],
            ['hu' => '<strong>NyelvvĂˇltĂł frissĂ­tĂ©se:</strong> Az oldalsĂˇv HU/EN kapcsolĂłja kiegĂ©szĂĽlt a DE, RO Ă©s SK zĂˇszlĂłkkal (<code>fi fi-de</code>, <code>fi fi-ro</code>, <code>fi fi-sk</code> SVG ikonok, flag-icons kĂ¶nyvtĂˇr). A locale-vĂˇltĂł vĂ©gpont vĂˇltozatlan: <code>/locale/{locale}</code>.',
             'en'  => '<strong>Language switcher updated:</strong> The HU/EN sidebar switcher was extended with DE, RO and SK flags (<code>fi fi-de</code>, <code>fi fi-ro</code>, <code>fi fi-sk</code> SVG icons, flag-icons library). The locale-switch endpoint is unchanged: <code>/locale/{locale}</code>.'],
        ],
    ],

    [
        'version' => 'v1.13.0',
        'badge'   => [
            'text'  => ['hu' => 'FejlesztĂ©s', 'en' => 'Improvement'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => '2026. mĂˇjus 12.', 'en' => 'May 12, 2026'],
        'items' => [
            ['hu' => '<strong>EsemĂ©ny bejelentkezĂ©s QR-kĂłddal:</strong> Minden regisztrĂˇciĂłhoz egyedi QR-kĂłd generĂˇlĂłdik JavaScript alapon (CDN: <code>qrcode.js</code>), amelyet a rĂ©sztvevĹ‘ a sajĂˇt jegy oldalĂˇn (<code>/e/ticket/{token}</code>) tekinthet meg. Az admin panel esemĂ©ny rĂ©szletoldalĂˇn megjelent a <em>BejelentkezĂ©s (ideje)</em> oszlop Ă©s egy <em>QR Szkenner</em> gomb. A szkenner oldal (<code>/admin/events/{id}/checkin</code>) kameraalapĂş QR-beolvasĂˇst tesz lehetĹ‘vĂ© (<code>html5-qrcode</code> CDN, <code>v2.3.8</code>), valĂłs idejĹ± visszajelzĂ©ssel (sikeres / mĂˇr bejelentkezett / ismeretlen token). ManuĂˇlis token-beviteli mezĹ‘ is elĂ©rhetĹ‘. Az <code>event_registrations</code> tĂˇblĂˇhoz <code>checked_in_at</code> (nullable timestamp) oszlop adĂłdott. Statisztikai Ă¶sszesĂ­tĹ‘ sor: Ă¶sszesen / bejelentkezett / mĂ©g nem Ă©rkezett meg.',
             'en'  => '<strong>Event check-in via QR code:</strong> Every registration now has a unique JavaScript-generated QR code (CDN: <code>qrcode.js</code>) accessible on the attendee\'s personal ticket page (<code>/e/ticket/{token}</code>). The admin event detail page now shows a <em>Check-in (time)</em> column and a <em>QR Scanner</em> button. The scanner page (<code>/admin/events/{id}/checkin</code>) supports camera-based QR scanning (<code>html5-qrcode</code> CDN v2.3.8) with real-time feedback (success / already checked in / unknown token). A manual token input field is also available. A <code>checked_in_at</code> (nullable timestamp) column was added to <code>event_registrations</code>. Summary row shows: total / checked in / not yet arrived.'],
            ['hu' => '<strong>BelĂ©pĹ‘jegy oldal (publikus):</strong> Sikeres regisztrĂˇciĂł utĂˇn a megerĹ‘sĂ­tĹ‘ oldalon megjelenik a <em>â€žJegyem megtekintĂ©se"</em> gomb (token session flash alapjĂˇn). A jegy oldala tartalmazza az esemĂ©ny adatait, a rĂ©sztvevĹ‘ nevĂ©t, kĂ­sĂ©rĹ‘k szĂˇmĂˇt, Ă©s a QR-kĂłdot, amely a <code>token</code> Ă©rtĂ©kĂ©t kĂłdolja. Ha a rĂ©sztvevĹ‘ mĂˇr be van jelentkezve, zĂ¶ld sĂˇv jelzi a bejelentkezĂ©s idĹ‘pontjĂˇt. Az oldal nyomtatĂˇsra optimalizĂˇlt.',
             'en'  => '<strong>Personal ticket page (public):</strong> After a successful registration, a <em>"View my ticket"</em> button appears on the confirmation page (using a session flash of the token). The ticket page displays the event details, attendee name, number of guests, and the QR code encoding the <code>token</code> value. If the attendee is already checked in, a green banner shows the check-in timestamp. The page is print-optimised.'],
            ['hu' => '<strong>VĂˇrĂłlistakezelĂ©s:</strong> Az admin esemĂ©ny szerkesztĹ‘ formjĂˇn megjelent a <em>VĂˇrĂłlista engedĂ©lyezve</em> kapcsolĂł. Ha az esemĂ©ny betelt Ă©s a vĂˇrĂłlista aktĂ­v, a publikus regisztrĂˇciĂłs oldalon sĂˇrga â€žFeliratkozĂˇs a vĂˇrĂłlistĂˇra" Ĺ±rlap jelenik meg a vĂˇrakozĂłk aktuĂˇlis szĂˇmĂˇval. A vĂˇrĂłlistĂˇn szereplĹ‘k pozĂ­ciĂł szerint sorrendben jelennek meg az admin rĂ©szletoldalon, ahol <em>ElĹ‘lĂ©ptet</em> Ă©s <em>TĂ¶rĂ¶l</em> gombok is elĂ©rhetĹ‘k. Ha egy adminisztrĂˇtor tĂ¶rĂ¶l egy megerĹ‘sĂ­tett regisztrĂˇciĂłt, az elsĹ‘ vĂˇrĂłlistĂˇs automatikusan elĹ‘lĂ©p Ă©s emailes Ă©rtesĂ­tĂ©st kap. Az <code>event_registrations</code> tĂˇblĂˇhoz <code>waitlisted</code> (boolean) Ă©s <code>waitlist_position</code> (smallint) oszlopok, az <code>events</code> tĂˇblĂˇhoz <code>waitlist_enabled</code> (boolean) oszlop adĂłdott.',
             'en'  => '<strong>Waitlist management:</strong> A <em>Waitlist enabled</em> toggle was added to the admin event edit form. When the event is full and the waitlist is active, the public registration page displays a yellow "Join the waiting list" form showing the current number of waiting people. Waitlisted entries appear sorted by position on the admin detail page, with <em>Promote</em> and <em>Remove</em> buttons. When an admin deletes a confirmed registration, the first waitlisted person is automatically promoted and receives a notification email. The <code>event_registrations</code> table gained <code>waitlisted</code> (boolean) and <code>waitlist_position</code> (smallint) columns; the <code>events</code> table gained <code>waitlist_enabled</code> (boolean).'],
            ['hu' => '<strong>VĂˇrĂłlistĂˇs email Ă©rtesĂ­tĹ‘k (2 db):</strong> <em>WaitlistConfirmation</em> â€“ sĂˇrga stĂ­lusĂş visszaigazolĂł email, amelyet a vĂˇrĂłlistĂˇra kerĂĽlĹ‘ szemĂ©ly kap, a pozĂ­ciĂłszĂˇmĂˇval. <em>WaitlistPromotion</em> â€“ zĂ¶ld stĂ­lusĂş â€žhely felszabadult" Ă©rtesĂ­tĹ‘, amelyet az elĹ‘lĂ©ptetett szemĂ©ly kap, belĂ©pĹ‘jegy linkkel. MindkĂ©t email HU/EN kĂ©tnyelvĹ± (a kĂĽldĂ©skori alkalmazĂˇslocale alapjĂˇn).',
             'en'  => '<strong>Waitlist email notifications (Ă—2):</strong> <em>WaitlistConfirmation</em> â€” a yellow-styled confirmation email sent to the person who joined the waitlist, including their position number. <em>WaitlistPromotion</em> â€” a green-styled "spot available" notification sent to the promoted person, with a ticket link. Both emails are bilingual HU/EN (driven by the application locale at send time).'],
            ['hu' => '<strong>RegisztrĂˇciĂł tĂ¶rlĂ©se adminbĂłl:</strong> Az admin esemĂ©ny rĂ©szletoldalon minden regisztrĂˇciĂłs sor kapott egy <em>Ă—</em> tĂ¶rlĂ©s gombot. TĂ¶rlĂ©skor a rendszer automatikusan ellenĹ‘rzi a vĂˇrĂłlistĂˇt, Ă©s ha van, az elsĹ‘ pozĂ­ciĂłn lĂ©vĹ‘ vĂˇrĂłlistĂˇs elĹ‘lĂ©ptetĂ©sre kerĂĽl Ă©s emailt kap. A vĂˇrĂłlistĂˇn lĂ©vĹ‘k pozĂ­ciĂłi automatikusan ĂˇtrendezĹ‘dnek.',
             'en'  => '<strong>Registration deletion from admin:</strong> Each registration row on the admin event detail page now has a <em>Ă—</em> delete button. On deletion, the system automatically checks the waitlist and, if present, promotes the first waitlisted entry and sends them a notification email. Waitlist positions are automatically reordered after removal.'],
        ],
    ],

    [
        'version' => 'v1.12.0',
        'badge'   => [
            'text'  => ['hu' => 'FejlesztĂ©s', 'en' => 'Improvement'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => '2026. mĂˇjus 10.', 'en' => 'May 10, 2026'],
        'items' => [
            ['hu' => '<strong>ZĂˇszlĂł ikonok a nyelvvĂˇltĂłban (sidebar):</strong> A HU / EN nyelvvĂˇltĂł gombok melletti zĂˇszlĂłk korĂˇbban emoji karakterekkĂ©nt (<code>đź‡­đź‡ş</code>, <code>đź‡¬đź‡§</code>) voltak megadva, amelyek Windows rendszeren nem jelennek meg (Chrome / Edge sem rendereli a regionĂˇlis jelzĹ‘ emoji-kat). JavĂ­tĂˇs: a <a href="https://flagicons.lipis.dev" target="_blank">flag-icons</a> SVG kĂ¶nyvtĂˇr (CDN, v7.2.3) betĂ¶ltĂ©sre kerĂĽl, Ă©s az emoji helyett <code>&lt;span class="fi fi-hu"&gt;</code> / <code>&lt;span class="fi fi-gb"&gt;</code> elemek kerĂĽlnek hasznĂˇlatba. Az ikonok most minden platformon Ă©s bĂ¶ngĂ©szĹ‘ben egysĂ©gesen jelennek meg.',
             'en'  => '<strong>Flag icons in the language switcher (sidebar):</strong> The flags next to the HU / EN language switcher buttons were previously emoji characters (<code>đź‡­đź‡ş</code>, <code>đź‡¬đź‡§</code>), which do not render on Windows (Chrome / Edge does not support regional indicator emoji sequences). Fix: the <a href="https://flagicons.lipis.dev" target="_blank">flag-icons</a> SVG library (CDN, v7.2.3) is now loaded and <code>&lt;span class="fi fi-hu"&gt;</code> / <code>&lt;span class="fi fi-gb"&gt;</code> elements replace the emoji. Flags now render consistently across all platforms and browsers.'],
            ['hu' => '<strong>README â€” teljes funkciĂłlista âś… / đź”˛ jelĂ¶lĂ©sekkel:</strong> A projekt README-je gyĂ¶keresen ĂˇtdolgozĂˇsra kerĂĽlt. Az Ă¶sszes meglĂ©vĹ‘ funkciĂł âś… jelĂ¶lĂ©ssel, az Ă¶sszes tervezett fejlesztĂ©s đź”˛ jelĂ¶lĂ©ssel szerepel, modulonkĂ©nt csoportosĂ­tva: Kapcsolatok (CRM), Csoportok, EsemĂ©nyek, Email kampĂˇnyok, AdomĂˇnyok, Projektek & Feladatok, Dashboard, FelhasznĂˇlĂłk & SzerepkĂ¶rĂ¶k, Link gyĹ±jtemĂ©ny, BeĂˇllĂ­tĂˇsok, SĂşgĂł, TĂ¶bbnyelvĹ±sĂ©g, IntegrĂˇciĂłk & API, Advanced / Enterprise. ĂŤgy GitHub-on bĂˇrmely Ă©rdeklĹ‘dĹ‘ egyetlen pillantĂˇssal ĂˇtlĂˇthatja, mi elĂ©rhetĹ‘ Ă©s mi van tervezĹ‘asztalon.',
             'en'  => '<strong>README â€” comprehensive feature list with âś… / đź”˛ markers:</strong> The project README was comprehensively rewritten. All implemented features are marked âś… and all planned features are marked đź”˛, grouped by module: Contacts (CRM), Groups, Events, Email Campaigns, Donations, Projects & Tasks, Dashboard, Users & Roles, Link Collection, Settings, Help & Documentation, Multi-language, Integrations & API, Advanced / Enterprise. This gives anyone visiting the GitHub repo an instant overview of what is available and what is on the roadmap.'],
            ['hu' => '<strong>Open Core tĂˇbla Ă©s Advanced / Enterprise szekciĂł szinkronizĂˇlĂˇsa:</strong> A README Open Core Ă¶sszehasonlĂ­tĂł tĂˇblĂˇja Ă©s a Features lista Advanced / Enterprise szekciĂłja Ă¶sszhangba hozĂˇsra kerĂĽlt. A KĂ©tfaktoros hitelesĂ­tĂ©s (TOTP) Ă©s a REST API for mobile clients tĂ©telek kizĂˇrĂłlag az Enterprise szekciĂłba kerĂĽltek (korĂˇbban a FelhasznĂˇlĂłk & SzerepkĂ¶rĂ¶k, ill. IntegrĂˇciĂłk & API szekciĂłkban is szerepeltek). Az Open Core tĂˇbla bĹ‘vĂĽlt: DokumentumtĂˇrolĂł, KĂ©rdĹ‘Ă­v & Ĺ±rlapkĂ©szĂ­tĹ‘, PetĂ­ciĂł / alĂˇĂ­rĂˇsgyĹ±jtĂ©s, Ă–nkĂ©ntes ĂłrakĂ¶vetĂ©s sorokkal.',
             'en'  => '<strong>Open Core table and Advanced / Enterprise section synchronised:</strong> The README Open Core comparison table and the Advanced / Enterprise section in the Features list have been brought into full alignment. Two-factor authentication (TOTP) and REST API for mobile clients are now exclusively listed under the Enterprise section (previously they also appeared under Users & Roles and Integrations & API). The Open Core table was expanded with new rows: Document storage, Survey & form builder, Petition / signature collection, Volunteer hours tracking.'],
            ['hu' => '<strong>SĂşgĂł gomb ĂˇthelyezĂ©se a gyorslinkek sĂˇvba:</strong> A FĹ‘oldal jobb felsĹ‘ sarkĂˇbĂłl eltĂˇvolĂ­tĂˇsra kerĂĽlt a SĂşgĂł gomb. A gyorslinkek sĂˇvba (kĂ©k topbar) kerĂĽlve az Infografikonok mellĂ©, most bĂˇrmely oldalrĂłl elĂ©rhetĹ‘vĂ© vĂˇlt anĂ©lkĂĽl, hogy el kellene navigĂˇlni a FĹ‘oldalra. A bal oldali menĂĽben a â€žSĂşgĂł kezelĂ©se" felirat â€žSĂşgĂł"-ra egyszerĹ±sĂ¶dĂ¶tt.',
             'en'  => '<strong>Help button moved to quick links bar:</strong> The Help button was removed from the top-right corner of the Dashboard and placed in the quick links bar (blue topbar) next to Infographics â€” now accessible from any page without navigating back to the Dashboard. The left sidebar label "Manage Help" was simplified to "Help".'],
            ['hu' => '<strong>CSV / Excel import &amp; export (Kapcsolatok):</strong> A <code>/admin/people</code> oldalon az Ă¶sszes kapcsolat exportĂˇlhatĂł CSV (UTF-8 BOM, pontosvesszĹ‘s elvĂˇlasztĂł) vagy Excel (XLSX, fĂ©lkĂ¶vĂ©r fejlĂ©c) formĂˇtumban. Import: CSV Ă©s XLSX fĂˇjlbĂłl, oszlopnĂ©v-alapĂş lekĂ©pzĂ©ssel, meglĂ©vĹ‘ emailcĂ­mek kihagyĂˇsĂˇval. A <code>phpoffice/phpspreadsheet</code> kĂ¶nyvtĂˇr kezeli az XLSX fĂˇjlokat.',
             'en'  => '<strong>CSV / Excel import &amp; export (Contacts):</strong> On the <code>/admin/people</code> page, all contacts can be exported as CSV (UTF-8 BOM, semicolon separator) or Excel (XLSX, bold header). Import: from CSV or XLSX file with column-name-based mapping, skipping existing email addresses. The <code>phpoffice/phpspreadsheet</code> library handles XLSX files.'],
            ['hu' => '<strong>SpeciĂˇlis szĹ±rĹ‘k Ă©s mentett keresĂ©sek (Kapcsolatok):</strong> KibĹ‘vĂ­tett szĹ±rĹ‘panel: keresĂ©s, stĂˇtusz (tĂ¶bb is), vĂˇros, forrĂˇs, hĂ­rlevĂ©l, csoport, regisztrĂˇciĂłs dĂˇtumtartomĂˇny, lead fĂˇzis Ă©s minimum pontszĂˇm. A szĹ±rĹ‘kombinĂˇciĂłk nĂ©vvel elmenthetĹ‘k Ă©s egy kattintĂˇssal visszatĂ¶lthetĹ‘k â€” felhasznĂˇlĂłnkĂ©nti szĹ±rĹ‘-elĹ‘beĂˇllĂ­tĂˇsok, <code>people_saved_filters</code> tĂˇbla.',
             'en'  => '<strong>Advanced filters and saved searches (Contacts):</strong> Expanded filter panel: text search, status (multi-select chips), city, source, newsletter subscription, group, registration date range, lead stage and minimum score. Filter combinations can be saved by name and reloaded in one click â€” per-user filter presets stored in the <code>people_saved_filters</code> table.'],
            ['hu' => '<strong>DuplikĂˇtum-keresĂ©s Ă©s kapcsolat-Ă¶sszevonĂˇs:</strong> Ăšj <code>/admin/people/duplicates</code> oldal, amely email, telefonszĂˇm Ă©s teljes nĂ©v (kis-/nagybetĹ±-fĂĽggetlen) alapjĂˇn azonosĂ­tja a valĂłszĂ­nĹ± duplikĂˇtumokat. A pĂˇrokat kĂˇrtyĂˇn jelenĂ­ti meg az egyezĂ©s okĂˇval (email/telefon/nĂ©v badge). Ă–sszevonĂˇskor az ĂĽres mezĹ‘k automatikusan tĂ¶ltĹ‘dnek fel a mĂˇsik profilbĂłl, az adomĂˇnyok, esemĂ©ny RSVP-k Ă©s csoporttagsĂˇgok ĂˇtkerĂĽlnek, a duplikĂˇtum soft-delete-elve lesz.',
             'en'  => '<strong>Duplicate detection and contact merge:</strong> New <code>/admin/people/duplicates</code> page that identifies probable duplicates by email, phone and full name (case-insensitive). Pairs are shown on cards with the match reason (email / phone / name badge). On merge, empty fields are auto-filled from the other profile, donations, event RSVPs and group memberships are transferred, and the duplicate is soft-deleted.'],
            ['hu' => '<strong>KapcsolatonkĂ©nti aktivitĂˇs naplĂł:</strong> Minden kapcsolathoz interakciĂłtĂ¶rtĂ©net rĂ¶gzĂ­thetĹ‘: TelefonhĂ­vĂˇs, Email, MegbeszĂ©lĂ©s, FeljegyzĂ©s, Feladat, SMS, EgyĂ©b â€” idĹ‘ponttal, megjegyzĂ©ssel Ă©s rĂ¶gzĂ­tĹ‘ felhasznĂˇlĂłval. A <code>contact_activities</code> tĂˇbla tĂˇrolja az adatokat. A kapcsolat rĂ©szletoldalĂˇn szĂ­n-kĂłdolt, ikonos vertikĂˇlis timeline formĂˇban jelenik meg.',
             'en'  => '<strong>Per-contact activity log:</strong> Interaction history can be recorded for every contact: Phone call, Email, Meeting, Note, Task, SMS, Other â€” with timestamp, notes and the recording user. Stored in the <code>contact_activities</code> table. Displayed as a colour-coded, icon-based vertical timeline on the contact detail page.'],
            ['hu' => '<strong>KapcsolatfelvĂ©tel / Ă©rdeklĹ‘dĹ‘Ă©rtĂ©kelĂ©s (Lead scoring):</strong> Minden kapcsolathoz beĂˇllĂ­thatĂł 6 fĂˇzisĂş Ă©rtĂ©kesĂ­tĂ©si pipeline (Ăšj Ă©rdeklĹ‘dĹ‘ â†’ Kapcsolatba lĂ©pve â†’ MinĹ‘sĂ­tett â†’ AjĂˇnlat kĂĽldve â†’ Megnyert â†’ Elveszett) Ă©s 1â€“5 csillagos Ă©rdeklĹ‘dĂ©si pontszĂˇm. A <code>people</code> tĂˇbla bĹ‘vĂĽl <code>lead_stage</code> Ă©s <code>lead_score</code> oszlopokkal. A listĂˇban Ă‰rtĂ©kelĂ©s oszlop jelenik meg; fĂˇzis Ă©s minimum pontszĂˇm alapjĂˇn szĹ±rhetĹ‘.',
             'en'  => '<strong>Contact intake / lead scoring:</strong> Each contact can be assigned a 6-stage sales pipeline (New Lead â†’ Contacted â†’ Qualified â†’ Proposal Sent â†’ Converted â†’ Lost) and a 1â€“5 star interest score. The <code>people</code> table gains <code>lead_stage</code> and <code>lead_score</code> columns. An Evaluation column appears in the contacts list; filterable by stage and minimum score.'],
        ],
    ],

    [
        'version' => 'v1.11.0',
        'badge'   => [
            'text'  => ['hu' => 'HibajavĂ­tĂˇs', 'en' => 'Bug Fix'],
            'style' => 'background:rgba(240,101,72,0.1);color:#f06548;',
        ],
        'date' => ['hu' => '2026. mĂˇjus 8.', 'en' => 'May 8, 2026'],
        'items' => [
            ['hu' => '<strong>Email kampĂˇny modul â€” hibajavĂ­tĂˇs csomag (Pro):</strong> Az email kampĂˇny kĂĽldĂ©si funkciĂł tĂ¶bb kritikus hibĂˇja javĂ­tĂˇsra kerĂĽlt: a <code>is_subscribed</code> mezĹ‘ helyes hasznĂˇlata (volt: <code>newsletter</code>), a <code>full_name</code> accessor hasznĂˇlata (nem lĂ©tezĹ‘ <code>name</code> oszlop helyett), az ĂĽres <code>\$e</code> catch vĂˇltozĂł elhĂˇrĂ­tĂˇsa, valamint az utolsĂł <code>$campaign->update()</code> hĂ­vĂˇs kĂ¶rĂ© helyezett try/catch vĂ©delem <em>failed</em> stĂˇtusz esetĂ©re.',
             'en' => '<strong>Email campaign module â€” bug fix bundle (Pro):</strong> Several critical bugs in the email campaign send flow were fixed: correct use of the <code>is_subscribed</code> field (was: <code>newsletter</code>), use of the <code>full_name</code> accessor (instead of non-existent <code>name</code> column), removal of unused <code>$e</code> catch variable, and a try/catch wrapper around the final <code>$campaign->update()</code> call for the <em>failed</em> status case.'],
            ['hu' => '<strong>KampĂˇny modal javĂ­tĂˇs:</strong> A kampĂˇny lĂ©trehozĂˇs Ă©s szerkesztĂ©s modaljain helytelen CSS osztĂˇly (<code>nf-modal-backdrop</code>) volt megadva, ami miatt a modalisablonok nem nyĂ­ltak meg. JavĂ­tva: <code>nf-overlay</code>.',
             'en' => '<strong>Campaign modal fix:</strong> The campaign create and edit modals had an incorrect CSS class (<code>nf-modal-backdrop</code>) that prevented them from opening. Fixed to <code>nf-overlay</code>.'],
            ['hu' => '<strong>FeliratkozĂłk szĂˇma piszkozat kampĂˇnyoknĂˇl:</strong> A kampĂˇny lista FogadĂłk oszlopa piszkozat ĂˇllapotĂş kampĂˇnyoknĂˇl korĂˇbban â€žâ€”â€ť jelet mutatott. MostantĂłl a valĂłs hĂ­rlevĂ©l feliratkozĂłk szĂˇma jelenik meg.',
             'en' => '<strong>Subscriber count for draft campaigns:</strong> The Recipients column in the campaign list previously showed "â€”" for draft campaigns. It now correctly displays the actual newsletter subscriber count.'],
            ['hu' => '<strong>FeladĂł cĂ­m javĂ­tĂˇsa (<code>CampaignMail</code>):</strong> Az emailek kĂĽldĂ©sĂ©kor a feladĂł cĂ­m helytelenĂĽl, csonkĂ­tva jelent meg (pl. <code>admin@</code> domain nĂ©lkĂĽl). A <code>CampaignMail::envelope()</code> most explicitĂ©n a kampĂˇnyban tĂˇrolt <code>from_email</code> Ă©s <code>from_name</code> Ă©rtĂ©keket hasznĂˇlja (<code>Illuminate\\Mail\\Mailables\\Address</code> segĂ­tsĂ©gĂ©vel), config fallbackkel.',
             'en' => '<strong>Sender address fix (<code>CampaignMail</code>):</strong> When sending emails, the sender address appeared incorrectly truncated (e.g. <code>admin@</code> without domain). <code>CampaignMail::envelope()</code> now explicitly uses the campaign\'s stored <code>from_email</code> and <code>from_name</code> values (via <code>Illuminate\\Mail\\Mailables\\Address</code>), with config fallback.'],
            ['hu' => '<strong><code>failed_count</code> oszlop Ă©s ENUM bĹ‘vĂ­tĂ©s (migrĂˇciĂł):</strong> KĂ©t Ăşj migrĂˇciĂł: az <code>email_campaigns</code> tĂˇblĂˇhoz hozzĂˇadĂˇsra kerĂĽltek a <code>failed_count</code> (unsignedInteger, default 0) oszlop, valamint a <em>failed</em> stĂˇtusz Ă©rtĂ©ke az ENUM mezĹ‘hĂ¶z â€” raw <code>ALTER TABLE</code> SQL-lel, mivel a MySQL ENUM mĂłdosĂ­tĂˇs nem lehetsĂ©ges Laravelblueprint-tel.',
             'en' => '<strong><code>failed_count</code> column and ENUM extension (migration):</strong> Two new migrations: the <code>failed_count</code> (unsignedInteger, default 0) column and the <em>failed</em> status value were added to the <code>email_campaigns</code> table â€” using raw <code>ALTER TABLE</code> SQL, as MySQL ENUM modification is not possible with Laravel Blueprint.'],
            ['hu' => '<strong>DuplikĂˇlt migrĂˇciĂł eltĂˇvolĂ­tĂˇsa (Forge deployment fix):</strong> A <code>2026_05_08_190846_create_email_campaigns_table.php</code> migrĂˇciĂł â€” amely lokĂˇlisan manuĂˇlisan volt hozzĂˇadva az adatbĂˇzishoz â€” eltĂˇvolĂ­tĂˇsra kerĂĽlt a git repĂłbĂłl. A Forge szerveren ez a duplikĂˇlt migrĂˇciĂł <em>â€žtable already exists"</em> hibĂˇval akadĂˇlyozta a deployment-et.',
             'en' => '<strong>Duplicate migration removed (Forge deployment fix):</strong> The <code>2026_05_08_190846_create_email_campaigns_table.php</code> migration â€” which was manually added to the database locally â€” was removed from the git repository. On the Forge server, this duplicate migration was blocking deployment with a <em>"table already exists"</em> error.'],
            ['hu' => '<strong>Dashboard TypeError javĂ­tĂˇs (Windows / HU locale):</strong> A <code>/dashboard</code> oldal <code>TypeError: htmlspecialchars() array given</code> hibĂˇval omlott Ă¶ssze. GyĂ¶kĂ©rok: Windows fĂˇjlrendszer nem kĂĽlĂ¶nbĂ¶zteti meg a kis- Ă©s nagybetĹ±ket, ezĂ©rt az <code>__("Dashboard")</code> hĂ­vĂˇs a <code>lang/hu/dashboard.php</code> fĂˇjlt (tĂ¶mbkĂ©nt) adta vissza a vĂˇrt szĂ¶veg helyett. JavĂ­tĂˇs: <code>__("nav.dashboard")</code> â€” mind a <code>dashboard.blade.php</code>, mind a <code>livewire/layout/navigation.blade.php</code> nĂ©zetekben.',
             'en' => '<strong>Dashboard TypeError fix (Windows / HU locale):</strong> The <code>/dashboard</code> page was crashing with <code>TypeError: htmlspecialchars() array given</code>. Root cause: the Windows filesystem is case-insensitive, so <code>__("Dashboard")</code> matched <code>lang/hu/dashboard.php</code> and returned the entire array instead of a string. Fix: <code>__("nav.dashboard")</code> â€” in both <code>dashboard.blade.php</code> and <code>livewire/layout/navigation.blade.php</code>.'],
            ['hu' => '<strong>Resend email integrĂˇciĂł:</strong> A <code>config/services.php</code>-ben a <code>RESEND_API_KEY</code> env vĂˇltozĂł neve <code>RESEND_KEY</code>-re javĂ­tva a <code>.env</code> fĂˇjl tĂ©nyleges vĂˇltozĂłjĂˇnak megfelelĹ‘en. A Resend Laravel csomag mindkĂ©t config kulcsot ellenĹ‘rzi fallback-kĂ©nt, Ă­gy a javĂ­tĂˇs utĂˇn az API kulcs helyesen tĂ¶ltĹ‘dik be.',
             'en' => '<strong>Resend email integration:</strong> In <code>config/services.php</code>, the env variable name was corrected from <code>RESEND_API_KEY</code> to <code>RESEND_KEY</code> to match the actual <code>.env</code> file variable. The Resend Laravel package checks both config keys as fallback, so after the fix the API key loads correctly.'],
        ],
    ],

    [
        'version' => 'v1.10.0',
        'badge'   => [
            'text'  => ['hu' => 'FejlesztĂ©s', 'en' => 'Improvement'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => '2026. mĂˇjus 6.', 'en' => 'May 6, 2026'],
        'items' => [
            ['hu' => '<strong>TĂ¶bbnyelvĹ±sĂ©g (HU/EN) â€” infrastruktĂşra:</strong> Bevezetve a <code>SetLocale</code> middleware (session-alapĂş locale beĂˇllĂ­tĂˇs), <code>LocaleController</code> Ă©s a <code>/language/{locale}</code> route. A felsĹ‘ navigĂˇciĂłban megjelent a HU / EN nyelvvĂˇltĂł gomb, amely azonnal Ăˇtkapcsolja az admin felĂĽlet teljes szĂ¶vegĂ©t.',
             'en' => '<strong>Multi-language support (HU/EN) â€” infrastructure:</strong> Introduced <code>SetLocale</code> middleware (session-based locale), <code>LocaleController</code> and the <code>/language/{locale}</code> route. A HU / EN language switcher button appeared in the top navigation, instantly switching all admin interface text.'],
            ['hu' => '<strong>FordĂ­tĂˇsi fĂˇjlok â€” teljes lefedĂ©s:</strong> LĂ©trehozĂˇsra Ă©s feltĂ¶ltĂ©sre kerĂĽltek a <code>lang/hu/</code> Ă©s <code>lang/en/</code> PHP nyelvi fĂˇjlok minden modulhoz: <code>common</code>, <code>people</code>, <code>events</code>, <code>groups</code>, <code>donations</code>, <code>projects</code>, <code>tasks</code>, <code>users</code>, <code>settings</code>, <code>links</code>, <code>cal</code> (naptĂˇr hĂłnap- Ă©s napnevek), <code>changelog</code>.',
             'en' => '<strong>Translation files â€” full coverage:</strong> <code>lang/hu/</code> and <code>lang/en/</code> PHP language files created and populated for every module: <code>common</code>, <code>people</code>, <code>events</code>, <code>groups</code>, <code>donations</code>, <code>projects</code>, <code>tasks</code>, <code>users</code>, <code>settings</code>, <code>links</code>, <code>cal</code> (calendar month and day names), <code>changelog</code>.'],
            ['hu' => '<strong>Admin listaoldalak fordĂ­tĂˇsa:</strong> Minden admin <em>index</em> nĂ©zet ĂˇtĂ­rva <code>__()</code> helperekkel â€” Kapcsolatok, EsemĂ©nyek, Csoportok, AdomĂˇnyok, Projektek, Feladatok, FelhasznĂˇlĂłk, BeĂˇllĂ­tĂˇsok. A stĂˇtusz/tĂ­pus/prioritĂˇs badge-ek Ă©s a dropdown opciĂłk mostantĂłl a kivĂˇlasztott nyelvnek megfelelĹ‘en jelennek meg.',
             'en' => '<strong>Admin list pages translated:</strong> All admin <em>index</em> views rewritten with <code>__()</code> helpers â€” Contacts, Events, Groups, Donations, Projects, Tasks, Users, Settings. Status/type/priority badges and dropdown options now display according to the selected language.'],
            ['hu' => '<strong>Admin rĂ©szletoldalak fordĂ­tĂˇsa:</strong> A Projekt, EsemĂ©ny, AdomĂˇny, Kapcsolat Ă©s Csoport rĂ©szletoldalak (<em>show</em> nĂ©zetek) teljes szĂ¶vege lefordĂ­tva. A dinamikus PHP Ă©rtĂ©ktĂ©rkĂ©pek (stĂˇtusz, prioritĂˇs, tĂ­pus, szerepkĂ¶r) szintĂ©n <code>__()</code> hĂ­vĂˇsokat hasznĂˇlnak.',
             'en' => '<strong>Admin detail pages translated:</strong> Full translation of the Project, Event, Donation, Contact and Group detail (<em>show</em>) views. Dynamic PHP value maps (status, priority, type, role) also use <code>__()</code> calls.'],
            ['hu' => '<strong>Admin Ĺ±rlapok fordĂ­tĂˇsa:</strong> Minden szerkesztĹ‘ Ă©s lĂ©trehozĂł oldal (<em>form</em> nĂ©zetek) ĂˇtĂ­rva â€” Projektek, EsemĂ©nyek (teljes oldal + modal partial), Kapcsolatok, Csoportok. A legĂ¶rdĂĽlĹ‘ opciĂłk Ă©rtĂ©ktĂ©rkĂ©pek alapjĂˇn tĂ¶ltĹ‘dnek be a megfelelĹ‘ nyelven.',
             'en' => '<strong>Admin forms translated:</strong> All edit and create pages (<em>form</em> views) rewritten â€” Projects, Events (full page + modal partial), Contacts, Groups. Dropdown options populate from value maps in the correct language.'],
            ['hu' => '<strong>NaptĂˇr Ă©s Gantt JS-fordĂ­tĂˇs:</strong> A Projekt rĂ©szletoldalon a NaptĂˇr Ă©s Gantt nĂ©zetekhez szĂĽksĂ©ges hĂłnap/nap neveket PHP <code>__()</code> tĂ¶mbĂ¶k tĂˇroljĂˇk, amelyek <code>@json()</code> direktĂ­vĂˇval kerĂĽlnek a JavaScript kontextusba â€” Ă­gy az oldal renderidejĂ©ben a helyes lokalizĂˇlt Ă©rtĂ©kek jelennek meg.',
             'en' => '<strong>Calendar and Gantt JS translation:</strong> On the Project detail page, month/day names needed by the Calendar and Gantt views are stored in PHP <code>__()</code> arrays passed into JavaScript context via the <code>@json()</code> directive â€” rendering correctly localized values at page load time.'],
            ['hu' => '<strong>NyilvĂˇnos esemĂ©nyoldalak fordĂ­tĂˇsa:</strong> A bejelentkezĂ©s nĂ©lkĂĽl elĂ©rhetĹ‘ nyilvĂˇnos regisztrĂˇciĂłs oldal (<code>/e/{slug}</code>) Ă©s a visszaigazolĂł oldal is teljes HU/EN fordĂ­tĂˇst kapott. A <code>&lt;html lang&gt;</code> attribĂştum mostantĂłl dinamikusan tĂĽkrĂ¶zi az aktuĂˇlis locale-t.',
             'en' => '<strong>Public event pages translated:</strong> The login-free public registration page (<code>/e/{slug}</code>) and the confirmation page received full HU/EN translation. The <code>&lt;html lang&gt;</code> attribute now dynamically reflects the current locale.'],
            ['hu' => '<strong>VerziĂłkĂ¶vetĂ©s oldal fordĂ­tĂˇsa:</strong> A Changelog oldal data-driven szerkezetre vĂˇltott â€” a verziĂłk bejegyzĂ©sei PHP tĂ¶mbĂ¶kben tĂˇrolĂłdnak <code>hu</code>/<code>en</code> kulcsokkal, a sablon locale alapjĂˇn rendereli a megfelelĹ‘ szĂ¶veget. Badge-ek Ă©s dĂˇtumok szintĂ©n kĂ©tnyelvĹ±ek.',
             'en' => '<strong>Changelog page translated:</strong> The Changelog page switched to a data-driven structure â€” version entries are stored in PHP arrays with <code>hu</code>/<code>en</code> keys, the template renders the correct text based on locale. Badges and dates are also bilingual.'],
            ['hu' => '<strong>SĂşgĂł szekciĂł teljes kĂ©tnyelvĹ±sĂ­tĂ©se:</strong> LĂ©trehozĂˇsra kerĂĽltek a <code>lang/hu/help.php</code> Ă©s <code>lang/en/help.php</code> fordĂ­tĂˇsi fĂˇjlok. Az admin <em>SĂşgĂł kezelĂ©se</em> oldal Ă©s a nyilvĂˇnos <em>SĂşgĂł megtekintĹ‘</em> (<code>sugo.blade.php</code>) minden szĂ¶vege <code>__()</code> helperekkel lett ĂˇtĂ­rva. A <code>&lt;html lang&gt;</code> attribĂştum dinamikus, az oldal fejlĂ©ce Ă©s gombok is az aktĂ­v locale-t tĂĽkrĂ¶zik.',
             'en' => '<strong>Full bilingual support for Help section:</strong> <code>lang/hu/help.php</code> and <code>lang/en/help.php</code> translation files created. All text in the admin <em>Manage Help</em> page and the public <em>Help viewer</em> (<code>sugo.blade.php</code>) rewritten with <code>__()</code> helpers. The <code>&lt;html lang&gt;</code> attribute is now dynamic; the page header and buttons reflect the active locale.'],
            ['hu' => '<strong>SĂşgĂł cikkek kĂ©tnyelvĹ± adatbĂˇzis-sĂ©mĂˇja:</strong> A <code>help_articles</code> tĂˇbla bĹ‘vĂ­tĂ©sre kerĂĽlt <code>title_en</code> Ă©s <code>content_en</code> (nullable) oszlopokkal. HĂˇrom Ăşj sĂşgĂł cikk jĂ¶tt lĂ©tre teljes HU+EN tartalommal: <em>Projektek</em>, <em>VerziĂłkĂ¶vetĂ©s</em>, <em>SĂşgĂł kezelĂ©se</em>. A megjelenĂ­tĹ‘ a locale alapjĂˇn automatikusan vĂˇlt a megfelelĹ‘ nyelvre, hiĂˇnyzĂł EN tartalom esetĂ©n a magyar verziĂłra esik vissza.',
             'en' => '<strong>Bilingual database schema for Help articles:</strong> The <code>help_articles</code> table was extended with nullable <code>title_en</code> and <code>content_en</code> columns. Three new help articles were created with full HU+EN content: <em>Projects</em>, <em>Changelog</em>, <em>Manage Help</em>. The viewer automatically switches to the correct language based on locale, falling back to Hungarian if EN content is missing.'],
            ['hu' => '<strong>SĂşgĂł admin szerkesztĹ‘ â€” kĂ©tnyelvĹ± tabos modal:</strong> A SĂşgĂł kezelĂ©se oldalon az edit modal HU Ă©s EN fĂĽlekkel bĹ‘vĂĽlt, Ă­gy az adminisztrĂˇtor mindkĂ©t nyelv tartalmĂˇt (cĂ­m + szĂ¶veg) egymĂˇstĂłl fĂĽggetlenĂĽl szerkesztheti Ă©s mentheti egyetlen felĂĽleten.',
             'en' => '<strong>Help admin editor â€” bilingual tabbed modal:</strong> The edit modal on the Manage Help page gained HU and EN language tabs, allowing the administrator to edit and save both language versions (title + content) independently from a single interface.'],
            ['hu' => '<strong>SĂşgĂł cikkekhez kĂ©pernyĹ‘kĂ©pek:</strong> Minden sĂşgĂł cikkhez (<em>FĹ‘oldal, Kapcsolatok, EsemĂ©nyek, Csoportok, AdomĂˇnyok, FelhasznĂˇlĂłk, BeĂˇllĂ­tĂˇsok, Projektek, VerziĂłkĂ¶vetĂ©s, SĂşgĂł kezelĂ©se</em>) a leĂ­rĂˇs vĂ©gĂ©re bekerĂĽlt egy-egy jellemzĹ‘ kĂ©pernyĹ‘kĂ©p (<code>/public/img/sugo/</code> mappa). A kĂ©pek kattintĂˇsra teljes kĂ©pernyĹ‘s lightbox nĂ©zetben nyĂ­lnak meg.',
             'en' => '<strong>Screenshots added to Help articles:</strong> A representative screenshot was appended to every help article (<em>Dashboard, Contacts, Events, Groups, Donations, Users, Settings, Projects, Changelog, Manage Help</em>) from the <code>/public/img/sugo/</code> folder. Images open in a full-screen lightbox on click.'],
            ['hu' => '<strong>SĂşgĂł megtekintĹ‘ gĂ¶rgethetĹ‘sĂ©g javĂ­tĂˇsa:</strong> A <code>sugo.blade.php</code> elrendezĂ©sĂ©ben a <code>main</code> elem explicit <code>height: calc(100vh - 60px)</code> Ă©s <code>overflow-y: auto</code> stĂ­lust kapott, Ă­gy hosszabb cikkeknĂ©l Ă©s beillesztett kĂ©peknĂ©l az oldal megfelelĹ‘en gĂ¶rgethetĹ‘vĂ© vĂˇlt.',
             'en' => '<strong>Help viewer scrolling fix:</strong> In the <code>sugo.blade.php</code> layout the <code>main</code> element received an explicit <code>height: calc(100vh - 60px)</code> and <code>overflow-y: auto</code> style, making the page properly scrollable for longer articles and embedded screenshots.'],
        ],
    ],

    [
        'version' => 'v1.9.0',
        'badge'   => [
            'text'  => ['hu' => 'FejlesztĂ©s', 'en' => 'Improvement'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => '2026. mĂˇjus 6.', 'en' => 'May 6, 2026'],
        'items' => [
            ['hu' => '<strong>Open Core GitHub stratĂ©gia â€” repĂł szĂ©tvĂˇlasztĂˇs:</strong> A projekt nyilvĂˇnos (<code>nationforge-community</code>) Ă©s privĂˇt (<code>nationforge-pro</code>) repĂłra vĂˇlt szĂ©t. A Community MIT licenc alatt elĂ©rhetĹ‘, a Pro fejlesztĂ©sek kĂĽlĂ¶n privĂˇt repĂłban folynak.',
             'en' => '<strong>Open Core GitHub strategy â€” repo split:</strong> The project was split into a public (<code>nationforge-community</code>) and a private (<code>nationforge-pro</code>) repo. The Community edition is available under MIT license; Pro developments continue in a separate private repo.'],
            ['hu' => '<strong>MIT LICENSE fĂˇjl hozzĂˇadĂˇsa:</strong> A Community kiadĂˇshoz hivatalos <code>LICENSE</code> fĂˇjl kerĂĽlt (MIT, ProgramozĂˇs Kft. 2026) â€” enĂ©lkĂĽl jogilag â€žminden jog fenntartva" lett volna Ă©rvĂ©nyes.',
             'en' => '<strong>MIT LICENSE file added:</strong> An official <code>LICENSE</code> file (MIT, ProgramozĂˇs Kft. 2026) was added to the Community edition â€” without it, "all rights reserved" would have applied legally.'],
            ['hu' => '<strong>GitHub README â€” angol hero kĂ©p:</strong> A fĹ‘oldalon megjelenĹ‘ marketing kĂ©p angol szĂ¶vegĹ± verziĂłra cserĂ©lve (<em>Stronger communities. More action. Real change.</em>), a GitHub globĂˇlis fejlesztĹ‘i kĂ¶zĂ¶nsĂ©ge szĂˇmĂˇra.',
             'en' => '<strong>GitHub README â€” English hero image:</strong> The marketing image on the main page replaced with an English-text version (<em>Stronger communities. More action. Real change.</em>) for GitHub\'s global developer audience.'],
            ['hu' => '<strong>README Pro-szekciĂł linkelĂ©se:</strong> Az Open Core tĂˇblĂˇzatban a Pro oszlop Ă©s a call-to-action sor mostantĂłl kĂ¶zvetlenĂĽl a <code>nationforge-pro</code> GitHub repĂłra hivatkozik.',
             'en' => '<strong>README Pro section linked:</strong> In the Open Core table, the Pro column and call-to-action row now link directly to the <code>nationforge-pro</code> GitHub repo.'],
            ['hu' => '<strong>RepĂł tisztĂ­tĂˇs â€” Ă©rzĂ©keny fĂˇjlok eltĂˇvolĂ­tĂˇsa:</strong> A publikus repĂłbĂłl eltĂˇvolĂ­tĂˇsra kerĂĽltek a helyi fejlesztĹ‘i eszkĂ¶zĂ¶k: <code>.claude/</code> config, <code>gitupdate.bat</code>, <code>get_help.php</code>, <code>run_help_fix.php</code>, <code>help_dump.json</code>, <code>help_fix.json</code>. Mindegyik bekerĂĽlt a <code>.gitignore</code>-ba.',
             'en' => '<strong>Repo cleanup â€” sensitive files removed:</strong> Local developer tools removed from the public repo: <code>.claude/</code> config, <code>gitupdate.bat</code>, <code>get_help.php</code>, <code>run_help_fix.php</code>, <code>help_dump.json</code>, <code>help_fix.json</code>. All added to <code>.gitignore</code>.'],
            ['hu' => '<strong>Pro repĂł automatikus Community-szinkron:</strong> A <code>nationforge-pro</code> repĂłhoz <code>gitupdate.bat</code> szkript kĂ©szĂĽlt, amely minden futtatĂˇskor automatikusan behĂşzza a Community ĂşjĂ­tĂˇsait (<code>git fetch community && git merge</code>), majd feltĂ¶lti a Pro vĂˇltozĂˇsokat.',
             'en' => '<strong>Pro repo automatic Community sync:</strong> A <code>gitupdate.bat</code> script was created for the <code>nationforge-pro</code> repo that automatically pulls Community updates (<code>git fetch community && git merge</code>) on every run, then pushes Pro changes.'],
            ['hu' => '<strong>TĂ¶bbnyelvĹ±sĂ©g a Roadmap-ben:</strong> A tervezett fejlesztĂ©sek kĂ¶zĂ© bekerĂĽlt a tĂ¶bbnyelvĹ± tĂˇmogatĂˇs (angol / magyar) mint kĂ¶zelgĹ‘ funkciĂł.',
             'en' => '<strong>Multi-language support in Roadmap:</strong> Multi-language support (English / Hungarian) was added to the planned features as an upcoming item.'],
            ['hu' => '<strong>NyilvĂˇnos esemĂ©ny-regisztrĂˇciĂł (Ăşj funkciĂł):</strong> Minden <em>published</em> stĂˇtuszĂş esemĂ©nyhez egyedi nyilvĂˇnos regisztrĂˇciĂłs oldal Ă©rhetĹ‘ el (<code>/e/{slug}</code>), bejelentkezĂ©s nĂ©lkĂĽl. A lĂˇtogatĂł megadja nevĂ©t, e-mail cĂ­mĂ©t, telefonszĂˇmĂˇt, kĂ­sĂ©rĹ‘k szĂˇmĂˇt Ă©s megjegyzĂ©sĂ©t. KapacitĂˇskorlĂˇt esetĂ©n vizuĂˇlis tĂ¶ltĂ¶ttsĂ©gsĂˇv jelenik meg, Ă©s ha az esemĂ©ny betelt, a form helyett hibaĂĽzenet lĂˇthatĂł. Sikeres regisztrĂˇciĂł utĂˇn visszaigazolĂł oldal fogadja a rĂ©sztvevĹ‘t. Az admin EsemĂ©ny rĂ©szletoldalĂˇn megjelenik a regisztrĂˇltak listĂˇja (nĂ©v, e-mail, telefon, kĂ­sĂ©rĹ‘k, idĹ‘pont), valamint egy â€žPublikus oldal" gomb.',
             'en' => '<strong>Public event registration (new feature):</strong> Every <em>published</em> event gets a unique public registration page (<code>/e/{slug}</code>), accessible without login. Visitors enter their name, email, phone, number of guests and a note. A visual capacity bar appears when a capacity limit is set; if the event is full, a notice replaces the form. A confirmation page greets the attendee after successful registration. The admin Event detail page displays the registrant list (name, email, phone, guests, time) and a "Public page" button.'],
        ],
    ],

    [
        'version' => 'v1.8.0',
        'date' => ['hu' => '2026. mĂˇjus 5.', 'en' => 'May 5, 2026'],
        'items' => [
            ['hu' => '<strong>EsemĂ©ny 500-as hiba javĂ­tĂˇsa (EventRsvp model):</strong> Az esemĂ©ny rĂ©szletoldal Ă©s a szerkesztĂ©s utĂˇni ĂˇtirĂˇnyĂ­tĂˇs 500-as szerverhibĂˇval vĂ©gzĹ‘dĂ¶tt, mert a <code>App\Models\EventRsvp</code> osztĂˇly hiĂˇnyzott, noha az <code>event_rsvps</code> tĂˇbla az adatbĂˇzisban mĂˇr lĂ©tezett. A modell lĂ©trehozĂˇsa megszĂĽntette a hibĂˇt.',
             'en' => '<strong>Event 500 error fix (EventRsvp model):</strong> The event detail page and the redirect after editing ended with a 500 server error because the <code>App\Models\EventRsvp</code> class was missing, even though the <code>event_rsvps</code> table already existed in the database. Creating the model resolved the error.'],
            ['hu' => '<strong>EsemĂ©ny lĂ©trehozĂˇs/mĂłdosĂ­tĂˇs 500-as hiba javĂ­tĂˇsa (ticket_price):</strong> Production MySQL strict mĂłdban az ĂĽres jegyĂˇr mezĹ‘ <code>NULL</code> Ă©rtĂ©kkĂ©nt jutott a <code>NOT NULL</code> oszlopba, ami szerverhibĂˇt okozott. A vezĂ©rlĹ‘ben bevezetett <code>?? 0</code> visszavezetĹ‘ Ă©rtĂ©k megoldja a problĂ©mĂˇt.',
             'en' => '<strong>Event create/update 500 error fix (ticket_price):</strong> In production MySQL strict mode, an empty ticket price field reached the <code>NOT NULL</code> column as <code>NULL</code>, causing a server error. A <code>?? 0</code> fallback introduced in the controller\'s <code>store()</code> and <code>update()</code> methods resolves the issue.'],
            ['hu' => '<strong>KĂ¶zelgĹ‘ esemĂ©nyek helyes szĂˇmlĂˇlĂˇsa:</strong> A fĹ‘oldal â€žKĂ¶zelgĹ‘ esemĂ©ny" szĂˇmlĂˇlĂłja korĂˇbban csak a <em>published</em> stĂˇtuszĂş esemĂ©nyeket vette figyelembe, holott az Ăşjonnan lĂ©trehozott esemĂ©nyek alapĂ©rtelmezetten <em>draft</em> stĂˇtusszal jĂ¶nnek lĂ©tre. MostantĂłl a <em>cancelled</em> Ă©s <em>completed</em> kivĂ©telĂ©vel minden jĂ¶vĹ‘beli esemĂ©ny beleszĂˇmĂ­t.',
             'en' => '<strong>Correct counting of upcoming events:</strong> The homepage "Upcoming events" counter previously only counted <em>published</em> events, while newly created events default to <em>draft</em>. Now all future events except <em>cancelled</em> and <em>completed</em> are counted.'],
            ['hu' => '<strong>FĹ‘oldal gĂ¶rgetĂ©s javĂ­tĂˇsa:</strong> A layout fĹ‘oszlopa explicit <code>height: calc(100vh - 38px)</code> magassĂˇgot kapott, a <code>&lt;main&gt;</code> elem pedig <code>flex:1; min-height:0</code> kombinĂˇciĂłval tĂ¶lti ki a maradĂ©k terĂĽletet.',
             'en' => '<strong>Homepage scroll fix:</strong> The layout\'s main column received an explicit <code>height: calc(100vh - 38px)</code>, and the <code>&lt;main&gt;</code> element fills the remaining area with <code>flex:1; min-height:0</code> â€” so longer content scrolls correctly.'],
            ['hu' => '<strong>Panel padding egysĂ©gesĂ­tĂ©s:</strong> Az EsemĂ©ny rĂ©szletoldal RĂ©szletek panelĂ©n Ă©s a fĹ‘oldal KĂ¶zelgĹ‘ esemĂ©nyek listĂˇjĂˇn a Tailwind <code>px-5</code> osztĂˇlyok helyett garantĂˇltan Ă©rvĂ©nyesĂĽlĹ‘ inline <code>padding: 20px</code> stĂ­lusok kerĂĽltek be.',
             'en' => '<strong>Panel padding standardization:</strong> On the Event detail page\'s Details panel and the homepage Upcoming events list, Tailwind <code>px-5</code> classes were replaced with guaranteed inline <code>padding: 20px</code> styles.'],
            ['hu' => '<strong>LinkgyĹ±jtemĂ©ny modul (Ăşj oldal):</strong> Ăšj <code>/admin/links</code> oldal, amely a mentett hivatkozĂˇsokat kategĂłriĂˇnkĂ©nt csoportosĂ­tva, kĂˇrtyĂˇs elrendezĂ©sben jelenĂ­ti meg. Minden kĂˇrtya tartalmaz szĂ­nes ikont, leĂ­rĂˇst Ă©s domain-chip feliratot; kattintĂˇsra Ăşj lapon nyĂ­lik meg.',
             'en' => '<strong>Link collection module (new page):</strong> New <code>/admin/links</code> page displaying saved links grouped by category in a card layout. Each card contains a colored icon, description and domain chip label; clicking opens in a new tab.'],
            ['hu' => '<strong>LinkgyĹ±jtemĂ©ny konfigurĂˇlĂˇsa a BeĂˇllĂ­tĂˇsokban:</strong> A BeĂˇllĂ­tĂˇsok oldal aljĂˇn Ăşj szekciĂł teszi lehetĹ‘vĂ© a linkek kezelĂ©sĂ©t (hozzĂˇadĂˇs, szerkesztĂ©s, tĂ¶rlĂ©s) â€” modal alapĂş felĂĽlettel, cĂ­m, URL, kategĂłria, szĂ­n, leĂ­rĂˇs, sorrend Ă©s aktĂ­v/inaktĂ­v mezĹ‘kkel.',
             'en' => '<strong>Link collection configuration in Settings:</strong> A new section at the bottom of the Settings page enables link management (add, edit, delete) â€” with a modal-based interface for title, URL, category, color, description, order and active/inactive fields.'],
            ['hu' => '<strong>Gyorslinkek sĂˇv â€” valĂłdi URL-ek:</strong> A felsĹ‘ kĂ©k sĂˇvban lĂ©vĹ‘ gyorslinkek megkaptĂˇk a tĂ©nyleges hivatkozĂˇsaikat: <em>YouTube</em>, <em>Google Drive</em>, <em>Instagram</em>, <em>HĂ­rek</em>, <em>Infografikonok</em>. Minden link Ăşj lapon nyĂ­lik meg. A â€žLinkgyĹ±jtemĂ©ny" gomb az Ăşj <code>/admin/links</code> oldalra navigĂˇl.',
             'en' => '<strong>Quick links bar â€” real URLs:</strong> The quick links in the top blue bar received their actual links: <em>YouTube</em>, <em>Google Drive</em>, <em>Instagram</em>, <em>News</em>, <em>Infographics</em>. All links open in a new tab. The "Link Collection" button navigates to the new <code>/admin/links</code> page.'],
            ['hu' => '<strong>BeĂˇllĂ­tĂˇsok oldal teljes szĂ©lessĂ©gĹ± elrendezĂ©se:</strong> A korĂˇbban kĂ¶zĂ©pre igazĂ­tott, korlĂˇtozott szĂ©lessĂ©gĹ± BeĂˇllĂ­tĂˇsok felĂĽlet mostantĂłl a teljes rendelkezĂ©sre ĂˇllĂł terĂĽletet kitĂ¶lti. Az ĂltalĂˇnos Ă©s Email szekciĂłk kĂ©toszlopos rĂˇcsban helyezkednek el egymĂˇs mellett.',
             'en' => '<strong>Settings page full-width layout:</strong> The previously centered, limited-width Settings interface now fills all available space. The General and Email sections are arranged side by side in a two-column grid, with info cards (PHP, Laravel, Environment) below.'],
        ],
    ],

    [
        'version' => 'v1.7.0',
        'date' => ['hu' => '2026. mĂˇjus 3.', 'en' => 'May 3, 2026'],
        'items' => [
            ['hu' => '<strong>OldalsĂˇv menĂĽ egyszerĹ±sĂ­tĂ©se:</strong> A CRM Ă©s AdminisztrĂˇciĂł legĂ¶rdĂĽlĹ‘ almenĂĽk megszĹ±ntek. A Kapcsolatok, Csoportok, FelhasznĂˇlĂłk, BeĂˇllĂ­tĂˇsok, VerziĂłkĂ¶vetĂ©s Ă©s SĂşgĂł kezelĂ©se mostantĂłl kĂ¶zvetlen, Ă¶nĂˇllĂł menĂĽpontokkĂ©nt Ă©rhetĹ‘k el.',
             'en' => '<strong>Sidebar menu simplification:</strong> The CRM and Administration dropdown submenus were removed. Contacts, Groups, Users, Settings, Changelog and Help are now directly accessible as standalone menu items â€” reachable in a single click.'],
            ['hu' => '<strong>Csoport rĂ©szletoldal ĂˇtrendezĂ©se:</strong> Az oldal bal oszlopĂˇba kerĂĽltek az Adatok Ă©s a Tagok panel egymĂˇs alatt, mĂ­g a Chat ablak a jobb oldali (kĂ©tharmados) oszlopot tĂ¶lti ki â€” ĂˇttekinthetĹ‘bb, kĂ©tpaneles elrendezĂ©s.',
             'en' => '<strong>Group detail page rearrangement:</strong> The Data and Members panels were moved to the left column stacked vertically, while the Chat window fills the right (two-thirds) column â€” a clearer, two-panel layout.'],
            ['hu' => '<strong>Chat ablak viewport-kitĂ¶ltĂ©s:</strong> A csoport chat ablaka mostantĂłl a bĂ¶ngĂ©szĹ‘ablak teljes magassĂˇgĂˇt kitĂ¶lti (topbartĂłl az aljĂˇig), Ă©s a jobb szĂ©lre van igazĂ­tva. JavaScript alapĂş <code>position: fixed</code> elhelyezĂ©s gondoskodik arrĂłl, hogy a Livewire poll-frissĂ­tĂ©s sem ĂˇllĂ­tja vissza a pozĂ­ciĂłt.',
             'en' => '<strong>Chat window viewport fill:</strong> The group chat window now fills the full height of the browser window (from topbar to bottom), aligned to the right edge. JavaScript-based <code>position: fixed</code> placement ensures Livewire poll updates don\'t reset the position.'],
            ['hu' => '<strong>SzerepkĂ¶rĂ¶k magyar megnevezĂ©se:</strong> A FelhasznĂˇlĂłk lĂ©trehozĂˇs/szerkesztĂ©s modalban Ă©s a Csoport rĂ©szletoldalon a szerepkĂ¶r nevek angolrĂłl magyarra vĂˇltottak: <em>super-admin â†’ FĹ‘admin, admin â†’ Admin, editor â†’ SzerkesztĹ‘, member â†’ Tag</em>.',
             'en' => '<strong>Localized role names:</strong> In the Users create/edit modal and the Group detail page, role names were updated to match the display locale: <em>super-admin â†’ FĹ‘admin, admin â†’ Admin, editor â†’ SzerkesztĹ‘, member â†’ Tag</em>.'],
            ['hu' => '<strong>Dashboard grafikonok (Chart.js):</strong> A fĹ‘oldalra hĂˇrom lĂˇtvĂˇnyos grafikon kerĂĽlt: <em>Havi adomĂˇnyok</em> oszlopdiagram (utolsĂł 12 hĂłnap), <em>Kapcsolatok nĂ¶vekedĂ©se</em> kettĹ‘s-tengelyes vonaldiagram, Ă©s <em>Kapcsolatok megoszlĂˇsa</em> fĂˇnkdiagram stĂˇtusz szerint. A grafikonok valĂłs adatbĂˇzis-adatokat jelenĂ­tenek meg.',
             'en' => '<strong>Dashboard charts (Chart.js):</strong> Three charts added to the homepage: <em>Monthly donations</em> bar chart (last 12 months), <em>Contact growth</em> dual-axis line chart (contacts + donations), and <em>Contact distribution</em> donut chart by status with custom percentage legend. Charts display live database data.'],
        ],
    ],

    [
        'version' => 'v1.6.0',
        'date' => ['hu' => '2026. mĂˇjus 2.', 'en' => 'May 2, 2026'],
        'items' => [
            ['hu' => '<strong>FelhasznĂˇlĂłk â†” Csoportok hozzĂˇrendelĂ©s:</strong> A rendszer felhasznĂˇlĂłi mostantĂłl csoportokhoz rendelhetĹ‘k â€” kĂĽlĂ¶n <code>group_user</code> pivot tĂˇbla Ă©s M:N kapcsolat a <code>User</code> Ă©s <code>Group</code> modellek kĂ¶zĂ¶tt.',
             'en' => '<strong>Users â†” Groups assignment:</strong> System users can now be assigned to groups â€” separate <code>group_user</code> pivot table and M:N relationship between the <code>User</code> and <code>Group</code> models.'],
            ['hu' => '<strong>Csoportok rĂ©szletoldala â€” FelhasznĂˇlĂłk megjelenĂ­tĂ©se:</strong> A csoport tagok listĂˇjĂˇban mostantĂłl a FelhasznĂˇlĂłk is szerepelnek a Kapcsolatok mellett, megjelĂ¶lve a tĂ­pusukat (Kapcsolat / FelhasznĂˇlĂł), szerepkĂ¶rĂĽk badge-dzsel ellĂˇtva.',
             'en' => '<strong>Group detail page â€” User display:</strong> Users now appear alongside Contacts in the group members list, labeled with their type (Contact / User) and a role badge.'],
            ['hu' => '<strong>Chip/pill csoport-vĂˇlasztĂł:</strong> A Kapcsolatok Ă©s FelhasznĂˇlĂłk szerkesztĹ‘ modaljaiban a nehĂ©zkes tĂ¶bbvĂˇlasztĂłs listĂˇt letisztult, kattinthatĂł chip-gombok vĂˇltjĂˇk fel â€” egyetlen kattintĂˇssal aktivĂˇlhatĂł/deaktivĂˇlhatĂł minden csoport.',
             'en' => '<strong>Chip/pill group selector:</strong> In the Contacts and Users edit modals, the cumbersome multi-select list was replaced by clean, clickable chip buttons â€” each group can be toggled with a single click.'],
            ['hu' => '<strong>JelszĂł szem ikon (FelhasznĂˇlĂłk):</strong> A FelhasznĂˇlĂłk lĂ©trehozĂˇs Ă©s szerkesztĂ©s modalokban a jelszĂł- Ă©s jelszĂł-megerĹ‘sĂ­tĂ©s mezĹ‘k mellĂ© szem ikon kerĂĽlt, amellyel a beĂ­rt jelszĂł lĂˇthatĂłvĂˇ tehetĹ‘.',
             'en' => '<strong>Password eye icon (Users):</strong> An eye icon was added to the password and password confirmation fields in the Users create and edit modals, allowing the entered password to be shown/hidden.'],
            ['hu' => '<strong>JelszĂł validĂˇciĂłs javĂ­tĂˇs:</strong> FelhasznĂˇlĂł szerkesztĂ©sekor az ĂĽres jelszĂł mezĹ‘k mĂˇr nem okoznak validĂˇciĂłs hibĂˇt â€” a <code>confirmed</code> szabĂˇly csak akkor fut le, ha tĂ©nylegesen van megadott jelszĂł.',
             'en' => '<strong>Password validation fix:</strong> When editing a user, empty password fields no longer cause validation errors â€” the <code>confirmed</code> rule only runs if a password is actually entered.'],
            ['hu' => '<strong>OldalsĂˇv logo csere:</strong> A bal felsĹ‘ sarokbeli ikon lecserĂ©lve a NationForge mĂˇrkakĂ©pnek megfelelĹ‘ sĂ¶tĂ©tkĂ©k hatszĂ¶g alapĂş â€žN" logĂłra, vilĂˇgoskĂ©k szegĂ©llyel.',
             'en' => '<strong>Sidebar logo replacement:</strong> The icon in the top-left corner was replaced with a NationForge-branded dark blue hexagon "N" logo with a light blue border.'],
            ['hu' => '<strong>OldalsĂˇv menĂĽ egyszerĹ±sĂ­tĂ©se:</strong> A CRM Ă©s AdminisztrĂˇciĂł legĂ¶rdĂĽlĹ‘ almenĂĽk megszĹ±ntek â€” a Kapcsolatok, Csoportok, FelhasznĂˇlĂłk, BeĂˇllĂ­tĂˇsok, VerziĂłkĂ¶vetĂ©s Ă©s SĂşgĂł mostantĂłl kĂ¶zvetlen menĂĽpontokkĂ©nt Ă©rhetĹ‘k el.',
             'en' => '<strong>Sidebar menu simplification:</strong> The CRM and Administration dropdown submenus were removed â€” Contacts, Groups, Users, Settings, Changelog and Help are now directly accessible as standalone menu items.'],
        ],
    ],

    [
        'version' => 'v1.5.2',
        'date' => ['hu' => '2026. mĂˇjus 2.', 'en' => 'May 2, 2026'],
        'items' => [
            ['hu' => '<strong>FĹ‘oldal (Dashboard) vizuĂˇlis finomĂ­tĂˇsa:</strong> A "LegĂşjabb kapcsolatok" listĂˇjĂˇnak igazĂ­tĂˇsa, a megjelenĂ­tett tartalmak megfelelĹ‘ bal oldali belsĹ‘ margĂłt kaptak a szebb elrendezĂ©s Ă©rdekĂ©ben.',
             'en' => '<strong>Dashboard visual refinement:</strong> Alignment of the "Latest contacts" list; displayed items received proper left padding for a cleaner layout.'],
            ['hu' => '<strong>SĂşgĂł â€” Dinamikus kĂ©pmegjelenĂ­tĂ©s:</strong> A sĂşgĂł cikkekhez integrĂˇlĂˇsra kerĂĽlt egy teljes kĂ©pernyĹ‘s kĂ©pnĂ©zegetĹ‘ (lightbox) funkciĂł.',
             'en' => '<strong>Help â€” Dynamic image display:</strong> A full-screen image viewer (lightbox) function was integrated for help articles.'],
            ['hu' => '<strong>KĂ©pnagyĂ­tĂˇs Ă©lmĂ©ny javĂ­tĂˇsa:</strong> A lightbox finomhangolĂˇsa, Ă­gy a feltĂ¶ltĂ¶tt kĂ©pek kattintĂˇskor a kĂ©pernyĹ‘ 90%-Ăˇt dinamikusan kitĂ¶ltve jelennek meg, megtartva az eredeti mĂ©retarĂˇnyokat.',
             'en' => '<strong>Image zoom experience improvement:</strong> Lightbox fine-tuning so that uploaded images appear dynamically filling 90% of the screen on click, maintaining original aspect ratios.'],
        ],
    ],

    [
        'version' => 'v1.5.1',
        'date' => ['hu' => '2026. mĂˇjus 1.', 'en' => 'May 1, 2026'],
        'items' => [
            ['hu' => '<strong>ElrendezĂ©s Ă©s gĂ¶rgetĂ©s javĂ­tĂˇsa:</strong> A teljes admin felĂĽlet layoutjĂˇnak optimalizĂˇlĂˇsa (CSS <code>calc</code> hasznĂˇlata a Flexbox korlĂˇtok helyett), Ă­gy a hosszĂş tartalmak tĂ¶kĂ©letesen gĂ¶rgethetĹ‘k maradnak.',
             'en' => '<strong>Layout and scroll fix:</strong> Full admin interface layout optimization (using CSS <code>calc</code> instead of Flexbox constraints) so long content scrolls correctly.'],
            ['hu' => '<strong>Dinamikus szĂˇmlĂˇlĂłk a menĂĽben:</strong> A bal oldali menĂĽsĂˇv mostantĂłl valĂłs idĹ‘ben mutatja az adatbĂˇzisban lĂ©vĹ‘ rekordok pontos szĂˇmĂˇt a modulok (Kapcsolatok, Projektek stb.) mellett.',
             'en' => '<strong>Dynamic counters in menu:</strong> The left sidebar now shows the exact count of database records next to each module (Contacts, Projects, etc.) in real time.'],
            ['hu' => '<strong>Livewire 404 hiba javĂ­tĂˇsa Forge-on:</strong> A rendszer automatikusan publikĂˇlja a Livewire asseteket telepĂ­tĂ©skor (<code>post-autoload-dump</code>), Ă©s be lett ĂˇllĂ­tva a pontos statikus fizikai elĂ©rĂ©si Ăşt, kikĂĽszĂ¶bĂ¶lve a Nginx hibĂˇs <code>.js</code> fĂˇjl kiszolgĂˇlĂˇsĂˇt.',
             'en' => '<strong>Livewire 404 fix on Forge:</strong> The system automatically publishes Livewire assets on deployment (<code>post-autoload-dump</code>), and the exact static physical path was configured, eliminating Nginx\'s incorrect <code>.js</code> file serving on the production server.'],
            ['hu' => '<strong>Beragadt csomagok takarĂ­tĂˇsa:</strong> A Filament vĂ©gleges eltĂˇvolĂ­tĂˇsĂˇnak utolsĂł lĂ©pĂ©sekĂ©nt a felesleges <code>filament:upgrade</code> parancs kikerĂĽlt a Composer folyamatbĂłl, ami eddig telepĂ­tĂ©si hibĂˇt okozott.',
             'en' => '<strong>Stuck package cleanup:</strong> As the final step of removing Filament, the unnecessary <code>filament:upgrade</code> command was removed from the Composer process, which was previously causing installation errors.'],
        ],
    ],

    [
        'version' => 'v1.5.0',
        'date' => ['hu' => '2026. mĂˇjus 1.', 'en' => 'May 1, 2026'],
        'items' => [
            ['hu' => '<strong>Sor kattintĂˇsra szerkesztĂ©s â€” Csoportok:</strong> Az egĂ©sz tĂˇblĂˇzatsor kattinthatĂł, megnyitja a szerkesztĹ‘ modalt. Ăšj szemikon (đź‘) navigĂˇl a rĂ©szletoldalra az akciĂłsĂˇvban.',
             'en' => '<strong>Row click to edit â€” Groups:</strong> The entire table row is clickable, opening the edit modal. A new eye icon (đź‘) navigates to the detail page from the action bar.'],
            ['hu' => '<strong>Sor kattintĂˇsra szerkesztĂ©s â€” EsemĂ©nyek:</strong> Ugyanez a viselkedĂ©s az EsemĂ©nyek listĂˇban, kĂĽlĂ¶n MegnyitĂˇs gombbal a rĂ©szletoldalhoz.',
             'en' => '<strong>Row click to edit â€” Events:</strong> The same behavior in the Events list, with a separate Open button for the detail page.'],
            ['hu' => '<strong>Sor kattintĂˇsra szerkesztĂ©s â€” Feladatok:</strong> A feladatlista sorai kattinthatĂłk; a stĂˇtusz dropdown Ă©s a tĂ¶rlĂ©s gomb nem indĂ­tja el a szerkesztĹ‘t (stopPropagation).',
             'en' => '<strong>Row click to edit â€” Tasks:</strong> Task list rows are clickable; the status dropdown and delete button don\'t trigger the editor (stopPropagation).'],
            ['hu' => '<strong>data-* attribĂştum alapĂş megkĂ¶zelĂ­tĂ©s:</strong> Az inline JS argumentumok helyett HTML data-attribĂştumok tĂˇroljĂˇk az adatokat â€” megbĂ­zhatĂłbb, speciĂˇlis karakterek Ă©s Ă©kezetek sem okoznak problĂ©mĂˇt.',
             'en' => '<strong>data-* attribute approach:</strong> HTML data attributes store the data instead of inline JS arguments â€” more reliable, special characters and accented letters cause no issues.'],
            ['hu' => '<strong>URL generĂˇlĂˇs javĂ­tĂˇsa (feladatok):</strong> A szerkesztĹ‘ form action URL-je Blade <code>url()</code> helperrel generĂˇlĂłdik, Ă­gy XAMPP al-kĂ¶nyvtĂˇrban is helyes az Ăştvonal.',
             'en' => '<strong>URL generation fix (tasks):</strong> The editor form action URL is generated with the Blade <code>url()</code> helper, so the path is correct even in XAMPP subdirectories.'],
        ],
    ],

    [
        'version' => 'v1.4.0',
        'badge' => [
            'text'  => ['hu' => 'Ăšj modul', 'en' => 'New module'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => '2026. mĂˇjus 1.', 'en' => 'May 1, 2026'],
        'items' => [
            ['hu' => '<strong>ProjektkezelĹ‘ modul:</strong> Teljes CRUD â€” projektek lĂ©trehozĂˇsa, szerkesztĂ©se, tĂ¶rlĂ©se. StĂˇtusz (tervezĂ©s / aktĂ­v / lezĂˇrt / felfĂĽggesztve) Ă©s prioritĂˇs (alacsony / kĂ¶zepes / magas) kezelĂ©ssel.',
             'en' => '<strong>Project management module:</strong> Full CRUD â€” create, edit, delete projects. With status (planning / active / completed / on hold) and priority (low / medium / high) management.'],
            ['hu' => '<strong>Projektâ€“Feladat kapcsolat:</strong> Feladatok projektekhez rendelhetĹ‘k; a projekt rĂ©szletoldalĂˇn lĂˇthatĂł az Ă¶sszes kapcsolĂłdĂł feladat.',
             'en' => '<strong>Projectâ€“Task relationship:</strong> Tasks can be assigned to projects; all related tasks are visible on the project detail page.'],
            ['hu' => '<strong>HaladĂˇsjelzĹ‘ (Progress %):</strong> A projekt elĹ‘rehaladĂˇsa automatikusan szĂˇmĂ­tĂłdik a kĂ©sz feladatok arĂˇnya alapjĂˇn, vizuĂˇlis progress bar-ral.',
             'en' => '<strong>Progress indicator (Progress %):</strong> Project progress is automatically calculated based on the ratio of completed tasks, with a visual progress bar.'],
            ['hu' => '<strong>Projekt rĂ©szletoldal (show):</strong> Bal oszlop: metaadatok, haladĂˇs, statisztikĂˇk (nyitott / folyamatban / kĂ©sz feladatszĂˇmok). Jobb oszlop: feladatlista inline stĂˇtuszvĂˇltĂłval.',
             'en' => '<strong>Project detail page (show):</strong> Left column: metadata, progress, statistics (open / in progress / done task counts). Right column: task list with inline status switcher.'],
            ['hu' => '<strong>LejĂˇrt projekt jelzĂ©s:</strong> Ha a projekt hatĂˇrideje elmĂşlt Ă©s mĂ©g nincs lezĂˇrva, piros â€žLejĂˇrt" badge jelenik meg.',
             'en' => '<strong>Overdue project indicator:</strong> If the project deadline has passed and it\'s not yet closed, a red "Overdue" badge appears.'],
            ['hu' => '<strong>Projekt szĹ±rĹ‘ a feladatlistĂˇban:</strong> A Feladatok oldalon projekt szerint is szĹ±rhetĹ‘ a lista, beleĂ©rtve a â€žProjekt nĂ©lkĂĽli" feladatok szĹ±rĹ‘jĂ©t.',
             'en' => '<strong>Project filter in task list:</strong> On the Tasks page, the list can be filtered by project, including a "No project" filter option.'],
        ],
    ],

    [
        'version' => 'v1.3.0',
        'badge' => [
            'text'  => ['hu' => 'Ăšj modul', 'en' => 'New module'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => '2026. mĂˇjus 1.', 'en' => 'May 1, 2026'],
        'items' => [
            ['hu' => '<strong>FeladatkezelĹ‘ modul:</strong> Teljes CRUD â€” feladatok lĂ©trehozĂˇsa, szerkesztĂ©se, tĂ¶rlĂ©se. PrioritĂˇs (alacsony / kĂ¶zepes / magas / sĂĽrgĹ‘s) Ă©s stĂˇtusz (nyitott / folyamatban / kĂ©sz) kezelĂ©ssel.',
             'en' => '<strong>Task management module:</strong> Full CRUD â€” create, edit, delete tasks. With priority (low / medium / high / urgent) and status (open / in progress / done) management.'],
            ['hu' => '<strong>Inline stĂˇtuszvĂˇltĂł:</strong> A feladatlista tĂˇblĂˇzatĂˇban kĂ¶zvetlenĂĽl vĂˇlthatĂł a stĂˇtusz legĂ¶rdĂĽlĹ‘ menĂĽbĹ‘l, oldal-ĂşjratĂ¶ltĂ©s nĂ©lkĂĽl.',
             'en' => '<strong>Inline status switcher:</strong> Status can be changed directly from a dropdown in the task list table, without page reload (form submit).'],
            ['hu' => '<strong>FelelĹ‘s hozzĂˇrendelĂ©s:</strong> Minden feladathoz rendelhetĹ‘ felelĹ‘s felhasznĂˇlĂł; az admin panel felhasznĂˇlĂłi listĂˇjĂˇbĂłl vĂˇlaszthatĂł.',
             'en' => '<strong>Assignee assignment:</strong> Every task can be assigned to a responsible user; selectable from the admin panel\'s user list.'],
            ['hu' => '<strong>HatĂˇridĹ‘ Ă©s lejĂˇrat jelzĂ©s:</strong> LejĂˇrt feladatoknĂˇl piros dĂˇtumszĂ­n Ă©s â€žLejĂˇrt" badge figyelmezteti az adminisztrĂˇtort.',
             'en' => '<strong>Deadline and overdue indicator:</strong> For overdue tasks, a red date color and "Overdue" badge warns the administrator.'],
            ['hu' => '<strong>Statisztikai kĂˇrtyĂˇk:</strong> A feladatlista tetejĂ©n Ă¶sszesĂ­tĹ‘k jelennek meg: Ă¶sszes / nyitott / folyamatban / kĂ©sz darabszĂˇmokkal, amelyek szĹ±rĹ‘kĂ©nt is mĹ±kĂ¶dnek.',
             'en' => '<strong>Statistics cards:</strong> Summaries appear at the top of the task list: total / open / in progress / done counts, which also work as filters.'],
            ['hu' => '<strong>Sidebar badge:</strong> A navigĂˇciĂłs sĂˇvban a Feladatok menĂĽpont mellett Ă©lĹ‘ szĂˇmlĂˇlĂł mutatja az aktĂ­v (nyitott + folyamatban) feladatok szĂˇmĂˇt.',
             'en' => '<strong>Sidebar badge:</strong> In the navigation bar, a live counter next to the Tasks menu item shows the number of active (open + in progress) tasks.'],
            ['hu' => '<strong>GitHub szinkronizĂˇciĂł:</strong> <code>gitupdate.bat</code> szkript a projekt automatikus feltĂ¶ltĂ©sĂ©hez a GitHub repĂłba, XAMPP jogosultsĂˇgi fix-szel.',
             'en' => '<strong>GitHub synchronization:</strong> <code>gitupdate.bat</code> script for automatically pushing the project to GitHub, with XAMPP permissions fix.'],
        ],
    ],

    [
        'version' => 'v1.2.0',
        'badge' => [
            'text'  => ['hu' => 'FejlesztĂ©s', 'en' => 'Improvement'],
            'style' => 'background:rgba(247,184,75,0.12);color:#c9920a;',
        ],
        'date' => ['hu' => '2026. mĂˇjus 1.', 'en' => 'May 1, 2026'],
        'items' => [
            ['hu' => '<strong>Magyar bejelentkezĂ©si felĂĽlet:</strong> Az Ă¶sszes login oldal szĂ¶vege (E-mail, JelszĂł, BejelentkezĂ©s, hibaĂĽzenetek) teljes egĂ©szĂ©ben magyarra lett fordĂ­tva JSON Ă©s PHP nyelvi fĂˇjlok segĂ­tsĂ©gĂ©vel.',
             'en' => '<strong>Localized login interface:</strong> All login page text (Email, Password, Login, error messages) was fully translated using JSON and PHP language files.'],
            ['hu' => '<strong>JelszĂł megjelenĂ­tĹ‘ szem ikon:</strong> A jelszĂł beviteli mezĹ‘ jobb szĂ©lĂ©n toggle gomb jelenik meg, amellyel a jelszĂł lĂˇthatĂłvĂˇ / elrejtettĂ© tehetĹ‘ (Alpine.js <code>x-bind:type</code>).',
             'en' => '<strong>Password show eye icon:</strong> A toggle button appears on the right side of the password field, allowing the password to be shown/hidden (Alpine.js <code>x-bind:type</code>).'],
            ['hu' => '<strong>KĂĽlĂ¶nĂˇllĂł admin bejelentkezĂ©s:</strong> Az <code>/admin/login</code> route kĂĽlĂ¶nĂˇllĂł Volt komponenssel rendelkezik; sikeres belĂ©pĂ©s utĂˇn az admin dashboardra irĂˇnyĂ­t.',
             'en' => '<strong>Separate admin login:</strong> The <code>/admin/login</code> route has a dedicated Volt component; after successful login it redirects to the admin dashboard, showing an error for non-admin users.'],
            ['hu' => '<strong>Admin login hĂˇttĂ©rkĂ©p:</strong> Az admin bejelentkezĂ©si oldalon teljes kĂ©pernyĹ‘s hĂˇttĂ©rkĂ©p lĂˇthatĂł, a bejelentkezĂ©si panel a jobb oldalon fĂ©lĂˇtlĂˇtszĂł, blur-hatĂˇsĂş kĂˇrtyĂˇban helyezkedik el.',
             'en' => '<strong>Admin login background image:</strong> The admin login page features a full-screen background image, with the login panel on the right in a semi-transparent, blur-effect card.'],
            ['hu' => '<strong>AdminMiddleware javĂ­tĂˇs:</strong> Nem bejelentkezett felhasznĂˇlĂł esetĂ©n a middleware az <code>admin.login</code> route-ra irĂˇnyĂ­t (korĂˇbban 403 hibĂˇt dobott).',
             'en' => '<strong>AdminMiddleware fix:</strong> For non-logged-in users, the middleware now redirects to the <code>admin.login</code> route (previously threw a 403 error).'],
        ],
    ],

    [
        'version' => 'v1.1.0',
        'badge' => [
            'text'  => ['hu' => 'FejlesztĂ©s', 'en' => 'Improvement'],
            'style' => 'background:rgba(247,184,75,0.12);color:#c9920a;',
        ],
        'date' => ['hu' => '2026. Ăˇprilis', 'en' => 'April 2026'],
        'items' => [
            ['hu' => '<strong>Ă–nĂˇllĂł SĂşgĂł oldal kialakĂ­tĂˇsa:</strong> A sĂşgĂł popup rendszert levĂˇltotta egy elegĂˇns, teljes oldalas megjelenĂ­tĂ©s.',
             'en' => '<strong>Standalone Help page:</strong> The help popup system was replaced by an elegant, full-page display.'],
            ['hu' => '<strong>Markdown tĂˇmogatĂˇs:</strong> A sĂşgĂł cikkeket mostantĂłl Markdown formĂˇtummal is lehet rendszerezni (fĂ©lkĂ¶vĂ©r, cĂ­msorok stb.).',
             'en' => '<strong>Markdown support:</strong> Help articles can now use Markdown formatting (bold, headings, etc.).'],
            ['hu' => '<strong>AdatbĂˇzis korrekciĂłk:</strong> A sĂşgĂł alapĂ©rtelmezett cikkei nyelvtanilag tĂ¶kĂ©letes, magyar Ă©kezetes formĂˇban kerĂĽltek rĂ¶gzĂ­tĂ©sre.',
             'en' => '<strong>Database corrections:</strong> The default help articles were stored in grammatically correct form.'],
            ['hu' => '<strong>VerziĂłkĂ¶vetĂ©s (Changelog):</strong> LĂ©trehozĂˇsra kerĂĽlt ez a menĂĽpont a fejlesztĂ©sek Ă©s az eddigi munka ĂˇttekintĂ©sĂ©re.',
             'en' => '<strong>Changelog:</strong> This menu item was created to track and review all developments.'],
        ],
    ],

    [
        'version' => 'v1.0.0',
        'badge' => [
            'text'  => ['hu' => 'MĂ©rfĂ¶ldkĹ‘', 'en' => 'Milestone'],
            'style' => 'background:rgba(64,81,137,0.1);color:#405189;',
        ],
        'date' => ['hu' => 'IndulĂˇs, Alaprendszer', 'en' => 'Launch, Core system'],
        'items' => [
            ['hu' => '<strong>KĂ¶rnyezet kialakĂ­tĂˇsa:</strong> XAMPP kompatibilitĂˇs, URL routing fixek, Laravel 12.56 beĂˇllĂ­tĂˇs.',
             'en' => '<strong>Environment setup:</strong> XAMPP compatibility, URL routing fixes, Laravel 12.56 configuration.'],
            ['hu' => '<strong>Admin felĂĽlet ĂşjjĂˇĂ©pĂ­tĂ©se:</strong> Filament eltĂˇvolĂ­tĂˇsa, gyorsabb, modern Velzon-stĂ­lusĂş egyedi Tailwind panellĂ©.',
             'en' => '<strong>Admin interface rebuild:</strong> Filament removed, replaced with a faster, modern Velzon-style custom Tailwind panel.'],
            ['hu' => '<strong>JogosultsĂˇgkezelĂ©s:</strong> Spatie Permission alapĂş szerepkĂ¶rĂ¶k (super-admin, admin, editor, member) bevezetĂ©se.',
             'en' => '<strong>Access control:</strong> Spatie Permission-based roles (super-admin, admin, editor, member) introduced.'],
            ['hu' => '<strong>Kapcsolatok (CRM):</strong> Emberek, stĂˇtuszok, elĹ‘fizetĂ©sek, Ă©s rĂ©szletes profiladatok nyilvĂˇntartĂˇsa fejlesztve.',
             'en' => '<strong>Contacts (CRM):</strong> People, statuses, subscriptions, and detailed profile data tracking developed.'],
            ['hu' => '<strong>Csoportok modul:</strong> Kapcsolatok tematikus elrendezĂ©se csoportokba M:N kapcsolatokon keresztĂĽl.',
             'en' => '<strong>Groups module:</strong> Thematic arrangement of contacts into groups through M:N relationships.'],
            ['hu' => '<strong>EsemĂ©nyek kezelĂ©se:</strong> EsemĂ©nyek CRUD felĂĽlete naptĂˇri validĂˇciĂłval, RSVP elĹ‘kĂ©szĂ­tĂ©ssel.',
             'en' => '<strong>Events management:</strong> Events CRUD interface with calendar validation and RSVP preparation.'],
            ['hu' => '<strong>AdomĂˇnyok megtekintĂ©se:</strong> TranzakciĂłlista a pĂ©nzĂĽgyi transzferek kĂ¶nnyĹ± nyomonkĂ¶vetĂ©sĂ©hez.',
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
        content: 'âť–';
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
