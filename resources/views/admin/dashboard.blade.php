@extends('admin.layouts.app')

@section('title', __('dashboard.title'))
@section('header', __('dashboard.title'))

@section('header-actions')
<button onclick="openCustomizer()"
        class="nf-btn-ghost flex items-center gap-1.5 text-sm font-medium px-3 py-1.5 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
    </svg>
    {{ __('dashboard.customize') }}
</button>
@endsection

@section('content')

@php
    use App\Http\Controllers\Admin\DashboardWidgetController;
    $widgetMap = collect($widgets)->keyBy('id');
    $isVisible = fn($id) => (bool)($widgetMap[$id]['visible'] ?? true);
    $spanClass = function(string $span): string {
        return match($span) {
            'quarter'    => 'col-span-12 sm:col-span-6 lg:col-span-3',
            'half'       => 'col-span-12 lg:col-span-6',
            'two-thirds' => 'col-span-12 lg:col-span-8',
            'one-third'  => 'col-span-12 lg:col-span-4',
            default      => 'col-span-12',
        };
    };
    $statusBadge = ['member'=>'badge-primary','supporter'=>'badge-success','donor'=>'badge-warning','vip'=>'badge-purple','inactive'=>'badge-secondary','prospect'=>'badge-info','volunteer'=>'badge-success'];
@endphp

<div class="grid grid-cols-12 gap-5">
@foreach($widgets as $widget)
@if($widget['visible'])
@php $wid = $widget['id']; $def = DashboardWidgetController::DEFS[$wid]; $sc = $spanClass($def['span']); @endphp

{{-- ── stat_contacts ─────────────────────────────────────── --}}
@if($wid === 'stat_contacts')
<div class="{{ $sc }}">
<div class="nf-card p-5 flex items-center gap-4 h-full">
    <div class="stat-icon flex-shrink-0" style="background:rgba(64,81,137,0.12)">
        <svg class="w-6 h-6" style="color:#405189" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
    </div>
    <div>
        <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['people']) }}</p>
        <p class="text-xs text-gray-500 mt-0.5">{{ __('dashboard.total_contacts') }}</p>
        <p class="text-xs mt-1" style="color:#0ab39c">+{{ $stats['new_people'] }} {{ __('dashboard.this_month') }}</p>
    </div>
</div>
</div>

{{-- ── stat_events ───────────────────────────────────────── --}}
@elseif($wid === 'stat_events')
<div class="{{ $sc }}">
<div class="nf-card p-5 flex items-center gap-4 h-full">
    <div class="stat-icon flex-shrink-0" style="background:rgba(10,179,156,0.12)">
        <svg class="w-6 h-6" style="color:#0ab39c" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
    </div>
    <div>
        <p class="text-2xl font-bold text-gray-800">{{ $stats['events'] }}</p>
        <p class="text-xs text-gray-500 mt-0.5">{{ __('dashboard.upcoming_events') }}</p>
    </div>
</div>
</div>

{{-- ── stat_donations ────────────────────────────────────── --}}
@elseif($wid === 'stat_donations')
<div class="{{ $sc }}">
<div class="nf-card p-5 flex items-center gap-4 h-full">
    <div class="stat-icon flex-shrink-0" style="background:rgba(247,184,75,0.12)">
        <svg class="w-6 h-6" style="color:#f7b84b" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </div>
    <div>
        <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['donations'], 0, ',', ' ') }}</p>
        <p class="text-xs text-gray-500 mt-0.5">{{ __('dashboard.total_donations') }}</p>
    </div>
</div>
</div>

{{-- ── stat_subscribed ───────────────────────────────────── --}}
@elseif($wid === 'stat_subscribed')
<div class="{{ $sc }}">
<div class="nf-card p-5 flex items-center gap-4 h-full">
    <div class="stat-icon flex-shrink-0" style="background:rgba(122,90,248,0.12)">
        <svg class="w-6 h-6" style="color:#7a5af8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
    </div>
    <div>
        <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['subscribed']) }}</p>
        <p class="text-xs text-gray-500 mt-0.5">{{ __('dashboard.newsletter_subs') }}</p>
    </div>
</div>
</div>

{{-- ── chart_donations ───────────────────────────────────── --}}
@elseif($wid === 'chart_donations')
<div class="{{ $sc }}">
<div class="nf-card p-5">
    <div class="flex items-center justify-between mb-4">
        <div>
            <p class="text-sm font-semibold text-gray-800">{{ __('dashboard.monthly_donations') }}</p>
            <p class="text-xs text-gray-400">{{ __('dashboard.last_12_months_ft') }}</p>
        </div>
    </div>
    <canvas id="donationChart" height="60"></canvas>
</div>
</div>

{{-- ── list_contacts ─────────────────────────────────────── --}}
@elseif($wid === 'list_contacts')
<div class="{{ $sc }}">
<div class="nf-card h-full">
    <div class="nf-card-header flex items-center justify-between">
        <span>{{ __('dashboard.latest_contacts') }}</span>
        <a href="{{ route('admin.people.index') }}" class="text-xs font-normal" style="color:#405189">{{ __('dashboard.view_all') }}</a>
    </div>
    <div class="divide-y" style="border-color:#f3f3f9">
        @forelse($recent_people as $person)
        <div class="px-5 py-3 flex items-center gap-3">
            @if($person->photo)
                <div style="width:32px;height:32px;border-radius:50%;overflow:hidden;flex-shrink:0">
                    <img src="{{ asset('storage/' . $person->photo) }}" style="width:100%;height:100%;object-fit:cover" alt="">
                </div>
            @else
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0"
                     style="background:linear-gradient(135deg,#405189,#7a5af8)">
                    {{ strtoupper(substr($person->first_name, 0, 1)) }}
                </div>
            @endif
            <div class="flex-1 min-w-0">
                <a href="{{ route('admin.people.show', $person) }}"
                   class="text-sm font-medium text-gray-800 hover:text-indigo-700 truncate block">
                    {{ $person->last_name }} {{ $person->first_name }}
                </a>
                <p class="text-xs text-gray-400 truncate">{{ $person->email ?? '—' }}</p>
            </div>
            <span class="nf-badge {{ $statusBadge[$person->status] ?? 'badge-secondary' }}" style="white-space:nowrap;flex-shrink:0">
                {{ __('dashboard.status.' . $person->status, [], null) ?? $person->status }}
            </span>
        </div>
        @empty
        <div class="px-5 py-6 text-center text-sm text-gray-400">{{ __('dashboard.no_contacts') }}</div>
        @endforelse
    </div>
</div>
</div>

{{-- ── list_events ───────────────────────────────────────── --}}
@elseif($wid === 'list_events')
<div class="{{ $sc }}">
<div class="nf-card h-full">
    <div class="nf-card-header flex items-center justify-between">
        <span>{{ __('dashboard.upcoming_events_panel') }}</span>
        <a href="{{ route('admin.events.index') }}" class="text-xs font-normal" style="color:#405189">{{ __('dashboard.view_all') }}</a>
    </div>
    <div class="divide-y" style="border-color:#f3f3f9">
        @forelse($upcoming_events as $event)
        <div style="padding:12px 20px;display:flex;align-items:center;gap:12px">
            <div class="w-10 h-10 rounded-lg flex flex-col items-center justify-center flex-shrink-0 text-white"
                 style="background:linear-gradient(135deg,#0ab39c,#0a8c7a)">
                <span class="text-xs font-bold leading-none">{{ $event->starts_at->format('d') }}</span>
                <span class="text-xs leading-none opacity-80">{{ $event->starts_at->format('M') }}</span>
            </div>
            <div class="flex-1 min-w-0">
                <a href="{{ route('admin.events.show', $event) }}"
                   class="text-sm font-medium text-gray-800 hover:text-indigo-700 truncate block">
                    {{ $event->title }}
                </a>
                <p class="text-xs text-gray-400">{{ $event->starts_at->format('H:i') }} · {{ $event->city ?? ($event->is_online ? __('common.online') : '—') }}</p>
            </div>
            <span class="nf-badge badge-info">{{ $event->type }}</span>
        </div>
        @empty
        <div style="padding:24px 20px;text-align:center;font-size:0.875rem;color:#adb5bd">{{ __('dashboard.no_events') }}</div>
        @endforelse
    </div>
</div>
</div>

{{-- ── chart_growth ──────────────────────────────────────── --}}
@elseif($wid === 'chart_growth')
<div class="{{ $sc }}">
<div class="nf-card p-5 h-full">
    <div class="flex items-center justify-between mb-4">
        <div>
            <p class="text-sm font-semibold text-gray-800">{{ __('dashboard.contact_growth') }}</p>
            <p class="text-xs text-gray-400">{{ __('dashboard.last_12_months') }}</p>
        </div>
        <div class="flex items-center gap-4 text-xs text-gray-500">
            <span class="flex items-center gap-1">
                <span style="display:inline-block;width:12px;height:3px;background:#405189;border-radius:2px"></span>
                {{ __('dashboard.contacts_label') }}
            </span>
            <span class="flex items-center gap-1">
                <span style="display:inline-block;width:12px;height:3px;background:#0ab39c;border-radius:2px"></span>
                {{ __('dashboard.donations_label') }}
            </span>
        </div>
    </div>
    <canvas id="growthChart" height="100"></canvas>
</div>
</div>

{{-- ── chart_status ──────────────────────────────────────── --}}
@elseif($wid === 'chart_status')
<div class="{{ $sc }}">
<div class="nf-card p-5 h-full">
    <div class="mb-4">
        <p class="text-sm font-semibold text-gray-800">{{ __('dashboard.contact_distribution') }}</p>
        <p class="text-xs text-gray-400">{{ __('dashboard.by_status') }}</p>
    </div>
    <canvas id="statusChart" height="200"></canvas>
    <div id="statusLegend" class="mt-4 space-y-1"></div>
</div>
</div>

@endif
@endif
@endforeach
</div>

{{-- ── Customizer drawer ─────────────────────────────────── --}}
<div id="customizerOverlay"
     class="hidden fixed inset-0 z-40"
     style="background:rgba(0,0,0,0.35)"
     onclick="closeCustomizer()"></div>

<div id="customizerPanel"
     class="fixed top-0 right-0 h-full z-50 flex flex-col"
     style="width:320px;background:#fff;box-shadow:-4px 0 24px rgba(0,0,0,0.12);transform:translateX(100%);transition:transform .25s ease">

    <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid #f3f3f9">
        <div>
            <p class="text-sm font-semibold text-gray-800">{{ __('dashboard.customize_title') }}</p>
            <p class="text-xs text-gray-400 mt-0.5">{{ __('dashboard.customize_desc') }}</p>
        </div>
        <button onclick="closeCustomizer()" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
    </div>

    <div id="customizerList" class="flex-1 overflow-y-auto divide-y" style="border-color:#f3f3f9">
        @foreach($widgets as $widget)
        @php $def = DashboardWidgetController::DEFS[$widget['id']]; @endphp
        <div class="flex items-center gap-3 px-5 py-3 select-none" data-id="{{ $widget['id'] }}">
            <span class="drag-handle cursor-move text-gray-300 hover:text-gray-400" title="Drag to reorder">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9 5a1 1 0 100 2 1 1 0 000-2zm6 0a1 1 0 100 2 1 1 0 000-2zM9 11a1 1 0 100 2 1 1 0 000-2zm6 0a1 1 0 100 2 1 1 0 000-2zM9 17a1 1 0 100 2 1 1 0 000-2zm6 0a1 1 0 100 2 1 1 0 000-2z"/>
                </svg>
            </span>
            <span class="flex-1 text-sm text-gray-700">{{ __($def['label_key']) }}</span>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" class="sr-only peer" {{ $widget['visible'] ? 'checked' : '' }}>
                <div class="w-9 h-5 rounded-full transition-colors duration-200 peer-checked:bg-indigo-600 bg-gray-200 relative after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-transform after:duration-200 peer-checked:after:translate-x-4"></div>
            </label>
        </div>
        @endforeach
    </div>

    <div class="px-5 py-4" style="border-top:1px solid #f3f3f9">
        <button onclick="saveWidgets()" id="saveWidgetsBtn"
                class="w-full py-2 px-4 rounded-lg text-sm font-medium text-white transition-colors"
                style="background:#405189">
            {{ __('dashboard.customize_save') }}
        </button>
        <p id="customizerSaved" class="text-center text-xs mt-2 hidden" style="color:#0ab39c">
            {{ __('dashboard.customize_saved') }}
        </p>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
const monthLabels      = @json($monthLabels);
const monthlyPeople    = @json($monthlyPeople);
const monthlyDonations = @json($monthlyDonations);
const statusNames      = @json($statusNames);
const statusData       = @json($statusData);
const personUnit       = @json(__('dashboard.person_unit'));
const contactsLabel    = @json(__('dashboard.contacts_label'));
const donationsLabel   = @json(__('dashboard.donations_label'));
const contactsAxis     = @json(__('dashboard.contacts_axis'));
const donationsAxis    = @json(__('dashboard.donations_axis'));

const statusColors = ['#405189','#0ab39c','#f7b84b','#7a5af8','#f06548','#299cdb','#adb5bd'];

Chart.defaults.font.family = "'Inter', sans-serif";
Chart.defaults.font.size   = 11;
Chart.defaults.color       = '#6c757d';

if (document.getElementById('growthChart')) {
    new Chart(document.getElementById('growthChart'), {
        type: 'line',
        data: {
            labels: monthLabels,
            datasets: [
                {
                    label: contactsLabel,
                    data: monthlyPeople,
                    borderColor: '#405189',
                    backgroundColor: 'rgba(64,81,137,0.08)',
                    borderWidth: 2.5,
                    pointRadius: 3,
                    pointBackgroundColor: '#405189',
                    tension: 0.4,
                    fill: true,
                    yAxisID: 'yPeople',
                },
                {
                    label: donationsLabel,
                    data: monthlyDonations,
                    borderColor: '#0ab39c',
                    backgroundColor: 'rgba(10,179,156,0.07)',
                    borderWidth: 2.5,
                    pointRadius: 3,
                    pointBackgroundColor: '#0ab39c',
                    tension: 0.4,
                    fill: true,
                    yAxisID: 'yDonations',
                }
            ]
        },
        options: {
            responsive: true,
            interaction: { mode: 'index', intersect: false },
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { maxTicksLimit: 6 } },
                yPeople: {
                    type: 'linear', position: 'left',
                    grid: { color: 'rgba(0,0,0,0.04)' },
                    ticks: { stepSize: 1 },
                    title: { display: true, text: contactsAxis, color: '#405189', font: { size: 10 } }
                },
                yDonations: {
                    type: 'linear', position: 'right',
                    grid: { drawOnChartArea: false },
                    ticks: { callback: v => v.toLocaleString('hu-HU') + ' Ft' },
                    title: { display: true, text: donationsAxis, color: '#0ab39c', font: { size: 10 } }
                }
            }
        }
    });
}

if (document.getElementById('statusChart')) {
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: statusNames,
            datasets: [{
                data: statusData,
                backgroundColor: statusColors.slice(0, statusData.length),
                borderWidth: 2,
                borderColor: '#fff',
                hoverOffset: 6,
            }]
        },
        options: {
            responsive: true,
            cutout: '65%',
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: ctx => ' ' + ctx.label + ': ' + ctx.parsed + (personUnit ? ' ' + personUnit : '') } }
            }
        }
    });

    const legend = document.getElementById('statusLegend');
    const total  = statusData.reduce((a, b) => a + b, 0);
    statusNames.forEach((name, i) => {
        const pct = total ? Math.round(statusData[i] / total * 100) : 0;
        legend.innerHTML += `
            <div style="display:flex;align-items:center;justify-content:space-between;font-size:0.75rem;margin-bottom:4px">
                <span style="display:flex;align-items:center;gap:6px">
                    <span style="width:10px;height:10px;border-radius:50%;background:${statusColors[i]};flex-shrink:0"></span>
                    ${name}
                </span>
                <span style="color:#343a40;font-weight:600">${statusData[i]}${personUnit ? ' ' + personUnit : ''} <span style="color:#adb5bd;font-weight:400">(${pct}%)</span></span>
            </div>`;
    });
}

if (document.getElementById('donationChart')) {
    new Chart(document.getElementById('donationChart'), {
        type: 'bar',
        data: {
            labels: monthLabels,
            datasets: [{
                label: donationsLabel,
                data: monthlyDonations,
                backgroundColor: 'rgba(247,184,75,0.75)',
                borderColor: '#f7b84b',
                borderWidth: 1.5,
                borderRadius: 5,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: ctx => ' ' + ctx.parsed.y.toLocaleString('hu-HU') + ' Ft' } }
            },
            scales: {
                x: { grid: { display: false } },
                y: {
                    grid: { color: 'rgba(0,0,0,0.04)' },
                    ticks: { callback: v => v.toLocaleString('hu-HU') + ' Ft' }
                }
            }
        }
    });
}

// ── Customizer ──────────────────────────────────────────────────
function openCustomizer() {
    document.getElementById('customizerOverlay').classList.remove('hidden');
    document.getElementById('customizerPanel').style.transform = 'translateX(0)';
}

function closeCustomizer() {
    document.getElementById('customizerOverlay').classList.add('hidden');
    document.getElementById('customizerPanel').style.transform = 'translateX(100%)';
}

Sortable.create(document.getElementById('customizerList'), {
    animation: 150,
    handle: '.drag-handle',
    ghostClass: 'bg-indigo-50',
});

function saveWidgets() {
    const btn = document.getElementById('saveWidgetsBtn');
    btn.disabled = true;
    btn.style.opacity = '0.7';

    const items = [...document.querySelectorAll('#customizerList [data-id]')];
    const widgets = items.map((el, i) => ({
        id:      el.dataset.id,
        visible: el.querySelector('input[type=checkbox]').checked,
        order:   i + 1,
    }));

    fetch('{{ route("admin.dashboard.widgets") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({ widgets }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.ok) {
            document.getElementById('customizerSaved').classList.remove('hidden');
            setTimeout(() => location.reload(), 800);
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.style.opacity = '1';
    });
}
</script>
@endpush

@endsection
