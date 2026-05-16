<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('unsubscribe.page_title') }} – {{ $orgName }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background: #f3f4f6;
            color: #1f2937;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            max-width: 460px;
            width: 100%;
            overflow: hidden;
        }
        .card-header {
            background: linear-gradient(135deg, #405189 0%, #2c3a73 100%);
            padding: 28px 36px;
            text-align: center;
        }
        .org-name {
            color: #fff;
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: 0.03em;
        }
        .card-body { padding: 36px; text-align: center; }
        .icon {
            width: 64px; height: 64px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
            font-size: 1.8rem;
        }
        .icon-success { background: rgba(10,179,156,0.12); }
        .icon-info    { background: rgba(64,81,137,0.1); }
        .icon-warn    { background: rgba(245,158,11,0.1); }
        h2 { font-size: 1.2rem; font-weight: 700; color: #1e293b; margin-bottom: 10px; }
        .sub { font-size: .9rem; color: #6c757d; line-height: 1.6; }
        .email-chip {
            display: inline-block;
            margin-top: 10px;
            padding: 4px 14px;
            background: #f3f4f6;
            border-radius: 20px;
            font-size: .82rem;
            color: #495057;
            font-weight: 500;
        }
        .btn {
            display: inline-block;
            margin-top: 24px;
            padding: 12px 28px;
            border-radius: 8px;
            font-size: .9rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: opacity .15s;
        }
        .btn:hover { opacity: .88; }
        .btn-red    { background: #f06548; color: #fff; }
        .btn-green  { background: #0ab39c; color: #fff; }
        .btn-ghost  {
            background: none;
            color: #6c757d;
            border: 1px solid #dee2e6;
            font-size: .82rem;
            padding: 8px 18px;
            margin-top: 12px;
        }
        form { margin: 0; }
        .divider { border: none; border-top: 1px solid #f0f0f5; margin: 28px 0; }
    </style>
</head>
<body>
<div class="card">
    <div class="card-header">
        <span class="org-name">{{ $orgName }}</span>
    </div>
    <div class="card-body">

        @if(session('unsubscribed'))
            {{-- ✓ Just unsubscribed --}}
            <div class="icon icon-success">✅</div>
            <h2>{{ __('unsubscribe.done_title') }}</h2>
            <p class="sub">{{ __('unsubscribe.done_body') }}</p>
            <span class="email-chip">{{ $person->email }}</span>

            <hr class="divider">
            <p class="sub" style="font-size:.82rem">{{ __('unsubscribe.regret') }}</p>
            <form method="POST" action="{{ route('unsubscribe.resubscribe', $token) }}">
                @csrf
                <button type="submit" class="btn btn-ghost">{{ __('unsubscribe.resubscribe_btn') }}</button>
            </form>

        @elseif(session('resubscribed'))
            {{-- ✓ Re-subscribed --}}
            <div class="icon icon-success">🎉</div>
            <h2>{{ __('unsubscribe.resub_done_title') }}</h2>
            <p class="sub">{{ __('unsubscribe.resub_done_body') }}</p>
            <span class="email-chip">{{ $person->email }}</span>

        @elseif(!$person->is_subscribed)
            {{-- Already unsubscribed --}}
            <div class="icon icon-info">📭</div>
            <h2>{{ __('unsubscribe.already_title') }}</h2>
            <p class="sub">{{ __('unsubscribe.already_body') }}</p>
            <span class="email-chip">{{ $person->email }}</span>

            <hr class="divider">
            <p class="sub" style="font-size:.82rem">{{ __('unsubscribe.regret') }}</p>
            <form method="POST" action="{{ route('unsubscribe.resubscribe', $token) }}">
                @csrf
                <button type="submit" class="btn btn-green" style="margin-top:16px">{{ __('unsubscribe.resubscribe_btn') }}</button>
            </form>

        @else
            {{-- Confirm unsubscribe --}}
            <div class="icon icon-warn">📧</div>
            <h2>{{ __('unsubscribe.confirm_title') }}</h2>
            <p class="sub">{{ __('unsubscribe.confirm_body', ['org' => $orgName]) }}</p>
            <span class="email-chip">{{ $person->email }}</span>

            <form method="POST" action="{{ route('unsubscribe.confirm', $token) }}">
                @csrf
                <button type="submit" class="btn btn-red">{{ __('unsubscribe.confirm_btn') }}</button>
            </form>
            <br>
            <a href="{{ url('/') }}" class="btn btn-ghost">{{ __('unsubscribe.cancel_btn') }}</a>
        @endif

    </div>
</div>
</body>
</html>
