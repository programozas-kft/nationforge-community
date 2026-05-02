@extends('admin.layouts.app')

@section('title', 'Kapcsolatok')
@section('header', 'Kapcsolatok')
@section('breadcrumb') <span style="color:#495057">Kapcsolatok</span> @endsection

@section('header-actions')
    <a href="#" class="btn-primary" onclick="openModal('modal-create');return false;">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        Új kapcsolat
    </a>
@endsection

@section('content')
<div class="nf-card" style="overflow:hidden">
    <table class="nf-table">
        <thead>
            <tr>
                <th style="width:40px"></th>
                <th>Név</th>
                <th>Email</th>
                <th>Telefon</th>
                <th>Státusz</th>
                <th>Város</th>
                <th>Regisztrált</th>
                <th style="width:80px"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($people as $person)
            @php
                $editArgs = implode(',', [
                    $person->id,
                    json_encode($person->first_name),
                    json_encode($person->last_name),
                    json_encode($person->email ?? ''),
                    json_encode($person->phone ?? ''),
                    json_encode($person->city ?? ''),
                    "'{$person->status}'",
                    $person->is_subscribed ? 'true' : 'false',
                    json_encode($person->source ?? ''),
                    json_encode($person->notes ?? ''),
                    json_encode($person->photo ? asset('storage/' . $person->photo) : ''),
                    json_encode($person->groups->pluck('id')->toArray()),
                ]);
            @endphp
            <tr onclick="openEdit({{ $editArgs }})"
                style="cursor:pointer"
                onmouseover="this.style.background='#f8f9ff'"
                onmouseout="this.style.background=''">
                <td onclick="event.stopPropagation()">
                    <div style="width:34px;height:34px;border-radius:50%;overflow:hidden;flex-shrink:0;background:linear-gradient(135deg,#405189,#7a5af8);display:flex;align-items:center;justify-content:center;">
                        @if($person->photo)
                            <img src="{{ asset('storage/' . $person->photo) }}" style="width:34px;height:34px;object-fit:cover;display:block;flex-shrink:0">
                        @else
                            <span style="color:#fff;font-size:0.75rem;font-weight:700">{{ strtoupper(substr($person->first_name,0,1)) }}</span>
                        @endif
                    </div>
                </td>
                <td style="font-weight:500;color:#343a40">{{ $person->last_name }} {{ $person->first_name }}</td>
                <td style="color:#6c757d">{{ $person->email ?? '—' }}</td>
                <td style="color:#6c757d">{{ $person->phone ?? '—' }}</td>
                <td>
                    @php
                        $sc=['member'=>'badge-primary','supporter'=>'badge-success','donor'=>'badge-warning','volunteer'=>'badge-info','vip'=>'badge-purple','prospect'=>'badge-secondary','inactive'=>'badge-secondary'];
                        $sl=['prospect'=>'Érdeklődő','supporter'=>'Támogató','member'=>'Tag','volunteer'=>'Önkéntes','donor'=>'Adományozó','vip'=>'VIP','inactive'=>'Inaktív'];
                    @endphp
                    <span class="nf-badge {{ $sc[$person->status] ?? 'badge-secondary' }}">{{ $sl[$person->status] ?? $person->status }}</span>
                </td>
                <td style="color:#6c757d">{{ $person->city ?? '—' }}</td>
                <td style="color:#adb5bd">{{ $person->created_at->format('d M, Y') }}</td>
                <td style="text-align:right" onclick="event.stopPropagation()">
                    <button onclick="openEdit({{ $editArgs }})"
                            style="background:none;border:none;cursor:pointer;color:#405189;margin-right:6px" title="Szerkesztés">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </button>
                    <form method="POST" action="{{ route('admin.people.destroy', $person) }}" style="display:inline" onsubmit="return confirm('Biztosan törli?')">
                        @csrf @method('DELETE')
                        <button type="submit" style="background:none;border:none;cursor:pointer;color:#f06548" title="Törlés">
                            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;padding:40px;color:#adb5bd">Nincs még kapcsolat.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($people->hasPages())
    <div style="padding:12px 16px;border-top:1px solid #e9ebec">{{ $people->links() }}</div>
    @endif
</div>

{{-- ── CREATE MODAL ─────────────────────────────────── --}}
<div id="modal-create" class="nf-overlay" onclick="if(event.target===this)closeModal('modal-create')">
    <div class="nf-modal">
        <div class="nf-modal-header">
            <span class="nf-modal-title">Új kapcsolat</span>
            <button class="nf-modal-close" onclick="closeModal('modal-create')">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.people.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="nf-modal-body" style="display:grid;grid-template-columns:1fr 1fr;gap:14px">

                {{-- Fotó feltöltő --}}
                <div style="grid-column:span 2;display:flex;align-items:center;gap:16px">
                    <div id="c-preview-wrap" style="width:64px;height:64px;border-radius:50%;overflow:hidden;background:linear-gradient(135deg,#405189,#7a5af8);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <svg id="c-preview-icon" width="28" height="28" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <img id="c-preview-img" src="" style="width:100%;height:100%;object-fit:cover;display:none">
                    </div>
                    <div>
                        <label class="nf-label" style="margin-bottom:6px">Profilkép</label>
                        <label style="display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border:1px solid #ced4da;border-radius:5px;cursor:pointer;font-size:0.8rem;color:#495057;background:#fff">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            Kép feltöltése
                            <input type="file" name="photo" accept="image/*" style="display:none" onchange="previewPhoto(this,'c-preview-img','c-preview-icon')">
                        </label>
                        <p style="font-size:0.7rem;color:#adb5bd;margin-top:4px">JPG, PNG, max 2MB</p>
                    </div>
                </div>

                <div>
                    <label class="nf-label">Vezetéknév <span style="color:#f06548">*</span></label>
                    <input type="text" name="last_name" class="nf-input" required>
                </div>
                <div>
                    <label class="nf-label">Keresztnév <span style="color:#f06548">*</span></label>
                    <input type="text" name="first_name" class="nf-input" required>
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">Email</label>
                    <input type="email" name="email" class="nf-input">
                </div>
                <div>
                    <label class="nf-label">Telefon</label>
                    <input type="text" name="phone" class="nf-input">
                </div>
                <div>
                    <label class="nf-label">Város</label>
                    <input type="text" name="city" class="nf-input">
                </div>
                <div>
                    <label class="nf-label">Státusz <span style="color:#f06548">*</span></label>
                    <select name="status" class="nf-select">
                        @foreach(['prospect'=>'Érdeklődő','supporter'=>'Támogató','member'=>'Tag','volunteer'=>'Önkéntes','donor'=>'Adományozó','vip'=>'VIP','inactive'=>'Inaktív'] as $val=>$label)
                        <option value="{{ $val }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="nf-label">Forrás</label>
                    <input type="text" name="source" class="nf-input">
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">Csoportok</label>
                    <select name="groups[]" class="nf-input" multiple size="4" style="padding: 8px;">
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                    <p style="font-size:0.7rem;color:#adb5bd;margin-top:4px">Több kiválasztásához tartsd lenyomva a Ctrl/Cmd gombot.</p>
                </div>
                <div style="grid-column:span 2">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                        <input type="hidden" name="is_subscribed" value="0">
                        <input type="checkbox" name="is_subscribed" value="1" style="width:15px;height:15px;accent-color:#405189">
                        <span class="nf-label" style="margin:0">Hírlevél feliratkozó</span>
                    </label>
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">Megjegyzés</label>
                    <textarea name="notes" rows="2" class="nf-input" style="resize:none"></textarea>
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
    <div class="nf-modal">
        <div class="nf-modal-header">
            <span class="nf-modal-title">Kapcsolat szerkesztése</span>
            <button class="nf-modal-close" onclick="closeModal('modal-edit')">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="edit-form" method="POST" action="" enctype="multipart/form-data"
              data-base="{{ url('admin/people') }}">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="nf-modal-body" style="display:grid;grid-template-columns:1fr 1fr;gap:14px">

                {{-- Fotó --}}
                <div style="grid-column:span 2;display:flex;align-items:center;gap:16px">
                    <div style="width:64px;height:64px;border-radius:50%;overflow:hidden;background:linear-gradient(135deg,#405189,#7a5af8);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <svg id="e-preview-icon" width="28" height="28" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <img id="e-preview-img" src="" style="width:100%;height:100%;object-fit:cover;display:none">
                    </div>
                    <div>
                        <label class="nf-label" style="margin-bottom:6px">Profilkép módosítása</label>
                        <label style="display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border:1px solid #ced4da;border-radius:5px;cursor:pointer;font-size:0.8rem;color:#495057;background:#fff">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            Új kép feltöltése
                            <input type="file" name="photo" accept="image/*" style="display:none" onchange="previewPhoto(this,'e-preview-img','e-preview-icon')">
                        </label>
                        <p style="font-size:0.7rem;color:#adb5bd;margin-top:4px">Hagyd üresen ha nem változtatod</p>
                    </div>
                </div>

                <div>
                    <label class="nf-label">Vezetéknév <span style="color:#f06548">*</span></label>
                    <input type="text" name="last_name" id="e_last" class="nf-input" required>
                </div>
                <div>
                    <label class="nf-label">Keresztnév <span style="color:#f06548">*</span></label>
                    <input type="text" name="first_name" id="e_first" class="nf-input" required>
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">Email</label>
                    <input type="email" name="email" id="e_email" class="nf-input">
                </div>
                <div>
                    <label class="nf-label">Telefon</label>
                    <input type="text" name="phone" id="e_phone" class="nf-input">
                </div>
                <div>
                    <label class="nf-label">Város</label>
                    <input type="text" name="city" id="e_city" class="nf-input">
                </div>
                <div>
                    <label class="nf-label">Státusz</label>
                    <select name="status" id="e_status" class="nf-select">
                        @foreach(['prospect'=>'Érdeklődő','supporter'=>'Támogató','member'=>'Tag','volunteer'=>'Önkéntes','donor'=>'Adományozó','vip'=>'VIP','inactive'=>'Inaktív'] as $val=>$label)
                        <option value="{{ $val }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="nf-label">Forrás</label>
                    <input type="text" name="source" id="e_source" class="nf-input">
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">Csoportok</label>
                    <select name="groups[]" id="e_groups" class="nf-input" multiple size="4" style="padding: 8px;">
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                    <p style="font-size:0.7rem;color:#adb5bd;margin-top:4px">Több kiválasztásához tartsd lenyomva a Ctrl/Cmd gombot.</p>
                </div>
                <div style="grid-column:span 2">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                        <input type="hidden" name="is_subscribed" value="0">
                        <input type="checkbox" name="is_subscribed" id="e_subscribed" value="1" style="width:15px;height:15px;accent-color:#405189">
                        <span class="nf-label" style="margin:0">Hírlevél feliratkozó</span>
                    </label>
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">Megjegyzés</label>
                    <textarea name="notes" id="e_notes" rows="2" class="nf-input" style="resize:none"></textarea>
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
function previewPhoto(input, imgId, iconId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const img  = document.getElementById(imgId);
            const icon = document.getElementById(iconId);
            img.src = e.target.result;
            img.style.display = 'block';
            if (icon) icon.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function openEdit(id, first, last, email, phone, city, status, subscribed, source, notes, photoUrl, groupIds = []) {
    const form = document.getElementById('edit-form');
    form.action = form.dataset.base + '/' + id;
    document.getElementById('e_first').value      = first;
    document.getElementById('e_last').value       = last;
    document.getElementById('e_email').value      = email;
    document.getElementById('e_phone').value      = phone;
    document.getElementById('e_city').value       = city;
    document.getElementById('e_status').value     = status;
    document.getElementById('e_source').value     = source;
    document.getElementById('e_notes').value      = notes;
    document.getElementById('e_subscribed').checked = subscribed;

    const select = document.getElementById('e_groups');
    if (select) {
        Array.from(select.options).forEach(opt => {
            opt.selected = groupIds.includes(parseInt(opt.value));
        });
    }

    const img  = document.getElementById('e-preview-img');
    const icon = document.getElementById('e-preview-icon');
    if (photoUrl) {
        img.src = photoUrl;
        img.style.display = 'block';
        icon.style.display = 'none';
    } else {
        img.style.display = 'none';
        icon.style.display = 'block';
    }

    openModal('modal-edit');
}
</script>
@endpush
@endsection
