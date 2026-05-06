@extends('admin.layouts.app')

@section('title', __('donations.show_title'))
@section('header', __('donations.show_title'))
@section('breadcrumb')
    <a href="{{ route('admin.donations.index') }}">{{ __('donations.title') }}</a>
    <span class="breadcrumb-sep">/</span>
    <span class="text-gray-700">{{ __('common.details') }}</span>
@endsection

@section('header-actions')
    <form method="POST" action="{{ route('admin.donations.destroy', $donation) }}"
          onsubmit="return confirm('{{ __('common.confirm_delete') }}')">
        @csrf @method('DELETE')
        <button class="btn-danger">{{ __('common.delete') }}</button>
    </form>
@endsection

@section('content')
<div class="max-w-lg">
    <div class="nf-card overflow-hidden">
        <div class="p-6 text-center" style="background:linear-gradient(135deg,#f0fdf9,#e6f9f6);border-bottom:1px solid #e9ebec">
            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">{{ __('donations.col_amount') }}</p>
            <p class="text-4xl font-bold" style="color:#0ab39c">
                {{ number_format($donation->amount, 0, ',', ' ') }} {{ $donation->currency }}
            </p>
        </div>
        <div class="px-6 py-5 space-y-4 text-sm">
            <div class="flex justify-between items-center">
                <span class="text-gray-500">{{ __('donations.col_donor') }}</span>
                <span class="font-medium">
                    @if($donation->person)
                        <a href="{{ route('admin.people.show', $donation->person) }}" style="color:#405189">
                            {{ $donation->person->last_name }} {{ $donation->person->first_name }}
                        </a>
                    @else
                        {{ __('common.unknown') }}
                    @endif
                </span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-500">{{ __('common.status') }}</span>
                @php $sc=['completed'=>'badge-success','pending'=>'badge-warning','failed'=>'badge-danger','refunded'=>'badge-secondary']; @endphp
                <span class="nf-badge {{ $sc[$donation->status] ?? 'badge-secondary' }}">{{ __('donations.status.' . $donation->status) }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-500">{{ __('donations.payment_method') }}</span>
                <span class="font-medium text-gray-800">{{ $donation->payment_method ? __('donations.method.' . $donation->payment_method) : '—' }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-500">{{ __('donations.col_recurring') }}</span>
                <span class="nf-badge {{ $donation->is_recurring ? 'badge-info' : 'badge-secondary' }}">
                    {{ $donation->is_recurring ? __('common.yes') : __('common.no') }}
                </span>
            </div>
            @if($donation->notes)
            <div class="flex justify-between items-start">
                <span class="text-gray-500">{{ __('common.notes') }}</span>
                <span class="font-medium text-gray-800 text-right max-w-xs">{{ $donation->notes }}</span>
            </div>
            @endif
            <div class="flex justify-between items-center pt-3" style="border-top:1px solid #f3f3f9">
                <span class="text-gray-500">{{ __('common.date') }}</span>
                <span class="font-medium text-gray-800">{{ $donation->created_at->format('Y. m. d. H:i') }}</span>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.donations.index') }}" class="text-sm" style="color:#405189">{{ __('common.back_to_list') }}</a>
    </div>
</div>
@endsection
