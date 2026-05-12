<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('events.reg_success') }} – {{ $event->title }}</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f3f4f8; color: #212529; min-height: 100vh; }
        .nf-header {
            background: #0b1437; padding: 14px 24px;
            display: flex; align-items: center; gap: 10px;
        }
        .nf-logo {
            width: 32px; height: 32px; background: #1a3a6b;
            border: 2px solid #4d7efa; border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; color: #fff; font-size: 0.9rem;
        }
        .nf-brand { color: #fff; font-weight: 700; font-size: 1rem; }
        .wrap {
            max-width: 520px; margin: 80px auto; padding: 0 20px;
            text-align: center;
        }
        .icon-circle {
            width: 72px; height: 72px; border-radius: 50%;
            background: rgba(10,179,156,0.1);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 24px;
        }
        h1 { font-size: 1.6rem; font-weight: 800; color: #0b1437; margin-bottom: 12px; }
        p { font-size: 0.95rem; color: #495057; line-height: 1.6; margin-bottom: 8px; }
        .event-name { font-weight: 700; color: #405189; }
        .card {
            background: #fff; border: 1px solid #e9ebec; border-radius: 12px;
            padding: 28px; margin-top: 32px;
        }
        .meta-row {
            display: flex; align-items: center; gap: 10px;
            font-size: 0.875rem; color: #495057; padding: 8px 0;
            border-bottom: 1px solid #f3f4f8;
        }
        .meta-row:last-child { border-bottom: none; }
        .meta-icon { color: #405189; flex-shrink: 0; }
        .btn-back {
            display: inline-block; margin-top: 28px;
            padding: 11px 28px; background: #405189; color: #fff;
            border-radius: 8px; text-decoration: none;
            font-weight: 700; font-size: 0.875rem;
        }
        .btn-back:hover { background: #364474; }
    </style>
</head>
<body>

<header class="nf-header">
    <div class="nf-logo">N</div>
    <span class="nf-brand">NationForge</span>
</header>

<div class="wrap">
    <div class="icon-circle">
        <svg width="36" height="36" fill="none" stroke="#0ab39c" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </div>

    <h1>{{ __('events.reg_success') }}</h1>
    <p>{{ __('events.reg_success_msg') }}</p>
    <p class="event-name">{{ $event->title }}</p>

    <div class="card">
        <div class="meta-row">
            <svg class="meta-icon" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span>{{ $event->starts_at->format('Y. F j., l · H:i') }}</span>
        </div>

        @if($event->is_online)
        <div class="meta-row">
            <svg class="meta-icon" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.277A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
            </svg>
            <span>{{ __('events.is_online') }}</span>
        </div>
        @elseif($event->venue_name || $event->city)
        <div class="meta-row">
            <svg class="meta-icon" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/>
            </svg>
            <span>{{ implode(', ', array_filter([$event->venue_name, $event->city])) }}</span>
        </div>
        @endif
    </div>

    @if($ticketToken ?? null)
    <a href="{{ route('events.ticket', $ticketToken) }}"
       style="display:inline-block;margin-top:28px;padding:11px 28px;background:#0ab39c;color:#fff;border-radius:8px;text-decoration:none;font-weight:700;font-size:0.875rem">
        🎟 {{ __('events.view_ticket') }}
    </a>
    @endif
    <a href="{{ route('events.public', $event->slug) }}" class="btn-back">{{ __('events.back_to_event') }}</a>
</div>

</body>
</html>
