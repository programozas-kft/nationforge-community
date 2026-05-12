@extends('admin.layouts.app')

@section('title', $group->name)
@section('header', $group->name)
@section('breadcrumb')
    <a href="{{ route('admin.groups.index') }}">{{ __('groups.title') }}</a>
    <span class="breadcrumb-sep">/</span>
    <span class="text-gray-700">{{ $group->name }}</span>
@endsection

@section('header-actions')
    <a href="{{ route('admin.groups.edit', $group) }}" class="btn-primary">{{ __('common.edit') }}</a>
    <form method="POST" action="{{ route('admin.groups.destroy', $group) }}" class="inline"
          onsubmit="return confirm('{{ __('common.confirm_delete') }}')">
        @csrf @method('DELETE')
        <button class="btn-danger">{{ __('common.delete') }}</button>
    </form>
@endsection

@section('content')
@php
    $groupIcons = require resource_path('views/admin/groups/icon_map.php');
    $totalMembers = $group->people->count() + $group->users->count();
    $sc = ['member'=>'badge-primary','supporter'=>'badge-success','donor'=>'badge-warning','volunteer'=>'badge-info','vip'=>'badge-purple','prospect'=>'badge-secondary','inactive'=>'badge-secondary'];
    $typeColors = [
        'community' => ['bg'=>'rgba(64,81,137,0.12)',  'color'=>'#405189'],
        'campaign'  => ['bg'=>'rgba(240,101,72,0.12)', 'color'=>'#f06548'],
        'chapter'   => ['bg'=>'rgba(10,179,156,0.12)', 'color'=>'#0ab39c'],
        'committee' => ['bg'=>'rgba(122,90,248,0.12)', 'color'=>'#7a5af8'],
        'team'      => ['bg'=>'rgba(247,184,75,0.12)', 'color'=>'#f7b84b'],
    ];
    $defaultTypeIcons = ['community'=>'users','campaign'=>'megaphone','chapter'=>'bookmark','committee'=>'building','team'=>'bolt'];
    $tc      = $typeColors[$group->type] ?? ['bg'=>'rgba(108,117,125,0.12)','color'=>'#6c757d'];
    $iconKey = $group->icon ?: ($defaultTypeIcons[$group->type] ?? 'users');
    $ti      = $groupIcons[$iconKey] ?? $groupIcons['users'];
    $roleColors = ['super-admin'=>'badge-danger','admin'=>'badge-primary','editor'=>'badge-warning','member'=>'badge-secondary'];
@endphp
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    <div class="space-y-5">
        <div class="nf-card">
            <div class="nf-card-header" style="gap:10px">
                <div style="width:32px;height:32px;border-radius:7px;background:{{ $tc['bg'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <svg width="15" height="15" fill="none" stroke="{{ $tc['color'] }}" viewBox="0 0 24 24">{!! $ti !!}</svg>
                </div>
                {{ __('common.data') }}
            </div>
            <div class="py-4 space-y-3 text-sm" style="padding-left: 24px; padding-right: 24px;">
                <div class="flex justify-between">
                    <span class="text-gray-500">{{ __('common.type') }}</span>
                    <span class="nf-badge badge-purple">{{ __('groups.type.' . $group->type) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">{{ __('groups.col_privacy') }}</span>
                    <span class="nf-badge badge-secondary">{{ __('groups.privacy.' . $group->privacy) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">{{ __('common.status') }}</span>
                    <span class="nf-badge {{ $group->is_active ? 'badge-success' : 'badge-secondary' }}">
                        {{ $group->is_active ? __('common.active') : __('common.inactive') }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">{{ __('groups.member_count') }}</span>
                    <span class="font-semibold text-gray-800">{{ $totalMembers }} {{ __('events.persons_unit') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">{{ __('common.created_at') }}</span>
                    <span class="font-medium text-gray-800">{{ $group->created_at->format('Y. m. d.') }}</span>
                </div>
            </div>
        </div>

        @if($group->description)
        <div class="nf-card p-5">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">{{ __('common.description') }}</p>
            <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-wrap">{{ $group->description }}</p>
        </div>
        @endif

        <div class="nf-card overflow-hidden">
            <div class="nf-card-header">{{ __('groups.members') }} ({{ $totalMembers }})</div>
            <table class="nf-table">
                <thead>
                    <tr>
                        <th>{{ __('common.name') }}</th>
                        <th>{{ __('groups.col_status_role') }}</th>
                        <th>{{ __('common.type') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($group->people as $person)
                    <tr>
                        <td>
                            <div class="flex items-center gap-2">
                                @if($person->photo)
                                    <div class="w-7 h-7 rounded-full overflow-hidden flex-shrink-0">
                                        <img src="{{ asset('storage/' . $person->photo) }}" class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0"
                                         style="background:linear-gradient(135deg,#405189,#7a5af8)">
                                        {{ strtoupper(substr($person->first_name, 0, 1)) }}
                                    </div>
                                @endif
                                <a href="{{ route('admin.people.show', $person) }}" class="font-medium text-gray-800 hover:text-indigo-700">
                                    {{ $person->last_name }} {{ $person->first_name }}
                                </a>
                            </div>
                        </td>
                        <td><span class="nf-badge {{ $sc[$person->status] ?? 'badge-secondary' }}">{{ __('people.status.' . $person->status) }}</span></td>
                        <td><span class="nf-badge badge-secondary">{{ __('groups.type_contact') }}</span></td>
                    </tr>
                    @endforeach

                    @foreach($group->users as $user)
                    <tr>
                        <td>
                            <div class="flex items-center gap-2">
                                @if($user->photo)
                                    <div class="w-7 h-7 rounded-full overflow-hidden flex-shrink-0">
                                        <img src="{{ asset('storage/' . $user->photo) }}" class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0"
                                         style="background:linear-gradient(135deg,#f97316,#ea580c)">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <span class="font-medium text-gray-800">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td>
                            @foreach($user->roles as $role)
                                <span class="nf-badge {{ $roleColors[$role->name] ?? 'badge-secondary' }}">{{ __('users.roles.' . $role->name) }}</span>
                            @endforeach
                        </td>
                        <td><span class="nf-badge badge-info">{{ __('groups.type_user') }}</span></td>
                    </tr>
                    @endforeach

                    @if($totalMembers === 0)
                    <tr><td colspan="3" class="py-8 text-center text-gray-400">{{ __('groups.no_members') }}</td></tr>
                    @endif
                </tbody>
            </table>
        </div>

        @include('admin.groups._files', ['group' => $group])
    </div>

    {{-- Right column: Chat --}}
    <div class="lg:col-span-2" id="chat-col" style="min-height:calc(100vh - 146px);">
        @livewire('admin.groups.group-chat', ['group' => $group])
    </div>

</div>

@push('scripts')
<script>
function fitChatPanel() {
    const col = document.getElementById('chat-col');
    if (!col) return;
    const rect = col.getBoundingClientRect();
    col.style.position = 'fixed';
    col.style.left     = Math.round(rect.left) + 'px';
    col.style.right    = '0';
    col.style.top      = '98px';
    col.style.bottom   = '0';
    col.style.height   = 'auto';
    col.style.zIndex   = '10';
}
document.addEventListener('DOMContentLoaded', fitChatPanel);
window.addEventListener('resize', function() {
    const col = document.getElementById('chat-col');
    if (col) { col.style.position = 'static'; }
    fitChatPanel();
});
</script>
@endpush
@endsection
