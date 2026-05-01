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

    <!-- LATEST VERSION -->
    <div class="tl-item">
        <div class="tl-dot latest">
            <svg width="12" height="12" fill="white" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
        </div>
        <div class="tl-content">
            <div class="tl-header">
                <div class="tl-title">
                    v1.1.0 
                    <span class="tl-badge badge-success" style="background:rgba(10,179,156,0.1);color:#0ab39c;">Aktuális, Legújabb</span>
                </div>
                <div class="tl-date">Frissítve: Ma</div>
            </div>
            <ul>
                <li><strong>Önálló Súgó oldal kialakítása:</strong> A súgó popup rendszert leváltotta egy elegáns, teljes oldalas megjelenítés.</li>
                <li><strong>Markdown támogatás:</strong> A súgó cikkeket mostantól Markdown formátummal is lehet rendszerezni (félkövér, címsorok stb.).</li>
                <li><strong>Adatbázis korrekciók:</strong> A súgó alapértelmezett cikkei nyelvtanilag tökéletes, magyar ékezetes formában kerültek rögzítésre.</li>
                <li><strong>Verziókövetés (Changelog):</strong> Létrehozásra került ez a menüpont a fejlesztések és az eddigi munka áttekintésére.</li>
            </ul>
        </div>
    </div>

    <!-- PREVIOUS VERSION -->
    <div class="tl-item">
        <div class="tl-dot"></div>
        <div class="tl-content">
            <div class="tl-header">
                <div class="tl-title">
                    v1.0.0
                    <span class="tl-badge badge-primary" style="background:rgba(64,81,137,0.1);color:#405189;">Mérföldkő</span>
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
