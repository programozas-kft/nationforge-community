@extends('admin.layouts.app')

@section('title', __('events.checkin_title') . ' – ' . $event->title)
@section('header', __('events.checkin_title'))
@section('breadcrumb')
    <a href="{{ route('admin.events.index') }}">{{ __('events.title') }}</a>
    <span class="breadcrumb-sep">/</span>
    <a href="{{ route('admin.events.show', $event) }}">{{ $event->title }}</a>
    <span class="breadcrumb-sep">/</span>
    <span class="text-gray-700">{{ __('events.checkin_title') }}</span>
@endsection

@section('header-actions')
    <a href="{{ route('admin.events.show', $event) }}" class="btn-ghost">← {{ __('common.back') }}</a>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

    {{-- QR Scanner --}}
    <div class="nf-card">
        <div class="nf-card-header">{{ __('events.checkin_scan') }}</div>
        <div style="padding:20px">
            <div id="qr-reader" style="width:100%;border-radius:8px;overflow:hidden;background:#000;min-height:240px"></div>

            <div id="scan-result" style="margin-top:16px;display:none">
                <div id="result-box" style="border-radius:8px;padding:16px;font-size:0.9rem;line-height:1.5"></div>
            </div>

            <div style="margin-top:12px;display:flex;gap:8px">
                <button id="btn-start" onclick="startScanner()"
                    style="flex:1;padding:9px 0;background:#405189;color:#fff;border:none;border-radius:7px;font-weight:600;font-size:0.85rem;cursor:pointer">
                    {{ __('events.checkin_start') }}
                </button>
                <button id="btn-stop" onclick="stopScanner()" style="display:none;
                    flex:1;padding:9px 0;background:#6c757d;color:#fff;border:none;border-radius:7px;font-weight:600;font-size:0.85rem;cursor:pointer">
                    {{ __('events.checkin_stop') }}
                </button>
            </div>

            {{-- Manual token input --}}
            <div style="margin-top:16px;border-top:1px solid #e9ebec;padding-top:16px">
                <p style="font-size:0.78rem;color:#6c757d;margin-bottom:8px">{{ __('events.checkin_manual_input') }}</p>
                <div style="display:flex;gap:8px">
                    <input id="manual-token" type="text" placeholder="{{ __('events.checkin_token_placeholder') }}"
                        style="flex:1;padding:8px 12px;border:1px solid #ced4da;border-radius:6px;font-size:0.85rem;outline:none">
                    <button onclick="submitToken(document.getElementById('manual-token').value)"
                        style="padding:8px 16px;background:#405189;color:#fff;border:none;border-radius:6px;font-weight:600;font-size:0.85rem;cursor:pointer">
                        OK
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Registration list --}}
    <div class="nf-card overflow-hidden">
        <div class="nf-card-header" style="display:flex;align-items:center;justify-content:space-between">
            <span>{{ __('events.registrations') }} ({{ $event->registrations->count() }})</span>
            @php $checkedIn = $event->registrations->whereNotNull('checked_in_at')->count(); @endphp
            <span style="font-size:0.78rem;color:#0ab39c;font-weight:600">{{ $checkedIn }} / {{ $event->registrations->count() }} {{ __('events.checkin_done') }}</span>
        </div>
        <div style="max-height:500px;overflow-y:auto">
            <table class="nf-table" id="reg-table">
                <thead>
                    <tr>
                        <th>{{ __('common.name') }}</th>
                        <th>{{ __('events.col_guests') }}</th>
                        <th>{{ __('events.col_checkin') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($event->registrations->sortBy('name') as $reg)
                    <tr id="reg-row-{{ $reg->id }}" class="{{ $reg->checked_in_at ? 'row-checked' : '' }}">
                        <td style="font-weight:500;color:#343a40">{{ $reg->name }}<br>
                            <span style="font-size:0.75rem;color:#adb5bd">{{ $reg->email }}</span>
                        </td>
                        <td style="color:#6c757d">{{ $reg->guests > 0 ? '+' . $reg->guests : '—' }}</td>
                        <td id="checkin-cell-{{ $reg->id }}">
                            @if($reg->checked_in_at)
                                <span style="color:#0ab39c;font-size:0.8rem;font-weight:600;display:flex;align-items:center;gap:3px">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    {{ $reg->checked_in_at->format('H:i') }}
                                </span>
                            @else
                                <span style="color:#dee2e6;font-size:0.8rem">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" style="text-align:center;padding:32px;color:#adb5bd">{{ __('events.no_regs') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<style>
.row-checked { background: rgba(10,179,156,0.04); }
#qr-reader video { border-radius: 8px; }
</style>

<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
let html5QrCode = null;
let scanning = false;
let lastScanned = null;

const checkinUrl = '{{ route('admin.events.checkin.store', $event) }}';
const csrfToken = '{{ csrf_token() }}';

function startScanner() {
    if (scanning) return;
    html5QrCode = new Html5Qrcode("qr-reader");
    html5QrCode.start(
        { facingMode: "environment" },
        { fps: 10, qrbox: { width: 220, height: 220 } },
        (decodedText) => {
            if (decodedText === lastScanned) return;
            lastScanned = decodedText;
            submitToken(decodedText);
        },
        () => {}
    ).then(() => {
        scanning = true;
        document.getElementById('btn-start').style.display = 'none';
        document.getElementById('btn-stop').style.display = 'flex';
    }).catch(err => {
        showResult(false, '{{ __('events.checkin_camera_error') }}: ' + err, null, null);
    });
}

function stopScanner() {
    if (html5QrCode && scanning) {
        html5QrCode.stop().then(() => {
            scanning = false;
            lastScanned = null;
            document.getElementById('btn-start').style.display = 'flex';
            document.getElementById('btn-stop').style.display = 'none';
        });
    }
}

function submitToken(token) {
    token = token.trim();
    if (!token) return;

    fetch(checkinUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        body: JSON.stringify({ token })
    })
    .then(r => r.json())
    .then(data => {
        showResult(data.success, data.message, data.name, data.guests, data.already ?? false);
        if (data.success) {
            updateRow(token, data.name);
            document.getElementById('manual-token').value = '';
            setTimeout(() => { lastScanned = null; }, 3000);
        }
    })
    .catch(() => showResult(false, '{{ __('events.checkin_error') }}', null, null));
}

function showResult(success, message, name, guests, already = false) {
    const box = document.getElementById('result-box');
    const wrap = document.getElementById('scan-result');
    wrap.style.display = 'block';

    let bg, border, icon, guestStr = '';
    if (success) {
        bg = 'rgba(10,179,156,0.08)'; border = '#0ab39c';
        icon = '<svg width="22" height="22" fill="none" stroke="#0ab39c" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
    } else if (already) {
        bg = 'rgba(247,184,75,0.1)'; border = '#f7b84b';
        icon = '<svg width="22" height="22" fill="none" stroke="#f7b84b" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 2a10 10 0 110 20A10 10 0 0112 2z"/></svg>';
    } else {
        bg = 'rgba(220,53,69,0.08)'; border = '#dc3545';
        icon = '<svg width="22" height="22" fill="none" stroke="#dc3545" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M12 2a10 10 0 110 20A10 10 0 0112 2z"/></svg>';
    }

    if (guests > 0) guestStr = ` <span style="color:#6c757d;font-size:0.8rem">(+${guests} {{ __('events.col_guests') }})</span>`;

    box.style.cssText = `background:${bg};border:1px solid ${border};border-radius:8px;padding:14px 16px`;
    box.innerHTML = `
        <div style="display:flex;align-items:center;gap:10px">
            ${icon}
            <div>
                <div style="font-weight:700;font-size:0.9rem;color:#212529">${name ? name + guestStr : message}</div>
                ${name ? `<div style="font-size:0.8rem;color:#6c757d;margin-top:2px">${message}</div>` : ''}
            </div>
        </div>`;
}

function updateRow(token, name) {
    const now = new Date();
    const timeStr = now.toLocaleTimeString('hu-HU', { hour: '2-digit', minute: '2-digit' });
    // find row by name match (best effort) — full refresh on next page load
    const rows = document.querySelectorAll('#reg-table tbody tr');
    rows.forEach(row => {
        const td = row.querySelector('td');
        if (td && td.textContent.trim().startsWith(name)) {
            row.classList.add('row-checked');
            const cell = row.querySelector('td:last-child');
            if (cell) {
                cell.innerHTML = `<span style="color:#0ab39c;font-size:0.8rem;font-weight:600;display:flex;align-items:center;gap:3px">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    ${timeStr}
                </span>`;
            }
        }
    });
}
</script>
@endsection
