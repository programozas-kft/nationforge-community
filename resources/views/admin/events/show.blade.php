@extends('admin.layouts.app')

@section('title', $event->title)
@section('header', $event->title)
@section('breadcrumb')
    <a href="{{ route('admin.events.index') }}">Események</a>
    <span class="breadcrumb-sep">/</span>
    <span class="text-gray-700">{{ $event->title }}</span>
@endsection

@section('header-actions')
    <a href="{{ route('admin.events.edit', $event) }}" class="btn-primary">Szerkesztés</a>
    <form method="POST" action="{{ route('admin.events.destroy', $event) }}" class="inline"
          onsubmit="return confirm('Biztosan törli?')">
        @csrf @method('DELETE')
        <button class="btn-danger">Törlés</button>
    </form>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
    <div class="space-y-5">
        <div class="nf-card">
            <div class="nf-card-header">Részletek</div>
            <div class="space-y-3 text-sm" style="padding: 16px 20px;">
                @php $sc=['draft'=>'badge-secondary','published'=>'badge-success','cancelled'=>'badge-danger','completed'=>'badge-primary']; @endphp
                <div class="flex justify-between">
                    <span class="text-gray-500">Státusz</span>
                    <span class="nf-badge {{ $sc[$event->status] ?? 'badge-secondary' }}">{{ $event->status }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Típus</span>
                    <span class="nf-badge badge-info">{{ $event->type }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Kezdés</span>
                    <span class="font-medium text-gray-800">{{ $event->starts_at->format('Y. m. d. H:i') }}</span>
                </div>
                @if($event->ends_at)
                <div class="flex justify-between">
                    <span class="text-gray-500">Befejezés</span>
                    <span class="font-medium text-gray-800">{{ $event->ends_at->format('Y. m. d. H:i') }}</span>
                </div>
                @endif
                <div class="flex justify-between">
                    <span class="text-gray-500">Online</span>
                    <span class="font-medium text-gray-800">{{ $event->is_online ? 'Igen' : 'Nem' }}</span>
                </div>
                @if($event->online_url)
                <div class="flex justify-between">
                    <span class="text-gray-500">URL</span>
                    <a href="{{ $event->online_url }}" target="_blank" style="color:#405189" class="text-xs">Link →</a>
                </div>
                @endif
                @if($event->venue_name)
                <div class="flex justify-between">
                    <span class="text-gray-500">Helyszín</span>
                    <span class="font-medium text-gray-800">{{ $event->venue_name }}</span>
                </div>
                @endif
                @if($event->city)
                <div class="flex justify-between">
                    <span class="text-gray-500">Város</span>
                    <span class="font-medium text-gray-800">{{ $event->city }}</span>
                </div>
                @endif
                @if($event->capacity)
                <div class="flex justify-between">
                    <span class="text-gray-500">Kapacitás</span>
                    <span class="font-medium text-gray-800">{{ $event->capacity }} fő</span>
                </div>
                @endif
                @if($event->ticket_price !== null)
                <div class="flex justify-between">
                    <span class="text-gray-500">Jegyár</span>
                    <span class="font-semibold" style="color:#f7b84b">{{ number_format($event->ticket_price, 0, ',', ' ') }} Ft</span>
                </div>
                @endif
            </div>
        </div>

        @if($event->description)
        <div class="nf-card p-5">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Leírás</p>
            <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-wrap">{{ $event->description }}</p>
        </div>
        @endif
    </div>

    <div class="lg:col-span-2">
        <div class="nf-card overflow-hidden">
            <div class="nf-card-header">Résztvevők ({{ $event->rsvps->count() }})</div>
            <table class="nf-table">
                <thead>
                    <tr>
                        <th>Név</th>
                        <th>Státusz</th>
                        <th>Regisztrált</th>
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
                    <tr><td colspan="3" class="py-8 text-center text-gray-400">Nincs jelentkező.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
