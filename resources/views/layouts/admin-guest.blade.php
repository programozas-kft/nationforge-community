<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Admin – {{ config('app.name', 'NationForge') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .guest-wrapper {
                min-height: 100vh;
                position: relative;
                display: flex;
                align-items: center;
                justify-content: flex-end;
            }
            .guest-bg {
                position: fixed;
                inset: 0;
                width: 100%;
                height: 100%;
                object-fit: cover;
                object-position: center top;
                z-index: 0;
            }
            .guest-panel {
                position: relative;
                z-index: 1;
                width: 100%;
                max-width: 480px;
                margin: 2rem 1rem;
                padding: 2.5rem 2.5rem;
                background: rgba(255, 255, 255, 0.92);
                backdrop-filter: blur(6px);
                -webkit-backdrop-filter: blur(6px);
                border-radius: 1rem;
                box-shadow: 0 8px 40px rgba(0,0,0,0.18);
            }
            @media (min-width: 768px) {
                .guest-panel {
                    margin: 2rem 3rem;
                }
            }
            @media (min-width: 1280px) {
                .guest-panel {
                    margin: 2rem 5rem;
                }
            }
            .guest-brand {
                display: block;
                text-align: center;
                font-size: 1.75rem;
                font-weight: 700;
                letter-spacing: -0.02em;
                color: #1e293b;
                text-decoration: none;
                margin-bottom: 1.5rem;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">

        <img class="guest-bg" src="{{ asset('images/nation-forge-fooldal.png') }}" alt="" />

        <div class="guest-wrapper">
            <div class="guest-panel">
                <a href="/admin/login" class="guest-brand">NationForge</a>
                {{ $slot }}
            </div>
        </div>

    </body>
</html>
