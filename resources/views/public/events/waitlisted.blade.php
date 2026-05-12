<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('events.waitlist_confirmed_title') }} – {{ $event->title }}</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f3f4f8; color: #212529; min-height: 100vh; }
        .nf-header { background: #0b1437; padding: 14px 24px; display: flex; align-items: center; gap: 10px; }
        .nf-logo { width: 32px; height: 32px; background: #1a3a6b; border: 2px solid #4d7efa; border-radius: 7px; display: flex; align-items: center; justify-content: center; font-weight: 800; color: #fff; font-size: 0.9rem; }
        .nf-brand { color: #fff; font-weight: 700; font-size: 1rem; }
        .wrap { max-width: 520px; margin: 80px auto; padding: 0 20px; text-align: center; }
        .icon-circle { width: 72px; height: 72px; border-radius: 50%; background: rgba(247,184,75,0.12); display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; }
        h1 { font-size: 1.6rem; font-weight: 800; color: #0b1437; margin-bottom: 12px; }
        p { font-size: 0.95rem; color: #495057; line-height: 1.6; margin-bottom: 8px; }
        .event-name { font-weight: 700; color: #405189; }
        .card { background: #fff; border: 1px solid #e9ebec; border-radius: 12px; padding: 28px; margin-top: 28px; }
        .position-badge { font-size: 2rem; font-weight: 900; color: #f7b84b; margin-bottom: 4px; }
        .position-label { font-size: 0.8rem; color: #6c757d; text-transform: uppercase; letter-spacing: 0.06em; }
        .info-row { display: flex; align-items: center; gap: 10px; font-size: 0.875rem; color: #495057; padding: 8px 0; border-bottom: 1px solid #f3f4f8; text-align: left; }
        .info-row:last-child { border-bottom: none; }
        .info-icon { color: #f7b84b; flex-shrink: 0; }
        .btn-back { display: inline-block; margin-top: 28px; padding: 11px 28px; background: #405189; color: #fff; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 0.875rem; }
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
        <svg width="36" height="36" fill="none" stroke="#f7b84b" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </div>

    <h1>{{ __('events.waitlist_confirmed_title') }}</h1>
    <p>{{ __('events.waitlist_confirmed_msg') }}</p>
    <p class="event-name">{{ $event->title }}</p>

    <div class="card">
        @if($position)
        <div class="position-badge">#{{ $position }}</div>
        <div class="position-label">{{ __('events.waitlist_your_position') }}</div>
        <div style="height:1px;background:#f3f4f8;margin:16px 0"></div>
        @endif

        <div class="info-row">
            <svg class="info-icon" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <span>{{ __('events.waitlist_email_note') }}</span>
        </div>

        <div class="info-row">
            <svg class="info-icon" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span>{{ $event->starts_at->format('Y. F j., l · H:i') }}</span>
        </div>

        @if(!$event->is_online && ($event->venue_name || $event->city))
        <div class="info-row">
            <svg class="info-icon" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/>
            </svg>
            <span>{{ implode(', ', array_filter([$event->venue_name, $event->city])) }}</span>
        </div>
        @endif
    </div>

    <a href="{{ route('events.public', $event->slug) }}" class="btn-back">{{ __('events.back_to_event') }}</a>
</div>

</body>
</html>
