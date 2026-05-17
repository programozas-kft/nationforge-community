@extends('admin.layouts.app')

@section('title', __('help.manage_title'))
@section('header', __('help.manage_title'))
@section('breadcrumb')
    <span style="color:#495057">Admin</span>
    <span style="color:#dee2e6">/</span>
    <span style="color:#495057">{{ __('help.manage_title') }}</span>
@endsection

@section('content')

@if(session('success'))
<div style="background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:0.85rem">
    {{ session('success') }}
</div>
@endif

<div style="display:grid;gap:16px">
    @foreach($articles as $article)
    <div class="nf-card" style="padding:0;overflow:hidden">
        <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid #e9ebec;background:#f8f9fa">
            <div style="display:flex;align-items:center;gap:10px">
                <span style="display:inline-flex;align-items:center;justify-content:center;width:26px;height:26px;border-radius:6px;background:#405189;color:#fff;font-size:0.7rem;font-weight:700">
                    {{ $article->sort_order }}
                </span>
                <span style="font-weight:600;color:#343a40;font-size:0.875rem">{{ $article->title }}</span>
                <span style="font-size:0.72rem;color:#adb5bd;background:#e9ebec;padding:2px 8px;border-radius:20px">{{ $article->menu_key }}</span>
            </div>
            <button onclick="openEditHelp({{ $article->id }}, {{ json_encode($article->title) }}, {{ json_encode($article->content) }}, {{ json_encode($article->title_en) }}, {{ json_encode($article->content_en) }}, {{ json_encode($article->video_url) }}, {{ json_encode($article->title_de) }}, {{ json_encode($article->content_de) }}, {{ json_encode($article->title_ro) }}, {{ json_encode($article->content_ro) }}, {{ json_encode($article->title_sk) }}, {{ json_encode($article->content_sk) }})"
                style="display:inline-flex;align-items:center;gap:5px;padding:5px 12px;border-radius:5px;border:1px solid #dee2e6;background:#fff;color:#495057;font-size:0.78rem;cursor:pointer">
                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                {{ __('help.edit_btn') }}
            </button>
        </div>
        <div style="padding:14px 20px;font-size:0.8rem;color:#6c757d;line-height:1.6;white-space:pre-wrap;max-height:120px;overflow:hidden;position:relative">
            {{ $article->content }}
            <div style="position:absolute;bottom:0;left:0;right:0;height:40px;background:linear-gradient(transparent,#fff)"></div>
        </div>
    </div>
    @endforeach
</div>

{{-- EDIT MODAL --}}
<div id="modal-help-edit" class="nf-overlay" onclick="if(event.target===this&&__nfMdTarget===this)closeModal('modal-help-edit')">
    <div class="nf-modal" style="max-width:620px">
        <div class="nf-modal-header">
            <span class="nf-modal-title">{{ __('help.modal_title') }}</span>
            <button class="nf-modal-close" onclick="closeModal('modal-help-edit')">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="help-edit-form" method="POST" action="" data-base="{{ url('admin/help') }}">
            @csrf
            @method('PUT')
            {{-- Language tabs --}}
            <div style="display:flex;border-bottom:1px solid #e9ebec;padding:0 20px;gap:4px">
                <button type="button" id="help-tab-hu" onclick="switchHelpLang('hu')"
                    style="padding:10px 16px;font-size:0.8rem;font-weight:600;border:none;background:none;cursor:pointer;border-bottom:2px solid #405189;color:#405189">
                    {{ __('help.tab_hu') }}
                </button>
                <button type="button" id="help-tab-en" onclick="switchHelpLang('en')"
                    style="padding:10px 16px;font-size:0.8rem;font-weight:500;border:none;background:none;cursor:pointer;border-bottom:2px solid transparent;color:#6c757d">
                    {{ __('help.tab_en') }}
                </button>
                <button type="button" id="help-tab-de" onclick="switchHelpLang('de')"
                    style="padding:10px 16px;font-size:0.8rem;font-weight:500;border:none;background:none;cursor:pointer;border-bottom:2px solid transparent;color:#6c757d">
                    DE
                </button>
                <button type="button" id="help-tab-ro" onclick="switchHelpLang('ro')"
                    style="padding:10px 16px;font-size:0.8rem;font-weight:500;border:none;background:none;cursor:pointer;border-bottom:2px solid transparent;color:#6c757d">
                    RO
                </button>
                <button type="button" id="help-tab-sk" onclick="switchHelpLang('sk')"
                    style="padding:10px 16px;font-size:0.8rem;font-weight:500;border:none;background:none;cursor:pointer;border-bottom:2px solid transparent;color:#6c757d">
                    SK
                </button>
            </div>
            <div class="nf-modal-body" style="display:grid;gap:14px">
                {{-- HU panel --}}
                <div id="help-panel-hu">
                    <div style="margin-bottom:12px">
                        <label class="nf-label">{{ __('help.menu_name') }} <span style="color:#f06548">*</span></label>
                        <input type="text" name="title" id="help_title" class="nf-input" required>
                    </div>
                    <div>
                        <label class="nf-label">{{ __('help.content_label') }} <span style="color:#f06548">*</span></label>
                        <textarea name="content" id="help_content" class="nf-input"
                            style="height:240px;resize:vertical;font-family:monospace;font-size:0.8rem;line-height:1.6"
                            required placeholder="{{ __('help.placeholder') }}"></textarea>
                        <p style="font-size:0.72rem;color:#adb5bd;margin-top:4px">{{ __('help.markdown_hint') }}</p>
                    </div>
                </div>
                {{-- EN panel --}}
                <div id="help-panel-en" style="display:none">
                    <div style="margin-bottom:12px">
                        <label class="nf-label">{{ __('help.menu_name') }} (EN)</label>
                        <input type="text" name="title_en" id="help_title_en" class="nf-input">
                    </div>
                    <div>
                        <label class="nf-label">{{ __('help.content_label') }} (EN)</label>
                        <textarea name="content_en" id="help_content_en" class="nf-input"
                            style="height:240px;resize:vertical;font-family:monospace;font-size:0.8rem;line-height:1.6"
                            placeholder="{{ __('help.placeholder') }}"></textarea>
                        <p style="font-size:0.72rem;color:#adb5bd;margin-top:4px">{{ __('help.markdown_hint') }}</p>
                    </div>
                </div>
                {{-- DE panel --}}
                <div id="help-panel-de" style="display:none">
                    <div style="margin-bottom:12px">
                        <label class="nf-label">{{ __('help.menu_name') }} (DE)</label>
                        <input type="text" name="title_de" id="help_title_de" class="nf-input">
                    </div>
                    <div>
                        <label class="nf-label">{{ __('help.content_label') }} (DE)</label>
                        <textarea name="content_de" id="help_content_de" class="nf-input"
                            style="height:240px;resize:vertical;font-family:monospace;font-size:0.8rem;line-height:1.6"
                            placeholder="{{ __('help.placeholder') }}"></textarea>
                        <p style="font-size:0.72rem;color:#adb5bd;margin-top:4px">{{ __('help.markdown_hint') }}</p>
                    </div>
                </div>
                {{-- RO panel --}}
                <div id="help-panel-ro" style="display:none">
                    <div style="margin-bottom:12px">
                        <label class="nf-label">{{ __('help.menu_name') }} (RO)</label>
                        <input type="text" name="title_ro" id="help_title_ro" class="nf-input">
                    </div>
                    <div>
                        <label class="nf-label">{{ __('help.content_label') }} (RO)</label>
                        <textarea name="content_ro" id="help_content_ro" class="nf-input"
                            style="height:240px;resize:vertical;font-family:monospace;font-size:0.8rem;line-height:1.6"
                            placeholder="{{ __('help.placeholder') }}"></textarea>
                        <p style="font-size:0.72rem;color:#adb5bd;margin-top:4px">{{ __('help.markdown_hint') }}</p>
                    </div>
                </div>
                {{-- SK panel --}}
                <div id="help-panel-sk" style="display:none">
                    <div style="margin-bottom:12px">
                        <label class="nf-label">{{ __('help.menu_name') }} (SK)</label>
                        <input type="text" name="title_sk" id="help_title_sk" class="nf-input">
                    </div>
                    <div>
                        <label class="nf-label">{{ __('help.content_label') }} (SK)</label>
                        <textarea name="content_sk" id="help_content_sk" class="nf-input"
                            style="height:240px;resize:vertical;font-family:monospace;font-size:0.8rem;line-height:1.6"
                            placeholder="{{ __('help.placeholder') }}"></textarea>
                        <p style="font-size:0.72rem;color:#adb5bd;margin-top:4px">{{ __('help.markdown_hint') }}</p>
                    </div>
                </div>
                {{-- Video URL (shared, not per-language) --}}
                <div style="border-top:1px solid #e9ebec;padding-top:14px">
                    <label class="nf-label">{{ __('help.video_url_label') }}</label>
                    <input type="url" name="video_url" id="help_video_url" class="nf-input"
                        placeholder="https://www.youtube.com/watch?v=... or https://vimeo.com/...">
                    <p style="font-size:0.72rem;color:#adb5bd;margin-top:4px">{{ __('help.video_url_hint') }}</p>
                </div>
            </div>
            <div class="nf-modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('modal-help-edit')">{{ __('common.cancel') }}</button>
                <button type="submit" class="btn-teal">{{ __('common.save_changes') }}</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openEditHelp(id, title, content, titleEn, contentEn, videoUrl, titleDe, contentDe, titleRo, contentRo, titleSk, contentSk) {
    const form = document.getElementById('help-edit-form');
    form.action = form.dataset.base + '/' + id;
    document.getElementById('help_title').value      = title;
    document.getElementById('help_content').value    = content;
    document.getElementById('help_title_en').value   = titleEn   || '';
    document.getElementById('help_content_en').value = contentEn || '';
    document.getElementById('help_title_de').value   = titleDe   || '';
    document.getElementById('help_content_de').value = contentDe || '';
    document.getElementById('help_title_ro').value   = titleRo   || '';
    document.getElementById('help_content_ro').value = contentRo || '';
    document.getElementById('help_title_sk').value   = titleSk   || '';
    document.getElementById('help_content_sk').value = contentSk || '';
    document.getElementById('help_video_url').value  = videoUrl  || '';
    switchHelpLang('hu');
    openModal('modal-help-edit');
}

function switchHelpLang(lang) {
    ['hu','en','de','ro','sk'].forEach(l => {
        const panel = document.getElementById('help-panel-' + l);
        const tab   = document.getElementById('help-tab-' + l);
        const active = l === lang;
        if (panel) panel.style.display = active ? 'block' : 'none';
        if (tab) {
            tab.style.borderBottomColor = active ? '#405189' : 'transparent';
            tab.style.color             = active ? '#405189' : '#6c757d';
            tab.style.fontWeight        = active ? '600' : '500';
        }
    });
}
</script>
@endpush

@endsection
