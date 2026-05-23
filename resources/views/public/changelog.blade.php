<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', $locale) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('changelog.title') }} – {{ config('app.name', 'NationForge') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { background: #f3f3f9; font-family: 'Figtree', sans-serif; margin: 0; }
        .pub-header {
            background: #fff;
            border-bottom: 1px solid #e9ebec;
            padding: 0 2rem;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 4px rgba(56,65,74,0.06);
        }
        .pub-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.1rem;
            color: #2a2f45;
        }
        .pub-logo svg { flex-shrink: 0; }
        .pub-right { display: flex; align-items: center; gap: 12px; }
        .lang-btn {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 5px;
            font-size: 0.8rem;
            font-weight: 600;
            text-decoration: none;
            border: 1px solid #e9ebec;
            color: #495057;
            background: #fff;
            transition: background 0.15s;
        }
        .lang-btn:hover { background: #f3f3f9; }
        .lang-btn.active { background: #405189; color: #fff; border-color: #405189; }
        .pub-login-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 18px;
            background: #405189;
            color: #fff;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.15s;
        }
        .pub-login-btn:hover { background: #3a4878; color: #fff; }
        .pub-main {
            max-width: 900px;
            margin: 2rem auto;
            padding: 0 1.5rem 4rem;
        }
        .pub-page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2a2f45;
            margin-bottom: 0.25rem;
        }
        .pub-page-sub {
            color: #878a99;
            font-size: 0.875rem;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>

<header class="pub-header">
    <div style="display:flex;align-items:center;gap:16px;">
        <a href="https://nationforge.on-forge.com/web/" class="pub-logo">
            <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                <polygon points="16,2 30,9 30,23 16,30 2,23 2,9" fill="#1a2456" stroke="#4a7fd4" stroke-width="1.5"/>
                <text x="16" y="22" text-anchor="middle" font-family="sans-serif" font-weight="700" font-size="16" fill="white">N</text>
            </svg>
            {{ config('app.name', 'NationForge') }}
        </a>
        <span style="color:#dee2e6;font-size:1.1rem;">|</span>
        <a href="https://www.facebook.com/programozas.kft" target="_blank" rel="noopener"
           style="font-size:0.8rem;color:#878a99;text-decoration:none;font-weight:500;white-space:nowrap;"
           onmouseover="this.style.color='#405189'" onmouseout="this.style.color='#878a99'">
            Programozás Kft.
        </a>
    </div>
    <div class="pub-right">
        @php
        $langs = [
            ['lc'=>'hu','flag'=>'hu','label'=>'HU'],
            ['lc'=>'en','flag'=>'gb','label'=>'EN'],
            ['lc'=>'de','flag'=>'de','label'=>'DE'],
            ['lc'=>'ro','flag'=>'ro','label'=>'RO'],
            ['lc'=>'sk','flag'=>'sk','label'=>'SK'],
        ];
        @endphp
        @foreach($langs as $lang)
        <a href="{{ route('locale.switch', $lang['lc']) }}"
           class="lang-btn {{ $locale === $lang['lc'] ? 'active' : '' }}">
            <span class="fi fi-{{ $lang['flag'] }}" style="width:16px;height:12px;display:inline-block;background-size:cover;border-radius:2px;"></span>
            {{ $lang['label'] }}
        </a>
        @endforeach
        <a href="{{ route('admin.login') }}" class="pub-login-btn">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
            </svg>
            {{ __('Log in') }}
        </a>
    </div>
</header>

<main class="pub-main">
    <div class="pub-page-title">{{ __('changelog.header') }}</div>
    <div class="pub-page-sub">{{ config('app.name', 'NationForge') }} – {{ $locale === 'hu' ? 'Verziótörténet' : 'Release history' }}</div>

    @include('admin.partials.changelog_content')
</main>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.2.3/css/flag-icons.min.css"/>
</body>
</html>
