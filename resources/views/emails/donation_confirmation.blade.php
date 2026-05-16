<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ __('donations.email_subject') }}</title>
<style>
  body { margin:0; padding:0; background:#f3f4f8; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif; color:#212529; }
  .wrap { max-width:560px; margin:32px auto; background:#fff; border-radius:12px; border:1px solid #e9ebec; overflow:hidden; }
  .header { background:#0b1437; padding:28px 32px; text-align:center; }
  .header h1 { color:#fff; font-size:1.15rem; margin:0 0 4px; }
  .header p  { color:#8ba3d4; font-size:0.8rem; margin:0; }
  .body { padding:32px; }
  .amount-box { background:#f0f4ff; border-radius:10px; text-align:center; padding:20px; margin:24px 0; }
  .amount-box .label { font-size:0.8rem; color:#6c757d; margin-bottom:4px; }
  .amount-box .value { font-size:2rem; font-weight:700; color:#405189; }
  .info-row { display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #f0f0f5; font-size:0.8375rem; }
  .info-row .k { color:#6c757d; }
  .info-row .v { font-weight:500; color:#212529; }
  .footer { background:#f8f9fa; padding:20px 32px; text-align:center; border-top:1px solid #e9ebec; }
  .footer p { font-size:0.75rem; color:#adb5bd; margin:0; }
</style>
</head>
<body>
<div class="wrap">
  <div class="header">
    <h1>{{ __('donations.email_heading') }}</h1>
    <p>{{ $donation->config['org_name'] ?? config('app.name') }}</p>
  </div>
  <div class="body">
    <p style="font-size:0.9rem;color:#495057;margin:0 0 8px">
      {{ $donation->donor_name ? __('donations.email_hi', ['name' => $donation->donor_name]) : __('donations.email_hi_anon') }}
    </p>
    <p style="font-size:0.875rem;color:#6c757d;margin:0 0 16px">{{ __('donations.email_body') }}</p>

    <div class="amount-box">
      <div class="label">{{ __('donations.email_amount') }}</div>
      <div class="value">{{ number_format($donation->amount, 0, ',', ' ') }} {{ $donation->currency }}</div>
    </div>

    <div>
      @if($donation->campaign)
      <div class="info-row">
        <span class="k">{{ __('donations.campaign') }}</span>
        <span class="v">{{ $donation->campaign }}</span>
      </div>
      @endif
      <div class="info-row">
        <span class="k">{{ __('donations.col_date') }}</span>
        <span class="v">{{ $donation->created_at->format('Y-m-d H:i') }}</span>
      </div>
      @if($donation->message)
      <div class="info-row" style="border:none">
        <span class="k">{{ __('donations.message_label') }}</span>
        <span class="v" style="max-width:60%;text-align:right">{{ $donation->message }}</span>
      </div>
      @endif
    </div>

    <p style="font-size:0.8rem;color:#adb5bd;margin:24px 0 0">{{ __('donations.email_footer') }}</p>
  </div>
  <div class="footer">
    <p>{{ config('app.name') }} &middot; {{ config('app.url') }}</p>
  </div>
</div>
</body>
</html>
