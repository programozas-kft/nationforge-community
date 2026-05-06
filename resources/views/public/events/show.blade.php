<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->title }} – NationForge</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f3f4f8; color: #212529; min-height: 100vh; }

        .nf-header {
            background: #0b1437;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .nf-logo {
            width: 32px; height: 32px;
            background: #1a3a6b;
            border: 2px solid #4d7efa;
            border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; color: #fff; font-size: 0.9rem;
        }
        .nf-brand { color: #fff; font-weight: 700; font-size: 1rem; }

        .page-wrap {
            max-width: 920px;
            margin: 40px auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 28px;
            align-items: start;
        }

        @media (max-width: 700px) {
            .page-wrap { grid-template-columns: 1fr; margin: 20px auto; }
        }

        .event-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #e9ebec;
            overflow: hidden;
        }
        .event-cover {
            width: 100%; height: 220px;
            object-fit: cover;
            background: linear-gradient(135deg, #0b1437 0%, #1a3a6b 100%);
            display: flex; align-items: center; justify-content: center;
        }
        .event-cover-placeholder {
            width: 100%; height: 220px;
            background: linear-gradient(135deg, #0b1437 0%, #1a3a6b 100%);
            display: flex; align-items: center; justify-content: center;
        }
        .event-body { padding: 28px; }
        .event-type {
            display: inline-block;
            font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em;
            color: #405189; background: rgba(64,81,137,0.1);
            padding: 3px 10px; border-radius: 4px; margin-bottom: 12px;
        }
        .event-title { font-size: 1.6rem; font-weight: 800; color: #0b1437; line-height: 1.25; margin-bottom: 20px; }
        .event-meta { display: flex; flex-direction: column; gap: 10px; margin-bottom: 24px; }
        .event-meta-row { display: flex; align-items: flex-start; gap: 10px; font-size: 0.875rem; color: #495057; }
        .event-meta-icon { width: 18px; flex-shrink: 0; margin-top: 1px; color: #405189; }
        .event-desc { font-size: 0.9rem; line-height: 1.7; color: #495057; border-top: 1px solid #e9ebec; padding-top: 20px; }

        .capacity-bar-wrap { margin: 20px 0 0; }
        .capacity-label { font-size: 0.78rem; color: #6c757d; margin-bottom: 6px; display: flex; justify-content: space-between; }
        .capacity-bar { height: 6px; background: #e9ebec; border-radius: 3px; overflow: hidden; }
        .capacity-bar-fill { height: 100%; border-radius: 3px; background: #0ab39c; transition: width .3s; }
        .capacity-bar-fill.warn { background: #f7b84b; }
        .capacity-bar-fill.full { background: #f06548; }

        .form-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #e9ebec;
            padding: 28px;
            position: sticky;
            top: 24px;
        }
        .form-title { font-size: 1rem; font-weight: 700; color: #0b1437; margin-bottom: 4px; }
        .form-sub { font-size: 0.78rem; color: #6c757d; margin-bottom: 20px; }
        .form-group { margin-bottom: 14px; }
        .form-label { display: block; font-size: 0.78rem; font-weight: 600; color: #495057; margin-bottom: 5px; }
        .form-input {
            width: 100%; padding: 9px 12px;
            border: 1px solid #e9ebec; border-radius: 7px;
            font-size: 0.875rem; color: #212529;
            outline: none; transition: border-color .15s;
        }
        .form-input:focus { border-color: #405189; box-shadow: 0 0 0 3px rgba(64,81,137,0.1); }
        textarea.form-input { resize: none; }
        .form-error { font-size: 0.75rem; color: #f06548; margin-top: 4px; }
        .btn-submit {
            width: 100%; padding: 12px;
            background: #405189; color: #fff;
            border: none; border-radius: 8px;
            font-size: 0.9rem; font-weight: 700;
            cursor: pointer; transition: background .15s;
            margin-top: 6px;
        }
        .btn-submit:hover { background: #364474; }
        .btn-submit:disabled { background: #adb5bd; cursor: not-allowed; }
        .full-badge {
            text-align: center; padding: 14px;
            background: rgba(240,101,72,0.07); border-radius: 8px;
            color: #f06548; font-weight: 600; font-size: 0.875rem;
        }
        .privacy-note { font-size: 0.7rem; color: #adb5bd; text-align: center; margin-top: 12px; line-height: 1.5; }
    </style>
</head>
<body>

<header class="nf-header">
    <div class="nf-logo">N</div>
    <span class="nf-brand">NationForge</span>
</header>

<div class="page-wrap">

    {{-- Bal oldal: esemény részletek --}}
    <div class="event-card">
        @if($event->cover_image)
            <img src="{{ Storage::url($event->cover_image) }}" alt="{{ $event->title }}" class="event-cover">
        @else
            <div class="event-cover-placeholder">
                <svg width="48" height="48" fill="none" stroke="rgba(255,255,255,0.3)" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        @endif

        <div class="event-body">
            <div class="event-type">{{ $event->type }}</div>
            <h1 class="event-title">{{ $event->title }}</h1>

            <div class="event-meta">
                <div class="event-meta-row">
                    <svg class="event-meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <div>
                        <strong>{{ $event->starts_at->format('Y. F j., l') }}</strong>
                        · {{ $event->starts_at->format('H:i') }}
                        @if($event->ends_at) – {{ $event->ends_at->format('H:i') }} @endif
                    </div>
                </div>

                @if($event->is_online)
                <div class="event-meta-row">
                    <svg class="event-meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.277A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
                    </svg>
                    <div>Online esemény @if($event->online_url) · <a href="{{ $event->online_url }}" target="_blank" style="color:#405189">Csatlakozási link</a>@endif</div>
                </div>
                @elseif($event->venue_name || $event->city)
                <div class="event-meta-row">
                    <svg class="event-meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <div>
                        @if($event->venue_name)<strong>{{ $event->venue_name }}</strong>@endif
                        @if($event->address) · {{ $event->address }}@endif
                        @if($event->city) · {{ $event->city }}@endif
                    </div>
                </div>
                @endif

                @if($event->ticket_price > 0)
                <div class="event-meta-row">
                    <svg class="event-meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                    </svg>
                    <div>Részvételi díj: <strong>{{ number_format($event->ticket_price, 0, ',', ' ') }} Ft</strong></div>
                </div>
                @else
                <div class="event-meta-row">
                    <svg class="event-meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>Ingyenes esemény</div>
                </div>
                @endif

                @if($event->capacity)
                <div class="event-meta-row">
                    <svg class="event-meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <div>{{ $registrationCount }} / {{ $event->capacity }} regisztrált</div>
                </div>
                @php
                    $pct = min(100, round($registrationCount / $event->capacity * 100));
                    $barClass = $pct >= 100 ? 'full' : ($pct >= 75 ? 'warn' : '');
                @endphp
                <div class="capacity-bar-wrap">
                    <div class="capacity-label">
                        <span>Beteltség</span>
                        <span>{{ $pct }}%</span>
                    </div>
                    <div class="capacity-bar">
                        <div class="capacity-bar-fill {{ $barClass }}" style="width:{{ $pct }}%"></div>
                    </div>
                </div>
                @endif
            </div>

            @if($event->description)
            <div class="event-desc">{{ $event->description }}</div>
            @endif
        </div>
    </div>

    {{-- Jobb oldal: regisztrációs form --}}
    <div class="form-card">
        @if($isFull)
            <p class="form-title">Regisztráció</p>
            <div class="full-badge" style="margin-top:12px">
                Ez az esemény betelt.<br>Nincs több szabad hely.
            </div>
        @else
            <p class="form-title">Regisztrálj az eseményre</p>
            <p class="form-sub">A részvételi szándékodat az alábbi űrlapon jelezheted.</p>

            @if($errors->any())
                <div style="background:rgba(240,101,72,0.08);border:1px solid #f06548;border-radius:7px;padding:10px 14px;margin-bottom:14px;font-size:0.8rem;color:#f06548">
                    @foreach($errors->all() as $e) <div>{{ $e }}</div> @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('events.register', $event->slug) }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Teljes név <span style="color:#f06548">*</span></label>
                    <input type="text" name="name" class="form-input" value="{{ old('name') }}" required placeholder="pl. Kovács János">
                </div>
                <div class="form-group">
                    <label class="form-label">E-mail cím <span style="color:#f06548">*</span></label>
                    <input type="email" name="email" class="form-input" value="{{ old('email') }}" required placeholder="pl. kovacs@email.hu">
                </div>
                <div class="form-group">
                    <label class="form-label">Telefonszám</label>
                    <input type="tel" name="phone" class="form-input" value="{{ old('phone') }}" placeholder="+36 30 123 4567">
                </div>
                <div class="form-group">
                    <label class="form-label">Kísérők száma</label>
                    <input type="number" name="guests" class="form-input" value="{{ old('guests', 0) }}" min="0" max="10">
                </div>
                <div class="form-group">
                    <label class="form-label">Megjegyzés</label>
                    <textarea name="notes" class="form-input" rows="3" placeholder="Bármilyen kérdés vagy megjegyzés...">{{ old('notes') }}</textarea>
                </div>
                <button type="submit" class="btn-submit">Regisztráció elküldése</button>
            </form>
            <p class="privacy-note">Az adataid kizárólag az esemény szervezéséhez kerülnek felhasználásra.</p>
        @endif
    </div>

</div>

</body>
</html>
