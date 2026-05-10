@extends('admin.layouts.app')

@section('title', 'Duplikátum detektálás')
@section('header', 'Duplikátum detektálás')
@section('breadcrumb')
    <span style="color:#dee2e6">/</span>
    <a href="{{ route('admin.people.index') }}" style="color:#adb5bd">Kapcsolatok</a>
    <span style="color:#dee2e6">/</span>
    <span style="color:#495057">Duplikátumok</span>
@endsection

@section('header-actions')
    <a href="{{ route('admin.people.index') }}" class="btn-ghost">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Vissza
    </a>
@endsection

@section('content')

@if($pairs->isEmpty())
<div class="nf-card" style="padding:60px 40px;text-align:center">
    <div style="width:60px;height:60px;border-radius:50%;background:rgba(10,179,156,0.1);display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
        <svg width="28" height="28" fill="none" stroke="#0ab39c" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    </div>
    <h3 style="font-size:1.1rem;font-weight:600;color:#343a40;margin-bottom:8px">Nincs duplikátum</h3>
    <p style="font-size:0.875rem;color:#6c757d">Nem található egyező email, telefon vagy névvel rendelkező kapcsolat.</p>
</div>
@else

<div style="margin-bottom:16px;display:flex;align-items:center;gap:10px">
    <div style="background:rgba(240,101,72,0.1);border:1px solid rgba(240,101,72,0.2);border-radius:6px;padding:8px 14px;font-size:0.8125rem;color:#f06548;font-weight:500">
        {{ $pairs->count() }} potenciális duplikátum pár található
    </div>
    <span style="font-size:0.8rem;color:#adb5bd">Ellenőrizd és vond össze az egyező kapcsolatokat.</span>
</div>

@foreach($pairs as $i => $pair)
@php
    $a = $pair['a'];
    $b = $pair['b'];
    $reasons = $pair['reasons'];
    $reasonLabels = ['email' => 'Email egyezés', 'phone' => 'Telefon egyezés', 'name' => 'Névegyezés'];
    $reasonColors = ['email' => '#405189', 'phone' => '#0ab39c', 'name' => '#f7b84b'];
@endphp
<div class="nf-card" style="margin-bottom:12px">
    {{-- Header --}}
    <div style="padding:10px 16px;border-bottom:1px solid #e9ebec;display:flex;align-items:center;gap:8px;background:#fafbff;border-radius:8px 8px 0 0">
        <span style="font-size:0.75rem;font-weight:600;color:#adb5bd">#{{ $i + 1 }}</span>
        @foreach($reasons as $r)
        <span style="display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:12px;font-size:0.7rem;font-weight:600;background:{{ $reasonColors[$r] ?? '#6c757d' }}1a;color:{{ $reasonColors[$r] ?? '#6c757d' }}">
            {{ $reasonLabels[$r] ?? $r }}
        </span>
        @endforeach
        <button onclick="openMergeModal({{ $a->id }},{{ $b->id }},'{{ $i }}')"
            style="margin-left:auto;display:inline-flex;align-items:center;gap:5px;padding:4px 12px;background:#405189;color:#fff;border:none;border-radius:5px;font-size:0.78rem;font-weight:500;cursor:pointer">
            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
            Összevonás
        </button>
    </div>

    {{-- Side-by-side --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0">
        @foreach([$a, $b] as $ci => $c)
        <div style="{{ $ci === 0 ? 'border-right:1px solid #e9ebec;' : '' }}padding:16px">
            {{-- Avatar + name --}}
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px">
                <div style="width:44px;height:44px;border-radius:50%;overflow:hidden;flex-shrink:0;background:linear-gradient(135deg,{{ $ci === 0 ? '#405189,#7a5af8' : '#0ab39c,#0891b2' }});display:flex;align-items:center;justify-content:center">
                    @if($c->photo)
                        <img src="{{ asset('storage/'.$c->photo) }}" style="width:100%;height:100%;object-fit:cover">
                    @else
                        <span style="color:#fff;font-size:0.8rem;font-weight:700">{{ strtoupper(substr($c->first_name,0,1)) }}</span>
                    @endif
                </div>
                <div>
                    <div style="font-weight:600;color:#343a40;font-size:0.9rem">{{ $c->last_name }} {{ $c->first_name }}</div>
                    <div style="font-size:0.72rem;color:#adb5bd">ID: {{ $c->id }} · {{ $c->created_at->format('Y. m. d.') }}</div>
                </div>
            </div>

            {{-- Fields --}}
            @php
                $fields = [
                    'Email'   => $c->email,
                    'Telefon' => $c->phone,
                    'Mobil'   => $c->mobile,
                    'Város'   => $c->city,
                    'Státusz' => $c->status,
                    'Forrás'  => $c->source,
                    'Hírlevél'=> $c->is_subscribed ? 'Igen' : 'Nem',
                    'Csoportok' => $c->groups->pluck('name')->join(', ') ?: null,
                    'Adományok' => $c->donation_count > 0 ? $c->donation_count . ' db / ' . number_format($c->total_donated, 0, ',', ' ') . ' Ft' : null,
                    'Megjegyzés' => $c->notes,
                ];
            @endphp
            <div style="display:flex;flex-direction:column;gap:5px">
                @foreach($fields as $label => $value)
                @if($value)
                <div style="display:flex;gap:8px;font-size:0.8rem">
                    <span style="color:#adb5bd;min-width:80px;flex-shrink:0">{{ $label }}</span>
                    <span style="color:#343a40;word-break:break-word">{{ $value }}</span>
                </div>
                @endif
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>
@endforeach

@endif

{{-- ── MERGE MODAL ──────────────────────────────────────── --}}
<div id="modal-merge" class="nf-overlay" onclick="if(event.target===this)closeModal('modal-merge')">
    <div class="nf-modal" style="max-width:560px">
        <div class="nf-modal-header">
            <span class="nf-modal-title">Kapcsolatok összevonása</span>
            <button class="nf-modal-close" onclick="closeModal('modal-merge')">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="nf-modal-body">
            <p style="font-size:0.8125rem;color:#6c757d;margin-bottom:16px;line-height:1.6">
                Válaszd ki, melyik kapcsolatot tartod meg. Az üres mezők automatikusan feltöltődnek a másik kapcsolat adataival. Az adományok, esemény-regisztrációk és csoportok átkerülnek a megtartott kapcsolathoz.
            </p>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                {{-- Keep A --}}
                <form method="POST" action="{{ route('admin.people.merge') }}" id="merge-form-a">
                    @csrf
                    <input type="hidden" name="master_id" id="merge-master-a">
                    <input type="hidden" name="duplicate_id" id="merge-dupe-a">
                    <button type="submit" id="merge-btn-a"
                        style="width:100%;padding:14px 10px;border:2px solid #405189;border-radius:8px;background:#fff;cursor:pointer;text-align:left;transition:background 0.15s"
                        onmouseover="this.style.background='#f0f3ff'" onmouseout="this.style.background='#fff'"
                        onclick="return confirm('Összevonja a két kapcsolatot? A nem megtartott kapcsolat törlődik.')">
                        <div style="font-size:0.7rem;font-weight:700;color:#405189;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:6px">← Ezt tartom meg</div>
                        <div id="merge-a-name" style="font-weight:600;color:#343a40;font-size:0.875rem"></div>
                        <div id="merge-a-detail" style="font-size:0.75rem;color:#6c757d;margin-top:2px"></div>
                    </button>
                </form>

                {{-- Keep B --}}
                <form method="POST" action="{{ route('admin.people.merge') }}" id="merge-form-b">
                    @csrf
                    <input type="hidden" name="master_id" id="merge-master-b">
                    <input type="hidden" name="duplicate_id" id="merge-dupe-b">
                    <button type="submit" id="merge-btn-b"
                        style="width:100%;padding:14px 10px;border:2px solid #0ab39c;border-radius:8px;background:#fff;cursor:pointer;text-align:right;transition:background 0.15s"
                        onmouseover="this.style.background='#f0fffe'" onmouseout="this.style.background='#fff'"
                        onclick="return confirm('Összevonja a két kapcsolatot? A nem megtartott kapcsolat törlődik.')">
                        <div style="font-size:0.7rem;font-weight:700;color:#0ab39c;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:6px">Ezt tartom meg →</div>
                        <div id="merge-b-name" style="font-weight:600;color:#343a40;font-size:0.875rem"></div>
                        <div id="merge-b-detail" style="font-size:0.75rem;color:#6c757d;margin-top:2px"></div>
                    </button>
                </form>
            </div>

            <div style="margin-top:12px;padding:10px 12px;background:#fff8f0;border:1px solid #fde8d0;border-radius:6px;font-size:0.78rem;color:#b45309">
                <strong>Figyelem:</strong> Az összevonás nem vonható vissza. A duplikáció alapja (email/telefon/név egyezés) is feloldódik.
            </div>
        </div>
        <div class="nf-modal-footer">
            <button type="button" class="btn-ghost" onclick="closeModal('modal-merge')">Mégse</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
const pairData = @json($pairs->map(fn($p) => [
    'a' => ['id' => $p['a']->id, 'name' => $p['a']->last_name . ' ' . $p['a']->first_name, 'detail' => $p['a']->email ?: ($p['a']->phone ?: $p['a']->city)],
    'b' => ['id' => $p['b']->id, 'name' => $p['b']->last_name . ' ' . $p['b']->first_name, 'detail' => $p['b']->email ?: ($p['b']->phone ?: $p['b']->city)],
])->values());

function openMergeModal(idA, idB, idx) {
    const pair = pairData[idx];
    document.getElementById('merge-a-name').textContent   = pair.a.name;
    document.getElementById('merge-a-detail').textContent = pair.a.detail ?? '';
    document.getElementById('merge-b-name').textContent   = pair.b.name;
    document.getElementById('merge-b-detail').textContent = pair.b.detail ?? '';

    // "Keep A" → master=A, dupe=B
    document.getElementById('merge-master-a').value = pair.a.id;
    document.getElementById('merge-dupe-a').value   = pair.b.id;
    // "Keep B" → master=B, dupe=A
    document.getElementById('merge-master-b').value = pair.b.id;
    document.getElementById('merge-dupe-b').value   = pair.a.id;

    openModal('modal-merge');
}
</script>
@endpush

@endsection
