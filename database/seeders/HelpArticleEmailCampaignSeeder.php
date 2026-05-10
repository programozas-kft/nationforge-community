<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HelpArticleEmailCampaignSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('help_articles')->where('menu_key', 'email-kampanyok')->exists()) {
            return;
        }

        $maxOrder = DB::table('help_articles')->max('sort_order') ?? 0;

        DB::table('help_articles')->insert([
            'menu_key'   => 'email-kampanyok',
            'title'      => 'Email kampányok',
            'title_en'   => 'Email Campaigns',
            'content'    => <<<'MD'
![Screenshot](/img/sugo/kampanyok.png)

## Email kampányok (Pro)

Az **Email kampányok** modul lehetővé teszi, hogy hírleveleket és értesítőket küldj az összes feliratkozott kapcsolatodnak egyetlen kattintással.

### Kampány létrehozása

1. Navigálj az **Email kampányok** menüpontra.
2. Kattints az **+ Új kampány** gombra.
3. Töltsd ki a mezőket:
   - **Kampány neve** – belső azonosítóként szolgál
   - **Email tárgy** – a fogadók postaládájában megjelenő tárgy
   - **Feladó neve / Feladó email** – opcionális, ha üresen hagyod a rendszer alapértelmezett értékét használja
   - **Tartalom** – Markdown formázás támogatott (`**félkövér**`, `# Cím`, `- lista`)
4. Mentsd el → a kampány **Piszkozat** állapotba kerül.

### Kampány küldése

- A listában kattints a **✉ Küldés** gombra.
- A rendszer elküldi az emailt az összes `is_subscribed = true` és érvényes email-lel rendelkező kapcsolatnak.
- Küldés után a kampány állapota **Elküldve** lesz, és megjelenik a sikeres / sikertelen küldések száma.

### Állapotok

| Állapot | Leírás |
|---|---|
| Piszkozat | Szerkeszthető, még nem lett elküldve |
| Küldés alatt | Folyamatban lévő küldés |
| Elküldve | Sikeresen elküldve |
| Sikertelen | Minden küldési kísérlet meghiúsult |

### Resend integráció

Az emailek küldéséhez a **Resend** transactional email szolgáltatás szükséges:
- Regisztrálj a [resend.com](https://resend.com) oldalon
- Verifikáld a saját domainedre vonatkozó DNS rekordokat
- Add meg az API kulcsot a `.env` fájlban: `RESEND_KEY=re_xxxxxxxxxx`
- Állítsd be: `MAIL_MAILER=resend`

> **Fontos:** Csak verifikált domainen lévő feladó email cím fogadható el (pl. `noreply@sajatdomain.hu`).

MD,
            'content_en' => <<<'MD'
![Screenshot](/img/sugo/kampanyok.png)

## Email Campaigns (Pro)

The **Email Campaigns** module lets you send newsletters and notifications to all subscribed contacts with a single click.

### Creating a Campaign

1. Navigate to the **Email Campaigns** menu item.
2. Click **+ New Campaign**.
3. Fill in the fields:
   - **Campaign name** – used as an internal identifier
   - **Email subject** – the subject line recipients will see
   - **Sender name / Sender email** – optional; if left empty, the system default is used
   - **Content** – Markdown formatting supported (`**bold**`, `# Heading`, `- list`)
4. Save → the campaign enters **Draft** status.

### Sending a Campaign

- Click the **✉ Send** button in the campaign list.
- The system sends the email to all contacts with `is_subscribed = true` and a valid email address.
- After sending, the campaign status changes to **Sent**, and the sent / failed counts are displayed.

### Statuses

| Status | Description |
|---|---|
| Draft | Editable, not yet sent |
| Sending | Send in progress |
| Sent | Successfully dispatched |
| Failed | All send attempts failed |

### Resend Integration

Sending emails requires the **Resend** transactional email service:
- Register at [resend.com](https://resend.com)
- Verify the DNS records for your own domain
- Add the API key to the `.env` file: `RESEND_KEY=re_xxxxxxxxxx`
- Set: `MAIL_MAILER=resend`

> **Important:** Only a sender email address on a verified domain is accepted (e.g. `noreply@yourdomain.com`).

MD,
            'sort_order' => $maxOrder + 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
