<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('events.ticket_title') }} – {{ $registration->event->title }}</title>
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
        .wrap { max-width: 440px; margin: 48px auto; padding: 0 20px; }
        .ticket {
            background: #fff; border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        .ticket-header {
            background: linear-gradient(135deg, #405189, #0b1437);
            padding: 24px; color: #fff; text-align: center;
        }
        .ticket-header h1 { font-size: 1.15rem; font-weight: 800; margin-bottom: 4px; }
        .ticket-header p { font-size: 0.82rem; opacity: 0.75; }
        .ticket-body { padding: 24px; text-align: center; }
        .qr-wrap {
            display: inline-block;
            padding: 12px; border: 2px solid #e9ebec; border-radius: 12px;
            background: #fff; margin-bottom: 20px;
        }
        .attendee-name {
            font-size: 1.2rem; font-weight: 800; color: #0b1437; margin-bottom: 4px;
        }
        .attendee-email { font-size: 0.82rem; color: #6c757d; margin-bottom: 20px; }
        .meta-row {
            display: flex; align-items: center; gap: 10px;
            font-size: 0.85rem; color: #495057; padding: 9px 0;
            border-bottom: 1px solid #f3f4f8; text-align: left;
        }
        .meta-row:last-child { border-bottom: none; }
        .meta-icon { color: #405189; flex-shrink: 0; }
        .ticket-footer {
            background: #f8f9fa; border-top: 2px dashed #e9ebec;
            padding: 16px 24px; text-align: center;
        }
        .ticket-footer p { font-size: 0.75rem; color: #adb5bd; line-height: 1.5; }
        @if($registration->checked_in_at)
        .checked-banner {
            background: rgba(10,179,156,0.1); border: 1px solid #0ab39c;
            border-radius: 8px; padding: 10px 16px; margin-bottom: 16px;
            font-size: 0.82rem; color: #0ab39c; font-weight: 600;
            display: flex; align-items: center; gap: 8px; justify-content: center;
        }
        @endif
        .btn-back {
            display: inline-block; margin-top: 20px;
            padding: 10px 24px; background: #405189; color: #fff;
            border-radius: 8px; text-decoration: none;
            font-weight: 700; font-size: 0.85rem;
        }
        .btn-back:hover { background: #364474; }
        @media print {
            body { background: #fff; }
            .nf-header, .btn-back { display: none; }
            .ticket { box-shadow: none; border: 1px solid #dee2e6; }
        }
    </style>
</head>
<body>

<header class="nf-header">
    <div class="nf-logo">N</div>
    <span class="nf-brand">NationForge</span>
</header>

<div class="wrap">
    <div class="ticket">
        <div class="ticket-header">
            <h1>{{ $registration->event->title }}</h1>
            <p>{{ $registration->event->starts_at->format('Y. F j., l · H:i') }}</p>
        </div>
        <div class="ticket-body">

            @if($registration->checked_in_at)
            <div class="checked-banner">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ __('events.ticket_checked_in') }}: {{ $registration->checked_in_at->format('Y. m. d. H:i') }}
            </div>
            @endif

            <div class="qr-wrap">
                <canvas id="qr-canvas"></canvas>
            </div>

            <div class="attendee-name">{{ $registration->name }}</div>
            <div class="attendee-email">{{ $registration->email }}</div>

            <div style="text-align:left">
                <div class="meta-row">
                    <svg class="meta-icon" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>{{ $registration->event->starts_at->format('Y. m. d. H:i') }}</span>
                </div>

                @if($registration->event->is_online)
                <div class="meta-row">
                    <svg class="meta-icon" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.277A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
                    </svg>
                    <span>{{ __('events.is_online') }}</span>
                </div>
                @elseif($registration->event->venue_name || $registration->event->city)
                <div class="meta-row">
                    <svg class="meta-icon" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/>
                    </svg>
                    <span>{{ implode(', ', array_filter([$registration->event->venue_name, $registration->event->city])) }}</span>
                </div>
                @endif

                @if($registration->guests > 0)
                <div class="meta-row">
                    <svg class="meta-icon" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>+{{ $registration->guests }} {{ __('events.col_guests') }}</span>
                </div>
                @endif
            </div>
        </div>
        <div class="ticket-footer">
            <p>{{ __('events.ticket_footer') }}</p>
        </div>
    </div>

    <div style="text-align:center">
        <a href="{{ route('events.public', $registration->event->slug) }}" class="btn-back">{{ __('events.back_to_event') }}</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.4/build/qrcode.min.js"></script>
<script>
QRCode.toCanvas(document.getElementById('qr-canvas'), '{{ $registration->token }}', {
    width: 200,
    margin: 1,
    color: { dark: '#0b1437', light: '#ffffff' }
}, function(error) {
    if (error) console.error(error);
});
</script>

</body>
</html>
