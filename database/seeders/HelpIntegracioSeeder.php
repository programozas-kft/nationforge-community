<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HelpIntegracioSeeder extends Seeder
{
    public function run(): void
    {
        $exists = DB::table('help_articles')->where('menu_key', 'integraciok')->exists();

        if ($exists) {
            DB::table('help_articles')->where('menu_key', 'integraciok')->update([
                'title'      => 'Integrációk',
                'title_en'   => 'Integrations',
                'content'    => $this->contentHu(),
                'content_en' => $this->contentEn(),
                'content_de' => $this->contentDe(),
                'content_ro' => $this->contentRo(),
                'content_sk' => $this->contentSk(),
                'sort_order' => 120,
                'updated_at' => now(),
            ]);
        } else {
            DB::table('help_articles')->insert([
                'menu_key'   => 'integraciok',
                'title'      => 'Integrációk',
                'title_en'   => 'Integrations',
                'title_de'   => 'Integrationen',
                'title_ro'   => 'Integrări',
                'title_sk'   => 'Integrácie',
                'content'    => $this->contentHu(),
                'content_en' => $this->contentEn(),
                'content_de' => $this->contentDe(),
                'content_ro' => $this->contentRo(),
                'content_sk' => $this->contentSk(),
                'sort_order' => 120,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function contentHu(): string
    {
        return <<<'MD'
![Screenshot](/img/sugo/integraciok.png)

## Integrációk

Az Integrációk oldal lehetővé teszi, hogy a NationForge-ot külső rendszerekhez csatlakoztasd: Google Calendar, Facebook és Zapier / Make automatizációs platformok.

---

### Google Calendar / iCal szinkronizáció

A NationForge minden publikált eseményt elérhetővé tesz egy nyilvános **iCal feed URL-en** keresztül, amelyre bármilyen naptáralkalmazás feliratkozhat.

**Hogyan add hozzá Google Naptárhoz:**

1. Másold ki az **iCal feed URL-t** a „Másol" gombbal
2. Nyisd meg a [Google Naptárt](https://calendar.google.com) → **Más naptárak (+)** → **URL-ből**
3. Illeszd be az URL-t, majd kattints a **„Naptár hozzáadása"** gombra
4. A Google kb. **12–24 óránként** frissíti az előfizetett naptárakat

> Az iCal feed minden naptáralkalmazásban működik, amely támogatja az RFC 5545 formátumot: **Apple Calendar**, **Microsoft Outlook**, **Thunderbird** stb.

A **„Megnyitás Google Naptárban"** gomb egyetlen kattintással elvégzi a fentieket — egyenesen megnyitja a Google Naptár előfizetési felületét az előtöltött URL-lel.

---

### Facebook Események

Az integráció segítségével a NationForge-ban rögzített eseményeket közvetlenül közzéteheted a **Facebook Oldaladra** a Graph API-n keresztül.

**Beállítás:**

| Mező | Leírás |
|------|--------|
| **Facebook Oldal ID** | A Facebook Oldalad numerikus azonosítója (pl. `123456789012345`) |
| **Oldal Hozzáférési Token** | A Graph API-n keresztül generált token. Szükséges jogosultságok: `pages_manage_events`, `pages_read_engagement` |

Mentés után az esemény nézetoldalán megjelenik a **„Közzétesz Facebookon"** gomb. Erre kattintva az esemény automatikusan létrejön a beállított Facebook Oldalon.

**Hogyan szerezd meg az Oldal Hozzáférési Tokent:**

1. Lépj be a [developers.facebook.com](https://developers.facebook.com) oldalra, és hozz létre egy alkalmazást
2. Add hozzá a **„Facebook Login for Business"** terméket
3. A **Graph API Explorerben** válaszd ki az Oldaladat, és generálj **Oldal Hozzáférési Tokent**
4. Szükséges jogosultságok: `pages_manage_events`, `pages_read_engagement`

> Ha az „Oldal Hozzáférési Token" mező üresen maradt vagy a beállítás hiányos, a „Közzétesz Facebookon" gomb hibaüzenetet jelenít meg, és az admin Integrációk oldalára irányít.

---

### Zapier és Make (Integromat)

A NationForge **kimenő webhook** rendszerére (v1.24.0) épülő automatizáció. A Zapier és a Make közvetlenül képes a NationForge eseményeket feldolgozni, és bármilyen külső alkalmazással összekötni — **kód nélkül**.

**Hogyan működik:**

A NationForge minden kijelölt rendszereseménynél HTTP POST kérést küld a beállított URL-re. A Zapier / Make megkapja az adatokat, és bármilyen akcióhoz köti (email küldés, Google Sheets frissítés, Slack üzenet stb.).

#### Zapier beállítása

1. Hozz létre egy új **Zap-et** a Zapier-ben
2. Triggerként válaszd: **„Webhooks by Zapier" → „Catch Hook"**
3. Másold ki a Zapier által generált webhook URL-t
4. A NationForge-ban menj a **Webhookok** oldalra, hozz létre új webhookot ezzel az URL-lel
5. Válaszd ki, melyik eseménytípusra triggereljenek (pl. `contact.created`)
6. Aktiváld a webhookot, majd tesztelj a Zapier felületén

#### Make (Integromat) beállítása

1. Hozz létre egy új **forgatókönyvet** a Make-ben
2. Első modulként add hozzá: **„Webhooks" → „Custom webhook"**
3. Másold ki a Make által generált webhook URL-t
4. A NationForge-ban hozz létre új webhookot ezzel az URL-lel
5. Aktiváld a webhookot és a forgatókönyvet

**Elérhető eseménytípusok:**

| Esemény | Leírás |
|---------|--------|
| `contact.created` | Új kapcsolat rögzítve |
| `contact.updated` | Kapcsolat módosítva |
| `contact.deleted` | Kapcsolat törölve |
| `event.created` | Új esemény létrehozva |
| `event.registration` | Valaki regisztrált az eseményre |
| `donation.created` | Új adomány rögzítve |
| `campaign.sent` | Email kampány elküldve |
| `task.created` | Új feladat létrehozva |
| `task.completed` | Feladat befejezve |
| `drip.enrolled` | Feliratkozott drip kampányba |
| `group.created` | Új csoport létrehozva |
| `group.deleted` | Csoport törölve |

> A webhookok beállításához és kezeléséhez menj a bal oldali menü **Webhook-ok** menüpontjára.
MD;
    }

    private function contentEn(): string
    {
        return <<<'MD'
![Screenshot](/img/sugo/integraciok.png)

## Integrations

The Integrations page allows you to connect NationForge to external services: Google Calendar, Facebook, and Zapier / Make automation platforms.

---

### Google Calendar / iCal Sync

NationForge exposes all published events via a public **iCal feed URL** that any calendar application can subscribe to.

**How to add to Google Calendar:**

1. Copy the **iCal feed URL** using the "Copy" button
2. Open [Google Calendar](https://calendar.google.com) → **Other calendars (+)** → **From URL**
3. Paste the URL, then click **"Add calendar"**
4. Google refreshes subscribed calendars approximately every **12–24 hours**

> The iCal feed works with any app that supports the RFC 5545 format: **Apple Calendar**, **Microsoft Outlook**, **Thunderbird**, etc.

The **"Open in Google Calendar"** button performs the above in a single click — it opens the Google Calendar subscription screen with the URL pre-filled.

---

### Facebook Events

This integration lets you publish NationForge events directly to your **Facebook Page** via the Graph API.

**Configuration:**

| Field | Description |
|-------|-------------|
| **Facebook Page ID** | The numeric identifier of your Facebook Page (e.g. `123456789012345`) |
| **Page Access Token** | Token generated via the Graph API. Required permissions: `pages_manage_events`, `pages_read_engagement` |

After saving, a **"Publish to Facebook"** button appears on each published event page. Clicking it automatically creates the event on the configured Facebook Page.

**How to get a Page Access Token:**

1. Go to [developers.facebook.com](https://developers.facebook.com) and create an app
2. Add the **"Facebook Login for Business"** product
3. In the **Graph API Explorer**, select your page and generate a **Page Access Token**
4. Required permissions: `pages_manage_events`, `pages_read_engagement`

> If the Page Access Token is missing or the integration is not configured, the "Publish to Facebook" button will show an error and redirect you to the Integrations settings page.

---

### Zapier & Make (Integromat)

Automation built on top of NationForge's **outgoing webhook** system (v1.24.0). Both Zapier and Make can receive NationForge events and connect them to any external application — **no code required**.

**How it works:**

Whenever a selected system event occurs, NationForge sends an HTTP POST request to a configured URL. Zapier / Make receives the data and triggers any action you define (send an email, update a Google Sheet, post to Slack, etc.).

#### Setting up Zapier

1. Create a new **Zap** in Zapier
2. Choose the trigger: **"Webhooks by Zapier" → "Catch Hook"**
3. Copy the webhook URL generated by Zapier
4. In NationForge, go to **Webhooks** and create a new webhook with that URL
5. Select which event type should trigger it (e.g. `contact.created`)
6. Activate the webhook, then test from the Zapier interface

#### Setting up Make (Integromat)

1. Create a new **scenario** in Make
2. Add **"Webhooks" → "Custom webhook"** as the first module
3. Copy the webhook URL generated by Make
4. In NationForge, create a new webhook with that URL
5. Activate both the webhook and the scenario

**Available event types:**

| Event | Description |
|-------|-------------|
| `contact.created` | New contact added |
| `contact.updated` | Contact modified |
| `contact.deleted` | Contact deleted |
| `event.created` | New event created |
| `event.registration` | Someone registered for an event |
| `donation.created` | New donation recorded |
| `campaign.sent` | Email campaign sent |
| `task.created` | New task created |
| `task.completed` | Task marked as done |
| `drip.enrolled` | Contact enrolled in drip campaign |
| `group.created` | New group created |
| `group.deleted` | Group deleted |

> To manage webhooks, go to the **Webhooks** section in the left sidebar.
MD;
    }

    private function contentDe(): string
    {
        return <<<'MD'
![Screenshot](/img/sugo/integraciok.png)

## Integrationen

Die Seite „Integrationen" ermöglicht es, NationForge mit externen Diensten zu verbinden: Google Calendar, Facebook und Zapier / Make-Automatisierungsplattformen.

---

### Google Calendar / iCal-Synchronisation

NationForge stellt alle veröffentlichten Veranstaltungen über eine öffentliche **iCal-Feed-URL** bereit, auf die sich jede Kalenderanwendung abonnieren kann.

**So fügst du den Kalender zu Google Kalender hinzu:**

1. Kopiere die **iCal-Feed-URL** mit der Schaltfläche „Kopieren"
2. Öffne [Google Kalender](https://calendar.google.com) → **Weitere Kalender (+)** → **Per URL**
3. Füge die URL ein und klicke auf **„Kalender hinzufügen"**
4. Google aktualisiert abonnierte Kalender ca. alle **12–24 Stunden**

Mit der Schaltfläche **„In Google Kalender öffnen"** gelangt du mit einem Klick direkt zur Abonnementseite.

---

### Facebook-Veranstaltungen

Mit dieser Integration kannst du NationForge-Veranstaltungen direkt auf deiner **Facebook-Seite** über die Graph API veröffentlichen.

**Konfiguration:** Facebook-Seiten-ID und Seiten-Zugriffstoken eingeben (Berechtigungen: `pages_manage_events`, `pages_read_engagement`).

Nach dem Speichern erscheint auf jeder veröffentlichten Veranstaltung die Schaltfläche **„Auf Facebook veröffentlichen"**.

---

### Zapier & Make (Integromat)

Basiert auf dem **Ausgehende-Webhooks**-System von NationForge. Zapier und Make empfangen Ereignisse und verbinden sie mit beliebigen externen Apps — **ohne Code**.

Verfügbare Ereignistypen: `contact.created`, `contact.updated`, `contact.deleted`, `event.created`, `event.registration`, `donation.created`, `campaign.sent`, `task.created`, `task.completed`, `drip.enrolled`, `group.created`, `group.deleted`

> Webhooks verwalten: linkes Menü → **Webhooks**
MD;
    }

    private function contentRo(): string
    {
        return <<<'MD'
![Screenshot](/img/sugo/integraciok.png)

## Integrări

Pagina „Integrări" îți permite să conectezi NationForge la servicii externe: Google Calendar, Facebook și platformele de automatizare Zapier / Make.

---

### Sincronizare Google Calendar / iCal

NationForge pune la dispoziție toate evenimentele publicate printr-o **URL de flux iCal** la care se poate abona orice aplicație de calendar.

**Cum adaugi în Google Calendar:**

1. Copiați **URL-ul fluxului iCal** cu butonul „Copiați"
2. Deschideți [Google Calendar](https://calendar.google.com) → **Alte calendare (+)** → **Din URL**
3. Inserați URL-ul și faceți clic pe **„Adăugați calendar"**
4. Google actualizează calendarele abonate la fiecare **12–24 de ore**

Butonul **„Deschide în Google Calendar"** efectuează pașii de mai sus cu un singur clic.

---

### Evenimente Facebook

Publicați evenimentele NationForge direct pe **Pagina de Facebook** prin intermediul Graph API.

**Configurare:** ID pagină Facebook și Token de acces la pagină (permisiuni necesare: `pages_manage_events`, `pages_read_engagement`).

---

### Zapier & Make (Integromat)

Construit pe sistemul de **webhooks de ieșire** al NationForge. Zapier și Make pot recepționa evenimentele NationForge și le pot conecta la orice aplicație externă — **fără cod**.

Tipuri de evenimente disponibile: `contact.created`, `contact.updated`, `contact.deleted`, `event.created`, `event.registration`, `donation.created`, `campaign.sent`, `task.created`, `task.completed`, `drip.enrolled`, `group.created`, `group.deleted`

> Gestionați webhook-urile din meniul din stânga → **Webhooks**
MD;
    }

    private function contentSk(): string
    {
        return <<<'MD'
![Screenshot](/img/sugo/integraciok.png)

## Integrácie

Stránka „Integrácie" umožňuje prepojiť NationForge s externými službami: Google Calendar, Facebook a automatizačnými platformami Zapier / Make.

---

### Synchronizácia Google Calendar / iCal

NationForge sprístupňuje všetky zverejnené udalosti prostredníctvom verejnej **URL adresy iCal feedu**, na ktorú sa môže prihlásiť akákoľvek kalendárová aplikácia.

**Ako pridať do Google Kalendára:**

1. Skopírujte **URL adresu iCal feedu** pomocou tlačidla „Kopírovať"
2. Otvorte [Google Kalendár](https://calendar.google.com) → **Ďalšie kalendáre (+)** → **Z URL**
3. Vložte URL adresu a kliknite na **„Pridať kalendár"**
4. Google aktualizuje prihlásené kalendáre každých **12–24 hodín**

Tlačidlo **„Otvoriť v Google Kalendári"** vykoná vyššie uvedené kroky jedným kliknutím.

---

### Udalosti na Facebooku

Publikujte udalosti NationForge priamo na **Facebook stránku** prostredníctvom Graph API.

**Nastavenie:** ID stránky Facebook a Prístupový token stránky (potrebné oprávnenia: `pages_manage_events`, `pages_read_engagement`).

---

### Zapier & Make (Integromat)

Postavené na systéme **odchádzajúcich webhookov** NationForge. Zapier a Make môžu prijímať udalosti NationForge a prepájať ich s ľubovoľnými externými aplikáciami — **bez kódu**.

Dostupné typy udalostí: `contact.created`, `contact.updated`, `contact.deleted`, `event.created`, `event.registration`, `donation.created`, `campaign.sent`, `task.created`, `task.completed`, `drip.enrolled`, `group.created`, `group.deleted`

> Webhooky spravujte cez ľavý panel → **Webhooks**
MD;
    }
}
