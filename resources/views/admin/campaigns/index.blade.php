@extends('admin.layouts.app')

@section('title', __('campaigns.title'))
@section('header', __('campaigns.title'))
@section('breadcrumb')
    <span style="color:#dee2e6">/</span>
    <span style="color:#495057">{{ __('campaigns.title') }}</span>
@endsection

@section('content')

@php
$statusMap = [
    'draft'   => ['label' => __('campaigns.status_draft'),   'style' => 'background:#f3f4f6;color:#6b7280;'],
    'sending' => ['label' => __('campaigns.status_sending'), 'style' => 'background:rgba(245,158,11,0.1);color:#d97706;'],
    'sent'    => ['label' => __('campaigns.status_sent'),    'style' => 'background:rgba(10,179,156,0.1);color:#0ab39c;'],
    'failed'  => ['label' => __('campaigns.status_failed'),  'style' => 'background:rgba(240,101,72,0.1);color:#f06548;'],
];
@endphp

{{-- Resend key warning --}}
@if(empty(config('services.resend.key')))
<div style="margin-bottom:16px;padding:14px 18px;background:rgba(245,158,11,0.08);border:1px solid rgba(245,158,11,0.25);border-radius:8px;display:flex;align-items:center;gap:10px;">
    <svg style="width:18px;height:18px;color:#d97706;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
    <span style="font-size:0.85rem;color:#92400e;">
        <strong>RESEND_KEY</strong> nincs beállítva. Kampányt nem lehet küldeni. →
        Regisztrálj a <a href="https://resend.com" target="_blank" style="color:#405189;">resend.com</a> oldalon, másold be az API kulcsot a <code>.env</code> fájlba:
        <code style="background:#fff;padding:2px 6px;border-radius:3px;border:1px solid #e5e7eb;">RESEND_KEY=re_xxxxxxxxxx</code>
        majd állítsd: <code style="background:#fff;padding:2px 6px;border-radius:3px;border:1px solid #e5e7eb;">MAIL_MAILER=resend</code>
    </span>
</div>
@endif

<div class="nf-card">
    <div class="nf-card-header">
        <span>{{ __('campaigns.title') }}</span>
        <button onclick="openModal('modal-campaign-create')" class="btn-teal">
            + {{ __('campaigns.new') }}
        </button>
    </div>

    @if($campaigns->isEmpty())
    <div style="padding:48px;text-align:center;color:#adb5bd;">
        <svg style="width:48px;height:48px;margin:0 auto 12px;display:block;opacity:.4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        <p style="font-size:.9rem;">{{ __('campaigns.empty') }}</p>
    </div>
    @else
    <table class="nf-table">
        <thead>
            <tr>
                <th>{{ __('campaigns.name_label') }}</th>
                <th>{{ __('campaigns.subject_label') }}</th>
                <th>{{ __('common.status') }}</th>
                <th>{{ __('campaigns.recipients_hint') }}</th>
                <th>{{ __('campaigns.sent_at') }}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($campaigns as $c)
            <tr>
                <td style="font-weight:500">{{ $c->name }}</td>
                <td style="color:#6c757d;font-size:.85rem;">{{ $c->subject }}</td>
                <td>
                    <span class="badge" style="{{ $statusMap[$c->status]['style'] ?? '' }}">
                        {{ $statusMap[$c->status]['label'] ?? $c->status }}
                    </span>
                </td>
                <td style="font-size:.85rem;color:#6c757d;">
                    @if($c->isSent())
                        {{ $c->sent_count }} / {{ $c->recipients_count }}
                        @if($c->failed_count > 0)
                            <span style="color:#f06548"> ({{ $c->failed_count }} {{ __('campaigns.failed_count') }})</span>
                        @endif
                    @else
                        {{ $subscriberCount }} {{ __('campaigns.recipients_hint') }}
                    @endif
                </td>
                <td style="font-size:.85rem;color:#6c757d;">{{ $c->sent_at?->format('Y.m.d H:i') ?? '—' }}</td>
                <td style="text-align:right;white-space:nowrap">
                    @if($c->isDraft())
                    <button onclick="openEditCampaign({{ $c->id }}, {{ json_encode($c->name) }}, {{ json_encode($c->subject) }}, {{ json_encode($c->body_html) }}, {{ json_encode($c->from_name) }}, {{ json_encode($c->from_email) }})"
                        class="btn-ghost" style="margin-right:4px">{{ __('common.edit') }}</button>
                    <form method="POST" action="{{ route('admin.campaigns.send', $c) }}" style="display:inline"
                          onsubmit="return confirm('{{ __('campaigns.send_confirm') }}')">
                        @csrf
                        <button type="submit" class="btn-teal" style="padding:5px 12px;font-size:.8rem;">
                            ✉ {{ __('campaigns.send_btn') }}
                        </button>
                    </form>
                    @endif
                    <form method="POST" action="{{ route('admin.campaigns.destroy', $c) }}" style="display:inline"
                          onsubmit="return confirm('{{ __('common.confirm_delete') }}')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-danger" style="padding:5px 10px;font-size:.8rem;margin-left:4px">✕</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

{{-- Create Modal --}}
<div id="modal-campaign-create" class="nf-overlay">
    <div class="nf-modal" style="max-width:680px;width:95%">
        <div class="nf-modal-header">
            <span class="nf-modal-title">{{ __('campaigns.new') }}</span>
            <button onclick="closeModal('modal-campaign-create')" class="nf-modal-close">✕</button>
        </div>
        <form method="POST" action="{{ route('admin.campaigns.store') }}">
            @csrf
            <div class="nf-modal-body" style="display:grid;gap:14px">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                    <div>
                        <label class="nf-label">{{ __('campaigns.name_label') }} <span style="color:#f06548">*</span></label>
                        <input type="text" name="name" class="nf-input" required placeholder="{{ __('campaigns.name_label') }}">
                    </div>
                    <div>
                        <label class="nf-label">{{ __('campaigns.subject_label') }} <span style="color:#f06548">*</span></label>
                        <input type="text" name="subject" class="nf-input" required placeholder="{{ __('campaigns.subject_label') }}">
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                    <div>
                        <label class="nf-label">{{ __('campaigns.from_name_label') }}</label>
                        <input type="text" name="from_name" class="nf-input" placeholder="{{ config('mail.from.name') }}">
                    </div>
                    <div>
                        <label class="nf-label">{{ __('campaigns.from_email_label') }}</label>
                        <input type="email" name="from_email" class="nf-input" placeholder="{{ config('mail.from.address') }}">
                    </div>
                </div>
                <div>
                    <label class="nf-label">{{ __('campaigns.body_label') }} <span style="color:#f06548">*</span></label>
                    <textarea name="body_html" class="nf-input" rows="10" required
                        style="font-family:monospace;font-size:.82rem;line-height:1.6;resize:vertical"
                        placeholder="{{ __('campaigns.placeholder') }}"></textarea>
                    <p style="font-size:.72rem;color:#adb5bd;margin-top:4px">{{ __('campaigns.markdown_hint') }}</p>
                </div>
                <div style="padding:10px 12px;background:#f8f9fa;border-radius:6px;font-size:.8rem;color:#6c757d;">
                    📧 {{ $subscriberCount }} {{ __('campaigns.recipients_hint') }}
                </div>
            </div>
            <div class="nf-modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('modal-campaign-create')">{{ __('common.cancel') }}</button>
                <button type="submit" class="btn-teal">{{ __('common.save_changes') }}</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Modal --}}
<div id="modal-campaign-edit" class="nf-overlay">
    <div class="nf-modal" style="max-width:680px;width:95%">
        <div class="nf-modal-header">
            <span class="nf-modal-title">{{ __('campaigns.edit') }}</span>
            <button onclick="closeModal('modal-campaign-edit')" class="nf-modal-close">✕</button>
        </div>
        <form id="campaign-edit-form" method="POST" action="" data-base="{{ url('admin/campaigns') }}">
            @csrf @method('PUT')
            <div class="nf-modal-body" style="display:grid;gap:14px">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                    <div>
                        <label class="nf-label">{{ __('campaigns.name_label') }} <span style="color:#f06548">*</span></label>
                        <input type="text" name="name" id="edit_name" class="nf-input" required>
                    </div>
                    <div>
                        <label class="nf-label">{{ __('campaigns.subject_label') }} <span style="color:#f06548">*</span></label>
                        <input type="text" name="subject" id="edit_subject" class="nf-input" required>
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                    <div>
                        <label class="nf-label">{{ __('campaigns.from_name_label') }}</label>
                        <input type="text" name="from_name" id="edit_from_name" class="nf-input">
                    </div>
                    <div>
                        <label class="nf-label">{{ __('campaigns.from_email_label') }}</label>
                        <input type="email" name="from_email" id="edit_from_email" class="nf-input">
                    </div>
                </div>
                <div>
                    <label class="nf-label">{{ __('campaigns.body_label') }} <span style="color:#f06548">*</span></label>
                    <textarea name="body_html" id="edit_body" class="nf-input" rows="10" required
                        style="font-family:monospace;font-size:.82rem;line-height:1.6;resize:vertical"></textarea>
                    <p style="font-size:.72rem;color:#adb5bd;margin-top:4px">{{ __('campaigns.markdown_hint') }}</p>
                </div>
            </div>
            <div class="nf-modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('modal-campaign-edit')">{{ __('common.cancel') }}</button>
                <button type="submit" class="btn-teal">{{ __('common.save_changes') }}</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openEditCampaign(id, name, subject, body, fromName, fromEmail) {
    const form = document.getElementById('campaign-edit-form');
    form.action = form.dataset.base + '/' + id;
    document.getElementById('edit_name').value      = name;
    document.getElementById('edit_subject').value   = subject;
    document.getElementById('edit_body').value      = body;
    document.getElementById('edit_from_name').value  = fromName || '';
    document.getElementById('edit_from_email').value = fromEmail || '';
    openModal('modal-campaign-edit');
}
</script>
@endpush
