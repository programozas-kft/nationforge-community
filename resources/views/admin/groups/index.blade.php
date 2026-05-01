@extends('admin.layouts.app')

@section('title', 'Csoportok')
@section('header', 'Csoportok')
@section('breadcrumb') <span style="color:#495057">Csoportok</span> @endsection

@section('header-actions')
    <a href="#" class="btn-primary" onclick="openModal('modal-create');return false;">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        Új csoport
    </a>
@endsection

@section('content')
<div class="nf-card" style="overflow:hidden">
    <table class="nf-table">
        <thead>
            <tr>
                <th>Csoport neve</th>
                <th>Típus</th>
                <th>Láthatóság</th>
                <th>Státusz</th>
                <th style="width:100px"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($groups as $group)
            <tr onclick="openGroupEditRow(this)"
                style="cursor:pointer"
                onmouseover="this.style.background='#f8f9ff'"
                onmouseout="this.style.background=''"
                data-id="{{ $group->id }}"
                data-name="{{ $group->name }}"
                data-type="{{ $group->type }}"
                data-privacy="{{ $group->privacy }}"
                data-active="{{ $group->is_active ? '1' : '0' }}"
                data-desc="{{ $group->description ?? '' }}">
                <td>
                    <span style="font-weight:500;color:#343a40">{{ $group->name }}</span>
                </td>
                <td><span class="nf-badge badge-purple">{{ $group->type }}</span></td>
                <td><span class="nf-badge badge-secondary">{{ $group->privacy }}</span></td>
                <td>
                    <span class="nf-badge {{ $group->is_active ? 'badge-success' : 'badge-secondary' }}">
                        {{ $group->is_active ? 'Aktív' : 'Inaktív' }}
                    </span>
                </td>
                <td style="text-align:right" onclick="event.stopPropagation()">
                    <a href="{{ route('admin.groups.show', $group) }}"
                       style="background:none;border:none;cursor:pointer;color:#0ab39c;margin-right:4px;text-decoration:none;display:inline-flex;align-items:center" title="Megnyitás">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </a>
                    <button onclick="openGroupEditRow(this.closest('tr'))"
                        style="background:none;border:none;cursor:pointer;color:#405189;margin-right:6px" title="Szerkesztés">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </button>
                    <form method="POST" action="{{ route('admin.groups.destroy', $group) }}" style="display:inline" onsubmit="return confirm('Biztosan törli?')">
                        @csrf @method('DELETE')
                        <button type="submit" style="background:none;border:none;cursor:pointer;color:#f06548" title="Törlés">
                            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;padding:40px;color:#adb5bd">Nincs még csoport.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($groups->hasPages())
    <div style="padding:12px 16px;border-top:1px solid #e9ebec">{{ $groups->links() }}</div>
    @endif
</div>

{{-- CREATE MODAL --}}
<div id="modal-create" class="nf-overlay" onclick="if(event.target===this)closeModal('modal-create')">
    <div class="nf-modal">
        <div class="nf-modal-header">
            <span class="nf-modal-title">Új csoport</span>
            <button class="nf-modal-close" onclick="closeModal('modal-create')">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.groups.store') }}">
            @csrf
            <div class="nf-modal-body" style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
                <div style="grid-column:span 2">
                    <label class="nf-label">Csoport neve <span style="color:#f06548">*</span></label>
                    <input type="text" name="name" class="nf-input" required>
                </div>
                <div>
                    <label class="nf-label">Típus <span style="color:#f06548">*</span></label>
                    <select name="type" class="nf-select">
                        @foreach(['community','campaign','chapter','committee','team'] as $t)
                        <option value="{{ $t }}">{{ ucfirst($t) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="nf-label">Láthatóság <span style="color:#f06548">*</span></label>
                    <select name="privacy" class="nf-select">
                        @foreach(['public','private','secret'] as $p)
                        <option value="{{ $p }}">{{ ucfirst($p) }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="grid-column:span 2">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" checked style="width:15px;height:15px;accent-color:#405189">
                        <span class="nf-label" style="margin:0">Aktív csoport</span>
                    </label>
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">Leírás</label>
                    <textarea name="description" rows="3" class="nf-input" style="resize:none"></textarea>
                </div>
            </div>
            <div class="nf-modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('modal-create')">Mégse</button>
                <button type="submit" class="btn-teal">Létrehozás</button>
            </div>
        </form>
    </div>
</div>

{{-- EDIT MODAL --}}
<div id="modal-edit" class="nf-overlay" onclick="if(event.target===this)closeModal('modal-edit')">
    <div class="nf-modal">
        <div class="nf-modal-header">
            <span class="nf-modal-title">Csoport szerkesztése</span>
            <button class="nf-modal-close" onclick="closeModal('modal-edit')">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="edit-group-form" method="POST" action="" data-base="{{ url('admin/groups') }}">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="nf-modal-body" style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
                <div style="grid-column:span 2">
                    <label class="nf-label">Csoport neve <span style="color:#f06548">*</span></label>
                    <input type="text" name="name" id="g_name" class="nf-input" required>
                </div>
                <div>
                    <label class="nf-label">Típus</label>
                    <select name="type" id="g_type" class="nf-select">
                        @foreach(['community','campaign','chapter','committee','team'] as $t)
                        <option value="{{ $t }}">{{ ucfirst($t) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="nf-label">Láthatóság</label>
                    <select name="privacy" id="g_privacy" class="nf-select">
                        @foreach(['public','private','secret'] as $p)
                        <option value="{{ $p }}">{{ ucfirst($p) }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="grid-column:span 2">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" id="g_active" value="1" style="width:15px;height:15px;accent-color:#405189">
                        <span class="nf-label" style="margin:0">Aktív csoport</span>
                    </label>
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">Leírás</label>
                    <textarea name="description" id="g_desc" rows="3" class="nf-input" style="resize:none"></textarea>
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
function openGroupEditRow(el) {
    const d = el.dataset;
    const form = document.getElementById('edit-group-form');
    form.action = form.dataset.base + '/' + d.id;
    document.getElementById('g_name').value     = d.name;
    document.getElementById('g_type').value     = d.type;
    document.getElementById('g_privacy').value  = d.privacy;
    document.getElementById('g_active').checked = d.active === '1';
    document.getElementById('g_desc').value     = d.desc;
    openModal('modal-edit');
}
</script>
@endpush
@endsection
