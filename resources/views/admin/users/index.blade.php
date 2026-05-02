@extends('admin.layouts.app')

@section('title', 'Felhasználók')
@section('header', 'Felhasználók')
@section('breadcrumb')
    <span style="color:#495057">Admin</span>
    <span style="color:#dee2e6">/</span>
    <span style="color:#495057">Felhasználók</span>
@endsection

@section('header-actions')
    <a href="#" class="btn-primary" onclick="openModal('modal-create');return false;">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        Új felhasználó
    </a>
@endsection

@section('content')
<div class="nf-card" style="overflow:hidden">
    <table class="nf-table">
        <thead>
            <tr>
                <th style="width:50px">Kép</th>
                <th>Név</th>
                <th>Email</th>
                <th>Szerepkör</th>
                <th>Regisztrált</th>
                <th style="width:80px"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            @php
                $uArgs = implode(',', [
                    $user->id,
                    json_encode($user->name),
                    json_encode($user->email),
                    json_encode($user->roles->first()?->name ?? ''),
                    json_encode($user->photo ? asset('storage/' . $user->photo) : ''),
                ]);
            @endphp
            <tr onclick="openEditUser({{ $uArgs }})"
                style="cursor:pointer"
                onmouseover="this.style.background='#f8f9ff'" onmouseout="this.style.background=''">
                <td>
                    @if($user->photo)
                        <div style="width:34px;height:34px;border-radius:50%;overflow:hidden;flex-shrink:0">
                            <img src="{{ asset('storage/' . $user->photo) }}" style="width:100%;height:100%;object-fit:cover" alt="">
                        </div>
                    @else
                        <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,#f97316,#ea580c);display:flex;align-items:center;justify-content:center;color:#fff;font-size:0.75rem;font-weight:700;flex-shrink:0">
                            {{ strtoupper(substr($user->name,0,1)) }}
                        </div>
                    @endif
                </td>
                <td>
                    <div style="display:flex;align-items:center;gap:8px">
                        <span style="font-weight:500;color:#343a40">{{ $user->name }}</span>
                        @if($user->id === auth()->id())
                            <span class="nf-badge badge-info" style="font-size:0.6rem">Te</span>
                        @endif
                    </div>
                </td>
                <td style="color:#6c757d">{{ $user->email }}</td>
                <td>
                    @php $roleColors=['super-admin'=>'badge-danger','admin'=>'badge-primary','editor'=>'badge-warning','member'=>'badge-secondary']; @endphp
                    @foreach($user->roles as $role)
                        <span class="nf-badge {{ $roleColors[$role->name] ?? 'badge-secondary' }}">{{ $role->name }}</span>
                    @endforeach
                </td>
                <td style="color:#adb5bd">{{ $user->created_at->format('d M, Y') }}</td>
                <td style="text-align:right" onclick="event.stopPropagation()">
                    @if($user->id !== auth()->id())
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display:inline"
                          onsubmit="return confirm('Biztosan törli a felhasználót?')">
                        @csrf @method('DELETE')
                        <button type="submit" style="background:none;border:none;cursor:pointer;color:#f06548" title="Törlés">
                            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;padding:40px;color:#adb5bd">Nincs felhasználó.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- CREATE MODAL --}}
<div id="modal-create" class="nf-overlay" onclick="if(event.target===this)closeModal('modal-create')">
    <div class="nf-modal">
        <div class="nf-modal-header">
            <span class="nf-modal-title">Új felhasználó</span>
            <button class="nf-modal-close" onclick="closeModal('modal-create')">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="nf-modal-body" style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
                <div style="grid-column:span 2;display:flex;flex-direction:column;align-items:center;gap:10px">
                    <div id="c_photo_preview" style="width:72px;height:72px;border-radius:50%;overflow:hidden;background:linear-gradient(135deg,#f97316,#ea580c);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.5rem;font-weight:700">
                        <span id="c_photo_initial">?</span>
                        <img id="c_photo_img" src="" style="width:100%;height:100%;object-fit:cover;display:none" alt="">
                    </div>
                    <label style="cursor:pointer;font-size:0.78rem;color:#0ab39c;font-weight:500">
                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="vertical-align:middle;margin-right:3px"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        Kép feltöltése
                        <input type="file" name="photo" accept="image/*" style="display:none" onchange="previewUserPhoto(this,'c')">
                    </label>
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">Teljes név <span style="color:#f06548">*</span></label>
                    <input type="text" name="name" id="c_name" class="nf-input" required oninput="updateInitial('c',this.value)">
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">Email <span style="color:#f06548">*</span></label>
                    <input type="email" name="email" class="nf-input" required>
                </div>
                <div>
                    <label class="nf-label">Jelszó <span style="color:#f06548">*</span></label>
                    <input type="password" name="password" class="nf-input" required>
                </div>
                <div>
                    <label class="nf-label">Jelszó megerősítés <span style="color:#f06548">*</span></label>
                    <input type="password" name="password_confirmation" class="nf-input" required>
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">Szerepkör <span style="color:#f06548">*</span></label>
                    <select name="role" class="nf-select" required>
                        @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
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
            <span class="nf-modal-title">Felhasználó szerkesztése</span>
            <button class="nf-modal-close" onclick="closeModal('modal-edit')">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="edit-user-form" method="POST" action="" data-base="{{ url('admin/users') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="nf-modal-body" style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
                <div style="grid-column:span 2;display:flex;flex-direction:column;align-items:center;gap:10px">
                    <div id="e_photo_preview" style="width:72px;height:72px;border-radius:50%;overflow:hidden;background:linear-gradient(135deg,#f97316,#ea580c);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.5rem;font-weight:700">
                        <span id="e_photo_initial">?</span>
                        <img id="e_photo_img" src="" style="width:100%;height:100%;object-fit:cover;display:none" alt="">
                    </div>
                    <label style="cursor:pointer;font-size:0.78rem;color:#0ab39c;font-weight:500">
                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="vertical-align:middle;margin-right:3px"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        Kép feltöltése
                        <input type="file" name="photo" accept="image/*" style="display:none" onchange="previewUserPhoto(this,'e')">
                    </label>
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">Teljes név <span style="color:#f06548">*</span></label>
                    <input type="text" name="name" id="u_name" class="nf-input" required oninput="updateInitial('e',this.value)">
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">Email <span style="color:#f06548">*</span></label>
                    <input type="email" name="email" id="u_email" class="nf-input" required>
                </div>
                <div>
                    <label class="nf-label">Új jelszó</label>
                    <input type="password" name="password" class="nf-input" placeholder="Hagyd üresen ha nem változtatod">
                </div>
                <div>
                    <label class="nf-label">Jelszó megerősítés</label>
                    <input type="password" name="password_confirmation" class="nf-input">
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">Szerepkör <span style="color:#f06548">*</span></label>
                    <select name="role" id="u_role" class="nf-select" required>
                        @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
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
function previewUserPhoto(input, prefix) {
    const img = document.getElementById(prefix + '_photo_img');
    const initial = document.getElementById(prefix + '_photo_initial');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            img.src = e.target.result;
            img.style.display = 'block';
            initial.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function updateInitial(prefix, name) {
    const initial = document.getElementById(prefix + '_photo_initial');
    const img = document.getElementById(prefix + '_photo_img');
    if (img.style.display === 'none') {
        initial.textContent = name ? name.charAt(0).toUpperCase() : '?';
    }
}

function openEditUser(id, name, email, role, photoUrl) {
    const form = document.getElementById('edit-user-form');
    form.action = form.dataset.base + '/' + id;
    document.getElementById('u_name').value  = name;
    document.getElementById('u_email').value = email;
    document.getElementById('u_role').value  = role;

    const img = document.getElementById('e_photo_img');
    const initial = document.getElementById('e_photo_initial');
    if (photoUrl) {
        img.src = photoUrl;
        img.style.display = 'block';
        initial.style.display = 'none';
    } else {
        img.src = '';
        img.style.display = 'none';
        initial.style.display = 'block';
        initial.textContent = name ? name.charAt(0).toUpperCase() : '?';
    }

    openModal('modal-edit');
}
</script>
@endpush
@endsection
