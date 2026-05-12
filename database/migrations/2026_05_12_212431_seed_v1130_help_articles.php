<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $articles = [
            [
                'menu_key'   => 'esemenyek-qr-bejelentkezes',
                'sort_order' => 35,
                'title'      => 'Események – QR-kód bejelentkezés',
                'content'    => <<<'MD'
## QR-kód bejelentkezés

Az esemény résztvevői QR-kódos belépőjeggyel jelentkezhetnek be a helyszínen.

### Belépőjegy megtekintése

Sikeres regisztráció után a megerősítő oldalon megjelenik a **„Jegyem megtekintése"** gomb. A jegy oldala tartalmazza:
- A QR-kódot (a token kódolva)
- Az esemény adatait
- A résztvevő nevét és kísérők számát

A jegyet könyvjelzőbe mentheted vagy kinyomtathatod.

### QR Szkenner (admin)

Az esemény részletoldalán a regisztrációk táblájánál kattints a **QR Szkenner** gombra.

A szkenner oldalon:
1. Kattints a **Szkenner indítása** gombra
2. Tartsd a résztvevő telefonját / nyomtatott jegyét a kamera elé
3. A rendszer azonnal visszajelez: ✅ sikeres bejelentkezés / ⚠️ már bejelentkezett / ❌ ismeretlen token

Ha kamera nem elérhető, a tokent **kézzel is megadhatod** az oldal alján lévő szövegmezőben.

### Manuális bejelentkeztetés

Az esemény részletoldalán minden regisztrációs sor végén van egy **Bejelentkeztet** gomb. Ezzel manuálisan is bejelentkeztethetsz, ill. visszavonhatod a bejelentkezést.

### Statisztika

A regisztrációk táblája felett megjelenik:
- Összes regisztráló száma
- Bejelentkeztek száma
- Még nem érkezett meg

### Bejelentkezés visszaigazolása

Ha valaki bejelentkezett, a jegy oldalán zöld sávban jelenik meg a bejelentkezés időpontja.
MD,
                'title_en'   => 'Events – QR Code Check-In',
                'content_en' => <<<'MD'
## QR Code Check-In

Event attendees can check in at the venue using a QR code ticket.

### Viewing Your Ticket

After a successful registration, a **"View my ticket"** button appears on the confirmation page. The ticket page shows:
- A QR code (encoding the registration token)
- Event details
- Attendee name and number of guests

You can bookmark the ticket URL or print the page.

### QR Scanner (admin)

On the event detail page, click the **QR Scanner** button above the registrations table.

On the scanner page:
1. Click **Start scanner**
2. Hold the attendee's phone or printed ticket up to the camera
3. The system gives instant feedback: ✅ check-in successful / ⚠️ already checked in / ❌ unknown token

If a camera is not available, you can **enter the token manually** using the text field at the bottom of the page.

### Manual Check-In

On the event detail page, each registration row has a **Check in** button at the end. Use this to manually toggle check-in status on or off.

### Statistics

Above the registrations table a summary row shows:
- Total registrations
- Checked in
- Not yet arrived

### Check-In Confirmation

Once an attendee has checked in, a green banner showing the check-in time appears on their ticket page.
MD,
            ],
            [
                'menu_key'   => 'esemenyek-varolista',
                'sort_order' => 36,
                'title'      => 'Események – Várólista kezelése',
                'content'    => <<<'MD'
## Várólista kezelése

Ha egy esemény betelt, a látogatóknak lehetőségük van feliratkozni a várólistára – és automatikusan értesítést kapnak, ha hely szabadul fel.

### Várólista engedélyezése

Az esemény szerkesztő oldalon jelöld be a **Várólista engedélyezve** jelölőnégyzetet. Ez csak kapacitáskorláttal rendelkező eseményeknél hatásos.

### Publikus működés

Ha az esemény betelt és a várólista aktív:
- A regisztrációs oldalon sárga **„Feliratkozás a várólistára"** űrlap jelenik meg
- Az aktuális várakozók száma is látható
- Feliratkozás után a látogató **e-mailt kap** a pozíciószámával

### Automatikus előléptetés

Ha egy adminisztrátor **töröl** egy megerősített regisztrációt:
1. A rendszer automatikusan keresi az első várólistást
2. Az első várólistás **előlép** (megerősített regisztráló lesz)
3. A rendszer **„Hely felszabadult"** e-mailt küld neki, belépőjegy linkkel
4. A várólistán maradók pozíciói automatikusan átrendeződnek

### Várólistaszekció az admin oldalon

Az esemény részletoldalán a regisztrációk alatt megjelenik a **Várólista** szekció:
- Pozíciónként láthatók a várakozók
- **Előléptet** gomb: manuálisan léptetsz elő valakit (ha van szabad hely)
- **×** gomb: törölsz valakit a várólistáról (pozíciók automatikusan átrendeznek)

### Várólistás e-mailek

- **Feliratkozás visszaigazolása** – jelzi a pozíciószámot és hogy értesíteni fogod
- **Hely felszabadult** – tartalmazza az esemény adatait és a belépőjegy linkjét
MD,
                'title_en'   => 'Events – Waitlist Management',
                'content_en' => <<<'MD'
## Waitlist Management

When an event is fully booked, visitors can join a waiting list and be automatically notified when a spot opens up.

### Enabling the Waitlist

On the event edit page, check the **Waitlist enabled** checkbox. This only takes effect for events with a capacity limit.

### Public Behaviour

When an event is full and the waitlist is active:
- A yellow **"Join the waiting list"** form appears on the registration page
- The current number of waiting people is shown
- After signing up, the visitor receives an **email** with their position number

### Automatic Promotion

When an admin **deletes** a confirmed registration:
1. The system automatically finds the first person on the waitlist
2. The first waitlisted entry is **promoted** (becomes a confirmed registration)
3. A **"Spot available"** email is sent with a ticket link
4. The positions of remaining waitlisted entries are automatically reordered

### Waitlist Section in the Admin Panel

Below the registrations table on the event detail page, a **Waiting list** section appears:
- Waiting people are listed by position
- **Promote** button: manually promote someone (if a spot is available)
- **×** button: remove someone from the waitlist (positions are automatically reordered)

### Waitlist Emails

- **Waitlist confirmation** — includes the position number and a note that you will be notified
- **Spot available** — includes the event details and a link to the personal ticket page
MD,
            ],
        ];

        foreach ($articles as $article) {
            $exists = DB::table('help_articles')->where('menu_key', $article['menu_key'])->exists();
            if (! $exists) {
                DB::table('help_articles')->insert(array_merge($article, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
    }

    public function down(): void
    {
        DB::table('help_articles')->whereIn('menu_key', [
            'esemenyek-qr-bejelentkezes',
            'esemenyek-varolista',
        ])->delete();
    }
};
