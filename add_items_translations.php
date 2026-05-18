<?php
$file = 'c:/xampp/htdocs/nationforge/resources/views/admin/partials/changelog_content.blade.php';
$content = file_get_contents($file);

// Items translations: [search_en_text => [de, ro, sk]]
// We'll do str_replace on each item's 'en' => '...' portion and append de/ro/sk

// Helper: add de/ro/sk after 'en' => '...' in an item
// Pattern: ['hu' => '...', 'en' => '...'],
// Replace with: ['hu' => '...', 'en' => '...', 'de' => '...', 'ro' => '...', 'sk' => '...'],

$items = [

// v1.25.0
[
'en' => '<strong>Google Calendar / iCal sync:</strong> Public iCal feed (<code>/events.ics</code>) — all published events are now subscribable in any calendar app (Google Calendar, Apple Calendar, Outlook). The URL shown on the Integrations page can be added to Google Calendar in a single click.',
'de' => '<strong>Google Calendar / iCal-Synchronisation:</strong> Öffentlicher iCal-Feed (<code>/events.ics</code>) — alle veröffentlichten Ereignisse können nun in jeder Kalender-App abonniert werden (Google Calendar, Apple Calendar, Outlook). Die auf der Integrationsseite angezeigte URL kann mit einem Klick zu Google Calendar hinzugefügt werden.',
'ro' => '<strong>Sincronizare Google Calendar / iCal:</strong> Feed iCal public (<code>/events.ics</code>) — toate evenimentele publicate pot fi acum abonate în orice aplicație de calendar (Google Calendar, Apple Calendar, Outlook). URL-ul afișat pe pagina Integrări poate fi adăugat la Google Calendar cu un singur clic.',
'sk' => '<strong>Synchronizácia Google Calendar / iCal:</strong> Verejný iCal feed (<code>/events.ics</code>) — všetky zverejnené udalosti je teraz možné odoberať v ľubovoľnej kalendárovej aplikácii (Google Calendar, Apple Calendar, Outlook). URL zobrazená na stránke Integrácie sa dá pridať do Google Kalendára jediným kliknutím.',
],
[
'en' => '<strong>Facebook Event publisher:</strong> A <em>Publish to Facebook</em> button appears on published event pages, creating the event on the configured Facebook Page via Graph API v19.0. The Page ID and Page Access Token are configured on the Integrations page.',
'de' => '<strong>Facebook-Ereignis-Veröffentlicher:</strong> Ein <em>Auf Facebook veröffentlichen</em>-Button erscheint auf veröffentlichten Ereignisseiten und erstellt das Ereignis auf der konfigurierten Facebook-Seite über die Graph API v19.0. Die Seiten-ID und der Seiten-Zugriffstoken werden auf der Integrationsseite konfiguriert.',
'ro' => '<strong>Publisher de evenimente Facebook:</strong> Un buton <em>Publică pe Facebook</em> apare pe paginile de evenimente publicate, creând evenimentul pe Pagina Facebook configurată prin Graph API v19.0. ID-ul paginii și Token-ul de acces al paginii sunt configurate pe pagina Integrări.',
'sk' => '<strong>Publikátor udalostí na Facebooku:</strong> Tlačidlo <em>Zverejniť na Facebooku</em> sa zobrazuje na stránkach zverejnených udalostí a vytvára udalosť na nakonfigurovanej stránke Facebook prostredníctvom Graph API v19.0. ID stránky a prístupový token stránky sa konfigurujú na stránke Integrácie.',
],
[
'en' => '<strong>Zapier & Make (Integromat) integration:</strong> Built on the existing outgoing webhook system (v1.24.0). The new Integrations page provides a step-by-step guide on how to connect Zapier Catch Hook and Make Custom Webhook triggers to NationForge — no code required.',
'de' => '<strong>Zapier & Make (Integromat) Integration:</strong> Basiert auf dem bestehenden ausgehenden Webhook-System (v1.24.0). Die neue Integrationsseite bietet eine Schritt-für-Schritt-Anleitung zur Verbindung von Zapier Catch Hook und Make Custom Webhook-Triggern mit NationForge — kein Code erforderlich.',
'ro' => '<strong>Integrare Zapier & Make (Integromat):</strong> Construit pe sistemul de webhook-uri de ieșire existent (v1.24.0). Noua pagină Integrări oferă un ghid pas cu pas despre cum să conectați Zapier Catch Hook și declanșatoarele Make Custom Webhook la NationForge — nu este necesar cod.',
'sk' => '<strong>Integrácia Zapier & Make (Integromat):</strong> Postavená na existujúcom systéme odchádzajúcich webhookov (v1.24.0). Nová stránka Integrácie poskytuje podrobného sprievodcu, ako prepojiť Zapier Catch Hook a Make Custom Webhook spúšťače s NationForge — nevyžaduje sa žiadny kód.',
],
[
'en' => '<strong>Integrations menu item in sidebar:</strong> All external integrations are accessible from a dedicated <em>Integrations</em> page — Google Calendar URL copy, Facebook token configuration, and the Zapier/Make guide all in one place.',
'de' => '<strong>Integrationen-Menüpunkt in der Seitenleiste:</strong> Alle externen Integrationen sind über eine dedizierte <em>Integrationen</em>-Seite zugänglich — Google Calendar URL-Kopie, Facebook-Token-Konfiguration und die Zapier/Make-Anleitung an einem Ort.',
'ro' => '<strong>Element de meniu Integrări în bara laterală:</strong> Toate integrările externe sunt accesibile de pe o pagină dedicată <em>Integrări</em> — copierea URL-ului Google Calendar, configurarea token-ului Facebook și ghidul Zapier/Make, toate într-un singur loc.',
'sk' => '<strong>Položka menu Integrácie v bočnom paneli:</strong> Všetky externé integrácie sú dostupné z dedikovanej stránky <em>Integrácie</em> — kopírovanie URL Google Kalendára, konfigurácia tokenu Facebooku a sprievodca Zapier/Make na jednom mieste.',
],

// v1.24.0
[
'en' => '<strong>Outgoing webhooks:</strong> Configurable HTTP POST to any URL on system events. 12 event types: <code>contact.*</code>, <code>event.*</code>, <code>donation.created</code>, <code>campaign.sent</code>, <code>task.*</code>, <code>drip.enrolled</code>. HMAC-SHA256 signing (<code>X-NationForge-Signature</code>). Delivery log with per-attempt status, HTTP code and response body. Automatic retry (3 attempts, 60 s backoff) via queue. Manual retry for failed deliveries from the admin UI.',
'de' => '<strong>Ausgehende Webhooks:</strong> Konfigurierbares HTTP POST an eine beliebige URL bei Systemereignissen. 12 Ereignistypen: <code>contact.*</code>, <code>event.*</code>, <code>donation.created</code>, <code>campaign.sent</code>, <code>task.*</code>, <code>drip.enrolled</code>. HMAC-SHA256-Signierung (<code>X-NationForge-Signature</code>). Zustellungsprotokoll mit Status pro Versuch, HTTP-Code und Antworttext. Automatischer Wiederholungsversuch (3 Versuche, 60 s Backoff) über Queue. Manueller Wiederholungsversuch für fehlgeschlagene Zustellungen aus der Admin-Oberfläche.',
'ro' => '<strong>Webhook-uri de ieșire:</strong> HTTP POST configurabil la orice URL la evenimentele sistemului. 12 tipuri de evenimente: <code>contact.*</code>, <code>event.*</code>, <code>donation.created</code>, <code>campaign.sent</code>, <code>task.*</code>, <code>drip.enrolled</code>. Semnare HMAC-SHA256 (<code>X-NationForge-Signature</code>). Jurnal de livrare cu starea per-tentativă, codul HTTP și corpul răspunsului. Reîncercare automată (3 tentative, 60 s backoff) prin coadă. Reîncercare manuală pentru livrările eșuate din interfața de administrare.',
'sk' => '<strong>Odchádzajúce webhooky:</strong> Konfigurovateľný HTTP POST na ľubovoľnú URL pri systémových udalostiach. 12 typov udalostí: <code>contact.*</code>, <code>event.*</code>, <code>donation.created</code>, <code>campaign.sent</code>, <code>task.*</code>, <code>drip.enrolled</code>. Podpisovanie HMAC-SHA256 (<code>X-NationForge-Signature</code>). Protokol doručenia so stavom za pokus, HTTP kódom a telom odpovede. Automatické opakovanie (3 pokusy, 60 s backoff) cez frontu. Manuálne opakovanie pre neúspešné doručenia z administrátorského rozhrania.',
],

// v1.23.0
[
'en' => '<strong>Multilingual help (DE / RO / SK):</strong> The help documentation is now available in five languages: Hungarian, English, <em>German, Romanian and Slovak</em>. All 16 help articles are fully translated. The language switcher is available in the help sidebar — the selected language takes effect immediately.',
'de' => '<strong>Mehrsprachige Hilfe (DE / RO / SK):</strong> Die Hilfedokumentation ist jetzt in fünf Sprachen verfügbar: Ungarisch, Englisch, <em>Deutsch, Rumänisch und Slowakisch</em>. Alle 16 Hilfeartikel sind vollständig übersetzt. Der Sprachumschalter ist in der Hilfe-Seitenleiste verfügbar — die ausgewählte Sprache wirkt sofort.',
'ro' => '<strong>Ajutor multilingv (DE / RO / SK):</strong> Documentația de ajutor este acum disponibilă în cinci limbi: maghiară, engleză, <em>germană, română și slovacă</em>. Toate cele 16 articole de ajutor sunt complet traduse. Selectorul de limbă este disponibil în bara laterală a ajutorului — limba selectată intră în vigoare imediat.',
'sk' => '<strong>Viacjazyčná pomoc (DE / RO / SK):</strong> Dokumentácia pomocníka je teraz dostupná v piatich jazykoch: maďarčina, angličtina, <em>nemčina, rumunčina a slovenčina</em>. Všetkých 16 článkov pomocníka je plne preložených. Prepínač jazykov je dostupný v bočnom paneli pomocníka — vybraný jazyk sa uplatní okamžite.',
],
[
'en' => '<strong>Database schema extension:</strong> Six new nullable text columns were added to the <code>help_articles</code> table: <code>title_de</code>, <code>content_de</code>, <code>title_ro</code>, <code>content_ro</code>, <code>title_sk</code>, <code>content_sk</code>.',
'de' => '<strong>Datenbankschema-Erweiterung:</strong> Sechs neue nullable Textspalten wurden zur Tabelle <code>help_articles</code> hinzugefügt: <code>title_de</code>, <code>content_de</code>, <code>title_ro</code>, <code>content_ro</code>, <code>title_sk</code>, <code>content_sk</code>.',
'ro' => '<strong>Extinderea schemei bazei de date:</strong> Șase noi coloane de text nullable au fost adăugate la tabelul <code>help_articles</code>: <code>title_de</code>, <code>content_de</code>, <code>title_ro</code>, <code>content_ro</code>, <code>title_sk</code>, <code>content_sk</code>.',
'sk' => '<strong>Rozšírenie schémy databázy:</strong> Do tabuľky <code>help_articles</code> bolo pridaných šesť nových stĺpcov nullable textu: <code>title_de</code>, <code>content_de</code>, <code>title_ro</code>, <code>content_ro</code>, <code>title_sk</code>, <code>content_sk</code>.',
],
[
'en' => '<strong>Help editor — DE / RO / SK tabs:</strong> The admin help editor modal now includes Deutsch, Română and Slovenčina tabs, allowing all language content to be edited from one place.',
'de' => '<strong>Hilfe-Editor — DE / RO / SK Tabs:</strong> Das Admin-Hilfe-Editor-Modal enthält jetzt Tabs für Deutsch, Română und Slovenčina, sodass alle Sprachinhalte von einem Ort aus bearbeitet werden können.',
'ro' => '<strong>Editor ajutor — file DE / RO / SK:</strong> Modalul de editare al ajutorului de administrare include acum file pentru Deutsch, Română și Slovenčina, permițând editarea conținutului în toate limbile dintr-un singur loc.',
'sk' => '<strong>Editor pomocníka — karty DE / RO / SK:</strong> Modálne okno editora pomocníka v administrácii teraz obsahuje karty Deutsch, Română a Slovenčina, čo umožňuje upravovať obsah vo všetkých jazykoch z jedného miesta.',
],
[
'en' => '<strong>Image sync across all languages:</strong> The <code>HelpSyncImagesAllLangsSeeder</code> automatically prepends the same screenshot to DE / RO / SK content for every article whose Hungarian content starts with a screenshot image — without duplication.',
'de' => '<strong>Bildsynchronisation für alle Sprachen:</strong> Der <code>HelpSyncImagesAllLangsSeeder</code> fügt automatisch denselben Screenshot dem DE / RO / SK-Inhalt für jeden Artikel voran, dessen ungarischer Inhalt mit einem Screenshot-Bild beginnt — ohne Duplizierung.',
'ro' => '<strong>Sincronizarea imaginilor pentru toate limbile:</strong> <code>HelpSyncImagesAllLangsSeeder</code> adaugă automat același screenshot la conținutul DE / RO / SK pentru fiecare articol al cărui conținut maghiar începe cu o imagine screenshot — fără duplicare.',
'sk' => '<strong>Synchronizácia obrázkov pre všetky jazyky:</strong> <code>HelpSyncImagesAllLangsSeeder</code> automaticky pridáva rovnaký screenshot pred obsah DE / RO / SK pre každý článok, ktorého maďarský obsah začína obrázkom screenshotu — bez duplicity.',
],

// v1.22.0
[
'en' => '<strong>Email open tracking (pixel):</strong> Every sent campaign email and drip email now contains an invisible 1×1 GIF image. When the recipient opens the email, the image request records the open event. An <code>opened_at</code> (nullable timestamp) column was added to <code>email_sends</code> and <code>drip_sends</code>; the campaign summary <code>opened_count</code> counter increments automatically.',
'de' => '<strong>E-Mail-Öffnungs-Tracking (Pixel):</strong> Jede gesendete Kampagnen-E-Mail und Drip-E-Mail enthält nun ein unsichtbares 1×1 GIF-Bild. Wenn der Empfänger die E-Mail öffnet, zeichnet die Bildanfrage das Öffnungsereignis auf. Eine <code>opened_at</code>-Spalte (nullable Timestamp) wurde zu <code>email_sends</code> und <code>drip_sends</code> hinzugefügt; der Kampagnenzusammenfassungs-Zähler <code>opened_count</code> wird automatisch erhöht.',
'ro' => '<strong>Urmărirea deschiderilor de e-mail (pixel):</strong> Fiecare e-mail de campanie și e-mail drip trimis conține acum o imagine GIF invizibilă de 1×1. Când destinatarul deschide e-mailul, cererea de imagine înregistrează evenimentul de deschidere. O coloană <code>opened_at</code> (timestamp nullable) a fost adăugată la <code>email_sends</code> și <code>drip_sends</code>; contorul de rezumat al campaniei <code>opened_count</code> se incrementează automat.',
'sk' => '<strong>Sledovanie otvorení e-mailov (pixel):</strong> Každý odoslaný e-mail kampane a drip e-mail teraz obsahuje neviditeľný obrázok GIF 1×1. Keď príjemca otvorí e-mail, požiadavka na obrázok zaznamená udalosť otvorenia. Stĺpec <code>opened_at</code> (nullable timestamp) bol pridaný do <code>email_sends</code> a <code>drip_sends</code>; počítadlo súhrnu kampane <code>opened_count</code> sa automaticky zvyšuje.',
],
[
'en' => '<strong>Link click tracking:</strong> All external links in emails are served through a redirect proxy URL (<code>/track/click/{token}?to=...</code>). On click, the system records the <code>clicked_at</code> timestamp and increments the campaign\'s <code>clicked_count</code> counter, then redirects to the original destination. Unsubscribe and tracking links are excluded from rewriting.',
'de' => '<strong>Link-Klick-Tracking:</strong> Alle externen Links in E-Mails werden über eine Umleitungs-Proxy-URL (<code>/track/click/{token}?to=...</code>) bereitgestellt. Beim Klick zeichnet das System den <code>clicked_at</code>-Zeitstempel auf und erhöht den <code>clicked_count</code>-Zähler der Kampagne, dann leitet es zum ursprünglichen Ziel weiter. Abmelde- und Tracking-Links sind vom Umschreiben ausgenommen.',
'ro' => '<strong>Urmărirea clicurilor pe linkuri:</strong> Toate linkurile externe din e-mailuri sunt servite printr-un URL proxy de redirecționare (<code>/track/click/{token}?to=...</code>). La clic, sistemul înregistrează timestamp-ul <code>clicked_at</code> și incrementează contorul <code>clicked_count</code> al campaniei, apoi redirecționează către destinația originală. Linkurile de dezabonare și urmărire sunt excluse din rescriere.',
'sk' => '<strong>Sledovanie kliknutí na odkazy:</strong> Všetky externé odkazy v e-mailoch sú obsluhované cez URL presmerúvaného proxy (<code>/track/click/{token}?to=...</code>). Pri kliknutí systém zaznamená časovú pečiatku <code>clicked_at</code> a zvýši počítadlo <code>clicked_count</code> kampane, potom presmeruje na pôvodný cieľ. Odkazy na odhlásenie a sledovacie odkazy sú vylúčené z prepisovania.',
],
[
'en' => '<strong>Opens and clicks displayed in campaign list:</strong> Two new columns appear in the Email Campaigns table: <em>Opens</em> (absolute count + percentage rate) and <em>Clicks</em> — highlighted in green. Statistics are based on live database data.',
'de' => '<strong>Öffnungen und Klicks in der Kampagnenliste angezeigt:</strong> Zwei neue Spalten erscheinen in der E-Mail-Kampagnentabelle: <em>Öffnungen</em> (absolute Anzahl + prozentuale Rate) und <em>Klicks</em> — grün hervorgehoben. Statistiken basieren auf Live-Datenbankdaten.',
'ro' => '<strong>Deschideri și clicuri afișate în lista de campanii:</strong> Două coloane noi apar în tabelul Campanii de e-mail: <em>Deschideri</em> (număr absolut + rată procentuală) și <em>Clicuri</em> — evidențiate în verde. Statisticile se bazează pe date live din baza de date.',
'sk' => '<strong>Otvorenia a kliknutia zobrazené v zozname kampaní:</strong> V tabuľke E-mailových kampaní sa objavia dva nové stĺpce: <em>Otvorenia</em> (absolútny počet + percentuálna miera) a <em>Kliknutia</em> — zvýraznené zelenou farbou. Štatistiky sú založené na živých databázových dátach.',
],
[
'en' => '<strong>EmailTrackingService:</strong> New <code>App\\Services\\EmailTrackingService</code> class that uniformly handles link wrapping (<code>wrapLinks()</code>), pixel injection (<code>injectPixel()</code>) and the full pipeline (<code>process()</code>). The base64-encoded GIF is stored as a constant — no filesystem or HTTP request needed for the pixel.',
'de' => '<strong>EmailTrackingService:</strong> Neue Klasse <code>App\\Services\\EmailTrackingService</code>, die einheitlich Link-Wrapping (<code>wrapLinks()</code>), Pixel-Injektion (<code>injectPixel()</code>) und die gesamte Pipeline (<code>process()</code>) verarbeitet. Das base64-kodierte GIF wird als Konstante gespeichert — kein Dateisystem oder HTTP-Anfrage für das Pixel erforderlich.',
'ro' => '<strong>EmailTrackingService:</strong> Noua clasă <code>App\\Services\\EmailTrackingService</code> care gestionează uniform înfășurarea linkurilor (<code>wrapLinks()</code>), injectarea pixelilor (<code>injectPixel()</code>) și întreaga conductă (<code>process()</code>). GIF-ul codificat base64 este stocat ca o constantă — nu este necesară nicio cerere de sistem de fișiere sau HTTP pentru pixel.',
'sk' => '<strong>EmailTrackingService:</strong> Nová trieda <code>App\\Services\\EmailTrackingService</code>, ktorá jednotne spracúva zabalenie odkazov (<code>wrapLinks()</code>), injekciu pixelov (<code>injectPixel()</code>) a celý pipeline (<code>process()</code>). GIF zakódovaný v base64 je uložený ako konštanta — pre pixel nie je potrebný žiadny súborový systém ani HTTP požiadavka.',
],
[
'en' => '<strong>TrackingController (public endpoints):</strong> <code>GET /track/open/{token}</code> — returns the GIF pixel and updates the <code>opened_at</code> field; <code>GET /track/click/{token}?to=URL</code> — redirects to the destination and updates the <code>clicked_at</code> field. Security check: the <code>to</code> parameter is only redirected for valid absolute URLs (<code>FILTER_VALIDATE_URL</code>).',
'de' => '<strong>TrackingController (öffentliche Endpunkte):</strong> <code>GET /track/open/{token}</code> — gibt den GIF-Pixel zurück und aktualisiert das Feld <code>opened_at</code>; <code>GET /track/click/{token}?to=URL</code> — leitet zum Ziel weiter und aktualisiert das Feld <code>clicked_at</code>. Sicherheitsprüfung: Der Parameter <code>to</code> wird nur für gültige absolute URLs weitergeleitet (<code>FILTER_VALIDATE_URL</code>).',
'ro' => '<strong>TrackingController (puncte finale publice):</strong> <code>GET /track/open/{token}</code> — returnează pixelul GIF și actualizează câmpul <code>opened_at</code>; <code>GET /track/click/{token}?to=URL</code> — redirecționează către destinație și actualizează câmpul <code>clicked_at</code>. Verificare de securitate: parametrul <code>to</code> este redirecționat doar pentru URL-uri absolute valide (<code>FILTER_VALIDATE_URL</code>).',
'sk' => '<strong>TrackingController (verejné endpointy):</strong> <code>GET /track/open/{token}</code> — vráti GIF pixel a aktualizuje pole <code>opened_at</code>; <code>GET /track/click/{token}?to=URL</code> — presmeruje na cieľ a aktualizuje pole <code>clicked_at</code>. Bezpečnostná kontrola: parameter <code>to</code> je presmerovaný iba pre platné absolútne URL (<code>FILTER_VALIDATE_URL</code>).',
],

// v1.21.0
[
'en' => '<strong>One-click unsubscribe page (public):</strong> Every newsletter subscriber receives a unique <code>unsubscribe_token</code> (a backfill migration runs for existing records). Emails now include an <em>Unsubscribe</em> link pointing to <code>/unsubscribe/{token}</code>. The page handles 4 states: active subscriber / unsubscribed / re-subscribe option / unknown token.',
'de' => '<strong>Ein-Klick-Abmeldeseite (öffentlich):</strong> Jeder Newsletter-Abonnent erhält ein einzigartiges <code>unsubscribe_token</code> (eine Backfill-Migration läuft für bestehende Datensätze). E-Mails enthalten nun einen <em>Abmelden</em>-Link, der auf <code>/unsubscribe/{token}</code> zeigt. Die Seite verarbeitet 4 Zustände: aktiver Abonnent / abgemeldet / Wiederanmeldeoption / unbekanntes Token.',
'ro' => '<strong>Pagina de dezabonare cu un singur clic (publică):</strong> Fiecare abonat la newsletter primește un <code>unsubscribe_token</code> unic (o migrare de completare rulează pentru înregistrările existente). E-mailurile includ acum un link de <em>Dezabonare</em> care indică spre <code>/unsubscribe/{token}</code>. Pagina gestionează 4 stări: abonat activ / dezabonat / opțiune de reabonare / token necunoscut.',
'sk' => '<strong>Stránka odhlásenia jedným kliknutím (verejná):</strong> Každý odberateľ newslettera dostane jedinečný <code>unsubscribe_token</code> (pre existujúce záznamy prebehne dopĺňacia migrácia). E-maily teraz obsahujú odkaz <em>Odhlásiť sa</em> smerujúci na <code>/unsubscribe/{token}</code>. Stránka spracúva 4 stavy: aktívny odberateľ / odhlásený / možnosť opätovného prihlásenia / neznámy token.',
],
[
'en' => '<strong>RFC 8058 <code>List-Unsubscribe</code> headers:</strong> Sent emails now include <code>List-Unsubscribe</code> and <code>List-Unsubscribe-Post: List-Unsubscribe=One-Click</code> headers via a Symfony <code>using:</code> callback. This allows modern email clients (Gmail, Outlook) to render a one-click unsubscribe button.',
'de' => '<strong>RFC 8058 <code>List-Unsubscribe</code>-Header:</strong> Gesendete E-Mails enthalten nun <code>List-Unsubscribe</code>- und <code>List-Unsubscribe-Post: List-Unsubscribe=One-Click</code>-Header über einen Symfony <code>using:</code>-Callback. Dies ermöglicht modernen E-Mail-Clients (Gmail, Outlook) das Rendern einer Ein-Klick-Abmeldetaste.',
'ro' => '<strong>Anteturi RFC 8058 <code>List-Unsubscribe</code>:</strong> E-mailurile trimise includ acum anteturi <code>List-Unsubscribe</code> și <code>List-Unsubscribe-Post: List-Unsubscribe=One-Click</code> printr-un callback Symfony <code>using:</code>. Aceasta permite clienților de e-mail moderni (Gmail, Outlook) să afișeze un buton de dezabonare cu un singur clic.',
'sk' => '<strong>RFC 8058 hlavičky <code>List-Unsubscribe</code>:</strong> Odoslané e-maily teraz obsahujú hlavičky <code>List-Unsubscribe</code> a <code>List-Unsubscribe-Post: List-Unsubscribe=One-Click</code> cez Symfony callback <code>using:</code>. To umožňuje moderným e-mailovým klientom (Gmail, Outlook) zobraziť tlačidlo odhlásenia jedným kliknutím.',
],
[
'en' => '<strong>Re-subscribe option:</strong> On the unsubscribed state, the page also shows a <em>Re-subscribe</em> button. Re-subscribing is handled through a separate POST endpoint (<code>/unsubscribe/{token}/resubscribe</code>) that sets <code>is_subscribed</code> back to <code>true</code>.',
'de' => '<strong>Wiederanmeldeoption:</strong> Im abgemeldeten Zustand zeigt die Seite auch eine <em>Erneut anmelden</em>-Schaltfläche. Die Wiederanmeldung wird über einen separaten POST-Endpunkt (<code>/unsubscribe/{token}/resubscribe</code>) verarbeitet, der <code>is_subscribed</code> wieder auf <code>true</code> setzt.',
'ro' => '<strong>Opțiunea de reabonare:</strong> În starea dezabonat, pagina afișează și un buton <em>Reabonare</em>. Reabonarea este gestionată printr-un endpoint POST separat (<code>/unsubscribe/{token}/resubscribe</code>) care setează <code>is_subscribed</code> înapoi la <code>true</code>.',
'sk' => '<strong>Možnosť opätovného prihlásenia:</strong> V stave odhlásenia stránka zobrazuje aj tlačidlo <em>Opätovne sa prihlásiť</em>. Opätovné prihlásenie sa spracúva cez samostatný POST endpoint (<code>/unsubscribe/{token}/resubscribe</code>), ktorý nastaví <code>is_subscribed</code> späť na <code>true</code>.',
],

// v1.20.0
[
'en' => '<strong>Automated drip campaign module:</strong> New <code>/admin/drip-campaigns</code> page. Each drip campaign supports an unlimited number of steps — subject, sender, HTML content, and delay in days from the previous step. Triggers: <em>Manual</em>, <em>Group join</em>, <em>Tag added</em>.',
'de' => '<strong>Automatisiertes Drip-Kampagnen-Modul:</strong> Neue Seite <code>/admin/drip-campaigns</code>. Jede Drip-Kampagne unterstützt eine unbegrenzte Anzahl von Schritten — Betreff, Absender, HTML-Inhalt und Verzögerung in Tagen vom vorherigen Schritt. Auslöser: <em>Manuell</em>, <em>Gruppe beitreten</em>, <em>Tag hinzugefügt</em>.',
'ro' => '<strong>Modul de campanie drip automatizată:</strong> Noua pagină <code>/admin/drip-campaigns</code>. Fiecare campanie drip suportă un număr nelimitat de pași — subiect, expeditor, conținut HTML și întârziere în zile față de pasul anterior. Declanșatoare: <em>Manual</em>, <em>Alăturare la grup</em>, <em>Tag adăugat</em>.',
'sk' => '<strong>Modul automatizovanej drip kampane:</strong> Nová stránka <code>/admin/drip-campaigns</code>. Každá drip kampaň podporuje neobmedzený počet krokov — predmet, odosielateľ, HTML obsah a oneskorenie v dňoch od predchádzajúceho kroku. Spúšťače: <em>Manuálne</em>, <em>Vstup do skupiny</em>, <em>Pridaný tag</em>.',
],
[
'en' => '<strong>Drip enrollment and processing:</strong> Contacts can enroll in a drip campaign manually (admin button) or automatically (via trigger). The <code>drip:process</code> Artisan command runs every 15 minutes: it finds due enrollments, sends the next step, and sets the next send time. When the campaign ends, the enrollment receives <em>completed</em> status.',
'de' => '<strong>Drip-Einschreibung und -Verarbeitung:</strong> Kontakte können sich manuell (Admin-Schaltfläche) oder automatisch (über Auslöser) in eine Drip-Kampagne einschreiben. Der Artisan-Befehl <code>drip:process</code> läuft alle 15 Minuten: Er findet fällige Einschreibungen, sendet den nächsten Schritt und setzt die nächste Sendezeit. Wenn die Kampagne endet, erhält die Einschreibung den Status <em>abgeschlossen</em>.',
'ro' => '<strong>Înregistrare și procesare drip:</strong> Contactele se pot înscrie într-o campanie drip manual (buton de admin) sau automat (prin declanșator). Comanda Artisan <code>drip:process</code> rulează la fiecare 15 minute: găsește înregistrările scadente, trimite pasul următor și setează ora de trimitere următoare. Când campania se termină, înregistrarea primește starea <em>finalizat</em>.',
'sk' => '<strong>Registrácia a spracovanie drip:</strong> Kontakty sa môžu zaregistrovať do drip kampane manuálne (tlačidlo admina) alebo automaticky (cez spúšťač). Artisan príkaz <code>drip:process</code> beží každých 15 minút: nájde splatné registrácie, odošle ďalší krok a nastaví nasledujúci čas odoslania. Keď kampaň skončí, registrácia dostane stav <em>dokončené</em>.',
],
[
'en' => '<strong>Drip campaign admin interface:</strong> The detail page shows 4 stat cards (active / completed / cancelled enrollments, total steps), editable step list via modals, and enrollments list per person and per step. Campaign activation / pausing with a single click.',
'de' => '<strong>Drip-Kampagnen-Admin-Oberfläche:</strong> Die Detailseite zeigt 4 Statistikkarten (aktive / abgeschlossene / stornierte Einschreibungen, Gesamtschritte), bearbeitbare Schrittliste über Modals und Einschreibungsliste pro Person und Schritt. Kampagnenaktivierung / -pause mit einem Klick.',
'ro' => '<strong>Interfața de administrare a campaniei drip:</strong> Pagina de detalii afișează 4 carduri de statistici (înregistrări active / finalizate / anulate, total pași), lista de pași editabilă prin modals și lista de înregistrări per persoană și per pas. Activarea / întreruperea campaniei cu un singur clic.',
'sk' => '<strong>Administrátorské rozhranie drip kampane:</strong> Stránka s podrobnosťami zobrazuje 4 štatistické karty (aktívne / dokončené / zrušené registrácie, celkový počet krokov), upraviteľný zoznam krokov cez modals a zoznam registrácií na osobu a krok. Aktivácia / pozastavenie kampane jedným kliknutím.',
],
[
'en' => '<strong>Database schema:</strong> Three new tables: <code>drip_campaigns</code> (campaign header, trigger type and target group/tag), <code>drip_steps</code> (steps ordered by position), <code>drip_enrollments</code> (enrollments with status, <code>next_send_at</code> index), and <code>drip_sends</code> (send tracking with tracking token).',
'de' => '<strong>Datenbankschema:</strong> Drei neue Tabellen: <code>drip_campaigns</code> (Kampagnenkopf, Auslösertyp und Zielgruppe/Tag), <code>drip_steps</code> (nach Position geordnete Schritte), <code>drip_enrollments</code> (Einschreibungen mit Status, <code>next_send_at</code>-Index) und <code>drip_sends</code> (Versand-Tracking mit Tracking-Token).',
'ro' => '<strong>Schema bazei de date:</strong> Trei tabele noi: <code>drip_campaigns</code> (antetul campaniei, tipul declanșatorului și grupul/tag-ul țintă), <code>drip_steps</code> (pași ordonați după poziție), <code>drip_enrollments</code> (înregistrări cu stare, index <code>next_send_at</code>) și <code>drip_sends</code> (urmărirea trimiterilor cu token de urmărire).',
'sk' => '<strong>Schéma databázy:</strong> Tri nové tabuľky: <code>drip_campaigns</code> (hlavička kampane, typ spúšťača a cieľová skupina/tag), <code>drip_steps</code> (kroky zoradené podľa pozície), <code>drip_enrollments</code> (registrácie so stavom, index <code>next_send_at</code>) a <code>drip_sends</code> (sledovanie odosielania so sledovacím tokenom).',
],

// v1.19.0
[
'en' => '<strong>Campaign audience segmentation:</strong> A <em>Audience</em> section appeared in the campaign create and edit modal. Admins can choose from four options: <em>All newsletter subscribers</em>, <em>Group members</em> (multiple groups selectable), <em>Tagged contacts</em> (multiple tags), <em>By member status</em> (multiple statuses). The filter combination is stored as JSON in the <code>email_campaigns.segment_filters</code> column.',
'de' => '<strong>Kampagnenzielgruppen-Segmentierung:</strong> Ein Abschnitt <em>Zielgruppe</em> erschien im Kampagnenerstellungs- und -bearbeitungsmodal. Admins können aus vier Optionen wählen: <em>Alle Newsletter-Abonnenten</em>, <em>Gruppenmitglieder</em> (mehrere Gruppen auswählbar), <em>Getaggte Kontakte</em> (mehrere Tags), <em>Nach Mitgliedsstatus</em> (mehrere Status). Die Filterkombination wird als JSON in der Spalte <code>email_campaigns.segment_filters</code> gespeichert.',
'ro' => '<strong>Segmentarea publicului campaniei:</strong> O secțiune <em>Public</em> a apărut în modalul de creare și editare a campaniei. Administratorii pot alege din patru opțiuni: <em>Toți abonații la newsletter</em>, <em>Membri ai grupului</em> (mai multe grupuri selectabile), <em>Contacte cu tag-uri</em> (mai multe tag-uri), <em>După statutul membrului</em> (mai multe statute). Combinația de filtre este stocată ca JSON în coloana <code>email_campaigns.segment_filters</code>.',
'sk' => '<strong>Segmentácia publika kampane:</strong> V modálnom okne vytvorenia a úpravy kampane sa objavila sekcia <em>Publikum</em>. Správcovia si môžu vybrať zo štyroch možností: <em>Všetci odberatelia newslettera</em>, <em>Členovia skupiny</em> (vyberateľné viacero skupín), <em>Kontakty s tagom</em> (viacero tagov), <em>Podľa stavu člena</em> (viacero stavov). Kombinácia filtrov sa ukladá ako JSON do stĺpca <code>email_campaigns.segment_filters</code>.',
],
[
'en' => '<strong>Live recipient count preview:</strong> When the segmentation setting changes, the page fetches the estimated recipient count in real time via AJAX (<code>GET /admin/campaigns/recipient-count</code>) with a 500 ms debounce, and displays it immediately. A <em>Segment</em> column appeared in the campaign list indicating the type.',
'de' => '<strong>Live-Empfängeranzahl-Vorschau:</strong> Wenn sich die Segmentierungseinstellung ändert, ruft die Seite die geschätzte Empfängeranzahl in Echtzeit über AJAX (<code>GET /admin/campaigns/recipient-count</code>) mit einem 500-ms-Debounce ab und zeigt sie sofort an. In der Kampagnenliste erschien eine Spalte <em>Segment</em> mit Angabe des Typs.',
'ro' => '<strong>Previzualizarea în timp real a numărului de destinatari:</strong> Când setarea de segmentare se modifică, pagina preia numărul estimat de destinatari în timp real prin AJAX (<code>GET /admin/campaigns/recipient-count</code>) cu un debounce de 500 ms și îl afișează imediat. O coloană <em>Segment</em> a apărut în lista de campanii indicând tipul.',
'sk' => '<strong>Živý náhľad počtu príjemcov:</strong> Keď sa zmení nastavenie segmentácie, stránka načíta odhadovaný počet príjemcov v reálnom čase cez AJAX (<code>GET /admin/campaigns/recipient-count</code>) s 500 ms debouncingom a zobrazí ho okamžite. V zozname kampaní sa objavil stĺpec <em>Segment</em> s uvedením typu.',
],
[
'en' => '<strong><code>buildRecipientsQuery()</code> method on <code>EmailCampaign</code> model:</strong> A unified query builder that filters subscribed contacts with valid emails based on the <code>segment_filters</code> JSON — using <code>whereHas(\'groups\')</code> for group filter, <code>whereHas(\'tags\')</code> for tag filter, <code>whereIn(\'status\')</code> for status filter.',
'de' => '<strong><code>buildRecipientsQuery()</code>-Methode am <code>EmailCampaign</code>-Modell:</strong> Ein einheitlicher Query-Builder, der abonnierte Kontakte mit gültigen E-Mails basierend auf dem <code>segment_filters</code>-JSON filtert — mit <code>whereHas(\'groups\')</code> für Gruppenfilter, <code>whereHas(\'tags\')</code> für Tag-Filter, <code>whereIn(\'status\')</code> für Statusfilter.',
'ro' => '<strong>Metoda <code>buildRecipientsQuery()</code> pe modelul <code>EmailCampaign</code>:</strong> Un constructor de interogări unificat care filtrează contactele abonate cu e-mailuri valide pe baza JSON-ului <code>segment_filters</code> — folosind <code>whereHas(\'groups\')</code> pentru filtrul de grup, <code>whereHas(\'tags\')</code> pentru filtrul de tag, <code>whereIn(\'status\')</code> pentru filtrul de stare.',
'sk' => '<strong>Metóda <code>buildRecipientsQuery()</code> na modeli <code>EmailCampaign</code>:</strong> Unifikovaný tvorca dotazov, ktorý filtruje prihlásených kontaktov s platnými e-mailmi na základe JSON <code>segment_filters</code> — pomocou <code>whereHas(\'groups\')</code> pre filter skupiny, <code>whereHas(\'tags\')</code> pre filter tagov, <code>whereIn(\'status\')</code> pre filter stavu.',
],

// v1.18.0
[
'en' => '<strong>Email template library:</strong> New <code>/admin/email-templates</code> page displaying built-in (<em>Minimal, Newsletter, Announcement, Promotional</em>) and custom templates in card layout. Every template can be edited, previewed (iframe modal) and deleted (except built-ins).',
'de' => '<strong>E-Mail-Vorlagenbibliothek:</strong> Neue Seite <code>/admin/email-templates</code> mit integrierten (<em>Minimal, Newsletter, Ankündigung, Werbung</em>) und benutzerdefinierten Vorlagen im Kartenlayout. Jede Vorlage kann bearbeitet, vorgeschaut (iframe-Modal) und gelöscht werden (außer integrierten).',
'ro' => '<strong>Biblioteca de șabloane de e-mail:</strong> Noua pagină <code>/admin/email-templates</code> afișând șabloane integrate (<em>Minimal, Newsletter, Anunț, Promoțional</em>) și personalizate în aspect card. Fiecare șablon poate fi editat, previzualizat (modal iframe) și șters (cu excepția celor integrate).',
'sk' => '<strong>Knižnica e-mailových šablón:</strong> Nová stránka <code>/admin/email-templates</code> zobrazujúca vstavané (<em>Minimálna, Newsletter, Oznámenie, Propagačná</em>) a vlastné šablóny v rozložení kariet. Každú šablónu je možné upraviť, zobraziť náhľad (iframe modal) a odstrániť (okrem vstavaných).',
],
[
'en' => '<strong>Loading a template into the campaign editor:</strong> A <em>"Use template"</em> button appeared in the campaign create and edit modal. It opens a template picker modal, from which a single click loads the selected template\'s HTML content into the editor. All available templates are listed with a detailed preview.',
'de' => '<strong>Vorlage in den Kampagneneditor laden:</strong> Im Kampagnenerstellungs- und -bearbeitungsmodal erschien eine Schaltfläche <em>„Vorlage verwenden"</em>. Sie öffnet ein Vorlagenauswahl-Modal, aus dem ein einziger Klick den HTML-Inhalt der ausgewählten Vorlage in den Editor lädt. Alle verfügbaren Vorlagen werden mit einer detaillierten Vorschau aufgelistet.',
'ro' => '<strong>Încărcarea unui șablon în editorul de campanie:</strong> Un buton <em>„Folosiți șablonul"</em> a apărut în modalul de creare și editare a campaniei. Acesta deschide un modal de selectare a șablonului, din care un singur clic încarcă conținutul HTML al șablonului selectat în editor. Toate șabloanele disponibile sunt listate cu o previzualizare detaliată.',
'sk' => '<strong>Načítanie šablóny do editora kampane:</strong> V modálnom okne vytvorenia a úpravy kampane sa objavilo tlačidlo <em>„Použiť šablónu"</em>. Otvára modálny výber šablóny, z ktorého jediné kliknutie načíta HTML obsah vybranej šablóny do editora. Všetky dostupné šablóny sú uvedené s podrobným náhľadom.',
],
[
'en' => '<strong>Built-in templates (seeder):</strong> At installation, 4 professional built-in templates are automatically inserted into the database and can be customized for organizational branding. The <code>email_templates</code> table contains: <code>name</code>, <code>description</code>, <code>category</code>, <code>body_html</code>, <code>is_system</code> (boolean) columns.',
'de' => '<strong>Integrierte Vorlagen (Seeder):</strong> Bei der Installation werden 4 professionelle integrierte Vorlagen automatisch in die Datenbank eingefügt und können für das Organisationsbranding angepasst werden. Die Tabelle <code>email_templates</code> enthält: Spalten <code>name</code>, <code>description</code>, <code>category</code>, <code>body_html</code>, <code>is_system</code> (boolean).',
'ro' => '<strong>Șabloane integrate (seeder):</strong> La instalare, 4 șabloane integrate profesionale sunt inserate automat în baza de date și pot fi personalizate pentru identitatea organizației. Tabelul <code>email_templates</code> conține: coloanele <code>name</code>, <code>description</code>, <code>category</code>, <code>body_html</code>, <code>is_system</code> (boolean).',
'sk' => '<strong>Vstavané šablóny (seeder):</strong> Pri inštalácii sú 4 profesionálne vstavané šablóny automaticky vložené do databázy a môžu byť prispôsobené pre firemný branding organizácie. Tabuľka <code>email_templates</code> obsahuje: stĺpce <code>name</code>, <code>description</code>, <code>category</code>, <code>body_html</code>, <code>is_system</code> (boolean).',
],

// v1.17.0
[
'en' => '<strong>Donation export for accounting (CSV, XLSX, PDF):</strong> An <em>Export</em> button appeared on the Donations page. Export is filterable by start date, end date and currency. Three formats are available: CSV (UTF-8 BOM, semicolon-separated), Excel (XLSX, bold header) and PDF (tabular layout). <code>phpoffice/phpspreadsheet</code> handles XLSX; <code>dompdf/dompdf</code> handles PDF.',
'de' => '<strong>Adomány-Export für die Buchhaltung (CSV, XLSX, PDF):</strong> Auf der Spendenpage erschien eine Schaltfläche <em>Exportieren</em>. Der Export ist nach Startdatum, Enddatum und Währung filterbar. Drei Formate sind verfügbar: CSV (UTF-8 BOM, durch Semikolon getrennt), Excel (XLSX, fetter Header) und PDF (tabellarisches Layout). <code>phpoffice/phpspreadsheet</code> verarbeitet XLSX; <code>dompdf/dompdf</code> verarbeitet PDF.',
'ro' => '<strong>Export donații pentru contabilitate (CSV, XLSX, PDF):</strong> Un buton <em>Export</em> a apărut pe pagina Donații. Exportul este filtrabil după dată de început, dată de sfârșit și monedă. Trei formate sunt disponibile: CSV (UTF-8 BOM, separate prin punct și virgulă), Excel (XLSX, antet îngroșat) și PDF (aspect tabelar). <code>phpoffice/phpspreadsheet</code> gestionează XLSX; <code>dompdf/dompdf</code> gestionează PDF.',
'sk' => '<strong>Export darov pre účtovníctvo (CSV, XLSX, PDF):</strong> Na stránke Dary sa objavilo tlačidlo <em>Exportovať</em>. Export je filtrovateľný podľa dátumu začiatku, dátumu konca a meny. Sú k dispozícii tri formáty: CSV (UTF-8 BOM, oddelené bodkočiarkou), Excel (XLSX, tučná hlavička) a PDF (tabuľkový layout). <code>phpoffice/phpspreadsheet</code> spracúva XLSX; <code>dompdf/dompdf</code> spracúva PDF.',
],
[
'en' => '<strong>Exported fields:</strong> Date, Contact name, Email, Amount, Currency, Payment method, Status, Transaction ID, Campaign, Notes — these essential data points needed for accounting processing are exported.',
'de' => '<strong>Exportierte Felder:</strong> Datum, Kontaktname, E-Mail, Betrag, Währung, Zahlungsmethode, Status, Transaktions-ID, Kampagne, Notizen — diese wesentlichen Datenpunkte für die Buchhalterverarbeitung werden exportiert.',
'ro' => '<strong>Câmpuri exportate:</strong> Dată, Numele contactului, E-mail, Sumă, Monedă, Metodă de plată, Stare, ID tranzacție, Campanie, Note — aceste puncte de date esențiale necesare pentru procesarea contabilă sunt exportate.',
'sk' => '<strong>Exportované polia:</strong> Dátum, Meno kontaktu, E-mail, Suma, Mena, Spôsob platby, Stav, ID transakcie, Kampaň, Poznámky — tieto základné dátové body potrebné pre účtovné spracovanie sú exportované.',
],

// v1.16.0
[
'en' => '<strong>Public online donation form:</strong> The <code>/donate</code> URL displays a donation form accessible without login — with donor name, email, amount, currency and notes fields. On successful submission, a receipt email is sent to the donor (<em>DonationReceiptMail</em>), and a thank-you page appears (<code>/donate/thanks/{token}</code>).',
'de' => '<strong>Öffentliches Online-Spendenformular:</strong> Die URL <code>/donate</code> zeigt ein Spendenformular an, das ohne Anmeldung zugänglich ist — mit Feldern für Spendername, E-Mail, Betrag, Währung und Notizen. Bei erfolgreicher Einreichung wird eine Quittungs-E-Mail an den Spender gesendet (<em>DonationReceiptMail</em>), und eine Dankesseite erscheint (<code>/donate/thanks/{token}</code>).',
'ro' => '<strong>Formular de donații online public:</strong> URL-ul <code>/donate</code> afișează un formular de donații accesibil fără autentificare — cu câmpuri pentru numele donatorului, e-mail, sumă, monedă și note. La depunerea cu succes, un e-mail de chitanță este trimis donatorului (<em>DonationReceiptMail</em>), și apare o pagină de mulțumire (<code>/donate/thanks/{token}</code>).',
'sk' => '<strong>Verejný online formulár darov:</strong> URL <code>/donate</code> zobrazuje formulár darov dostupný bez prihlásenia — s poliami pre meno darcu, e-mail, sumu, menu a poznámky. Pri úspešnom odoslaní sa darcovi pošle e-mail s potvrdením (<em>DonationReceiptMail</em>) a zobrazí sa stránka s poďakovaním (<code>/donate/thanks/{token}</code>).',
],
[
'en' => '<strong>Online payment with Stripe / Barion integration:</strong> The public donation form supports card payments. For Stripe, the system creates a Checkout Session and verifies the payment on the return URL (<code>/payment/donation/stripe/success/{token}</code>). Barion integration is also available (<code>/payment/donation/barion/callback/{token}</code>).',
'de' => '<strong>Online-Zahlung mit Stripe / Barion-Integration:</strong> Das öffentliche Spendenformular unterstützt Kartenzahlungen. Für Stripe erstellt das System eine Checkout-Session und überprüft die Zahlung auf der Rückgabe-URL (<code>/payment/donation/stripe/success/{token}</code>). Barion-Integration ist ebenfalls verfügbar (<code>/payment/donation/barion/callback/{token}</code>).',
'ro' => '<strong>Plată online cu integrare Stripe / Barion:</strong> Formularul public de donații suportă plăți cu card. Pentru Stripe, sistemul creează o Sesiune de Checkout și verifică plata pe URL-ul de returnare (<code>/payment/donation/stripe/success/{token}</code>). Integrarea Barion este de asemenea disponibilă (<code>/payment/donation/barion/callback/{token}</code>).',
'sk' => '<strong>Online platba s integráciou Stripe / Barion:</strong> Verejný formulár darov podporuje platby kartou. Pre Stripe systém vytvorí reláciu Checkout a overí platbu na návratovej URL (<code>/payment/donation/stripe/success/{token}</code>). Integrácia Barion je tiež dostupná (<code>/payment/donation/barion/callback/{token}</code>).',
],

// v1.15.0
[
'en' => '<strong>Task comments:</strong> Text comments can be added to every task, showing the timestamp and the submitting user. Comments can be edited and deleted. Data is stored in the <code>task_comments</code> table.',
'de' => '<strong>Aufgabenkommentare:</strong> Zu jeder Aufgabe können Textkommentare hinzugefügt werden, die den Zeitstempel und den einsendenden Benutzer anzeigen. Kommentare können bearbeitet und gelöscht werden. Daten werden in der Tabelle <code>task_comments</code> gespeichert.',
'ro' => '<strong>Comentarii la sarcini:</strong> Comentarii text pot fi adăugate la fiecare sarcină, afișând timestamp-ul și utilizatorul care le-a trimis. Comentariile pot fi editate și șterse. Datele sunt stocate în tabelul <code>task_comments</code>.',
'sk' => '<strong>Komentáre k úlohám:</strong> K každej úlohe je možné pridať textové komentáre zobrazujúce časovú pečiatku a odosielateľa. Komentáre je možné upravovať a mazať. Dáta sú uložené v tabuľke <code>task_comments</code>.',
],
[
'en' => '<strong>Task file attachments:</strong> Files can be attached to tasks (max. 10 MB) — the <code>task_attachments</code> table and Spatie MediaLibrary handle storage. The attachment name, size and upload time appear on the task detail page; files are downloadable and deletable.',
'de' => '<strong>Aufgaben-Dateianhänge:</strong> Dateien können an Aufgaben angehängt werden (max. 10 MB) — die Tabelle <code>task_attachments</code> und Spatie MediaLibrary verwalten die Speicherung. Name, Größe und Upload-Zeit des Anhangs erscheinen auf der Aufgabendetailseite; Dateien sind herunterladbar und löschbar.',
'ro' => '<strong>Atașamente de fișiere la sarcini:</strong> Fișierele pot fi atașate la sarcini (max. 10 MB) — tabelul <code>task_attachments</code> și Spatie MediaLibrary gestionează stocarea. Numele atașamentului, dimensiunea și ora de încărcare apar pe pagina de detalii a sarcinii; fișierele sunt descărcabile și ștergibile.',
'sk' => '<strong>Prílohy súborov k úlohám:</strong> K úlohám je možné priložiť súbory (max. 10 MB) — tabuľka <code>task_attachments</code> a Spatie MediaLibrary spravujú úložisko. Názov prílohy, veľkosť a čas nahrávania sa zobrazujú na stránke s podrobnosťami úlohy; súbory sú stiahnuteľné a vymazateľné.',
],
[
'en' => '<strong>Gantt-style timeline view (Projects):</strong> A <em>Gantt view</em> tab appeared on the project detail page. The view places all project tasks on a timeline — a horizontal bar shows the start and end date, with red highlighting for overdue tasks.',
'de' => '<strong>Gantt-artige Zeitachsenansicht (Projekte):</strong> Auf der Projektdetailseite erschien ein Tab <em>Gantt-Ansicht</em>. Die Ansicht platziert alle Projektaufgaben auf einer Zeitachse — ein horizontaler Balken zeigt das Start- und Enddatum, mit roter Hervorhebung für überfällige Aufgaben.',
'ro' => '<strong>Vedere cronologică în stil Gantt (Proiecte):</strong> Un tab <em>Vedere Gantt</em> a apărut pe pagina de detalii a proiectului. Vederea plasează toate sarcinile proiectului pe o cronologie — un bar orizontal arată data de început și de sfârșit, cu evidențiere roșie pentru sarcinile întârziate.',
'sk' => '<strong>Zobrazenie časovej osi v štýle Gantt (Projekty):</strong> Na stránke s podrobnosťami projektu sa objavila karta <em>Ganttovo zobrazenie</em>. Zobrazenie umiestni všetky úlohy projektu na časovú os — vodorovný pruh zobrazuje dátum začiatku a konca, s červeným zvýraznením pre oneskorené úlohy.',
],

// v1.14.0
[
'en' => '<strong>German (DE), Romanian (RO) and Slovak (SK) language packs:</strong> The admin panel was extended with three new languages with full text coverage. All module translations are available in <code>lang/de/</code>, <code>lang/ro/</code> and <code>lang/sk/</code> folders (<code>common</code>, <code>nav</code>, <code>people</code>, <code>events</code>, <code>groups</code>, <code>donations</code>, <code>campaigns</code>, <code>projects</code>, <code>tasks</code>, <code>users</code>, <code>settings</code>, <code>help</code>, <code>changelog</code>, etc.).',
'de' => '<strong>Deutsche (DE), rumänische (RO) und slowakische (SK) Sprachpakete:</strong> Das Admin-Panel wurde um drei neue Sprachen mit vollständiger Textabdeckung erweitert. Alle Modulübersetzungen sind in den Ordnern <code>lang/de/</code>, <code>lang/ro/</code> und <code>lang/sk/</code> verfügbar (<code>common</code>, <code>nav</code>, <code>people</code>, <code>events</code>, <code>groups</code>, <code>donations</code>, <code>campaigns</code>, <code>projects</code>, <code>tasks</code>, <code>users</code>, <code>settings</code>, <code>help</code>, <code>changelog</code> usw.).',
'ro' => '<strong>Pachete de limbă germană (DE), română (RO) și slovacă (SK):</strong> Panoul de administrare a fost extins cu trei limbi noi cu acoperire completă a textului. Toate traducerile modulelor sunt disponibile în folderele <code>lang/de/</code>, <code>lang/ro/</code> și <code>lang/sk/</code> (<code>common</code>, <code>nav</code>, <code>people</code>, <code>events</code>, <code>groups</code>, <code>donations</code>, <code>campaigns</code>, <code>projects</code>, <code>tasks</code>, <code>users</code>, <code>settings</code>, <code>help</code>, <code>changelog</code> etc.).',
'sk' => '<strong>Jazykové balíky nemčiny (DE), rumunčiny (RO) a slovenčiny (SK):</strong> Admin panel bol rozšírený o tri nové jazyky s úplným pokrytím textu. Všetky preklady modulov sú dostupné v priečinkoch <code>lang/de/</code>, <code>lang/ro/</code> a <code>lang/sk/</code> (<code>common</code>, <code>nav</code>, <code>people</code>, <code>events</code>, <code>groups</code>, <code>donations</code>, <code>campaigns</code>, <code>projects</code>, <code>tasks</code>, <code>users</code>, <code>settings</code>, <code>help</code>, <code>changelog</code> atď.).',
],
[
'en' => '<strong>Language switcher updated:</strong> The HU/EN sidebar switcher was extended with DE, RO and SK flags (<code>fi fi-de</code>, <code>fi fi-ro</code>, <code>fi fi-sk</code> SVG icons, flag-icons library). The locale-switch endpoint is unchanged: <code>/locale/{locale}</code>.',
'de' => '<strong>Sprachumschalter aktualisiert:</strong> Der HU/EN-Sidebar-Umschalter wurde um DE, RO und SK-Flaggen erweitert (<code>fi fi-de</code>, <code>fi fi-ro</code>, <code>fi fi-sk</code> SVG-Symbole, flag-icons-Bibliothek). Der Locale-Wechsel-Endpunkt ist unverändert: <code>/locale/{locale}</code>.',
'ro' => '<strong>Selector de limbă actualizat:</strong> Selectorul din bara laterală HU/EN a fost extins cu steagurile DE, RO și SK (<code>fi fi-de</code>, <code>fi fi-ro</code>, <code>fi fi-sk</code> icoane SVG, biblioteca flag-icons). Punctul final de schimbare a locale-ului este neschimbat: <code>/locale/{locale}</code>.',
'sk' => '<strong>Prepínač jazykov aktualizovaný:</strong> Prepínač HU/EN v bočnom paneli bol rozšírený o vlajky DE, RO a SK (<code>fi fi-de</code>, <code>fi fi-ro</code>, <code>fi fi-sk</code> SVG ikony, knižnica flag-icons). Endpoint prepínania locale je nezmenený: <code>/locale/{locale}</code>.',
],

];

// Process each item: find the 'en' => '...', and append de/ro/sk
foreach ($items as $item) {
    $enText = $item['en'];
    $deText = $item['de'];
    $roText = $item['ro'];
    $skText = $item['sk'];

    // Escape for str_replace (not regex, literal)
    // Find pattern: 'en'  => 'ENTEXT'] and replace with 'en' => 'ENTEXT', 'de' => 'DE', 'ro' => 'RO', 'sk' => 'SK']
    // The en key might have single or double space after 'en'
    // We search for the closing '], of the item

    // Search for the exact en string followed by '], or '],\n
    $search = "'en'  => '" . $enText . "'],";
    $replace = "'en'  => '" . $enText . "', 'de' => '" . $deText . "', 'ro' => '" . $roText . "', 'sk' => '" . $skText . "'],";

    if (strpos($content, $search) !== false) {
        $content = str_replace($search, $replace, $content);
    } else {
        // Try with single space
        $search2 = "'en' => '" . $enText . "'],";
        $replace2 = "'en' => '" . $enText . "', 'de' => '" . $deText . "', 'ro' => '" . $roText . "', 'sk' => '" . $skText . "'],";
        if (strpos($content, $search2) !== false) {
            $content = str_replace($search2, $replace2, $content);
        } else {
            echo "NOT FOUND: " . substr($enText, 0, 60) . "\n";
        }
    }
}

file_put_contents($file, $content);
echo "Phase 2 done (items v1.25.0 - v1.14.0)\n";
echo "File size: " . strlen($content) . "\n";
