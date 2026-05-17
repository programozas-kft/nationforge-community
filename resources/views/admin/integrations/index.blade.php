@extends('admin.layouts.app')

@section('title', __('integrations.title'))
@section('header', __('integrations.title'))
@section('breadcrumb')
    <span style="color:#495057">Admin</span>
    <span style="color:#dee2e6">/</span>
    <span style="color:#495057">{{ __('integrations.title') }}</span>
@endsection

@section('content')

@if(session('success'))
<div style="background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:0.85rem">
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div style="background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:0.85rem">
    {{ session('error') }}
</div>
@endif

<p style="font-size:0.85rem;color:#6c757d;margin:0 0 24px">{{ __('integrations.subtitle') }}</p>

<div style="display:grid;gap:20px">

    {{-- ── Google Calendar / iCal ─────────────────────────────────────────────── --}}
    <div class="nf-card" style="padding:24px">
        <div style="display:flex;align-items:flex-start;gap:16px">
            <div style="width:40px;height:40px;border-radius:8px;background:rgba(66,133,244,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#4285F4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
            </div>
            <div style="flex:1">
                <h2 style="font-size:0.95rem;font-weight:600;color:#343a40;margin:0 0 6px">{{ __('integrations.gcal_title') }}</h2>
                <p style="font-size:0.82rem;color:#6c757d;margin:0 0 16px;line-height:1.5">{{ __('integrations.gcal_desc') }}</p>

                {{-- iCal URL --}}
                <div style="margin-bottom:16px">
                    <label style="font-size:0.78rem;font-weight:600;color:#495057;display:block;margin-bottom:6px">{{ __('integrations.ical_url_label') }}</label>
                    <div style="display:flex;gap:8px;align-items:center">
                        <input id="ical-url" type="text" value="{{ $icalUrl }}" readonly
                               style="flex:1;padding:8px 12px;border:1px solid #dee2e6;border-radius:6px;font-size:0.82rem;background:#f8f9fa;color:#495057;font-family:monospace">
                        <button onclick="copyIcalUrl()" id="copy-btn"
                                style="padding:8px 14px;border-radius:6px;border:1px solid #dee2e6;background:#fff;color:#495057;font-size:0.78rem;cursor:pointer;white-space:nowrap">
                            {{ __('integrations.gcal_copy') }}
                        </button>
                    </div>
                </div>

                {{-- Steps --}}
                <div style="background:#f8f9fa;border-radius:8px;padding:14px 16px;margin-bottom:16px">
                    <p style="font-size:0.78rem;font-weight:600;color:#495057;margin:0 0 8px">{{ __('integrations.gcal_steps') }}</p>
                    <ol style="margin:0;padding-left:18px;font-size:0.78rem;color:#6c757d;line-height:1.8">
                        <li>{{ __('integrations.gcal_step1') }}</li>
                        <li>{{ __('integrations.gcal_step2') }}</li>
                        <li>{{ __('integrations.gcal_step3') }}</li>
                        <li>{{ __('integrations.gcal_step4') }}</li>
                    </ol>
                </div>

                @php
                    $gcalAddUrl = 'https://calendar.google.com/calendar/r?cid=' . urlencode($icalUrl);
                @endphp
                <a href="{{ $gcalAddUrl }}" target="_blank" rel="noopener"
                   style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:6px;background:#4285F4;color:#fff;font-size:0.82rem;font-weight:500;text-decoration:none">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    {{ __('integrations.gcal_btn') }}
                </a>
            </div>
        </div>
    </div>

    {{-- ── Facebook Events ──────────────────────────────────────────────────────── --}}
    <div class="nf-card" style="padding:24px">
        <div style="display:flex;align-items:flex-start;gap:16px">
            <div style="width:40px;height:40px;border-radius:8px;background:rgba(24,119,242,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="#1877F2">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
            </div>
            <div style="flex:1">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px">
                    <h2 style="font-size:0.95rem;font-weight:600;color:#343a40;margin:0">{{ __('integrations.fb_title') }}</h2>
                    @if($fbConfigured)
                        <span style="font-size:0.7rem;padding:2px 8px;border-radius:20px;background:rgba(10,179,156,0.1);color:#0ab39c;font-weight:600">
                            ✓ {{ __('integrations.fb_configured') }}
                        </span>
                    @else
                        <span style="font-size:0.7rem;padding:2px 8px;border-radius:20px;background:#f3f3f9;color:#adb5bd;font-weight:600">
                            {{ __('integrations.fb_not_set') }}
                        </span>
                    @endif
                </div>
                <p style="font-size:0.82rem;color:#6c757d;margin:0 0 16px;line-height:1.5">{{ __('integrations.fb_desc') }}</p>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">
                    {{-- Settings form --}}
                    <div>
                        <form method="POST" action="{{ route('admin.integrations.facebook') }}">
                            @csrf
                            <div style="display:grid;gap:12px">
                                <div>
                                    <label class="nf-label">{{ __('integrations.fb_page_id') }}</label>
                                    <input type="text" name="fb_page_id" value="{{ $fbPageId }}"
                                           placeholder="123456789012345" class="nf-input">
                                </div>
                                <div>
                                    <label class="nf-label">{{ __('integrations.fb_page_token') }}</label>
                                    <input type="password" name="fb_page_access_token"
                                           placeholder="{{ __('integrations.fb_page_token') }}" class="nf-input">
                                    <p style="font-size:0.7rem;color:#adb5bd;margin-top:4px">{{ __('integrations.fb_page_token_hint') }}</p>
                                </div>
                                <div>
                                    <button type="submit" class="btn-teal">{{ __('integrations.fb_save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Setup guide --}}
                    <div style="background:#f8f9fa;border-radius:8px;padding:14px 16px">
                        <p style="font-size:0.78rem;font-weight:600;color:#495057;margin:0 0 8px">{{ __('integrations.fb_setup_steps') }}</p>
                        <ol style="margin:0;padding-left:18px;font-size:0.78rem;color:#6c757d;line-height:1.8">
                            <li>{{ __('integrations.fb_step1') }}</li>
                            <li>{{ __('integrations.fb_step2') }}</li>
                            <li>{{ __('integrations.fb_step3') }}</li>
                            <li>{{ __('integrations.fb_step4') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Zapier & Make ───────────────────────────────────────────────────────── --}}
    <div class="nf-card" style="padding:24px">
        <div style="display:flex;align-items:flex-start;gap:16px">
            <div style="width:40px;height:40px;border-radius:8px;background:rgba(255,74,5,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#FF4A05" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
                </svg>
            </div>
            <div style="flex:1">
                <h2 style="font-size:0.95rem;font-weight:600;color:#343a40;margin:0 0 6px">{{ __('integrations.zapier_title') }}</h2>
                <p style="font-size:0.82rem;color:#6c757d;margin:0 0 16px;line-height:1.5">{{ __('integrations.zapier_desc') }}</p>

                {{-- How it works --}}
                <div style="background:#fff8f0;border:1px solid #fed7aa;border-radius:8px;padding:14px 16px;margin-bottom:16px">
                    <p style="font-size:0.78rem;font-weight:600;color:#92400e;margin:0 0 6px">{{ __('integrations.zapier_how') }}</p>
                    <p style="font-size:0.78rem;color:#78350f;margin:0;line-height:1.5">{{ __('integrations.zapier_how_desc') }}</p>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:16px">
                    {{-- Zapier steps --}}
                    <div style="background:#f8f9fa;border-radius:8px;padding:14px 16px">
                        <p style="font-size:0.78rem;font-weight:600;color:#495057;margin:0 0 8px">⚡ {{ __('integrations.zapier_steps_title') }}</p>
                        <ol style="margin:0;padding-left:18px;font-size:0.78rem;color:#6c757d;line-height:1.8">
                            <li>{{ __('integrations.zapier_step1') }}</li>
                            <li>{{ __('integrations.zapier_step2') }}</li>
                            <li>{{ __('integrations.zapier_step3') }}</li>
                            <li>{{ __('integrations.zapier_step4') }}</li>
                            <li>{{ __('integrations.zapier_step5') }}</li>
                        </ol>
                    </div>

                    {{-- Make steps --}}
                    <div style="background:#f8f9fa;border-radius:8px;padding:14px 16px">
                        <p style="font-size:0.78rem;font-weight:600;color:#495057;margin:0 0 8px">⚙️ {{ __('integrations.make_steps_title') }}</p>
                        <ol style="margin:0;padding-left:18px;font-size:0.78rem;color:#6c757d;line-height:1.8">
                            <li>{{ __('integrations.make_step1') }}</li>
                            <li>{{ __('integrations.make_step2') }}</li>
                            <li>{{ __('integrations.make_step3') }}</li>
                            <li>{{ __('integrations.make_step4') }}</li>
                            <li>{{ __('integrations.make_step5') }}</li>
                        </ol>
                    </div>
                </div>

                {{-- Available event types --}}
                <div>
                    <p style="font-size:0.78rem;font-weight:600;color:#495057;margin:0 0 8px">{{ __('integrations.available_events') }}</p>
                    <div style="display:flex;flex-wrap:wrap;gap:6px;margin-bottom:14px">
                        @foreach($eventTypes as $type)
                        <span style="font-size:0.72rem;padding:3px 10px;border-radius:20px;background:#e9ebec;color:#495057;font-family:monospace">{{ $type }}</span>
                        @endforeach
                    </div>
                    <a href="{{ route('admin.webhooks.index') }}"
                       style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:6px;border:1px solid #dee2e6;background:#fff;color:#495057;font-size:0.82rem;font-weight:500;text-decoration:none">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        {{ __('integrations.go_to_webhooks') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
function copyIcalUrl() {
    const input = document.getElementById('ical-url');
    const btn   = document.getElementById('copy-btn');
    navigator.clipboard.writeText(input.value).then(() => {
        btn.textContent = '{{ __('integrations.gcal_copied') }}';
        btn.style.background = '#d1fae5';
        btn.style.color = '#065f46';
        setTimeout(() => {
            btn.textContent = '{{ __('integrations.gcal_copy') }}';
            btn.style.background = '#fff';
            btn.style.color = '#495057';
        }, 2000);
    });
}
</script>
@endsection
