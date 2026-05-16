<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('invite.page_title', ['app' => config('app.name')]) }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: linear-gradient(135deg, #405189 0%, #2c3a73 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px; margin: 0; }
        .card { background: #fff; border-radius: 14px; box-shadow: 0 20px 60px rgba(0,0,0,0.2); width: 100%; max-width: 420px; overflow: hidden; }
        .card-header { padding: 28px 32px 20px; border-bottom: 1px solid #f0f1f6; text-align: center; }
        .logo { font-size: 1.2rem; font-weight: 700; color: #405189; letter-spacing: 0.02em; }
        .badge { display: inline-block; margin-top: 10px; background: rgba(64,81,137,0.1); color: #405189; font-size: 0.75rem; font-weight: 600; padding: 3px 12px; border-radius: 20px; }
        .card-body { padding: 28px 32px; }
        h1 { font-size: 1.25rem; font-weight: 700; color: #0b1437; margin: 0 0 6px; }
        .subtitle { font-size: 0.875rem; color: #6c757d; margin: 0 0 24px; }
        .email-chip { display: inline-flex; align-items: center; gap: 6px; background: #f3f4f9; border-radius: 6px; padding: 6px 12px; font-size: 0.82rem; color: #405189; font-weight: 500; margin-bottom: 20px; }
        label { display: block; font-size: 0.8125rem; font-weight: 500; color: #495057; margin-bottom: 5px; }
        input[type=text], input[type=password] { display: block; width: 100%; padding: 9px 12px; border: 1.5px solid #ced4da; border-radius: 6px; font-size: 0.875rem; color: #343a40; outline: none; transition: border-color 0.2s, box-shadow 0.2s; }
        input:focus { border-color: #405189; box-shadow: 0 0 0 3px rgba(64,81,137,0.12); }
        .field { margin-bottom: 16px; }
        .error-msg { font-size: 0.72rem; color: #dc2626; margin-top: 4px; }
        .pw-wrap { position: relative; }
        .pw-toggle { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #adb5bd; padding: 0; line-height: 0; }
        .btn-submit { display: block; width: 100%; padding: 11px; background: #405189; color: #fff; border: none; border-radius: 7px; font-size: 0.9rem; font-weight: 600; cursor: pointer; transition: background 0.2s; margin-top: 6px; }
        .btn-submit:hover { background: #364476; }
        .card-footer { padding: 16px 32px; background: #f8f9fa; border-top: 1px solid #f0f1f6; text-align: center; font-size: 0.75rem; color: #adb5bd; }
        .alert-error { background: #fef2f2; border: 1px solid #fecaca; border-radius: 6px; padding: 10px 14px; font-size: 0.82rem; color: #dc2626; margin-bottom: 16px; }
    </style>
</head>
<body>
<div class="card">
    <div class="card-header">
        <div class="logo">{{ config('app.name') }}</div>
        <div class="badge">{{ __('invite.badge') }}</div>
    </div>
    <div class="card-body">
        <h1>{{ __('invite.heading') }}</h1>
        <p class="subtitle">{{ __('invite.subheading') }}</p>

        <div class="email-chip">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            {{ $invitation->email }}
        </div>

        @if($errors->any())
        <div class="alert-error">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('invite.register.submit', $invitation->token) }}">
            @csrf
            <div class="field">
                <label>{{ __('invite.name') }} <span style="color:#f06548">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
            </div>
            <div class="field">
                <label>{{ __('invite.password') }} <span style="color:#f06548">*</span></label>
                <div class="pw-wrap">
                    <input type="password" name="password" id="pw1" required autocomplete="new-password" style="padding-right:38px">
                    <button type="button" class="pw-toggle" onclick="togglePwd('pw1',this)">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </button>
                </div>
                <p style="font-size:0.72rem;color:#adb5bd;margin:4px 0 0">{{ __('invite.password_hint') }}</p>
            </div>
            <div class="field">
                <label>{{ __('invite.password_confirm') }} <span style="color:#f06548">*</span></label>
                <div class="pw-wrap">
                    <input type="password" name="password_confirmation" id="pw2" required autocomplete="new-password" style="padding-right:38px">
                    <button type="button" class="pw-toggle" onclick="togglePwd('pw2',this)">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </button>
                </div>
            </div>
            <button type="submit" class="btn-submit">{{ __('invite.submit') }}</button>
        </form>
    </div>
    <div class="card-footer">
        {{ __('invite.footer', ['expires' => $invitation->expires_at->format('Y. m. d.')]) }}
    </div>
</div>
<script>
function togglePwd(id, btn) {
    const inp = document.getElementById(id);
    inp.type = inp.type === 'password' ? 'text' : 'password';
}
</script>
</body>
</html>
