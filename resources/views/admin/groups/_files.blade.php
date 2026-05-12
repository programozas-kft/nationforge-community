@php
    $fileIcons = [
        'pdf'   => ['bg' => 'rgba(240,101,72,0.12)',  'color' => '#f06548', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M14 2v6h6M8 13h8M8 17h5"/>'],
        'doc'   => ['bg' => 'rgba(64,81,137,0.12)',   'color' => '#405189', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M14 2v6h6M8 13h8M8 17h5"/>'],
        'xls'   => ['bg' => 'rgba(10,179,156,0.12)',  'color' => '#0ab39c', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M14 2v6h6M9 14l3 3 3-3M12 11v6"/>'],
        'ppt'   => ['bg' => 'rgba(247,184,75,0.12)',  'color' => '#f7b84b', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M14 2v6h6"/>'],
        'zip'   => ['bg' => 'rgba(108,117,125,0.12)', 'color' => '#6c757d', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M14 2v6h6M12 11v2M12 15v2M12 19v1"/>'],
        'image' => ['bg' => 'rgba(122,90,248,0.12)',  'color' => '#7a5af8', 'svg' => '<rect x="3" y="4" width="18" height="16" rx="2" stroke-width="1.7"/><circle cx="9" cy="10" r="2" stroke-width="1.7"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M21 17l-5-5-7 7"/>'],
        'text'  => ['bg' => 'rgba(64,81,137,0.12)',   'color' => '#405189', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M14 2v6h6M8 12h8M8 16h8M8 8h3"/>'],
        'file'  => ['bg' => 'rgba(108,117,125,0.12)', 'color' => '#6c757d', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M14 2v6h6"/>'],
    ];
@endphp

<div class="nf-card mt-5 overflow-hidden">
    <div class="nf-card-header flex justify-between items-center">
        <div class="flex items-center gap-2">
            <div style="width:28px;height:28px;border-radius:7px;background:rgba(10,179,156,0.12);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <svg width="14" height="14" fill="none" stroke="#0ab39c" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                </svg>
            </div>
            <span>{{ __('group_files.title') }} ({{ $group->files->count() }})</span>
        </div>
        <button type="button" class="btn-primary text-xs" style="padding:6px 12px"
                onclick="document.getElementById('group-file-input').click()">
            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:inline;vertical-align:-1px;margin-right:4px">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            {{ __('group_files.upload') }}
        </button>
    </div>

    <form id="group-file-form" method="POST"
          action="{{ route('admin.groups.files.store', $group) }}"
          enctype="multipart/form-data"
          class="hidden">
        @csrf
        <input type="file" name="file" id="group-file-input"
               onchange="if (this.files.length) { document.getElementById('group-file-form').submit(); }">
    </form>

    @if($errors->any())
        <div class="px-5 pt-3">
            @foreach($errors->all() as $err)
                <div class="nf-error">{{ $err }}</div>
            @endforeach
        </div>
    @endif

    <div class="divide-y divide-gray-100">
        @forelse($group->files()->latest()->get() as $file)
            @php
                $icon = $fileIcons[$file->iconKey()] ?? $fileIcons['file'];
            @endphp
            <div class="flex items-center gap-3 px-5 py-3 hover:bg-gray-50 transition-colors">
                <div style="width:36px;height:36px;border-radius:8px;background:{{ $icon['bg'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <svg width="18" height="18" fill="none" stroke="{{ $icon['color'] }}" viewBox="0 0 24 24">{!! $icon['svg'] !!}</svg>
                </div>

                <div class="flex-1 min-w-0">
                    <a href="{{ route('admin.groups.files.download', [$group, $file]) }}"
                       class="block font-medium text-gray-800 text-sm hover:text-indigo-700 truncate"
                       title="{{ $file->original_name }}">
                        {{ $file->original_name }}
                    </a>
                    <div class="text-[11px] text-gray-500 mt-0.5 flex items-center gap-1.5 flex-wrap">
                        <span>{{ $file->humanSize() }}</span>
                        <span class="text-gray-300">•</span>
                        <span>{{ $file->uploader?->name ?? __('common.deleted_user') }}</span>
                        <span class="text-gray-300">•</span>
                        <span title="{{ $file->created_at->format('Y. m. d. H:i') }}">{{ $file->created_at->diffForHumans() }}</span>
                    </div>
                </div>

                <div class="flex items-center gap-1 flex-shrink-0">
                    <a href="{{ route('admin.groups.files.download', [$group, $file]) }}"
                       class="p-1.5 rounded hover:bg-gray-200 text-gray-500 hover:text-gray-700 transition-colors"
                       title="{{ __('group_files.download') }}">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/>
                        </svg>
                    </a>

                    @if($file->uploaded_by === auth()->id() || auth()->user()->isAdmin())
                        <form method="POST" action="{{ route('admin.groups.files.destroy', [$group, $file]) }}"
                              onsubmit="return confirm('{{ __('common.confirm_delete') }}')" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="p-1.5 rounded hover:bg-red-50 text-gray-400 hover:text-red-600 transition-colors"
                                    title="{{ __('common.delete') }}">
                                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/>
                                </svg>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="px-5 py-8 text-center">
                <svg class="mx-auto w-10 h-10 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                </svg>
                <p class="text-sm text-gray-400">{{ __('group_files.empty') }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ __('group_files.hint') }}</p>
            </div>
        @endforelse
    </div>
</div>
