<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
    <a href="{{ route('admin.login') }}" class="pub-logo">
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
            <polygon points="16,2 30,9 30,23 16,30 2,23 2,9" fill="#1a2456" stroke="#4a7fd4" stroke-width="1.5"/>
            <text x="16" y="22" text-anchor="middle" font-family="sans-serif" font-weight="700" font-size="16" fill="white">N</text>
        </svg>
        {{ config('app.name', 'NationForge') }}
    </a>
    <a href="{{ route('admin.login') }}" class="pub-login-btn">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
        </svg>
        {{ __('Log in') }}
    </a>
</header>

<main class="pub-main">
    <div class="pub-page-title">{{ __('changelog.header') }}</div>
    <div class="pub-page-sub">{{ config('app.name', 'NationForge') }} – Release history</div>

    @include('admin.partials.changelog_content')
</main>

</body>
</html>
