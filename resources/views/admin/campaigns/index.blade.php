@extends('admin.layouts.app')

@section('title', __('campaigns.title'))
@section('header', __('campaigns.title'))
@section('breadcrumb')
    <span style="color:#dee2e6">/</span>
    <span style="color:#495057">{{ __('campaigns.title') }}</span>
@endsection

@section('content')

@php
$statusMap = [
    'draft'   => ['label' => __('campaigns.status_draft'),   'style' => 'background:#f3f4f6;color:#6b7280;'],
    'sending' => ['label' => __('campaigns.status_sending'), 'style' => 'background:rgba(245,158,11,0.1);color:#d97706;'],
    'sent'    => ['label' => __('campaigns.status_sent'),    'style' => 'background:rgba(10,179,156,0.1);color:#0ab39c;'],
    'failed'  => ['label' => __('campaigns.status_failed'),  'style' => 'background:rgba(240,101,72,0.1);color:#f06548;'],
];

$allStatuses = ['prospect','supporter','member','volunteer','donor','vip','inactive'];
@endphp

{{-- Resend key warning --}}
@if(empty(config('services.resend.key')))
<div style="margin-bottom:16px;padding:14px 18px;background:rgba(245,158,11,0.08);border:1px solid rgba(245,158,11,0.25);border-radius:8px;display:flex;align-items:center;gap:10px;">
    <svg style="width:18px;height:18px;color:#d97706;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
    <span style="font-size:0.85rem;color:#92400e;">
        <strong>RESEND_KEY</strong> nincs beállítva. Kampányt nem lehet küldeni. →
        Regisztrálj a <a href="https://resend.com" target="_blank" style="color:#405189;">resend.com</a> oldalon, másold be az API kulcsot a <code>.env</code> fájlba:
        <code style="background:#fff;padding:2px 6px;border-radius:3px;border:1px solid #e5e7eb;">RESEND_KEY=re_xxxxxxxxxx</code>
        majd állítsd: <code style="background:#fff;padding:2px 6px;border-radius:3px;border:1px solid #e5e7eb;">MAIL_MAILER=resend</code>
    </span>
</div>
@endif

<div class="nf-card">
    <div class="nf-card-header">
        <span>{{ __('campaigns.title') }}</span>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.email-templates.index') }}" class="btn-ghost" style="font-size:0.8rem">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right:4px"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                {{ __('campaigns.tpl_library') }}
            </a>
            <button onclick="openModal('modal-campaign-create')" class="btn-teal">
                + {{ __('campaigns.new') }}
            </button>
        </div>
    </div>

    @if($campaigns->isEmpty())
    <div style="padding:48px;text-align:center;color:#adb5bd;">
        <svg style="width:48px;height:48px;margin:0 auto 12px;display:block;opacity:.4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        <p style="font-size:.9rem;">{{ __('campaigns.empty') }}</p>
    </div>
    @else
    <table class="nf-table">
        <thead>
            <tr>
                <th>{{ __('campaigns.name_label') }}</th>
                <th>{{ __('campaigns.subject_label') }}</th>
                <th>{{ __('common.status') }}</th>
                <th>{{ __('campaigns.seg_label') }}</th>
                <th>{{ __('campaigns.sent_count') }}</th>
                <th>{{ __('campaigns.stat_opens') }}</th>
                <th>{{ __('campaigns.stat_clicks') }}</th>
                <th>{{ __('campaigns.sent_at') }}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($campaigns as $c)
            @php
                $seg = $c->segment_filters ?? [];
                $segType = $seg['type'] ?? 'all';
            @endphp
            <tr>
                <td style="font-weight:500">{{ $c->name }}</td>
                <td style="color:#6c757d;font-size:.85rem;">{{ $c->subject }}</td>
                <td>
                    <span class="badge" style="{{ $statusMap[$c->status]['style'] ?? '' }}">
                        {{ $statusMap[$c->status]['label'] ?? $c->status }}
                    </span>
                </td>
                <td style="font-size:.82rem;color:#6c757d;">
                    @if($segType === 'group')
                        @php $ids = $seg['group_ids'] ?? []; @endphp
                        <span class="nf-badge badge-info" style="font-size:.7rem">{{ __('campaigns.seg_group') }}</span>
                        @if($ids)
                            <span style="margin-left:4px">{{ $groups->whereIn('id', $ids)->pluck('name')->join(', ') }}</span>
                        @endif
                    @elseif($segType === 'tag')
                        @php $ids = $seg['tag_ids'] ?? []; @endphp
                        <span class="nf-badge badge-warning" style="font-size:.7rem">{{ __('campaigns.seg_tag') }}</span>
                        @if($ids)
                            <span style="margin-left:4px">{{ $tags->whereIn('id', $ids)->pluck('name')->join(', ') }}</span>
                        @endif
                    @elseif($segType === 'status')
                        @php $sts = $seg['statuses'] ?? []; @endphp
                        <span class="nf-badge badge-primary" style="font-size:.7rem">{{ __('campaigns.seg_status') }}</span>
                        @if($sts)
                            <span style="margin-left:4px">{{ collect($sts)->map(fn($s) => __('people.statuses.'.$s))->join(', ') }}</span>
                        @endif
                    @else
                        <span class="nf-badge badge-secondary" style="font-size:.7rem">{{ __('campaigns.seg_all') }}</span>
                    @endif
                </td>
                <td style="font-size:.85rem;color:#6c757d;">
                    @if($c->isSent())
                        {{ $c->sent_count }}
                        @if($c->failed_count > 0)
                            <span style="color:#f06548;font-size:.78rem"> ({{ $c->failed_count }} ✗)</span>
                        @endif
                    @else
                        —
                    @endif
                </td>
                <td style="font-size:.85rem;text-align:center">
                    @if($c->isSent() && $c->sent_count > 0)
                        @php $openRate = round($c->opened_count / $c->sent_count * 100); @endphp
                        <span style="color:#0ab39c;font-weight:600">{{ $c->opened_count }}</span>
                        <span style="font-size:.75rem;color:#adb5bd"> {{ $openRate }}%</span>
                    @else
                        <span style="color:#dee2e6">—</span>
                    @endif
                </td>
                <td style="font-size:.85rem;text-align:center">
                    @if($c->isSent() && $c->sent_count > 0)
                        @php $clickRate = round($c->clicked_count / $c->sent_count * 100); @endphp
                        <span style="color:#405189;font-weight:600">{{ $c->clicked_count }}</span>
                        <span style="font-size:.75rem;color:#adb5bd"> {{ $clickRate }}%</span>
                    @else
                        <span style="color:#dee2e6">—</span>
                    @endif
                </td>
                <td style="font-size:.85rem;color:#6c757d;">{{ $c->sent_at?->format('Y.m.d H:i') ?? '—' }}</td>
                <td style="text-align:right;white-space:nowrap">
                    @if($c->isDraft())
                    <button onclick="openEditCampaign({{ $c->id }}, {{ json_encode($c->name) }}, {{ json_encode($c->subject) }}, {{ json_encode($c->body_html) }}, {{ json_encode($c->from_name) }}, {{ json_encode($c->from_email) }}, {{ json_encode($c->segment_filters ?? ['type'=>'all']) }})"
                        class="btn-ghost" style="margin-right:4px">{{ __('common.edit') }}</button>
                    <form method="POST" action="{{ route('admin.campaigns.send', $c) }}" style="display:inline"
                          onsubmit="return confirm('{{ __('campaigns.send_confirm') }}')">
                        @csrf
                        <button type="submit" class="btn-teal" style="padding:5px 12px;font-size:.8rem;">
                            ✉ {{ __('campaigns.send_btn') }}
                        </button>
                    </form>
                    @endif
                    <form method="POST" action="{{ route('admin.campaigns.destroy', $c) }}" style="display:inline"
                          onsubmit="return confirm('{{ __('common.confirm_delete') }}')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-danger" style="padding:5px 10px;font-size:.8rem;margin-left:4px">✕</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

{{-- ===================== CREATE MODAL ===================== --}}
<div id="modal-campaign-create" class="nf-overlay">
    <div class="nf-modal" style="max-width:720px;width:95%">
        <div class="nf-modal-header">
            <span class="nf-modal-title">{{ __('campaigns.new') }}</span>
            <button onclick="closeModal('modal-campaign-create')" class="nf-modal-close">✕</button>
        </div>
        <form id="campaign-create-form" method="POST" action="{{ route('admin.campaigns.store') }}">
            @csrf
            <div class="nf-modal-body" style="display:grid;gap:14px">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                    <div>
                        <label class="nf-label">{{ __('campaigns.name_label') }} <span style="color:#f06548">*</span></label>
                        <input type="text" name="name" class="nf-input" required placeholder="{{ __('campaigns.name_label') }}">
                    </div>
                    <div>
                        <label class="nf-label">{{ __('campaigns.subject_label') }} <span style="color:#f06548">*</span></label>
                        <input type="text" name="subject" class="nf-input" required placeholder="{{ __('campaigns.subject_label') }}">
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                    <div>
                        <label class="nf-label">{{ __('campaigns.from_name_label') }}</label>
                        <input type="text" name="from_name" class="nf-input" placeholder="{{ config('mail.from.name') }}">
                    </div>
                    <div>
                        <label class="nf-label">{{ __('campaigns.from_email_label') }}</label>
                        <input type="email" name="from_email" class="nf-input" placeholder="{{ config('mail.from.address') }}">
                    </div>
                </div>

                {{-- Audience segment --}}
                @include('admin.campaigns._segment_panel', ['prefix' => 'c', 'seg' => ['type' => 'all'], 'groups' => $groups, 'tags' => $tags, 'allStatuses' => $allStatuses, 'subscriberCount' => $subscriberCount])

                <div>
                    <div class="flex items-center justify-between" style="margin-bottom:6px">
                        <label class="nf-label" style="margin:0">{{ __('campaigns.body_label') }} <span style="color:#f06548">*</span></label>
                        <button type="button" onclick="openTemplatePicker('create_body')"
                                style="font-size:0.75rem;padding:3px 10px;background:rgba(64,81,137,0.08);color:#405189;border:1px solid rgba(64,81,137,0.2);border-radius:5px;cursor:pointer">
                            <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right:3px;vertical-align:middle"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            {{ __('campaigns.use_template_btn') }}
                        </button>
                    </div>
                    <textarea id="create_body" name="body_html" class="nf-input" rows="10" required
                        style="font-family:monospace;font-size:.82rem;line-height:1.6;resize:vertical"
                        placeholder="{{ __('campaigns.placeholder') }}"></textarea>
                    <p style="font-size:.72rem;color:#adb5bd;margin-top:4px">{{ __('campaigns.markdown_hint') }}</p>
                </div>
            </div>
            <div class="nf-modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('modal-campaign-create')">{{ __('common.cancel') }}</button>
                <button type="submit" class="btn-teal">{{ __('common.save_changes') }}</button>
            </div>
        </form>
    </div>
</div>

{{-- ===================== EDIT MODAL ===================== --}}
<div id="modal-campaign-edit" class="nf-overlay">
    <div class="nf-modal" style="max-width:720px;width:95%">
        <div class="nf-modal-header">
            <span class="nf-modal-title">{{ __('campaigns.edit') }}</span>
            <button onclick="closeModal('modal-campaign-edit')" class="nf-modal-close">✕</button>
        </div>
        <form id="campaign-edit-form" method="POST" action="" data-base="{{ url('admin/campaigns') }}">
            @csrf @method('PUT')
            <div class="nf-modal-body" style="display:grid;gap:14px">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                    <div>
                        <label class="nf-label">{{ __('campaigns.name_label') }} <span style="color:#f06548">*</span></label>
                        <input type="text" name="name" id="edit_name" class="nf-input" required>
                    </div>
                    <div>
                        <label class="nf-label">{{ __('campaigns.subject_label') }} <span style="color:#f06548">*</span></label>
                        <input type="text" name="subject" id="edit_subject" class="nf-input" required>
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                    <div>
                        <label class="nf-label">{{ __('campaigns.from_name_label') }}</label>
                        <input type="text" name="from_name" id="edit_from_name" class="nf-input">
                    </div>
                    <div>
                        <label class="nf-label">{{ __('campaigns.from_email_label') }}</label>
                        <input type="email" name="from_email" id="edit_from_email" class="nf-input">
                    </div>
                </div>

                {{-- Audience segment --}}
                @include('admin.campaigns._segment_panel', ['prefix' => 'e', 'seg' => ['type' => 'all'], 'groups' => $groups, 'tags' => $tags, 'allStatuses' => $allStatuses, 'subscriberCount' => $subscriberCount])

                <div>
                    <div class="flex items-center justify-between" style="margin-bottom:6px">
                        <label class="nf-label" style="margin:0">{{ __('campaigns.body_label') }} <span style="color:#f06548">*</span></label>
                        <button type="button" onclick="openTemplatePicker('edit_body')"
                                style="font-size:0.75rem;padding:3px 10px;background:rgba(64,81,137,0.08);color:#405189;border:1px solid rgba(64,81,137,0.2);border-radius:5px;cursor:pointer">
                            <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right:3px;vertical-align:middle"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            {{ __('campaigns.use_template_btn') }}
                        </button>
                    </div>
                    <textarea name="body_html" id="edit_body" class="nf-input" rows="10" required
                        style="font-family:monospace;font-size:.82rem;line-height:1.6;resize:vertical"></textarea>
                    <p style="font-size:.72rem;color:#adb5bd;margin-top:4px">{{ __('campaigns.markdown_hint') }}</p>
                </div>
            </div>
            <div class="nf-modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('modal-campaign-edit')">{{ __('common.cancel') }}</button>
                <button type="submit" class="btn-teal">{{ __('common.save_changes') }}</button>
            </div>
        </form>
    </div>
</div>

{{-- ===================== TEMPLATE PICKER MODAL ===================== --}}
<div id="modal-tpl-picker" class="nf-overlay">
    <div class="nf-modal" style="max-width:860px;width:96%">
        <div class="nf-modal-header">
            <span class="nf-modal-title">{{ __('campaigns.tpl_pick') }}</span>
            <button onclick="closeModal('modal-tpl-picker')" class="nf-modal-close">✕</button>
        </div>
        <div class="nf-modal-body" style="padding:0">
            <p style="padding:14px 20px 12px;font-size:0.8125rem;color:#6c757d;border-bottom:1px solid #f0f0f5;margin:0">
                {{ __('campaigns.tpl_pick_desc') }}
            </p>
            <div id="tpl-picker-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:16px;padding:20px;max-height:60vh;overflow-y:auto">
                <div style="text-align:center;color:#adb5bd;padding:40px;grid-column:1/-1">
                    <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mx-auto mb-2"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Loading…
                </div>
            </div>
        </div>
        <div class="nf-modal-footer">
            <button type="button" class="btn-ghost" onclick="closeModal('modal-tpl-picker')">{{ __('common.cancel') }}</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
const RECIPIENT_COUNT_URL = '{{ route("admin.campaigns.recipient-count") }}';

// ── Segment panel logic ───────────────────────────────────────────────────────

function onSegmentTypeChange(select, prefix) {
    const type = select.value;
    ['group','tag','status'].forEach(t => {
        document.getElementById(prefix + '_seg_' + t).style.display = type === t ? '' : 'none';
    });
    refreshSegmentCount(prefix);
}

let _segTimer = null;
function scheduleSegCount(prefix) {
    clearTimeout(_segTimer);
    _segTimer = setTimeout(() => refreshSegmentCount(prefix), 350);
}

function refreshSegmentCount(prefix) {
    const formId   = prefix === 'c' ? 'campaign-create-form' : 'campaign-edit-form';
    const form     = document.getElementById(formId);
    const type     = form.querySelector('[name="segment_type"]').value;
    const params   = new URLSearchParams({ type });

    if (type === 'group') {
        [...form.querySelectorAll('[name="segment_group_ids[]"] option:checked')]
            .forEach(o => params.append('group_ids[]', o.value));
    } else if (type === 'tag') {
        [...form.querySelectorAll('[name="segment_tag_ids[]"] option:checked')]
            .forEach(o => params.append('tag_ids[]', o.value));
    } else if (type === 'status') {
        [...form.querySelectorAll('[name="segment_statuses[]"]:checked')]
            .forEach(o => params.append('statuses[]', o.value));
    }

    const el = document.getElementById(prefix + '_seg_count_val');
    if (el) el.textContent = '…';

    fetch(RECIPIENT_COUNT_URL + '?' + params)
        .then(r => r.json())
        .then(d => { if (el) el.textContent = d.count; })
        .catch(() => { if (el) el.textContent = '?'; });
}

// ── Edit modal open ───────────────────────────────────────────────────────────

function openEditCampaign(id, name, subject, body, fromName, fromEmail, segmentFilters) {
    const form = document.getElementById('campaign-edit-form');
    form.action = form.dataset.base + '/' + id;

    document.getElementById('edit_name').value       = name;
    document.getElementById('edit_subject').value    = subject;
    document.getElementById('edit_body').value       = body;
    document.getElementById('edit_from_name').value  = fromName || '';
    document.getElementById('edit_from_email').value = fromEmail || '';

    // Apply segment filters
    const seg  = segmentFilters || { type: 'all' };
    const type = seg.type || 'all';

    const typeSelect = form.querySelector('[name="segment_type"]');
    if (typeSelect) {
        typeSelect.value = type;
        onSegmentTypeChange(typeSelect, 'e');
    }

    // Restore group selection
    const groupSel = form.querySelector('[name="segment_group_ids[]"]');
    if (groupSel && seg.group_ids) {
        [...groupSel.options].forEach(o => {
            o.selected = seg.group_ids.includes(parseInt(o.value));
        });
    }

    // Restore tag selection
    const tagSel = form.querySelector('[name="segment_tag_ids[]"]');
    if (tagSel && seg.tag_ids) {
        [...tagSel.options].forEach(o => {
            o.selected = seg.tag_ids.includes(parseInt(o.value));
        });
    }

    // Restore status checkboxes
    form.querySelectorAll('[name="segment_statuses[]"]').forEach(cb => {
        cb.checked = seg.statuses ? seg.statuses.includes(cb.value) : false;
    });

    refreshSegmentCount('e');
    openModal('modal-campaign-edit');
}

// ── Template picker ───────────────────────────────────────────────────────────

let pickerTargetId = null;
let templatesCache = null;

const catColors = {
    minimal:      '#6c757d',
    newsletter:   '#299cdb',
    announcement: '#405189',
    promotional:  '#0ab39c',
    custom:       '#f7b84b',
};
const catLabels = {
    minimal:      '{{ __("campaigns.tpl_cat_minimal") }}',
    newsletter:   '{{ __("campaigns.tpl_cat_newsletter") }}',
    announcement: '{{ __("campaigns.tpl_cat_announcement") }}',
    promotional:  '{{ __("campaigns.tpl_cat_promotional") }}',
    custom:       '{{ __("campaigns.tpl_cat_custom") }}',
};

function openTemplatePicker(targetId) {
    pickerTargetId = targetId;
    openModal('modal-tpl-picker');
    if (templatesCache) {
        renderPickerGrid(templatesCache);
    } else {
        fetch('{{ route("admin.email-templates.api") }}')
            .then(r => r.json())
            .then(data => { templatesCache = data; renderPickerGrid(data); })
            .catch(() => {
                document.getElementById('tpl-picker-grid').innerHTML =
                    '<div style="text-align:center;color:#f06548;padding:32px;grid-column:1/-1">Failed to load templates.</div>';
            });
    }
}

function renderPickerGrid(templates) {
    const grid = document.getElementById('tpl-picker-grid');
    if (!templates.length) {
        grid.innerHTML = '<div style="text-align:center;color:#adb5bd;padding:32px;grid-column:1/-1">{{ __("campaigns.tpl_empty") }}</div>';
        return;
    }
    grid.innerHTML = templates.map(t => `
        <div style="border:2px solid #e9ebec;border-radius:10px;overflow:hidden;cursor:pointer;transition:border-color .15s"
             onmouseover="this.style.borderColor='#405189'" onmouseout="this.style.borderColor='#e9ebec'"
             onclick="loadTemplate(${t.id})">
            <div style="height:140px;overflow:hidden;background:#f8f9fa;position:relative">
                <iframe src="{{ url('admin/email-templates') }}/${t.id}/preview"
                        style="width:200%;height:200%;transform:scale(0.5);transform-origin:top left;border:none;pointer-events:none"
                        loading="lazy"></iframe>
            </div>
            <div style="padding:12px 14px">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:4px">
                    <p style="margin:0;font-size:0.8125rem;font-weight:600;color:#212529">${t.name}</p>
                    <span style="font-size:0.65rem;padding:1px 6px;border-radius:3px;background:${catColors[t.category]}22;color:${catColors[t.category]};font-weight:600;white-space:nowrap">
                        ${catLabels[t.category] || t.category}
                    </span>
                </div>
                ${t.description ? `<p style="margin:0;font-size:0.75rem;color:#6c757d;line-height:1.4">${t.description}</p>` : ''}
                <button onclick="event.stopPropagation();loadTemplate(${t.id})"
                        style="margin-top:10px;width:100%;padding:7px;background:#405189;color:#fff;border:none;border-radius:6px;font-size:0.8rem;font-weight:600;cursor:pointer">
                    {{ __("campaigns.tpl_use") }}
                </button>
            </div>
        </div>
    `).join('');
}

function loadTemplate(id) {
    const tpl = templatesCache.find(t => t.id === id);
    if (!tpl || !pickerTargetId) return;
    const textarea = document.getElementById(pickerTargetId);
    if (!textarea) return;
    if (textarea.value.trim() && !confirm('{{ __("campaigns.tpl_loaded") }}\n\nOverwrite current content?')) return;
    textarea.value = tpl.body_html;
    closeModal('modal-tpl-picker');
}
</script>
@endpush
