@extends('public.layouts.app')
@section('title', 'Események')

@section('content')
@php
    $primary = \App\Models\Setting::get('brand_primary_color', '#405189');
    $orgName = \App\Models\Setting::get('brand_org_name', config('app.name'));
@endphp

<div style="background:var(--primary);padding:40px 24px;color:#fff">
    <div class="pub-container">
        <h1 style="font-size:1.8rem;font-weight:800">Események</h1>
        <p style="opacity:0.8;margin-top:6px">{{ $orgName }} rendezvényei</p>
    </div>
</div>

<div class="pub-container" style="padding-top:40px;padding-bottom:60px">

    @if($upcoming->isNotEmpty())
    <div class="pub-section-title" style="margin-bottom:20px"><span>Közelgő események</span></div>
    <div class="pub-grid-3" style="margin-bottom:48px">
        @foreach($upcoming as $event)
        <a href="{{ route('events.public', $event->slug) }}" class="pub-card">
            <div class="event-card-date">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                {{ $event->starts_at->translatedFormat('Y. F j., l H:i') }}
            </div>
            <div class="event-card-body">
                <div class="event-card-title">{{ $event->title }}</div>
                @if($event->location)
                <div class="event-card-meta" style="display:flex;align-items:center;gap:4px;margin-top:6px">
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ $event->location }}
                </div>
                @endif
                @if($event->description)
                <div class="event-card-meta" style="margin-top:8px;color:#475569">{{ Str::limit(strip_tags($event->description), 80) }}</div>
                @endif
            </div>
        </a>
        @endforeach
    </div>
    @else
    <div style="text-align:center;padding:60px 0;color:#94a3b8">
        <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-bottom:12px;opacity:0.4"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        <p style="font-size:1rem">Jelenleg nincs közelgő esemény.</p>
    </div>
    @endif

    @if($past->isNotEmpty())
    <div style="border-top:1px solid #e8eaf2;padding-top:40px">
        <div class="pub-section-title" style="margin-bottom:20px"><span>Korábbi események</span></div>
        <div class="pub-grid-3">
            @foreach($past as $event)
            <a href="{{ route('events.public', $event->slug) }}" class="pub-card" style="opacity:0.75">
                <div class="event-card-date" style="background:#64748b">
                    {{ $event->starts_at->translatedFormat('Y. F j.') }}
                </div>
                <div class="event-card-body">
                    <div class="event-card-title">{{ $event->title }}</div>
                    @if($event->location)
                    <div class="event-card-meta">{{ $event->location }}</div>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection
