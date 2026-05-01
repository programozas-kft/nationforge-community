@extends('admin.layouts.app')

@section('title', 'Adomány részletei')
@section('header', 'Adomány részletei')
@section('breadcrumb')
    <a href="{{ route('admin.donations.index') }}">Adományok</a>
    <span class="breadcrumb-sep">/</span>
    <span class="text-gray-700">Részletek</span>
@endsection

@section('header-actions')
    <form method="POST" action="{{ route('admin.donations.destroy', $donation) }}"
          onsubmit="return confirm('Biztosan törli ezt az adományt?')">
        @csrf @method('DELETE')
        <button class="btn-danger">Törlés</button>
    </form>
@endsection

@section('content')
<div class="max-w-lg">
    <div class="nf-card overflow-hidden">
        <div class="p-6 text-center" style="background:linear-gradient(135deg,#f0fdf9,#e6f9f6);border-bottom:1px solid #e9ebec">
            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Összeg</p>
            <p class="text-4xl font-bold" style="color:#0ab39c">
                {{ number_format($donation->amount, 0, ',', ' ') }} {{ $donation->currency }}
            </p>
        </div>
        <div class="px-6 py-5 space-y-4 text-sm">
            <div class="flex justify-between items-center">
                <span class="text-gray-500">Adományozó</span>
                <span class="font-medium">
                    @if($donation->person)
                        <a href="{{ route('admin.people.show', $donation->person) }}" style="color:#405189">
                            {{ $donation->person->last_name }} {{ $donation->person->first_name }}
                        </a>
                    @else
                        Ismeretlen
                    @endif
                </span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-500">Státusz</span>
                @php $sc=['completed'=>'badge-success','pending'=>'badge-warning','failed'=>'badge-danger','refunded'=>'badge-secondary']; @endphp
                <span class="nf-badge {{ $sc[$donation->status] ?? 'badge-secondary' }}">{{ $donation->status }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-500">Fizetési mód</span>
                <span class="font-medium text-gray-800">{{ $donation->payment_method ?? '—' }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-500">Visszatérő</span>
                <span class="nf-badge {{ $donation->is_recurring ? 'badge-info' : 'badge-secondary' }}">
                    {{ $donation->is_recurring ? 'Igen' : 'Nem' }}
                </span>
            </div>
            @if($donation->notes)
            <div class="flex justify-between items-start">
                <span class="text-gray-500">Megjegyzés</span>
                <span class="font-medium text-gray-800 text-right max-w-xs">{{ $donation->notes }}</span>
            </div>
            @endif
            <div class="flex justify-between items-center pt-3" style="border-top:1px solid #f3f3f9">
                <span class="text-gray-500">Dátum</span>
                <span class="font-medium text-gray-800">{{ $donation->created_at->format('Y. m. d. H:i') }}</span>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.donations.index') }}" class="text-sm" style="color:#405189">← Vissza a listához</a>
    </div>
</div>
@endsection
