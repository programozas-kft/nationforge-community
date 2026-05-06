<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('help_articles', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
            $table->text('content_en')->nullable()->after('content');
        });

        $now = now();

        $projektek_hu = <<<'EOT'
A Projektek modul lehetővé teszi a szervezet belső projektjeinek és feladatainak kezelését.

**Projekt létrehozása** - Kattints az "Új projekt" gombra, add meg a projekt nevét, leírását, státuszát és a hozzárendelt tagokat.

**Feladatok kezelése** - Minden projekthez feladatok rendelhetők. A feladatoknál megadható:
- Feladat neve és leírása
- Felelős személy
- Határidő
- Státusz: Nyitott / Folyamatban / Kész

**Státuszok:**
- **Tervezés** – a projekt előkészítési fázisban van
- **Aktív** – a projekt folyamatban van
- **Szüneteltetett** – átmenetileg leállítva
- **Lezárt** – a projekt befejeződött

**Szerkesztés és törlés** - A projektekre kattintva megnyílik a részletes nézet, ahol szerkesztés és törlés is lehetséges.
EOT;

        $projektek_en = <<<'EOT'
The Projects module allows you to manage your organization's internal projects and tasks.

**Create a project** - Click "New project", enter the project name, description, status, and assigned members.

**Task management** - Tasks can be assigned to each project. For each task you can set:
- Task name and description
- Responsible person
- Deadline
- Status: Open / In Progress / Done

**Statuses:**
- **Planning** – project is in the preparation phase
- **Active** – project is currently in progress
- **On hold** – temporarily paused
- **Closed** – project has been completed

**Edit and delete** - Click a project to open the detail view where editing and deletion are available.
EOT;

        $changelog_hu = <<<'EOT'
A Verziókövetés oldal a rendszer fejlesztési naplóját tartalmazza — minden kiadott verzió újdonságait, fejlesztéseit és javításait dokumentálja.

**Verziók** - Az oldalon felülről lefelé haladva a legfrissebb verzió látható először. Minden verziónál megtalálható:
- Verziószám (pl. v1.10.0)
- Kiadás dátuma
- Az adott verzióban elvégzett változtatások listája

**Mire jó?** - Segítségével nyomon követheted, hogy mikor milyen funkció került be a rendszerbe, mit javítottunk, és mi várható a következő verziókban.

**Két nyelvű megjelenítés** - A verziókövetés teljes tartalma elérhető magyarul és angolul is — a jobb felső sarokban lévő nyelvváltóval választható.
EOT;

        $changelog_en = <<<'EOT'
The Changelog page contains the system's development log — documenting the new features, improvements, and fixes in every released version.

**Versions** - The page lists versions from newest to oldest. Each version includes:
- Version number (e.g. v1.10.0)
- Release date
- List of changes made in that version

**What is it for?** - It lets you track when specific features were added, what was fixed, and what to expect in upcoming releases.

**Bilingual display** - The full changelog is available in both Hungarian and English — use the language switcher in the top-right corner to switch.
EOT;

        $sugo_hu = <<<'EOT'
A Súgó kezelése felület lehetővé teszi az adminisztrátorok számára a súgó cikkek tartalmának szerkesztését.

**Cikkek listája** - Az oldalon felsorolva látható az összes súgó cikk rendezési sorrend szerint. Minden cikknél megjelenik a menü kulcsa és a tartalom előnézete.

**Szerkesztés** - A "Szerkesztés" gombra kattintva megnyílik a szerkesztő modal:
- **Menü neve** – ez jelenik meg a súgó oldalsávjában
- **Tartalom** – a cikk szövege, Markdown-szerű formázással

**Formázási lehetőségek a tartalomban:**
- `**félkövér**` → **félkövér** szöveg
- `- lista elem` → felsorolás pont
- Üres sor = bekezdés elválasztó

**Mentés** - A mentés gombra kattintva az új tartalom azonnal érvényes lesz a súgó oldalon.

**Elérés** - A súgó oldal bármely bejelentkezett felhasználó számára elérhető a navigáció "?" ikonjával.
EOT;

        $sugo_en = <<<'EOT'
The Manage Help page allows administrators to edit the content of help articles.

**Article list** - All help articles are listed in sort order. Each article shows its menu key and a content preview.

**Editing** - Click "Edit" to open the editor modal:
- **Menu name** – this appears in the help sidebar
- **Content** – the article text, using Markdown-like formatting

**Formatting options in content:**
- `**bold**` → **bold** text
- `- list item` → bullet point
- Empty line = paragraph separator

**Save** - Clicking Save applies the new content immediately on the help page.

**Access** - The help page is accessible to all logged-in users via the "?" icon in the navigation bar.
EOT;

        DB::table('help_articles')->insert([
            [
                'menu_key'   => 'projektek',
                'title'      => 'Projektek',
                'title_en'   => 'Projects',
                'content'    => $projektek_hu,
                'content_en' => $projektek_en,
                'sort_order' => 8,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'menu_key'   => 'verziokovetes',
                'title'      => 'Verziókövetés',
                'title_en'   => 'Changelog',
                'content'    => $changelog_hu,
                'content_en' => $changelog_en,
                'sort_order' => 9,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'menu_key'   => 'sugo-kezeles',
                'title'      => 'Súgó kezelése',
                'title_en'   => 'Manage Help',
                'content'    => $sugo_hu,
                'content_en' => $sugo_en,
                'sort_order' => 10,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    public function down(): void
    {
        DB::table('help_articles')
            ->whereIn('menu_key', ['projektek', 'verziokovetes', 'sugo-kezeles'])
            ->delete();

        Schema::table('help_articles', function (Blueprint $table) {
            $table->dropColumn(['title_en', 'content_en']);
        });
    }
};
