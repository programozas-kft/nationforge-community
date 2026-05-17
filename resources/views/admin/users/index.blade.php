@extends('admin.layouts.app')

@section('title', __('users.title'))
@section('header', __('users.title'))
@section('breadcrumb')
    <span style="color:#495057">{{ __('common.admin') }}</span>
    <span style="color:#dee2e6">/</span>
    <span style="color:#495057">{{ __('users.title') }}</span>
@endsection

@section('header-actions')
    <a href="#" class="btn-ghost" onclick="openModal('modal-invite');return false;" style="display:inline-flex;align-items:center;gap:5px">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        {{ __('users.invite_btn') }}
    </a>
    <a href="#" class="btn-primary" onclick="openModal('modal-create');return false;">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        {{ __('users.new') }}
    </a>
@endsection

@section('content')
<div class="nf-card" style="overflow:hidden">
    <table class="nf-table">
        <thead>
            <tr>
                <th style="width:50px">{{ __('users.col_photo') }}</th>
                <th>{{ __('users.col_name') }}</th>
                <th>{{ __('users.col_email') }}</th>
                <th>{{ __('users.col_role') }}</th>
                <th>{{ __('users.col_groups') }}</th>
                <th>{{ __('users.col_registered') }}</th>
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
                    json_encode($user->groups->pluck('id')->toArray()),
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
                            <span class="nf-badge badge-info" style="font-size:0.6rem">{{ __('users.you') }}</span>
                        @endif
                    </div>
                </td>
                <td style="color:#6c757d">{{ $user->email }}</td>
                <td>
                    @foreach($user->roles as $role)
                        <span class="nf-badge {{ ['super-admin'=>'badge-danger','admin'=>'badge-primary','editor'=>'badge-warning','member'=>'badge-secondary'][$role->name] ?? 'badge-secondary' }}">{{ __('users.roles.' . $role->name, [], null) ?: $role->name }}</span>
                    @endforeach
                </td>
                <td>
                    @forelse($user->groups as $group)
                        <span class="nf-badge badge-info" style="margin-bottom:2px">{{ $group->name }}</span>
                    @empty
                        <span style="color:#ced4da;font-size:0.75rem">—</span>
                    @endforelse
                </td>
                <td style="color:#adb5bd">{{ $user->created_at->format('d M, Y') }}</td>
                <td style="text-align:right" onclick="event.stopPropagation()">
                    @if($user->id !== auth()->id())
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display:inline"
                          onsubmit="return confirm('{{ __('common.confirm_delete') }}')">
                        @csrf @method('DELETE')
                        <button type="submit" style="background:none;border:none;cursor:pointer;color:#f06548" title="{{ __('common.delete') }}">
                            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;padding:40px;color:#adb5bd">{{ __('users.empty') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- PENDING INVITATIONS --}}
@if($invitations->isNotEmpty())
<div style="margin-top:24px">
    <p style="font-size:0.8125rem;font-weight:600;color:#343a40;margin:0 0 10px">{{ __('users.pending_invites') }}</p>
    <div class="nf-card" style="overflow:hidden">
        <table class="nf-table">
            <thead>
                <tr>
                    <th>{{ __('common.email') }}</th>
                    <th>{{ __('users.col_role') }}</th>
                    <th>{{ __('users.invite_sent_by') }}</th>
                    <th>{{ __('users.invite_expires') }}</th>
                    <th>{{ __('users.invite_status') }}</th>
                    <th style="width:110px"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($invitations as $inv)
                <tr>
                    <td style="font-weight:500;color:#343a40">{{ $inv->email }}</td>
                    <td>
                        <span class="nf-badge badge-primary">{{ ucfirst($inv->role) }}</span>
                    </td>
                    <td style="color:#6c757d;font-size:0.8rem">{{ $inv->invited_by_name ?? '—' }}</td>
                    <td style="color:#6c757d;font-size:0.8rem">{{ $inv->expires_at->format('Y.m.d') }}</td>
                    <td>
                        @if($inv->isExpired())
                            <span class="nf-badge badge-danger">{{ __('users.invite_expired') }}</span>
                        @else
                            <span class="nf-badge badge-warning">{{ __('users.invite_pending') }}</span>
                        @endif
                    </td>
                    <td style="text-align:right;display:flex;gap:6px;justify-content:flex-end;align-items:center">
                        <button onclick="copyInviteLink('{{ $inv->registrationUrl() }}')"
                            title="{{ __('users.invite_copy') }}"
                            style="background:none;border:none;cursor:pointer;color:#405189;padding:4px">
                            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        </button>
                        @if($inv->isPending())
                        <form method="POST" action="{{ route('admin.invitations.resend', $inv) }}" style="display:inline">
                            @csrf
                            <button type="submit" title="{{ __('users.invite_resend') }}"
                                style="background:none;border:none;cursor:pointer;color:#0ab39c;padding:4px">
                                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            </button>
                        </form>
                        @endif
                        <form method="POST" action="{{ route('admin.invitations.destroy', $inv) }}" style="display:inline"
                              onsubmit="return confirm('{{ __('users.invite_delete_confirm') }}')">
                            @csrf @method('DELETE')
                            <button type="submit" title="{{ __('common.delete') }}"
                                style="background:none;border:none;cursor:pointer;color:#f06548;padding:4px">
                                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- INVITE MODAL --}}
<div id="modal-invite" class="nf-overlay" onclick="if(event.target===this&&__nfMdTarget===this)closeModal('modal-invite')">
    <div class="nf-modal" style="max-width:440px">
        <div class="nf-modal-header">
            <span class="nf-modal-title">{{ __('users.invite_modal_title') }}</span>
            <button class="nf-modal-close" onclick="closeModal('modal-invite')">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.invitations.store') }}">
            @csrf
            <div class="nf-modal-body" style="display:grid;gap:14px">
                <div>
                    <label class="nf-label">{{ __('common.email') }} <span style="color:#f06548">*</span></label>
                    <input type="email" name="email" class="nf-input" required autofocus placeholder="valaki@example.com">
                    <p style="font-size:0.72rem;color:#adb5bd;margin-top:4px">{{ __('users.invite_email_hint') }}</p>
                </div>
                <div>
                    <label class="nf-label">{{ __('users.role') }} <span style="color:#f06548">*</span></label>
                    <select name="role" class="nf-select" required>
                        @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ __('users.roles.' . $role->name, [], null) ?: $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="background:#f8f9fa;border-radius:6px;padding:10px 14px;font-size:0.78rem;color:#6c757d;display:flex;gap:8px;align-items:flex-start">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ __('users.invite_info') }}
                </div>
            </div>
            <div class="nf-modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('modal-invite')">{{ __('common.cancel') }}</button>
                <button type="submit" class="btn-teal">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    {{ __('users.invite_send') }}
                </button>
            </div>
        </form>
    </div>
</div>

{{-- CREATE MODAL --}}
<div id="modal-create" class="nf-overlay" onclick="if(event.target===this&&__nfMdTarget===this)closeModal('modal-create')">
    <div class="nf-modal">
        <div class="nf-modal-header">
            <span class="nf-modal-title">{{ __('users.new') }}</span>
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
                        {{ __('users.photo_upload') }}
                        <input type="file" name="photo" accept="image/*" style="display:none" onchange="previewUserPhoto(this,'c')">
                    </label>
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">{{ __('users.full_name') }} <span style="color:#f06548">*</span></label>
                    <input type="text" name="name" id="c_name" class="nf-input" required oninput="updateInitial('c',this.value)">
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">{{ __('common.email') }} <span style="color:#f06548">*</span></label>
                    <input type="email" name="email" class="nf-input" required>
                </div>
                <div>
                    <label class="nf-label">{{ __('users.password') }} <span style="color:#f06548">*</span></label>
                    <div style="position:relative">
                        <input type="password" name="password" class="nf-input" required style="padding-right:38px">
                        <button type="button" onclick="togglePwd(this)" tabindex="-1" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#adb5bd;padding:0;line-height:0"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></button>
                    </div>
                </div>
                <div>
                    <label class="nf-label">{{ __('users.password_confirm') }} <span style="color:#f06548">*</span></label>
                    <div style="position:relative">
                        <input type="password" name="password_confirmation" class="nf-input" required style="padding-right:38px">
                        <button type="button" onclick="togglePwd(this)" tabindex="-1" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#adb5bd;padding:0;line-height:0"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></button>
                    </div>
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">{{ __('users.role') }} <span style="color:#f06548">*</span></label>
                    <select name="role" class="nf-select" required>
                        @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ __('users.roles.' . $role->name, [], null) ?: $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">{{ __('users.groups') }}</label>
                    <div class="group-chip-wrap">
                        @forelse($groups as $group)
                            <label class="group-chip">
                                <input type="checkbox" name="groups[]" value="{{ $group->id }}" onchange="this.closest('.group-chip').classList.toggle('active',this.checked)">
                                {{ $group->name }}
                            </label>
                        @empty
                            <span style="font-size:0.78rem;color:#adb5bd">{{ __('users.no_groups') }}</span>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="nf-modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('modal-create')">{{ __('common.cancel') }}</button>
                <button type="submit" class="btn-teal">{{ __('common.create') }}</button>
            </div>
        </form>
    </div>
</div>

{{-- EDIT MODAL --}}
<div id="modal-edit" class="nf-overlay" onclick="if(event.target===this&&__nfMdTarget===this)closeModal('modal-edit')">
    <div class="nf-modal">
        <div class="nf-modal-header">
            <span class="nf-modal-title">{{ __('users.edit_title') }}</span>
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
                        {{ __('users.photo_upload') }}
                        <input type="file" name="photo" accept="image/*" style="display:none" onchange="previewUserPhoto(this,'e')">
                    </label>
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">{{ __('users.full_name') }} <span style="color:#f06548">*</span></label>
                    <input type="text" name="name" id="u_name" class="nf-input" required oninput="updateInitial('e',this.value)">
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">{{ __('common.email') }} <span style="color:#f06548">*</span></label>
                    <input type="email" name="email" id="u_email" class="nf-input" required>
                </div>
                <div>
                    <label class="nf-label">{{ __('users.new_password') }}</label>
                    <div style="position:relative">
                        <input type="password" name="password" class="nf-input" placeholder="{{ __('users.password_placeholder') }}" style="padding-right:38px">
                        <button type="button" onclick="togglePwd(this)" tabindex="-1" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#adb5bd;padding:0;line-height:0"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></button>
                    </div>
                </div>
                <div>
                    <label class="nf-label">{{ __('users.password_confirm') }}</label>
                    <div style="position:relative">
                        <input type="password" name="password_confirmation" class="nf-input" style="padding-right:38px">
                        <button type="button" onclick="togglePwd(this)" tabindex="-1" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#adb5bd;padding:0;line-height:0"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></button>
                    </div>
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">{{ __('users.role') }} <span style="color:#f06548">*</span></label>
                    <select name="role" id="u_role" class="nf-select" required>
                        @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ __('users.roles.' . $role->name, [], null) ?: $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">{{ __('users.groups') }}</label>
                    <div class="group-chip-wrap" id="u_groups">
                        @forelse($groups as $group)
                            <label class="group-chip">
                                <input type="checkbox" name="groups[]" value="{{ $group->id }}" onchange="this.closest('.group-chip').classList.toggle('active',this.checked)">
                                {{ $group->name }}
                            </label>
                        @empty
                            <span style="font-size:0.78rem;color:#adb5bd">{{ __('users.no_groups') }}</span>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="nf-modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('modal-edit')">{{ __('common.cancel') }}</button>
                <button type="submit" class="btn-teal">{{ __('common.save') }}</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function copyInviteLink(url) {
    navigator.clipboard.writeText(url).then(() => {
        const tip = document.createElement('div');
        tip.textContent = '{{ __("users.invite_copied") }}';
        tip.style.cssText = 'position:fixed;bottom:24px;left:50%;transform:translateX(-50%);background:#0ab39c;color:#fff;padding:8px 18px;border-radius:6px;font-size:0.82rem;font-weight:600;z-index:9999;box-shadow:0 4px 12px rgba(0,0,0,0.15)';
        document.body.appendChild(tip);
        setTimeout(() => tip.remove(), 2000);
    });
}

const EYE_OPEN = '<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>';
const EYE_OFF  = '<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>';

function togglePwd(btn) {
    const inp = btn.previousElementSibling;
    const show = inp.type === 'password';
    inp.type = show ? 'text' : 'password';
    btn.innerHTML = show ? EYE_OFF : EYE_OPEN;
}

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

function openEditUser(id, name, email, role, photoUrl, groupIds = []) {
    const form = document.getElementById('edit-user-form');
    form.action = form.dataset.base + '/' + id;
    document.getElementById('u_name').value  = name;
    document.getElementById('u_email').value = email;
    document.getElementById('u_role').value  = role;

    document.querySelectorAll('#u_groups .group-chip input[type=checkbox]').forEach(cb => {
        const active = groupIds.includes(parseInt(cb.value));
        cb.checked = active;
        cb.closest('.group-chip').classList.toggle('active', active);
    });

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
