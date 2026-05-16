<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ __('emails.invitation.subject', ['app' => config('app.name')]) }}</title>
<style>
  body { margin:0; padding:0; background:#f3f4f6; font-family:'Helvetica Neue',Arial,sans-serif; color:#1f2937; }
  .wrapper { max-width:600px; margin:32px auto; background:#fff; border-radius:10px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,0.07); }
  .header { background:linear-gradient(135deg,#405189 0%,#2c3a73 100%); padding:32px 40px; text-align:center; }
  .header-logo { color:#fff; font-size:1.4rem; font-weight:700; letter-spacing:0.04em; }
  .header-sub { color:rgba(255,255,255,0.75); font-size:0.85rem; margin-top:6px; }
  .body { padding:36px 40px; font-size:0.95rem; line-height:1.65; }
  .body h1 { color:#0b1437; font-size:1.2rem; margin:0 0 14px; }
  .body p { margin:0 0 14px; color:#374151; }
  .btn-wrap { text-align:center; margin:28px 0; }
  .btn { display:inline-block; padding:13px 32px; background:#405189; color:#fff !important; border-radius:8px; text-decoration:none; font-weight:600; font-size:0.95rem; }
  .info-box { background:#f8f9fb; border:1px solid #e9ebee; border-radius:8px; padding:16px 20px; margin:20px 0; font-size:0.85rem; color:#495057; }
  .info-row { display:flex; gap:10px; padding:4px 0; }
  .info-label { color:#6c757d; min-width:80px; font-weight:500; }
  .url-box { word-break:break-all; background:#f1f5f9; border-radius:6px; padding:10px 14px; font-size:0.78rem; color:#64748b; font-family:monospace; margin-top:16px; }
  .footer { background:#f8f9fa; border-top:1px solid #e9ecef; padding:18px 40px; text-align:center; font-size:0.78rem; color:#6c757d; }
</style>
</head>
<body>
<div class="wrapper">
  <div class="header">
    <div class="header-logo">{{ config('app.name') }}</div>
    <div class="header-sub">{{ __('emails.invitation.header_sub') }}</div>
  </div>
  <div class="body">
    <h1>{{ __('emails.invitation.heading') }}</h1>
    <p>{{ __('emails.invitation.intro', ['inviter' => $invitation->invited_by_name ?? config('app.name'), 'app' => config('app.name')]) }}</p>

    <div class="info-box">
      <div class="info-row">
        <span class="info-label">{{ __('emails.invitation.email_label') }}</span>
        <span>{{ $invitation->email }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">{{ __('emails.invitation.role_label') }}</span>
        <span>{{ ucfirst($invitation->role) }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">{{ __('emails.invitation.expires_label') }}</span>
        <span>{{ $invitation->expires_at->format('Y. m. d.') }}</span>
      </div>
    </div>

    <div class="btn-wrap">
      <a href="{{ $invitation->registrationUrl() }}" class="btn">{{ __('emails.invitation.cta') }}</a>
    </div>

    <p style="font-size:0.85rem;color:#6c757d">{{ __('emails.invitation.url_hint') }}</p>
    <div class="url-box">{{ $invitation->registrationUrl() }}</div>
  </div>
  <div class="footer">
    {{ __('emails.invitation.footer', ['app' => config('app.name')]) }}
  </div>
</div>
</body>
</html>
