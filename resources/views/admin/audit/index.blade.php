@extends('admin.layouts.app')

@section('title', __('audit.title'))
@section('header', __('audit.title'))
@section('breadcrumb')
    <span style="color:#495057">{{ __('common.admin') }}</span>
    <span style="color:#dee2e6">/</span>
    <span style="color:#495057">{{ __('audit.title') }}</span>
@endsection

@section('content')

{{-- Filter bar --}}
<form method="GET" action="{{ route('admin.audit') }}" style="margin-bottom:16px">
    <div class="nf-card" style="padding:14px 20px">
        <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end">
            <div style="flex:1;min-width:130px">
                <label class="nf-label" style="font-size:0.72rem">{{ __('audit.filter_action') }}</label>
                <select name="action" class="nf-select" style="font-size:0.8rem">
                    <option value="">{{ __('audit.all_actions') }}</option>
                    @foreach($actions as $a)
                    <option value="{{ $a }}" {{ request('action') === $a ? 'selected' : '' }}>{{ __('audit.action_'.$a) }}</option>
                    @endforeach
                </select>
            </div>
            <div style="flex:1;min-width:140px">
                <label class="nf-label" style="font-size:0.72rem">{{ __('audit.filter_type') }}</label>
                <select name="type" class="nf-select" style="font-size:0.8rem">
                    <option value="">{{ __('audit.all_types') }}</option>
                    @foreach($types as $t)
                    <option value="{{ $t }}" {{ request('type') === $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <div style="flex:1;min-width:150px">
                <label class="nf-label" style="font-size:0.72rem">{{ __('audit.filter_user') }}</label>
                <input type="text" name="user" value="{{ request('user') }}" class="nf-input" style="font-size:0.8rem" placeholder="{{ __('audit.filter_user_ph') }}">
            </div>
            <div style="min-width:130px">
                <label class="nf-label" style="font-size:0.72rem">{{ __('audit.filter_from') }}</label>
                <input type="date" name="from" value="{{ request('from') }}" class="nf-input" style="font-size:0.8rem">
            </div>
            <div style="min-width:130px">
                <label class="nf-label" style="font-size:0.72rem">{{ __('audit.filter_to') }}</label>
                <input type="date" name="to" value="{{ request('to') }}" class="nf-input" style="font-size:0.8rem">
            </div>
            <div style="display:flex;gap:8px">
                <button type="submit" class="btn-primary" style="font-size:0.8rem">{{ __('audit.filter_apply') }}</button>
                @if(request()->hasAny(['action','type','user','from','to']))
                <a href="{{ route('admin.audit') }}" class="btn-ghost" style="font-size:0.8rem">{{ __('common.reset') }}</a>
                @endif
            </div>
        </div>
    </div>
</form>

{{-- Results --}}
<div class="nf-card" style="overflow:hidden">
    <div style="padding:12px 20px;border-bottom:1px solid #e9ebec;display:flex;align-items:center;justify-content:space-between">
        <span style="font-size:0.8125rem;font-weight:600;color:#343a40">{{ __('audit.title') }}</span>
        <span style="font-size:0.75rem;color:#adb5bd">{{ $logs->total() }} {{ __('audit.entries') }}</span>
    </div>

    @if($logs->isEmpty())
    <div style="text-align:center;padding:48px 20px;color:#adb5bd">
        <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin:0 auto 12px;display:block;opacity:0.4"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        <p style="font-size:0.875rem">{{ __('audit.no_entries') }}</p>
    </div>
    @else
    <table class="nf-table">
        <thead>
            <tr>
                <th style="width:150px">{{ __('audit.col_when') }}</th>
                <th style="width:140px">{{ __('audit.col_user') }}</th>
                <th style="width:100px">{{ __('audit.col_action') }}</th>
                <th style="width:110px">{{ __('audit.col_model') }}</th>
                <th>{{ __('audit.col_record') }}</th>
                <th style="width:80px">{{ __('audit.col_changes') }}</th>
                <th style="width:120px">{{ __('audit.col_ip') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
            <tr>
                <td style="font-size:0.78rem;color:#6c757d;white-space:nowrap">
                    <span title="{{ $log->created_at }}">{{ \Carbon\Carbon::parse($log->created_at)->format('Y.m.d H:i') }}</span>
                </td>
                <td>
                    <span style="font-size:0.8rem;font-weight:500;color:#343a40">{{ $log->user_name ?? '—' }}</span>
                </td>
                <td>
                    @php
                        $actionStyles = [
                            'created'  => 'background:rgba(10,179,156,0.12);color:#0a7564',
                            'updated'  => 'background:rgba(64,81,137,0.12);color:#405189',
                            'deleted'  => 'background:rgba(240,101,72,0.12);color:#c0432a',
                            'restored' => 'background:rgba(41,156,219,0.12);color:#1a7ca8',
                        ];
                    @endphp
                    <span class="nf-badge" style="{{ $actionStyles[$log->action] ?? '' }}">
                        {{ __('audit.action_'.$log->action) }}
                    </span>
                </td>
                <td>
                    <span style="font-size:0.75rem;color:#6c757d;background:#f3f3f9;padding:2px 8px;border-radius:4px;font-weight:500">
                        {{ $log->auditable_type }}
                    </span>
                </td>
                <td style="font-size:0.82rem;color:#343a40;max-width:260px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                    {{ $log->model_label ?? '#'.$log->auditable_id }}
                    <span style="font-size:0.7rem;color:#adb5bd;margin-left:4px">#{{ $log->auditable_id }}</span>
                </td>
                <td style="text-align:center">
                    @if($log->changes && count($log->changes))
                    <button onclick="toggleChanges('log-{{ $log->id }}')"
                        style="background:none;border:none;cursor:pointer;color:#405189;font-size:0.75rem;font-weight:600;padding:2px 6px;border-radius:4px;border:1px solid #dee2e6">
                        {{ count($log->changes) }} {{ __('audit.fields') }}
                    </button>
                    @else
                    <span style="color:#dee2e6;font-size:0.75rem">—</span>
                    @endif
                </td>
                <td style="font-size:0.72rem;color:#adb5bd;font-family:monospace">
                    {{ $log->ip_address ?? '—' }}
                </td>
            </tr>
            @if($log->changes && count($log->changes))
            <tr id="log-{{ $log->id }}" style="display:none;background:#f8f9fa">
                <td colspan="7" style="padding:0">
                    <table style="width:100%;font-size:0.78rem;border-collapse:collapse">
                        <thead>
                            <tr style="background:#f0f1f6">
                                <td style="padding:6px 20px 6px 60px;font-weight:600;color:#6c757d;width:200px">{{ __('audit.field') }}</td>
                                <td style="padding:6px 10px;font-weight:600;color:#6c757d;width:50%">{{ __('audit.old_value') }}</td>
                                <td style="padding:6px 20px 6px 10px;font-weight:600;color:#6c757d">{{ __('audit.new_value') }}</td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($log->changes as $field => $diff)
                            <tr style="border-top:1px solid #e9ebec">
                                <td style="padding:6px 10px 6px 60px;color:#495057;font-family:monospace">{{ $field }}</td>
                                <td style="padding:6px 10px;color:#c0432a;word-break:break-all;max-width:0">
                                    {{ is_array($diff['old']) ? json_encode($diff['old']) : ($diff['old'] ?? '(empty)') }}
                                </td>
                                <td style="padding:6px 20px 6px 10px;color:#0a7564;word-break:break-all;max-width:0">
                                    {{ is_array($diff['new']) ? json_encode($diff['new']) : ($diff['new'] ?? '(empty)') }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
    @endif
</div>

<div style="margin-top:16px">
    {{ $logs->links() }}
</div>

@push('scripts')
<script>
function toggleChanges(id) {
    const row = document.getElementById(id);
    if (row) row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
}
</script>
@endpush

@endsection
