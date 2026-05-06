@extends('admin.layouts.app')

@section('title', __('settings.title'))
@section('header', __('settings.title'))
@section('breadcrumb')
    <span style="color:#495057">{{ __('common.admin') }}</span>
    <span style="color:#dee2e6">/</span>
    <span style="color:#495057">{{ __('settings.title') }}</span>
@endsection

@section('content')
<div>
    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px">

            {{-- Általános --}}
            <div class="nf-card" style="padding:24px">
                <h2 style="font-size:0.875rem;font-weight:600;color:#343a40;margin:0 0 16px;padding-bottom:12px;border-bottom:1px solid #e9ebec">
                    {{ __('settings.general') }}
                </h2>
                <div style="display:grid;gap:14px">
                    <div>
                        <label class="nf-label">{{ __('settings.app_name') }}</label>
                        <input type="text" name="app_name" value="{{ $settings['app_name'] }}" class="nf-input">
                    </div>
                    <div>
                        <label class="nf-label">{{ __('settings.app_url') }}</label>
                        <input type="text" value="{{ $settings['app_url'] }}" class="nf-input" disabled style="background:#f8f9fa;color:#adb5bd">
                        <p style="font-size:0.72rem;color:#adb5bd;margin-top:4px">{{ __('settings.app_url_hint') }}</p>
                    </div>
                    <div>
                        <label class="nf-label">{{ __('settings.language') }}</label>
                        <input type="text" value="{{ $settings['app_locale'] }}" class="nf-input" disabled style="background:#f8f9fa;color:#adb5bd">
                    </div>
                </div>
            </div>

            {{-- Email + Info --}}
            <div style="display:flex;flex-direction:column;gap:20px">
                <div class="nf-card" style="padding:24px">
                    <h2 style="font-size:0.875rem;font-weight:600;color:#343a40;margin:0 0 16px;padding-bottom:12px;border-bottom:1px solid #e9ebec">
                        {{ __('settings.email_settings') }}
                    </h2>
                    <div style="display:grid;gap:14px">
                        <div>
                            <label class="nf-label">{{ __('settings.sender_name') }}</label>
                            <input type="text" name="mail_name" value="{{ $settings['mail_name'] }}" class="nf-input">
                        </div>
                        <div>
                            <label class="nf-label">{{ __('settings.sender_email') }}</label>
                            <input type="email" name="mail_from" value="{{ $settings['mail_from'] }}" class="nf-input">
                        </div>
                    </div>
                </div>

                {{-- Info kártyák --}}
                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px">
                    <div class="nf-card" style="padding:16px;text-align:center">
                        <p style="font-size:0.7rem;color:#adb5bd;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:4px">{{ __('settings.php_version') }}</p>
                        <p style="font-weight:600;color:#343a40">{{ PHP_VERSION }}</p>
                    </div>
                    <div class="nf-card" style="padding:16px;text-align:center">
                        <p style="font-size:0.7rem;color:#adb5bd;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:4px">{{ __('settings.laravel') }}</p>
                        <p style="font-weight:600;color:#343a40">{{ app()->version() }}</p>
                    </div>
                    <div class="nf-card" style="padding:16px;text-align:center">
                        <p style="font-size:0.7rem;color:#adb5bd;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:4px">{{ __('settings.environment') }}</p>
                        <p style="font-weight:600;color:#343a40">{{ app()->environment() }}</p>
                    </div>
                </div>
            </div>

        </div>

        <div style="display:flex;gap:10px;margin-bottom:32px">
            <button type="submit" class="btn-teal">{{ __('settings.save') }}</button>
        </div>
    </form>

    {{-- ── LINKGYŰJTEMÉNY ───────────────────────────────── --}}
    <div id="links" style="margin-top:32px">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
            <div>
                <p style="font-size:0.875rem;font-weight:600;color:#343a40;margin:0">{{ __('settings.links_title') }}</p>
                <p style="font-size:0.75rem;color:#adb5bd;margin:2px 0 0">{{ __('settings.links_desc') }} <a href="{{ route('admin.links.index') }}" style="color:#405189"></a></p>
            </div>
            <button class="btn-primary" onclick="openModal('modal-link-create');return false;"
                    style="display:inline-flex;align-items:center;gap:6px">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                {{ __('settings.link_new') }}
            </button>
        </div>

        <div class="nf-card" style="overflow:hidden">
            <table class="nf-table">
                <thead>
                    <tr>
                        <th>{{ __('settings.col_title') }}</th>
                        <th>{{ __('settings.col_url') }}</th>
                        <th>{{ __('settings.col_category') }}</th>
                        <th>{{ __('settings.col_order') }}</th>
                        <th>{{ __('settings.col_status') }}</th>
                        <th style="width:80px"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($links as $link)
                    <tr data-id="{{ $link->id }}"
                        data-title="{{ $link->title }}"
                        data-url="{{ $link->url }}"
                        data-desc="{{ $link->description ?? '' }}"
                        data-category="{{ $link->category ?? '' }}"
                        data-color="{{ $link->color }}"
                        data-order="{{ $link->sort_order }}"
                        data-active="{{ $link->is_active ? '1' : '0' }}">
                        <td style="font-weight:500;color:#343a40">{{ $link->title }}</td>
                        <td>
                            <a href="{{ $link->url }}" target="_blank" rel="noopener"
                               style="color:#405189;font-size:0.78rem;max-width:200px;display:inline-block;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;vertical-align:middle">
                                {{ $link->url }}
                            </a>
                        </td>
                        <td>
                            @if($link->category)
                            <span class="nf-badge badge-secondary">{{ $link->category }}</span>
                            @else
                            <span style="color:#adb5bd;font-size:0.78rem">—</span>
                            @endif
                        </td>
                        <td style="color:#6c757d;font-size:0.8rem">{{ $link->sort_order }}</td>
                        <td>
                            <span class="nf-badge {{ $link->is_active ? 'badge-success' : 'badge-secondary' }}">
                                {{ $link->is_active ? __('settings.active') : __('settings.inactive') }}
                            </span>
                        </td>
                        <td style="text-align:right">
                            <button onclick="openLinkEdit(this.closest('tr'))"
                                    style="background:none;border:none;cursor:pointer;color:#405189;margin-right:6px" title="{{ __('common.edit') }}">
                                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <form method="POST" action="{{ route('admin.links.destroy', $link) }}" style="display:inline"
                                  onsubmit="return confirm('{{ __('settings.delete_confirm') }}')">
                                @csrf @method('DELETE')
                                <button type="submit" style="background:none;border:none;cursor:pointer;color:#f06548" title="{{ __('common.delete') }}">
                                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center;padding:32px;color:#adb5bd">{{ __('settings.no_links') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- CREATE MODAL --}}
<div id="modal-link-create" class="nf-overlay" onclick="if(event.target===this)closeModal('modal-link-create')">
    <div class="nf-modal" style="max-width:520px">
        <div class="nf-modal-header">
            <span class="nf-modal-title">{{ __('settings.link_new') }}</span>
            <button class="nf-modal-close" onclick="closeModal('modal-link-create')">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.links.store') }}">
            @csrf
            <div class="nf-modal-body" style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
                <div style="grid-column:span 2">
                    <label class="nf-label">{{ __('settings.link_title') }} <span style="color:#f06548">*</span></label>
                    <input type="text" name="title" class="nf-input" required>
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">{{ __('settings.link_url') }} <span style="color:#f06548">*</span></label>
                    <input type="url" name="url" class="nf-input" placeholder="https://" required>
                </div>
                <div>
                    <label class="nf-label">{{ __('settings.link_category') }}</label>
                    <input type="text" name="category" class="nf-input">
                </div>
                <div>
                    <label class="nf-label">{{ __('settings.link_color') }}</label>
                    <div style="display:flex;align-items:center;gap:8px">
                        <input type="color" name="color" value="#405189" style="width:38px;height:34px;padding:2px;border:1px solid #e9ebec;border-radius:6px;cursor:pointer">
                        <span style="font-size:0.75rem;color:#adb5bd">{{ __('settings.link_color_hint') }}</span>
                    </div>
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">{{ __('settings.link_desc') }}</label>
                    <textarea name="description" rows="2" class="nf-input" style="resize:none"></textarea>
                </div>
                <div>
                    <label class="nf-label">{{ __('settings.link_order') }}</label>
                    <input type="number" name="sort_order" value="0" class="nf-input">
                </div>
                <div style="display:flex;align-items:center;gap:8px;padding-top:22px">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" checked id="lc_active" style="width:15px;height:15px;accent-color:#405189">
                    <label for="lc_active" class="nf-label" style="margin:0">{{ __('settings.link_active') }}</label>
                </div>
            </div>
            <div class="nf-modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('modal-link-create')">{{ __('common.cancel') }}</button>
                <button type="submit" class="btn-teal">{{ __('settings.add') }}</button>
            </div>
        </form>
    </div>
</div>

{{-- EDIT MODAL --}}
<div id="modal-link-edit" class="nf-overlay" onclick="if(event.target===this)closeModal('modal-link-edit')">
    <div class="nf-modal" style="max-width:520px">
        <div class="nf-modal-header">
            <span class="nf-modal-title">{{ __('settings.link_edit') }}</span>
            <button class="nf-modal-close" onclick="closeModal('modal-link-edit')">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="link-edit-form" method="POST" action="" data-base="{{ url('admin/links') }}">
            @csrf @method('PUT')
            <div class="nf-modal-body" style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
                <div style="grid-column:span 2">
                    <label class="nf-label">{{ __('settings.link_title') }} <span style="color:#f06548">*</span></label>
                    <input type="text" id="le_title" name="title" class="nf-input" required>
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">{{ __('settings.link_url') }} <span style="color:#f06548">*</span></label>
                    <input type="url" id="le_url" name="url" class="nf-input" required>
                </div>
                <div>
                    <label class="nf-label">{{ __('settings.link_category') }}</label>
                    <input type="text" id="le_category" name="category" class="nf-input">
                </div>
                <div>
                    <label class="nf-label">{{ __('settings.link_color') }}</label>
                    <div style="display:flex;align-items:center;gap:8px">
                        <input type="color" id="le_color" name="color" style="width:38px;height:34px;padding:2px;border:1px solid #e9ebec;border-radius:6px;cursor:pointer">
                        <span style="font-size:0.75rem;color:#adb5bd">{{ __('settings.link_color_hint') }}</span>
                    </div>
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">{{ __('settings.link_desc') }}</label>
                    <textarea id="le_desc" name="description" rows="2" class="nf-input" style="resize:none"></textarea>
                </div>
                <div>
                    <label class="nf-label">{{ __('settings.link_order') }}</label>
                    <input type="number" id="le_order" name="sort_order" class="nf-input">
                </div>
                <div style="display:flex;align-items:center;gap:8px;padding-top:22px">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" id="le_active" name="is_active" value="1" style="width:15px;height:15px;accent-color:#405189">
                    <label for="le_active" class="nf-label" style="margin:0">{{ __('settings.link_active') }}</label>
                </div>
            </div>
            <div class="nf-modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('modal-link-edit')">{{ __('common.cancel') }}</button>
                <button type="submit" class="btn-teal">{{ __('common.save') }}</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openLinkEdit(row) {
    const d = row.dataset;
    const form = document.getElementById('link-edit-form');
    form.action = form.dataset.base + '/' + d.id;
    document.getElementById('le_title').value    = d.title;
    document.getElementById('le_url').value      = d.url;
    document.getElementById('le_category').value = d.category;
    document.getElementById('le_color').value    = d.color;
    document.getElementById('le_desc').value     = d.desc;
    document.getElementById('le_order').value    = d.order;
    document.getElementById('le_active').checked = d.active === '1';
    openModal('modal-link-edit');
}
</script>
@endpush
@endsection
