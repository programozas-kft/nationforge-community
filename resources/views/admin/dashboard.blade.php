@extends('admin.layouts.app')

@section('title', 'Főoldal')
@section('header', 'Főoldal')

@section('header-actions')
    <a href="{{ route('admin.sugo') }}" target="_blank"
        style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:6px;border:1.5px solid #dee2e6;background:#fff;color:#495057;font-size:0.8rem;font-weight:500;cursor:pointer;text-decoration:none">
        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        Súgó
    </a>
@endsection

@section('content')

<!-- Stat Cards -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-6">

    <div class="nf-card p-5 flex items-center gap-4">
        <div class="stat-icon flex-shrink-0" style="background:rgba(64,81,137,0.12)">
            <svg class="w-6 h-6" style="color:#405189" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['people']) }}</p>
            <p class="text-xs text-gray-500 mt-0.5">Összes kapcsolat</p>
            <p class="text-xs mt-1" style="color:#0ab39c">+{{ $stats['new_people'] }} ez hónapban</p>
        </div>
    </div>

    <div class="nf-card p-5 flex items-center gap-4">
        <div class="stat-icon flex-shrink-0" style="background:rgba(10,179,156,0.12)">
            <svg class="w-6 h-6" style="color:#0ab39c" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['events'] }}</p>
            <p class="text-xs text-gray-500 mt-0.5">Közelgő esemény</p>
        </div>
    </div>

    <div class="nf-card p-5 flex items-center gap-4">
        <div class="stat-icon flex-shrink-0" style="background:rgba(247,184,75,0.12)">
            <svg class="w-6 h-6" style="color:#f7b84b" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['donations'], 0, ',', ' ') }}</p>
            <p class="text-xs text-gray-500 mt-0.5">Összes adomány (Ft)</p>
        </div>
    </div>

    <div class="nf-card p-5 flex items-center gap-4">
        <div class="stat-icon flex-shrink-0" style="background:rgba(122,90,248,0.12)">
            <svg class="w-6 h-6" style="color:#7a5af8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['subscribed']) }}</p>
            <p class="text-xs text-gray-500 mt-0.5">Hírlevél feliratkozó</p>
        </div>
    </div>
</div>

<!-- Two columns -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

    <!-- Recent people -->
    <div class="nf-card">
        <div class="nf-card-header flex items-center justify-between">
            <span>Legújabb kapcsolatok</span>
            <a href="{{ route('admin.people.index') }}" class="text-xs font-normal" style="color:#405189">Összes megtekintése →</a>
        </div>
        <div class="divide-y" style="border-color:#f3f3f9">
            @forelse($recent_people as $person)
            <div class="px-5 py-3 flex items-center gap-3">
                @if($person->photo)
                    <div style="width:32px;height:32px;border-radius:50%;overflow:hidden;flex-shrink:0">
                        <img src="{{ asset('storage/' . $person->photo) }}" style="width:100%;height:100%;object-fit:cover" alt="">
                    </div>
                @else
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0"
                         style="background:linear-gradient(135deg,#405189,#7a5af8)">
                        {{ strtoupper(substr($person->first_name, 0, 1)) }}
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <a href="{{ route('admin.people.show', $person) }}"
                       class="text-sm font-medium text-gray-800 hover:text-indigo-700 truncate block">
                        {{ $person->last_name }} {{ $person->first_name }}
                    </a>
                    <p class="text-xs text-gray-400 truncate">{{ $person->email ?? '—' }}</p>
                </div>
                @php
                    $sc = ['member'=>'badge-primary','supporter'=>'badge-success','donor'=>'badge-warning','vip'=>'badge-purple','inactive'=>'badge-secondary'];
                @endphp
                <span class="nf-badge {{ $sc[$person->status] ?? 'badge-secondary' }}">{{ $person->status }}</span>
            </div>
            @empty
            <div class="px-5 py-6 text-center text-sm text-gray-400">Nincs kapcsolat.</div>
            @endforelse
        </div>
    </div>

    <!-- Upcoming events -->
    <div class="nf-card">
        <div class="nf-card-header flex items-center justify-between">
            <span>Közelgő események</span>
            <a href="{{ route('admin.events.index') }}" class="text-xs font-normal" style="color:#405189">Összes megtekintése →</a>
        </div>
        <div class="divide-y" style="border-color:#f3f3f9">
            @forelse($upcoming_events as $event)
            <div class="px-5 py-3 flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg flex flex-col items-center justify-center flex-shrink-0 text-white"
                     style="background:linear-gradient(135deg,#0ab39c,#0a8c7a)">
                    <span class="text-xs font-bold leading-none">{{ $event->starts_at->format('d') }}</span>
                    <span class="text-xs leading-none opacity-80">{{ $event->starts_at->format('M') }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <a href="{{ route('admin.events.show', $event) }}"
                       class="text-sm font-medium text-gray-800 hover:text-indigo-700 truncate block">
                        {{ $event->title }}
                    </a>
                    <p class="text-xs text-gray-400">{{ $event->starts_at->format('H:i') }} · {{ $event->city ?? ($event->is_online ? 'Online' : '—') }}</p>
                </div>
                <span class="nf-badge badge-info">{{ $event->type }}</span>
            </div>
            @empty
            <div class="px-5 py-6 text-center text-sm text-gray-400">Nincs közelgő esemény.</div>
            @endforelse
        </div>
    </div>
</div>

@endsection
