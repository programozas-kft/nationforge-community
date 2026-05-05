@extends('admin.layouts.app')

@section('title', 'Verziókövetés')
@section('header', 'Verziókövetés (Changelog)')
@section('breadcrumb')
    <span style="color:#dee2e6">/</span>
    <span style="color:#495057">Verziókövetés</span>
@endsection

@section('content')

<style>
    .timeline {
        position: relative;
        max-width: 800px;
        margin: 0 auto;
        padding-left: 30px;
    }
    .timeline::before {
        content: '';
        position: absolute;
        top: 0; bottom: 0; left: 11px;
        width: 2px;
        background: #e9ebec;
    }
    .tl-item {
        position: relative;
        margin-bottom: 40px;
    }
    .tl-dot {
        position: absolute;
        left: -30px;
        top: 4px;
        width: 24px; height: 24px;
        border-radius: 50%;
        background: #405189;
        border: 4px solid #f3f3f9;
        display: flex; align-items: center; justify-content: center;
    }
    .tl-dot.latest {
        background: #0ab39c; /* Zöld jelőli a legújabbat */
        box-shadow: 0 0 0 3px rgba(10,179,156,0.15);
    }
    .tl-content {
        background: #fff;
        border: 1px solid #e9ebec;
        border-radius: 8px;
        padding: 24px;
        box-shadow: 0 2px 4px rgba(56,65,74,0.05);
    }
    .tl-header {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px; border-bottom: 1px solid #e9ebec;
    }
    .tl-title { font-size: 1.15rem; font-weight: 700; color: #2a2f45; display: flex; align-items: center; gap: 10px; }
    .tl-date { color: #878a99; font-size: 0.8rem; font-weight: 500; }
    
    .tl-content ul {
        list-style: none;
        padding: 0; margin: 0;
    }
    .tl-content ul li {
        position: relative;
        padding-left: 20px;
        margin-bottom: 12px;
        color: #495057;
        font-size: 0.9rem;
        line-height: 1.5;
    }
    .tl-content ul li::before {
        content: '❖';
        position: absolute;
        left: 0; top: 0px;
        color: #405189;
        font-size: 0.75rem;
    }
    .tl-badge {
        font-size: 0.65rem; padding: 3px 8px; border-radius: 4px; font-weight: 600; margin-left: 8px;
    }
</style>

<div class="timeline">

    <!-- v1.8.0 LATEST -->
    <div class="tl-item">
        <div class="tl-dot latest">
            <svg width="12" height="12" fill="white" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
        </div>
        <div class="tl-content">
            <div class="tl-header">
                <div class="tl-title">
                    v1.8.0
                    <span class="tl-badge" style="background:rgba(10,179,156,0.1);color:#0ab39c;">Aktuális, Legújabb</span>
                </div>
                <div class="tl-date">2026. május 5.</div>
            </div>
            <ul>
                <li><strong>Esemény 500-as hiba javítása (EventRsvp model):</strong> Az esemény részletoldal és a szerkesztés utáni átirányítás 500-as szerverhibával végződött, mert a <code>App\Models\EventRsvp</code> osztály hiányzott, noha az <code>event_rsvps</code> tábla az adatbázisban már létezett. A modell létrehozása megszüntette a hibát.</li>
                <li><strong>Esemény létrehozás/módosítás 500-as hiba javítása (ticket_price):</strong> Production MySQL strict módban az üres jegyár mező <code>NULL</code> értékként jutott a <code>NOT NULL</code> oszlopba, ami szerverhibát okozott. A vezérlőben bevezetett <code>?? 0</code> visszavezető érték mind a <code>store()</code>, mind az <code>update()</code> metódusban megoldja a problémát.</li>
                <li><strong>Közelgő események helyes számlálása:</strong> A főoldal „Közelgő esemény" számlálója korábban csak a <em>published</em> státuszú eseményeket vette figyelembe, holott az újonnan létrehozott események alapértelmezetten <em>draft</em> státusszal jönnek létre. Mostantól a <em>cancelled</em> és <em>completed</em> kivételével minden jövőbeli esemény beleszámít.</li>
                <li><strong>Főoldal görgetés javítása:</strong> A dashboard tartalom nem volt görgethetőÍ. A layout főoszlopa explicit <code>height: calc(100vh - 38px)</code> magasságot kapott, a <code>&lt;main&gt;</code> elem pedig <code>flex:1; min-height:0</code> kombinációval tölti ki a maradék területet — így a hosszabb tartalmak helyesen görgethetők.</li>
                <li><strong>Panel padding egységesítés (Esemény részletek, Közelgő események):</strong> Az Esemény részletoldal Részletek panelén és a főoldal Közelgő események listáján a Tailwind <code>px-5</code> osztályok helyett garantáltan érvényesülő inline <code>padding: 20px</code> stílusok kerültek be, így a szövegek nem érnek a panel széleihez.</li>
            </ul>
        </div>
    </div>

    <!-- v1.7.0 -->
    <div class="tl-item">
        <div class="tl-dot">
            <svg width="12" height="12" fill="white" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
        </div>
        <div class="tl-content">
            <div class="tl-header">
                <div class="tl-title">
                    v1.7.0
                </div>
                <div class="tl-date">2026. május 3.</div>
            </div>
            <ul>
                <li><strong>Oldalsáv menü egyszerűsítése:</strong> A CRM és Adminisztráció legördülő almenük megszűntek. A Kapcsolatok, Csoportok, Felhasználók, Beállítások, Verziókövetés és Súgó kezelése mostantól közvetlen, önálló menüpontokként érhetők el — a navigáció egyetlen kattintással elérhető.</li>
                <li><strong>Csoport részletoldal átrendezése:</strong> Az oldal bal oszlopába kerültek az Adatok és a Tagok panel egymás alatt, míg a Chat ablak a jobb oldali (kétharmados) oszlopot tölti ki — áttekinthetőbb, kétpaneles elrendezés.</li>
                <li><strong>Chat ablak viewport-kitöltés:</strong> A csoport chat ablaka mostantól a böngészőablak teljes magasságát kitölti (topbartól az aljáig), és a jobb szélre van igazítva. JavaScript alapú <code>position: fixed</code> elhelyezés gondoskodik arról, hogy a Livewire poll-frissítés sem állítja vissza a pozíciót.</li>
                <li><strong>Szerepkörök magyar megnevezése:</strong> A Felhasználók létrehozás/szerkesztés modalban és a Csoport részletoldalon a szerepkör nevek angolról magyarra váltottak: <em>super-admin → Főadmin, admin → Admin, editor → Szerkesztő, member → Tag</em>.</li>
                <li><strong>Dashboard grafikonok (Chart.js):</strong> A főoldalra három látványos grafikon került: <em>Havi adományok</em> oszlopdiagram (teljes sor, utolsó 12 hónap), <em>Kapcsolatok növekedése</em> kettős-tengelyes vonaldiagram (kapcsolatok + adományok párhuzamosan), és <em>Kapcsolatok megoszlása</em> fánkdiagram státusz szerint, egyedi százalékos legendával. A grafikonok valós adatbázis-adatokat jelenítenek meg.</li>
            </ul>
        </div>
    </div>

    <!-- v1.6.0 -->
    <div class="tl-item">
        <div class="tl-dot">
            <svg width="12" height="12" fill="white" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
        </div>
        <div class="tl-content">
            <div class="tl-header">
                <div class="tl-title">
                    v1.6.0
                </div>
                <div class="tl-date">2026. május 2.</div>
            </div>
            <ul>
                <li><strong>Felhasználók ↔ Csoportok hozzárendelés:</strong> A rendszer felhasználói (bejelentkezési fiókkal rendelkezők) mostantól csoportokhoz rendelhetők — külön <code>group_user</code> pivot tábla és M:N kapcsolat a <code>User</code> és <code>Group</code> modellek között.</li>
                <li><strong>Csoportok részletoldala — Felhasználók megjelenítése:</strong> A csoport tagok listájában mostantól a Felhasználók is szerepelnek a Kapcsolatok mellett, megjelölve a típusukat (Kapcsolat / Felhasználó), szerepkörük badge-dzsel ellátva.</li>
                <li><strong>Chip/pill csoport-választó:</strong> A Kapcsolatok és Felhasználók szerkesztő modaljaiban a nehézkes többválasztós listát letisztult, kattintható chip-gombok váltják fel — egyetlen kattintással aktiválható/deaktiválható minden csoport.</li>
                <li><strong>Jelszó szem ikon (Felhasználók):</strong> A Felhasználók létrehozás és szerkesztés modalokban a jelszó- és jelszó-megerősítés mezők mellé szem ikon került, amellyel a beírt jelszó láthatóvá tehető.</li>
                <li><strong>Jelszó validációs javítás:</strong> Felhasználó szerkesztésekor az üres jelszó mezők már nem okoznak validációs hibát — a <code>confirmed</code> szabály csak akkor fut le, ha ténylegesen van megadott jelszó.</li>
                <li><strong>Oldalsáv logo csere:</strong> A bal felső sarokbeli ikon lecserélve a NationForge márkaképnek megfelelő sötétkék hatszög alapú „N" logóra, világoskék szegéllyel.</li>
                <li><strong>Oldalsáv menü egyszerűsítése:</strong> A CRM és Adminisztráció legördülő almenük megszűntek — a Kapcsolatok, Csoportok, Felhasználók, Beállítások, Verziókövetés és Súgó kezelése mostantól közvetlen, önálló menüpontokként érhetők el.</li>
            </ul>
        </div>
    </div>

    <!-- v1.5.2 -->
    <div class="tl-item">
        <div class="tl-dot"></div>
        <div class="tl-content">
            <div class="tl-header">
                <div class="tl-title">
                    v1.5.2
                </div>
                <div class="tl-date">2026. május 2.</div>
            </div>
            <ul>
                <li><strong>Főoldal (Dashboard) vizuális finomítása:</strong> A "Legújabb kapcsolatok" listájának igazítása, a megjelenített tartalmak megfelelő bal oldali belső margót (padding) kaptak a szebb elrendezés érdekében.</li>
                <li><strong>Súgó - Dinamikus képmegjelenítés:</strong> A súgó cikkekhez integrálásra került egy teljes képernyős képnézegető (lightbox) funkció.</li>
                <li><strong>Képnagyítás élmény javítása:</strong> A lightbox finomhangolása, így a feltöltött képek (mint pl. a beillesztett főoldal képernyőkép) kattintáskor a képernyő 90%-át dinamikusan kitöltve jelennek meg, megtartva az eredeti méretarányokat.</li>
            </ul>
        </div>
    </div>

    <!-- v1.5.1 -->
    <div class="tl-item">
        <div class="tl-dot"></div>
        <div class="tl-content">
            <div class="tl-header">
                <div class="tl-title">
                    v1.5.1
                </div>
                <div class="tl-date">2026. május 1.</div>
            </div>
            <ul>
                <li><strong>Elrendezés és görgetés javítása:</strong> A teljes admin felület layoutjának optimalizálása (CSS <code>calc</code> használata a Flexbox korlátok helyett), így a hosszú tartalmak ezentúl tökéletesen görgethetők maradnak.</li>
                <li><strong>Dinamikus számlálók a menüben:</strong> A bal oldali menüsáv mostantól valós időben mutatja az adatbázisban lévő rekordok pontos számát a modulok (Kapcsolatok, Projektek stb.) mellett.</li>
                <li><strong>Livewire 404 hiba javítása Forge-on:</strong> A rendszer automatikusan publikálja a Livewire asseteket telepítéskor (<code>post-autoload-dump</code>), és be lett állítva a pontos statikus fizikai elérési út, kiküszöbölve a Nginx hibás `.js` fájl kiszolgálását az éles szerveren.</li>
                <li><strong>Beragadt csomagok takarítása:</strong> A Filament végleges eltávolításának utolsó lépéseként a felesleges <code>filament:upgrade</code> parancs kikerült a Composer folyamatból, ami eddig telepítési hibát okozott.</li>
            </ul>
        </div>
    </div>

    <!-- v1.5.0 -->
    <div class="tl-item">
        <div class="tl-dot"></div>
        <div class="tl-content">
            <div class="tl-header">
                <div class="tl-title">
                    v1.5.0
                </div>
                <div class="tl-date">2026. május 1.</div>
            </div>
            <ul>
                <li><strong>Sor kattintásra szerkesztés — Csoportok:</strong> Az egész táblázatsor kattintható, megnyitja a szerkesztő modalt. Új szemikon (👁) navigál a részletoldalra az akciósávban.</li>
                <li><strong>Sor kattintásra szerkesztés — Események:</strong> Ugyanez a viselkedés az Események listában, külön Megnyitás gombbal a részletoldalhoz.</li>
                <li><strong>Sor kattintásra szerkesztés — Feladatok:</strong> A feladatlista sorai kattinthatók; a státusz dropdown és a törlés gomb nem indítja el a szerkesztőt (stopPropagation).</li>
                <li><strong>data-* attribútum alapú megközelítés:</strong> Az inline JS argumentumok helyett HTML data-attribútumok tárolják az adatokat — megbízhatóbb, speciális karakterek és ékezetek sem okoznak problémát.</li>
                <li><strong>URL generálás javítása (feladatok):</strong> A szerkesztő form action URL-je Blade <code>url()</code> helperrel generálódik, így XAMPP al-könyvtárban is helyes az útvonal (<code>/nationforge/public/admin/tasks/{id}</code>).</li>
            </ul>
        </div>
    </div>

    <!-- v1.4.0 -->
    <div class="tl-item">
        <div class="tl-dot"></div>
        <div class="tl-content">
            <div class="tl-header">
                <div class="tl-title">
                    v1.4.0
                    <span class="tl-badge" style="background:rgba(64,81,137,0.1);color:#405189;">Új modul</span>
                </div>
                <div class="tl-date">2026. május 1.</div>
            </div>
            <ul>
                <li><strong>Projektkezelő modul:</strong> Teljes CRUD — projektek létrehozása, szerkesztése, törlése. Státusz (tervezés / aktív / lezárt / felfüggesztve) és prioritás (alacsony / közepes / magas) kezeléssel.</li>
                <li><strong>Projekt–Feladat kapcsolat:</strong> Feladatok projektekhez rendelhetők; a projekt részletoldalán látható az összes kapcsolódó feladat.</li>
                <li><strong>Haladásjelző (Progress %):</strong> A projekt előrehaladása automatikusan számítódik a kész feladatok aránya alapján, vizuális progress bar-ral.</li>
                <li><strong>Projekt részletoldal (show):</strong> Bal oszlop: metaadatok, haladás, statisztikák (nyitott / folyamatban / kész feladatszámok). Jobb oszlop: feladatlista inline státuszváltóval.</li>
                <li><strong>Lejárt projekt jelzés:</strong> Ha a projekt határideje elmúlt és még nincs lezárva, piros „Lejárt" badge jelenik meg.</li>
                <li><strong>Projekt szűrő a feladatlistában:</strong> A Feladatok oldalon projekt szerint is szűrhető a lista, beleértve a „Projekt nélküli" feladatok szűrőjét.</li>
            </ul>
        </div>
    </div>

    <!-- v1.3.0 -->
    <div class="tl-item">
        <div class="tl-dot"></div>
        <div class="tl-content">
            <div class="tl-header">
                <div class="tl-title">
                    v1.3.0
                    <span class="tl-badge" style="background:rgba(64,81,137,0.1);color:#405189;">Új modul</span>
                </div>
                <div class="tl-date">2026. május 1.</div>
            </div>
            <ul>
                <li><strong>Feladatkezelő modul:</strong> Teljes CRUD — feladatok létrehozása, szerkesztése, törlése. Prioritás (alacsony / közepes / magas / sürgős) és státusz (nyitott / folyamatban / kész) kezeléssel.</li>
                <li><strong>Inline státuszváltó:</strong> A feladatlista táblázatában közvetlenül váltható a státusz legördülő menüből, oldal-újratöltés nélkül (form submit).</li>
                <li><strong>Felelős hozzárendelés:</strong> Minden feladathoz rendelhető felelős felhasználó; az admin panel felhasználói listájából választható.</li>
                <li><strong>Határidő és lejárat jelzés:</strong> Lejárt feladatoknál piros dátumszín és „Lejárt" badge figyelmezteti az adminisztrátort.</li>
                <li><strong>Statisztikai kártyák:</strong> A feladatlista tetején összesítők jelennek meg: összes / nyitott / folyamatban / kész darabszámokkal, amelyek szűrőként is működnek.</li>
                <li><strong>Sidebar badge:</strong> A navigációs sávban a Feladatok menüpont mellett élő számláló mutatja az aktív (nyitott + folyamatban) feladatok számát.</li>
                <li><strong>GitHub szinkronizáció:</strong> <code>gitupdate.bat</code> szkript a projekt automatikus feltöltéséhez a <em>programozas-kft/nationforge</em> GitHub repóba, XAMPP jogosultsági fix-szel.</li>
            </ul>
        </div>
    </div>

    <!-- v1.2.0 -->
    <div class="tl-item">
        <div class="tl-dot"></div>
        <div class="tl-content">
            <div class="tl-header">
                <div class="tl-title">
                    v1.2.0
                    <span class="tl-badge" style="background:rgba(247,184,75,0.12);color:#c9920a;">Fejlesztés</span>
                </div>
                <div class="tl-date">2026. május 1.</div>
            </div>
            <ul>
                <li><strong>Magyar bejelentkezési felület:</strong> Az összes login oldal szövege (E-mail, Jelszó, Bejelentkezés, hibaüzenetek) teljes egészében magyarra lett fordítva JSON és PHP nyelvi fájlok segítségével.</li>
                <li><strong>Jelszó megjelenítő szem ikon:</strong> A jelszó beviteli mező jobb szélén toggle gomb jelenik meg, amellyel a jelszó láthatóvá / elrejtetté tehető (Alpine.js <code>x-bind:type</code>).</li>
                <li><strong>Különálló admin bejelentkezés:</strong> Az <code>/admin/login</code> route különálló Volt komponenssel rendelkezik; sikeres belépés után az admin dashboardra irányít, nem admin felhasználó esetén hibaüzenet jelenik meg.</li>
                <li><strong>Admin login háttérkép:</strong> Az admin bejelentkezési oldalon teljes képernyős háttérkép látható, a bejelentkezési panel a jobb oldalon félátlátszó, blur-hatású kártyában helyezkedik el.</li>
                <li><strong>AdminMiddleware javítás:</strong> Nem bejelentkezett felhasználó esetén a middleware az <code>admin.login</code> route-ra irányít (korábban 403 hibát dobott).</li>
            </ul>
        </div>
    </div>

    <!-- v1.1.0 -->
    <div class="tl-item">
        <div class="tl-dot"></div>
        <div class="tl-content">
            <div class="tl-header">
                <div class="tl-title">
                    v1.1.0
                    <span class="tl-badge" style="background:rgba(247,184,75,0.12);color:#c9920a;">Fejlesztés</span>
                </div>
                <div class="tl-date">2026. április</div>
            </div>
            <ul>
                <li><strong>Önálló Súgó oldal kialakítása:</strong> A súgó popup rendszert leváltotta egy elegáns, teljes oldalas megjelenítés.</li>
                <li><strong>Markdown támogatás:</strong> A súgó cikkeket mostantól Markdown formátummal is lehet rendszerezni (félkövér, címsorok stb.).</li>
                <li><strong>Adatbázis korrekciók:</strong> A súgó alapértelmezett cikkei nyelvtanilag tökéletes, magyar ékezetes formában kerültek rögzítésre.</li>
                <li><strong>Verziókövetés (Changelog):</strong> Létrehozásra került ez a menüpont a fejlesztések és az eddigi munka áttekintésére.</li>
            </ul>
        </div>
    </div>

    <!-- v1.0.0 -->
    <div class="tl-item">
        <div class="tl-dot"></div>
        <div class="tl-content">
            <div class="tl-header">
                <div class="tl-title">
                    v1.0.0
                    <span class="tl-badge" style="background:rgba(64,81,137,0.1);color:#405189;">Mérföldkő</span>
                </div>
                <div class="tl-date">Indulás, Alaprendszer</div>
            </div>
            <ul>
                <li><strong>Környezet kialakítása:</strong> XAMPP kompatibilitás, URL routing fixek, Laravel 12.56 beállítás.</li>
                <li><strong>Admin felület újjáépítése:</strong> Filament eltávolítása, gyorsabb, modern Velzon-stílusú egyedi Tailwind panellé.</li>
                <li><strong>Jogosultságkezelés:</strong> Spatie Permission alapú szerepkörök (super-admin, admin, editor, member) bevezetése.</li>
                <li><strong>Kapcsolatok (CRM):</strong> Emberek, státuszok, előfizetések, és részletes profiladatok nyilvántartása fejlesztve.</li>
                <li><strong>Csoportok modul:</strong> Kapcsolatok tematikus elrendezése csoportokba M:N kapcsolatokon keresztül.</li>
                <li><strong>Események kezelése:</strong> Események CRUD felülete naptári validációval, RSVP előkészítéssel.</li>
                <li><strong>Adományok megtekintése:</strong> Tranzakciólista a pénzügyi transzferek könnyű nyomonkövetéséhez.</li>
            </ul>
        </div>
    </div>

</div>

@endsection
