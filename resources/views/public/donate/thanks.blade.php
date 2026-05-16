<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('donations.thanks_title') }} – {{ $config['org_name'] }}</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f3f4f8; color: #212529; min-height: 100vh; }
        .nf-header { background: #0b1437; padding: 14px 24px; display: flex; align-items: center; gap: 10px; }
        .nf-logo { width: 32px; height: 32px; background: #1a3a6b; border: 2px solid #4d7efa; border-radius: 7px; display: flex; align-items: center; justify-content: center; font-weight: 800; color: #fff; font-size: 0.9rem; }
        .nf-brand { color: #fff; font-weight: 700; font-size: 1rem; }
        .page-wrap { max-width: 480px; margin: 60px auto; padding: 0 20px 60px; text-align: center; }
        .icon-circle { width: 72px; height: 72px; background: rgba(10,179,156,.12); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; }
        h1 { font-size: 1.5rem; font-weight: 700; color: #212529; margin-bottom: 10px; }
        .subtitle { font-size: 0.9rem; color: #6c757d; line-height: 1.6; margin-bottom: 32px; }
        .amount-box { background: #fff; border-radius: 12px; border: 1px solid #e9ebec; padding: 24px; margin-bottom: 24px; }
        .amount-box .lbl { font-size: 0.75rem; color: #adb5bd; margin-bottom: 6px; }
        .amount-box .val { font-size: 2rem; font-weight: 800; color: #405189; }
        .bank-card { background: #fff; border-radius: 12px; border: 1px solid #e9ebec; padding: 20px 24px; margin-bottom: 24px; text-align: left; }
        .bank-card h3 { font-size: 0.875rem; font-weight: 600; color: #343a40; margin-bottom: 14px; }
        .bank-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f0f0f5; font-size: 0.8375rem; }
        .bank-row:last-child { border: none; }
        .bank-row .k { color: #6c757d; }
        .bank-row .v { font-weight: 600; color: #212529; }
        .back-btn { display: inline-block; padding: 12px 28px; background: #405189; color: #fff; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 0.9rem; }
        .back-btn:hover { background: #354475; }
    </style>
</head>
<body>

<div class="nf-header">
    <div class="nf-logo">N</div>
    <span class="nf-brand">{{ $config['org_name'] }}</span>
</div>

<div class="page-wrap">

    <div class="icon-circle">
        <svg width="34" height="34" fill="none" stroke="#0ab39c" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
        </svg>
    </div>

    <h1>{{ __('donations.thanks_title') }}</h1>

    @if($donation->status === 'completed')
        <p class="subtitle">{{ __('donations.thanks_desc_payment') }}</p>
    @else
        <p class="subtitle">{{ __('donations.thanks_desc_transfer') }}</p>
    @endif

    <div class="amount-box">
        <div class="lbl">{{ __('donations.email_amount') }}</div>
        <div class="val">{{ number_format($donation->amount, 0, ',', ' ') }} {{ $donation->currency }}</div>
    </div>

    @if($donation->status === 'pending' && $bankDetails['iban'])
        <div class="bank-card">
            <h3>{{ __('donations.bank_details') }}</h3>
            @if($bankDetails['name'])
            <div class="bank-row">
                <span class="k">{{ __('donations.bank_name') }}</span>
                <span class="v">{{ $bankDetails['name'] }}</span>
            </div>
            @endif
            <div class="bank-row">
                <span class="k">{{ __('donations.bank_iban') }}</span>
                <span class="v" style="font-family:monospace;letter-spacing:.05em">{{ $bankDetails['iban'] }}</span>
            </div>
            @if($bankDetails['note'])
            <div class="bank-row">
                <span class="k">{{ __('donations.bank_note') }}</span>
                <span class="v">{{ $bankDetails['note'] }}</span>
            </div>
            @endif
            @if($donation->campaign)
            <div class="bank-row">
                <span class="k">{{ __('donations.bank_reference') }}</span>
                <span class="v">{{ $donation->campaign }}</span>
            </div>
            @endif
        </div>
    @endif

    <a href="{{ url('/') }}" class="back-btn">{{ __('donations.back_to_home') }}</a>

</div>

</body>
</html>
