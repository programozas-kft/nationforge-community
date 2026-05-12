@php
    $eventUrl = route('events.public', $event->slug);
    $ticketUrl = route('events.ticket', $registration->token);
    $location = $event->is_online
        ? __('emails.event_registration.online_event')
        : trim(implode(', ', array_filter([$event->venue_name, $event->address, $event->city])));
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ __('emails.waitlist.promotion_subject', ['event' => $event->title]) }}</title>
<style>
  body { margin:0; padding:0; background:#f3f4f6; font-family:'Helvetica Neue',Arial,sans-serif; color:#1f2937; }
  .wrapper { max-width:620px; margin:32px auto; background:#fff; border-radius:10px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,0.07); }
  .header { background:linear-gradient(135deg,#0ab39c 0%,#078a78 100%); padding:32px 40px; text-align:center; }
  .header-logo { color:#fff; font-size:1.4rem; font-weight:700; letter-spacing:0.04em; }
  .header-sub { color:rgba(255,255,255,0.9); font-size:0.85rem; margin-top:8px; }
  .body { padding:36px 40px; font-size:0.95rem; line-height:1.65; }
  .greeting { font-size:1rem; color:#1e293b; font-weight:600; margin:0 0 14px; }
  .event-card { background:#f8f9fb; border:1px solid #e9ebee; border-radius:10px; padding:20px 22px; margin:22px 0 26px; }
  .event-title { font-size:1.05rem; font-weight:700; color:#0b1437; margin:0 0 12px; }
  .meta-row { display:flex; align-items:flex-start; gap:10px; font-size:0.88rem; color:#495057; padding:6px 0; }
  .meta-label { color:#6c757d; font-weight:500; min-width:78px; flex-shrink:0; }
  .meta-value { color:#1e293b; font-weight:500; }
  .success-badge { background:rgba(10,179,156,0.1); border:1px solid #0ab39c; border-radius:8px; padding:14px 18px; margin:20px 0; font-size:0.92rem; color:#065a50; font-weight:600; }
  .btn { display:inline-block; padding:11px 24px; background:#0ab39c; color:#fff !important; border-radius:8px; text-decoration:none; font-weight:600; font-size:0.9rem; margin-top:8px; margin-right:8px; }
  .btn-outline { display:inline-block; padding:10px 20px; background:transparent; color:#405189 !important; border:1px solid #405189; border-radius:8px; text-decoration:none; font-weight:600; font-size:0.85rem; margin-top:8px; }
  .footer { background:#f8f9fa; border-top:1px solid #e9ecef; padding:18px 40px; text-align:center; font-size:0.78rem; color:#6c757d; }
</style>
</head>
<body>
<div class="wrapper">
  <div class="header">
    <span class="header-logo">{{ config('app.name', 'NationForge') }}</span>
    <div class="header-sub">{{ __('emails.waitlist.promotion_header_sub') }}</div>
  </div>
  <div class="body">
    <p class="greeting">{{ __('emails.event_registration.greeting', ['name' => $registration->name]) }}</p>

    <div class="success-badge">
        ✅ {{ __('emails.waitlist.promotion_intro', ['event' => $event->title]) }}
    </div>

    <p>{{ __('emails.waitlist.promotion_body') }}</p>

    <div class="event-card">
      <div class="event-title">{{ $event->title }}</div>
      <div class="meta-row">
        <span class="meta-label">{{ __('emails.event_registration.when') }}</span>
        <span class="meta-value">{{ $event->starts_at->isoFormat('LLLL') }}</span>
      </div>
      @if($location)
      <div class="meta-row">
        <span class="meta-label">{{ __('emails.event_registration.where') }}</span>
        <span class="meta-value">{{ $location }}</span>
      </div>
      @endif
      @if($event->ticket_price > 0)
      <div class="meta-row">
        <span class="meta-label">{{ __('emails.event_registration.fee') }}</span>
        <span class="meta-value">{{ number_format($event->ticket_price, 0, ',', ' ') }} Ft</span>
      </div>
      @endif
    </div>

    <p>
      <a href="{{ $ticketUrl }}" class="btn">🎟 {{ __('events.view_ticket') }}</a>
      <a href="{{ $eventUrl }}" class="btn-outline">{{ __('emails.event_registration.view_event') }}</a>
    </p>
  </div>
  <div class="footer">
    &copy; {{ date('Y') }} {{ config('app.name') }}<br>
    {{ __('emails.event_registration.footer_note') }}
  </div>
</div>
</body>
</html>
