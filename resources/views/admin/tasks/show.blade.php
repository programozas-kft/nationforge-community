@extends('admin.layouts.app')

@section('title', __('tasks.show_title', ['title' => $task->title]))
@section('header', $task->title)
@section('breadcrumb')
    <a href="{{ route('admin.tasks.index') }}">{{ __('tasks.title') }}</a>
    <span class="breadcrumb-sep">/</span>
    <span class="text-gray-700">{{ Str::limit($task->title, 40) }}</span>
@endsection

@section('header-actions')
    <a href="{{ route('admin.tasks.index') }}" class="btn-ghost">
        ← {{ __('tasks.back') }}
    </a>
@endsection

@section('content')

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

<div style="display:grid;grid-template-columns:1fr 1.4fr;gap:24px;align-items:start">

{{-- Bal: feladat adatok --}}
<div style="display:flex;flex-direction:column;gap:20px">

    {{-- Fejléc kártya --}}
    <div class="nf-card">
        <div class="nf-card-header">{{ __('tasks.details') }}</div>
        <div class="p-5" style="display:flex;flex-direction:column;gap:16px">

            {{-- Cím --}}
            <div>
                <p class="nf-label mb-1">{{ __('tasks.task_name') }}</p>
                <p style="font-size:0.9375rem;font-weight:600;color:#212529">{{ $task->title }}</p>
            </div>

            {{-- Leírás --}}
            @if($task->description)
            <div>
                <p class="nf-label mb-1">{{ __('tasks.description') }}</p>
                <p style="font-size:0.875rem;color:#495057;white-space:pre-wrap;line-height:1.6">{{ $task->description }}</p>
            </div>
            @endif

            {{-- Státusz + Prioritás --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                <div>
                    <p class="nf-label mb-1">{{ __('tasks.col_status') }}</p>
                    <form method="POST" action="{{ route('admin.tasks.status', $task) }}">
                        @csrf @method('PATCH')
                        <select name="status" onchange="this.form.submit()" class="nf-select" style="width:100%">
                            <option value="nyitott"     {{ $task->status === 'nyitott'     ? 'selected' : '' }}>{{ __('tasks.status.nyitott') }}</option>
                            <option value="folyamatban" {{ $task->status === 'folyamatban' ? 'selected' : '' }}>{{ __('tasks.status.folyamatban') }}</option>
                            <option value="kesz"        {{ $task->status === 'kesz'        ? 'selected' : '' }}>{{ __('tasks.status.kesz') }}</option>
                        </select>
                    </form>
                </div>
                <div>
                    <p class="nf-label mb-1">{{ __('tasks.col_priority') }}</p>
                    <span class="nf-badge {{ $priClass }}">{{ $priLabel }}</span>
                </div>
            </div>

            {{-- Határidő --}}
            <div>
                <p class="nf-label mb-1">{{ __('tasks.deadline') }}</p>
                @if($task->due_date)
                    <span style="font-size:0.875rem;{{ $task->isOverdue() ? 'color:#f06548;font-weight:600' : 'color:#495057' }}">
                        {{ $task->due_date->format('Y. m. d.') }}
                        @if($task->isOverdue())
                            <span class="nf-badge badge-danger ml-2">{{ __('tasks.overdue') }}</span>
                        @endif
                    </span>
                @else
                    <span class="text-gray-400">—</span>
                @endif
            </div>

            {{-- Felelős --}}
            <div>
                <p class="nf-label mb-1">{{ __('tasks.assignee') }}</p>
                @if($task->assignedUser)
                    <div class="flex items-center gap-2">
                        @if($task->assignedUser->photo)
                            <div style="width:28px;height:28px;border-radius:50%;overflow:hidden;flex-shrink:0">
                                <img src="{{ asset('storage/' . $task->assignedUser->photo) }}" style="width:100%;height:100%;object-fit:cover" alt="">
                            </div>
                        @else
                            <div style="width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,#405189,#7a5af8);display:flex;align-items:center;justify-content:center;color:#fff;font-size:0.7rem;font-weight:700;flex-shrink:0">
                                {{ strtoupper(substr($task->assignedUser->name, 0, 1)) }}
                            </div>
                        @endif
                        <span style="font-size:0.875rem;color:#212529">{{ $task->assignedUser->name }}</span>
                    </div>
                @else
                    <span class="text-gray-400">—</span>
                @endif
            </div>

            {{-- Projekt --}}
            <div>
                <p class="nf-label mb-1">{{ __('tasks.project') }}</p>
                @if($task->project)
                    <a href="{{ route('admin.projects.show', $task->project) }}" class="nf-badge badge-primary" style="text-decoration:none">
                        {{ $task->project->title }}
                    </a>
                @else
                    <span class="text-gray-400">—</span>
                @endif
            </div>

            {{-- Létrehozó + dátum --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;padding-top:8px;border-top:1px solid #f0f0f5">
                <div>
                    <p class="nf-label mb-1">{{ __('tasks.col_creator') }}</p>
                    <span style="font-size:0.8125rem;color:#6c757d">{{ $task->creator->name ?? '—' }}</span>
                </div>
                <div>
                    <p class="nf-label mb-1">{{ __('common.created_at') }}</p>
                    <span style="font-size:0.8125rem;color:#6c757d">{{ $task->created_at->format('Y.m.d H:i') }}</span>
                </div>
            </div>

        </div>
    </div>

    {{-- Csatolmányok --}}
    <div class="nf-card">
        <div class="nf-card-header">
            <span>{{ __('tasks.attachments') }}</span>
            <span class="text-xs font-normal text-gray-400">{{ $task->attachments->count() }}</span>
        </div>

        {{-- Feltöltési form --}}
        <div class="p-4" style="border-bottom:1px solid #f0f0f5">
            <form method="POST" action="{{ route('admin.tasks.attachments.store', $task) }}" enctype="multipart/form-data">
                @csrf
                <div class="flex items-center gap-3">
                    <input type="file" name="file" class="nf-input" style="flex:1;padding:5px 8px;font-size:0.8rem" required>
                    <button type="submit" class="btn-primary" style="white-space:nowrap;flex-shrink:0">
                        {{ __('tasks.attach_upload') }}
                    </button>
                </div>
                <p style="font-size:0.75rem;color:#adb5bd;margin-top:6px">{{ __('tasks.attach_hint') }}</p>
                @error('file')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </form>
        </div>

        {{-- Csatolmányok listája --}}
        @if($task->attachments->isEmpty())
            <div class="p-6 text-center text-gray-400 text-sm">{{ __('tasks.attach_none') }}</div>
        @else
            <div style="display:flex;flex-direction:column">
                @foreach($task->attachments as $attachment)
                    @php
                        $ext = strtolower(pathinfo($attachment->filename, PATHINFO_EXTENSION));
                        $iconColor = match(true) {
                            in_array($ext, ['pdf'])                      => '#f06548',
                            in_array($ext, ['doc','docx'])               => '#405189',
                            in_array($ext, ['xls','xlsx','csv'])         => '#0ab39c',
                            in_array($ext, ['ppt','pptx'])               => '#f7b84b',
                            in_array($ext, ['jpg','jpeg','png','gif','webp']) => '#7a5af8',
                            in_array($ext, ['zip','rar'])                => '#6c757d',
                            default                                      => '#adb5bd',
                        };
                    @endphp
                    <div style="display:flex;align-items:center;gap:12px;padding:10px 16px;border-bottom:1px solid #f8f9fa">
                        <div style="width:32px;height:32px;border-radius:6px;background:{{ $iconColor }}1a;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                            <span style="font-size:0.65rem;font-weight:700;color:{{ $iconColor }};text-transform:uppercase">{{ $ext }}</span>
                        </div>
                        <div style="flex:1;min-width:0">
                            <p style="font-size:0.8125rem;font-weight:500;color:#212529;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $attachment->filename }}</p>
                            <p style="font-size:0.75rem;color:#adb5bd">{{ $attachment->size_formatted }} · {{ $attachment->user->name ?? '—' }} · {{ $attachment->created_at->format('Y.m.d') }}</p>
                        </div>
                        <div class="flex items-center gap-2" style="flex-shrink:0">
                            <a href="{{ route('admin.tasks.attachments.download', [$task, $attachment]) }}"
                               class="btn-ghost" style="padding:3px 10px;font-size:0.75rem">
                                {{ __('tasks.attach_download') }}
                            </a>
                            <form method="POST" action="{{ route('admin.tasks.attachments.destroy', [$task, $attachment]) }}"
                                  onsubmit="return confirm('{{ __('tasks.attach_delete_confirm') }}')">
                                @csrf @method('DELETE')
                                <button type="submit" style="padding:3px 10px;font-size:0.75rem;background:none;border:1px solid transparent;color:#f06548;cursor:pointer;border-radius:5px" onmouseover="this.style.background='rgba(240,101,72,0.08)'" onmouseout="this.style.background='none'">
                                    {{ __('tasks.comment_delete') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>

{{-- Jobb: Hozzászólások --}}
<div class="nf-card">
    <div class="nf-card-header">
        <span>{{ __('tasks.comments') }}</span>
        <span class="text-xs font-normal text-gray-400">{{ $task->comments->count() }}</span>
    </div>

    {{-- Komment írás --}}
    <div class="p-4" style="border-bottom:1px solid #f0f0f5">
        <form method="POST" action="{{ route('admin.tasks.comments.store', $task) }}">
            @csrf
            <textarea name="body" class="nf-input" rows="3"
                      placeholder="{{ __('tasks.comment_body') }}"
                      style="resize:vertical;min-height:80px"
                      required>{{ old('body') }}</textarea>
            @error('body')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            <div class="flex justify-end mt-3">
                <button type="submit" class="btn-primary">{{ __('tasks.comment_submit') }}</button>
            </div>
        </form>
    </div>

    {{-- Kommentek listája --}}
    @if($task->comments->isEmpty())
        <div class="p-8 text-center text-gray-400 text-sm">{{ __('tasks.comment_none') }}</div>
    @else
        <div style="display:flex;flex-direction:column;gap:0">
            @foreach($task->comments as $comment)
                <div style="padding:16px;border-bottom:1px solid #f8f9fa">
                    <div class="flex items-start gap-3">
                        {{-- Avatar --}}
                        @if($comment->user?->photo)
                            <div style="width:32px;height:32px;border-radius:50%;overflow:hidden;flex-shrink:0;margin-top:2px">
                                <img src="{{ asset('storage/' . $comment->user->photo) }}" style="width:100%;height:100%;object-fit:cover" alt="">
                            </div>
                        @else
                            <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#405189,#7a5af8);display:flex;align-items:center;justify-content:center;color:#fff;font-size:0.7rem;font-weight:700;flex-shrink:0;margin-top:2px">
                                {{ strtoupper(substr($comment->user->name ?? '?', 0, 1)) }}
                            </div>
                        @endif

                        <div style="flex:1;min-width:0">
                            <div class="flex items-center justify-between gap-2 mb-1">
                                <div class="flex items-center gap-2">
                                    <span style="font-size:0.8125rem;font-weight:600;color:#212529">{{ $comment->user->name ?? '—' }}</span>
                                    <span style="font-size:0.75rem;color:#adb5bd">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                @if($comment->user_id === auth()->id() || auth()->user()->hasAnyRole(['super-admin', 'admin']))
                                    <form method="POST" action="{{ route('admin.tasks.comments.destroy', [$task, $comment]) }}"
                                          onsubmit="return confirm('{{ __('common.confirm_delete') }}')">
                                        @csrf @method('DELETE')
                                        <button type="submit" style="background:none;border:none;color:#adb5bd;cursor:pointer;font-size:0.75rem;padding:0" onmouseover="this.style.color='#f06548'" onmouseout="this.style.color='#adb5bd'">
                                            {{ __('tasks.comment_delete') }}
                                        </button>
                                    </form>
                                @endif
                            </div>
                            <p style="font-size:0.875rem;color:#495057;white-space:pre-wrap;line-height:1.6;margin:0">{{ $comment->body }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

</div>

@endsection
