<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 9pt; color: #212529; }

  .header { background: #0b1437; color: #fff; padding: 14px 20px; margin-bottom: 16px; }
  .header h1 { font-size: 14pt; font-weight: bold; margin-bottom: 2px; }
  .header p  { font-size: 8pt; color: #8ba3d4; }

  .meta { display: flex; justify-content: space-between; margin-bottom: 14px; padding: 0 2px; }
  .meta-box { background: #f8f9fa; border: 1px solid #e9ebec; border-radius: 6px; padding: 8px 14px; font-size: 8pt; }
  .meta-box .label { color: #6c757d; font-size: 7.5pt; }
  .meta-box .value { font-weight: bold; color: #212529; margin-top: 2px; }

  .totals { margin-bottom: 14px; }
  .totals table { width: 100%; border-collapse: collapse; }
  .totals td { padding: 5px 10px; font-size: 8.5pt; }
  .totals .t-label { background: #f0f4ff; color: #405189; font-weight: bold; border-radius: 4px; }
  .totals .t-val { font-weight: bold; color: #0ab39c; font-size: 10pt; }

  .filters { margin-bottom: 14px; font-size: 7.5pt; color: #6c757d; }
  .filters span { background: #f0f4ff; color: #405189; border-radius: 4px; padding: 2px 8px; margin-right: 6px; }

  table.main { width: 100%; border-collapse: collapse; }
  table.main thead tr { background: #405189; color: #fff; }
  table.main thead th { padding: 6px 8px; font-size: 8pt; text-align: left; font-weight: bold; }
  table.main tbody tr:nth-child(even) { background: #f8f9ff; }
  table.main tbody td { padding: 5px 8px; font-size: 8pt; border-bottom: 1px solid #f0f0f5; vertical-align: top; }

  .badge { display: inline-block; padding: 1px 6px; border-radius: 3px; font-size: 7.5pt; font-weight: bold; }
  .badge-completed { background: #d1fae5; color: #065f46; }
  .badge-pending   { background: #fef9c3; color: #92400e; }
  .badge-failed    { background: #fee2e2; color: #991b1b; }
  .badge-refunded  { background: #e5e7eb; color: #374151; }

  .amount { text-align: right; font-weight: 600; color: #0ab39c; }
  .footer { margin-top: 16px; padding-top: 10px; border-top: 1px solid #e9ebec; font-size: 7.5pt; color: #adb5bd; text-align: center; }

  .section-title { font-size: 9pt; font-weight: bold; color: #343a40; margin-bottom: 8px; }
</style>
</head>
<body>

<div class="header">
  <h1>{{ $orgName }} — Donation Export</h1>
  <p>Generated: {{ $generatedAt }} &nbsp;|&nbsp; Total records: {{ $donations->count() }}</p>
</div>

@if($filters)
<div class="filters">
  <strong>Filters:</strong>
  @foreach($filters as $key => $val)
    <span>{{ $key }}: {{ $val }}</span>
  @endforeach
</div>
@endif

{{-- Summary totals --}}
@if($totals->count())
<div class="totals" style="margin-bottom:14px">
  <p class="section-title">Completed donations summary</p>
  <table>
    <tr>
      @foreach($totals as $t)
        <td style="width:{{ 100 / $totals->count() }}%">
          <div class="meta-box">
            <div class="label">Total ({{ $t['currency'] }})</div>
            <div class="value t-val">{{ number_format($t['sum'], 0, ',', ' ') }} {{ $t['currency'] }}</div>
            <div class="label" style="margin-top:4px">{{ $t['count'] }} completed</div>
          </div>
        </td>
      @endforeach
      <td style="width:{{ 100 / ($totals->count() + 2) }}%">
        <div class="meta-box">
          <div class="label">Total donations</div>
          <div class="value" style="font-size:10pt">{{ $donations->count() }}</div>
          <div class="label" style="margin-top:4px">all statuses</div>
        </div>
      </td>
    </tr>
  </table>
</div>
@endif

{{-- Detailed table --}}
<p class="section-title">Donation details</p>
<table class="main">
  <thead>
    <tr>
      <th style="width:4%">#</th>
      <th style="width:9%">Date</th>
      <th style="width:18%">Donor</th>
      <th style="width:16%">Email</th>
      <th style="width:9%;text-align:right">Amount</th>
      <th style="width:7%">Status</th>
      <th style="width:9%">Method</th>
      <th style="width:9%">Campaign</th>
      <th style="width:5%">Rec.</th>
      <th style="width:14%">Transaction ID</th>
    </tr>
  </thead>
  <tbody>
    @forelse($donations as $d)
    @php
      $donor = $d->person
        ? trim($d->person->last_name . ' ' . $d->person->first_name)
        : ($d->is_anonymous ? '(anonymous)' : ($d->donor_name ?? '—'));
      $email = $d->person?->email ?? $d->donor_email ?? '—';
    @endphp
    <tr>
      <td style="color:#adb5bd">{{ $d->id }}</td>
      <td>{{ $d->created_at->format('Y-m-d') }}</td>
      <td>{{ $donor }}</td>
      <td style="color:#6c757d;font-size:7.5pt">{{ $email }}</td>
      <td class="amount">{{ number_format($d->amount, 0, ',', ' ') }} {{ $d->currency }}</td>
      <td><span class="badge badge-{{ $d->status }}">{{ ucfirst($d->status) }}</span></td>
      <td style="color:#6c757d">{{ $d->payment_method ?? '—' }}</td>
      <td style="color:#6c757d">{{ $d->campaign ?? '—' }}</td>
      <td style="text-align:center">{{ $d->is_recurring ? '✓' : '—' }}</td>
      <td style="font-size:6.5pt;color:#adb5bd;word-break:break-all">{{ $d->transaction_id ?? '—' }}</td>
    </tr>
    @empty
    <tr>
      <td colspan="10" style="text-align:center;color:#adb5bd;padding:20px">No donations match the selected filters.</td>
    </tr>
    @endforelse
  </tbody>
</table>

<div class="footer">
  {{ $orgName }} &nbsp;|&nbsp; {{ config('app.url') }} &nbsp;|&nbsp; Exported {{ $generatedAt }}
</div>

</body>
</html>
