@extends('admin.layouts.app')

@section('title', $dripCampaign->name)
@section('header', $dripCampaign->name)
@section('breadcrumb')
    <a href="{{ route('admin.drip-campaigns.index') }}">{{ __('drip.title') }}</a>
    <span class="breadcrumb-sep">/</span>
    <span style="color:#495057">{{ $dripCampaign->name }}</span>
@endsection

@section('header-actions')
    @php
        $statusStyle = match($dripCampaign->status) {
            'active' => 'background:rgba(10,179,156,0.1);color:#0ab39c;border:1px solid rgba(10,179,156,0.25)',
            'paused' => 'background:rgba(245,158,11,0.1);color:#d97706;border:1px solid rgba(245,158,11,0.25)',
            default  => 'background:#f3f4f6;color:#6b7280;border:1px solid #e5e7eb',
        };
    @endphp
    <span class="badge" style="{{ $statusStyle }};padding:4px 10px;font-size:.8rem;border-radius:5px">
        {{ __('drip.status_' . $dripCampaign->status) }}
    </span>
    <form method="POST" action="{{ route('admin.drip-campaigns.toggle-status', $dripCampaign) }}" style="display:inline">
        @csrf
        @if($dripCampaign->isActive())
            <button type="submit" class="btn-ghost" style="font-size:.82rem">⏸ {{ __('drip.pause') }}</button>
        @else
            <button type="submit" class="btn-primary" style="font-size:.82rem">▶ {{ __('drip.activate') }}</button>
        @endif
    </form>
    <button onclick="openModal('modal-drip-edit')" class="btn-ghost" style="font-size:.82rem">{{ __('common.edit') }}</button>
@endsection

@section('content')

{{-- Stats row --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px">
    @foreach([
        ['stat_total',     $stats['total'],     '#405189', 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0'],
        ['stat_active',    $stats['active'],    '#0ab39c', 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0'],
        ['stat_completed', $stats['completed'], '#6c757d', 'M5 13l4 4L19 7'],
        ['stat_cancelled', $stats['cancelled'], '#f06548', 'M6 18L18 6M6 6l12 12'],
    ] as [$key, $val, $color, $path])
    <div class="nf-card" style="padding:16px 20px;display:flex;align-items:center;gap:14px">
        <div style="width:38px;height:38px;border-radius:8px;background:{{ $color }}1a;display:flex;align-items:center;justify-content:center;flex-shrink:0">
            <svg width="18" height="18" fill="none" stroke="{{ $color }}" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $path }}"/></svg>
        </div>
        <div>
            <p style="margin:0;font-size:1.4rem;font-weight:700;color:#212529">{{ $val }}</p>
            <p style="margin:0;font-size:.75rem;color:#6c757d">{{ __('drip.' . $key) }}</p>
        </div>
    </div>
    @endforeach
</div>

<div style="display:grid;grid-template-columns:1fr 1.6fr;gap:20px;align-items:start">

{{-- ═══ STEPS ═══ --}}
<div class="nf-card">
    <div class="nf-card-header">
        <span>{{ __('drip.steps_title') }}</span>
        <button onclick="openModal('modal-step-create')" class="btn-primary" style="font-size:.8rem;padding:5px 12px">
            + {{ __('drip.step_new') }}
        </button>
    </div>

    @if($dripCampaign->steps->isEmpty())
        <div style="padding:36px;text-align:center;color:#adb5bd;font-size:.85rem">{{ __('drip.steps_empty') }}</div>
    @else
        <div style="padding:12px 0">
            @foreach($dripCampaign->steps as $i => $step)
            <div style="display:flex;align-items:flex-start;gap:0;padding:0 16px 0 0">
                {{-- Timeline --}}
                <div style="display:flex;flex-direction:column;align-items:center;width:40px;flex-shrink:0;padding-top:14px">
                    <div style="width:28px;height:28px;border-radius:50%;background:#405189;color:#fff;display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:700;flex-shrink:0">
                        {{ $i + 1 }}
                    </div>
                    @if(!$loop->last)
                        <div style="width:2px;flex:1;background:#e9ebec;min-height:24px;margin:4px 0"></div>
                    @endif
                </div>
                {{-- Content --}}
                <div style="flex:1;padding:10px 0 16px 10px;border-bottom:{{ $loop->last ? 'none' : '1px solid #f8f9fa' }}">
                    <div style="font-size:.72rem;color:#0ab39c;font-weight:600;margin-bottom:3px">
                        @if($step->delay_days === 0)
                            ⚡ {{ __('drip.delay_immediately') }}
                        @else
                            ⏱ {{ __('drip.delay_after_days', ['days' => $step->delay_days]) }}
                        @endif
                    </div>
                    <p style="margin:0;font-size:.85rem;font-weight:600;color:#212529">{{ $step->subject }}</p>
                    @if($step->from_email)
                        <p style="margin:2px 0 0;font-size:.75rem;color:#adb5bd">{{ $step->from_name }} &lt;{{ $step->from_email }}&gt;</p>
                    @endif
                    <div style="display:flex;gap:6px;margin-top:8px">
                        <button onclick="openEditStep({{ $step->id }}, {{ json_encode($step->subject) }}, {{ json_encode($step->from_name ?? '') }}, {{ json_encode($step->from_email ?? '') }}, {{ json_encode($step->body_html) }}, {{ $step->delay_days }})"
                                class="btn-ghost" style="padding:3px 9px;font-size:.75rem">{{ __('common.edit') }}</button>
                        <form method="POST" action="{{ route('admin.drip-campaigns.steps.destroy', [$dripCampaign, $step]) }}"
                              onsubmit="return confirm('{{ __('common.confirm_delete') }}')">
                            @csrf @method('DELETE')
                            <button type="submit" style="padding:3px 9px;font-size:.75rem;background:none;border:1px solid transparent;color:#f06548;border-radius:4px;cursor:pointer"
                                    onmouseover="this.style.background='rgba(240,101,72,0.08)'" onmouseout="this.style.background='none'">
                                {{ __('common.delete') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

{{-- ═══ ENROLLMENTS ═══ --}}
<div class="nf-card">
    <div class="nf-card-header">
        <span>{{ __('drip.enrollments_title') }}</span>
        <button onclick="openModal('modal-enroll')" class="btn-teal" style="font-size:.8rem;padding:5px 12px">
            + {{ __('drip.enroll_btn') }}
        </button>
    </div>

    @if($enrollments->isEmpty())
        <div style="padding:36px;text-align:center;color:#adb5bd;font-size:.85rem">{{ __('drip.enrollments_empty') }}</div>
    @else
        <table class="nf-table">
            <thead>
                <tr>
                    <th>{{ __('drip.col_person') }}</th>
                    <th>{{ __('drip.col_step') }}</th>
                    <th>{{ __('drip.col_next') }}</th>
                    <th>{{ __('drip.col_status') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($enrollments as $enr)
                @php
                    $enrStyle = match($enr->status) {
                        'active'    => 'background:rgba(10,179,156,0.1);color:#0ab39c;',
                        'completed' => 'background:#f3f4f6;color:#6b7280;',
                        default     => 'background:rgba(240,101,72,0.08);color:#f06548;',
                    };
                @endphp
                <tr>
                    <td>
                        <p style="margin:0;font-size:.85rem;font-weight:500">{{ $enr->person?->full_name ?? '—' }}</p>
                        <p style="margin:0;font-size:.75rem;color:#adb5bd">{{ $enr->person?->email }}</p>
                    </td>
                    <td style="font-size:.82rem;color:#6c757d;text-align:center">
                        {{ $enr->current_step_index }} / {{ $dripCampaign->steps->count() }}
                    </td>
                    <td style="font-size:.8rem;color:#6c757d;white-space:nowrap">
                        {{ $enr->next_send_at?->format('Y.m.d H:i') ?? '—' }}
                    </td>
                    <td>
                        <span class="badge" style="{{ $enrStyle }}">
                            {{ __('drip.status_' . $enr->status . '_row') }}
                        </span>
                    </td>
                    <td>
                        @if($enr->status === 'active')
                        <form method="POST" action="{{ route('admin.drip-campaigns.enrollments.cancel', [$dripCampaign, $enr]) }}"
                              onsubmit="return confirm('{{ __('common.confirm_delete') }}')">
                            @csrf
                            <button type="submit" style="font-size:.75rem;padding:2px 8px;background:none;border:1px solid #dee2e6;border-radius:4px;color:#6c757d;cursor:pointer"
                                    onmouseover="this.style.borderColor='#f06548';this.style.color='#f06548'" onmouseout="this.style.borderColor='#dee2e6';this.style.color='#6c757d'">
                                {{ __('drip.cancel_enrollment') }}
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="padding:12px 16px">
            {{ $enrollments->links() }}
        </div>
    @endif
</div>

</div>{{-- /grid --}}

{{-- ═══ EDIT CAMPAIGN MODAL ═══ --}}
<div id="modal-drip-edit" class="nf-overlay">
    <div class="nf-modal" style="max-width:520px;width:95%">
        <div class="nf-modal-header">
            <span class="nf-modal-title">{{ __('drip.edit') }}</span>
            <button onclick="closeModal('modal-drip-edit')" class="nf-modal-close">✕</button>
        </div>
        <form method="POST" action="{{ route('admin.drip-campaigns.update', $dripCampaign) }}">
            @csrf @method('PUT')
            <div class="nf-modal-body" style="display:grid;gap:14px">
                <div>
                    <label class="nf-label">{{ __('drip.name_label') }} <span style="color:#f06548">*</span></label>
                    <input type="text" name="name" class="nf-input" required value="{{ $dripCampaign->name }}">
                </div>
                <div>
                    <label class="nf-label">{{ __('drip.description_label') }}</label>
                    <input type="text" name="description" class="nf-input" value="{{ $dripCampaign->description }}">
                </div>
                <div>
                    <label class="nf-label">{{ __('drip.trigger_label') }}</label>
                    <select name="trigger_type" class="nf-select" onchange="onEditTriggerChange(this)">
                        <option value="manual"     @selected($dripCampaign->trigger_type === 'manual')>{{ __('drip.trigger_manual') }}</option>
                        <option value="group_join" @selected($dripCampaign->trigger_type === 'group_join')>{{ __('drip.trigger_group_join') }}</option>
                        <option value="tag_added"  @selected($dripCampaign->trigger_type === 'tag_added')>{{ __('drip.trigger_tag_added') }}</option>
                    </select>
                </div>
                <div id="edit_trigger_group" style="display:{{ $dripCampaign->trigger_type === 'group_join' ? '' : 'none' }}">
                    <label class="nf-label">{{ __('drip.trigger_group_sel') }}</label>
                    <select name="trigger_group_id" class="nf-select">
                        <option value="">—</option>
                        @foreach($groups as $g)
                            <option value="{{ $g->id }}" @selected($dripCampaign->trigger_group_id == $g->id)>{{ $g->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="edit_trigger_tag" style="display:{{ $dripCampaign->trigger_type === 'tag_added' ? '' : 'none' }}">
                    <label class="nf-label">{{ __('drip.trigger_tag_sel') }}</label>
                    <select name="trigger_tag_id" class="nf-select">
                        <option value="">—</option>
                        @foreach($tags as $t)
                            <option value="{{ $t->id }}" @selected($dripCampaign->trigger_tag_id == $t->id)>{{ $t->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="nf-modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('modal-drip-edit')">{{ __('common.cancel') }}</button>
                <button type="submit" class="btn-primary">{{ __('common.save') }}</button>
            </div>
        </form>
    </div>
</div>

{{-- ═══ CREATE STEP MODAL ═══ --}}
<div id="modal-step-create" class="nf-overlay">
    <div class="nf-modal" style="max-width:700px;width:96%">
        <div class="nf-modal-header">
            <span class="nf-modal-title">{{ __('drip.step_new') }}</span>
            <button onclick="closeModal('modal-step-create')" class="nf-modal-close">✕</button>
        </div>
        <form method="POST" action="{{ route('admin.drip-campaigns.steps.store', $dripCampaign) }}">
            @csrf
            <div class="nf-modal-body" style="display:grid;gap:14px">
                <div style="display:grid;grid-template-columns:1fr auto;gap:12px;align-items:end">
                    <div>
                        <label class="nf-label">{{ __('drip.step_subject') }} <span style="color:#f06548">*</span></label>
                        <input type="text" name="subject" class="nf-input" required>
                    </div>
                    <div style="min-width:110px">
                        <label class="nf-label">{{ __('drip.step_delay') }} <span style="color:#f06548">*</span>
                            <span style="font-weight:400;color:#adb5bd;font-size:.72rem">({{ __('drip.step_delay_hint') }})</span>
                        </label>
                        <div style="display:flex;align-items:center;gap:6px">
                            <input type="number" name="delay_days" class="nf-input" value="0" min="0" max="365" style="width:80px;text-align:center">
                            <span style="font-size:.82rem;color:#6c757d;white-space:nowrap">{{ __('common.days') }}</span>
                        </div>
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                    <div>
                        <label class="nf-label">{{ __('drip.step_from_name') }}</label>
                        <input type="text" name="from_name" class="nf-input" placeholder="{{ config('mail.from.name') }}">
                    </div>
                    <div>
                        <label class="nf-label">{{ __('drip.step_from_email') }}</label>
                        <input type="email" name="from_email" class="nf-input" placeholder="{{ config('mail.from.address') }}">
                    </div>
                </div>
                <div>
                    <label class="nf-label">{{ __('drip.step_body') }} <span style="color:#f06548">*</span></label>
                    <textarea name="body_html" id="create_step_body" class="nf-input" rows="11" required
                              style="font-family:monospace;font-size:.82rem;line-height:1.6;resize:vertical"
                              placeholder="&lt;!DOCTYPE html&gt;&#10;&lt;html&gt;...&lt;/html&gt;"></textarea>
                </div>
            </div>
            <div class="nf-modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('modal-step-create')">{{ __('common.cancel') }}</button>
                <button type="submit" class="btn-primary">{{ __('common.create') }}</button>
            </div>
        </form>
    </div>
</div>

{{-- ═══ EDIT STEP MODAL ═══ --}}
<div id="modal-step-edit" class="nf-overlay">
    <div class="nf-modal" style="max-width:700px;width:96%">
        <div class="nf-modal-header">
            <span class="nf-modal-title">{{ __('drip.step_edit') }}</span>
            <button onclick="closeModal('modal-step-edit')" class="nf-modal-close">✕</button>
        </div>
        <form id="form-step-edit" method="POST" action="" data-base="{{ url('admin/drip-campaigns/' . $dripCampaign->id . '/steps') }}">
            @csrf @method('PUT')
            <div class="nf-modal-body" style="display:grid;gap:14px">
                <div style="display:grid;grid-template-columns:1fr auto;gap:12px;align-items:end">
                    <div>
                        <label class="nf-label">{{ __('drip.step_subject') }} <span style="color:#f06548">*</span></label>
                        <input type="text" name="subject" id="es_subject" class="nf-input" required>
                    </div>
                    <div style="min-width:110px">
                        <label class="nf-label">{{ __('drip.step_delay') }} <span style="color:#f06548">*</span>
                            <span style="font-weight:400;color:#adb5bd;font-size:.72rem">({{ __('drip.step_delay_hint') }})</span>
                        </label>
                        <div style="display:flex;align-items:center;gap:6px">
                            <input type="number" name="delay_days" id="es_delay" class="nf-input" value="0" min="0" max="365" style="width:80px;text-align:center">
                            <span style="font-size:.82rem;color:#6c757d;white-space:nowrap">{{ __('common.days') }}</span>
                        </div>
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                    <div>
                        <label class="nf-label">{{ __('drip.step_from_name') }}</label>
                        <input type="text" name="from_name" id="es_from_name" class="nf-input">
                    </div>
                    <div>
                        <label class="nf-label">{{ __('drip.step_from_email') }}</label>
                        <input type="email" name="from_email" id="es_from_email" class="nf-input">
                    </div>
                </div>
                <div>
                    <label class="nf-label">{{ __('drip.step_body') }} <span style="color:#f06548">*</span></label>
                    <textarea name="body_html" id="es_body" class="nf-input" rows="11" required
                              style="font-family:monospace;font-size:.82rem;line-height:1.6;resize:vertical"></textarea>
                </div>
            </div>
            <div class="nf-modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('modal-step-edit')">{{ __('common.cancel') }}</button>
                <button type="submit" class="btn-primary">{{ __('common.save') }}</button>
            </div>
        </form>
    </div>
</div>

{{-- ═══ ENROLL MODAL ═══ --}}
<div id="modal-enroll" class="nf-overlay">
    <div class="nf-modal" style="max-width:480px;width:95%">
        <div class="nf-modal-header">
            <span class="nf-modal-title">{{ __('drip.enroll_btn') }}</span>
            <button onclick="closeModal('modal-enroll')" class="nf-modal-close">✕</button>
        </div>
        <form method="POST" action="{{ route('admin.drip-campaigns.enroll', $dripCampaign) }}">
            @csrf
            <div class="nf-modal-body" style="display:grid;gap:14px">
                <div>
                    <label class="nf-label">{{ __('drip.trigger_label') }}</label>
                    <select name="segment_type" class="nf-select" onchange="onEnrollTypeChange(this)">
                        <option value="all">{{ __('drip.enroll_seg_all') }}</option>
                        <option value="group">{{ __('drip.enroll_seg_group') }}</option>
                        <option value="tag">{{ __('drip.enroll_seg_tag') }}</option>
                        <option value="status">{{ __('drip.enroll_seg_status') }}</option>
                        <option value="person">{{ __('drip.enroll_seg_person') }}</option>
                    </select>
                </div>

                <div id="enroll_group" style="display:none">
                    <label class="nf-label">{{ __('drip.trigger_group_sel') }}</label>
                    <select name="segment_group_id" class="nf-select">
                        <option value="">—</option>
                        @foreach($groups as $g)
                            <option value="{{ $g->id }}">{{ $g->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="enroll_tag" style="display:none">
                    <label class="nf-label">{{ __('drip.trigger_tag_sel') }}</label>
                    <select name="segment_tag_id" class="nf-select">
                        <option value="">—</option>
                        @foreach($tags as $t)
                            <option value="{{ $t->id }}">{{ $t->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="enroll_status" style="display:none">
                    <label class="nf-label">{{ __('campaigns.seg_statuses') }}</label>
                    <div style="display:flex;flex-wrap:wrap;gap:8px 16px;margin-top:6px">
                        @foreach(['prospect','supporter','member','volunteer','donor','vip','inactive'] as $s)
                        <label style="display:flex;align-items:center;gap:5px;cursor:pointer;font-size:.83rem">
                            <input type="checkbox" name="segment_statuses[]" value="{{ $s }}">
                            {{ __('people.status.' . $s) }}
                        </label>
                        @endforeach
                    </div>
                </div>

                <div id="enroll_person" style="display:none">
                    <label class="nf-label">{{ __('drip.enroll_seg_person') }}</label>
                    <select name="person_id" class="nf-select">
                        <option value="">—</option>
                        @foreach(\App\Models\Person::orderBy('last_name')->orderBy('first_name')->get(['id','first_name','last_name','email']) as $p)
                            <option value="{{ $p->id }}">{{ $p->full_name }} ({{ $p->email }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="nf-modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('modal-enroll')">{{ __('common.cancel') }}</button>
                <button type="submit" class="btn-teal">{{ __('drip.enroll_btn') }}</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openEditStep(id, subject, fromName, fromEmail, body, delay) {
    const form = document.getElementById('form-step-edit');
    form.action = form.dataset.base + '/' + id;
    document.getElementById('es_subject').value   = subject;
    document.getElementById('es_from_name').value = fromName;
    document.getElementById('es_from_email').value= fromEmail;
    document.getElementById('es_body').value      = body;
    document.getElementById('es_delay').value     = delay;
    openModal('modal-step-edit');
}

function onEditTriggerChange(sel) {
    document.getElementById('edit_trigger_group').style.display = sel.value === 'group_join' ? '' : 'none';
    document.getElementById('edit_trigger_tag').style.display   = sel.value === 'tag_added'  ? '' : 'none';
}

function onEnrollTypeChange(sel) {
    ['group','tag','status','person'].forEach(t => {
        document.getElementById('enroll_' + t).style.display = sel.value === t ? '' : 'none';
    });
}
</script>
@endpush
