@extends('admin.layouts.app')

@section('title', $project->title)
@section('header', $project->title)
@section('breadcrumb')
    <a href="{{ route('admin.projects.index') }}">{{ __('projects.title') }}</a>
    <span style="color:#dee2e6">/</span>
    {{ $project->title }}
@endsection

@section('header-actions')
    <button onclick="openModal('edit-project-modal')" class="btn-ghost">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
        {{ __('common.edit') }}
    </button>
    <button onclick="openModal('add-task-modal')" class="btn-primary">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        {{ __('projects.add_task') }}
    </button>
@endsection

@section('content')
@php
    $statusMap = [
        'tervezes'      => ['badge-warning',   __('projects.status.planning')],
        'aktiv'         => ['badge-success',   __('projects.status.active')],
        'lezart'        => ['badge-secondary', __('projects.status.completed')],
        'felfuggesztve' => ['badge-danger',    __('projects.status.on_hold')],
    ];
    $priorityMap = [
        'magas'    => ['badge-danger',    __('projects.priority.high')],
        'kozepes'  => ['badge-info',      __('projects.priority.medium')],
        'alacsony' => ['badge-secondary', __('projects.priority.low')],
    ];
    [$stClass, $stLabel] = $statusMap[$project->status]    ?? ['badge-secondary', $project->status];
    [$prClass, $prLabel] = $priorityMap[$project->priority] ?? ['badge-secondary', $project->priority];
    $progress = $project->progressPercent();
@endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-5">

    {{-- Bal: projekt részletek --}}
    <div class="lg:col-span-1 flex flex-col gap-4">

        <div class="nf-card p-5">
            <div class="flex gap-2 mb-3">
                <span class="nf-badge {{ $stClass }}">{{ $stLabel }}</span>
                <span class="nf-badge {{ $prClass }}">{{ $prLabel }}</span>
                @if($project->isOverdue())
                    <span class="nf-badge badge-danger">{{ __('projects.overdue') }}</span>
                @endif
            </div>

            @if($project->description)
                <p style="font-size:0.8125rem; color:#495057; line-height:1.6; margin-bottom:16px">{{ $project->description }}</p>
            @endif

            <div style="display:flex; flex-direction:column; gap:10px; font-size:0.8125rem">
                @if($project->responsible)
                <div class="flex items-center gap-2">
                    <span style="color:#adb5bd; width:90px; flex-shrink:0">{{ __('projects.responsible') }}</span>
                    <div class="flex items-center gap-2">
                        <div style="width:22px;height:22px;border-radius:50%;background:linear-gradient(135deg,#405189,#7a5af8);display:flex;align-items:center;justify-content:center;color:#fff;font-size:0.6rem;font-weight:700">
                            {{ strtoupper(substr($project->responsible->name, 0, 1)) }}
                        </div>
                        <span>{{ $project->responsible->name }}</span>
                    </div>
                </div>
                @endif
                @if($project->start_date)
                <div class="flex items-center gap-2">
                    <span style="color:#adb5bd; width:90px; flex-shrink:0">{{ __('projects.start_date') }}</span>
                    <span>{{ $project->start_date->format('Y.m.d') }}</span>
                </div>
                @endif
                @if($project->end_date)
                <div class="flex items-center gap-2">
                    <span style="color:#adb5bd; width:90px; flex-shrink:0">{{ __('projects.deadline') }}</span>
                    <span style="{{ $project->isOverdue() ? 'color:#f06548;font-weight:600' : '' }}">{{ $project->end_date->format('Y.m.d') }}</span>
                </div>
                @endif
                <div class="flex items-center gap-2">
                    <span style="color:#adb5bd; width:90px; flex-shrink:0">{{ __('projects.created_by') }}</span>
                    <span>{{ $project->creator->name ?? '—' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <span style="color:#adb5bd; width:90px; flex-shrink:0">{{ __('common.created_at') }}</span>
                    <span>{{ $project->created_at->format('Y.m.d') }}</span>
                </div>
            </div>
        </div>

        {{-- Haladás --}}
        <div class="nf-card p-5">
            <p style="font-size:0.8125rem; font-weight:600; color:#343a40; margin-bottom:12px">{{ __('projects.progress') }}</p>
            <div style="font-size:2rem; font-weight:700; color:{{ $progress === 100 ? '#0ab39c' : '#405189' }}; line-height:1; margin-bottom:6px">{{ $progress }}%</div>
            <div style="height:8px; background:#f3f3f9; border-radius:4px; overflow:hidden; margin-bottom:12px">
                <div style="height:100%; width:{{ $progress }}%; background:{{ $progress === 100 ? '#0ab39c' : '#405189' }}; border-radius:4px; transition:width 0.4s"></div>
            </div>
            <div class="grid grid-cols-3 gap-2 text-center" style="font-size:0.72rem">
                <div style="background:#f8f9fa; border-radius:6px; padding:8px">
                    <p style="font-size:1.1rem; font-weight:700; color:#6c757d">{{ $taskCounts['nyitott'] }}</p>
                    <p style="color:#adb5bd">{{ __('tasks.status.nyitott') }}</p>
                </div>
                <div style="background:#f8f9fa; border-radius:6px; padding:8px">
                    <p style="font-size:1.1rem; font-weight:700; color:#299cdb">{{ $taskCounts['folyamatban'] }}</p>
                    <p style="color:#adb5bd">{{ __('tasks.status.folyamatban') }}</p>
                </div>
                <div style="background:#f8f9fa; border-radius:6px; padding:8px">
                    <p style="font-size:1.1rem; font-weight:700; color:#0ab39c">{{ $taskCounts['kesz'] }}</p>
                    <p style="color:#adb5bd">{{ __('tasks.status.kesz') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Jobb: tabbed kártya --}}
    <div class="lg:col-span-2">
        <div class="nf-card">

            {{-- Tab fejléc --}}
            <div style="display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid #e9ebec;padding:0 20px">
                <div style="display:flex;gap:0">
                    <button onclick="switchTab('tab-tasks')" id="btn-tab-tasks"
                            style="padding:14px 18px;font-size:0.8125rem;font-weight:600;border:none;background:none;cursor:pointer;border-bottom:2px solid #405189;color:#405189;margin-bottom:-1px">
                        {{ __('projects.tab_tasks') }}
                        <span style="margin-left:6px;background:rgba(64,81,137,0.1);color:#405189;font-size:0.65rem;font-weight:700;padding:2px 6px;border-radius:4px">{{ $taskCounts['osszes'] }}</span>
                    </button>
                    <button onclick="switchTab('tab-members')" id="btn-tab-members"
                            style="padding:14px 18px;font-size:0.8125rem;font-weight:500;border:none;background:none;cursor:pointer;border-bottom:2px solid transparent;color:#6c757d;margin-bottom:-1px">
                        {{ __('projects.tab_members') }}
                        <span style="margin-left:6px;background:#f3f3f9;color:#6c757d;font-size:0.65rem;font-weight:700;padding:2px 6px;border-radius:4px">{{ $project->members->count() }}</span>
                    </button>
                    <button onclick="switchTab('tab-calendar')" id="btn-tab-calendar"
                            style="padding:14px 18px;font-size:0.8125rem;font-weight:500;border:none;background:none;cursor:pointer;border-bottom:2px solid transparent;color:#6c757d;margin-bottom:-1px">
                        {{ __('projects.tab_calendar') }}
                    </button>
                    <button onclick="switchTab('tab-kanban')" id="btn-tab-kanban"
                            style="padding:14px 18px;font-size:0.8125rem;font-weight:500;border:none;background:none;cursor:pointer;border-bottom:2px solid transparent;color:#6c757d;margin-bottom:-1px">
                        {{ __('projects.tab_kanban') }}
                    </button>
                    <button onclick="switchTab('tab-gantt')" id="btn-tab-gantt"
                            style="padding:14px 18px;font-size:0.8125rem;font-weight:500;border:none;background:none;cursor:pointer;border-bottom:2px solid transparent;color:#6c757d;margin-bottom:-1px">
                        {{ __('projects.tab_gantt') }}
                    </button>
                </div>
                <div id="tab-tasks-action">
                    <button onclick="openModal('add-task-modal')" class="btn-primary" style="padding:5px 12px;font-size:0.75rem">
                        + {{ __('projects.add_task') }}
                    </button>
                </div>
                <div id="tab-members-action" style="display:none"></div>
                <div id="tab-calendar-action" style="display:none"></div>
                <div id="tab-kanban-action" style="display:none">
                    <button onclick="openModal('add-task-modal')" class="btn-primary" style="padding:5px 12px;font-size:0.75rem">
                        + {{ __('projects.add_task') }}
                    </button>
                </div>
                <div id="tab-gantt-action" style="display:none"></div>
            </div>

            {{-- Feladatok tab --}}
            <div id="tab-tasks">
                @if($tasks->isEmpty())
                    <div class="p-10 text-center text-gray-400">
                        <svg width="36" height="36" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mx-auto mb-2 opacity-30"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        <p class="text-sm">{{ __('projects.no_tasks_project') }}</p>
                    </div>
                @else
                    <table class="nf-table">
                        <thead>
                            <tr>
                                <th>{{ __('tasks.col_task') }}</th>
                                <th style="width:80px">{{ __('tasks.col_priority') }}</th>
                                <th style="width:120px">{{ __('common.status') }}</th>
                                <th style="width:80px">{{ __('tasks.col_deadline') }}</th>
                                <th style="width:100px">{{ __('tasks.col_assignee') }}</th>
                                <th style="width:55px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tasks as $task)
                            @php
                                $priMap = [
                                    'surgos'   => ['badge-danger',    __('tasks.priority.surgos')],
                                    'magas'    => ['badge-warning',   __('tasks.priority.magas')],
                                    'kozepes'  => ['badge-info',      __('tasks.priority.kozepes')],
                                    'alacsony' => ['badge-secondary', __('tasks.priority.alacsony')],
                                ];
                                $stMap = [
                                    'nyitott'     => ['badge-secondary', __('tasks.status.nyitott')],
                                    'folyamatban' => ['badge-info',      __('tasks.status.folyamatban')],
                                    'kesz'        => ['badge-success',   __('tasks.status.kesz')],
                                ];
                                [$pc,$pl] = $priMap[$task->priority] ?? ['badge-secondary', $task->priority];
                                [$sc,$sl] = $stMap[$task->status]   ?? ['badge-secondary', $task->status];
                            @endphp
                            <tr>
                                <td style="max-width:220px">
                                    <p class="font-medium text-gray-800 truncate" style="font-size:0.8125rem">{{ $task->title }}</p>
                                    @if($task->description)
                                        <p class="text-xs text-gray-400 truncate mt-0.5">{{ $task->description }}</p>
                                    @endif
                                </td>
                                <td><span class="nf-badge {{ $pc }}">{{ $pl }}</span></td>
                                <td>
                                    <form method="POST" action="{{ route('admin.tasks.status', $task) }}">
                                        @csrf @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="nf-select" style="width:100%;padding:4px 6px;font-size:0.75rem">
                                            <option value="nyitott"     {{ $task->status==='nyitott'     ?'selected':'' }}>{{ __('tasks.status.nyitott') }}</option>
                                            <option value="folyamatban" {{ $task->status==='folyamatban' ?'selected':'' }}>{{ __('tasks.status.folyamatban') }}</option>
                                            <option value="kesz"        {{ $task->status==='kesz'        ?'selected':'' }}>{{ __('tasks.status.kesz') }}</option>
                                        </select>
                                    </form>
                                </td>
                                <td style="font-size:0.8rem; {{ $task->isOverdue() ? 'color:#f06548;font-weight:600' : 'color:#495057' }}">
                                    {{ $task->due_date?->format('Y.m.d') ?? '—' }}
                                </td>
                                <td style="font-size:0.8rem">{{ $task->assignedUser?->name ?? '—' }}</td>
                                <td>
                                    <form method="POST" action="{{ route('admin.tasks.destroy', $task) }}">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('{{ __('common.confirm_delete') }}')"
                                                style="padding:3px 8px;font-size:0.72rem;background:none;border:none;color:#f06548;cursor:pointer;white-space:nowrap">
                                            {{ __('common.delete') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            {{-- Csapattagok tab --}}
            <div id="tab-members" style="display:none">
                @if($project->members->isEmpty())
                    <div class="p-10 text-center text-gray-400">
                        <svg width="36" height="36" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mx-auto mb-2 opacity-30"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <p class="text-sm">{{ __('projects.no_members') }}</p>
                    </div>
                @else
                    <table class="nf-table">
                        <thead>
                            <tr>
                                <th>{{ __('projects.col_member') }}</th>
                                <th>{{ __('projects.col_role') }}</th>
                                <th style="width:60px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($project->members as $member)
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:10px">
                                        @if($member->photo)
                                            <div style="width:32px;height:32px;border-radius:50%;overflow:hidden;flex-shrink:0">
                                                <img src="{{ asset('storage/' . $member->photo) }}" style="width:100%;height:100%;object-fit:cover" alt="">
                                            </div>
                                        @else
                                            <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#405189,#7a5af8);display:flex;align-items:center;justify-content:center;color:#fff;font-size:0.7rem;font-weight:700;flex-shrink:0">
                                                {{ strtoupper(substr($member->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <span style="font-weight:500;color:#343a40;font-size:0.8125rem">{{ $member->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    @foreach($member->roles as $role)
                                        @php $rc=['super-admin'=>'badge-danger','admin'=>'badge-primary','editor'=>'badge-warning','member'=>'badge-secondary']; @endphp
                                        <span class="nf-badge {{ $rc[$role->name] ?? 'badge-secondary' }}">{{ __('users.roles.' . $role->name, [], null) ?: $role->name }}</span>
                                    @endforeach
                                </td>
                                <td style="text-align:right">
                                    <form method="POST" action="{{ route('admin.projects.members.remove', [$project, $member]) }}">
                                        @csrf @method('DELETE')
                                        <button type="submit" title="{{ __('common.delete') }}"
                                                style="background:none;border:none;cursor:pointer;color:#adb5bd;padding:4px"
                                                onmouseover="this.style.color='#f06548'" onmouseout="this.style.color='#adb5bd'">
                                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                <div style="padding:14px 20px;border-top:1px solid #e9ebec">
                    <form method="POST" action="{{ route('admin.projects.members.add', $project) }}" style="display:flex;gap:8px">
                        @csrf
                        <select name="user_id" class="nf-select" style="flex:1;max-width:280px" required>
                            <option value="">{{ __('projects.member_select') }}</option>
                            @foreach($users->whereNotIn('id', $project->members->pluck('id')) as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn-teal" style="padding:7px 14px;font-size:0.8125rem">{{ __('projects.member_add') }}</button>
                    </form>
                </div>
            </div>

            {{-- Naptár tab --}}
            <div id="tab-calendar" style="display:none;padding:20px">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
                    <button onclick="calNav(-1)" style="background:none;border:1px solid #e9ebec;border-radius:6px;padding:5px 10px;cursor:pointer;color:#495057">&#8592;</button>
                    <span id="cal-title" style="font-size:0.9375rem;font-weight:600;color:#343a40"></span>
                    <button onclick="calNav(1)"  style="background:none;border:1px solid #e9ebec;border-radius:6px;padding:5px 10px;cursor:pointer;color:#495057">&#8594;</button>
                </div>
                <div id="cal-grid" style="display:grid;grid-template-columns:repeat(7,1fr);gap:4px;text-align:center"></div>
                <div id="cal-day-tasks" style="margin-top:16px;display:none">
                    <p id="cal-day-label" style="font-size:0.8rem;font-weight:600;color:#495057;margin-bottom:8px"></p>
                    <div id="cal-day-list"></div>
                </div>
            </div>

            {{-- Kanban tab --}}
            <div id="tab-kanban" style="display:none;padding:16px">
                @php
                    $priColors = ['surgos'=>'#f06548','magas'=>'#c9920a','kozepes'=>'#299cdb','alacsony'=>'#6c757d'];
                    $kanbanCols = [
                        ['nyitott',     __('tasks.status.nyitott'),     '#6c757d','rgba(108,117,125,0.08)'],
                        ['folyamatban', __('tasks.status.folyamatban'), '#299cdb','rgba(41,156,219,0.08)'],
                        ['kesz',        __('tasks.status.kesz'),        '#0ab39c','rgba(10,179,156,0.08)'],
                    ];
                @endphp
                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;align-items:start">

                    @foreach($kanbanCols as [$colStatus,$colLabel,$colColor,$colBg])
                    <div class="kanban-col"
                         data-status="{{ $colStatus }}"
                         ondragover="event.preventDefault();this.style.background='{{ $colBg }}'"
                         ondragleave="this.style.background=''"
                         ondrop="onDrop(event,this)"
                         style="background:#f8f9fa;border-radius:10px;padding:10px;min-height:120px;transition:background .15s">
                        <div style="display:flex;align-items:center;gap:6px;margin-bottom:10px;padding:0 2px">
                            <span style="width:8px;height:8px;border-radius:50%;background:{{ $colColor }};flex-shrink:0"></span>
                            <span style="font-size:0.8rem;font-weight:600;color:#343a40">{{ $colLabel }}</span>
                            <span style="margin-left:auto;font-size:0.7rem;background:#fff;border:1px solid #e9ebec;border-radius:4px;padding:1px 7px;color:#6c757d;font-weight:600">
                                {{ $tasks->where('status',$colStatus)->count() }}
                            </span>
                        </div>
                        <div style="display:flex;flex-direction:column;gap:8px">
                            @foreach($tasks->where('status',$colStatus) as $task)
                            <div class="kanban-card"
                                 draggable="true"
                                 data-id="{{ $task->id }}"
                                 data-status="{{ $task->status }}"
                                 ondragstart="onDragStart(event,this)"
                                 ondragend="onDragEnd(event,this)"
                                 style="background:#fff;border:1px solid #e9ebec;border-radius:8px;padding:10px 12px;cursor:grab;box-shadow:0 1px 3px rgba(0,0,0,0.06);transition:box-shadow .15s;user-select:none"
                                 onmouseover="this.style.boxShadow='0 3px 10px rgba(0,0,0,0.1)'" onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.06)'">
                                <p style="font-size:0.8125rem;font-weight:500;color:#343a40;margin-bottom:6px;line-height:1.4">{{ $task->title }}</p>
                                <div style="display:flex;align-items:center;gap:6px;flex-wrap:wrap">
                                    <span style="font-size:0.65rem;font-weight:700;color:{{ $priColors[$task->priority] ?? '#6c757d' }};background:rgba(0,0,0,0.04);padding:2px 6px;border-radius:4px">
                                        {{ __('tasks.priority.' . $task->priority, [], null) ?: $task->priority }}
                                    </span>
                                    @if($task->due_date)
                                    <span style="font-size:0.65rem;color:{{ $task->isOverdue() ? '#f06548' : '#adb5bd' }};margin-left:auto">
                                        {{ $task->due_date->format('m.d') }}
                                    </span>
                                    @endif
                                </div>
                                @if($task->assignedUser)
                                <div style="display:flex;align-items:center;gap:5px;margin-top:7px;padding-top:7px;border-top:1px solid #f3f3f9">
                                    @if($task->assignedUser->photo)
                                        <img src="{{ asset('storage/'.$task->assignedUser->photo) }}" style="width:18px;height:18px;border-radius:50%;object-fit:cover" alt="">
                                    @else
                                        <div style="width:18px;height:18px;border-radius:50%;background:linear-gradient(135deg,#405189,#7a5af8);display:flex;align-items:center;justify-content:center;color:#fff;font-size:0.55rem;font-weight:700;flex-shrink:0">
                                            {{ strtoupper(substr($task->assignedUser->name,0,1)) }}
                                        </div>
                                    @endif
                                    <span style="font-size:0.7rem;color:#6c757d">{{ $task->assignedUser->name }}</span>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>

            {{-- Gantt tab --}}
            <div id="tab-gantt" style="display:none">
                <div style="overflow-x:auto">
                    <div id="gantt-inner"></div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Feladat hozzáadása modal --}}
<div id="add-task-modal" class="nf-overlay">
    <div class="nf-modal nf-modal-lg">
        <div class="nf-modal-header">
            <span class="nf-modal-title">{{ __('projects.add_task') }} — {{ $project->title }}</span>
            <button onclick="closeModal('add-task-modal')" class="nf-modal-close">✕</button>
        </div>
        <form method="POST" action="{{ route('admin.tasks.store') }}">
            @csrf
            <input type="hidden" name="project_id" value="{{ $project->id }}">
            <div class="nf-modal-body" style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                <div style="grid-column:1/-1">
                    <label class="nf-label">{{ __('projects.task_name') }} <span style="color:#f06548">*</span></label>
                    <input type="text" name="title" class="nf-input" required>
                </div>
                <div style="grid-column:1/-1">
                    <label class="nf-label">{{ __('common.description') }}</label>
                    <textarea name="description" class="nf-input" rows="2"></textarea>
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
                    <label class="nf-label">{{ __('tasks.col_deadline') }}</label>
                    <input type="date" name="due_date" class="nf-input" value="{{ $project->end_date?->format('Y-m-d') }}">
                </div>
                <div>
                    <label class="nf-label">{{ __('tasks.assignee') }}</label>
                    <select name="assigned_to" class="nf-select">
                        <option value="">{{ __('tasks.no_assignee') }}</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $user->id === $project->responsible_id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="nf-modal-footer">
                <button type="button" onclick="closeModal('add-task-modal')" class="btn-ghost">{{ __('common.cancel') }}</button>
                <button type="submit" class="btn-teal">{{ __('common.create') }}</button>
            </div>
        </form>
    </div>
</div>

{{-- Projekt szerkesztés modal --}}
<div id="edit-project-modal" class="nf-overlay">
    <div class="nf-modal nf-modal-lg">
        <div class="nf-modal-header">
            <span class="nf-modal-title">{{ __('projects.edit_title') }}</span>
            <button onclick="closeModal('edit-project-modal')" class="nf-modal-close">✕</button>
        </div>
        <form method="POST" action="{{ route('admin.projects.update', $project) }}">
            @csrf @method('PUT')
            @include('admin.projects._form', ['project' => $project, 'edit' => true])
            <div class="nf-modal-footer">
                <button type="button" onclick="closeModal('edit-project-modal')" class="btn-ghost">{{ __('common.cancel') }}</button>
                <button type="submit" class="btn-primary">{{ __('common.save') }}</button>
            </div>
        </form>
    </div>
</div>

@php
$ganttTasksData = $tasks->filter(fn($t) => $t->due_date)->map(fn($t) => [
    'title'  => $t->title,
    'start'  => $t->created_at->format('Y-m-d'),
    'end'    => $t->due_date->format('Y-m-d'),
    'status' => $t->status,
])->values();

$calTasksData = $tasks->filter(fn($t) => $t->due_date)->map(fn($t) => [
    'title'    => $t->title,
    'due'      => $t->due_date->format('Y-m-d'),
    'status'   => $t->status,
    'priority' => $t->priority,
])->values();

// Localized calendar strings
$calMonths   = [__('cal.jan'),__('cal.feb'),__('cal.mar'),__('cal.apr'),__('cal.may'),__('cal.jun'),__('cal.jul'),__('cal.aug'),__('cal.sep'),__('cal.oct'),__('cal.nov'),__('cal.dec')];
$calDays     = [__('cal.mon'),__('cal.tue'),__('cal.wed'),__('cal.thu'),__('cal.fri'),__('cal.sat'),__('cal.sun')];
$calMonthsFull = [__('cal.january'),__('cal.february'),__('cal.march'),__('cal.april'),__('cal.may_full'),__('cal.june'),__('cal.july'),__('cal.august'),__('cal.september'),__('cal.october'),__('cal.november'),__('cal.december')];
$calMonthsGen = [__('cal.jan_gen'),__('cal.feb_gen'),__('cal.mar_gen'),__('cal.apr_gen'),__('cal.may_gen'),__('cal.jun_gen'),__('cal.jul_gen'),__('cal.aug_gen'),__('cal.sep_gen'),__('cal.oct_gen'),__('cal.nov_gen'),__('cal.dec_gen')];
@endphp

@push('scripts')
<script>
const calTasks      = @json($calTasksData);
const calMonths     = @json($calMonths);
const calDays       = @json($calDays);
const calMonthsFull = @json($calMonthsFull);
const calMonthsGen  = @json($calMonthsGen);
const noDeadlineTxt = @json(__('projects.no_deadline_tasks'));
const noTasksDayTxt = @json(__('projects.no_tasks_day'));
const taskColHeader = @json(__('tasks.col_task'));

const statusColor = { nyitott:'#6c757d', folyamatban:'#299cdb', kesz:'#0ab39c' };

let calYear, calMonth;
const ganttTasks = @json($ganttTasksData);
let ganttRendered = false;

function renderGantt() {
    if (ganttRendered) return;
    ganttRendered = true;
    const el = document.getElementById('gantt-inner');
    if (!ganttTasks.length) {
        el.innerHTML = `<div style="padding:48px;text-align:center;color:#adb5bd;font-size:0.875rem">${noDeadlineTxt}</div>`;
        return;
    }
    const DAY = 86400000, CELL = 30, LEFT_W = 190;
    const stColors = { nyitott:'#6c757d', folyamatban:'#405189', kesz:'#0ab39c' };

    const allD = ganttTasks.flatMap(t => [new Date(t.start), new Date(t.end)]);
    let minD = new Date(Math.min(...allD.map(d=>d.getTime())));
    let maxD = new Date(Math.max(...allD.map(d=>d.getTime())));
    minD = new Date(minD.getFullYear(), minD.getMonth(), 1);
    maxD = new Date(maxD.getFullYear(), maxD.getMonth()+1, 0);

    const totalDays = Math.ceil((maxD - minD) / DAY) + 1;
    const today = new Date(); today.setHours(0,0,0,0);
    const todayOff = Math.floor((today - minD) / DAY);

    let mHtml = '', cur = new Date(minD);
    while (cur <= maxD) {
        const last = new Date(cur.getFullYear(), cur.getMonth()+1, 0);
        const clamped = last > maxD ? maxD : last;
        const span = Math.floor((clamped - cur) / DAY) + 1;
        mHtml += `<div style="width:${span*CELL}px;flex-shrink:0;padding:4px 6px;font-size:0.68rem;font-weight:600;color:#495057;border-right:1px solid #e9ebec;overflow:hidden;white-space:nowrap">${calMonths[cur.getMonth()]} ${cur.getFullYear()}</div>`;
        cur = new Date(cur.getFullYear(), cur.getMonth()+1, 1);
    }

    let dHtml = '';
    for (let i = 0; i < totalDays; i++) {
        const d = new Date(minD.getTime() + i*DAY);
        const isT = i === todayOff;
        const isW = d.getDay()===0 || d.getDay()===6;
        dHtml += `<div style="width:${CELL}px;flex-shrink:0;text-align:center;font-size:0.58rem;color:${isT?'#405189':isW?'#bbb':'#adb5bd'};font-weight:${isT?700:400};padding:2px 0;border-right:1px solid #f3f3f9">${d.getDate()}</div>`;
    }

    const todayLine = todayOff>=0 && todayOff<totalDays
        ? `<div style="position:absolute;left:${todayOff*CELL}px;top:0;bottom:0;width:2px;background:rgba(240,101,72,0.5);z-index:1;pointer-events:none"></div>` : '';

    let rows = ganttTasks.map(t => {
        const s = new Date(t.start), e = new Date(t.end);
        const sOff = Math.max(0, Math.floor((s-minD)/DAY));
        const eOff = Math.min(totalDays-1, Math.floor((e-minD)/DAY));
        const bLeft = sOff*CELL, bW = Math.max(CELL, (eOff-sOff+1)*CELL);
        const overdue = e < today && t.status !== 'kesz';
        const color = overdue ? '#f06548' : (stColors[t.status]||'#405189');
        return `<div style="display:flex;align-items:center;border-bottom:1px solid #f3f3f9;min-height:34px">
            <div style="width:${LEFT_W}px;flex-shrink:0;padding:4px 12px;font-size:0.78rem;color:#343a40;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;border-right:1px solid #e9ebec" title="${t.title}">${t.title}</div>
            <div style="position:relative;height:34px;width:${totalDays*CELL}px;flex-shrink:0">
                ${todayLine}
                <div style="position:absolute;left:${bLeft}px;top:7px;height:20px;width:${bW}px;background:${color};border-radius:4px;opacity:0.85;display:flex;align-items:center;padding:0 7px;z-index:2">
                    <span style="font-size:0.62rem;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:${bW-14}px">${t.title}</span>
                </div>
            </div>
        </div>`;
    }).join('');

    el.innerHTML = `<div style="min-width:${LEFT_W+totalDays*CELL}px">
        <div style="display:flex;border-bottom:2px solid #e9ebec;background:#f8f9fa">
            <div style="width:${LEFT_W}px;flex-shrink:0;padding:6px 12px;font-size:0.7rem;font-weight:600;color:#6c757d;border-right:1px solid #e9ebec">${taskColHeader}</div>
            <div style="display:flex">${mHtml}</div>
        </div>
        <div style="display:flex;border-bottom:1px solid #e9ebec;background:#fafafa">
            <div style="width:${LEFT_W}px;flex-shrink:0;border-right:1px solid #e9ebec"></div>
            <div style="display:flex">${dHtml}</div>
        </div>
        ${rows}
    </div>`;
}

function switchTab(active) {
    const tabs    = ['tab-tasks', 'tab-members', 'tab-calendar', 'tab-kanban', 'tab-gantt'];
    const buttons = { 'tab-tasks':'btn-tab-tasks', 'tab-members':'btn-tab-members', 'tab-calendar':'btn-tab-calendar', 'tab-kanban':'btn-tab-kanban', 'tab-gantt':'btn-tab-gantt' };
    const actions = { 'tab-tasks':'tab-tasks-action', 'tab-members':'tab-members-action', 'tab-calendar':'tab-calendar-action', 'tab-kanban':'tab-kanban-action', 'tab-gantt':'tab-gantt-action' };
    tabs.forEach(id => {
        const isActive = id === active;
        document.getElementById(id).style.display = isActive ? '' : 'none';
        document.getElementById(actions[id]).style.display = isActive ? '' : 'none';
        const btn = document.getElementById(buttons[id]);
        btn.style.borderBottomColor = isActive ? '#405189' : 'transparent';
        btn.style.color             = isActive ? '#405189' : '#6c757d';
        btn.style.fontWeight        = isActive ? '600'     : '500';
    });
    if (active === 'tab-calendar' && !calYear) {
        const now = new Date();
        calYear = now.getFullYear();
        calMonth = now.getMonth();
        renderCal();
    }
    if (active === 'tab-gantt') renderGantt();
}

function calNav(dir) {
    calMonth += dir;
    if (calMonth > 11) { calMonth = 0;  calYear++; }
    if (calMonth < 0)  { calMonth = 11; calYear--; }
    renderCal();
    document.getElementById('cal-day-tasks').style.display = 'none';
}

function renderCal() {
    document.getElementById('cal-title').textContent = calYear + '. ' + calMonthsFull[calMonth];

    const taskMap = {};
    calTasks.forEach(t => { (taskMap[t.due] = taskMap[t.due] || []).push(t); });

    const today = new Date().toISOString().slice(0,10);
    const firstDay = new Date(calYear, calMonth, 1).getDay();
    const offset   = (firstDay === 0) ? 6 : firstDay - 1;
    const daysInMonth = new Date(calYear, calMonth + 1, 0).getDate();

    let html = calDays.map(d => `<div style="font-size:0.7rem;font-weight:600;color:#adb5bd;padding:4px 0">${d}</div>`).join('');

    for (let i = 0; i < offset; i++) html += '<div></div>';

    for (let d = 1; d <= daysInMonth; d++) {
        const key  = calYear + '-' + String(calMonth+1).padStart(2,'0') + '-' + String(d).padStart(2,'0');
        const isToday = key === today;
        const tasks   = taskMap[key] || [];
        const dots    = tasks.map(t => `<span style="display:inline-block;width:6px;height:6px;border-radius:50%;background:${statusColor[t.status]||'#405189'};margin:0 1px"></span>`).join('');
        html += `<div onclick="showDayTasks('${key}',${d})"
            style="border-radius:8px;padding:6px 2px;cursor:pointer;min-height:48px;
                   background:${isToday?'rgba(64,81,137,0.08)':'#fafafa'};
                   border:1px solid ${isToday?'#405189':'#e9ebec'};
                   transition:background .15s"
            onmouseover="this.style.background='#f0f2ff'" onmouseout="this.style.background='${isToday?'rgba(64,81,137,0.08)':'#fafafa'}'">
            <div style="font-size:0.78rem;font-weight:${isToday?700:400};color:${isToday?'#405189':'#495057'}">${d}</div>
            <div style="margin-top:3px">${dots}</div>
        </div>`;
    }
    document.getElementById('cal-grid').innerHTML = html;
}

let dragCard = null;

function onDragStart(e, el) {
    dragCard = el;
    setTimeout(() => el.style.opacity = '0.4', 0);
}

function onDragEnd(e, el) {
    el.style.opacity = '1';
    document.querySelectorAll('.kanban-col').forEach(c => c.style.background = '');
}

function onDrop(e, col) {
    e.preventDefault();
    col.style.background = '';
    if (!dragCard) return;

    const newStatus = col.dataset.status;
    const oldStatus = dragCard.dataset.status;
    if (newStatus === oldStatus) return;

    const taskId = dragCard.dataset.id;

    const list = col.querySelector('div[style*="flex-direction:column"]');
    list.appendChild(dragCard);
    dragCard.dataset.status = newStatus;

    document.querySelectorAll('.kanban-col').forEach(c => {
        const count = c.querySelectorAll('.kanban-card').length;
        c.querySelector('span[style*="border-radius:4px"]').textContent = count;
    });

    fetch('{{ url("admin/tasks") }}/' + taskId + '/status', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ _method: 'PATCH', status: newStatus })
    });

    dragCard = null;
}

function showDayTasks(key, day) {
    const tasks  = calTasks.filter(t => t.due === key);
    const panel  = document.getElementById('cal-day-tasks');
    document.getElementById('cal-day-label').textContent = calYear + '. ' + calMonthsGen[calMonth] + ' ' + day + '.';
    if (tasks.length === 0) {
        document.getElementById('cal-day-list').innerHTML = `<p style="font-size:0.8rem;color:#adb5bd">${noTasksDayTxt}</p>`;
    } else {
        document.getElementById('cal-day-list').innerHTML = tasks.map(t =>
            `<div style="display:flex;align-items:center;gap:8px;padding:6px 10px;background:#f8f9fa;border-radius:6px;margin-bottom:4px">
                <span style="width:8px;height:8px;border-radius:50%;background:${statusColor[t.status]||'#405189'};flex-shrink:0"></span>
                <span style="font-size:0.8125rem;color:#343a40;flex:1">${t.title}</span>
                <span style="font-size:0.7rem;color:#adb5bd">${t.status}</span>
            </div>`
        ).join('');
    }
    panel.style.display = '';
}
</script>
@endpush

@endsection
