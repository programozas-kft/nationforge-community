<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ __('emails.report.subject', ['app' => $orgName]) }}</title>
<style>
  body { margin:0; padding:0; background:#f3f3f9; font-family:'Segoe UI',Arial,sans-serif; color:#343a40; }
  .wrap { max-width:600px; margin:32px auto; background:#fff; border-radius:10px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,0.07); }
  .header { background:linear-gradient(135deg,#405189,#7a5af8); padding:32px 40px; text-align:center; }
  .header h1 { margin:0; color:#fff; font-size:1.5rem; font-weight:700; }
  .header p  { margin:6px 0 0; color:rgba(255,255,255,0.8); font-size:0.9rem; }
  .body { padding:32px 40px; }
  .stats-grid { display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:28px; }
  .stat-card { background:#f8f9fa; border-radius:8px; padding:16px; text-align:center; border:1px solid #e9ebec; }
  .stat-card .val { font-size:1.6rem; font-weight:700; color:#343a40; }
  .stat-card .lbl { font-size:0.72rem; color:#6c757d; margin-top:2px; text-transform:uppercase; letter-spacing:0.04em; }
  .stat-card .sub { font-size:0.75rem; margin-top:4px; }
  .section-title { font-size:0.8rem; font-weight:600; text-transform:uppercase; letter-spacing:0.06em; color:#405189; margin:0 0 10px; }
  .contact-row { display:flex; align-items:center; gap:12px; padding:9px 0; border-bottom:1px solid #f3f3f9; }
  .avatar { width:32px; height:32px; border-radius:50%; background:linear-gradient(135deg,#405189,#7a5af8); display:flex; align-items:center; justify-content:center; color:#fff; font-size:0.75rem; font-weight:700; flex-shrink:0; }
  .contact-name { font-size:0.85rem; font-weight:500; color:#343a40; }
  .contact-email { font-size:0.75rem; color:#adb5bd; }
  .event-row { display:flex; align-items:center; gap:12px; padding:9px 0; border-bottom:1px solid #f3f3f9; }
  .event-date { width:36px; height:36px; border-radius:7px; background:linear-gradient(135deg,#0ab39c,#0a8c7a); display:flex; flex-direction:column; align-items:center; justify-content:center; color:#fff; font-size:0.7rem; font-weight:700; flex-shrink:0; }
  .event-title { font-size:0.85rem; font-weight:500; color:#343a40; }
  .event-meta  { font-size:0.75rem; color:#adb5bd; }
  .footer { padding:20px 40px; background:#f8f9fa; border-top:1px solid #e9ebec; text-align:center; font-size:0.75rem; color:#adb5bd; }
  .section-block { margin-bottom:28px; }
  .badge { display:inline-block; padding:2px 8px; border-radius:4px; font-size:0.7rem; font-weight:600; }
  .badge-blue { background:#e8ecf7; color:#405189; }
  .badge-green { background:#e3f5f2; color:#0ab39c; }
</style>
</head>
<body>
<div class="wrap">

  {{-- Header --}}
  <div class="header">
    <h1>{{ $orgName }}</h1>
    <p>{{ __('emails.report.heading') }}</p>
  </div>

  <div class="body">

    {{-- Stats --}}
    <div class="stats-grid">
      <div class="stat-card">
        <div class="val">{{ number_format($stats['people']) }}</div>
        <div class="lbl">{{ __('emails.report.contacts') }}</div>
        @if($stats['new_people'] > 0)
        <div class="sub" style="color:#0ab39c">+{{ $stats['new_people'] }} {{ __('emails.report.new_this_month') }}</div>
        @endif
      </div>
      <div class="stat-card">
        <div class="val">{{ $stats['events'] }}</div>
        <div class="lbl">{{ __('emails.report.events') }}</div>
      </div>
      <div class="stat-card">
        <div class="val">{{ number_format($stats['donations'], 0, ',', ' ') }}</div>
        <div class="lbl">{{ __('emails.report.donations') }}</div>
      </div>
      <div class="stat-card">
        <div class="val">{{ number_format($stats['subscribed']) }}</div>
        <div class="lbl">{{ __('emails.report.subscribed') }}</div>
      </div>
    </div>

    {{-- Recent contacts --}}
    @if($stats['recent_people']->isNotEmpty())
    <div class="section-block">
      <p class="section-title">{{ __('emails.report.recent_contacts') }}</p>
      @foreach($stats['recent_people'] as $person)
      <div class="contact-row">
        <div class="avatar">{{ strtoupper(substr($person->first_name, 0, 1)) }}</div>
        <div>
          <div class="contact-name">{{ $person->last_name }} {{ $person->first_name }}</div>
          <div class="contact-email">{{ $person->email ?? '—' }}</div>
        </div>
        <div style="margin-left:auto">
          <span class="badge badge-blue">{{ $person->status }}</span>
        </div>
      </div>
      @endforeach
    </div>
    @endif

    {{-- Upcoming events --}}
    @if($stats['upcoming_events']->isNotEmpty())
    <div class="section-block">
      <p class="section-title">{{ __('emails.report.upcoming_events') }}</p>
      @foreach($stats['upcoming_events'] as $event)
      <div class="event-row">
        <div class="event-date">
          <span>{{ $event->starts_at->format('d') }}</span>
          <span>{{ $event->starts_at->format('M') }}</span>
        </div>
        <div>
          <div class="event-title">{{ $event->title }}</div>
          <div class="event-meta">{{ $event->starts_at->format('H:i') }} · {{ $event->city ?? ($event->is_online ? 'Online' : '—') }}</div>
        </div>
        <div style="margin-left:auto">
          <span class="badge badge-green">{{ $event->type }}</span>
        </div>
      </div>
      @endforeach
    </div>
    @endif

  </div>

  {{-- Footer --}}
  <div class="footer">
    {{ __('emails.report.generated') }}: {{ $stats['generated_at']->format('Y-m-d H:i') }}
    <br><br>
    {{ __('emails.report.footer', ['app' => $orgName]) }}
  </div>

</div>
</body>
</html>
