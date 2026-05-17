@extends('admin.layouts.app')

@section('title', __('webhooks.title'))
@section('header', __('webhooks.title'))
@section('breadcrumb')
    <span style="color:#495057">Admin</span>
    <span style="color:#dee2e6">/</span>
    <span style="color:#495057">{{ __('webhooks.title') }}</span>
@endsection

@section('content')

@if(session('success'))
<div style="background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:0.85rem">
    {{ session('success') }}
</div>
@endif

{{-- Header row --}}
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
    <div>
        <p style="font-size:0.85rem;color:#6c757d;margin:0">{{ __('webhooks.subtitle') }}</p>
    </div>
    <button onclick="openModal('modal-webhook-create')" class="btn-teal">
        + {{ __('webhooks.add_btn') }}
    </button>
</div>

{{-- Webhook list --}}
@forelse($webhooks as $wh)
@php $last = $wh->lastDelivery(); @endphp
<div class="nf-card" style="padding:0;overflow:hidden;margin-bottom:12px">
    <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 20px;gap:12px">
        <div style="flex:1;min-width:0">
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">
                <span style="font-weight:600;color:#343a40;font-size:0.875rem">{{ $wh->name }}</span>
                @if($wh->is_active)
                    <span style="font-size:0.7rem;padding:2px 8px;border-radius:20px;background:rgba(10,179,156,0.1);color:#0ab39c;font-weight:600">{{ __('webhooks.active') }}</span>
                @else
                    <span style="font-size:0.7rem;padding:2px 8px;border-radius:20px;background:#f3f3f9;color:#adb5bd;font-weight:600">{{ __('webhooks.inactive') }}</span>
                @endif
                @if($last)
                    @if($last->isSuccess())
                        <span style="font-size:0.7rem;padding:2px 8px;border-radius:20px;background:rgba(10,179,156,0.08);color:#0ab39c">✓ {{ __('webhooks.last_ok') }}</span>
                    @else
                        <span style="font-size:0.7rem;padding:2px 8px;border-radius:20px;background:rgba(240,101,72,0.08);color:#f06548">✗ {{ __('webhooks.last_failed') }}</span>
                    @endif
                @endif
            </div>
            <div style="font-size:0.78rem;color:#6c757d;margin-top:4px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                {{ $wh->url }}
            </div>
            <div style="display:flex;gap:6px;flex-wrap:wrap;margin-top:6px">
                @foreach($wh->events as $ev)
                <span style="font-size:0.68rem;padding:1px 7px;border-radius:20px;background:#e9ebec;color:#495057;font-family:monospace">{{ $ev }}</span>
                @endforeach
            </div>
        </div>
        <div style="display:flex;gap:6px;flex-shrink:0">
            <a href="{{ route('admin.webhooks.deliveries', $wh) }}"
               style="display:inline-flex;align-items:center;gap:4px;padding:5px 10px;border-radius:5px;border:1px solid #dee2e6;background:#fff;color:#495057;font-size:0.75rem;text-decoration:none">
                {{ __('webhooks.deliveries_btn') }}
                <span style="background:#e9ebec;border-radius:20px;padding:0 6px;font-size:0.68rem">{{ $wh->deliveries_count }}</span>
            </a>
            <form method="POST" action="{{ route('admin.webhooks.toggle', $wh) }}">
                @csrf @method('PATCH')
                <button type="submit" style="padding:5px 10px;border-radius:5px;border:1px solid #dee2e6;background:#fff;color:#495057;font-size:0.75rem;cursor:pointer">
                    {{ $wh->is_active ? __('webhooks.deactivate') : __('webhooks.activate') }}
                </button>
            </form>
            <button onclick="openEditWebhook({{ json_encode($wh) }})"
                style="padding:5px 10px;border-radius:5px;border:1px solid #dee2e6;background:#fff;color:#495057;font-size:0.75rem;cursor:pointer">
                {{ __('common.edit') }}
            </button>
            <form method="POST" action="{{ route('admin.webhooks.destroy', $wh) }}"
                  onsubmit="return confirm('{{ __('webhooks.confirm_delete') }}')">
                @csrf @method('DELETE')
                <button type="submit" style="padding:5px 10px;border-radius:5px;border:1px solid #f06548;background:#fff;color:#f06548;font-size:0.75rem;cursor:pointer">
                    {{ __('common.delete') }}
                </button>
            </form>
        </div>
    </div>
</div>
@empty
<div class="nf-card" style="text-align:center;padding:40px 20px;color:#adb5bd">
    <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin:0 auto 12px"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
    <p style="font-size:0.9rem;margin:0">{{ __('webhooks.empty') }}</p>
</div>
@endforelse

{{-- CREATE MODAL --}}
<div id="modal-webhook-create" class="nf-overlay" onclick="if(event.target===this&&__nfMdTarget===this)closeModal('modal-webhook-create')">
    <div class="nf-modal" style="max-width:560px">
        <div class="nf-modal-header">
            <span class="nf-modal-title">{{ __('webhooks.modal_create_title') }}</span>
            <button class="nf-modal-close" onclick="closeModal('modal-webhook-create')">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.webhooks.store') }}">
            @csrf
            @include('admin.webhooks._form')
            <div class="nf-modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('modal-webhook-create')">{{ __('common.cancel') }}</button>
                <button type="submit" class="btn-teal">{{ __('common.save') }}</button>
            </div>
        </form>
    </div>
</div>

{{-- EDIT MODAL --}}
<div id="modal-webhook-edit" class="nf-overlay" onclick="if(event.target===this&&__nfMdTarget===this)closeModal('modal-webhook-edit')">
    <div class="nf-modal" style="max-width:560px">
        <div class="nf-modal-header">
            <span class="nf-modal-title">{{ __('webhooks.modal_edit_title') }}</span>
            <button class="nf-modal-close" onclick="closeModal('modal-webhook-edit')">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="webhook-edit-form" method="POST" action="" data-base="{{ url('admin/webhooks') }}">
            @csrf @method('PUT')
            @include('admin.webhooks._form', ['edit' => true])
            <div class="nf-modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('modal-webhook-edit')">{{ __('common.cancel') }}</button>
                <button type="submit" class="btn-teal">{{ __('common.save_changes') }}</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
const allEvents = @json($eventTypes);

function openEditWebhook(wh) {
    const form = document.getElementById('webhook-edit-form');
    form.action = form.dataset.base + '/' + wh.id;
    form.querySelector('[name="name"]').value   = wh.name;
    form.querySelector('[name="url"]').value    = wh.url;
    form.querySelector('[name="secret"]').value = wh.secret || '';
    // reset checkboxes
    form.querySelectorAll('input[type="checkbox"]').forEach(cb => {
        cb.checked = (wh.events || []).includes(cb.value);
    });
    openModal('modal-webhook-edit');
}
</script>
@endpush

@endsection
