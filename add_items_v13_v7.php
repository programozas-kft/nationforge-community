<?php
$file = 'c:/xampp/htdocs/nationforge/resources/views/admin/partials/changelog_content.blade.php';
$content = file_get_contents($file);

function addTranslation(&$content, $enEnd, $de, $ro, $sk) {
    $search = $enEnd . "'],";
    $replace = $enEnd . "', 'de' => '" . $de . "', 'ro' => '" . $ro . "', 'sk' => '" . $sk . "'],";
    if (strpos($content, $search) !== false) {
        $content = str_replace($search, $replace, $content);
        return true;
    }
    return false;
}

$items = [
// v1.13.0 - Event check-in via QR
[
'enEnd' => 'Summary row shows: total / checked in / not yet arrived.',
'de' => '<strong>Veranstaltungs-Check-in per QR-Code:</strong> Jede Registrierung hat nun einen eindeutigen JavaScript-generierten QR-Code (CDN: <code>qrcode.js</code>), der auf der persönlichen Ticket-Seite des Teilnehmers zugänglich ist (<code>/e/ticket/{token}</code>). Die Admin-Ereignisdetailseite zeigt nun eine Spalte <em>Check-in (Zeit)</em> und eine Schaltfläche <em>QR-Scanner</em>. Die Scannerseite (<code>/admin/events/{id}/checkin</code>) unterstützt kamerabasiertes QR-Scannen (<code>html5-qrcode</code> CDN v2.3.8) mit Echtzeit-Feedback (Erfolg / bereits eingecheckt / unbekanntes Token). Ein manuelles Token-Eingabefeld ist ebenfalls verfügbar. Eine Spalte <code>checked_in_at</code> (nullable Timestamp) wurde zu <code>event_registrations</code> hinzugefügt. Zusammenfassungszeile: gesamt / eingecheckt / noch nicht angekommen.',
'ro' => '<strong>Check-in la eveniment prin cod QR:</strong> Fiecare înregistrare are acum un cod QR generat de JavaScript unic (CDN: <code>qrcode.js</code>) accesibil pe pagina de bilet personală a participantului (<code>/e/ticket/{token}</code>). Pagina de detalii a evenimentului din admin afișează acum o coloană <em>Check-in (ora)</em> și un buton <em>Scanner QR</em>. Pagina scanerului (<code>/admin/events/{id}/checkin</code>) suportă scanarea QR bazată pe cameră (<code>html5-qrcode</code> CDN v2.3.8) cu feedback în timp real (succes / deja înregistrat / token necunoscut). Un câmp de introducere manuală a tokenului este de asemenea disponibil. O coloană <code>checked_in_at</code> (timestamp nullable) a fost adăugată la <code>event_registrations</code>. Rândul de rezumat arată: total / înregistrați / nu au sosit încă.',
'sk' => '<strong>Check-in na podujatie cez QR kód:</strong> Každá registrácia má teraz jedinečný JavaScript-generovaný QR kód (CDN: <code>qrcode.js</code>) dostupný na osobnej stránke vstupenky účastníka (<code>/e/ticket/{token}</code>). Stránka s podrobnosťami o podujatí v administrácii teraz zobrazuje stĺpec <em>Check-in (čas)</em> a tlačidlo <em>QR skener</em>. Stránka skenera (<code>/admin/events/{id}/checkin</code>) podporuje skenovanie QR kamerou (<code>html5-qrcode</code> CDN v2.3.8) s real-time spätnou väzbou (úspech / už prihlásený / neznámy token). K dispozícii je aj pole manuálneho zadania tokenu. Stĺpec <code>checked_in_at</code> (nullable timestamp) bol pridaný do <code>event_registrations</code>. Súhrnný riadok zobrazuje: celkom / prihlásení / ešte neprišli.',
],
// v1.13.0 - Personal ticket page
[
'enEnd' => 'The page is print-optimised.',
'de' => '<strong>Persönliche Ticket-Seite (öffentlich):</strong> Nach einer erfolgreichen Registrierung erscheint ein Button <em>„Mein Ticket ansehen"</em> auf der Bestätigungsseite (mit einem Session-Flash des Tokens). Die Ticketseite zeigt die Veranstaltungsdetails, den Namen des Teilnehmers, die Anzahl der Gäste und den QR-Code, der den <code>token</code>-Wert kodiert. Wenn der Teilnehmer bereits eingecheckt ist, zeigt ein grünes Banner den Check-in-Zeitstempel. Die Seite ist druckoptimiert.',
'ro' => '<strong>Pagina de bilet personală (publică):</strong> După o înregistrare reușită, un buton <em>„Vizualizați biletul meu"</em> apare pe pagina de confirmare (folosind un flash de sesiune al tokenului). Pagina de bilet afișează detaliile evenimentului, numele participantului, numărul de oaspeți și codul QR care codifică valoarea <code>token</code>. Dacă participantul este deja înregistrat, un banner verde arată timestamp-ul de check-in. Pagina este optimizată pentru tipărire.',
'sk' => '<strong>Osobná stránka vstupenky (verejná):</strong> Po úspešnej registrácii sa na stránke potvrdenia zobrazí tlačidlo <em>„Zobraziť moju vstupenku"</em> (pomocou session flash tokenu). Stránka vstupenky zobrazuje podrobnosti o podujatí, meno účastníka, počet hostí a QR kód kódujúci hodnotu <code>token</code>. Ak je účastník už prihlásený, zelený banner zobrazuje časovú pečiatku check-inu. Stránka je optimalizovaná pre tlač.',
],
// v1.13.0 - Waitlist management
[
'enEnd' => 'Waitlist positions are automatically reordered after removal.',
'de' => '<strong>Wartelistenverwaltung:</strong> Ein Umschalter <em>Warteliste aktiviert</em> wurde dem Admin-Veranstaltungsbearbeitungsformular hinzugefügt. Wenn die Veranstaltung voll ist und die Warteliste aktiv ist, zeigt die öffentliche Registrierungsseite ein gelbes „Auf die Warteliste" Formular mit der aktuellen Anzahl wartender Personen. Wartelisteneinträge erscheinen nach Position sortiert auf der Admin-Detailseite mit den Schaltflächen <em>Hochstufen</em> und <em>Entfernen</em>. Wenn ein Admin eine bestätigte Registrierung löscht, wird die erste wartende Person automatisch hochgestuft und erhält eine Benachrichtigungs-E-Mail. Wartelistenpositionen werden nach der Entfernung automatisch neu geordnet.',
'ro' => '<strong>Gestionarea listei de așteptare:</strong> Un comutator <em>Listă de așteptare activată</em> a fost adăugat la formularul de editare a evenimentului din admin. Când evenimentul este plin și lista de așteptare este activă, pagina publică de înregistrare afișează un formular galben „Alăturați-vă listei de așteptare" care arată numărul actual de persoane care așteaptă. Intrările din lista de așteptare apar sortate după poziție pe pagina de detalii admin, cu butoanele <em>Promovare</em> și <em>Eliminare</em>. Când un admin șterge o înregistrare confirmată, prima persoană din lista de așteptare este promovată automat și primește un e-mail de notificare. Pozițiile din lista de așteptare sunt reordonate automat după eliminare.',
'sk' => '<strong>Správa zoznamu čakajúcich:</strong> Do formulára úpravy podujatia v administrácii bol pridaný prepínač <em>Zoznam čakajúcich povolený</em>. Keď je podujatie plné a zoznam čakajúcich je aktívny, verejná stránka registrácie zobrazuje žltý formulár „Pridajte sa do zoznamu čakajúcich" zobrazujúci aktuálny počet čakajúcich. Záznamy v zozname čakajúcich sa zobrazujú zoradené podľa pozície na stránke s podrobnosťami admina s tlačidlami <em>Povýšiť</em> a <em>Odstrániť</em>. Keď admin vymaže potvrdenú registráciu, prvá čakajúca osoba je automaticky povýšená a dostane notifikačný e-mail. Pozície v zozname čakajúcich sú po odstránení automaticky preusporiadané.',
],
// v1.13.0 - Waitlist emails
[
'enEnd' => 'Both emails are bilingual HU/EN (driven by the application locale at send time).',
'de' => '<strong>Wartelisten-E-Mail-Benachrichtigungen (×2):</strong> <em>WaitlistConfirmation</em> — eine gelb gestaltete Bestätigungs-E-Mail, die an die Person gesendet wird, die sich auf die Warteliste gesetzt hat, einschließlich ihrer Positionsnummer. <em>WaitlistPromotion</em> — eine grün gestaltete „Platz verfügbar"-Benachrichtigung, die an die hochgestufte Person mit einem Ticket-Link gesendet wird. Beide E-Mails sind zweisprachig HU/EN (gesteuert durch das Anwendungslocale zum Sendezeitpunkt).',
'ro' => '<strong>Notificări e-mail pentru lista de așteptare (×2):</strong> <em>WaitlistConfirmation</em> — un e-mail de confirmare cu stil galben trimis persoanei care s-a alăturat listei de așteptare, incluzând numărul poziției sale. <em>WaitlistPromotion</em> — o notificare „loc disponibil" cu stil verde trimisă persoanei promovate, cu un link de bilet. Ambele e-mailuri sunt bilingve HU/EN (determinate de locale-ul aplicației la momentul trimiterii).',
'sk' => '<strong>E-mailové notifikácie pre zoznam čakajúcich (×2):</strong> <em>WaitlistConfirmation</em> — žlto štylizovaný potvrdzovací e-mail zaslaný osobe, ktorá sa pridala do zoznamu čakajúcich, vrátane čísla jej pozície. <em>WaitlistPromotion</em> — zeleno štylizovaná notifikácia „miesto k dispozícii" zaslaná povýšenej osobe s odkazom na vstupenku. Oba e-maily sú dvojjazyčné HU/EN (určené locale aplikácie v čase odoslania).',
],
// v1.13.0 - Registration deletion
[
'enEnd' => 'Waitlist positions are automatically reordered after removal.',
'de' => '', // already used above - this is a duplicate ending; skip
'ro' => '',
'sk' => '',
],
// v1.12.0 - Flag icons
[
'enEnd' => 'Flags now render consistently across all platforms and browsers.',
'de' => '<strong>Flaggen-Icons im Sprachumschalter (Seitenleiste):</strong> Die Flaggen neben den HU/EN-Sprachumschalter-Schaltflächen waren zuvor Emoji-Zeichen (<code>🇭🇺</code>, <code>🇬🇧</code>), die unter Windows nicht gerendert werden (Chrome/Edge unterstützt keine regionalen Indikator-Emoji-Sequenzen). Lösung: Die SVG-Bibliothek <a href="https://flagicons.lipis.dev" target="_blank">flag-icons</a> (CDN, v7.2.3) wird nun geladen und <code>&lt;span class="fi fi-hu"&gt;</code> / <code>&lt;span class="fi fi-gb"&gt;</code>-Elemente ersetzen die Emoji. Flaggen werden nun auf allen Plattformen und Browsern einheitlich gerendert.',
'ro' => '<strong>Icoane de steag în selectorul de limbă (bara laterală):</strong> Steagurile de lângă butoanele selectoare de limbă HU/EN erau anterior caractere emoji (<code>🇭🇺</code>, <code>🇬🇧</code>), care nu se randează pe Windows (Chrome/Edge nu suportă secvențele de emoji indicator regional). Soluție: biblioteca SVG <a href="https://flagicons.lipis.dev" target="_blank">flag-icons</a> (CDN, v7.2.3) este acum încărcată și elementele <code>&lt;span class="fi fi-hu"&gt;</code> / <code>&lt;span class="fi fi-gb"&gt;</code> înlocuiesc emoji-urile. Steagurile se randează acum consistent pe toate platformele și browserele.',
'sk' => '<strong>Ikony vlajok v prepínači jazykov (bočný panel):</strong> Vlajky vedľa tlačidiel prepínača jazykov HU/EN boli predtým znaky emoji (<code>🇭🇺</code>, <code>🇬🇧</code>), ktoré sa na Windows nevykresľujú (Chrome/Edge nepodporuje sekvencie emoji regionálneho indikátora). Oprava: SVG knižnica <a href="https://flagicons.lipis.dev" target="_blank">flag-icons</a> (CDN, v7.2.3) je teraz načítaná a elementy <code>&lt;span class="fi fi-hu"&gt;</code> / <code>&lt;span class="fi fi-gb"&gt;</code> nahrádzajú emoji. Vlajky sa teraz vykresľujú konzistentne na všetkých platformách a prehliadačoch.',
],
// v1.12.0 - README feature list
[
'enEnd' => 'This gives anyone visiting the GitHub repo an instant overview of what is available and what is on the roadmap.',
'de' => '<strong>README — umfassende Funktionsliste mit ✅ / 🔲 Markierungen:</strong> Das Projekt-README wurde umfassend neu geschrieben. Alle implementierten Funktionen sind mit ✅ markiert und alle geplanten Funktionen mit 🔲, gruppiert nach Modul: Kontakte (CRM), Gruppen, Veranstaltungen, E-Mail-Kampagnen, Spenden, Projekte & Aufgaben, Dashboard, Benutzer & Rollen, Link-Sammlung, Einstellungen, Hilfe & Dokumentation, Mehrsprachigkeit, Integrationen & API, Erweitert / Enterprise. Dies gibt jedem, der das GitHub-Repo besucht, einen sofortigen Überblick über das Verfügbare und die Roadmap.',
'ro' => '<strong>README — lista completă de funcționalități cu marcaje ✅ / 🔲:</strong> README-ul proiectului a fost rescris complet. Toate funcționalitățile implementate sunt marcate ✅ și toate funcționalitățile planificate sunt marcate 🔲, grupate pe module: Contacte (CRM), Grupuri, Evenimente, Campanii de e-mail, Donații, Proiecte & Sarcini, Dashboard, Utilizatori & Roluri, Colecție de linkuri, Setări, Ajutor & Documentație, Multilingv, Integrări & API, Avansat / Enterprise. Aceasta oferă oricui vizitează repo-ul GitHub o prezentare instantanee a ceea ce este disponibil și ce este pe foaia de parcurs.',
'sk' => '<strong>README — komplexný zoznam funkcií s označeniami ✅ / 🔲:</strong> README projektu bolo komplexne prepísané. Všetky implementované funkcie sú označené ✅ a všetky plánované funkcie sú označené 🔲, zoskupené podľa modulu: Kontakty (CRM), Skupiny, Udalosti, E-mailové kampane, Dary, Projekty a úlohy, Dashboard, Používatelia a roly, Zbierka odkazov, Nastavenia, Pomoc a dokumentácia, Viacjazyčnosť, Integrácie a API, Pokročilé / Enterprise. To dáva každému, kto navštívi GitHub repo, okamžitý prehľad o tom, čo je k dispozícii a čo je na pláne.',
],
// v1.12.0 - Open Core table
[
'enEnd' => 'The Open Core table was expanded with new rows: Document storage, Survey &amp; form builder, Petition / signature collection, Volunteer hours tracking.',
'de' => '<strong>Open Core-Tabelle und Abschnitt Erweitert / Enterprise synchronisiert:</strong> Die Open Core-Vergleichstabelle und der Abschnitt Erweitert / Enterprise in der Funktionsliste wurden vollständig angeglichen. Zwei-Faktor-Authentifizierung (TOTP) und REST API für mobile Clients sind nun ausschließlich im Enterprise-Abschnitt aufgeführt. Die Open Core-Tabelle wurde mit neuen Zeilen erweitert: Dokumentenspeicher, Umfrage- & Formular-Builder, Petition / Unterschriftensammlung, Ehrenamtliche Zeiterfassung.',
'ro' => '<strong>Tabelul Open Core și secțiunea Avansat / Enterprise sincronizate:</strong> Tabelul de comparație Open Core și secțiunea Avansat / Enterprise din lista de funcționalități au fost aduse în deplină aliniere. Autentificarea cu doi factori (TOTP) și REST API pentru clienți mobili sunt acum enumerate exclusiv în secțiunea Enterprise. Tabelul Open Core a fost extins cu rânduri noi: Stocare documente, Constructor de sondaje & formulare, Petiție / colectare de semnături, Urmărirea orelor de voluntariat.',
'sk' => '<strong>Tabuľka Open Core a sekcia Pokročilé / Enterprise synchronizované:</strong> Porovnávacia tabuľka Open Core a sekcia Pokročilé / Enterprise v zozname funkcií boli uvedené do úplného súladu. Dvojfaktorová autentifikácia (TOTP) a REST API pre mobilných klientov sú teraz uvedené výhradne v sekcii Enterprise. Tabuľka Open Core bola rozšírená o nové riadky: Úložisko dokumentov, Tvorca prieskumov & formulárov, Petícia / zbierka podpisov, Sledovanie dobrovoľníckych hodín.',
],
// v1.12.0 - Help button moved
[
'enEnd' => 'The left sidebar label "Manage Help" was simplified to "Help".',
'de' => '<strong>Hilfe-Schaltfläche in die Schnelllinks-Leiste verschoben:</strong> Die Hilfe-Schaltfläche wurde aus der oberen rechten Ecke des Dashboards entfernt und in der Schnelllinks-Leiste (blauer Topbar) neben Infografiken platziert — nun von jeder Seite aus zugänglich, ohne zum Dashboard zurückzunavigieren. Der linke Seitenleistenname „Hilfe verwalten" wurde zu „Hilfe" vereinfacht.',
'ro' => '<strong>Butonul Ajutor mutat în bara de linkuri rapide:</strong> Butonul Ajutor a fost eliminat din colțul din dreapta sus al Dashboard-ului și plasat în bara de linkuri rapide (bara albastră topbar) lângă Infografice — acum accesibil de pe orice pagină fără a naviga înapoi la Dashboard. Eticheta barei laterale stângi „Gestionare Ajutor" a fost simplificată la „Ajutor".',
'sk' => '<strong>Tlačidlo Pomocník presunuté do lišty rýchlych odkazov:</strong> Tlačidlo Pomocník bolo odstránené z pravého horného rohu dashboardu a umiestnené do lišty rýchlych odkazov (modrý topbar) vedľa Infografík — teraz dostupné z ľubovoľnej stránky bez navigácie späť na Dashboard. Označenie ľavého bočného panela „Správa pomocníka" bolo zjednodušené na „Pomocník".',
],
// v1.12.0 - CSV/Excel import
[
'enEnd' => 'The <code>phpoffice/phpspreadsheet</code> library handles XLSX files.',
'de' => '<strong>CSV / Excel Import &amp; Export (Kontakte):</strong> Auf der Seite <code>/admin/people</code> können alle Kontakte als CSV (UTF-8 BOM, durch Semikolon getrennt) oder Excel (XLSX, fetter Header) exportiert werden. Import: aus CSV- oder XLSX-Dateien mit spaltennamensbasierter Zuordnung, Überspringen vorhandener E-Mail-Adressen. Die Bibliothek <code>phpoffice/phpspreadsheet</code> verarbeitet XLSX-Dateien.',
'ro' => '<strong>Import &amp; Export CSV / Excel (Contacte):</strong> Pe pagina <code>/admin/people</code>, toate contactele pot fi exportate ca CSV (UTF-8 BOM, separator punct și virgulă) sau Excel (XLSX, antet îngroșat). Import: din fișier CSV sau XLSX cu mapare bazată pe numele coloanei, sărindu-se adresele de e-mail existente. Biblioteca <code>phpoffice/phpspreadsheet</code> gestionează fișierele XLSX.',
'sk' => '<strong>Import &amp; export CSV / Excel (Kontakty):</strong> Na stránke <code>/admin/people</code> je možné exportovať všetky kontakty ako CSV (UTF-8 BOM, oddelené bodkočiarkou) alebo Excel (XLSX, tučná hlavička). Import: zo súboru CSV alebo XLSX s mapovaním na základe názvov stĺpcov, preskakovaním existujúcich e-mailových adries. Knižnica <code>phpoffice/phpspreadsheet</code> spracúva súbory XLSX.',
],
// v1.12.0 - Advanced filters
[
'enEnd' => 'Filter combinations can be saved by name and reloaded in one click — per-user filter presets stored in the <code>people_saved_filters</code> table.',
'de' => '<strong>Erweiterte Filter und gespeicherte Suchen (Kontakte):</strong> Erweitertes Filterpanel: Textsuche, Status (Mehrfachauswahl-Chips), Stadt, Quelle, Newsletter-Abonnement, Gruppe, Registrierungsdatumsbereich, Lead-Phase und Mindestpunktzahl. Filterkombinationen können mit Namen gespeichert und mit einem Klick neu geladen werden — benutzerspezifische Filter-Voreinstellungen in der Tabelle <code>people_saved_filters</code>.',
'ro' => '<strong>Filtre avansate și căutări salvate (Contacte):</strong> Panel de filtre extins: căutare text, status (chips cu selecție multiplă), oraș, sursă, abonament la newsletter, grup, interval de date de înregistrare, etapă de lead și scor minim. Combinațiile de filtre pot fi salvate după nume și reîncărcate cu un singur clic — presetări de filtre per utilizator stocate în tabelul <code>people_saved_filters</code>.',
'sk' => '<strong>Pokročilé filtre a uložené vyhľadávania (Kontakty):</strong> Rozšírený panel filtrov: textové vyhľadávanie, stav (multi-výberové čipy), mesto, zdroj, odber newslettera, skupina, rozsah dátumov registrácie, fáza leadu a minimálne skóre. Kombinácie filtrov je možné uložiť podľa názvu a jedným kliknutím ich znova načítať — predvoľby filtrov pre každého používateľa uložené v tabuľke <code>people_saved_filters</code>.',
],
// v1.12.0 - Duplicate detection
[
'enEnd' => 'On merge, empty fields are auto-filled from the other profile, donations, event RSVPs and group memberships are transferred, and the duplicate is soft-deleted.',
'de' => '<strong>Duplikatserkennung und Kontaktzusammenführung:</strong> Neue Seite <code>/admin/people/duplicates</code>, die wahrscheinliche Duplikate nach E-Mail, Telefon und vollständigem Namen (Groß-/Kleinschreibung unempfindlich) identifiziert. Paare werden auf Karten mit dem Übereinstimmungsgrund (E-Mail / Telefon / Name-Badge) angezeigt. Bei der Zusammenführung werden leere Felder automatisch aus dem anderen Profil ausgefüllt, Spenden, Veranstaltungs-RSVPs und Gruppenmitgliedschaften werden übertragen, und das Duplikat wird soft-gelöscht.',
'ro' => '<strong>Detectarea duplicatelor și fuzionarea contactelor:</strong> Noua pagină <code>/admin/people/duplicates</code> care identifică duplicatele probabile după e-mail, telefon și numele complet (insensibil la majuscule/minuscule). Perechile sunt afișate pe carduri cu motivul potrivirii (badge e-mail / telefon / nume). La fuzionare, câmpurile goale sunt completate automat din celălalt profil, donațiile, RSVP-urile la evenimente și apartenența la grupuri sunt transferate, iar duplicatul este șters soft.',
'sk' => '<strong>Detekcia duplikátov a zlučovanie kontaktov:</strong> Nová stránka <code>/admin/people/duplicates</code>, ktorá identifikuje pravdepodobné duplikáty podľa e-mailu, telefónu a celého mena (bez rozlišovania veľkých/malých písmen). Páry sú zobrazené na kartách s dôvodom zhody (badge e-mail / telefón / meno). Pri zlučovaní sa prázdne polia automaticky vyplnia z druhého profilu, dary, RSVP udalostí a členstvá v skupinách sú prenesené a duplikát je soft-vymazaný.',
],
// v1.12.0 - Activity log
[
'enEnd' => 'Displayed as a colour-coded, icon-based vertical timeline on the contact detail page.',
'de' => '<strong>Kontaktbezogenes Aktivitätsprotokoll:</strong> Interaktionshistorie kann für jeden Kontakt aufgezeichnet werden: Telefonanruf, E-Mail, Besprechung, Notiz, Aufgabe, SMS, Sonstiges — mit Zeitstempel, Notizen und dem aufzeichnenden Benutzer. Gespeichert in der Tabelle <code>contact_activities</code>. Wird als farbcodierte, ikonenbasierte vertikale Zeitleiste auf der Kontaktdetailseite angezeigt.',
'ro' => '<strong>Jurnal de activitate per contact:</strong> Istoricul interacțiunilor poate fi înregistrat pentru fiecare contact: Apel telefonic, E-mail, Întâlnire, Notă, Sarcină, SMS, Altele — cu timestamp, note și utilizatorul care le-a înregistrat. Stocat în tabelul <code>contact_activities</code>. Afișat ca o cronologie verticală codificată prin culori, bazată pe icoane, pe pagina de detalii a contactului.',
'sk' => '<strong>Denník aktivity na kontakt:</strong> Pre každý kontakt je možné zaznamenať históriu interakcií: Telefonický hovor, E-mail, Stretnutie, Poznámka, Úloha, SMS, Iné — s časovou pečiatkou, poznámkami a zaznamenávajúcim používateľom. Uložené v tabuľke <code>contact_activities</code>. Zobrazené ako farebne kódovaná, ikona-založená vertikálna časová os na stránke s podrobnosťami kontaktu.',
],
// v1.12.0 - Lead scoring
[
'enEnd' => 'An Evaluation column appears in the contacts list; filterable by stage and minimum score.',
'de' => '<strong>Kontaktaufnahme / Lead-Scoring:</strong> Jedem Kontakt kann eine 6-stufige Vertriebspipeline zugewiesen werden (Neuer Lead → Kontaktiert → Qualifiziert → Angebot gesendet → Konvertiert → Verloren) und ein 1–5-Sterne-Interessenpunktzahl. Die Tabelle <code>people</code> erhält die Spalten <code>lead_stage</code> und <code>lead_score</code>. In der Kontaktliste erscheint eine Bewertungsspalte; filterbar nach Phase und Mindestpunktzahl.',
'ro' => '<strong>Captare contacte / Lead scoring:</strong> Fiecărui contact i se poate atribui un pipeline de vânzări cu 6 etape (Lead nou → Contactat → Calificat → Propunere trimisă → Convertit → Pierdut) și un scor de interes de 1–5 stele. Tabelul <code>people</code> câștigă coloanele <code>lead_stage</code> și <code>lead_score</code>. O coloană de Evaluare apare în lista de contacte; filtrabilă după etapă și scor minim.',
'sk' => '<strong>Príjem kontaktov / Lead scoring:</strong> Každému kontaktu je možné priradiť 6-fázový predajný pipeline (Nový lead → Kontaktovaný → Kvalifikovaný → Zaslaný návrh → Konvertovaný → Stratený) a skóre záujmu 1–5 hviezdičiek. Tabuľka <code>people</code> získa stĺpce <code>lead_stage</code> a <code>lead_score</code>. V zozname kontaktov sa zobrazí stĺpec Hodnotenie; filtrovateľný podľa fázy a minimálneho skóre.',
],
];

$count = 0;
foreach ($items as $item) {
    if (empty($item['de'])) continue; // skip empty (duplicate ending case)
    $found = addTranslation($content, $item['enEnd'], $item['de'], $item['ro'], $item['sk']);
    if ($found) $count++;
    else echo "NOT FOUND: " . substr($item['enEnd'], 0, 60) . "\n";
}

file_put_contents($file, $content);
echo "Done. Fixed $count items. File size: " . strlen($content) . "\n";
