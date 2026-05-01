@extends('admin.layouts.app')

@section('title', $person->last_name . ' ' . $person->first_name)
@section('header', $person->last_name . ' ' . $person->first_name)
@section('breadcrumb')
    <a href="{{ route('admin.people.index') }}">Kapcsolatok</a>
    <span class="breadcrumb-sep">/</span>
    <span class="text-gray-700">{{ $person->last_name }} {{ $person->first_name }}</span>
@endsection

@section('header-actions')
    <a href="{{ route('admin.people.edit', $person) }}" class="btn-primary">Szerkesztés</a>
    <form method="POST" action="{{ route('admin.people.destroy', $person) }}" class="inline"
          onsubmit="return confirm('Biztosan törli?')">
        @csrf @method('DELETE')
        <button class="btn-danger">Törlés</button>
    </form>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    <!-- Profile card -->
    <div class="space-y-5">
        <div class="nf-card p-6 text-center">
            <div class="w-20 h-20 rounded-full flex items-center justify-center text-white text-3xl font-bold mx-auto mb-3"
                 style="background:linear-gradient(135deg,#405189,#7a5af8)">
                {{ strtoupper(substr($person->first_name, 0, 1)) }}
            </div>
            <h2 class="text-base font-semibold text-gray-800">{{ $person->last_name }} {{ $person->first_name }}</h2>
            <p class="text-sm text-gray-500">{{ $person->email ?? '—' }}</p>
            @php
                $sc = ['member'=>'badge-primary','supporter'=>'badge-success','donor'=>'badge-warning','volunteer'=>'badge-info','vip'=>'badge-purple','prospect'=>'badge-secondary','inactive'=>'badge-secondary'];
                $sl = ['prospect'=>'Érdeklődő','supporter'=>'Támogató','member'=>'Tag','volunteer'=>'Önkéntes','donor'=>'Adományozó','vip'=>'VIP','inactive'=>'Inaktív'];
            @endphp
            <div class="mt-2">
                <span class="nf-badge {{ $sc[$person->status] ?? 'badge-secondary' }}">{{ $sl[$person->status] ?? $person->status }}</span>
            </div>
        </div>

        <div class="nf-card">
            <div class="nf-card-header">Adatok</div>
            <div class="px-5 py-4 space-y-3">
                @foreach([
                    ['Telefon', $person->phone],
                    ['Város', $person->city],
                    ['Feliratkozott', $person->is_subscribed ? 'Igen' : 'Nem'],
                    ['Forrás', $person->source],
                    ['Regisztrált', $person->created_at->format('Y. m. d.')],
                ] as [$label, $value])
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">{{ $label }}</span>
                    <span class="font-medium text-gray-800">{{ $value ?? '—' }}</span>
                </div>
                @endforeach
                <div class="flex justify-between text-sm pt-2" style="border-top:1px solid #f3f3f9">
                    <span class="text-gray-500">Összes adomány</span>
                    <span class="font-semibold" style="color:#0ab39c">{{ number_format($person->total_donated, 0, ',', ' ') }} Ft</span>
                </div>
            </div>
            @if($person->notes)
            <div class="px-5 pb-4">
                <p class="text-xs text-gray-400 mb-1">Megjegyzés</p>
                <p class="text-sm text-gray-600">{{ $person->notes }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Detail cards -->
    <div class="lg:col-span-2 space-y-5">
        <div class="nf-card overflow-hidden">
            <div class="nf-card-header">Adományok</div>
            <table class="nf-table">
                <thead>
                    <tr>
                        <th>Összeg</th>
                        <th>Státusz</th>
                        <th>Módszer</th>
                        <th>Dátum</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($person->donations as $donation)
                    <tr>
                        <td class="font-semibold" style="color:#0ab39c">{{ number_format($donation->amount, 0, ',', ' ') }} {{ $donation->currency }}</td>
                        <td><span class="nf-badge {{ $donation->status === 'completed' ? 'badge-success' : 'badge-secondary' }}">{{ $donation->status }}</span></td>
                        <td class="text-gray-500">{{ $donation->payment_method ?? '—' }}</td>
                        <td class="text-gray-400">{{ $donation->created_at->format('Y. m. d.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="py-6 text-center text-gray-400">Nincs adomány.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="nf-card overflow-hidden">
            <div class="nf-card-header">Csoportok</div>
            <table class="nf-table">
                <thead>
                    <tr>
                        <th>Csoport neve</th>
                        <th>Típus</th>
                        <th>Láthatóság</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($person->groups as $group)
                    <tr>
                        <td>
                            <a href="{{ route('admin.groups.show', $group) }}" class="font-medium text-gray-800 hover:text-indigo-700">{{ $group->name }}</a>
                        </td>
                        <td><span class="nf-badge badge-purple">{{ $group->type }}</span></td>
                        <td class="text-gray-500">{{ $group->privacy }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="py-6 text-center text-gray-400">Nincs csoport.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
