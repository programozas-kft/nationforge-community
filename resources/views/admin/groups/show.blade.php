@extends('admin.layouts.app')

@section('title', $group->name)
@section('header', $group->name)
@section('breadcrumb')
    <a href="{{ route('admin.groups.index') }}">Csoportok</a>
    <span class="breadcrumb-sep">/</span>
    <span class="text-gray-700">{{ $group->name }}</span>
@endsection

@section('header-actions')
    <a href="{{ route('admin.groups.edit', $group) }}" class="btn-primary">Szerkesztés</a>
    <form method="POST" action="{{ route('admin.groups.destroy', $group) }}" class="inline"
          onsubmit="return confirm('Biztosan törli?')">
        @csrf @method('DELETE')
        <button class="btn-danger">Törlés</button>
    </form>
@endsection

@section('content')
@php
    $totalMembers = $group->people->count() + $group->users->count();
    $sc = ['member'=>'badge-primary','supporter'=>'badge-success','donor'=>'badge-warning','volunteer'=>'badge-info','vip'=>'badge-purple','prospect'=>'badge-secondary','inactive'=>'badge-secondary'];
    $sl = ['prospect'=>'Érdeklődő','supporter'=>'Támogató','member'=>'Tag','volunteer'=>'Önkéntes','donor'=>'Adományozó','vip'=>'VIP','inactive'=>'Inaktív'];
@endphp
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- Bal oszlop: Adatok + Leírás + Tagok --}}
    <div class="space-y-5">
        <div class="nf-card">
            <div class="nf-card-header">Adatok</div>
            <div class="py-4 space-y-3 text-sm" style="padding-left: 24px; padding-right: 24px;">
                <div class="flex justify-between">
                    <span class="text-gray-500">Típus</span>
                    <span class="nf-badge badge-purple">{{ $group->type }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Láthatóság</span>
                    <span class="nf-badge badge-secondary">{{ $group->privacy }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Státusz</span>
                    <span class="nf-badge {{ $group->is_active ? 'badge-success' : 'badge-secondary' }}">
                        {{ $group->is_active ? 'Aktív' : 'Inaktív' }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Tagok száma</span>
                    <span class="font-semibold text-gray-800">{{ $totalMembers }} fő</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Létrehozva</span>
                    <span class="font-medium text-gray-800">{{ $group->created_at->format('Y. m. d.') }}</span>
                </div>
            </div>
        </div>

        @if($group->description)
        <div class="nf-card p-5">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Leírás</p>
            <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-wrap">{{ $group->description }}</p>
        </div>
        @endif

        <div class="nf-card overflow-hidden">
            <div class="nf-card-header">Tagok ({{ $totalMembers }})</div>
            <table class="nf-table">
                <thead>
                    <tr>
                        <th>Név</th>
                        <th>Státusz / Szerepkör</th>
                        <th>Típus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($group->people as $person)
                    <tr>
                        <td>
                            <div class="flex items-center gap-2">
                                @if($person->photo)
                                    <div class="w-7 h-7 rounded-full overflow-hidden flex-shrink-0">
                                        <img src="{{ asset('storage/' . $person->photo) }}" class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0"
                                         style="background:linear-gradient(135deg,#405189,#7a5af8)">
                                        {{ strtoupper(substr($person->first_name, 0, 1)) }}
                                    </div>
                                @endif
                                <a href="{{ route('admin.people.show', $person) }}" class="font-medium text-gray-800 hover:text-indigo-700">
                                    {{ $person->last_name }} {{ $person->first_name }}
                                </a>
                            </div>
                        </td>
                        <td><span class="nf-badge {{ $sc[$person->status] ?? 'badge-secondary' }}">{{ $sl[$person->status] ?? $person->status }}</span></td>
                        <td><span class="nf-badge badge-secondary">Kapcsolat</span></td>
                    </tr>
                    @endforeach

                    @foreach($group->users as $user)
                    <tr>
                        <td>
                            <div class="flex items-center gap-2">
                                @if($user->photo)
                                    <div class="w-7 h-7 rounded-full overflow-hidden flex-shrink-0">
                                        <img src="{{ asset('storage/' . $user->photo) }}" class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0"
                                         style="background:linear-gradient(135deg,#f97316,#ea580c)">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <span class="font-medium text-gray-800">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td>
                            @php $roleColors=['super-admin'=>'badge-danger','admin'=>'badge-primary','editor'=>'badge-warning','member'=>'badge-secondary']; @endphp
                            @foreach($user->roles as $role)
                                <span class="nf-badge {{ $roleColors[$role->name] ?? 'badge-secondary' }}">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td><span class="nf-badge badge-info">Felhasználó</span></td>
                    </tr>
                    @endforeach

                    @if($totalMembers === 0)
                    <tr><td colspan="3" class="py-8 text-center text-gray-400">Nincs tag.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- Jobb oszlop: Chat --}}
    <div class="lg:col-span-2" style="position:sticky; top:0; height:calc(100vh - 108px); margin-right:-24px;">
        @livewire('admin.groups.group-chat', ['group' => $group])
    </div>

</div>
@endsection
