<!DOCTYPE html>
<html lang="hu">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $step->subject }}</title>
<style>
  body { margin:0; padding:0; background:#f3f4f6; font-family:'Helvetica Neue',Arial,sans-serif; color:#1f2937; }
  .wrapper { max-width:620px; margin:32px auto; background:#fff; border-radius:10px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,0.07); }
  .header { background:linear-gradient(135deg,#405189 0%,#2c3a73 100%); padding:32px 40px; text-align:center; }
  .header-logo { color:#fff; font-size:1.4rem; font-weight:700; letter-spacing:0.04em; text-decoration:none; }
  .body { padding:36px 40px; font-size:0.95rem; line-height:1.7; }
  .body h1,.body h2,.body h3 { color:#1e293b; margin-top:1.5em; margin-bottom:0.4em; }
  .body p { margin:0 0 1em; }
  .body ul { padding-left:1.4em; margin-bottom:1em; }
  .body strong { color:#1e293b; }
  .body a { color:#405189; }
  .footer { background:#f8f9fa; border-top:1px solid #e9ecef; padding:20px 40px; text-align:center; font-size:0.78rem; color:#6c757d; }
  .footer a { color:#405189; }
</style>
</head>
<body>
<div class="wrapper">
  <div class="header">
    <span class="header-logo">{{ config('app.name') }}</span>
  </div>
  <div class="body">
    {!! $step->body_html !!}
  </div>
  <div class="footer">
    &copy; {{ date('Y') }} {{ config('app.name') }}<br>
    Ez az email a <a href="{{ config('app.url') }}">{{ config('app.url') }}</a> rendszerből érkezett.<br><br>
    <a href="{{ route('unsubscribe', $person->unsubscribe_token) }}" style="color:#adb5bd">Leiratkozás / Unsubscribe</a>
  </div>
</div>
</body>
</html>
