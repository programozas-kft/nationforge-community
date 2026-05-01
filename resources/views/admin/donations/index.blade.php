@extends('admin.layouts.app')

@section('title', 'Adományok')
@section('header', 'Adományok')
@section('breadcrumb') <span class="text-gray-700">Adományok</span> @endsection

@section('content')

<div class="nf-card p-5 mb-5 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background:rgba(10,179,156,0.12)">
            <svg class="w-6 h-6" style="color:#0ab39c" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="text-xs text-gray-500">Összes befejezett adomány</p>
            <p class="text-2xl font-bold" style="color:#0ab39c">{{ number_format($total, 0, ',', ' ') }} Ft</p>
        </div>
    </div>
</div>

<div class="nf-card overflow-hidden">
    <table class="nf-table">
        <thead>
            <tr>
                <th>Adományozó</th>
                <th>Összeg</th>
                <th>Státusz</th>
                <th>Módszer</th>
                <th>Visszatérő</th>
                <th>Dátum</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($donations as $donation)
            <tr>
                <td>
                    @if($donation->person)
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0"
                             style="background:linear-gradient(135deg,#405189,#7a5af8)">
                            {{ strtoupper(substr($donation->person->first_name, 0, 1)) }}
                        </div>
                        <a href="{{ route('admin.people.show', $donation->person) }}" class="font-medium text-gray-800 hover:text-indigo-700">
                            {{ $donation->person->last_name }} {{ $donation->person->first_name }}
                        </a>
                    </div>
                    @else
                    <span class="text-gray-400">Ismeretlen</span>
                    @endif
                </td>
                <td class="font-semibold" style="color:#0ab39c">
                    {{ number_format($donation->amount, 0, ',', ' ') }} {{ $donation->currency }}
                </td>
                <td>
                    @php $sc=['completed'=>'badge-success','pending'=>'badge-warning','failed'=>'badge-danger','refunded'=>'badge-secondary']; @endphp
                    <span class="nf-badge {{ $sc[$donation->status] ?? 'badge-secondary' }}">{{ $donation->status }}</span>
                </td>
                <td class="text-gray-500">{{ $donation->payment_method ?? '—' }}</td>
                <td class="text-center">
                    @if($donation->is_recurring)
                        <span class="nf-badge badge-info">Igen</span>
                    @else
                        <span class="text-gray-300">—</span>
                    @endif
                </td>
                <td class="text-gray-400">{{ $donation->created_at->format('Y. m. d.') }}</td>
                <td class="text-right">
                    <a href="{{ route('admin.donations.show', $donation) }}" class="text-xs font-medium mr-3" style="color:#405189">Részletek</a>
                    <form method="POST" action="{{ route('admin.donations.destroy', $donation) }}" class="inline"
                          onsubmit="return confirm('Biztosan törli?')">
                        @csrf @method('DELETE')
                        <button class="text-xs font-medium" style="color:#f06548">Törlés</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="py-10 text-center text-gray-400">Nincs még adomány.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($donations->hasPages())
    <div class="px-5 py-4" style="border-top:1px solid #e9ebec">
        {{ $donations->links() }}
    </div>
    @endif
</div>
@endsection
