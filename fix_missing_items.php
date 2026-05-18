<?php
$file = 'c:/xampp/htdocs/nationforge/resources/views/admin/partials/changelog_content.blade.php';
$content = file_get_contents($file);

// Item 1: Link click tracking (has escaped apostrophe: campaign\'s)
$enPart = "the campaign\'s <code>clicked_count</code> counter, then redirects to the original destination. Unsubscribe and tracking links are excluded from rewriting.'],";
$dePart = "', 'de' => '<strong>Link-Klick-Tracking:</strong> Alle externen Links in E-Mails werden über eine Umleitungs-Proxy-URL (<code>/track/click/{token}?to=...</code>) bereitgestellt. Beim Klick zeichnet das System den <code>clicked_at</code>-Zeitstempel auf und erhöht den <code>clicked_count</code>-Zähler der Kampagne, dann leitet es zum ursprünglichen Ziel weiter. Abmelde- und Tracking-Links sind vom Umschreiben ausgenommen.', 'ro' => '<strong>Urmărirea clicurilor pe linkuri:</strong> Toate linkurile externe din e-mailuri sunt servite printr-un URL proxy de redirecționare (<code>/track/click/{token}?to=...</code>). La clic, sistemul înregistrează timestamp-ul <code>clicked_at</code> și incrementează contorul <code>clicked_count</code> al campaniei, apoi redirecționează către destinația originală. Linkurile de dezabonare și urmărire sunt excluse din rescriere.', 'sk' => '<strong>Sledovanie kliknutí na odkazy:</strong> Všetky externé odkazy v e-mailoch sú obsluhované cez URL presmerúvaného proxy (<code>/track/click/{token}?to=...</code>). Pri kliknutí systém zaznamená časovú pečiatku <code>clicked_at</code> a zvýši počítadlo <code>clicked_count</code> kampane, potom presmeruje na pôvodný cieľ. Odkazy na odhlásenie a sledovacie odkazy sú vylúčené z prepisovania.'],";

if (strpos($content, $enPart) !== false) {
    $content = str_replace($enPart, $enPart . $dePart, $content);
    // Actually we need to replace '], with ', 'de'...],
    // Let's do it differently: replace the full closing
    // Revert - do it properly:
    // The enPart already ends with '], so we replace '], with ', 'de'...],
    echo "Found link click tracking\n";
} else {
    echo "NOT FOUND link click tracking\n";
}

// Actually let's redo this more carefully
// Reset
$content = file_get_contents($file);

// --- Item 1: Link click tracking ---
$old1 = "the campaign\\'s <code>clicked_count</code> counter, then redirects to the original destination. Unsubscribe and tracking links are excluded from rewriting.'],";
$new1 = "the campaign\\'s <code>clicked_count</code> counter, then redirects to the original destination. Unsubscribe and tracking links are excluded from rewriting.', 'de' => '<strong>Link-Klick-Tracking:</strong> Alle externen Links in E-Mails werden über eine Umleitungs-Proxy-URL (<code>/track/click/{token}?to=...</code>) bereitgestellt. Beim Klick zeichnet das System den <code>clicked_at</code>-Zeitstempel auf und erhöht den <code>clicked_count</code>-Zähler der Kampagne, dann leitet es zum ursprünglichen Ziel weiter. Abmelde- und Tracking-Links sind vom Umschreiben ausgenommen.', 'ro' => '<strong>Urmărirea clicurilor pe linkuri:</strong> Toate linkurile externe din e-mailuri sunt servite printr-un URL proxy de redirecționare (<code>/track/click/{token}?to=...</code>). La clic, sistemul înregistrează timestamp-ul <code>clicked_at</code> și incrementează contorul <code>clicked_count</code> al campaniei, apoi redirecționează către destinația originală. Linkurile de dezabonare și urmărire sunt excluse din rescriere.', 'sk' => '<strong>Sledovanie kliknutí na odkazy:</strong> Všetky externé odkazy v e-mailoch sú obsluhované cez URL presmerúvaného proxy (<code>/track/click/{token}?to=...</code>). Pri kliknutí systém zaznamená časovú pečiatku <code>clicked_at</code> a zvýši počítadlo <code>clicked_count</code> kampane, potom presmeruje na pôvodný cieľ. Odkazy na odhlásenie a sledovacie odkazy sú vylúčené z prepisovania.'],";

if (strpos($content, $old1) !== false) {
    $content = str_replace($old1, $new1, $content);
    echo "Fixed: Link click tracking\n";
} else {
    echo "STILL NOT FOUND: link click tracking\n";
    // Debug: show what's actually in file around that text
    $pos = strpos($content, "clicked_count</code> counter, then redirects");
    echo "Raw: " . bin2hex(substr($content, $pos - 5, 20)) . "\n";
    echo "Text: " . substr($content, $pos - 30, 100) . "\n";
}

// --- Item 2: EmailTrackingService (EN version - search for the EN text) ---
// EN starts with: '<strong>EmailTrackingService:</strong> New <code>App\Services\...
// In file it's stored as: 'en'  => '<strong>EmailTrackingService:...
// The EN text uses \\Services\\
$pos2 = strpos($content, 'EmailTrackingService</code> class that uniformly');
if ($pos2 !== false) {
    // Find the '], after this
    $endPos = strpos($content, '],', $pos2);
    $snippet = substr($content, $pos2 - 50, $endPos - $pos2 + 52);
    echo "EmailTracking snippet end: '" . substr($snippet, -30) . "'\n";

    $old2_end = "no filesystem or HTTP request needed for the pixel.'],";
    $new2_end = "no filesystem or HTTP request needed for the pixel.', 'de' => '<strong>EmailTrackingService:</strong> Neue Klasse <code>App\\\\Services\\\\EmailTrackingService</code>, die einheitlich Link-Wrapping (<code>wrapLinks()</code>), Pixel-Injektion (<code>injectPixel()</code>) und die gesamte Pipeline (<code>process()</code>) verarbeitet. Das base64-kodierte GIF wird als Konstante gespeichert — kein Dateisystem oder HTTP-Anfrage für das Pixel erforderlich.', 'ro' => '<strong>EmailTrackingService:</strong> Noua clasă <code>App\\\\Services\\\\EmailTrackingService</code> care gestionează uniform înfășurarea linkurilor (<code>wrapLinks()</code>), injectarea pixelilor (<code>injectPixel()</code>) și întreaga conductă (<code>process()</code>). GIF-ul codificat base64 este stocat ca o constantă — nu este necesară nicio cerere de sistem de fișiere sau HTTP pentru pixel.', 'sk' => '<strong>EmailTrackingService:</strong> Nová trieda <code>App\\\\Services\\\\EmailTrackingService</code>, ktorá jednotne spracúva zabalenie odkazov (<code>wrapLinks()</code>), injekciu pixelov (<code>injectPixel()</code>) a celý pipeline (<code>process()</code>). GIF zakódovaný v base64 je uložený ako konštanta — pre pixel nie je potrebný žiadny súborový systém ani HTTP požiadavka.'],";

    if (strpos($content, $old2_end) !== false) {
        $content = str_replace($old2_end, $new2_end, $content);
        echo "Fixed: EmailTrackingService\n";
    } else {
        echo "NOT FOUND end of EmailTrackingService\n";
    }
} else {
    echo "NOT FOUND EmailTrackingService EN block\n";
}

// --- Item 3: buildRecipientsQuery (EN version) ---
$old3_end = "for tag filter, <code>whereIn(\\'status\\')</code> for status filter.'],";
$new3_end = "for tag filter, <code>whereIn(\\'status\\')</code> for status filter.', 'de' => '<strong><code>buildRecipientsQuery()</code>-Methode am <code>EmailCampaign</code>-Modell:</strong> Ein einheitlicher Query-Builder, der abonnierte Kontakte mit gültigen E-Mails basierend auf dem <code>segment_filters</code>-JSON filtert — mit <code>whereHas(\\'groups\\')</code> für Gruppenfilter, <code>whereHas(\\'tags\\')</code> für Tag-Filter, <code>whereIn(\\'status\\')</code> für Statusfilter.', 'ro' => '<strong>Metoda <code>buildRecipientsQuery()</code> pe modelul <code>EmailCampaign</code>:</strong> Un constructor de interogări unificat care filtrează contactele abonate cu e-mailuri valide pe baza JSON-ului <code>segment_filters</code> — folosind <code>whereHas(\\'groups\\')</code> pentru filtrul de grup, <code>whereHas(\\'tags\\')</code> pentru filtrul de tag, <code>whereIn(\\'status\\')</code> pentru filtrul de stare.', 'sk' => '<strong>Metóda <code>buildRecipientsQuery()</code> na modeli <code>EmailCampaign</code>:</strong> Unifikovaný tvorca dotazov, ktorý filtruje prihlásených kontaktov s platnými e-mailmi na základe JSON <code>segment_filters</code> — pomocou <code>whereHas(\\'groups\\')</code> pre filter skupiny, <code>whereHas(\\'tags\\')</code> pre filter tagov, <code>whereIn(\\'status\\')</code> pre filter stavu.'],";

if (strpos($content, $old3_end) !== false) {
    $content = str_replace($old3_end, $new3_end, $content);
    echo "Fixed: buildRecipientsQuery\n";
} else {
    echo "NOT FOUND: buildRecipientsQuery\n";
    $pos3 = strpos($content, 'whereIn');
    if ($pos3) {
        echo "whereIn context: " . substr($content, $pos3 - 10, 100) . "\n";
    }
}

// --- Item 4: Loading a template (has escaped apostrophe: template\'s) ---
$old4_end = "the selected template\\'s HTML content into the editor. All available templates are listed with a detailed preview.'],";
$new4_end = "the selected template\\'s HTML content into the editor. All available templates are listed with a detailed preview.', 'de' => '<strong>Vorlage in den Kampagneneditor laden:</strong> Im Kampagnenerstellungs- und -bearbeitungsmodal erschien eine Schaltfläche <em>\"Vorlage verwenden\"</em>. Sie öffnet ein Vorlagenauswahl-Modal, aus dem ein einziger Klick den HTML-Inhalt der ausgewählten Vorlage in den Editor lädt. Alle verfügbaren Vorlagen werden mit einer detaillierten Vorschau aufgelistet.', 'ro' => '<strong>Încărcarea unui șablon în editorul de campanie:</strong> Un buton <em>\"Folosiți șablonul\"</em> a apărut în modalul de creare și editare a campaniei. Acesta deschide un modal de selectare a șablonului, din care un singur clic încarcă conținutul HTML al șablonului selectat în editor. Toate șabloanele disponibile sunt listate cu o previzualizare detaliată.', 'sk' => '<strong>Načítanie šablóny do editora kampane:</strong> V modálnom okne vytvorenia a úpravy kampane sa objavilo tlačidlo <em>\"Použiť šablónu\"</em>. Otvára modálny výber šablóny, z ktorého jediné kliknutie načíta HTML obsah vybranej šablóny do editora. Všetky dostupné šablóny sú uvedené s podrobným náhľadom.'],";

if (strpos($content, $old4_end) !== false) {
    $content = str_replace($old4_end, $new4_end, $content);
    echo "Fixed: Loading a template\n";
} else {
    echo "NOT FOUND: Loading a template\n";
    $pos4 = strpos($content, "template\\'s HTML content into the editor");
    if ($pos4) echo "Context: " . substr($content, $pos4 - 20, 100) . "\n";
}

file_put_contents($file, $content);
echo "Done. File size: " . strlen($content) . "\n";
