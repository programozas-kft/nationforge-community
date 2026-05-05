@extends('admin.layouts.app')

@section('title', 'Főoldal')
@section('header', 'Főoldal')

@section('header-actions')
    <a href="{{ route('admin.sugo') }}" target="_blank"
        style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:6px;border:1.5px solid #dee2e6;background:#fff;color:#495057;font-size:0.8rem;font-weight:500;cursor:pointer;text-decoration:none">
        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        Súgó
    </a>
@endsection

@section('content')

<!-- Stat Cards -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-6">

    <div class="nf-card p-5 flex items-center gap-4">
        <div class="stat-icon flex-shrink-0" style="background:rgba(64,81,137,0.12)">
            <svg class="w-6 h-6" style="color:#405189" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['people']) }}</p>
            <p class="text-xs text-gray-500 mt-0.5">Összes kapcsolat</p>
            <p class="text-xs mt-1" style="color:#0ab39c">+{{ $stats['new_people'] }} ez hónapban</p>
        </div>
    </div>

    <div class="nf-card p-5 flex items-center gap-4">
        <div class="stat-icon flex-shrink-0" style="background:rgba(10,179,156,0.12)">
            <svg class="w-6 h-6" style="color:#0ab39c" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['events'] }}</p>
            <p class="text-xs text-gray-500 mt-0.5">Közelgő esemény</p>
        </div>
    </div>

    <div class="nf-card p-5 flex items-center gap-4">
        <div class="stat-icon flex-shrink-0" style="background:rgba(247,184,75,0.12)">
            <svg class="w-6 h-6" style="color:#f7b84b" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['donations'], 0, ',', ' ') }}</p>
            <p class="text-xs text-gray-500 mt-0.5">Összes adomány (Ft)</p>
        </div>
    </div>

    <div class="nf-card p-5 flex items-center gap-4">
        <div class="stat-icon flex-shrink-0" style="background:rgba(122,90,248,0.12)">
            <svg class="w-6 h-6" style="color:#7a5af8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['subscribed']) }}</p>
            <p class="text-xs text-gray-500 mt-0.5">Hírlevél feliratkozó</p>
        </div>
    </div>
</div>

<!-- Oszlopdiagram: havi adományok (teljes sor) -->
<div class="nf-card p-5 mb-6">
    <div class="flex items-center justify-between mb-4">
        <div>
            <p class="text-sm font-semibold text-gray-800">Havi adományok</p>
            <p class="text-xs text-gray-400">Utolsó 12 hónap (Ft)</p>
        </div>
    </div>
    <canvas id="donationChart" height="60"></canvas>
</div>

<!-- Two columns -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

    <!-- Recent people -->
    <div class="nf-card">
        <div class="nf-card-header flex items-center justify-between">
            <span>Legújabb kapcsolatok</span>
            <a href="{{ route('admin.people.index') }}" class="text-xs font-normal" style="color:#405189">Összes megtekintése →</a>
        </div>
        <div class="divide-y" style="border-color:#f3f3f9">
            @forelse($recent_people as $person)
            <div class="px-5 py-3 flex items-center gap-3" style="padding-left:20px; padding-right:20px;">
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
                @php
                    $sc = ['member'=>'badge-primary','supporter'=>'badge-success','donor'=>'badge-warning','vip'=>'badge-purple','inactive'=>'badge-secondary','prospect'=>'badge-info','volunteer'=>'badge-success'];
                    $sl = ['member'=>'Tag','supporter'=>'Támogató','donor'=>'Adományozó','vip'=>'VIP','inactive'=>'Inaktív','prospect'=>'Érdeklődő','volunteer'=>'Önkéntes'];
                @endphp
                <span class="nf-badge {{ $sc[$person->status] ?? 'badge-secondary' }}" style="white-space:nowrap;flex-shrink:0">{{ $sl[$person->status] ?? $person->status }}</span>
            </div>
            @empty
            <div class="px-5 py-6 text-center text-sm text-gray-400">Nincs kapcsolat.</div>
            @endforelse
        </div>
    </div>

    <!-- Upcoming events -->
    <div class="nf-card">
        <div class="nf-card-header flex items-center justify-between">
            <span>Közelgő események</span>
            <a href="{{ route('admin.events.index') }}" class="text-xs font-normal" style="color:#405189">Összes megtekintése →</a>
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
                    <p class="text-xs text-gray-400">{{ $event->starts_at->format('H:i') }} · {{ $event->city ?? ($event->is_online ? 'Online' : '—') }}</p>
                </div>
                <span class="nf-badge badge-info">{{ $event->type }}</span>
            </div>
            @empty
            <div style="padding:24px 20px;text-align:center;font-size:0.875rem;color:#adb5bd">Nincs közelgő esemény.</div>
            @endforelse
        </div>
    </div>
</div>

<!-- Charts row: kapcsolatok növekedése + megoszlás (legalul) -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mt-6">

    <!-- Vonaldiagram: kapcsolatok növekedése (2/3) -->
    <div class="nf-card p-5 lg:col-span-2">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-sm font-semibold text-gray-800">Kapcsolatok növekedése</p>
                <p class="text-xs text-gray-400">Utolsó 12 hónap</p>
            </div>
            <div class="flex items-center gap-4 text-xs text-gray-500">
                <span class="flex items-center gap-1"><span style="display:inline-block;width:12px;height:3px;background:#405189;border-radius:2px"></span> Kapcsolatok</span>
                <span class="flex items-center gap-1"><span style="display:inline-block;width:12px;height:3px;background:#0ab39c;border-radius:2px"></span> Adományok (Ft)</span>
            </div>
        </div>
        <canvas id="growthChart" height="100"></canvas>
    </div>

    <!-- Kördiagram: státusz megoszlás (1/3) -->
    <div class="nf-card p-5">
        <div class="mb-4">
            <p class="text-sm font-semibold text-gray-800">Kapcsolatok megoszlása</p>
            <p class="text-xs text-gray-400">Státusz szerint</p>
        </div>
        <canvas id="statusChart" height="200"></canvas>
        <div id="statusLegend" class="mt-4 space-y-1"></div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const monthLabels      = @json($monthLabels);
const monthlyPeople    = @json($monthlyPeople);
const monthlyDonations = @json($monthlyDonations);
const statusNames      = @json($statusNames);
const statusData       = @json($statusData);

const statusColors = ['#405189','#0ab39c','#f7b84b','#7a5af8','#f06548','#299cdb','#adb5bd'];

Chart.defaults.font.family = "'Inter', sans-serif";
Chart.defaults.font.size   = 11;
Chart.defaults.color       = '#6c757d';

// 1. Vonaldiagram – kapcsolatok + adományok
new Chart(document.getElementById('growthChart'), {
    type: 'line',
    data: {
        labels: monthLabels,
        datasets: [
            {
                label: 'Kapcsolatok',
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
                label: 'Adományok (Ft)',
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
                title: { display: true, text: 'Kapcsolatok (fő)', color: '#405189', font: { size: 10 } }
            },
            yDonations: {
                type: 'linear', position: 'right',
                grid: { drawOnChartArea: false },
                ticks: { callback: v => v.toLocaleString('hu-HU') + ' Ft' },
                title: { display: true, text: 'Adományok (Ft)', color: '#0ab39c', font: { size: 10 } }
            }
        }
    }
});

// 2. Kördiagram – státusz megoszlás
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
            tooltip: { callbacks: { label: ctx => ' ' + ctx.label + ': ' + ctx.parsed + ' fő' } }
        }
    }
});

// Egyedi legenda a kördiagramhoz
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
            <span style="color:#343a40;font-weight:600">${statusData[i]} fő <span style="color:#adb5bd;font-weight:400">(${pct}%)</span></span>
        </div>`;
});

// 3. Oszlopdiagram – havi adományok
new Chart(document.getElementById('donationChart'), {
    type: 'bar',
    data: {
        labels: monthLabels,
        datasets: [{
            label: 'Adományok (Ft)',
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
</script>
@endpush

@endsection
