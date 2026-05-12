@extends('admin.layouts.app')

@section('title', $event->title)
@section('header', $event->title)
@section('breadcrumb')
    <a href="{{ route('admin.events.index') }}">{{ __('events.title') }}</a>
    <span class="breadcrumb-sep">/</span>
    <span class="text-gray-700">{{ $event->title }}</span>
@endsection

@section('header-actions')
    @if($event->status === 'published')
    <a href="{{ route('events.public', $event->slug) }}" target="_blank" class="btn-ghost"
       style="display:inline-flex;align-items:center;gap:5px">
        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
        {{ __('events.public_page') }}
    </a>
    @endif
    <a href="{{ route('admin.events.edit', $event) }}" class="btn-primary">{{ __('common.edit') }}</a>
    <form method="POST" action="{{ route('admin.events.destroy', $event) }}" class="inline"
          onsubmit="return confirm('{{ __('common.confirm_delete') }}')">
        @csrf @method('DELETE')
        <button class="btn-danger">{{ __('common.delete') }}</button>
    </form>
@endsection

@section('content')
@php
    $statusMap = ['draft'=>'badge-secondary','published'=>'badge-success','cancelled'=>'badge-danger','completed'=>'badge-primary'];
@endphp
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
    <div class="space-y-5">
        <div class="nf-card">
            <div class="nf-card-header">{{ __('events.details') }}</div>
            <div class="space-y-3 text-sm" style="padding: 16px 20px;">
                <div class="flex justify-between">
                    <span class="text-gray-500">{{ __('common.status') }}</span>
                    <span class="nf-badge {{ $statusMap[$event->status] ?? 'badge-secondary' }}">{{ __('events.status.' . $event->status) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">{{ __('common.type') }}</span>
                    <span class="nf-badge badge-info">{{ __('events.type.' . $event->type) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">{{ __('events.col_start') }}</span>
                    <span class="font-medium text-gray-800">{{ $event->starts_at->format('Y. m. d. H:i') }}</span>
                </div>
                @if($event->ends_at)
                <div class="flex justify-between">
                    <span class="text-gray-500">{{ __('events.col_end') }}</span>
                    <span class="font-medium text-gray-800">{{ $event->ends_at->format('Y. m. d. H:i') }}</span>
                </div>
                @endif
                <div class="flex justify-between">
                    <span class="text-gray-500">{{ __('common.online') }}</span>
                    <span class="font-medium text-gray-800">{{ $event->is_online ? __('common.yes') : __('common.no') }}</span>
                </div>
                @if($event->online_url)
                <div class="flex justify-between">
                    <span class="text-gray-500">URL</span>
                    <a href="{{ $event->online_url }}" target="_blank" style="color:#405189" class="text-xs">{{ __('events.link') }}</a>
                </div>
                @endif
                @if($event->venue_name)
                <div class="flex justify-between">
                    <span class="text-gray-500">{{ __('events.venue') }}</span>
                    <span class="font-medium text-gray-800">{{ $event->venue_name }}</span>
                </div>
                @endif
                @if($event->city)
                <div class="flex justify-between">
                    <span class="text-gray-500">{{ __('common.city') }}</span>
                    <span class="font-medium text-gray-800">{{ $event->city }}</span>
                </div>
                @endif
                @if($event->capacity)
                <div class="flex justify-between">
                    <span class="text-gray-500">{{ __('events.capacity_short') }}</span>
                    <span class="font-medium text-gray-800">{{ $event->capacity }} {{ __('events.persons_unit') }}</span>
                </div>
                @endif
                @if($event->ticket_price !== null)
                <div class="flex justify-between">
                    <span class="text-gray-500">{{ __('events.ticket_price_short') }}</span>
                    <span class="font-semibold" style="color:#f7b84b">{{ number_format($event->ticket_price, 0, ',', ' ') }} Ft</span>
                </div>
                @endif
            </div>
        </div>

        @if($event->description)
        <div class="nf-card p-5">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">{{ __('common.description') }}</p>
            <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-wrap">{{ $event->description }}</p>
        </div>
        @endif
    </div>

    <div class="lg:col-span-2" style="display:flex;flex-direction:column;gap:20px">

        {{-- Public registrations --}}
        <div class="nf-card overflow-hidden">
            <div class="nf-card-header" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px">
                <span>{{ __('events.registrations') }} ({{ $event->registrations->count() }})</span>
                <div style="display:flex;align-items:center;gap:8px">
                    <a href="{{ route('admin.events.checkin', $event) }}"
                       style="font-size:0.75rem;background:#405189;color:#fff;padding:5px 12px;border-radius:6px;text-decoration:none;display:inline-flex;align-items:center;gap:5px;font-weight:600">
                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6.364 1.636l-.707.707M20 12h-1M17.657 17.657l-.707-.707M12 20v-1m-5.657-1.636l.707-.707M4 12h1M6.343 6.343l.707.707M9 12a3 3 0 116 0 3 3 0 01-6 0z"/></svg>
                        {{ __('events.checkin_scanner') }}
                    </a>
                    @if($event->status === 'published')
                    <a href="{{ route('events.public', $event->slug) }}" target="_blank"
                       style="font-size:0.75rem;color:#405189;display:inline-flex;align-items:center;gap:4px">
                        {{ __('events.reg_link') }}
                        <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                    @endif
                </div>
            </div>
            @php $checkedInCount = $event->registrations->whereNotNull('checked_in_at')->count(); @endphp
            @if($event->registrations->count() > 0)
            <div style="padding:8px 16px;background:#f8f9fa;border-bottom:1px solid #e9ebec;font-size:0.78rem;color:#6c757d;display:flex;gap:16px">
                <span>{{ __('events.checkin_total') }}: <strong style="color:#212529">{{ $event->registrations->count() }}</strong></span>
                <span>{{ __('events.checkin_done') }}: <strong style="color:#0ab39c">{{ $checkedInCount }}</strong></span>
                <span>{{ __('events.checkin_pending_count') }}: <strong style="color:#f7b84b">{{ $event->registrations->count() - $checkedInCount }}</strong></span>
            </div>
            @endif
            <table class="nf-table">
                <thead>
                    <tr>
                        <th>{{ __('common.name') }}</th>
                        <th>{{ __('common.email') }}</th>
                        <th>{{ __('common.phone') }}</th>
                        <th>{{ __('events.col_guests') }}</th>
                        <th>{{ __('events.col_checkin') }}</th>
                        <th>{{ __('common.registered') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($event->registrations as $reg)
                    <tr>
                        <td style="font-weight:500;color:#343a40">{{ $reg->name }}</td>
                        <td style="color:#405189;font-size:0.82rem">{{ $reg->email }}</td>
                        <td style="color:#6c757d;font-size:0.82rem">{{ $reg->phone ?? '—' }}</td>
                        <td style="color:#6c757d">{{ $reg->guests }}</td>
                        <td>
                            @if($reg->checked_in_at)
                                <span style="color:#0ab39c;font-size:0.78rem;font-weight:600;display:flex;align-items:center;gap:4px">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    {{ $reg->checked_in_at->format('H:i') }}
                                </span>
                            @else
                                <span style="color:#adb5bd;font-size:0.78rem">—</span>
                            @endif
                        </td>
                        <td style="color:#adb5bd;font-size:0.8rem">{{ $reg->created_at->format('Y. m. d. H:i') }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.events.checkin.manual', $event) }}">
                                @csrf
                                <input type="hidden" name="registration_id" value="{{ $reg->id }}">
                                <button type="submit" style="font-size:0.72rem;padding:3px 8px;border-radius:4px;border:1px solid {{ $reg->checked_in_at ? '#dc3545' : '#0ab39c' }};background:transparent;color:{{ $reg->checked_in_at ? '#dc3545' : '#0ab39c' }};cursor:pointer;white-space:nowrap">
                                    {{ $reg->checked_in_at ? __('events.checkin_undo') : __('events.checkin_btn') }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" style="text-align:center;padding:32px;color:#adb5bd">{{ __('events.no_regs') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Volunteer shifts --}}
        @include('admin.events._shifts', ['event' => $event, 'people' => $people])

        {{-- Internal RSVP --}}
        <div class="nf-card overflow-hidden">
            <div class="nf-card-header">{{ __('events.internal_rsvp') }} ({{ $event->rsvps->count() }})</div>
            <table class="nf-table">
                <thead>
                    <tr>
                        <th>{{ __('common.name') }}</th>
                        <th>{{ __('common.status') }}</th>
                        <th>{{ __('common.registered') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($event->rsvps as $rsvp)
                    <tr>
                        <td>
                            @if($rsvp->person)
                            <a href="{{ route('admin.people.show', $rsvp->person) }}" class="font-medium text-gray-800 hover:text-indigo-700">
                                {{ $rsvp->person->last_name }} {{ $rsvp->person->first_name }}
                            </a>
                            @else
                            <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td><span class="nf-badge badge-secondary">{{ $rsvp->status ?? '—' }}</span></td>
                        <td class="text-gray-400">{{ $rsvp->created_at->format('Y. m. d.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" style="text-align:center;padding:32px;color:#adb5bd">{{ __('events.no_rsvp') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
