@extends('admin.layouts.app')

@section('title', $project->title)
@section('header', $project->title)
@section('breadcrumb')
    <a href="{{ route('admin.projects.index') }}">Projektek</a>
    <span style="color:#dee2e6">/</span>
    {{ $project->title }}
@endsection

@section('header-actions')
    <button onclick="openModal('edit-project-modal')" class="btn-ghost">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
        Szerkesztés
    </button>
    <button onclick="openModal('add-task-modal')" class="btn-primary">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        Feladat hozzáadása
    </button>
@endsection

@section('content')
@php
    $statusMap = [
        'tervezes'      => ['badge-warning',   'Tervezés'],
        'aktiv'         => ['badge-success',   'Aktív'],
        'lezart'        => ['badge-secondary', 'Lezárt'],
        'felfuggesztve' => ['badge-danger',    'Felfüggesztve'],
    ];
    $priorityMap = [
        'magas'    => ['badge-danger',   'Magas'],
        'kozepes'  => ['badge-info',     'Közepes'],
        'alacsony' => ['badge-secondary','Alacsony'],
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
                    <span class="nf-badge badge-danger">Lejárt</span>
                @endif
            </div>

            @if($project->description)
                <p style="font-size:0.8125rem; color:#495057; line-height:1.6; margin-bottom:16px">{{ $project->description }}</p>
            @endif

            <div style="display:flex; flex-direction:column; gap:10px; font-size:0.8125rem">
                @if($project->responsible)
                <div class="flex items-center gap-2">
                    <span style="color:#adb5bd; width:90px; flex-shrink:0">Felelős</span>
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
                    <span style="color:#adb5bd; width:90px; flex-shrink:0">Kezdés</span>
                    <span>{{ $project->start_date->format('Y.m.d') }}</span>
                </div>
                @endif
                @if($project->end_date)
                <div class="flex items-center gap-2">
                    <span style="color:#adb5bd; width:90px; flex-shrink:0">Határidő</span>
                    <span style="{{ $project->isOverdue() ? 'color:#f06548;font-weight:600' : '' }}">{{ $project->end_date->format('Y.m.d') }}</span>
                </div>
                @endif
                <div class="flex items-center gap-2">
                    <span style="color:#adb5bd; width:90px; flex-shrink:0">Létrehozta</span>
                    <span>{{ $project->creator->name ?? '—' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <span style="color:#adb5bd; width:90px; flex-shrink:0">Létrehozva</span>
                    <span>{{ $project->created_at->format('Y.m.d') }}</span>
                </div>
            </div>
        </div>

        {{-- Haladás --}}
        <div class="nf-card p-5">
            <p style="font-size:0.8125rem; font-weight:600; color:#343a40; margin-bottom:12px">Haladás</p>
            <div style="font-size:2rem; font-weight:700; color:{{ $progress === 100 ? '#0ab39c' : '#405189' }}; line-height:1; margin-bottom:6px">{{ $progress }}%</div>
            <div style="height:8px; background:#f3f3f9; border-radius:4px; overflow:hidden; margin-bottom:12px">
                <div style="height:100%; width:{{ $progress }}%; background:{{ $progress === 100 ? '#0ab39c' : '#405189' }}; border-radius:4px; transition:width 0.4s"></div>
            </div>
            <div class="grid grid-cols-3 gap-2 text-center" style="font-size:0.72rem">
                <div style="background:#f8f9fa; border-radius:6px; padding:8px">
                    <p style="font-size:1.1rem; font-weight:700; color:#6c757d">{{ $taskCounts['nyitott'] }}</p>
                    <p style="color:#adb5bd">Nyitott</p>
                </div>
                <div style="background:#f8f9fa; border-radius:6px; padding:8px">
                    <p style="font-size:1.1rem; font-weight:700; color:#299cdb">{{ $taskCounts['folyamatban'] }}</p>
                    <p style="color:#adb5bd">Folyamatban</p>
                </div>
                <div style="background:#f8f9fa; border-radius:6px; padding:8px">
                    <p style="font-size:1.1rem; font-weight:700; color:#0ab39c">{{ $taskCounts['kesz'] }}</p>
                    <p style="color:#adb5bd">Kész</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Jobb: feladatlista --}}
    <div class="lg:col-span-2">
        <div class="nf-card">
            <div class="nf-card-header">
                <span>Feladatok ({{ $taskCounts['osszes'] }})</span>
                <button onclick="openModal('add-task-modal')" class="btn-primary" style="padding:5px 12px;font-size:0.75rem">
                    + Új feladat
                </button>
            </div>

            @if($tasks->isEmpty())
                <div class="p-10 text-center text-gray-400">
                    <svg width="36" height="36" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mx-auto mb-2 opacity-30"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <p class="text-sm">Még nincs feladat ebben a projektben.</p>
                </div>
            @else
                <table class="nf-table">
                    <thead>
                        <tr>
                            <th>Feladat</th>
                            <th>Prioritás</th>
                            <th>Státusz</th>
                            <th>Határidő</th>
                            <th>Felelős</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                        @php
                            $priMap = ['surgos'=>['badge-danger','Sürgős'],'magas'=>['badge-warning','Magas'],'kozepes'=>['badge-info','Közepes'],'alacsony'=>['badge-secondary','Alacsony']];
                            $stMap  = ['nyitott'=>['badge-secondary','Nyitott'],'folyamatban'=>['badge-info','Folyamatban'],'kesz'=>['badge-success','Kész']];
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
                                    <select name="status" onchange="this.form.submit()" class="nf-select" style="width:130px;padding:4px 8px;font-size:0.75rem">
                                        <option value="nyitott"     {{ $task->status==='nyitott'     ?'selected':'' }}>Nyitott</option>
                                        <option value="folyamatban" {{ $task->status==='folyamatban' ?'selected':'' }}>Folyamatban</option>
                                        <option value="kesz"        {{ $task->status==='kesz'        ?'selected':'' }}>Kész</option>
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
                                    <button type="submit" onclick="return confirm('Biztosan törli?')"
                                            style="padding:3px 8px;font-size:0.72rem;background:none;border:none;color:#f06548;cursor:pointer">
                                        Törlés
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

{{-- Feladat hozzáadása modal --}}
<div id="add-task-modal" class="nf-overlay">
    <div class="nf-modal nf-modal-lg">
        <div class="nf-modal-header">
            <span class="nf-modal-title">Feladat hozzáadása — {{ $project->title }}</span>
            <button onclick="closeModal('add-task-modal')" class="nf-modal-close">✕</button>
        </div>
        <form method="POST" action="{{ route('admin.tasks.store') }}">
            @csrf
            <input type="hidden" name="project_id" value="{{ $project->id }}">
            <div class="nf-modal-body" style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                <div style="grid-column:1/-1">
                    <label class="nf-label">Feladat megnevezése <span style="color:#f06548">*</span></label>
                    <input type="text" name="title" class="nf-input" required>
                </div>
                <div style="grid-column:1/-1">
                    <label class="nf-label">Leírás</label>
                    <textarea name="description" class="nf-input" rows="2"></textarea>
                </div>
                <div>
                    <label class="nf-label">Prioritás</label>
                    <select name="priority" class="nf-select">
                        <option value="alacsony">Alacsony</option>
                        <option value="kozepes" selected>Közepes</option>
                        <option value="magas">Magas</option>
                        <option value="surgos">Sürgős</option>
                    </select>
                </div>
                <div>
                    <label class="nf-label">Státusz</label>
                    <select name="status" class="nf-select">
                        <option value="nyitott" selected>Nyitott</option>
                        <option value="folyamatban">Folyamatban</option>
                        <option value="kesz">Kész</option>
                    </select>
                </div>
                <div>
                    <label class="nf-label">Határidő</label>
                    <input type="date" name="due_date" class="nf-input" value="{{ $project->end_date?->format('Y-m-d') }}">
                </div>
                <div>
                    <label class="nf-label">Felelős</label>
                    <select name="assigned_to" class="nf-select">
                        <option value="">— Nincs hozzárendelve —</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $user->id === $project->responsible_id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="nf-modal-footer">
                <button type="button" onclick="closeModal('add-task-modal')" class="btn-ghost">Mégse</button>
                <button type="submit" class="btn-teal">Feladat létrehozása</button>
            </div>
        </form>
    </div>
</div>

{{-- Projekt szerkesztés modal --}}
<div id="edit-project-modal" class="nf-overlay">
    <div class="nf-modal nf-modal-lg">
        <div class="nf-modal-header">
            <span class="nf-modal-title">Projekt szerkesztése</span>
            <button onclick="closeModal('edit-project-modal')" class="nf-modal-close">✕</button>
        </div>
        <form method="POST" action="{{ route('admin.projects.update', $project) }}">
            @csrf @method('PUT')
            @include('admin.projects._form', ['project' => $project, 'edit' => true])
            <div class="nf-modal-footer">
                <button type="button" onclick="closeModal('edit-project-modal')" class="btn-ghost">Mégse</button>
                <button type="submit" class="btn-primary">Mentés</button>
            </div>
        </form>
    </div>
</div>

@endsection
