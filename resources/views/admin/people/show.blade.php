@extends('admin.layouts.app')

@section('title', $person->last_name . ' ' . $person->first_name)
@section('header', $person->last_name . ' ' . $person->first_name)
@section('breadcrumb')
    <a href="{{ route('admin.people.index') }}">{{ __('people.title') }}</a>
    <span class="breadcrumb-sep">/</span>
    <span class="text-gray-700">{{ $person->last_name }} {{ $person->first_name }}</span>
@endsection

@section('header-actions')
    <a href="{{ route('admin.people.edit', $person) }}" class="btn-primary">{{ __('common.edit') }}</a>
    <form method="POST" action="{{ route('admin.people.destroy', $person) }}" class="inline"
          onsubmit="return confirm('{{ __('common.confirm_delete') }}')">
        @csrf @method('DELETE')
        <button class="btn-danger">{{ __('common.delete') }}</button>
    </form>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    <div class="space-y-5">
        <div class="nf-card p-6 text-center">
            @if($person->photo)
                <div class="w-20 h-20 rounded-full mx-auto mb-3 overflow-hidden shadow-sm border-2 border-white">
                    <img src="{{ asset('storage/' . $person->photo) }}" class="w-full h-full object-cover">
                </div>
            @else
                <div class="w-20 h-20 rounded-full flex items-center justify-center text-white text-3xl font-bold mx-auto mb-3"
                     style="background:linear-gradient(135deg,#405189,#7a5af8)">
                    {{ strtoupper(substr($person->first_name, 0, 1)) }}
                </div>
            @endif
            <h2 class="text-base font-semibold text-gray-800">{{ $person->last_name }} {{ $person->first_name }}</h2>
            <p class="text-sm text-gray-500">{{ $person->email ?? '—' }}</p>
            @php
                $sc = ['member'=>'badge-primary','supporter'=>'badge-success','donor'=>'badge-warning','volunteer'=>'badge-info','vip'=>'badge-purple','prospect'=>'badge-secondary','inactive'=>'badge-secondary'];
            @endphp
            <div class="mt-2">
                <span class="nf-badge {{ $sc[$person->status] ?? 'badge-secondary' }}">{{ __('people.status.' . $person->status) }}</span>
            </div>
        </div>

        <div class="nf-card">
            <div class="nf-card-header">{{ __('common.data') }}</div>
            <div class="py-4 space-y-3" style="padding-left: 24px; padding-right: 24px;">
                @foreach([
                    [__('common.phone'),              $person->phone],
                    [__('common.city'),               $person->city],
                    [__('people.subscribed_label'),   $person->is_subscribed ? __('common.yes') : __('common.no')],
                    [__('people.source'),             $person->source],
                    [__('common.registered'),         $person->created_at->format('Y. m. d.')],
                ] as [$label, $value])
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">{{ $label }}</span>
                    <span class="font-medium text-gray-800">{{ $value ?? '—' }}</span>
                </div>
                @endforeach
                <div class="flex justify-between text-sm pt-2" style="border-top:1px solid #f3f3f9">
                    <span class="text-gray-500">{{ __('people.total_donated') }}</span>
                    <span class="font-semibold" style="color:#0ab39c">{{ number_format($person->total_donated, 0, ',', ' ') }} Ft</span>
                </div>
            </div>
            @if($person->notes)
            <div class="pb-4" style="padding-left: 24px; padding-right: 24px;">
                <p class="text-xs text-gray-400 mb-1">{{ __('common.notes') }}</p>
                <p class="text-sm text-gray-600">{{ $person->notes }}</p>
            </div>
            @endif
        </div>
    </div>

    <div class="lg:col-span-2 space-y-5">
        <div class="nf-card overflow-hidden">
            <div class="nf-card-header">{{ __('donations.title') }}</div>
            <table class="nf-table">
                <thead>
                    <tr>
                        <th>{{ __('donations.col_amount') }}</th>
                        <th>{{ __('common.status') }}</th>
                        <th>{{ __('donations.col_method') }}</th>
                        <th>{{ __('common.date') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($person->donations as $donation)
                    <tr>
                        <td class="font-semibold" style="color:#0ab39c">{{ number_format($donation->amount, 0, ',', ' ') }} {{ $donation->currency }}</td>
                        <td><span class="nf-badge {{ $donation->status === 'completed' ? 'badge-success' : 'badge-secondary' }}">{{ __('donations.status.' . $donation->status) }}</span></td>
                        <td class="text-gray-500">{{ $donation->payment_method ? __('donations.method.' . $donation->payment_method) : '—' }}</td>
                        <td class="text-gray-400">{{ $donation->created_at->format('Y. m. d.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="py-6 text-center text-gray-400">{{ __('donations.none') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="nf-card overflow-hidden">
            <div class="nf-card-header">{{ __('groups.title') }}</div>
            <table class="nf-table">
                <thead>
                    <tr>
                        <th>{{ __('groups.col_name') }}</th>
                        <th>{{ __('common.type') }}</th>
                        <th>{{ __('groups.col_privacy') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($person->groups as $group)
                    <tr>
                        <td>
                            <a href="{{ route('admin.groups.show', $group) }}" class="font-medium text-gray-800 hover:text-indigo-700">{{ $group->name }}</a>
                        </td>
                        <td><span class="nf-badge badge-purple">{{ __('groups.type.' . $group->type) }}</span></td>
                        <td class="text-gray-500">{{ __('groups.privacy.' . $group->privacy) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="py-6 text-center text-gray-400">{{ __('people.no_groups') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
