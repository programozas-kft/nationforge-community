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
                        <label class="nf-label">{{ __('settings.default_language') }}</label>
                        <select name="default_locale" class="nf-input">
                            @foreach(['hu' => '🇭🇺 Magyar', 'en' => '🇬🇧 English', 'de' => '🇩🇪 Deutsch', 'ro' => '🇷🇴 Română', 'sk' => '🇸🇰 Slovenčina'] as $code => $label)
                                <option value="{{ $code }}" {{ $settings['default_locale'] === $code ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <p style="font-size:0.72rem;color:#adb5bd;margin-top:4px">{{ __('settings.default_language_hint') }}</p>
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

    {{-- ── SMTP / MAILER ───────────────────────────────── --}}
    <div id="smtp" style="margin-top:32px;margin-bottom:32px">
        <form method="POST" action="{{ route('admin.settings.mail') }}">
            @csrf
            <div class="nf-card" style="padding:24px">
                <h2 style="font-size:0.875rem;font-weight:600;color:#343a40;margin:0 0 16px;padding-bottom:12px;border-bottom:1px solid #e9ebec">
                    {{ __('settings.smtp_title') }}
                </h2>

                {{-- Mailer selector --}}
                <div style="margin-bottom:20px">
                    <label class="nf-label">{{ __('settings.smtp_mailer') }}</label>
                    <div style="display:flex;gap:10px;flex-wrap:wrap">
                        @foreach(['smtp' => __('settings.smtp_driver_smtp'), 'resend' => __('settings.smtp_driver_resend'), 'log' => __('settings.smtp_driver_log')] as $val => $label)
                        <label style="display:flex;align-items:center;gap:7px;padding:9px 16px;border:1.5px solid {{ $mailConfig['mailer'] === $val ? '#405189' : '#dee2e6' }};border-radius:7px;cursor:pointer;font-size:0.82rem;font-weight:500;color:{{ $mailConfig['mailer'] === $val ? '#405189' : '#495057' }};transition:all 0.15s"
                               id="mailer-opt-{{ $val }}"
                               onclick="selectMailer('{{ $val }}')">
                            <input type="radio" name="mail_mailer" value="{{ $val }}" {{ $mailConfig['mailer'] === $val ? 'checked' : '' }}
                                   style="accent-color:#405189;width:14px;height:14px">
                            {{ $label }}
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- SMTP fields --}}
                <div id="smtp-fields" style="display:{{ $mailConfig['mailer'] === 'smtp' ? 'grid' : 'none' }};grid-template-columns:1fr 1fr;gap:16px;margin-bottom:4px">
                    <div style="grid-column:span 1">
                        <label class="nf-label">{{ __('settings.smtp_host') }}</label>
                        <input type="text" name="mail_host" value="{{ $mailConfig['host'] }}" class="nf-input" placeholder="smtp.gmail.com">
                    </div>
                    <div>
                        <label class="nf-label">{{ __('settings.smtp_port') }}</label>
                        <input type="number" name="mail_port" value="{{ $mailConfig['port'] }}" class="nf-input" placeholder="587" min="1" max="65535">
                    </div>
                    <div>
                        <label class="nf-label">{{ __('settings.smtp_encryption') }}</label>
                        <select name="mail_scheme" class="nf-select">
                            <option value="tls"  {{ ($mailConfig['scheme'] === 'tls'  || $mailConfig['scheme'] === null) ? 'selected' : '' }}>TLS (STARTTLS — port 587)</option>
                            <option value="ssl"  {{ $mailConfig['scheme'] === 'ssl'  ? 'selected' : '' }}>SSL (port 465)</option>
                            <option value="null" {{ $mailConfig['scheme'] === 'null' ? 'selected' : '' }}>{{ __('settings.smtp_no_encryption') }}</option>
                        </select>
                    </div>
                    <div>
                        <label class="nf-label">{{ __('settings.smtp_username') }}</label>
                        <input type="text" name="mail_username" value="{{ $mailConfig['username'] }}" class="nf-input" autocomplete="off">
                    </div>
                    <div style="grid-column:span 2">
                        <label class="nf-label">{{ __('settings.smtp_password') }}</label>
                        <input type="password" name="mail_password" class="nf-input" autocomplete="new-password"
                               placeholder="{{ $mailConfig['has_pass'] ? '••••••••  ('.__('settings.smtp_pass_hint').')' : __('settings.smtp_pass_empty') }}">
                        <p style="font-size:0.72rem;color:#adb5bd;margin-top:4px">{{ __('settings.smtp_pass_hint') }}</p>
                    </div>
                </div>

                {{-- Resend API key --}}
                <div id="resend-fields" style="display:{{ $mailConfig['mailer'] === 'resend' ? 'block' : 'none' }};margin-bottom:4px">
                    <label class="nf-label">Resend API Key</label>
                    <input type="password" name="resend_api_key" class="nf-input" autocomplete="new-password"
                           placeholder="{{ $mailConfig['resend_key'] ? '••••••••  ('.__('settings.smtp_pass_hint').')' : 're_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx' }}">
                    <p style="font-size:0.72rem;color:#adb5bd;margin-top:4px">{{ __('settings.resend_hint') }}</p>
                </div>

                {{-- Log info --}}
                <div id="log-fields" style="display:{{ $mailConfig['mailer'] === 'log' ? 'block' : 'none' }};margin-bottom:4px">
                    <div style="background:#f3f3f9;border-radius:6px;padding:12px 16px;font-size:0.8rem;color:#6c757d">
                        {{ __('settings.log_hint') }}
                    </div>
                </div>

                <div style="margin-top:18px">
                    <button type="submit" class="btn-teal">{{ __('settings.smtp_save') }}</button>
                </div>
            </div>
        </form>
    </div>

    {{-- ── BRANDING ─────────────────────────────────────── --}}
    <div id="branding" style="margin-top:32px;margin-bottom:32px">
        <form method="POST" action="{{ route('admin.settings.branding') }}" enctype="multipart/form-data">
            @csrf
            <div class="nf-card" style="padding:24px">
                <h2 style="font-size:0.875rem;font-weight:600;color:#343a40;margin:0 0 16px;padding-bottom:12px;border-bottom:1px solid #e9ebec">
                    {{ __('settings.branding_title') }}
                </h2>
                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:20px;align-items:start">

                    {{-- Logo upload --}}
                    <div>
                        <label class="nf-label">{{ __('settings.branding_logo') }}</label>
                        <div style="display:flex;align-items:center;gap:12px;margin-bottom:8px">
                            @if($branding['logo'])
                                <img src="{{ asset('storage/' . $branding['logo']) }}" alt="Logo"
                                     style="height:42px;max-width:120px;object-fit:contain;border:1px solid #e9ebec;border-radius:6px;padding:4px;background:#f8f9fa">
                            @else
                                <div style="width:42px;height:42px;border-radius:6px;background:#f3f3f9;border:1px solid #e9ebec;display:flex;align-items:center;justify-content:center">
                                    <svg width="20" height="20" fill="none" stroke="#adb5bd" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 16M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        </div>
                        <input type="file" name="logo" accept="image/png,image/jpeg,image/svg+xml"
                               style="font-size:0.78rem;color:#495057;width:100%"
                               onchange="previewLogo(this)">
                        <p style="font-size:0.72rem;color:#adb5bd;margin-top:4px">PNG, JPG, SVG · max 1 MB</p>
                        @if($branding['logo'])
                        <label style="display:flex;align-items:center;gap:6px;margin-top:6px;font-size:0.78rem;color:#f06548;cursor:pointer">
                            <input type="checkbox" name="remove_logo" value="1" style="accent-color:#f06548">
                            {{ __('settings.branding_remove_logo') }}
                        </label>
                        @endif
                    </div>

                    {{-- Org name --}}
                    <div>
                        <label class="nf-label">{{ __('settings.branding_org_name') }}</label>
                        <input type="text" name="org_name" value="{{ $branding['org_name'] }}" class="nf-input" maxlength="60">
                        <p style="font-size:0.72rem;color:#adb5bd;margin-top:4px">{{ __('settings.branding_org_name_hint') }}</p>
                    </div>

                    {{-- Primary color --}}
                    <div>
                        <label class="nf-label">{{ __('settings.branding_color') }}</label>
                        <div style="display:flex;align-items:center;gap:10px">
                            <input type="color" name="primary_color" value="{{ $branding['primary_color'] }}"
                                   id="brand-color-picker"
                                   style="width:44px;height:38px;padding:2px;border:1px solid #e9ebec;border-radius:6px;cursor:pointer"
                                   oninput="document.getElementById('brand-color-hex').value=this.value;updateColorPreview(this.value)">
                            <input type="text" id="brand-color-hex" value="{{ $branding['primary_color'] }}"
                                   class="nf-input" style="width:90px;font-family:monospace"
                                   maxlength="7" pattern="#[0-9a-fA-F]{6}"
                                   oninput="if(this.value.match(/^#[0-9a-fA-F]{6}$/))document.getElementById('brand-color-picker').value=this.value">
                        </div>
                        <div id="brand-color-preview" style="margin-top:8px;height:28px;border-radius:6px;background:linear-gradient(90deg,{{ $branding['primary_color'] }},{{ \App\Models\Setting::darken($branding['primary_color']) }});transition:background 0.2s"></div>
                        <p style="font-size:0.72rem;color:#adb5bd;margin-top:4px">{{ __('settings.branding_color_hint') }}</p>
                    </div>

                </div>
                <div style="margin-top:18px">
                    <button type="submit" class="btn-teal">{{ __('settings.branding_save') }}</button>
                </div>
            </div>
        </form>
    </div>

    {{-- ── ONLINE PAYMENT ──────────────────────────────────── --}}
    @php
        $paymentProvider = \App\Models\Setting::get('payment_provider', '');
        $hasStripeKey    = !empty(\App\Models\Setting::get('stripe_secret_key'));
        $hasBarionKey    = !empty(\App\Models\Setting::get('barion_api_key'));
        $barionEnv       = \App\Models\Setting::get('barion_environment', 'test');
        $stripeWebhookUrl = route('payment.stripe.webhook');
    @endphp
    <div id="payment" style="margin-top:32px;margin-bottom:32px">
        <form method="POST" action="{{ route('admin.settings.payment') }}">
            @csrf
            <div class="nf-card" style="padding:24px">
                <h2 style="font-size:0.875rem;font-weight:600;color:#343a40;margin:0 0 6px;padding-bottom:12px;border-bottom:1px solid #e9ebec">
                    {{ __('settings.payment_title') }}
                </h2>
                <p style="font-size:0.78rem;color:#6c757d;margin:0 0 18px">{{ __('settings.payment_desc') }}</p>

                {{-- Provider selector --}}
                <div style="margin-bottom:20px">
                    <label class="nf-label">{{ __('settings.payment_provider') }}</label>
                    <div style="display:flex;gap:10px;flex-wrap:wrap">
                        @foreach(['' => __('settings.payment_none'), 'stripe' => __('settings.payment_stripe'), 'barion' => __('settings.payment_barion')] as $val => $label)
                        <label style="display:flex;align-items:center;gap:7px;padding:9px 16px;border:1.5px solid {{ $paymentProvider === $val ? '#405189' : '#dee2e6' }};border-radius:7px;cursor:pointer;font-size:0.82rem;font-weight:500;color:{{ $paymentProvider === $val ? '#405189' : '#495057' }};transition:all 0.15s"
                               id="pay-opt-{{ $val ?: 'none' }}"
                               onclick="selectProvider('{{ $val }}')">
                            <input type="radio" name="payment_provider" value="{{ $val }}" {{ $paymentProvider === $val ? 'checked' : '' }}
                                   style="accent-color:#405189;width:14px;height:14px">
                            {{ $label }}
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Stripe fields --}}
                <div id="pay-stripe" style="display:{{ $paymentProvider === 'stripe' ? 'block' : 'none' }}">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:4px">
                        <div>
                            <label class="nf-label">{{ __('settings.payment_stripe_pk') }}</label>
                            <input type="password" name="stripe_publishable" class="nf-input" autocomplete="new-password"
                                   placeholder="{{ $hasStripeKey ? '••••••••  ('.__('settings.payment_key_hint').')' : 'pk_live_…' }}">
                        </div>
                        <div>
                            <label class="nf-label">{{ __('settings.payment_stripe_sk') }}</label>
                            <input type="password" name="stripe_secret" class="nf-input" autocomplete="new-password"
                                   placeholder="{{ $hasStripeKey ? '••••••••  ('.__('settings.payment_key_hint').')' : 'sk_live_…' }}">
                        </div>
                        <div style="grid-column:span 2">
                            <label class="nf-label">{{ __('settings.payment_stripe_wh') }}</label>
                            <input type="password" name="stripe_webhook_sec" class="nf-input" autocomplete="new-password"
                                   placeholder="whsec_…">
                            <p style="font-size:0.72rem;color:#adb5bd;margin-top:4px">
                                {!! __('settings.payment_stripe_wh_hint', ['url' => '<code style="font-size:0.78rem;background:#f3f3f9;padding:1px 5px;border-radius:3px">' . $stripeWebhookUrl . '</code>']) !!}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Barion fields --}}
                <div id="pay-barion" style="display:{{ $paymentProvider === 'barion' ? 'block' : 'none' }}">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:4px">
                        <div>
                            <label class="nf-label">{{ __('settings.payment_barion_key') }}</label>
                            <input type="password" name="barion_api_key" class="nf-input" autocomplete="new-password"
                                   placeholder="{{ $hasBarionKey ? '••••••••  ('.__('settings.payment_key_hint').')' : 'POSKey…' }}">
                        </div>
                        <div>
                            <label class="nf-label">{{ __('settings.payment_barion_email') }}</label>
                            <input type="email" name="barion_merchant" class="nf-input"
                                   value="{{ \App\Models\Setting::get('barion_merchant_email', '') }}"
                                   placeholder="merchant@barion.com">
                        </div>
                        <div>
                            <label class="nf-label">{{ __('settings.payment_barion_env') }}</label>
                            <select name="barion_environment" class="nf-select">
                                <option value="test" {{ $barionEnv === 'test' ? 'selected' : '' }}>{{ __('settings.payment_barion_test') }}</option>
                                <option value="live" {{ $barionEnv === 'live' ? 'selected' : '' }}>{{ __('settings.payment_barion_live') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div style="margin-top:18px">
                    <button type="submit" class="btn-teal">{{ __('settings.payment_save') }}</button>
                </div>
            </div>
        </form>
    </div>

    {{-- ── SCHEDULED REPORTS ──────────────────────────────── --}}
    <div id="report" style="margin-top:32px;margin-bottom:32px">
        <form method="POST" action="{{ route('admin.settings.report') }}">
            @csrf
            <div class="nf-card" style="padding:24px">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;padding-bottom:12px;border-bottom:1px solid #e9ebec">
                    <h2 style="font-size:0.875rem;font-weight:600;color:#343a40;margin:0">
                        {{ __('settings.report_title') }}
                    </h2>
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                        <span style="font-size:0.8rem;color:#6c757d">{{ __('settings.report_enabled') }}</span>
                        <input type="hidden" name="report_enabled" value="0">
                        <input type="checkbox" name="report_enabled" value="1" id="report-enabled"
                               {{ $reportConfig['enabled'] ? 'checked' : '' }}
                               style="width:16px;height:16px;accent-color:#405189"
                               onchange="toggleReportFields()">
                    </label>
                </div>

                <p style="font-size:0.78rem;color:#6c757d;margin:0 0 18px">{{ __('settings.report_desc') }}</p>

                <div id="report-fields" style="display:{{ $reportConfig['enabled'] ? 'block' : 'none' }}">
                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;margin-bottom:16px">

                        {{-- Frequency --}}
                        <div>
                            <label class="nf-label">{{ __('settings.report_frequency') }}</label>
                            <select name="report_frequency" id="report-frequency" class="nf-select" onchange="updateFrequencyFields()">
                                @foreach(['daily' => __('settings.report_freq_daily'), 'weekly' => __('settings.report_freq_weekly'), 'monthly' => __('settings.report_freq_monthly')] as $val => $label)
                                <option value="{{ $val }}" {{ $reportConfig['frequency'] === $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Day of week (weekly only) --}}
                        <div id="dow-field" style="display:{{ $reportConfig['frequency'] === 'weekly' ? 'block' : 'none' }}">
                            <label class="nf-label">{{ __('settings.report_day_of_week') }}</label>
                            <select name="report_day_of_week" class="nf-select">
                                @for($d = 1; $d <= 7; $d++)
                                <option value="{{ $d }}" {{ $reportConfig['day_of_week'] === $d ? 'selected' : '' }}>{{ __('settings.dow_' . $d) }}</option>
                                @endfor
                            </select>
                        </div>

                        {{-- Day of month (monthly only) --}}
                        <div id="dom-field" style="display:{{ $reportConfig['frequency'] === 'monthly' ? 'block' : 'none' }}">
                            <label class="nf-label">{{ __('settings.report_day_of_month') }}</label>
                            <input type="number" name="report_day_of_month" value="{{ $reportConfig['day_of_month'] }}"
                                   min="1" max="28" class="nf-input">
                        </div>

                        {{-- Hour --}}
                        <div>
                            <label class="nf-label">{{ __('settings.report_hour') }}</label>
                            <input type="number" name="report_hour" value="{{ $reportConfig['hour'] }}"
                                   min="0" max="23" class="nf-input">
                            <p style="font-size:0.72rem;color:#adb5bd;margin-top:4px">{{ __('settings.report_hour_hint') }}</p>
                        </div>

                    </div>

                    {{-- Recipients --}}
                    <div style="margin-bottom:16px">
                        <label class="nf-label">{{ __('settings.report_recipients') }}</label>
                        <textarea name="report_recipients" rows="2" class="nf-input" style="resize:none"
                                  placeholder="admin@example.com, director@example.com">{{ $reportConfig['recipients'] }}</textarea>
                        <p style="font-size:0.72rem;color:#adb5bd;margin-top:4px">{{ __('settings.report_recipients_hint') }}</p>
                    </div>

                    {{-- Cron hint --}}
                    <div style="background:#f3f3f9;border-radius:6px;padding:10px 14px;font-size:0.78rem;color:#6c757d;margin-bottom:16px">
                        {!! __('settings.report_cron_hint') !!}
                    </div>
                </div>

                <div style="display:flex;align-items:center;gap:10px;margin-top:4px">
                    <button type="submit" class="btn-teal">{{ __('settings.report_save') }}</button>
                    <button type="button" id="report-test-btn" onclick="sendTestReport()"
                            class="btn-ghost" style="display:{{ $reportConfig['enabled'] ? 'inline-flex' : 'none' }}">
                        {{ __('settings.report_send_test') }}
                    </button>
                    <span id="report-test-msg" style="font-size:0.8rem;display:none"></span>
                </div>
            </div>
        </form>
    </div>

    {{-- ── DONATION PAGE ───────────────────────────────── --}}
    <div id="donation-page" style="margin-top:32px;margin-bottom:32px">
        <form method="POST" action="{{ route('admin.settings.donation') }}">
            @csrf
            <div class="nf-card" style="padding:24px">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;padding-bottom:12px;border-bottom:1px solid #e9ebec">
                    <div>
                        <h2 style="font-size:0.875rem;font-weight:600;color:#343a40;margin:0 0 2px">{{ __('settings.donation_page_title') }}</h2>
                        <p style="font-size:0.78rem;color:#6c757d;margin:0">{!! __('settings.donation_page_desc') !!}</p>
                    </div>
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                        <span style="font-size:0.8rem;color:#6c757d">{{ __('settings.donation_page_enabled') }}</span>
                        <input type="hidden" name="donation_page_enabled" value="0">
                        <input type="checkbox" name="donation_page_enabled" value="1"
                               {{ $donationConfig['enabled'] ? 'checked' : '' }}
                               style="width:16px;height:16px;accent-color:#405189">
                    </label>
                </div>

                @if($donationConfig['enabled'])
                    <div style="margin-bottom:12px;padding:10px 14px;background:#f0fff8;border:1px solid #c3f0e0;border-radius:8px;font-size:0.8rem;color:#0ab39c">
                        {{ __('settings.donation_page_url') }}:
                        <a href="{{ url('/donate') }}" target="_blank" style="color:#0ab39c;font-weight:600">{{ url('/donate') }}</a>
                    </div>
                @endif

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px">
                    <div>
                        <label class="nf-label">{{ __('settings.donation_title_field') }}</label>
                        <input type="text" name="donation_page_title" class="nf-input"
                               value="{{ $donationConfig['title'] }}"
                               placeholder="{{ __('donations.public_title') }}">
                    </div>
                    <div>
                        <label class="nf-label">{{ __('settings.donation_currency') }}</label>
                        <select name="donation_currency" class="nf-select">
                            <option value="HUF" {{ $donationConfig['currency'] === 'HUF' ? 'selected' : '' }}>HUF – Magyar forint</option>
                            <option value="EUR" {{ $donationConfig['currency'] === 'EUR' ? 'selected' : '' }}>EUR – Euro</option>
                            <option value="USD" {{ $donationConfig['currency'] === 'USD' ? 'selected' : '' }}>USD – US Dollar</option>
                        </select>
                    </div>
                    <div style="grid-column:1/-1">
                        <label class="nf-label">{{ __('settings.donation_description_field') }}</label>
                        <textarea name="donation_page_description" class="nf-input" rows="2">{{ $donationConfig['description'] }}</textarea>
                    </div>
                    <div>
                        <label class="nf-label">{{ __('settings.donation_presets') }}</label>
                        <input type="text" name="donation_presets" class="nf-input"
                               value="{{ $donationConfig['presets'] }}"
                               placeholder="1000,2000,5000,10000">
                        <p style="font-size:0.72rem;color:#adb5bd;margin-top:4px">{{ __('settings.donation_presets_hint') }}</p>
                    </div>
                    <div>
                        <label class="nf-label">{{ __('settings.donation_campaign') }}</label>
                        <input type="text" name="donation_campaign" class="nf-input"
                               value="{{ $donationConfig['campaign'] }}"
                               placeholder="general">
                        <p style="font-size:0.72rem;color:#adb5bd;margin-top:4px">{{ __('settings.donation_campaign_hint') }}</p>
                    </div>
                </div>

                <div style="padding-top:16px;border-top:1px solid #f0f0f5;margin-bottom:16px">
                    <p style="font-size:0.8rem;font-weight:600;color:#495057;margin-bottom:12px">{{ __('settings.donation_bank_title') }}</p>
                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px">
                        <div>
                            <label class="nf-label">{{ __('settings.donation_bank_name') }}</label>
                            <input type="text" name="donation_bank_name" class="nf-input" value="{{ $donationConfig['bank_name'] }}">
                        </div>
                        <div>
                            <label class="nf-label">{{ __('settings.donation_bank_iban') }}</label>
                            <input type="text" name="donation_bank_iban" class="nf-input"
                                   value="{{ $donationConfig['bank_iban'] }}"
                                   placeholder="HU12 3456 7890 …" style="font-family:monospace">
                        </div>
                        <div>
                            <label class="nf-label">{{ __('settings.donation_bank_note') }}</label>
                            <input type="text" name="donation_bank_note" class="nf-input" value="{{ $donationConfig['bank_note'] }}">
                        </div>
                    </div>
                    <p style="font-size:0.75rem;color:#adb5bd;margin-top:8px">Ezek az adatok akkor jelennek meg, ha nincs online fizetési szolgáltató beállítva, vagy az adományozó átutalással fizet.</p>
                </div>

                <div style="display:flex;justify-content:flex-end">
                    <button type="submit" class="btn-primary">{{ __('settings.donation_save') }}</button>
                </div>
            </div>
        </form>
    </div>

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
<div id="modal-link-create" class="nf-overlay" onclick="if(event.target===this&&__nfMdTarget===this)closeModal('modal-link-create')">
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
<div id="modal-link-edit" class="nf-overlay" onclick="if(event.target===this&&__nfMdTarget===this)closeModal('modal-link-edit')">
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
function selectMailer(val) {
    ['smtp', 'resend', 'log'].forEach(v => {
        const opt = document.getElementById('mailer-opt-' + v);
        const fields = document.getElementById(v + '-fields');
        const isActive = v === val;
        if (opt) {
            opt.style.borderColor  = isActive ? '#405189' : '#dee2e6';
            opt.style.color        = isActive ? '#405189' : '#495057';
        }
        if (fields) fields.style.display = isActive ? (v === 'smtp' ? 'grid' : 'block') : 'none';
    });
}

function previewLogo(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        const imgs = input.closest('div').parentElement.querySelectorAll('img');
        if (imgs.length) {
            imgs[0].src = e.target.result;
        } else {
            const placeholder = input.closest('div').parentElement.querySelector('div[style*="42px"]');
            if (placeholder) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.cssText = 'height:42px;max-width:120px;object-fit:contain;border:1px solid #e9ebec;border-radius:6px;padding:4px;background:#f8f9fa';
                placeholder.replaceWith(img);
            }
        }
    };
    reader.readAsDataURL(input.files[0]);
}

function updateColorPreview(hex) {
    const preview = document.getElementById('brand-color-preview');
    if (preview && hex.match(/^#[0-9a-fA-F]{6}$/)) {
        preview.style.background = `linear-gradient(90deg, ${hex}, ${hex}cc)`;
    }
}

function selectProvider(val) {
    ['none', 'stripe', 'barion'].forEach(v => {
        const opt = document.getElementById('pay-opt-' + v);
        const isActive = v === (val || 'none');
        if (opt) {
            opt.style.borderColor = isActive ? '#405189' : '#dee2e6';
            opt.style.color       = isActive ? '#405189' : '#495057';
        }
    });
    document.getElementById('pay-stripe').style.display = val === 'stripe' ? 'block' : 'none';
    document.getElementById('pay-barion').style.display = val === 'barion' ? 'block' : 'none';
}

function toggleReportFields() {
    const enabled = document.getElementById('report-enabled').checked;
    document.getElementById('report-fields').style.display = enabled ? 'block' : 'none';
    const testBtn = document.getElementById('report-test-btn');
    if (testBtn) testBtn.style.display = enabled ? 'inline-flex' : 'none';
}

function updateFrequencyFields() {
    const freq = document.getElementById('report-frequency').value;
    document.getElementById('dow-field').style.display = freq === 'weekly'  ? 'block' : 'none';
    document.getElementById('dom-field').style.display = freq === 'monthly' ? 'block' : 'none';
}

function sendTestReport() {
    const btn = document.getElementById('report-test-btn');
    const msg = document.getElementById('report-test-msg');
    btn.disabled = true;
    msg.style.display = 'none';

    fetch('{{ route("admin.settings.report.test") }}', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
        body: '{}',
    })
    .then(r => r.json())
    .then(data => {
        msg.style.display = 'inline';
        msg.style.color   = data.ok ? '#0ab39c' : '#f06548';
        msg.textContent   = data.ok ? '{{ __("settings.report_sent") }}' : (data.message || '{{ __("settings.report_send_error") }}');
        btn.disabled = false;
    })
    .catch(() => {
        msg.style.display = 'inline';
        msg.style.color   = '#f06548';
        msg.textContent   = '{{ __("settings.report_send_error") }}';
        btn.disabled = false;
    });
}

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
