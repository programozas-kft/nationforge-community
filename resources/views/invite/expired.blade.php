<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('invite.expired_title') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: linear-gradient(135deg, #405189 0%, #2c3a73 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px; margin: 0; }
        .card { background: #fff; border-radius: 14px; box-shadow: 0 20px 60px rgba(0,0,0,0.2); width: 100%; max-width: 400px; padding: 40px 36px; text-align: center; }
        .icon { width: 56px; height: 56px; border-radius: 50%; background: rgba(240,101,72,0.1); display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; }
        h1 { font-size: 1.2rem; font-weight: 700; color: #0b1437; margin: 0 0 10px; }
        p { font-size: 0.875rem; color: #6c757d; margin: 0; line-height: 1.6; }
    </style>
</head>
<body>
<div class="card">
    <div class="icon">
        <svg width="26" height="26" fill="none" stroke="#f06548" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    </div>
    <h1>{{ $invitation->used_at ? __('invite.already_used') : __('invite.expired_heading') }}</h1>
    <p>{{ $invitation->used_at ? __('invite.already_used_text') : __('invite.expired_text') }}</p>
</div>
</body>
</html>
