@extends('admin.layouts.app')

@section('title', 'Súgó kezelése')
@section('header', 'Súgó kezelése')
@section('breadcrumb')
    <span style="color:#495057">Admin</span>
    <span style="color:#dee2e6">/</span>
    <span style="color:#495057">Súgó kezelése</span>
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
            <button onclick="openEditHelp({{ $article->id }}, {{ json_encode($article->title) }}, {{ json_encode($article->content) }})"
                style="display:inline-flex;align-items:center;gap:5px;padding:5px 12px;border-radius:5px;border:1px solid #dee2e6;background:#fff;color:#495057;font-size:0.78rem;cursor:pointer">
                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Szerkesztés
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
<div id="modal-help-edit" class="nf-overlay" onclick="if(event.target===this)closeModal('modal-help-edit')">
    <div class="nf-modal" style="max-width:620px">
        <div class="nf-modal-header">
            <span class="nf-modal-title">Súgó szerkesztése</span>
            <button class="nf-modal-close" onclick="closeModal('modal-help-edit')">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="help-edit-form" method="POST" action="" data-base="{{ url('admin/help') }}">
            @csrf
            @method('PUT')
            <div class="nf-modal-body" style="display:grid;gap:14px">
                <div>
                    <label class="nf-label">Menü neve <span style="color:#f06548">*</span></label>
                    <input type="text" name="title" id="help_title" class="nf-input" required>
                </div>
                <div>
                    <label class="nf-label">Tartalom <span style="color:#f06548">*</span></label>
                    <textarea name="content" id="help_content" class="nf-input"
                        style="height:280px;resize:vertical;font-family:monospace;font-size:0.8rem;line-height:1.6"
                        required placeholder="Markdown-szerű formázás: **félkövér**, - lista elem, stb."></textarea>
                    <p style="font-size:0.72rem;color:#adb5bd;margin-top:4px">**félkövér** formázás és - listaelem is megjelenik a súgóban.</p>
                </div>
            </div>
            <div class="nf-modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('modal-help-edit')">Mégse</button>
                <button type="submit" class="btn-teal">Mentés</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openEditHelp(id, title, content) {
    const form = document.getElementById('help-edit-form');
    form.action = form.dataset.base + '/' + id;
    document.getElementById('help_title').value   = title;
    document.getElementById('help_content').value = content;
    openModal('modal-help-edit');
}
</script>
@endpush

@endsection
