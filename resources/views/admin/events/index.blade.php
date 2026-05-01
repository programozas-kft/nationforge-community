@extends('admin.layouts.app')

@section('title', 'Események')
@section('header', 'Események')
@section('breadcrumb') <span style="color:#495057">Események</span> @endsection

@section('header-actions')
    <a href="#" class="btn-primary" onclick="openModal('modal-create');return false;">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        Új esemény
    </a>
@endsection

@section('content')
<div class="nf-card" style="overflow:hidden">
    <table class="nf-table">
        <thead>
            <tr>
                <th>Esemény</th>
                <th>Típus</th>
                <th>Státusz</th>
                <th>Kezdés</th>
                <th>Helyszín</th>
                <th style="width:100px"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
            <tr>
                <td>
                    <a href="{{ route('admin.events.show', $event) }}" style="font-weight:500;color:#343a40;text-decoration:none" onmouseover="this.style.color='#405189'" onmouseout="this.style.color='#343a40'">
                        {{ $event->title }}
                    </a>
                </td>
                <td><span class="nf-badge badge-info">{{ $event->type }}</span></td>
                <td>
                    @php $sc=['draft'=>'badge-secondary','published'=>'badge-success','cancelled'=>'badge-danger','completed'=>'badge-primary']; @endphp
                    <span class="nf-badge {{ $sc[$event->status] ?? 'badge-secondary' }}">{{ $event->status }}</span>
                </td>
                <td style="color:#6c757d">{{ $event->starts_at->format('d M, Y H:i') }}</td>
                <td style="color:#6c757d">{{ $event->is_online ? 'Online' : ($event->city ?? $event->venue_name ?? '—') }}</td>
                <td style="text-align:right">
                    <button
                        onclick="openEventEdit(
                            {{ $event->id }},
                            @json($event->title),
                            '{{ $event->type }}',
                            '{{ $event->status }}',
                            '{{ $event->starts_at->format('Y-m-d\TH:i') }}',
                            '{{ $event->ends_at?->format('Y-m-d\TH:i') ?? '' }}',
                            {{ $event->is_online ? 'true' : 'false' }},
                            @json($event->online_url ?? ''),
                            @json($event->venue_name ?? ''),
                            @json($event->city ?? ''),
                            @json($event->address ?? ''),
                            '{{ $event->capacity ?? '' }}',
                            '{{ $event->ticket_price ?? '' }}',
                            @json($event->description ?? '')
                        )"
                        style="background:none;border:none;cursor:pointer;color:#405189;margin-right:6px" title="Szerkesztés">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </button>
                    <form method="POST" action="{{ route('admin.events.destroy', $event) }}" style="display:inline" onsubmit="return confirm('Biztosan törli?')">
                        @csrf @method('DELETE')
                        <button type="submit" style="background:none;border:none;cursor:pointer;color:#f06548" title="Törlés">
                            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;padding:40px;color:#adb5bd">Nincs még esemény.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($events->hasPages())
    <div style="padding:12px 16px;border-top:1px solid #e9ebec">{{ $events->links() }}</div>
    @endif
</div>

{{-- ── CREATE MODAL ─────────────────────────────────── --}}
<div id="modal-create" class="nf-overlay" onclick="if(event.target===this)closeModal('modal-create')">
    <div class="nf-modal nf-modal-lg">
        <div class="nf-modal-header">
            <span class="nf-modal-title">Új esemény</span>
            <button class="nf-modal-close" onclick="closeModal('modal-create')">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.events.store') }}">
            @csrf
            <div class="nf-modal-body" style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
                <div style="grid-column:span 2">
                    <label class="nf-label">Cím <span style="color:#f06548">*</span></label>
                    <input type="text" name="title" class="nf-input" required>
                </div>
                <div>
                    <label class="nf-label">Típus <span style="color:#f06548">*</span></label>
                    <select name="type" class="nf-select">
                        @foreach(['meetup','rally','webinar','fundraiser','volunteer','conference','other'] as $t)
                        <option value="{{ $t }}">{{ ucfirst($t) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="nf-label">Státusz <span style="color:#f06548">*</span></label>
                    <select name="status" class="nf-select">
                        @foreach(['draft','published','cancelled','completed'] as $s)
                        <option value="{{ $s }}">{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="nf-label">Kezdés <span style="color:#f06548">*</span></label>
                    <input type="datetime-local" name="starts_at" class="nf-input" required>
                </div>
                <div>
                    <label class="nf-label">Befejezés</label>
                    <input type="datetime-local" name="ends_at" class="nf-input">
                </div>
                <div style="grid-column:span 2">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                        <input type="hidden" name="is_online" value="0">
                        <input type="checkbox" name="is_online" value="1" style="width:15px;height:15px;accent-color:#0ab39c">
                        <span class="nf-label" style="margin:0">Online esemény</span>
                    </label>
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">Online URL</label>
                    <input type="url" name="online_url" class="nf-input" placeholder="https://...">
                </div>
                <div>
                    <label class="nf-label">Helyszín neve</label>
                    <input type="text" name="venue_name" class="nf-input">
                </div>
                <div>
                    <label class="nf-label">Város</label>
                    <input type="text" name="city" class="nf-input">
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">Cím / Utca</label>
                    <input type="text" name="address" class="nf-input">
                </div>
                <div>
                    <label class="nf-label">Kapacitás (fő)</label>
                    <input type="number" name="capacity" min="1" class="nf-input">
                </div>
                <div>
                    <label class="nf-label">Jegyár (Ft)</label>
                    <input type="number" name="ticket_price" min="0" step="0.01" class="nf-input">
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">Leírás</label>
                    <textarea name="description" rows="2" class="nf-input" style="resize:none"></textarea>
                </div>
            </div>
            <div class="nf-modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('modal-create')">Mégse</button>
                <button type="submit" class="btn-teal">Létrehozás</button>
            </div>
        </form>
    </div>
</div>

{{-- ── EDIT MODAL ───────────────────────────────────── --}}
<div id="modal-edit" class="nf-overlay" onclick="if(event.target===this)closeModal('modal-edit')">
    <div class="nf-modal nf-modal-lg">
        <div class="nf-modal-header">
            <span class="nf-modal-title">Esemény szerkesztése</span>
            <button class="nf-modal-close" onclick="closeModal('modal-edit')">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="edit-event-form" method="POST" action="" data-base="{{ url('admin/events') }}">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="nf-modal-body" style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
                <div style="grid-column:span 2">
                    <label class="nf-label">Cím <span style="color:#f06548">*</span></label>
                    <input type="text" id="ev_title" name="title" class="nf-input" required>
                </div>
                <div>
                    <label class="nf-label">Típus</label>
                    <select id="ev_type" name="type" class="nf-select">
                        @foreach(['meetup','rally','webinar','fundraiser','volunteer','conference','other'] as $t)
                        <option value="{{ $t }}">{{ ucfirst($t) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="nf-label">Státusz</label>
                    <select id="ev_status" name="status" class="nf-select">
                        @foreach(['draft','published','cancelled','completed'] as $s)
                        <option value="{{ $s }}">{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="nf-label">Kezdés <span style="color:#f06548">*</span></label>
                    <input type="datetime-local" id="ev_starts" name="starts_at" class="nf-input" required>
                </div>
                <div>
                    <label class="nf-label">Befejezés</label>
                    <input type="datetime-local" id="ev_ends" name="ends_at" class="nf-input">
                </div>
                <div style="grid-column:span 2">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                        <input type="hidden" name="is_online" value="0">
                        <input type="checkbox" id="ev_online" name="is_online" value="1" style="width:15px;height:15px;accent-color:#0ab39c">
                        <span class="nf-label" style="margin:0">Online esemény</span>
                    </label>
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">Online URL</label>
                    <input type="url" id="ev_url" name="online_url" class="nf-input" placeholder="https://...">
                </div>
                <div>
                    <label class="nf-label">Helyszín neve</label>
                    <input type="text" id="ev_venue" name="venue_name" class="nf-input">
                </div>
                <div>
                    <label class="nf-label">Város</label>
                    <input type="text" id="ev_city" name="city" class="nf-input">
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">Cím / Utca</label>
                    <input type="text" id="ev_address" name="address" class="nf-input">
                </div>
                <div>
                    <label class="nf-label">Kapacitás (fő)</label>
                    <input type="number" id="ev_capacity" name="capacity" min="1" class="nf-input">
                </div>
                <div>
                    <label class="nf-label">Jegyár (Ft)</label>
                    <input type="number" id="ev_price" name="ticket_price" min="0" step="0.01" class="nf-input">
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">Leírás</label>
                    <textarea id="ev_desc" name="description" rows="2" class="nf-input" style="resize:none"></textarea>
                </div>
            </div>
            <div class="nf-modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('modal-edit')">Mégse</button>
                <button type="submit" class="btn-teal">Mentés</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openEventEdit(id, title, type, status, starts, ends, online, url, venue, city, address, cap, price, desc) {
    const form = document.getElementById('edit-event-form');
    form.action = form.dataset.base + '/' + id;
    document.getElementById('ev_title').value    = title;
    document.getElementById('ev_type').value     = type;
    document.getElementById('ev_status').value   = status;
    document.getElementById('ev_starts').value   = starts;
    document.getElementById('ev_ends').value     = ends;
    document.getElementById('ev_online').checked = online;
    document.getElementById('ev_url').value      = url;
    document.getElementById('ev_venue').value    = venue;
    document.getElementById('ev_city').value     = city;
    document.getElementById('ev_address').value  = address;
    document.getElementById('ev_capacity').value = cap;
    document.getElementById('ev_price').value    = price;
    document.getElementById('ev_desc').value     = desc;
    openModal('modal-edit');
}
</script>
@endpush
@endsection
