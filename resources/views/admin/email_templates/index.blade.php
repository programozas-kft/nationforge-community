@extends('admin.layouts.app')

@section('title', __('campaigns.tpl_title'))
@section('header', __('campaigns.tpl_title'))
@section('breadcrumb')
    <a href="{{ route('admin.campaigns.index') }}">{{ __('campaigns.title') }}</a>
    <span class="breadcrumb-sep">/</span>
    <span class="text-gray-700">{{ __('campaigns.tpl_title') }}</span>
@endsection

@section('header-actions')
    <button onclick="openModal('modal-tpl-create')" class="btn-primary">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        {{ __('campaigns.tpl_new') }}
    </button>
@endsection

@section('content')

@php
$catColors = [
    'minimal'      => ['badge-secondary', __('campaigns.tpl_cat_minimal')],
    'newsletter'   => ['badge-info',      __('campaigns.tpl_cat_newsletter')],
    'announcement' => ['badge-primary',   __('campaigns.tpl_cat_announcement')],
    'promotional'  => ['badge-success',   __('campaigns.tpl_cat_promotional')],
    'custom'       => ['badge-warning',   __('campaigns.tpl_cat_custom')],
];
@endphp

{{-- Template grid --}}
@if($templates->isEmpty())
    <div class="nf-card p-12 text-center text-gray-400">
        <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mx-auto mb-3 opacity-30"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        <p class="text-sm">{{ __('campaigns.tpl_empty') }}</p>
    </div>
@else
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:20px">
        @foreach($templates as $tpl)
        @php [$catBadge, $catLabel] = $catColors[$tpl->category] ?? ['badge-secondary', $tpl->category]; @endphp
        <div class="nf-card" style="display:flex;flex-direction:column">

            {{-- Preview area --}}
            <div style="position:relative;height:200px;overflow:hidden;border-bottom:1px solid #f0f0f5;background:#f8f9fa;cursor:pointer"
                 onclick="openPreview({{ $tpl->id }})">
                <iframe
                    src="{{ route('admin.email-templates.preview', $tpl) }}"
                    style="width:200%;height:200%;transform:scale(0.5);transform-origin:top left;border:none;pointer-events:none"
                    loading="lazy"
                    title="{{ $tpl->name }}">
                </iframe>
                <div style="position:absolute;inset:0;background:transparent" title="{{ __('campaigns.tpl_preview') }}"></div>
            </div>

            {{-- Info --}}
            <div style="padding:16px 18px;flex:1;display:flex;flex-direction:column;gap:8px">
                <div class="flex items-start justify-between gap-2">
                    <div>
                        <p style="font-size:0.875rem;font-weight:600;color:#212529;margin:0">{{ $tpl->name }}</p>
                        @if($tpl->description)
                            <p style="font-size:0.775rem;color:#6c757d;margin:3px 0 0;line-height:1.4">{{ $tpl->description }}</p>
                        @endif
                    </div>
                    <div style="flex-shrink:0;display:flex;flex-direction:column;align-items:flex-end;gap:4px">
                        <span class="nf-badge {{ $catBadge }}">{{ $catLabel }}</span>
                        @if($tpl->is_system)
                            <span class="nf-badge badge-secondary" style="font-size:0.65rem">{{ __('campaigns.tpl_system') }}</span>
                        @endif
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-2" style="margin-top:auto;padding-top:10px;border-top:1px solid #f8f9fa">
                    <a href="{{ route('admin.email-templates.preview', $tpl) }}" target="_blank"
                       class="btn-ghost" style="padding:4px 10px;font-size:0.75rem">
                        {{ __('campaigns.tpl_preview') }}
                    </a>
                    <button onclick="openEditTpl({{ $tpl->id }}, {{ json_encode($tpl->name) }}, {{ json_encode($tpl->description ?? '') }}, {{ json_encode($tpl->category) }}, {{ json_encode($tpl->body_html) }})"
                            class="btn-ghost" style="padding:4px 10px;font-size:0.75rem">
                        {{ __('common.edit') }}
                    </button>
                    @if(!$tpl->is_system)
                        <form method="POST" action="{{ route('admin.email-templates.destroy', $tpl) }}" style="margin-left:auto"
                              onsubmit="return confirm('{{ __('common.confirm_delete') }}')">
                            @csrf @method('DELETE')
                            <button type="submit" style="padding:4px 10px;font-size:0.75rem;background:none;border:none;color:#f06548;cursor:pointer;border-radius:5px;border:1px solid transparent"
                                    onmouseover="this.style.background='rgba(240,101,72,0.08)'" onmouseout="this.style.background='none'">
                                {{ __('common.delete') }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

{{-- CREATE MODAL --}}
<div id="modal-tpl-create" class="nf-overlay">
    <div class="nf-modal" style="max-width:800px;width:96%">
        <div class="nf-modal-header">
            <span class="nf-modal-title">{{ __('campaigns.tpl_new') }}</span>
            <button onclick="closeModal('modal-tpl-create')" class="nf-modal-close">✕</button>
        </div>
        <form method="POST" action="{{ route('admin.email-templates.store') }}">
            @csrf
            <div class="nf-modal-body" style="display:grid;gap:14px">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                    <div>
                        <label class="nf-label">{{ __('campaigns.tpl_name') }} <span style="color:#f06548">*</span></label>
                        <input type="text" name="name" class="nf-input" required>
                    </div>
                    <div>
                        <label class="nf-label">{{ __('campaigns.tpl_category') }}</label>
                        <select name="category" class="nf-select">
                            <option value="custom">{{ __('campaigns.tpl_cat_custom') }}</option>
                            <option value="minimal">{{ __('campaigns.tpl_cat_minimal') }}</option>
                            <option value="newsletter">{{ __('campaigns.tpl_cat_newsletter') }}</option>
                            <option value="announcement">{{ __('campaigns.tpl_cat_announcement') }}</option>
                            <option value="promotional">{{ __('campaigns.tpl_cat_promotional') }}</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="nf-label">{{ __('campaigns.tpl_desc') }}</label>
                    <input type="text" name="description" class="nf-input" placeholder="{{ __('campaigns.tpl_desc') }}">
                </div>
                <div>
                    <label class="nf-label">{{ __('campaigns.tpl_body') }} <span style="color:#f06548">*</span></label>
                    <textarea name="body_html" class="nf-input" rows="14" required
                              style="font-family:monospace;font-size:0.8rem;line-height:1.6;resize:vertical"
                              placeholder="<!DOCTYPE html>&#10;<html>&#10;...&#10;</html>"></textarea>
                </div>
            </div>
            <div class="nf-modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('modal-tpl-create')">{{ __('common.cancel') }}</button>
                <button type="submit" class="btn-primary">{{ __('common.create') }}</button>
            </div>
        </form>
    </div>
</div>

{{-- EDIT MODAL --}}
<div id="modal-tpl-edit" class="nf-overlay">
    <div class="nf-modal" style="max-width:800px;width:96%">
        <div class="nf-modal-header">
            <span class="nf-modal-title">{{ __('campaigns.tpl_edit') }}</span>
            <button onclick="closeModal('modal-tpl-edit')" class="nf-modal-close">✕</button>
        </div>
        <form id="form-tpl-edit" method="POST" action="" data-base="{{ url('admin/email-templates') }}">
            @csrf @method('PUT')
            <div class="nf-modal-body" style="display:grid;gap:14px">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                    <div>
                        <label class="nf-label">{{ __('campaigns.tpl_name') }} <span style="color:#f06548">*</span></label>
                        <input type="text" name="name" id="etpl_name" class="nf-input" required>
                    </div>
                    <div>
                        <label class="nf-label">{{ __('campaigns.tpl_category') }}</label>
                        <select name="category" id="etpl_cat" class="nf-select">
                            <option value="custom">{{ __('campaigns.tpl_cat_custom') }}</option>
                            <option value="minimal">{{ __('campaigns.tpl_cat_minimal') }}</option>
                            <option value="newsletter">{{ __('campaigns.tpl_cat_newsletter') }}</option>
                            <option value="announcement">{{ __('campaigns.tpl_cat_announcement') }}</option>
                            <option value="promotional">{{ __('campaigns.tpl_cat_promotional') }}</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="nf-label">{{ __('campaigns.tpl_desc') }}</label>
                    <input type="text" name="description" id="etpl_desc" class="nf-input">
                </div>
                <div>
                    <label class="nf-label">{{ __('campaigns.tpl_body') }} <span style="color:#f06548">*</span></label>
                    <textarea name="body_html" id="etpl_body" class="nf-input" rows="14" required
                              style="font-family:monospace;font-size:0.8rem;line-height:1.6;resize:vertical"></textarea>
                </div>
            </div>
            <div class="nf-modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('modal-tpl-edit')">{{ __('common.cancel') }}</button>
                <button type="submit" class="btn-primary">{{ __('common.save') }}</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openEditTpl(id, name, desc, cat, body) {
    const form = document.getElementById('form-tpl-edit');
    form.action = form.dataset.base + '/' + id;
    document.getElementById('etpl_name').value = name;
    document.getElementById('etpl_desc').value = desc;
    document.getElementById('etpl_cat').value  = cat;
    document.getElementById('etpl_body').value = body;
    openModal('modal-tpl-edit');
}

function openPreview(id) {
    window.open('{{ url("admin/email-templates") }}/' + id + '/preview', '_blank', 'width=700,height=600');
}
</script>
@endpush
