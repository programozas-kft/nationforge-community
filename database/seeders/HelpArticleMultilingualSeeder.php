<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Fills title_de/ro/sk and content_de/ro/sk for all 16 help articles.
 */
class HelpArticleMultilingualSeeder extends Seeder
{
    public function run(): void
    {
        $translations = $this->translations();

        foreach ($translations as $menuKey => $langs) {
            $exists = DB::table('help_articles')->where('menu_key', $menuKey)->exists();
            if (!$exists) {
                $this->command->warn("Article not found: {$menuKey}");
                continue;
            }
            DB::table('help_articles')->where('menu_key', $menuKey)->update(array_merge(
                $langs,
                ['updated_at' => now()]
            ));
            $this->command->info("  ✓ {$menuKey}");
        }
    }

    private function translations(): array
    {
        return [

            // ─── FŐOLDAL ─────────────────────────────────────────────────────
            'fooldal' => [
                'title_de' => 'Startseite',
                'content_de' => <<<'MD'
## Willkommen bei NationForge

Die **Startseite** bietet Ihnen einen schnellen Überblick über die wichtigsten Aktivitäten und Statistiken Ihrer Organisation.

**Was Sie auf der Startseite sehen:**
- Aktuelle Kontakte, Veranstaltungen und Kampagnen
- Kürzliche Aktivitäten und Benachrichtigungen
- Schnellzugriff auf die wichtigsten Funktionen

Die Startseite wird automatisch aktualisiert und zeigt stets die aktuellen Daten Ihrer Organisation.
MD,
                'title_ro' => 'Pagina principală',
                'content_ro' => <<<'MD'
## Bun venit la NationForge

**Pagina principală** vă oferă o prezentare rapidă a celor mai importante activități și statistici ale organizației dvs.

**Ce vedeți pe pagina principală:**
- Contacte, evenimente și campanii recente
- Activități și notificări recente
- Acces rapid la funcțiile principale

Pagina principală se actualizează automat și afișează întotdeauna datele curente ale organizației dvs.
MD,
                'title_sk' => 'Hlavná stránka',
                'content_sk' => <<<'MD'
## Vitajte v NationForge

**Hlavná stránka** vám poskytuje rýchly prehľad o najdôležitejších aktivitách a štatistikách vašej organizácie.

**Čo uvidíte na hlavnej stránke:**
- Aktuálne kontakty, udalosti a kampane
- Nedávne aktivity a oznámenia
- Rýchly prístup k hlavným funkciám

Hlavná stránka sa automaticky aktualizuje a vždy zobrazuje aktuálne údaje vašej organizácie.
MD,
            ],

            // ─── KAPCSOLATOK ─────────────────────────────────────────────────
            'kapcsolatok' => [
                'title_de' => 'Kontakte',
                'content_de' => <<<'MD'
## Kontaktverwaltung

Im **Kontakte**-Bereich verwalten Sie alle Personen, die mit Ihrer Organisation in Verbindung stehen.

**Grundfunktionen:**
- Neuen Kontakt anlegen (Name, E-Mail, Telefon, Adresse)
- Kontaktliste durchsuchen und filtern
- Kontaktdaten bearbeiten oder löschen
- Kontakthistorie und Aktivitätsprotokoll anzeigen

**Import/Export:**
- CSV-Import: Importieren Sie bis zu tausende Kontakte auf einmal
- Excel-Export: Exportieren Sie Ihre gesamte Kontaktliste
- Duplikatprüfung: Das System erkennt doppelte E-Mail-Adressen automatisch

**Filter und Segmentierung:**
- Filtern nach Tags, Gruppen, Status oder Aktivitätsdatum
- Kombinieren Sie mehrere Filter für präzise Suchergebnisse
- Gespeicherte Filter für wiederholten Gebrauch

**Lead-Scoring:**
- Automatische Bewertung von Kontakten nach Aktivität
- Höhere Punkte für E-Mail-Öffnungen, Klicks und Veranstaltungsteilnahme
MD,
                'title_ro' => 'Contacte',
                'content_ro' => <<<'MD'
## Gestionarea contactelor

În secțiunea **Contacte** gestionați toate persoanele asociate cu organizația dvs.

**Funcții de bază:**
- Adăugați un contact nou (Nume, E-mail, Telefon, Adresă)
- Căutați și filtrați lista de contacte
- Editați sau ștergeți datele contactului
- Vizualizați istoricul și jurnalul de activități al contactului

**Import/Export:**
- Import CSV: importați mii de contacte dintr-o dată
- Export Excel: exportați întreaga listă de contacte
- Verificare duplicate: sistemul detectează automat adresele de e-mail duplicate

**Filtre și segmentare:**
- Filtrați după etichete, grupuri, status sau data activității
- Combinați mai multe filtre pentru rezultate precise
- Filtre salvate pentru utilizare repetată

**Lead Scoring:**
- Evaluarea automată a contactelor în funcție de activitate
- Puncte mai mari pentru deschiderea e-mailurilor, clicuri și participarea la evenimente
MD,
                'title_sk' => 'Kontakty',
                'content_sk' => <<<'MD'
## Správa kontaktov

V sekcii **Kontakty** spravujete všetky osoby spojené s vašou organizáciou.

**Základné funkcie:**
- Pridanie nového kontaktu (Meno, E-mail, Telefón, Adresa)
- Vyhľadávanie a filtrovanie zoznamu kontaktov
- Úprava alebo vymazanie údajov kontaktu
- Zobrazenie histórie a záznamu aktivít kontaktu

**Import/Export:**
- Import CSV: importujte tisíce kontaktov naraz
- Export do Excelu: exportujte celý zoznam kontaktov
- Kontrola duplicít: systém automaticky deteguje duplicitné e-mailové adresy

**Filtre a segmentácia:**
- Filtrovanie podľa štítkov, skupín, stavu alebo dátumu aktivity
- Kombinácia viacerých filtrov pre presné výsledky
- Uložené filtre na opakované použitie

**Lead Scoring:**
- Automatické hodnotenie kontaktov podľa aktivity
- Vyššie body za otváranie e-mailov, kliknutia a účasť na podujatiach
MD,
            ],

            // ─── CSOPORTOK ───────────────────────────────────────────────────
            'csoportok' => [
                'title_de' => 'Gruppen',
                'content_de' => <<<'MD'
## Gruppen

Mit **Gruppen** organisieren Sie Ihre Kontakte in sinnvolle Kategorien.

**So funktionieren Gruppen:**
- Erstellen Sie eine neue Gruppe (z. B. „Mitglieder 2024", „Freiwillige", „Newsletter")
- Fügen Sie Kontakte manuell oder per Import zu Gruppen hinzu
- Kontakte können gleichzeitig in mehreren Gruppen sein
- Verwenden Sie Gruppen zum Filtern von Kampagnen und Berichten

**Verwaltung:**
- Gruppen umbenennen, bearbeiten oder löschen
- Mitgliederliste exportieren
- Kontakte aus einer Gruppe entfernen
MD,
                'title_ro' => 'Grupuri',
                'content_ro' => <<<'MD'
## Grupuri

Cu **Grupuri** vă organizați contactele în categorii semnificative.

**Cum funcționează grupurile:**
- Creați un grup nou (ex. „Membri 2024", „Voluntari", „Newsletter")
- Adăugați contacte la grupuri manual sau prin import
- Contactele pot face parte din mai multe grupuri simultan
- Folosiți grupurile pentru filtrarea campaniilor și rapoartelor

**Gestionare:**
- Redenumiți, editați sau ștergeți grupuri
- Exportați lista de membri
- Eliminați contacte dintr-un grup
MD,
                'title_sk' => 'Skupiny',
                'content_sk' => <<<'MD'
## Skupiny

Pomocou **Skupín** organizujete svoje kontakty do zmysluplných kategórií.

**Ako skupiny fungujú:**
- Vytvorte novú skupinu (napr. „Členovia 2024", „Dobrovoľníci", „Newsletter")
- Pridávajte kontakty do skupín manuálne alebo importom
- Kontakty môžu byť súčasne vo viacerých skupinách
- Používajte skupiny na filtrovanie kampaní a správ

**Správa:**
- Premenujte, upravte alebo odstráňte skupiny
- Exportujte zoznam členov
- Odstráňte kontakty zo skupiny
MD,
            ],

            // ─── CSOPORTOK – FÁJLOK & NAPTÁR ─────────────────────────────────
            'csoportok-fajlok-naptar' => [
                'title_de' => 'Dateien & Kalender',
                'content_de' => <<<'MD'
## Dateien & Kalender

Jede Gruppe verfügt über **Dateien** und einen **Kalender** zur Verwaltung gruppenspezifischer Inhalte.

**Dateiverwaltung:**
- Laden Sie Dokumente, Bilder und Dateien für die Gruppe hoch
- Alle Mitglieder der Gruppe haben Zugang zu den gemeinsamen Dateien
- Unterstützte Formate: PDF, Word, Excel, Bilder und mehr

**Gruppenkalender:**
- Erstellen Sie Termine und Veranstaltungen speziell für eine Gruppe
- Behalten Sie gruppenspezifische Ereignisse im Überblick
- Kalendereinträge sind nur für Gruppenmitglieder sichtbar
MD,
                'title_ro' => 'Fișiere & Calendar',
                'content_ro' => <<<'MD'
## Fișiere & Calendar

Fiecare grup are **Fișiere** și un **Calendar** pentru gestionarea conținutului specific grupului.

**Gestionarea fișierelor:**
- Încărcați documente, imagini și fișiere pentru grup
- Toți membrii grupului au acces la fișierele comune
- Formate acceptate: PDF, Word, Excel, imagini și altele

**Calendarul grupului:**
- Creați întâlniri și evenimente specifice unui grup
- Urmăriți evenimentele specifice grupului
- Intrările din calendar sunt vizibile doar pentru membrii grupului
MD,
                'title_sk' => 'Súbory & Kalendár',
                'content_sk' => <<<'MD'
## Súbory & Kalendár

Každá skupina má **Súbory** a **Kalendár** na správu obsahu špecifického pre skupinu.

**Správa súborov:**
- Nahrajte dokumenty, obrázky a súbory pre skupinu
- Všetci členovia skupiny majú prístup k zdieľaným súborom
- Podporované formáty: PDF, Word, Excel, obrázky a ďalšie

**Skupinový kalendár:**
- Vytvárajte termíny a podujatia špecifické pre skupinu
- Sledujte skupinové udalosti
- Záznamy v kalendári sú viditeľné iba pre členov skupiny
MD,
            ],

            // ─── ESEMÉNYEK ───────────────────────────────────────────────────
            'esemenyek' => [
                'title_de' => 'Veranstaltungen',
                'content_de' => <<<'MD'
## Veranstaltungsverwaltung

Im Bereich **Veranstaltungen** organisieren und verwalten Sie alle Events Ihrer Organisation.

**Veranstaltung erstellen:**
- Name, Datum, Uhrzeit und Ort festlegen
- Beschreibung und Details hinzufügen
- Maximale Teilnehmerzahl definieren
- Öffentliche oder interne Veranstaltung auswählen

**Öffentliche Anmeldung:**
- Für öffentliche Events wird automatisch eine Anmeldeseite erstellt
- Besucher können sich direkt über die öffentliche URL anmelden
- Das System sendet automatische Bestätigungs-E-Mails

**QR-Code-Einlass:**
- Jeder Teilnehmer erhält einen individuellen QR-Code
- Scannen Sie den QR-Code am Einlass für schnelles Check-in
- Echtzeit-Anwesenheitsliste im Admin-Bereich

**Warteliste:**
- Bei ausgebuchten Veranstaltungen können sich Interessenten auf die Warteliste setzen
- Wenn ein Platz frei wird, rückt der nächste automatisch nach
- Benachrichtigungen werden automatisch per E-Mail gesendet
MD,
                'title_ro' => 'Evenimente',
                'content_ro' => <<<'MD'
## Gestionarea evenimentelor

În secțiunea **Evenimente** organizați și gestionați toate evenimentele organizației dvs.

**Crearea unui eveniment:**
- Stabiliți numele, data, ora și locul
- Adăugați descriere și detalii
- Definiți numărul maxim de participanți
- Alegeți eveniment public sau intern

**Înregistrare publică:**
- Pentru evenimentele publice se creează automat o pagină de înregistrare
- Vizitatorii se pot înregistra direct prin URL-ul public
- Sistemul trimite automat e-mailuri de confirmare

**Check-in prin cod QR:**
- Fiecare participant primește un cod QR individual
- Scanați codul QR la intrare pentru check-in rapid
- Listă de prezență în timp real în panoul de administrare

**Listă de așteptare:**
- La evenimentele complete, persoanele interesate se pot înscrie pe lista de așteptare
- Când se eliberează un loc, următoarea persoană avansează automat
- Notificările sunt trimise automat prin e-mail
MD,
                'title_sk' => 'Podujatia',
                'content_sk' => <<<'MD'
## Správa podujatí

V sekcii **Podujatia** organizujete a spravujete všetky podujatia vašej organizácie.

**Vytvorenie podujatia:**
- Zadajte názov, dátum, čas a miesto
- Pridajte popis a podrobnosti
- Definujte maximálny počet účastníkov
- Vyberte verejné alebo interné podujatie

**Verejná registrácia:**
- Pre verejné podujatia sa automaticky vytvorí registračná stránka
- Návštevníci sa môžu prihlásiť priamo cez verejnú URL
- Systém automaticky zasiela potvrdzujúce e-maily

**Check-in pomocou QR kódu:**
- Každý účastník dostane individuálny QR kód
- Naskenujte QR kód pri vstupe pre rýchly check-in
- Zoznam prítomnosti v reálnom čase v administrátorskom paneli

**Čakacia listina:**
- Pri vypredaných podujatiach sa záujemci môžu zaradiť na čakaciu listinu
- Keď sa uvoľní miesto, ďalší v poradí postupuje automaticky
- Oznámenia sú zasielané automaticky e-mailom
MD,
            ],

            // ─── ADOMÁNYOK ───────────────────────────────────────────────────
            'adományok' => [
                'title_de' => 'Spenden',
                'content_de' => <<<'MD'
## Spendenverwaltung

Im Bereich **Spenden** erfassen und verwalten Sie alle finanziellen Beiträge für Ihre Organisation.

**Spende erfassen:**
- Betrag, Datum und Zahlungsmethode eingeben
- Spende einem Kontakt zuordnen
- Zweck und Notizen hinzufügen
- Einzel- oder Dauerspende markieren

**Übersicht:**
- Gesamtspendensumme und Statistiken
- Spendenliste filtern nach Zeitraum, Betrag oder Kontakt
- Spendenverlauf pro Kontakt anzeigen

**Export:**
- Spendenliste als Excel oder CSV exportieren
- Verwendung für Buchhaltung und Berichte
MD,
                'title_ro' => 'Donații',
                'content_ro' => <<<'MD'
## Gestionarea donațiilor

În secțiunea **Donații** înregistrați și gestionați toate contribuțiile financiare ale organizației dvs.

**Înregistrarea unei donații:**
- Introduceți suma, data și metoda de plată
- Atribuiți donația unui contact
- Adăugați scopul și note
- Marcați ca donație unică sau recurentă

**Prezentare generală:**
- Suma totală a donațiilor și statistici
- Filtrați lista de donații după perioadă, sumă sau contact
- Vizualizați istoricul donațiilor per contact

**Export:**
- Exportați lista de donații ca Excel sau CSV
- Utilizare pentru contabilitate și rapoarte
MD,
                'title_sk' => 'Dary',
                'content_sk' => <<<'MD'
## Správa darov

V sekcii **Dary** evidujete a spravujete všetky finančné príspevky vašej organizácie.

**Evidencia daru:**
- Zadajte sumu, dátum a spôsob platby
- Priraďte dar kontaktu
- Pridajte účel a poznámky
- Označte ako jednorazový alebo opakovaný dar

**Prehľad:**
- Celková suma darov a štatistiky
- Filtrujte zoznam darov podľa obdobia, sumy alebo kontaktu
- Zobrazte históriu darov na kontakt

**Export:**
- Exportujte zoznam darov ako Excel alebo CSV
- Použitie pre účtovníctvo a správy
MD,
            ],

            // ─── PROJEKTEK ───────────────────────────────────────────────────
            'projektek' => [
                'title_de' => 'Projekte',
                'content_de' => <<<'MD'
## Projektverwaltung

Im Bereich **Projekte** können Sie komplexe Vorhaben strukturiert planen und verfolgen.

**Projekt erstellen:**
- Projektname, Beschreibung und Deadline festlegen
- Verantwortliche Personen zuweisen
- Status definieren: Offen, In Bearbeitung, Abgeschlossen

**Aufgaben innerhalb eines Projekts:**
- Erstellen Sie Aufgaben und Unteraufgaben
- Weisen Sie Aufgaben Teammitgliedern zu
- Setzen Sie Prioritäten und Fälligkeitsdaten
- Verfolgen Sie den Fortschritt

**Projektübersicht:**
- Alle Projekte in einer strukturierten Liste
- Filter nach Status, Verantwortlichem oder Deadline
- Aktivitätsprotokoll für jedes Projekt
MD,
                'title_ro' => 'Proiecte',
                'content_ro' => <<<'MD'
## Gestionarea proiectelor

În secțiunea **Proiecte** puteți planifica și urmări proiecte complexe în mod structurat.

**Crearea unui proiect:**
- Stabiliți numele, descrierea și termenul limită al proiectului
- Atribuiți persoane responsabile
- Definiți statusul: Deschis, În curs, Finalizat

**Sarcini în cadrul unui proiect:**
- Creați sarcini și sub-sarcini
- Atribuiți sarcini membrilor echipei
- Setați priorități și date scadente
- Urmăriți progresul

**Prezentarea generală a proiectului:**
- Toate proiectele într-o listă structurată
- Filtrați după status, responsabil sau termen limită
- Jurnal de activitate pentru fiecare proiect
MD,
                'title_sk' => 'Projekty',
                'content_sk' => <<<'MD'
## Správa projektov

V sekcii **Projekty** môžete štruktúrovane plánovať a sledovať zložité projekty.

**Vytvorenie projektu:**
- Zadajte názov projektu, popis a termín
- Priraďte zodpovedné osoby
- Definujte stav: Otvorený, V priebehu, Dokončený

**Úlohy v rámci projektu:**
- Vytvárajte úlohy a podúlohy
- Priraďte úlohy členom tímu
- Nastavte priority a termíny splatnosti
- Sledujte pokrok

**Prehľad projektov:**
- Všetky projekty v štruktúrovanom zozname
- Filtrujte podľa stavu, zodpovedného alebo termínu
- Záznam aktivít pre každý projekt
MD,
            ],

            // ─── FELADATOK ───────────────────────────────────────────────────
            'feladatok' => [
                'title_de' => 'Aufgaben',
                'content_de' => <<<'MD'
## Aufgabenverwaltung

Im Bereich **Aufgaben** verwalten Sie To-dos und Aktivitäten für Ihr Team.

**Aufgabe erstellen:**
- Titel und Beschreibung eingeben
- Priorität festlegen (Niedrig, Normal, Hoch, Dringend)
- Fälligkeitsdatum setzen
- Teammitglied zuweisen
- Optional: Kontakt oder Projekt verknüpfen

**Aufgabenstatus:**
- Offen → In Bearbeitung → Abgeschlossen
- Status-Änderungen werden im Aktivitätsprotokoll gespeichert

**Übersicht:**
- Aufgaben nach Status, Priorität oder Verantwortlichem filtern
- Meine Aufgaben: nur eigene Aufgaben anzeigen
- Fällige und überfällige Aufgaben hervorheben
MD,
                'title_ro' => 'Sarcini',
                'content_ro' => <<<'MD'
## Gestionarea sarcinilor

În secțiunea **Sarcini** gestionați activitățile și sarcinile echipei dvs.

**Crearea unei sarcini:**
- Introduceți titlul și descrierea
- Stabiliți prioritatea (Scăzut, Normal, Ridicat, Urgent)
- Setați data scadentă
- Atribuiți unui membru al echipei
- Opțional: asociați un contact sau proiect

**Starea sarcinii:**
- Deschis → În curs → Finalizat
- Modificările de stare sunt salvate în jurnalul de activitate

**Prezentare generală:**
- Filtrați sarcinile după stare, prioritate sau responsabil
- Sarcinile mele: afișați doar sarcinile proprii
- Evidențiați sarcinile scadente și depășite
MD,
                'title_sk' => 'Úlohy',
                'content_sk' => <<<'MD'
## Správa úloh

V sekcii **Úlohy** spravujete to-do položky a aktivity vášho tímu.

**Vytvorenie úlohy:**
- Zadajte názov a popis
- Nastavte prioritu (Nízka, Normálna, Vysoká, Urgentná)
- Nastavte dátum splatnosti
- Priraďte členovi tímu
- Voliteľne: prepojte kontakt alebo projekt

**Stav úlohy:**
- Otvorená → V priebehu → Dokončená
- Zmeny stavu sú zaznamenané v denníku aktivít

**Prehľad:**
- Filtrujte úlohy podľa stavu, priority alebo zodpovedného
- Moje úlohy: zobrazujte iba vlastné úlohy
- Zvýraznite splatné a oneskorené úlohy
MD,
            ],

            // ─── E-MAIL KAMPÁNYOK ─────────────────────────────────────────────
            'email-kampanyok' => [
                'title_de' => 'E-Mail-Kampagnen',
                'content_de' => <<<'MD'
## E-Mail-Kampagnen

Im Bereich **E-Mail-Kampagnen** erstellen und versenden Sie Newsletter und Massen-E-Mails.

**Kampagne erstellen:**
- Betreff und Absendername eingeben
- Empfänger auswählen: alle Kontakte, Gruppen oder gespeicherte Filter/Segmente
- E-Mail-Inhalt im Markdown-Editor verfassen
- Versandzeitpunkt planen oder sofort senden

**Personalisierung:**
- `{{name}}` – Name des Empfängers
- `{{email}}` – E-Mail-Adresse des Empfängers

**Tracking:**
- Öffnungsrate: wie viele Empfänger die E-Mail geöffnet haben
- Klickrate: wie viele auf Links geklickt haben

**Abmeldelink:**
- Jede Kampagne enthält automatisch einen Abmeldelink
- Abgemeldete Kontakte werden aus zukünftigen Kampagnen ausgeschlossen
MD,
                'title_ro' => 'Campanii e-mail',
                'content_ro' => <<<'MD'
## Campanii e-mail

În secțiunea **Campanii e-mail** creați și trimiteți newsletters și e-mailuri în masă.

**Crearea unei campanii:**
- Introduceți subiectul și numele expeditorului
- Selectați destinatarii: toate contactele, grupuri sau filtre/segmente salvate
- Compuneți conținutul e-mailului în editorul Markdown
- Planificați ora de trimitere sau trimiteți imediat

**Personalizare:**
- `{{name}}` – Numele destinatarului
- `{{email}}` – Adresa de e-mail a destinatarului

**Monitorizare:**
- Rata de deschidere: câți destinatari au deschis e-mailul
- Rata de clic: câți au dat clic pe linkuri

**Link de dezabonare:**
- Fiecare campanie include automat un link de dezabonare
- Contactele dezabonate sunt excluse din campaniile viitoare
MD,
                'title_sk' => 'E-mailové kampane',
                'content_sk' => <<<'MD'
## E-mailové kampane

V sekcii **E-mailové kampane** vytvárate a odosielate newslettery a hromadné e-maily.

**Vytvorenie kampane:**
- Zadajte predmet a meno odosielateľa
- Vyberte príjemcov: všetky kontakty, skupiny alebo uložené filtre/segmenty
- Napíšte obsah e-mailu v Markdown editore
- Naplánujte čas odoslania alebo odošlite okamžite

**Personalizácia:**
- `{{name}}` – Meno príjemcu
- `{{email}}` – E-mailová adresa príjemcu

**Sledovanie:**
- Miera otvorenia: koľko príjemcov e-mail otvorilo
- Miera kliknutí: koľko kliklo na odkazy

**Odkaz na odhlásenie:**
- Každá kampaň automaticky obsahuje odkaz na odhlásenie
- Odhlásené kontakty sú vylúčené z budúcich kampaní
MD,
            ],

            // ─── DRIP KAMPÁNYOK ───────────────────────────────────────────────
            'drip-kampanyok' => [
                'title_de' => 'Drip-Kampagnen',
                'content_de' => <<<'MD'
## Drip-Kampagnen (automatisierte E-Mail-Sequenzen)

**Drip-Kampagnen** ermöglichen den automatischen Versand einer Reihe von E-Mails über einen definierten Zeitraum.

**Wie es funktioniert:**
1. Erstellen Sie eine Drip-Kampagne und definieren Sie die Sequenz
2. Fügen Sie E-Mail-Schritte hinzu (z. B. Tag 1, Tag 3, Tag 7)
3. Weisen Sie Kontakte der Kampagne zu
4. Die E-Mails werden automatisch zum geplanten Zeitpunkt gesendet

**Anwendungsfälle:**
- Willkommenssequenz für neue Kontakte
- Onboarding neuer Mitglieder
- Erinnerungssequenz vor einer Veranstaltung
- Nachfass-Kampagnen nach Spenden

**Verwaltung:**
- Aktive Abonnenten pro Kampagne anzeigen
- Kampagne pausieren oder stoppen
- Einzelne Kontakte aus einer Kampagne entfernen
- Statistiken: Versandte, Geöffnete, Geklickte E-Mails
MD,
                'title_ro' => 'Campanii drip',
                'content_ro' => <<<'MD'
## Campanii drip (secvențe automate de e-mail)

**Campaniile drip** permit trimiterea automată a unei serii de e-mailuri pe o perioadă definită.

**Cum funcționează:**
1. Creați o campanie drip și definiți secvența
2. Adăugați pași de e-mail (ex. Ziua 1, Ziua 3, Ziua 7)
3. Atribuiți contacte campaniei
4. E-mailurile sunt trimise automat la momentul planificat

**Cazuri de utilizare:**
- Secvență de bun venit pentru contacte noi
- Onboarding pentru membrii noi
- Secvență de memento înainte de un eveniment
- Campanii de urmărire după donații

**Gestionare:**
- Vizualizați abonații activi per campanie
- Pauzați sau opriți campania
- Eliminați contacte individuale dintr-o campanie
- Statistici: E-mailuri trimise, deschise, cu clicuri
MD,
                'title_sk' => 'Drip kampane',
                'content_sk' => <<<'MD'
## Drip kampane (automatizované e-mailové sekvencie)

**Drip kampane** umožňujú automatické odosielanie série e-mailov počas definovaného časového obdobia.

**Ako to funguje:**
1. Vytvorte drip kampaň a definujte sekvenciu
2. Pridajte kroky e-mailov (napr. Deň 1, Deň 3, Deň 7)
3. Priraďte kontakty ku kampani
4. E-maily sa odosielajú automaticky v naplánovanom čase

**Príklady použitia:**
- Uvítacia sekvencia pre nové kontakty
- Onboarding nových členov
- Sekvencia pripomienok pred podujatím
- Následné kampane po daroch

**Správa:**
- Zobrazenie aktívnych odberateľov na kampaň
- Pozastavenie alebo zastavenie kampane
- Odstránenie jednotlivých kontaktov z kampane
- Štatistiky: Odoslané, Otvorené, Kliknuté e-maily
MD,
            ],

            // ─── FELHASZNÁLÓK ─────────────────────────────────────────────────
            'felhasznalok' => [
                'title_de' => 'Benutzer',
                'content_de' => <<<'MD'
## Benutzerverwaltung

Im Bereich **Benutzer** verwalten Sie alle Personen mit Zugang zum NationForge-System.

**Benutzer einladen:**
- E-Mail-Adresse eingeben und Einladung senden
- Der eingeladene Benutzer erhält einen Aktivierungslink
- Rolle beim Einladen festlegen

**Rollen:**
- **Admin**: Vollzugriff auf alle Funktionen und Einstellungen
- **Benutzer**: Zugang zu den Kernfunktionen ohne Systemeinstellungen

**Benutzerverwaltung:**
- Benutzer aktivieren oder deaktivieren
- Passwort zurücksetzen
- Rolle ändern
- Benutzer aus dem System entfernen
MD,
                'title_ro' => 'Utilizatori',
                'content_ro' => <<<'MD'
## Gestionarea utilizatorilor

În secțiunea **Utilizatori** gestionați toate persoanele cu acces la sistemul NationForge.

**Invitarea unui utilizator:**
- Introduceți adresa de e-mail și trimiteți invitația
- Utilizatorul invitat primește un link de activare
- Stabiliți rolul la invitare

**Roluri:**
- **Admin**: Acces complet la toate funcțiile și setările
- **Utilizator**: Acces la funcțiile de bază fără setările de sistem

**Gestionarea utilizatorilor:**
- Activați sau dezactivați utilizatorii
- Resetați parola
- Modificați rolul
- Eliminați utilizatorul din sistem
MD,
                'title_sk' => 'Používatelia',
                'content_sk' => <<<'MD'
## Správa používateľov

V sekcii **Používatelia** spravujete všetky osoby s prístupom do systému NationForge.

**Pozvanie používateľa:**
- Zadajte e-mailovú adresu a odošlite pozvánku
- Pozvaný používateľ dostane aktivačný odkaz
- Pri pozvaní stanovte rolu

**Roly:**
- **Admin**: Úplný prístup ku všetkým funkciám a nastaveniam
- **Používateľ**: Prístup k základným funkciám bez nastavení systému

**Správa používateľov:**
- Aktivujte alebo deaktivujte používateľov
- Resetujte heslo
- Zmeňte rolu
- Odstráňte používateľa zo systému
MD,
            ],

            // ─── AUDIT NAPLÓ ─────────────────────────────────────────────────
            'audit-naplo' => [
                'title_de' => 'Audit-Protokoll',
                'content_de' => <<<'MD'
## Audit-Protokoll

Das **Audit-Protokoll** zeichnet alle wichtigen Aktionen im System auf und ermöglicht vollständige Nachverfolgbarkeit.

**Was wird protokolliert:**
- Erstellung, Bearbeitung und Löschung von Datensätzen
- Benutzeranmeldungen und -abmeldungen
- Import- und Exportvorgänge
- Änderungen an Systemeinstellungen
- Kampagnenversand und E-Mail-Aktionen

**Protokolldetails:**
- Welcher Benutzer hat welche Aktion durchgeführt
- Zeitstempel der Aktion
- Betroffene Datensätze und Änderungen (Alt-Wert → Neu-Wert)
- IP-Adresse des Benutzers

**Filterung:**
- Nach Benutzer, Datum oder Aktionstyp filtern
- Export des Protokolls für externe Prüfungen
MD,
                'title_ro' => 'Jurnal de audit',
                'content_ro' => <<<'MD'
## Jurnal de audit

**Jurnalul de audit** înregistrează toate acțiunile importante din sistem și permite trasabilitate completă.

**Ce se înregistrează:**
- Crearea, editarea și ștergerea înregistrărilor
- Autentificările și deautentificările utilizatorilor
- Operațiunile de import și export
- Modificările la setările sistemului
- Trimiterea campaniilor și acțiunile prin e-mail

**Detaliile înregistrărilor:**
- Ce utilizator a efectuat ce acțiune
- Marca temporală a acțiunii
- Înregistrările afectate și modificările (valoare veche → valoare nouă)
- Adresa IP a utilizatorului

**Filtrare:**
- Filtrați după utilizator, dată sau tipul acțiunii
- Exportați jurnalul pentru audituri externe
MD,
                'title_sk' => 'Auditný denník',
                'content_sk' => <<<'MD'
## Auditný denník

**Auditný denník** zaznamenáva všetky dôležité akcie v systéme a umožňuje úplnú sledovateľnosť.

**Čo sa zaznamenáva:**
- Vytváranie, úprava a mazanie záznamov
- Prihlásenia a odhlásenia používateľov
- Operácie importu a exportu
- Zmeny nastavení systému
- Odosielanie kampaní a e-mailové akcie

**Podrobnosti záznamu:**
- Ktorý používateľ vykonal akú akciu
- Časová pečiatka akcie
- Ovplyvnené záznamy a zmeny (stará hodnota → nová hodnota)
- IP adresa používateľa

**Filtrovanie:**
- Filtrujte podľa používateľa, dátumu alebo typu akcie
- Exportujte denník pre externé audity
MD,
            ],

            // ─── BEÁLLÍTÁSOK ──────────────────────────────────────────────────
            'beallitasok' => [
                'title_de' => 'Einstellungen',
                'content_de' => <<<'MD'
## Systemeinstellungen

Im Bereich **Einstellungen** konfigurieren Sie die grundlegenden Parameter Ihrer NationForge-Instanz.

**Organisationsdaten:**
- Name und Logo der Organisation
- Kontaktdaten und Anschrift
- Standard-Sprache des Systems

**E-Mail-Einstellungen:**
- SMTP-Server-Konfiguration (Host, Port, Benutzername, Passwort)
- Absender-E-Mail und -Name für ausgehende E-Mails
- E-Mail-Verbindung testen

**System:**
- Zeitzone der Organisation
- Währungsformat für Spenden
- Datenschutzeinstellungen

Falsch konfigurierte E-Mail-Einstellungen können dazu führen, dass Kampagnen nicht versendet werden.
MD,
                'title_ro' => 'Setări',
                'content_ro' => <<<'MD'
## Setările sistemului

În secțiunea **Setări** configurați parametrii de bază ai instanței dvs. NationForge.

**Datele organizației:**
- Numele și logo-ul organizației
- Date de contact și adresă
- Limba implicită a sistemului

**Setări e-mail:**
- Configurarea serverului SMTP (Gazdă, Port, Utilizator, Parolă)
- E-mail și nume expeditor pentru e-mailurile trimise
- Testați conexiunea e-mail

**Sistem:**
- Fusul orar al organizației
- Formatul monedei pentru donații
- Setările de confidențialitate

Setările de e-mail configurate incorect pot face ca campaniile să nu fie trimise.
MD,
                'title_sk' => 'Nastavenia',
                'content_sk' => <<<'MD'
## Nastavenia systému

V sekcii **Nastavenia** konfigurujete základné parametre vašej inštancie NationForge.

**Údaje organizácie:**
- Názov a logo organizácie
- Kontaktné údaje a adresa
- Predvolený jazyk systému

**Nastavenia e-mailu:**
- Konfigurácia SMTP servera (Hostiteľ, Port, Používateľ, Heslo)
- E-mail a meno odosielateľa pre odchádzajúce e-maily
- Testovanie e-mailového spojenia

**Systém:**
- Časové pásmo organizácie
- Formát meny pre dary
- Nastavenia ochrany osobných údajov

Nesprávne nakonfigurované nastavenia e-mailu môžu spôsobiť, že kampane sa neodošlú.
MD,
            ],

            // ─── VERZIÓKÖVETÉS ────────────────────────────────────────────────
            'verziokovetes' => [
                'title_de' => 'Versionsverlauf',
                'content_de' => <<<'MD'
## Versionsverlauf

Im Bereich **Versionsverlauf** finden Sie eine Übersicht aller bisherigen Updates und Neuerungen in NationForge.

**Was Sie hier sehen:**
- Neue Funktionen und Erweiterungen nach Version
- Fehlerbehebungen und Verbesserungen
- Änderungen an bestehenden Funktionen

Der Versionsverlauf wird bei jedem Update automatisch ergänzt, sodass Sie stets informiert sind, was sich geändert hat.
MD,
                'title_ro' => 'Istoricul versiunilor',
                'content_ro' => <<<'MD'
## Istoricul versiunilor

În secțiunea **Istoricul versiunilor** găsiți o prezentare a tuturor actualizărilor și noutăților din NationForge.

**Ce vedeți aici:**
- Funcții noi și îmbunătățiri pe versiune
- Remedieri de erori și optimizări
- Modificări ale funcțiilor existente

Istoricul versiunilor este completat automat la fiecare actualizare, astfel încât să fiți mereu informat despre ce s-a schimbat.
MD,
                'title_sk' => 'História verzií',
                'content_sk' => <<<'MD'
## História verzií

V sekcii **História verzií** nájdete prehľad všetkých doterajších aktualizácií a noviniek v NationForge.

**Čo tu uvidíte:**
- Nové funkcie a vylepšenia podľa verzie
- Opravy chýb a zlepšenia
- Zmeny existujúcich funkcií

História verzií sa automaticky dopĺňa pri každej aktualizácii, takže budete vždy informovaní o tom, čo sa zmenilo.
MD,
            ],

            // ─── SÚGÓ KEZELÉS ────────────────────────────────────────────────
            'sugo-kezeles' => [
                'title_de' => 'Hilfeverwaltung',
                'content_de' => <<<'MD'
## Hilfeverwaltung

Im Bereich **Hilfeverwaltung** können Administratoren die Inhalte der Hilfedokumentation bearbeiten.

**Hilfeartikel bearbeiten:**
- Klicken Sie auf „Bearbeiten" neben dem gewünschten Artikel
- Bearbeiten Sie Titel und Inhalt in mehreren Sprachen (HU, EN, DE, RO, SK)
- Der Inhalt wird als Markdown formatiert – Sie können Überschriften, Listen und Bilder einfügen
- Optionaler YouTube- oder Vimeo-Link für Video-Tutorials

**Markdown-Tipps:**
- `## Überschrift` – Abschnittsüberschrift
- `**fett**` – Fettschrift
- `- Punkt` – Aufzählungspunkt
- `` `![Alt](URL)` `` – Bild einfügen

Änderungen werden sofort auf der Hilfeseite sichtbar.
MD,
                'title_ro' => 'Gestionarea ajutorului',
                'content_ro' => <<<'MD'
## Gestionarea ajutorului

În secțiunea **Gestionarea ajutorului** administratorii pot edita conținutul documentației de ajutor.

**Editarea articolelor de ajutor:**
- Faceți clic pe „Editare" lângă articolul dorit
- Editați titlul și conținutul în mai multe limbi (HU, EN, DE, RO, SK)
- Conținutul este formatat ca Markdown – puteți insera titluri, liste și imagini
- Link opțional YouTube sau Vimeo pentru tutoriale video

**Sfaturi Markdown:**
- `## Titlu` – Titlul secțiunii
- `**bold**` – Text îngroșat
- `- Punct` – Element de listă
- `` `![Alt](URL)` `` – Inserare imagine

Modificările sunt vizibile imediat pe pagina de ajutor.
MD,
                'title_sk' => 'Správa pomocníka',
                'content_sk' => <<<'MD'
## Správa pomocníka

V sekcii **Správa pomocníka** môžu administrátori upravovať obsah dokumentácie pomocníka.

**Úprava článkov pomocníka:**
- Kliknite na „Upraviť" vedľa požadovaného článku
- Upravte názov a obsah vo viacerých jazykoch (HU, EN, DE, RO, SK)
- Obsah je formátovaný ako Markdown – môžete vkladať nadpisy, zoznamy a obrázky
- Voliteľný odkaz na YouTube alebo Vimeo pre video tutoriály

**Tipy pre Markdown:**
- `## Nadpis` – Nadpis sekcie
- `**tučné**` – Tučný text
- `- Bod` – Položka zoznamu
- `` `![Alt](URL)` `` – Vloženie obrázka

Zmeny sú okamžite viditeľné na stránke pomocníka.
MD,
            ],

            // ─── NYELVVÁLTÓ ──────────────────────────────────────────────────
            'nyelvvalto-zaszlo' => [
                'title_de' => 'Sprachauswahl',
                'content_de' => <<<'MD'
## Sprachauswahl

NationForge unterstützt mehrere Sprachen. Die **Sprachauswahl** ermöglicht es jedem Benutzer, die Benutzeroberfläche in seiner bevorzugten Sprache anzuzeigen.

**Verfügbare Sprachen:**
- Ungarisch (HU) – Standardsprache
- Englisch (EN)
- Deutsch (DE)
- Rumänisch (RO)
- Slowakisch (SK)

**Sprache wechseln:**
- Klicken Sie auf die Flagge in der Navigationsleiste oder im Hilfefenster
- Die ausgewählte Sprache wird sofort angewendet
- Die Spracheinstellung wird für Ihre Sitzung gespeichert
MD,
                'title_ro' => 'Selectarea limbii',
                'content_ro' => <<<'MD'
## Selectarea limbii

NationForge acceptă mai multe limbi. **Selectarea limbii** permite fiecărui utilizator să vizualizeze interfața în limba preferată.

**Limbi disponibile:**
- Maghiară (HU) – Limba implicită
- Engleză (EN)
- Germană (DE)
- Română (RO)
- Slovacă (SK)

**Schimbarea limbii:**
- Faceți clic pe steag în bara de navigare sau în fereastra de ajutor
- Limba selectată este aplicată imediat
- Setarea limbii este salvată pentru sesiunea dvs.
MD,
                'title_sk' => 'Výber jazyka',
                'content_sk' => <<<'MD'
## Výber jazyka

NationForge podporuje viacero jazykov. **Výber jazyka** umožňuje každému používateľovi zobraziť rozhranie v preferovanom jazyku.

**Dostupné jazyky:**
- Maďarčina (HU) – Predvolený jazyk
- Angličtina (EN)
- Nemčina (DE)
- Rumunčina (RO)
- Slovenčina (SK)

**Zmena jazyka:**
- Kliknite na vlajku v navigačnej lište alebo v okne pomocníka
- Vybraný jazyk sa použije okamžite
- Nastavenie jazyka sa uloží pre vašu reláciu
MD,
            ],

        ];
    }
}
