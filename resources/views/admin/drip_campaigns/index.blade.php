@extends('admin.layouts.app')

@section('title', __('drip.title'))
@section('header', __('drip.title'))
@section('breadcrumb')
    <span style="color:#dee2e6">/</span>
    <span style="color:#495057">{{ __('drip.title') }}</span>
@endsection

@section('header-actions')
    <button onclick="openModal('modal-drip-create')" class="btn-primary">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        {{ __('drip.new') }}
    </button>
@endsection

@section('content')

<div class="nf-card">
    @if($campaigns->isEmpty())
        <div style="padding:56px;text-align:center;color:#adb5bd;">
            <svg style="width:48px;height:48px;margin:0 auto 12px;display:block;opacity:.35" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
            </svg>
            <p style="font-size:.9rem">{{ __('drip.empty') }}</p>
        </div>
    @else
        <table class="nf-table">
            <thead>
                <tr>
                    <th>{{ __('drip.name_label') }}</th>
                    <th>{{ __('drip.trigger_label') }}</th>
                    <th>{{ __('drip.steps_title') }}</th>
                    <th>{{ __('drip.stat_active') }}</th>
                    <th>{{ __('drip.stat_completed') }}</th>
                    <th>{{ __('common.status') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($campaigns as $drip)
                @php
                    $statusStyle = match($drip->status) {
                        'active' => 'background:rgba(10,179,156,0.1);color:#0ab39c;',
                        'paused' => 'background:rgba(245,158,11,0.1);color:#d97706;',
                        default  => 'background:#f3f4f6;color:#6b7280;',
                    };
                    $statusLabel = __('drip.status_' . $drip->status);
                @endphp
                <tr>
                    <td>
                        <a href="{{ route('admin.drip-campaigns.show', $drip) }}" style="font-weight:600;color:#405189;text-decoration:none">
                            {{ $drip->name }}
                        </a>
                        @if($drip->description)
                            <p style="margin:2px 0 0;font-size:.78rem;color:#adb5bd">{{ Str::limit($drip->description, 60) }}</p>
                        @endif
                    </td>
                    <td style="font-size:.85rem;color:#495057">
                        @if($drip->trigger_type === 'group_join')
                            <span style="font-size:.75rem;padding:2px 7px;border-radius:4px;background:rgba(41,156,219,0.1);color:#299cdb;font-weight:600">{{ __('drip.trigger_group_join') }}</span>
                            @if($drip->triggerGroup)
                                <span style="margin-left:4px;font-size:.8rem;color:#6c757d">{{ $drip->triggerGroup->name }}</span>
                            @endif
                        @elseif($drip->trigger_type === 'tag_added')
                            <span style="font-size:.75rem;padding:2px 7px;border-radius:4px;background:rgba(247,184,75,0.15);color:#c68000;font-weight:600">{{ __('drip.trigger_tag_added') }}</span>
                            @if($drip->triggerTag)
                                <span style="margin-left:4px;font-size:.8rem;color:#6c757d">{{ $drip->triggerTag->name }}</span>
                            @endif
                        @else
                            <span style="font-size:.75rem;padding:2px 7px;border-radius:4px;background:#f3f4f6;color:#6b7280;font-weight:600">{{ __('drip.trigger_manual') }}</span>
                        @endif
                    </td>
                    <td style="text-align:center;font-size:.9rem;color:#495057">{{ $drip->steps_count }}</td>
                    <td style="text-align:center;font-size:.9rem;color:#0ab39c;font-weight:600">{{ $drip->active_count }}</td>
                    <td style="text-align:center;font-size:.9rem;color:#6c757d">{{ $drip->enrollments_count - $drip->active_count }}</td>
                    <td><span class="badge" style="{{ $statusStyle }}">{{ $statusLabel }}</span></td>
                    <td style="text-align:right;white-space:nowrap">
                        <a href="{{ route('admin.drip-campaigns.show', $drip) }}" class="btn-ghost" style="padding:4px 10px;font-size:.8rem">
                            {{ __('common.view') }}
                        </a>
                        <form method="POST" action="{{ route('admin.drip-campaigns.destroy', $drip) }}" style="display:inline"
                              onsubmit="return confirm('{{ __('common.confirm_delete') }}')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-danger" style="padding:4px 10px;font-size:.8rem;margin-left:4px">✕</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

{{-- CREATE MODAL --}}
<div id="modal-drip-create" class="nf-overlay">
    <div class="nf-modal" style="max-width:560px;width:95%">
        <div class="nf-modal-header">
            <span class="nf-modal-title">{{ __('drip.new') }}</span>
            <button onclick="closeModal('modal-drip-create')" class="nf-modal-close">✕</button>
        </div>
        <form method="POST" action="{{ route('admin.drip-campaigns.store') }}">
            @csrf
            <div class="nf-modal-body" style="display:grid;gap:14px">
                <div>
                    <label class="nf-label">{{ __('drip.name_label') }} <span style="color:#f06548">*</span></label>
                    <input type="text" name="name" class="nf-input" required>
                </div>
                <div>
                    <label class="nf-label">{{ __('drip.description_label') }}</label>
                    <input type="text" name="description" class="nf-input">
                </div>
                <div>
                    <label class="nf-label">{{ __('drip.trigger_label') }}</label>
                    <select name="trigger_type" class="nf-select" onchange="onCreateTriggerChange(this)">
                        <option value="manual">{{ __('drip.trigger_manual') }}</option>
                        <option value="group_join">{{ __('drip.trigger_group_join') }}</option>
                        <option value="tag_added">{{ __('drip.trigger_tag_added') }}</option>
                    </select>
                </div>
                <div id="create_trigger_group" style="display:none">
                    <label class="nf-label">{{ __('drip.trigger_group_sel') }}</label>
                    <select name="trigger_group_id" class="nf-select">
                        <option value="">—</option>
                        @foreach($groups as $g)
                            <option value="{{ $g->id }}">{{ $g->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="create_trigger_tag" style="display:none">
                    <label class="nf-label">{{ __('drip.trigger_tag_sel') }}</label>
                    <select name="trigger_tag_id" class="nf-select">
                        <option value="">—</option>
                        @foreach($tags as $t)
                            <option value="{{ $t->id }}">{{ $t->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="nf-modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('modal-drip-create')">{{ __('common.cancel') }}</button>
                <button type="submit" class="btn-primary">{{ __('common.create') }}</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function onCreateTriggerChange(sel) {
    document.getElementById('create_trigger_group').style.display = sel.value === 'group_join' ? '' : 'none';
    document.getElementById('create_trigger_tag').style.display   = sel.value === 'tag_added'  ? '' : 'none';
}
</script>
@endpush
