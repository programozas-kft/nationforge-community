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
            <div class="nf-card-header" style="display:flex;align-items:center;justify-content:space-between">
                <span>{{ __('events.registrations') }} ({{ $event->registrations->count() }})</span>
                @if($event->status === 'published')
                <a href="{{ route('events.public', $event->slug) }}" target="_blank"
                   style="font-size:0.75rem;color:#405189;display:inline-flex;align-items:center;gap:4px">
                    {{ __('events.reg_link') }}
                    <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
                @endif
            </div>
            <table class="nf-table">
                <thead>
                    <tr>
                        <th>{{ __('common.name') }}</th>
                        <th>{{ __('common.email') }}</th>
                        <th>{{ __('common.phone') }}</th>
                        <th>{{ __('events.col_guests') }}</th>
                        <th>{{ __('common.registered') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($event->registrations as $reg)
                    <tr>
                        <td style="font-weight:500;color:#343a40">{{ $reg->name }}</td>
                        <td style="color:#405189;font-size:0.82rem">{{ $reg->email }}</td>
                        <td style="color:#6c757d;font-size:0.82rem">{{ $reg->phone ?? '—' }}</td>
                        <td style="color:#6c757d">{{ $reg->guests }}</td>
                        <td style="color:#adb5bd;font-size:0.8rem">{{ $reg->created_at->format('Y. m. d. H:i') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="text-align:center;padding:32px;color:#adb5bd">{{ __('events.no_regs') }}</td></tr>
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
