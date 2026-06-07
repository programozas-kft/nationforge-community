<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $orgName ?? config('app.name')) – {{ $orgName ?? config('app.name') }}</title>
    <meta name="description" content="@yield('description', '')">
    @php
        $primary     = \App\Models\Setting::get('brand_primary_color', '#405189');
        $orgName     = \App\Models\Setting::get('brand_org_name', config('app.name'));
        $logo        = \App\Models\Setting::get('brand_logo');
        $bookingUrl  = \App\Models\Setting::get('web_booking_url', '');
        $bookingLabel= \App\Models\Setting::get('web_booking_label', 'Időpontfoglalás');
    @endphp
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root { --primary: {{ $primary }}; --primary-dark: color-mix(in srgb, {{ $primary }}, black 20%); }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f5f6fa; color: #1e2535; min-height: 100vh; }

        /* NAV */
        .pub-nav {
            background: transparent;
            padding: 0 24px;
            display: flex;
            align-items: center;
            gap: 0;
            position: fixed;
            top: 0; left: 0; right: 0; width: 100%;
            z-index: 100;
            transition: background 0.3s ease, box-shadow 0.3s ease;
        }
        .pub-nav.nav-scrolled {
            background: var(--primary);
            box-shadow: 0 2px 12px rgba(0,0,0,0.15);
        }
        .pub-nav-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            padding: 14px 0;
            margin-right: 24px;
        }
        .pub-nav-logo {
            width: 36px; height: 36px;
            background: rgba(255,255,255,0.15);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; color: #fff; font-size: 1rem;
            flex-shrink: 0;
            overflow: hidden;
        }
        .pub-nav-logo img { width: 100%; height: 100%; object-fit: cover; }
        .pub-nav-logo.is-avatar { border-radius: 50%; background: transparent; border: 2px solid rgba(255,255,255,0.4); }
        .pub-nav-name { color: #fff; font-weight: 700; font-size: 1.05rem; }
        .pub-nav-links { display: flex; align-items: center; gap: 4px; flex: 1; }
        .pub-nav-link {
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            padding: 8px 14px;
            border-radius: 7px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: background 0.15s, color 0.15s;
        }
        .pub-nav-link:hover, .pub-nav-link.active { background: rgba(255,255,255,0.15); color: #fff; }
        .pub-nav-actions { display: flex; align-items: center; gap: 8px; margin-left: auto; }
        .pub-btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 18px;
            border-radius: 8px;
            font-size: 0.88rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.15s;
            cursor: pointer;
            border: none;
        }
        .pub-btn-white { background: #fff; color: var(--primary); }
        .pub-btn-white:hover { background: #f0f2ff; }
        .pub-btn-outline { background: rgba(255,255,255,0.1); color: #fff; border: 1px solid rgba(255,255,255,0.3); }
        .pub-btn-outline:hover { background: rgba(255,255,255,0.2); }

        /* MAIN */
        .pub-main { min-height: calc(100vh - 80px); }

        /* FOOTER */
        .pub-footer {
            background: #1e2535;
            color: rgba(255,255,255,0.5);
            text-align: center;
            padding: 24px;
            font-size: 0.82rem;
        }
        .pub-footer a { color: rgba(255,255,255,0.6); text-decoration: none; }
        .pub-footer a:hover { color: #fff; }

        /* CONTAINER */
        .pub-container { max-width: 1100px; margin: 0 auto; padding: 0 24px; }

        /* CARDS */
        .pub-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.07);
            overflow: hidden;
            transition: box-shadow 0.15s, transform 0.15s;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .pub-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.12); transform: translateY(-2px); }

        /* SECTION */
        .pub-section { padding: 48px 0; }
        .pub-section-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #1e2535;
            margin-bottom: 24px;
        }
        .pub-section-title span {
            display: inline-block;
            border-bottom: 3px solid var(--primary);
            padding-bottom: 4px;
        }

        /* GRID */
        .pub-grid-3 { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
        .pub-grid-2 { display: grid; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap: 20px; }

        /* EVENT CARD */
        .event-card-date {
            background: var(--primary);
            color: #fff;
            padding: 12px 16px;
            font-size: 0.8rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .event-card-body { padding: 16px; }
        .event-card-title { font-size: 1rem; font-weight: 600; color: #1e2535; margin-bottom: 6px; }
        .event-card-meta { font-size: 0.82rem; color: #64748b; }

        /* BADGE */
        .pub-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .pub-badge-primary { background: color-mix(in srgb, var(--primary), white 85%); color: var(--primary); }

        @media (max-width: 640px) {
            .pub-nav-links { display: none; }
            .pub-grid-3, .pub-grid-2 { grid-template-columns: 1fr; }
        }
    </style>
    @stack('styles')
</head>
<body>

<nav class="pub-nav">
    <a href="{{ route('public.home') }}" class="pub-nav-brand">
        @auth
            @if(auth()->user()->photo)
            <div class="pub-nav-logo is-avatar">
                <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="{{ auth()->user()->name }}">
            </div>
            @else
            <div class="pub-nav-logo">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            @endif
            <span class="pub-nav-name">{{ auth()->user()->name }}</span>
        @else
            @if($logo)
            <div class="pub-nav-logo">
                <img src="{{ asset('storage/' . $logo) }}" alt="{{ $orgName }}">
            </div>
            @else
            <div class="pub-nav-logo">
                {{ strtoupper(substr($orgName, 0, 1)) }}
            </div>
            @endif
            <span class="pub-nav-name">{{ $orgName }}</span>
        @endauth
    </a>

    <div class="pub-nav-links">
        <a href="{{ route('public.home') }}" class="pub-nav-link {{ request()->routeIs('public.home') ? 'active' : '' }}">Főoldal</a>
        <a href="{{ route('public.events') }}" class="pub-nav-link {{ request()->routeIs('public.events') ? 'active' : '' }}">Események</a>
    </div>

    @if($bookingUrl)
    <div style="margin-left:12px; margin-right:8px">
        <a href="{{ $bookingUrl }}" target="_blank" rel="noopener" class="pub-btn pub-btn-white">
            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            {{ $bookingLabel }}
        </a>
    </div>
    @endif

    <div class="pub-nav-actions">
        @auth
            <a href="{{ route('admin.dashboard') }}" class="pub-btn pub-btn-outline">Admin</a>
        @else
            <a href="{{ route('admin.login') }}" class="pub-btn pub-btn-white">Bejelentkezés</a>
        @endauth
    </div>
</nav>

<main class="pub-main">
    @yield('content')
</main>

<footer class="pub-footer">
    <div class="pub-container">
        © {{ date('Y') }} {{ $orgName }} &nbsp;·&nbsp;
        <a href="{{ route('admin.login') }}">Admin belépés</a>
        &nbsp;·&nbsp; Powered by <a href="#">NationForge</a>
    </div>
</footer>

@stack('scripts')
<script>
(function(){
    var nav = document.querySelector('.pub-nav');
    if (!nav) return;
    function update(){ nav.classList.toggle('nav-scrolled', window.scrollY > 60); }
    window.addEventListener('scroll', update, {passive: true});
    update();
})();
</script>
</body>
</html>
