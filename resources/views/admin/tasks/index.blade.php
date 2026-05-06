@extends('admin.layouts.app')

@section('title', __('tasks.title'))
@section('header', __('tasks.header'))
@section('breadcrumb') {{ __('tasks.title') }} @endsection

@section('header-actions')
    <button onclick="openModal('task-create-modal')" class="btn-primary">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        {{ __('tasks.new') }}
    </button>
@endsection

@section('content')

{{-- Stat kártyák --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <a href="{{ route('admin.tasks.index') }}" class="nf-card p-4 flex items-center gap-3" style="text-decoration:none">
        <div class="stat-icon" style="width:40px;height:40px;background:rgba(64,81,137,0.1)">
            <svg width="18" height="18" style="color:#405189" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        </div>
        <div>
            <p class="text-xl font-bold text-gray-800">{{ $counts['osszes'] }}</p>
            <p class="text-xs text-gray-500">{{ __('tasks.total') }}</p>
        </div>
    </a>
    <a href="{{ route('admin.tasks.index', ['status' => 'nyitott']) }}" class="nf-card p-4 flex items-center gap-3" style="text-decoration:none">
        <div class="stat-icon" style="width:40px;height:40px;background:rgba(108,117,125,0.1)">
            <svg width="18" height="18" style="color:#6c757d" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="text-xl font-bold text-gray-800">{{ $counts['nyitott'] }}</p>
            <p class="text-xs text-gray-500">{{ __('tasks.status.nyitott') }}</p>
        </div>
    </a>
    <a href="{{ route('admin.tasks.index', ['status' => 'folyamatban']) }}" class="nf-card p-4 flex items-center gap-3" style="text-decoration:none">
        <div class="stat-icon" style="width:40px;height:40px;background:rgba(41,156,219,0.1)">
            <svg width="18" height="18" style="color:#299cdb" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
        </div>
        <div>
            <p class="text-xl font-bold text-gray-800">{{ $counts['folyamatban'] }}</p>
            <p class="text-xs text-gray-500">{{ __('tasks.status.folyamatban') }}</p>
        </div>
    </a>
    <a href="{{ route('admin.tasks.index', ['status' => 'kesz']) }}" class="nf-card p-4 flex items-center gap-3" style="text-decoration:none">
        <div class="stat-icon" style="width:40px;height:40px;background:rgba(10,179,156,0.1)">
            <svg width="18" height="18" style="color:#0ab39c" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="text-xl font-bold text-gray-800">{{ $counts['kesz'] }}</p>
            <p class="text-xs text-gray-500">{{ __('tasks.status.kesz') }}</p>
        </div>
    </a>
</div>

{{-- Szűrők --}}
<div class="nf-card mb-5">
    <form method="GET" action="{{ route('admin.tasks.index') }}" class="p-4 flex flex-wrap gap-3 items-end">
        <div>
            <label class="nf-label">{{ __('common.status') }}</label>
            <select name="status" class="nf-select" style="width:150px">
                <option value="">{{ __('tasks.filter_all') }}</option>
                <option value="nyitott"     {{ request('status') === 'nyitott'     ? 'selected' : '' }}>{{ __('tasks.status.nyitott') }}</option>
                <option value="folyamatban" {{ request('status') === 'folyamatban' ? 'selected' : '' }}>{{ __('tasks.status.folyamatban') }}</option>
                <option value="kesz"        {{ request('status') === 'kesz'        ? 'selected' : '' }}>{{ __('tasks.status.kesz') }}</option>
            </select>
        </div>
        <div>
            <label class="nf-label">{{ __('tasks.col_priority') }}</label>
            <select name="priority" class="nf-select" style="width:150px">
                <option value="">{{ __('tasks.filter_all') }}</option>
                <option value="surgos"   {{ request('priority') === 'surgos'   ? 'selected' : '' }}>{{ __('tasks.priority.surgos') }}</option>
                <option value="magas"    {{ request('priority') === 'magas'    ? 'selected' : '' }}>{{ __('tasks.priority.magas') }}</option>
                <option value="kozepes"  {{ request('priority') === 'kozepes'  ? 'selected' : '' }}>{{ __('tasks.priority.kozepes') }}</option>
                <option value="alacsony" {{ request('priority') === 'alacsony' ? 'selected' : '' }}>{{ __('tasks.priority.alacsony') }}</option>
            </select>
        </div>
        <div>
            <label class="nf-label">{{ __('tasks.assignee') }}</label>
            <select name="assigned_to" class="nf-select" style="width:170px">
                <option value="">{{ __('tasks.filter_everyone') }}</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ request('assigned_to') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="nf-label">{{ __('tasks.project') }}</label>
            <select name="project_id" class="nf-select" style="width:180px">
                <option value="">{{ __('tasks.filter_all_projects') }}</option>
                <option value="none" {{ request('project_id') === 'none' ? 'selected' : '' }}>{{ __('tasks.no_project') }}</option>
                @foreach($projects as $proj)
                    <option value="{{ $proj->id }}" {{ request('project_id') == $proj->id ? 'selected' : '' }}>{{ $proj->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="btn-primary">{{ __('tasks.filter') }}</button>
            <a href="{{ route('admin.tasks.index') }}" class="btn-ghost">{{ __('tasks.filter_clear') }}</a>
        </div>
    </form>
</div>

{{-- Táblázat --}}
<div class="nf-card">
    <div class="nf-card-header">
        <span>{{ __('tasks.title') }}
            @if(request('status'))
                <span class="nf-badge badge-info ml-2">{{ request('status') }}</span>
            @endif
        </span>
        <span class="text-xs font-normal text-gray-400">{{ $tasks->total() }} {{ __('tasks.title') }}</span>
    </div>

    @if($tasks->isEmpty())
        <div class="p-10 text-center text-gray-400">
            <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mx-auto mb-3 opacity-30"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            <p class="text-sm">{{ __('tasks.empty') }}</p>
        </div>
    @else
        <table class="nf-table">
            <thead>
                <tr>
                    <th>{{ __('tasks.col_task') }}</th>
                    <th>{{ __('tasks.col_project') }}</th>
                    <th>{{ __('tasks.col_priority') }}</th>
                    <th>{{ __('tasks.col_status') }}</th>
                    <th>{{ __('tasks.col_deadline') }}</th>
                    <th>{{ __('tasks.col_assignee') }}</th>
                    <th>{{ __('tasks.col_creator') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                @php
                    $priorityMap = [
                        'surgos'   => ['badge-danger',    __('tasks.priority.surgos')],
                        'magas'    => ['badge-warning',   __('tasks.priority.magas')],
                        'kozepes'  => ['badge-info',      __('tasks.priority.kozepes')],
                        'alacsony' => ['badge-secondary', __('tasks.priority.alacsony')],
                    ];
                    $statusMap = [
                        'nyitott'     => ['badge-secondary', __('tasks.status.nyitott')],
                        'folyamatban' => ['badge-info',      __('tasks.status.folyamatban')],
                        'kesz'        => ['badge-success',   __('tasks.status.kesz')],
                    ];
                    [$priClass, $priLabel] = $priorityMap[$task->priority] ?? ['badge-secondary', $task->priority];
                    [$stClass,  $stLabel]  = $statusMap[$task->status]    ?? ['badge-secondary', $task->status];
                @endphp
                <tr onclick="openEditModalRow(this)"
                    style="cursor:pointer"
                    onmouseover="this.style.background='#f8f9ff'"
                    onmouseout="this.style.background=''"
                    data-id="{{ $task->id }}"
                    data-title="{{ $task->title }}"
                    data-desc="{{ $task->description ?? '' }}"
                    data-status="{{ $task->status }}"
                    data-priority="{{ $task->priority }}"
                    data-due="{{ $task->due_date?->format('Y-m-d') ?? '' }}"
                    data-assigned="{{ $task->assigned_to ?? '' }}"
                    data-project="{{ $task->project_id ?? '' }}">
                    <td style="max-width:280px">
                        <p class="font-medium text-gray-800 truncate" style="font-size:0.8125rem">{{ $task->title }}</p>
                        @if($task->description)
                            <p class="text-xs text-gray-400 truncate mt-0.5">{{ $task->description }}</p>
                        @endif
                    </td>
                    <td>
                        @if($task->project)
                            <a href="{{ route('admin.projects.show', $task->project) }}"
                               class="nf-badge badge-primary" style="text-decoration:none;max-width:130px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;display:inline-block">
                                {{ $task->project->title }}
                            </a>
                        @else
                            <span class="text-gray-300">—</span>
                        @endif
                    </td>
                    <td><span class="nf-badge {{ $priClass }}">{{ $priLabel }}</span></td>
                    <td onclick="event.stopPropagation()">
                        <form method="POST" action="{{ route('admin.tasks.status', $task) }}" style="display:inline">
                            @csrf @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="nf-select" style="width:130px;padding:4px 8px;font-size:0.75rem">
                                <option value="nyitott"     {{ $task->status === 'nyitott'     ? 'selected' : '' }}>{{ __('tasks.status.nyitott') }}</option>
                                <option value="folyamatban" {{ $task->status === 'folyamatban' ? 'selected' : '' }}>{{ __('tasks.status.folyamatban') }}</option>
                                <option value="kesz"        {{ $task->status === 'kesz'        ? 'selected' : '' }}>{{ __('tasks.status.kesz') }}</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        @if($task->due_date)
                            <span style="font-size:0.8rem; {{ $task->isOverdue() ? 'color:#f06548;font-weight:600' : 'color:#495057' }}">
                                {{ $task->due_date->format('Y.m.d') }}
                                @if($task->isOverdue()) <span class="nf-badge badge-danger ml-1">{{ __('tasks.overdue') }}</span> @endif
                            </span>
                        @else
                            <span class="text-gray-300">—</span>
                        @endif
                    </td>
                    <td>
                        @if($task->assignedUser)
                            <div class="flex items-center gap-2">
                                @if($task->assignedUser->photo)
                                    <div style="width:24px;height:24px;border-radius:50%;overflow:hidden;flex-shrink:0">
                                        <img src="{{ asset('storage/' . $task->assignedUser->photo) }}" style="width:100%;height:100%;object-fit:cover" alt="">
                                    </div>
                                @else
                                    <div style="width:24px;height:24px;border-radius:50%;background:linear-gradient(135deg,#405189,#7a5af8);display:flex;align-items:center;justify-content:center;color:#fff;font-size:0.65rem;font-weight:700;flex-shrink:0">
                                        {{ strtoupper(substr($task->assignedUser->name, 0, 1)) }}
                                    </div>
                                @endif
                                <span style="font-size:0.8rem">{{ $task->assignedUser->name }}</span>
                            </div>
                        @else
                            <span class="text-gray-300">—</span>
                        @endif
                    </td>
                    <td style="font-size:0.78rem;color:#adb5bd">{{ $task->creator->name ?? '—' }}</td>
                    <td onclick="event.stopPropagation()">
                        <div class="flex items-center gap-2">
                            <button onclick="openEditModalRow(this.closest('tr'))"
                                    class="btn-ghost" style="padding:4px 10px;font-size:0.75rem">
                                {{ __('common.edit') }}
                            </button>
                            <button onclick="openModal('delete-{{ $task->id }}')" style="padding:4px 10px;font-size:0.75rem;background:none;border:none;color:#f06548;cursor:pointer;border-radius:5px;border:1px solid transparent" onmouseover="this.style.background='rgba(240,101,72,0.08)'" onmouseout="this.style.background='none'">
                                {{ __('common.delete') }}
                            </button>
                        </div>
                    </td>
                </tr>

                <div id="delete-{{ $task->id }}" class="nf-overlay">
                    <div class="nf-modal">
                        <div class="nf-modal-header">
                            <span class="nf-modal-title">{{ __('tasks.title') }} – {{ __('common.delete') }}</span>
                            <button onclick="closeModal('delete-{{ $task->id }}')" class="nf-modal-close">✕</button>
                        </div>
                        <div class="nf-modal-body">
                            <p style="font-size:0.875rem;color:#495057">{{ __('common.confirm_delete') }} <strong>„{{ $task->title }}"</strong></p>
                        </div>
                        <div class="nf-modal-footer">
                            <button onclick="closeModal('delete-{{ $task->id }}')" class="btn-ghost">{{ __('common.cancel') }}</button>
                            <form method="POST" action="{{ route('admin.tasks.destroy', $task) }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger">{{ __('common.delete') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>

        @if($tasks->hasPages())
            <div class="p-4">{{ $tasks->links() }}</div>
        @endif
    @endif
</div>

{{-- Létrehozás modal --}}
<div id="task-create-modal" class="nf-overlay">
    <div class="nf-modal nf-modal-lg">
        <div class="nf-modal-header">
            <span class="nf-modal-title">{{ __('tasks.new') }}</span>
            <button onclick="closeModal('task-create-modal')" class="nf-modal-close">✕</button>
        </div>
        <form method="POST" action="{{ route('admin.tasks.store') }}">
            @csrf
            <div class="nf-modal-body" style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                <div style="grid-column:1/-1">
                    <label class="nf-label">{{ __('tasks.task_name') }} <span style="color:#f06548">*</span></label>
                    <input type="text" name="title" class="nf-input" required>
                </div>
                <div style="grid-column:1/-1">
                    <label class="nf-label">{{ __('common.description') }}</label>
                    <textarea name="description" class="nf-input" rows="3"></textarea>
                </div>
                <div>
                    <label class="nf-label">{{ __('tasks.col_priority') }}</label>
                    <select name="priority" class="nf-select">
                        <option value="alacsony">{{ __('tasks.priority.alacsony') }}</option>
                        <option value="kozepes" selected>{{ __('tasks.priority.kozepes') }}</option>
                        <option value="magas">{{ __('tasks.priority.magas') }}</option>
                        <option value="surgos">{{ __('tasks.priority.surgos') }}</option>
                    </select>
                </div>
                <div>
                    <label class="nf-label">{{ __('common.status') }}</label>
                    <select name="status" class="nf-select">
                        <option value="nyitott" selected>{{ __('tasks.status.nyitott') }}</option>
                        <option value="folyamatban">{{ __('tasks.status.folyamatban') }}</option>
                        <option value="kesz">{{ __('tasks.status.kesz') }}</option>
                    </select>
                </div>
                <div>
                    <label class="nf-label">{{ __('tasks.deadline') }}</label>
                    <input type="date" name="due_date" class="nf-input">
                </div>
                <div>
                    <label class="nf-label">{{ __('tasks.assignee') }}</label>
                    <select name="assigned_to" class="nf-select">
                        <option value="">{{ __('tasks.no_assignee') }}</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="grid-column:1/-1">
                    <label class="nf-label">{{ __('tasks.project') }}</label>
                    <select name="project_id" class="nf-select">
                        <option value="">{{ __('tasks.no_project') }}</option>
                        @foreach($projects as $proj)
                            <option value="{{ $proj->id }}">{{ $proj->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="nf-modal-footer">
                <button type="button" onclick="closeModal('task-create-modal')" class="btn-ghost">{{ __('common.cancel') }}</button>
                <button type="submit" class="btn-teal">{{ __('common.create') }}</button>
            </div>
        </form>
    </div>
</div>

{{-- Szerkesztés modal --}}
<div id="task-edit-modal" class="nf-overlay">
    <div class="nf-modal nf-modal-lg">
        <div class="nf-modal-header">
            <span class="nf-modal-title">{{ __('tasks.edit_title') }}</span>
            <button onclick="closeModal('task-edit-modal')" class="nf-modal-close">✕</button>
        </div>
        <form method="POST" id="edit-form" action="">
            @csrf @method('PUT')
            <div class="nf-modal-body" style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                <div style="grid-column:1/-1">
                    <label class="nf-label">{{ __('tasks.task_name') }} <span style="color:#f06548">*</span></label>
                    <input type="text" name="title" id="edit-title" class="nf-input" required>
                </div>
                <div style="grid-column:1/-1">
                    <label class="nf-label">{{ __('common.description') }}</label>
                    <textarea name="description" id="edit-description" class="nf-input" rows="3"></textarea>
                </div>
                <div>
                    <label class="nf-label">{{ __('tasks.col_priority') }}</label>
                    <select name="priority" id="edit-priority" class="nf-select">
                        <option value="alacsony">{{ __('tasks.priority.alacsony') }}</option>
                        <option value="kozepes">{{ __('tasks.priority.kozepes') }}</option>
                        <option value="magas">{{ __('tasks.priority.magas') }}</option>
                        <option value="surgos">{{ __('tasks.priority.surgos') }}</option>
                    </select>
                </div>
                <div>
                    <label class="nf-label">{{ __('common.status') }}</label>
                    <select name="status" id="edit-status" class="nf-select">
                        <option value="nyitott">{{ __('tasks.status.nyitott') }}</option>
                        <option value="folyamatban">{{ __('tasks.status.folyamatban') }}</option>
                        <option value="kesz">{{ __('tasks.status.kesz') }}</option>
                    </select>
                </div>
                <div>
                    <label class="nf-label">{{ __('tasks.deadline') }}</label>
                    <input type="date" name="due_date" id="edit-due-date" class="nf-input">
                </div>
                <div>
                    <label class="nf-label">{{ __('tasks.assignee') }}</label>
                    <select name="assigned_to" id="edit-assigned" class="nf-select">
                        <option value="">{{ __('tasks.no_assignee') }}</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="grid-column:1/-1">
                    <label class="nf-label">{{ __('tasks.project') }}</label>
                    <select name="project_id" id="edit-project" class="nf-select">
                        <option value="">{{ __('tasks.no_project') }}</option>
                        @foreach($projects as $proj)
                            <option value="{{ $proj->id }}">{{ $proj->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="nf-modal-footer">
                <button type="button" onclick="closeModal('task-edit-modal')" class="btn-ghost">{{ __('common.cancel') }}</button>
                <button type="submit" class="btn-primary">{{ __('common.save') }}</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openEditModalRow(el) {
    const d = el.dataset;
    document.getElementById('edit-form').action = '{{ url("admin/tasks") }}/' + d.id;
    document.getElementById('edit-title').value       = d.title;
    document.getElementById('edit-description').value = d.desc || '';
    document.getElementById('edit-status').value      = d.status;
    document.getElementById('edit-priority').value    = d.priority;
    document.getElementById('edit-due-date').value    = d.due || '';
    document.getElementById('edit-assigned').value    = d.assigned || '';
    document.getElementById('edit-project').value     = d.project || '';
    openModal('task-edit-modal');
}
</script>
@endpush
