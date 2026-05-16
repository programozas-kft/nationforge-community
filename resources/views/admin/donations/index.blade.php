@extends('admin.layouts.app')

@section('title', __('donations.title'))
@section('header', __('donations.title'))
@section('breadcrumb') <span class="text-gray-700">{{ __('donations.title') }}</span> @endsection

@section('header-actions')
    <button onclick="openModal('modal-export')" class="btn-ghost">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
        {{ __('donations.export') }}
    </button>
    <a href="#" class="btn-primary" onclick="openModal('modal-create-donation');return false;">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        {{ __('donations.new') }}
    </a>
@endsection

@section('content')

<div class="nf-card p-5 mb-5 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background:rgba(10,179,156,0.12)">
            <svg class="w-6 h-6" style="color:#0ab39c" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="text-xs text-gray-500">{{ __('donations.total_completed') ?? 'Összes befejezett adomány' }}</p>
            <p class="text-2xl font-bold" style="color:#0ab39c">{{ number_format($total, 0, ',', ' ') }} Ft</p>
        </div>
    </div>
</div>

<div class="nf-card overflow-hidden">
    <table class="nf-table">
        <thead>
            <tr>
                <th>{{ __('donations.col_donor') }}</th>
                <th>{{ __('donations.col_amount') }}</th>
                <th>{{ __('donations.col_status') }}</th>
                <th>{{ __('donations.col_method') ?? 'Módszer' }}</th>
                <th>{{ __('donations.col_recurring') ?? 'Visszatérő' }}</th>
                <th>{{ __('donations.col_date') }}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($donations as $donation)
            <tr onclick="openDonationEditRow(this)"
                style="cursor:pointer"
                onmouseover="this.style.background='#f8f9ff'" onmouseout="this.style.background=''"
                data-id="{{ $donation->id }}"
                data-person="{{ $donation->person_id ?? '' }}"
                data-amount="{{ $donation->amount }}"
                data-currency="{{ $donation->currency }}"
                data-status="{{ $donation->status }}"
                data-method="{{ $donation->payment_method ?? '' }}"
                data-campaign="{{ $donation->campaign ?? '' }}"
                data-message="{{ $donation->message ?? '' }}"
                data-recurring="{{ $donation->is_recurring ? '1' : '0' }}">
                <td onclick="event.stopPropagation()">
                    @if($donation->person)
                    <div class="flex items-center gap-2">
                        @if($donation->person->photo)
                            <div style="width:28px;height:28px;border-radius:50%;overflow:hidden;flex-shrink:0">
                                <img src="{{ asset('storage/' . $donation->person->photo) }}" style="width:100%;height:100%;object-fit:cover" alt="">
                            </div>
                        @else
                            <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-bold"
                                 style="background:linear-gradient(135deg,#405189,#7a5af8);flex-shrink:0">
                                {{ strtoupper(substr($donation->person->first_name, 0, 1)) }}
                            </div>
                        @endif
                        <a href="{{ route('admin.people.show', $donation->person) }}" class="font-medium text-gray-800 hover:text-indigo-700">
                            {{ $donation->person->last_name }} {{ $donation->person->first_name }}
                        </a>
                    </div>
                    @else
                    <span class="text-gray-400">—</span>
                    @endif
                </td>
                <td class="font-semibold" style="color:#0ab39c">
                    {{ number_format($donation->amount, 0, ',', ' ') }} {{ $donation->currency }}
                </td>
                <td>
                    @php
                        $sc=['completed'=>'badge-success','pending'=>'badge-warning','failed'=>'badge-danger','refunded'=>'badge-secondary'];
                    @endphp
                    <span class="nf-badge {{ $sc[$donation->status] ?? 'badge-secondary' }}">{{ __('donations.status.' . $donation->status, [], null) ?: $donation->status }}</span>
                </td>
                <td class="text-gray-500">{{ $donation->payment_method ?? '—' }}</td>
                <td class="text-center">
                    @if($donation->is_recurring)
                        <span class="nf-badge badge-info">{{ __('common.yes') }}</span>
                    @else
                        <span class="text-gray-300">—</span>
                    @endif
                </td>
                <td class="text-gray-400">{{ $donation->created_at->format('Y. m. d.') }}</td>
                <td class="text-right" onclick="event.stopPropagation()">
                    <a href="{{ route('admin.donations.show', $donation) }}" class="text-xs font-medium mr-3" style="color:#405189">{{ __('common.details') }}</a>
                    <form method="POST" action="{{ route('admin.donations.destroy', $donation) }}" class="inline"
                          onsubmit="return confirm('{{ __('common.confirm_delete') }}')">
                        @csrf @method('DELETE')
                        <button class="text-xs font-medium" style="color:#f06548">{{ __('common.delete') }}</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="py-10 text-center text-gray-400">{{ __('donations.empty') }}</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($donations->hasPages())
    <div class="px-5 py-4" style="border-top:1px solid #e9ebec">
        {{ $donations->links() }}
    </div>
    @endif
</div>

{{-- EXPORT MODAL --}}
<div id="modal-export" class="nf-overlay" onclick="if(event.target===this)closeModal('modal-export')">
    <div class="nf-modal">
        <div class="nf-modal-header">
            <span class="nf-modal-title">{{ __('donations.export_title') }}</span>
            <button class="nf-modal-close" onclick="closeModal('modal-export')">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="GET" action="{{ route('admin.donations.export') }}" target="_blank">
            <div class="nf-modal-body" style="display:grid;grid-template-columns:1fr 1fr;gap:14px">

                <div style="grid-column:span 2">
                    <label class="nf-label">{{ __('donations.export_format') }}</label>
                    <div class="flex gap-3">
                        <label class="flex items-center gap-2 cursor-pointer" style="font-size:0.875rem">
                            <input type="radio" name="format" value="csv" checked style="accent-color:#405189"> CSV
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer" style="font-size:0.875rem">
                            <input type="radio" name="format" value="xlsx" style="accent-color:#405189"> Excel (XLSX)
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer" style="font-size:0.875rem">
                            <input type="radio" name="format" value="pdf" style="accent-color:#405189"> PDF
                        </label>
                    </div>
                </div>

                <div>
                    <label class="nf-label">{{ __('donations.export_date_from') }}</label>
                    <input type="date" name="date_from" class="nf-input">
                </div>
                <div>
                    <label class="nf-label">{{ __('donations.export_date_to') }}</label>
                    <input type="date" name="date_to" class="nf-input">
                </div>

                <div>
                    <label class="nf-label">{{ __('donations.export_status') }}</label>
                    <select name="status" class="nf-select">
                        <option value="">{{ __('donations.export_all') }}</option>
                        @foreach(['completed','pending','failed','refunded'] as $s)
                            <option value="{{ $s }}">{{ __('donations.status.' . $s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="nf-label">{{ __('donations.export_currency') }}</label>
                    <select name="currency" class="nf-select">
                        <option value="">{{ __('donations.export_all') }}</option>
                        <option value="HUF">HUF</option>
                        <option value="EUR">EUR</option>
                        <option value="USD">USD</option>
                    </select>
                </div>

                <div style="grid-column:span 2">
                    <label class="nf-label">{{ __('donations.export_campaign') }}</label>
                    <input type="text" name="campaign" class="nf-input" placeholder="{{ __('donations.export_campaign_hint') }}">
                </div>

            </div>
            <div class="nf-modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('modal-export')">{{ __('common.cancel') }}</button>
                <button type="submit" class="btn-primary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right:4px"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    {{ __('donations.export_download') }}
                </button>
            </div>
        </form>
    </div>
</div>

{{-- CREATE MODAL --}}
<div id="modal-create-donation" class="nf-overlay" onclick="if(event.target===this)closeModal('modal-create-donation')">
    <div class="nf-modal">
        <div class="nf-modal-header">
            <span class="nf-modal-title">{{ __('donations.new') }}</span>
            <button class="nf-modal-close" onclick="closeModal('modal-create-donation')">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.donations.store') }}">
            @csrf
            <div class="nf-modal-body" style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
                <div style="grid-column:span 2">
                    <label class="nf-label">{{ __('donations.donor') }}</label>
                    <select name="person_id" class="nf-select">
                        <option value="">— {{ __('donations.anonymous') ?? 'Névtelen' }} —</option>
                        @foreach($people as $person)
                            <option value="{{ $person->id }}">{{ $person->last_name }} {{ $person->first_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="nf-label">{{ __('donations.amount') }} <span style="color:#f06548">*</span></label>
                    <input type="number" name="amount" class="nf-input" min="1" step="1" required placeholder="pl. 5000">
                </div>
                <div>
                    <label class="nf-label">{{ __('donations.currency') ?? 'Pénznem' }} <span style="color:#f06548">*</span></label>
                    <select name="currency" class="nf-select" required>
                        <option value="HUF" selected>HUF</option>
                        <option value="EUR">EUR</option>
                        <option value="USD">USD</option>
                    </select>
                </div>
                <div>
                    <label class="nf-label">{{ __('donations.payment_status') }} <span style="color:#f06548">*</span></label>
                    <select name="status" class="nf-select" required>
                        @foreach(['completed','pending','failed','refunded'] as $s)
                        <option value="{{ $s }}">{{ __('donations.status.' . $s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="nf-label">{{ __('donations.payment_method') ?? 'Fizetési mód' }}</label>
                    <select name="payment_method" class="nf-select">
                        <option value="">—</option>
                        <option value="cash">{{ __('donations.method.cash') ?? 'Készpénz' }}</option>
                        <option value="transfer">{{ __('donations.method.transfer') ?? 'Átutalás' }}</option>
                        <option value="card">{{ __('donations.method.card') ?? 'Bankkártya' }}</option>
                        <option value="paypal">PayPal</option>
                        <option value="stripe">Stripe</option>
                        <option value="other">{{ __('donations.method.other') ?? 'Egyéb' }}</option>
                    </select>
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">{{ __('donations.campaign') ?? 'Kampány' }}</label>
                    <input type="text" name="campaign" class="nf-input">
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">{{ __('common.notes') }}</label>
                    <textarea name="message" class="nf-input" rows="2" style="resize:vertical"></textarea>
                </div>
                <div style="grid-column:span 2;display:flex;align-items:center;gap:8px">
                    <input type="checkbox" name="is_recurring" id="is_recurring" value="1" style="width:16px;height:16px;cursor:pointer">
                    <label for="is_recurring" class="nf-label" style="margin:0;cursor:pointer">{{ __('donations.recurring') ?? 'Visszatérő adomány' }}</label>
                </div>
            </div>
            <div class="nf-modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('modal-create-donation')">{{ __('common.cancel') }}</button>
                <button type="submit" class="btn-teal">{{ __('common.add') }}</button>
            </div>
        </form>
    </div>
</div>

{{-- EDIT MODAL --}}
<div id="modal-edit-donation" class="nf-overlay" onclick="if(event.target===this)closeModal('modal-edit-donation')">
    <div class="nf-modal">
        <div class="nf-modal-header">
            <span class="nf-modal-title">{{ __('donations.edit_title') }}</span>
            <button class="nf-modal-close" onclick="closeModal('modal-edit-donation')">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="edit-donation-form" method="POST" action="" data-base="{{ url('admin/donations') }}">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="nf-modal-body" style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
                <div style="grid-column:span 2">
                    <label class="nf-label">{{ __('donations.donor') }}</label>
                    <select name="person_id" id="ed_person" class="nf-select">
                        <option value="">—</option>
                        @foreach($people as $person)
                            <option value="{{ $person->id }}">{{ $person->last_name }} {{ $person->first_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="nf-label">{{ __('donations.amount') }} <span style="color:#f06548">*</span></label>
                    <input type="number" name="amount" id="ed_amount" class="nf-input" min="1" step="1" required>
                </div>
                <div>
                    <label class="nf-label">{{ __('donations.currency') ?? 'Pénznem' }} <span style="color:#f06548">*</span></label>
                    <select name="currency" id="ed_currency" class="nf-select" required>
                        <option value="HUF">HUF</option>
                        <option value="EUR">EUR</option>
                        <option value="USD">USD</option>
                    </select>
                </div>
                <div>
                    <label class="nf-label">{{ __('donations.payment_status') }} <span style="color:#f06548">*</span></label>
                    <select name="status" id="ed_status" class="nf-select" required>
                        @foreach(['completed','pending','failed','refunded'] as $s)
                        <option value="{{ $s }}">{{ __('donations.status.' . $s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="nf-label">{{ __('donations.payment_method') ?? 'Fizetési mód' }}</label>
                    <select name="payment_method" id="ed_method" class="nf-select">
                        <option value="">—</option>
                        <option value="cash">{{ __('donations.method.cash') ?? 'Készpénz' }}</option>
                        <option value="transfer">{{ __('donations.method.transfer') ?? 'Átutalás' }}</option>
                        <option value="card">{{ __('donations.method.card') ?? 'Bankkártya' }}</option>
                        <option value="paypal">PayPal</option>
                        <option value="stripe">Stripe</option>
                        <option value="other">{{ __('donations.method.other') ?? 'Egyéb' }}</option>
                    </select>
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">{{ __('donations.campaign') ?? 'Kampány' }}</label>
                    <input type="text" name="campaign" id="ed_campaign" class="nf-input">
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">{{ __('common.notes') }}</label>
                    <textarea name="message" id="ed_message" class="nf-input" rows="2" style="resize:vertical"></textarea>
                </div>
                <div style="grid-column:span 2;display:flex;align-items:center;gap:8px">
                    <input type="checkbox" name="is_recurring" id="ed_recurring" value="1" style="width:16px;height:16px;cursor:pointer">
                    <label for="ed_recurring" class="nf-label" style="margin:0;cursor:pointer">{{ __('donations.recurring') ?? 'Visszatérő adomány' }}</label>
                </div>
            </div>
            <div class="nf-modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('modal-edit-donation')">{{ __('common.cancel') }}</button>
                <button type="submit" class="btn-teal">{{ __('common.save') }}</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openDonationEditRow(el) {
    const d = el.dataset;
    const form = document.getElementById('edit-donation-form');
    form.action = form.dataset.base + '/' + d.id;
    document.getElementById('ed_person').value   = d.person;
    document.getElementById('ed_amount').value   = d.amount;
    document.getElementById('ed_currency').value = d.currency;
    document.getElementById('ed_status').value   = d.status;
    document.getElementById('ed_method').value   = d.method;
    document.getElementById('ed_campaign').value = d.campaign;
    document.getElementById('ed_message').value  = d.message;
    document.getElementById('ed_recurring').checked = d.recurring === '1';
    openModal('modal-edit-donation');
}
</script>
@endpush

@endsection
