<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HelpArticleEnTranslationSeeder extends Seeder
{
    public function run(): void
    {
        $translations = [
            'fooldal' => [
                'title_en'   => 'Dashboard',
                'content_en' => <<<'MD'
## Dashboard

The Dashboard gives you an overview of the most important data in the system.

**Stat cards** — Four summary cards are shown at the top of the page:
- **Total contacts** — the number of people in the system, plus new additions this month
- **Upcoming events** — the number of future events
- **Total donations** — the total amount of donations received
- **Newsletter subscribers** — the number of active subscribers

**Latest contacts** — A list of the most recently added people. Click any entry to open the detailed profile.

**Upcoming events** — The nearest upcoming programmes with date, time, and venue.
MD,
            ],

            'kapcsolatok' => [
                'title_en'   => 'Contacts',
                'content_en' => <<<'MD'
## Contacts

The Contacts module is used for the complete management of people and organisations.

**Add a new contact** — Click the "New contact" button. In the pop-up window you can enter the name, email, phone, city, status, source, and notes. A profile photo can also be uploaded.

**Edit** — Click any row in the table; the editor window opens immediately with the current data.

**Statuses:**
- **Member** — active organisational member
- **Supporter** — sympathiser, but not a member
- **Donor** — financially supporting person
- **VIP** — highlighted contact
- **Inactive** — currently not active

**Newsletter** — The subscription checkbox shows who receives email communication.
MD,
            ],

            'esemenyek' => [
                'title_en'   => 'Events',
                'content_en' => <<<'MD'
## Events

The Events module is used for managing all organised programmes.

**Create a new event** — Click the "New event" button. You can specify:
- Event name and type
- Start and end date/time
- Venue (city, address) or Online flag
- Description and other details

**Edit** — Click the event row in the table.

**Delete** — After clicking the delete button and confirming, the event is permanently removed.

**Upcoming events** — Events due soon are also shown on the Dashboard.
MD,
            ],

            'csoportok' => [
                'title_en'   => 'Groups',
                'content_en' => <<<'MD'
## Groups

The Groups module is used for organising contacts thematically.

**Create a new group** — Click the "New group" button and enter the group name and description.

**Manage members** — On the group editing screen, members can be added and removed.

**Usage** — Groups make it easy to filter and target communication, for example when sending newsletters or invitations to events.
MD,
            ],

            'adományok' => [
                'title_en'   => 'Donations',
                'content_en' => <<<'MD'
## Donations

The Donations module is used for recording all incoming financial contributions.

**Donation list** — The table shows the donor name, amount, date of receipt, and payment method.

**Details** — Click a donation row to view the full details.

**Delete** — Incorrect entries can be removed with the delete button.

**Summary** — The total donation amount is also displayed on the Dashboard stat card.
MD,
            ],

            'felhasznalok' => [
                'title_en'   => 'Users',
                'content_en' => <<<'MD'
## Users

The Users page manages access accounts for the administration system.

**New user** — Click the "New user" button. Required fields: full name, email address, password, role. A profile photo can also be uploaded.

**Roles:**
- **super-admin** — full access to everything
- **admin** — administrative rights
- **editor** — content editing rights
- **member** — basic access level

**Edit** — Click the user row. Leaving the password field empty keeps the existing password.

**Own account** — A logged-in user cannot delete their own account.
MD,
            ],

            'beallitasok' => [
                'title_en'   => 'Settings',
                'content_en' => <<<'MD'
## Settings

The Settings page allows you to modify the basic configuration of the system.

**General settings:**
- **System name** — the name displayed on the browser tab and in the admin panel
- **Application URL** — can only be modified in the `.env` file on the server
- **Language** — currently only configurable in `.env`

**Email settings:**
- **Sender name** — this appears as the sender on outgoing emails
- **Sender email** — replies are delivered to this email address

**System information** — The bottom of the page shows the PHP version, Laravel version, and current environment.
MD,
            ],
        ];

        foreach ($translations as $menuKey => $data) {
            DB::table('help_articles')
                ->where('menu_key', $menuKey)
                ->whereNull('title_en')
                ->update([
                    'title_en'   => $data['title_en'],
                    'content_en' => $data['content_en'],
                    'updated_at' => now(),
                ]);
        }
    }
}
