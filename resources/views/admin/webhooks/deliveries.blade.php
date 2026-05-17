@extends('admin.layouts.app')

@section('title', __('webhooks.deliveries_title'))
@section('header', $webhook->name . ' — ' . __('webhooks.deliveries_title'))
@section('breadcrumb')
    <a href="{{ route('admin.webhooks.index') }}" style="color:#6c757d;text-decoration:none">{{ __('webhooks.title') }}</a>
    <span style="color:#dee2e6">/</span>
    <span style="color:#495057">{{ $webhook->name }}</span>
@endsection

@section('content')

@if(session('success'))
<div style="background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:0.85rem">
    {{ session('success') }}
</div>
@endif

<div class="nf-card" style="padding:0;overflow:hidden">
    <table style="width:100%;border-collapse:collapse;font-size:0.82rem">
        <thead>
            <tr style="background:#f8f9fa;border-bottom:1px solid #e9ebec">
                <th style="padding:10px 16px;text-align:left;font-weight:600;color:#495057">{{ __('webhooks.col_event') }}</th>
                <th style="padding:10px 16px;text-align:left;font-weight:600;color:#495057">{{ __('webhooks.col_status') }}</th>
                <th style="padding:10px 16px;text-align:left;font-weight:600;color:#495057">{{ __('webhooks.col_code') }}</th>
                <th style="padding:10px 16px;text-align:left;font-weight:600;color:#495057">{{ __('webhooks.col_attempt') }}</th>
                <th style="padding:10px 16px;text-align:left;font-weight:600;color:#495057">{{ __('webhooks.col_date') }}</th>
                <th style="padding:10px 16px;text-align:left;font-weight:600;color:#495057"></th>
            </tr>
        </thead>
        <tbody>
        @forelse($deliveries as $d)
        <tr style="border-bottom:1px solid #f1f1f1">
            <td style="padding:10px 16px;font-family:monospace;color:#405189">{{ $d->event_type }}</td>
            <td style="padding:10px 16px">
                @if($d->isSuccess())
                    <span style="display:inline-flex;align-items:center;gap:4px;font-size:0.72rem;padding:2px 8px;border-radius:20px;background:rgba(10,179,156,0.1);color:#0ab39c;font-weight:600">✓ {{ __('webhooks.status_success') }}</span>
                @elseif($d->isFailed())
                    <span style="display:inline-flex;align-items:center;gap:4px;font-size:0.72rem;padding:2px 8px;border-radius:20px;background:rgba(240,101,72,0.1);color:#f06548;font-weight:600">✗ {{ __('webhooks.status_failed') }}</span>
                @else
                    <span style="font-size:0.72rem;padding:2px 8px;border-radius:20px;background:#f3f3f9;color:#adb5bd;font-weight:600">{{ __('webhooks.status_pending') }}</span>
                @endif
            </td>
            <td style="padding:10px 16px;color:#6c757d">{{ $d->response_code ?? '—' }}</td>
            <td style="padding:10px 16px;color:#6c757d">{{ $d->attempt_count }}</td>
            <td style="padding:10px 16px;color:#6c757d;white-space:nowrap">{{ $d->created_at?->format('Y-m-d H:i:s') }}</td>
            <td style="padding:10px 16px">
                @if($d->isFailed())
                <form method="POST" action="{{ route('admin.webhooks.retry', [$webhook, $d]) }}">
                    @csrf
                    <button type="submit" style="padding:3px 10px;border-radius:5px;border:1px solid #dee2e6;background:#fff;color:#495057;font-size:0.73rem;cursor:pointer">
                        {{ __('webhooks.retry_btn') }}
                    </button>
                </form>
                @endif
            </td>
        </tr>
        @if($d->response_body && $d->isFailed())
        <tr style="background:#fff8f8;border-bottom:1px solid #f1f1f1">
            <td colspan="6" style="padding:6px 16px 10px;font-size:0.75rem;color:#f06548;font-family:monospace">
                {{ Str::limit($d->response_body, 300) }}
            </td>
        </tr>
        @endif
        @empty
        <tr>
            <td colspan="6" style="padding:30px;text-align:center;color:#adb5bd;font-size:0.85rem">
                {{ __('webhooks.no_deliveries') }}
            </td>
        </tr>
        @endforelse
        </tbody>
    </table>
</div>

@if($deliveries->hasPages())
<div style="margin-top:16px">{{ $deliveries->links() }}</div>
@endif

@endsection
