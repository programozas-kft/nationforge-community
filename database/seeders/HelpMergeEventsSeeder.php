<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Merges "esemenyek-qr-bejelentkezes" into "esemenyek" and deletes the separate article.
 */
class HelpMergeEventsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('help_articles')
            ->where('menu_key', 'esemenyek')
            ->update([
                'content' => <<<'MD'
![Screenshot](/img/sugo/esemenyek.png)

## Események

Az Események modul az összes szervezett program kezelésére szolgál.

**Új esemény létrehozása** – Kattints az „Új esemény" gombra. Megadható:
- Esemény neve és típusa
- Kezdés és befejezés időpontja
- Helyszín (város, cím) vagy Online jelölő
- Leírás és egyéb részletek
- Maximális férőhely (kapacitás) – ha kitöltöd, a rendszer kezeli a várólistát

**Szerkesztés** – Kattints az esemény sorára a táblázatban.

**Törlés** – A törlés gombra kattintva megerősítés után az esemény véglegesen törlődik.

**Közelgő események** – A Főoldalon is megjelennek a hamarosan esedékesek.

---

## Nyilvános eseményoldal és regisztráció

Minden eseményhez létrehozható nyilvános regisztrációs oldal (`/e/{slug}`). A látogatók ezen az oldalon regisztrálhatnak, megadva nevüket, email-jüket és kísérőik számát.

Sikeres regisztráció után a rendszer:
- Megerősítő emailt küld a résztvevőnek
- Belépőjegyet generál egyedi QR-kóddal

---

## QR-kód bejelentkezés

Az esemény résztvevői QR-kódos belépőjeggyel jelentkezhetnek be a helyszínen.

### Belépőjegy megtekintése

Sikeres regisztráció után a megerősítő oldalon megjelenik a **„Jegyem megtekintése"** gomb. A jegy tartalmazza:
- A QR-kódot
- Az esemény adatait
- A résztvevő nevét és kísérők számát

A jegyet könyvjelzőbe mentheted vagy kinyomtathatod.

### QR Szkenner (admin)

Az esemény részletoldalán kattints a **QR Szkenner** gombra.

1. Kattints a **Szkenner indítása** gombra
2. Tartsd a résztvevő telefonját / nyomtatott jegyét a kamera elé
3. A rendszer azonnal visszajelez:
   - ✅ sikeres bejelentkezés
   - ⚠️ már bejelentkezett
   - ❌ ismeretlen token

Ha kamera nem elérhető, a tokent **kézzel is megadhatod** az oldal alján lévő szövegmezőben.

### Manuális bejelentkeztetés

Az esemény részletoldalán minden regisztrációs sor végén van egy **Bejelentkeztet** gomb. Ezzel manuálisan is be- és kijelentkeztethetsz résztvevőket.

### Statisztika

A regisztrációk táblája felett megjelenik:
- Összes regisztráló száma
- Bejelentkeztek száma
- Még nem érkezett meg

---

## Várólista kezelése

Ha egy esemény betelt, a látogatóknak lehetőségük van feliratkozni a várólistára.

**Engedélyezés:** Az esemény szerkesztő oldalon jelöld be a **Várólista engedélyezve** jelölőnégyzetet (csak kapacitáskorláttal rendelkező eseményeknél hatásos).

**Automatikus előléptetés:** Ha egy adminisztrátor töröl egy megerősített regisztrációt, a rendszer automatikusan értesíti az első várólistást és „hely felszabadult" emailt küld belépőjegy linkkel.

**Kézi kezelés:** Az esemény részletoldalán a **Várólista** szekcióban manuálisan is előléptethetsz vagy törölhetsz várólistásokat.
MD,
                'content_en' => <<<'MD'
![Screenshot](/img/sugo/esemenyek.png)

## Events

The Events module is used for managing all organised programmes.

**Create a new event** – Click the "New event" button. You can specify:
- Event name and type
- Start and end date/time
- Venue (city, address) or Online flag
- Description and other details
- Maximum capacity – if set, the system manages the waiting list

**Edit** – Click the event row in the table.

**Delete** – After clicking the delete button and confirming, the event is permanently removed.

**Upcoming events** – Events due soon are also shown on the Dashboard.

---

## Public Event Page and Registration

A public registration page (`/e/{slug}`) can be created for each event. Visitors can register by entering their name, email, and number of guests.

After a successful registration, the system:
- Sends a confirmation email to the attendee
- Generates a ticket with a unique QR code

---

## QR Code Check-In

Event attendees can check in at the venue using a QR code ticket.

### Viewing Your Ticket

After a successful registration, a **"View my ticket"** button appears on the confirmation page. The ticket shows:
- A QR code
- Event details
- Attendee name and number of guests

You can bookmark the ticket URL or print the page.

### QR Scanner (admin)

On the event detail page, click the **QR Scanner** button.

1. Click **Start scanner**
2. Hold the attendee's phone or printed ticket up to the camera
3. The system gives instant feedback:
   - ✅ check-in successful
   - ⚠️ already checked in
   - ❌ unknown token

If a camera is not available, you can **enter the token manually** using the text field at the bottom of the page.

### Manual Check-In

On the event detail page, each registration row has a **Check in** button. Use this to manually toggle check-in status on or off.

### Statistics

Above the registrations table a summary row shows:
- Total registrations
- Checked in
- Not yet arrived

---

## Waitlist Management

When an event is fully booked, visitors can join a waiting list.

**Enable it:** On the event edit page, check the **Waitlist enabled** checkbox (only effective for events with a capacity limit).

**Automatic promotion:** When an admin deletes a confirmed registration, the system automatically notifies the first waitlisted person and sends a "spot available" email with a ticket link.

**Manual management:** In the **Waiting list** section on the event detail page, you can manually promote or remove waitlisted entries.
MD,
                'updated_at' => now(),
            ]);

        DB::table('help_articles')->where('menu_key', 'esemenyek-qr-bejelentkezes')->delete();
        DB::table('help_articles')->where('menu_key', 'esemenyek-varolista')->delete();

        $this->command->info('  ✓ esemenyek — kibővítve QR bejelentkezéssel és várólistával');
        $this->command->info('  ✗ esemenyek-qr-bejelentkezes — törölve');
        $this->command->info('  ✗ esemenyek-varolista — törölve');
    }
}
