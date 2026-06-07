@extends('public.layouts.app')
@section('title', $cfg['hero_title'] ?: (\App\Models\Setting::get('brand_org_name', config('app.name'))))

@section('content')
@php $primary = \App\Models\Setting::get('brand_primary_color', '#405189'); @endphp

{{-- ══════════════════════════════════════════════════════════
     1. HERO – főüzenet + alcím + CTA gomb
══════════════════════════════════════════════════════════ --}}
@php
    $heroImage = $cfg['hero_image'] ?? '';
    $heroBg = $heroImage
        ? 'background:linear-gradient(180deg,rgba(0,0,0,0.35) 0%,rgba(0,0,0,0.18) 18%,rgba(0,0,0,0.44) 65%,rgba(0,0,0,0.58) 100%),url('.asset('storage/'.$heroImage).') center/cover no-repeat'
        : 'background:linear-gradient(135deg,'.$primary.' 0%,color-mix(in srgb,'.$primary.',black 35%) 100%)';
    $orgName = \App\Models\Setting::get('brand_org_name', config('app.name'));
    $logo    = \App\Models\Setting::get('brand_logo');
@endphp
<section style="{{ $heroBg }};min-height:100vh;display:flex;flex-direction:column;justify-content:flex-end;align-items:center;text-align:center;color:#fff;padding:0 24px calc(100vh / 6)">
    <div class="pub-container">
        @if($logo)
        <img src="{{ asset('storage/'.$logo) }}" alt="{{ $orgName }}"
             style="width:88px;height:88px;object-fit:contain;border-radius:18px;margin:0 auto 24px;display:block;background:rgba(255,255,255,0.12);padding:10px">
        @endif
        <h1 style="font-size:clamp(1.8rem,4vw,2.8rem);font-weight:800;line-height:1.15;margin-bottom:16px;letter-spacing:-0.02em">
            {{ $cfg['hero_title'] ?: $orgName }}
        </h1>
        @if($cfg['hero_subtitle'])
        <p style="font-size:1.15rem;opacity:0.88;max-width:580px;margin:0 auto 32px;line-height:1.6">
            {{ $cfg['hero_subtitle'] }}
        </p>
        @endif
        <div style="display:flex;gap:14px;justify-content:center;flex-wrap:wrap">
            @if($cfg['booking_url'])
            <a href="{{ $cfg['booking_url'] }}" target="_blank" rel="noopener"
               style="display:inline-flex;align-items:center;gap:8px;background:#fff;color:{{ $primary }};padding:14px 28px;border-radius:10px;font-weight:700;font-size:1rem;text-decoration:none;transition:opacity 0.15s"
               onmouseover="this.style.opacity='.88'" onmouseout="this.style.opacity='1'">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                {{ $cfg['booking_label'] }}
            </a>
            @endif
            <a href="#bemutatkozas" style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,0.15);color:#fff;padding:14px 28px;border-radius:10px;font-weight:600;font-size:1rem;text-decoration:none;border:1px solid rgba(255,255,255,0.3)">
                Tudj meg többet ↓
            </a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     2. BEMUTATKOZÁS
══════════════════════════════════════════════════════════ --}}
@if($cfg['intro'])
<section id="bemutatkozas" style="background:#fff;padding:64px 24px">
    <div class="pub-container" style="max-width:760px;text-align:center">
        <div style="width:48px;height:4px;background:{{ $primary }};border-radius:2px;margin:0 auto 24px"></div>
        <p style="font-size:1.12rem;color:#374151;line-height:1.8;white-space:pre-line">{{ $cfg['intro'] }}</p>
    </div>
</section>
@endif

{{-- ══════════════════════════════════════════════════════════
     3. KINEK SEGÍTESZ
══════════════════════════════════════════════════════════ --}}
@if($cfg['who_text'])
<section style="background:#f8f9ff;padding:64px 24px">
    <div class="pub-container">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:48px;align-items:center">
            <div>
                <div style="font-size:0.85rem;font-weight:700;color:{{ $primary }};letter-spacing:0.08em;text-transform:uppercase;margin-bottom:12px">Kinek szól?</div>
                <h2 style="font-size:1.7rem;font-weight:800;color:#1e2535;margin-bottom:16px;line-height:1.3">
                    {{ $cfg['who_title'] }}
                </h2>
                <p style="font-size:1rem;color:#4b5563;line-height:1.8;white-space:pre-line">{{ $cfg['who_text'] }}</p>
                @if($cfg['booking_url'])
                <a href="{{ $cfg['booking_url'] }}" target="_blank" rel="noopener"
                   style="display:inline-flex;align-items:center;gap:8px;background:{{ $primary }};color:#fff;padding:12px 24px;border-radius:9px;font-weight:600;font-size:0.92rem;text-decoration:none;margin-top:24px">
                    {{ $cfg['booking_label'] }} →
                </a>
                @endif
            </div>
            <div style="display:flex;flex-direction:column;gap:12px">
                @foreach(array_slice($cfg['problems'], 0, 6) as $problem)
                <div style="display:flex;align-items:center;gap:12px;background:#fff;padding:14px 18px;border-radius:10px;box-shadow:0 1px 4px rgba(0,0,0,0.07)">
                    <div style="width:32px;height:32px;background:color-mix(in srgb, {{ $primary }}, white 85%);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <svg width="16" height="16" fill="none" stroke="{{ $primary }}" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <span style="font-size:0.92rem;color:#374151;font-weight:500">{{ $problem }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@elseif(!empty($cfg['problems']))
<section style="background:#f8f9ff;padding:64px 24px">
    <div class="pub-container">
        <div style="text-align:center;margin-bottom:40px">
            <div style="font-size:0.85rem;font-weight:700;color:{{ $primary }};letter-spacing:0.08em;text-transform:uppercase;margin-bottom:12px">Problémák</div>
            <h2 style="font-size:1.7rem;font-weight:800;color:#1e2535">{{ $cfg['who_title'] }}</h2>
        </div>
        <div class="pub-grid-3">
            @foreach($cfg['problems'] as $problem)
            <div style="background:#fff;padding:20px;border-radius:12px;box-shadow:0 1px 4px rgba(0,0,0,0.07);display:flex;align-items:center;gap:12px">
                <div style="width:36px;height:36px;background:color-mix(in srgb, {{ $primary }}, white 85%);border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <svg width="18" height="18" fill="none" stroke="{{ $primary }}" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                </div>
                <span style="font-weight:500;color:#374151">{{ $problem }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ══════════════════════════════════════════════════════════
     4. SZOLGÁLTATÁSOK
══════════════════════════════════════════════════════════ --}}
@if(!empty($cfg['services']))
<section style="background:#fff;padding:64px 24px">
    <div class="pub-container">
        <div style="text-align:center;margin-bottom:40px">
            <div style="font-size:0.85rem;font-weight:700;color:{{ $primary }};letter-spacing:0.08em;text-transform:uppercase;margin-bottom:12px">Amit kínálok</div>
            <h2 style="font-size:1.7rem;font-weight:800;color:#1e2535">Szolgáltatások</h2>
        </div>
        <div class="pub-grid-3">
            @foreach($cfg['services'] as $service)
            <div style="background:#f8f9ff;border-radius:14px;padding:28px 24px;border:1px solid #e8eaf2">
                <div style="width:44px;height:44px;background:{{ $primary }};border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:16px">
                    <svg width="22" height="22" fill="none" stroke="#fff" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h3 style="font-size:1.05rem;font-weight:700;color:#1e2535;margin-bottom:8px">{{ $service['title'] }}</h3>
                @if($service['desc'])
                <p style="font-size:0.88rem;color:#6b7280;line-height:1.6">{{ $service['desc'] }}</p>
                @endif
            </div>
            @endforeach
        </div>
        @if($cfg['booking_url'])
        <div style="text-align:center;margin-top:36px">
            <a href="{{ $cfg['booking_url'] }}" target="_blank" rel="noopener"
               style="display:inline-flex;align-items:center;gap:8px;background:{{ $primary }};color:#fff;padding:14px 32px;border-radius:10px;font-weight:700;font-size:1rem;text-decoration:none">
                {{ $cfg['booking_label'] }} →
            </a>
        </div>
        @endif
    </div>
</section>
@endif

{{-- ══════════════════════════════════════════════════════════
     5. KÖZELGŐ ESEMÉNYEK
══════════════════════════════════════════════════════════ --}}
@if($upcomingEvents->isNotEmpty())
<section style="background:#f8f9ff;padding:64px 24px">
    <div class="pub-container">
        <div style="text-align:center;margin-bottom:40px">
            <div style="font-size:0.85rem;font-weight:700;color:{{ $primary }};letter-spacing:0.08em;text-transform:uppercase;margin-bottom:12px">Naptár</div>
            <h2 style="font-size:1.7rem;font-weight:800;color:#1e2535">Közelgő események</h2>
        </div>
        <div class="pub-grid-3">
            @foreach($upcomingEvents as $event)
            <a href="{{ route('events.public', $event->slug) }}" class="pub-card">
                <div style="background:{{ $primary }};color:#fff;padding:12px 16px;font-size:0.82rem;font-weight:600;display:flex;align-items:center;gap:6px">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    {{ $event->starts_at->translatedFormat('Y. F j., l H:i') }}
                </div>
                <div style="padding:16px">
                    <div style="font-size:1rem;font-weight:600;color:#1e2535;margin-bottom:6px">{{ $event->title }}</div>
                    @if($event->location)<div style="font-size:0.82rem;color:#64748b">📍 {{ $event->location }}</div>@endif
                </div>
            </a>
            @endforeach
        </div>
        <div style="text-align:center;margin-top:28px">
            <a href="{{ route('public.events') }}" style="color:{{ $primary }};font-weight:600;text-decoration:none;font-size:0.95rem">
                Összes esemény megtekintése →
            </a>
        </div>
    </div>
</section>
@endif

{{-- ══════════════════════════════════════════════════════════
     6. ZÁRÓ CTA (időpontfoglalás)
══════════════════════════════════════════════════════════ --}}
@if($cfg['booking_url'])
<section style="background:#1e2535;padding:56px 24px;text-align:center">
    <div class="pub-container">
        <h2 style="font-size:1.6rem;font-weight:800;color:#fff;margin-bottom:12px">Készen állsz az első lépésre?</h2>
        <p style="color:rgba(255,255,255,0.6);margin-bottom:28px;font-size:1rem">Foglalj időpontot, az első konzultáció kötelezettségmentes.</p>
        <a href="{{ $cfg['booking_url'] }}" target="_blank" rel="noopener"
           style="display:inline-flex;align-items:center;gap:10px;background:{{ $primary }};color:#fff;padding:16px 36px;border-radius:12px;font-weight:700;font-size:1.05rem;text-decoration:none">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            {{ $cfg['booking_label'] }}
        </a>
    </div>
</section>
@endif

@endsection
