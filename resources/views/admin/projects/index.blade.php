@extends('admin.layouts.app')

@section('title', 'Projektek')
@section('header', 'Projektkezelő')
@section('breadcrumb') Projektek @endsection

@section('header-actions')
    <button onclick="openModal('project-create-modal')" class="btn-primary">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        Új projekt
    </button>
@endsection

@section('content')

{{-- Stat kártyák --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="nf-card p-4 flex items-center gap-3">
        <div class="stat-icon" style="width:40px;height:40px;background:rgba(64,81,137,0.1)">
            <svg width="18" height="18" style="color:#405189" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
        </div>
        <div>
            <p class="text-xl font-bold text-gray-800">{{ $counts['osszes'] }}</p>
            <p class="text-xs text-gray-500">Összes projekt</p>
        </div>
    </div>
    <div class="nf-card p-4 flex items-center gap-3">
        <div class="stat-icon" style="width:40px;height:40px;background:rgba(10,179,156,0.1)">
            <svg width="18" height="18" style="color:#0ab39c" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
        </div>
        <div>
            <p class="text-xl font-bold text-gray-800">{{ $counts['aktiv'] }}</p>
            <p class="text-xs text-gray-500">Aktív</p>
        </div>
    </div>
    <div class="nf-card p-4 flex items-center gap-3">
        <div class="stat-icon" style="width:40px;height:40px;background:rgba(247,184,75,0.1)">
            <svg width="18" height="18" style="color:#f7b84b" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="text-xl font-bold text-gray-800">{{ $counts['tervezes'] }}</p>
            <p class="text-xs text-gray-500">Tervezés alatt</p>
        </div>
    </div>
    <div class="nf-card p-4 flex items-center gap-3">
        <div class="stat-icon" style="width:40px;height:40px;background:rgba(108,117,125,0.1)">
            <svg width="18" height="18" style="color:#6c757d" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        </div>
        <div>
            <p class="text-xl font-bold text-gray-800">{{ $counts['lezart'] }}</p>
            <p class="text-xs text-gray-500">Lezárt</p>
        </div>
    </div>
</div>

{{-- Projektek kártyái --}}
@if($projects->isEmpty())
    <div class="nf-card p-12 text-center text-gray-400">
        <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mx-auto mb-3 opacity-30"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
        <p class="text-sm">Még nincs projekt. Hozz létre egyet!</p>
    </div>
@else
<div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-5 mb-5">
    @foreach($projects as $project)
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
        [$stClass, $stLabel] = $statusMap[$project->status]   ?? ['badge-secondary', $project->status];
        [$prClass, $prLabel] = $priorityMap[$project->priority] ?? ['badge-secondary', $project->priority];
        $progress = $project->tasks_count > 0 ? round($project->kesz_count / $project->tasks_count * 100) : 0;
    @endphp
    <div class="nf-card flex flex-col" style="min-height:200px">
        <div style="padding:16px 20px 12px; border-bottom:1px solid #f3f3f9">
            <div class="flex items-start justify-between gap-2 mb-2">
                <a href="{{ route('admin.projects.show', $project) }}"
                   class="font-semibold text-gray-800 hover:text-indigo-700 leading-snug"
                   style="font-size:0.9rem; text-decoration:none">
                    {{ $project->title }}
                </a>
                <div class="flex gap-1 flex-shrink-0">
                    <span class="nf-badge {{ $stClass }}">{{ $stLabel }}</span>
                    <span class="nf-badge {{ $prClass }}">{{ $prLabel }}</span>
                </div>
            </div>
            @if($project->description)
                <p class="text-xs text-gray-400 line-clamp-2">{{ $project->description }}</p>
            @endif
        </div>

        <div style="padding:12px 20px; flex:1">
            {{-- Haladás --}}
            <div class="mb-3">
                <div class="flex justify-between mb-1" style="font-size:0.72rem; color:#6c757d">
                    <span>Haladás</span>
                    <span>{{ $project->kesz_count }}/{{ $project->tasks_count }} feladat · {{ $progress }}%</span>
                </div>
                <div style="height:6px; background:#f3f3f9; border-radius:3px; overflow:hidden">
                    <div style="height:100%; width:{{ $progress }}%; background:{{ $progress === 100 ? '#0ab39c' : '#405189' }}; border-radius:3px; transition:width 0.3s"></div>
                </div>
            </div>

            {{-- Meta --}}
            <div class="flex flex-wrap gap-x-4 gap-y-1" style="font-size:0.75rem; color:#adb5bd">
                @if($project->responsible)
                    <span>👤 {{ $project->responsible->name }}</span>
                @endif
                @if($project->end_date)
                    <span style="{{ $project->isOverdue() ? 'color:#f06548;font-weight:600' : '' }}">
                        📅 {{ $project->end_date->format('Y.m.d') }}
                        @if($project->isOverdue()) · Lejárt @endif
                    </span>
                @endif
            </div>
        </div>

        <div style="padding:10px 20px; border-top:1px solid #f3f3f9; display:flex; gap:8px">
            <a href="{{ route('admin.projects.show', $project) }}" class="btn-ghost" style="padding:5px 12px;font-size:0.75rem;flex:1;justify-content:center">Megnyitás</a>
            <button onclick="openEditProjectModal({{ $project->id }}, {{ json_encode($project->title) }}, {{ json_encode($project->description) }}, '{{ $project->status }}', '{{ $project->priority }}', '{{ $project->start_date?->format('Y-m-d') }}', '{{ $project->end_date?->format('Y-m-d') }}', {{ $project->responsible_id ?? 'null' }})"
                    class="btn-ghost" style="padding:5px 12px;font-size:0.75rem">Szerk.</button>
            <button onclick="openModal('del-proj-{{ $project->id }}')" style="padding:5px 10px;font-size:0.75rem;background:none;border:1px solid transparent;border-radius:5px;color:#f06548;cursor:pointer" onmouseover="this.style.background='rgba(240,101,72,0.08)'" onmouseout="this.style.background='none'">Törlés</button>
        </div>
    </div>

    {{-- Törlés modal --}}
    <div id="del-proj-{{ $project->id }}" class="nf-overlay">
        <div class="nf-modal">
            <div class="nf-modal-header">
                <span class="nf-modal-title">Projekt törlése</span>
                <button onclick="closeModal('del-proj-{{ $project->id }}')" class="nf-modal-close">✕</button>
            </div>
            <div class="nf-modal-body">
                <p style="font-size:0.875rem;color:#495057">Biztosan törli a <strong>„{{ $project->title }}"</strong> projektet? A hozzárendelt feladatok megmaradnak, de projekt nélkül lesznek.</p>
            </div>
            <div class="nf-modal-footer">
                <button onclick="closeModal('del-proj-{{ $project->id }}')" class="btn-ghost">Mégse</button>
                <form method="POST" action="{{ route('admin.projects.destroy', $project) }}">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-danger">Törlés</button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@if($projects->hasPages())
    {{ $projects->links() }}
@endif
@endif

{{-- Létrehozás modal --}}
<div id="project-create-modal" class="nf-overlay">
    <div class="nf-modal nf-modal-lg">
        <div class="nf-modal-header">
            <span class="nf-modal-title">Új projekt</span>
            <button onclick="closeModal('project-create-modal')" class="nf-modal-close">✕</button>
        </div>
        <form method="POST" action="{{ route('admin.projects.store') }}">
            @csrf
            @include('admin.projects._form', ['project' => null])
            <div class="nf-modal-footer">
                <button type="button" onclick="closeModal('project-create-modal')" class="btn-ghost">Mégse</button>
                <button type="submit" class="btn-teal">Létrehozás</button>
            </div>
        </form>
    </div>
</div>

{{-- Szerkesztés modal --}}
<div id="project-edit-modal" class="nf-overlay">
    <div class="nf-modal nf-modal-lg">
        <div class="nf-modal-header">
            <span class="nf-modal-title">Projekt szerkesztése</span>
            <button onclick="closeModal('project-edit-modal')" class="nf-modal-close">✕</button>
        </div>
        <form method="POST" id="edit-project-form" action="">
            @csrf @method('PUT')
            @include('admin.projects._form', ['project' => null, 'edit' => true])
            <div class="nf-modal-footer">
                <button type="button" onclick="closeModal('project-edit-modal')" class="btn-ghost">Mégse</button>
                <button type="submit" class="btn-primary">Mentés</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openEditProjectModal(id, title, desc, status, priority, startDate, endDate, responsibleId) {
    document.getElementById('edit-project-form').action = '/admin/projects/' + id;
    document.getElementById('ep-title').value       = title;
    document.getElementById('ep-description').value = desc || '';
    document.getElementById('ep-status').value      = status;
    document.getElementById('ep-priority').value    = priority;
    document.getElementById('ep-start').value       = startDate || '';
    document.getElementById('ep-end').value         = endDate || '';
    document.getElementById('ep-responsible').value = responsibleId || '';
    openModal('project-edit-modal');
}
</script>
@endpush
