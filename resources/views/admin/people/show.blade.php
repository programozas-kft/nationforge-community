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

        {{-- ── LEAD SCORING CARD ────────────────────────── --}}
        @php
        $leadStages = [
            'new'       => ['label' => 'Új érdeklődő',     'color' => '#6c757d', 'icon' => 'M12 4v16m8-8H4'],
            'contacted' => ['label' => 'Kapcsolatba lépve', 'color' => '#299cdb', 'icon' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z'],
            'qualified' => ['label' => 'Minősített',        'color' => '#7a5af8', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
            'proposal'  => ['label' => 'Ajánlat küldve',   'color' => '#f7b84b', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
            'converted' => ['label' => 'Megnyert',          'color' => '#0ab39c', 'icon' => 'M5 13l4 4L19 7'],
            'lost'      => ['label' => 'Elveszett',         'color' => '#f06548', 'icon' => 'M6 18L18 6M6 6l12 12'],
        ];
        $currentStage = $person->lead_stage;
        $currentScore = $person->lead_score;
        @endphp

        <div class="nf-card">
            <div class="nf-card-header">Kapcsolatfelvétel / Értékelés</div>

            <form method="POST" action="{{ route('admin.people.lead.update', $person) }}" style="padding:20px 24px">
                @csrf @method('PATCH')

                {{-- Pipeline stages --}}
                <div style="margin-bottom:18px">
                    <label style="font-size:0.72rem;font-weight:600;color:#6c757d;text-transform:uppercase;letter-spacing:0.05em;display:block;margin-bottom:10px">Értékesítési fázis</label>
                    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:6px" id="stageGrid">
                        @foreach($leadStages as $val => $stage)
                        @php $active = $currentStage === $val; @endphp
                        <label style="cursor:pointer">
                            <input type="radio" name="lead_stage" value="{{ $val }}" {{ $active ? 'checked' : '' }}
                                   style="display:none" class="stage-radio">
                            <div class="stage-chip" data-val="{{ $val }}" data-color="{{ $stage['color'] }}"
                                 style="border:1.5px solid {{ $active ? $stage['color'] : '#e9ebec' }};
                                        background:{{ $active ? 'rgba('.implode(',', sscanf($stage['color'],'#%02x%02x%02x')).', 0.1)' : '#fff' }};
                                        border-radius:8px;padding:8px 6px;text-align:center;transition:all .15s">
                                <svg width="16" height="16" fill="none" stroke="{{ $active ? $stage['color'] : '#adb5bd' }}"
                                     viewBox="0 0 24 24" style="display:block;margin:0 auto 4px">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stage['icon'] }}"/>
                                </svg>
                                <span style="font-size:0.68rem;font-weight:{{ $active ? '700' : '500' }};color:{{ $active ? $stage['color'] : '#6c757d' }};line-height:1.2;display:block">
                                    {{ $stage['label'] }}
                                </span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Star score --}}
                <div style="margin-bottom:18px">
                    <label style="font-size:0.72rem;font-weight:600;color:#6c757d;text-transform:uppercase;letter-spacing:0.05em;display:block;margin-bottom:8px">Pontszám (érdeklődési szint)</label>
                    <div style="display:flex;gap:6px;align-items:center" id="starRow">
                        @for($i = 1; $i <= 5; $i++)
                        <button type="button" class="star-btn" data-val="{{ $i }}"
                                style="background:none;border:none;cursor:pointer;padding:2px;line-height:1">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="{{ $currentScore >= $i ? '#f7b84b' : 'none' }}"
                                 stroke="{{ $currentScore >= $i ? '#f7b84b' : '#ced4da' }}" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                        </button>
                        @endfor
                        <input type="hidden" name="lead_score" id="scoreInput" value="{{ $currentScore }}">
                        <span id="scoreLabel" style="font-size:0.8rem;color:#adb5bd;margin-left:4px">
                            @if($currentScore)
                                {{ $currentScore }}/5 — @switch($currentScore)
                                    @case(1) Hideg @break
                                    @case(2) Langyos @break
                                    @case(3) Érdeklődő @break
                                    @case(4) Forró @break
                                    @case(5) Nagyon forró @break
                                @endswitch
                            @else
                                Nincs értékelve
                            @endif
                        </span>
                    </div>
                </div>

                <div style="display:flex;gap:8px">
                    <button type="submit" class="btn-primary" style="font-size:0.82rem;padding:8px 18px">
                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:inline;vertical-align:middle;margin-right:4px"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Mentés
                    </button>
                    @if($currentStage || $currentScore)
                    <button type="button" onclick="clearLead()" class="btn-secondary" style="font-size:0.82rem;padding:8px 14px">Törlés</button>
                    @endif
                </div>
            </form>
        </div>

    </div>

    <div class="lg:col-span-2 space-y-5">

        {{-- ── ACTIVITY LOG ──────────────────────────────── --}}
        @php
        $activityMeta = [
            'call'    => ['label'=>'Telefonhívás',  'color'=>'#0ab39c', 'bg'=>'rgba(10,179,156,0.12)',
                          'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>'],
            'email'   => ['label'=>'Email',          'color'=>'#405189', 'bg'=>'rgba(64,81,137,0.12)',
                          'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>'],
            'meeting' => ['label'=>'Megbeszélés',    'color'=>'#7a5af8', 'bg'=>'rgba(122,90,248,0.12)',
                          'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>'],
            'note'    => ['label'=>'Feljegyzés',     'color'=>'#f7b84b', 'bg'=>'rgba(247,184,75,0.12)',
                          'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>'],
            'task'    => ['label'=>'Feladat',        'color'=>'#299cdb', 'bg'=>'rgba(41,156,219,0.12)',
                          'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>'],
            'sms'     => ['label'=>'SMS',            'color'=>'#f06548', 'bg'=>'rgba(240,101,72,0.12)',
                          'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>'],
            'other'   => ['label'=>'Egyéb',          'color'=>'#6c757d', 'bg'=>'rgba(108,117,125,0.12)',
                          'icon'=>'<circle cx="12" cy="12" r="4"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v2m0 16v2m10-10h-2M4 12H2"/>'],
        ];
        @endphp

        <div class="nf-card">
            <div class="nf-card-header" style="justify-content:space-between">
                <span>Aktivitás napló</span>
                <span style="font-size:0.75rem;font-weight:400;color:#adb5bd">{{ $activities->count() }} bejegyzés</span>
            </div>

            {{-- Add activity form --}}
            <form method="POST" action="{{ route('admin.people.activities.store', $person) }}"
                  style="padding:16px;border-bottom:1px solid #e9ebec;background:#fafbff;display:grid;grid-template-columns:auto 1fr auto;gap:10px;align-items:end">
                @csrf
                <div>
                    <label style="font-size:0.72rem;font-weight:600;color:#6c757d;text-transform:uppercase;letter-spacing:0.05em;display:block;margin-bottom:5px">Típus</label>
                    <select name="type" class="nf-select" style="font-size:0.8rem;min-width:140px">
                        @foreach($activityMeta as $val => $meta)
                        <option value="{{ $val }}">{{ $meta['label'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="font-size:0.72rem;font-weight:600;color:#6c757d;text-transform:uppercase;letter-spacing:0.05em;display:block;margin-bottom:5px">Megjegyzés</label>
                    <input type="text" name="notes" class="nf-input" style="font-size:0.8rem" placeholder="Mit tettél, mi hangzott el…">
                </div>
                <div style="display:flex;gap:8px;align-items:end">
                    <div>
                        <label style="font-size:0.72rem;font-weight:600;color:#6c757d;text-transform:uppercase;letter-spacing:0.05em;display:block;margin-bottom:5px">Időpont</label>
                        <input type="datetime-local" name="occurred_at" class="nf-input" style="font-size:0.8rem"
                               value="{{ now()->format('Y-m-d\TH:i') }}">
                    </div>
                    <button type="submit" class="btn-primary" style="padding:8px 16px;white-space:nowrap">
                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Rögzítés
                    </button>
                </div>
            </form>

            {{-- Timeline --}}
            @if($activities->isEmpty())
            <div style="padding:40px;text-align:center;color:#adb5bd;font-size:0.875rem">
                Még nincs aktivitás bejegyezve ennél a kapcsolatnál.
            </div>
            @else
            <div style="padding:20px 20px 8px;position:relative">
                {{-- Vertical line --}}
                <div style="position:absolute;left:44px;top:20px;bottom:20px;width:2px;background:#f0f0f5"></div>

                @foreach($activities as $act)
                @php $m = $activityMeta[$act->type] ?? $activityMeta['other']; @endphp
                <div style="display:flex;gap:16px;margin-bottom:20px;position:relative">
                    {{-- Icon dot --}}
                    <div style="width:32px;height:32px;border-radius:50%;background:{{ $m['bg'] }};border:2px solid {{ $m['color'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0;z-index:1">
                        <svg width="14" height="14" fill="none" stroke="{{ $m['color'] }}" viewBox="0 0 24 24">{!! $m['icon'] !!}</svg>
                    </div>

                    {{-- Content --}}
                    <div style="flex:1;background:#fff;border:1px solid #e9ebec;border-radius:8px;padding:12px 14px;min-width:0">
                        <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;flex-wrap:wrap;margin-bottom:{{ $act->notes ? '6px' : '0' }}">
                            <div style="display:flex;align-items:center;gap:8px">
                                <span style="font-size:0.8rem;font-weight:600;color:{{ $m['color'] }}">{{ $m['label'] }}</span>
                                <span style="font-size:0.75rem;color:#adb5bd">
                                    {{ $act->occurred_at->format('Y. m. d. H:i') }}
                                </span>
                                @if($act->user)
                                <span style="font-size:0.72rem;color:#ced4da">· {{ $act->user->name }}</span>
                                @endif
                            </div>
                            <form method="POST" action="{{ route('admin.people.activities.destroy', [$person, $act]) }}"
                                  style="display:inline" onsubmit="return confirm('Törlöd ezt a bejegyzést?')">
                                @csrf @method('DELETE')
                                <button type="submit" style="background:none;border:none;color:#ced4da;cursor:pointer;padding:0;line-height:1;transition:color 0.15s"
                                        onmouseover="this.style.color='#f06548'" onmouseout="this.style.color='#ced4da'">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                        @if($act->notes)
                        <p style="font-size:0.8125rem;color:#495057;margin:0;line-height:1.5">{{ $act->notes }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- ── DONATIONS ──────────────────────────────────── --}}
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

@push('scripts')
<script>
(function () {
    // ── Stage chips ────────────────────────────────────────────
    document.querySelectorAll('.stage-radio').forEach(function (radio) {
        radio.addEventListener('change', function () {
            document.querySelectorAll('.stage-chip').forEach(function (chip) {
                const val   = chip.dataset.val;
                const color = chip.dataset.color;
                const isActive = val === radio.value;
                chip.style.borderColor  = isActive ? color : '#e9ebec';
                chip.style.background   = isActive ? hexToRgba(color, 0.1) : '#fff';
                chip.querySelector('svg').setAttribute('stroke', isActive ? color : '#adb5bd');
                chip.querySelector('span').style.color      = isActive ? color : '#6c757d';
                chip.querySelector('span').style.fontWeight = isActive ? '700' : '500';
            });
        });
    });

    function hexToRgba(hex, a) {
        var r = parseInt(hex.slice(1,3),16);
        var g = parseInt(hex.slice(3,5),16);
        var b = parseInt(hex.slice(5,7),16);
        return 'rgba('+r+','+g+','+b+','+a+')';
    }

    // ── Star rating ────────────────────────────────────────────
    var scoreLabels = ['', 'Hideg', 'Langyos', 'Érdeklődő', 'Forró', 'Nagyon forró'];
    var stars       = document.querySelectorAll('.star-btn');
    var scoreInput  = document.getElementById('scoreInput');
    var scoreLabel  = document.getElementById('scoreLabel');
    var currentScore = parseInt(scoreInput.value) || 0;

    function paintStars(n, hovered) {
        stars.forEach(function (btn, idx) {
            var filled = idx < n;
            var svg    = btn.querySelector('svg');
            var color  = filled ? '#f7b84b' : '#ced4da';
            svg.setAttribute('fill',   filled ? '#f7b84b' : 'none');
            svg.setAttribute('stroke', color);
        });
        if (!hovered) {
            scoreLabel.textContent = n ? n + '/5 — ' + scoreLabels[n] : 'Nincs értékelve';
        }
    }

    stars.forEach(function (btn) {
        btn.addEventListener('mouseenter', function () {
            paintStars(parseInt(btn.dataset.val), true);
        });
        btn.addEventListener('mouseleave', function () {
            paintStars(currentScore, false);
        });
        btn.addEventListener('click', function () {
            var val = parseInt(btn.dataset.val);
            // clicking same star again clears the score
            currentScore = (currentScore === val) ? 0 : val;
            scoreInput.value = currentScore || '';
            paintStars(currentScore, false);
        });
    });

    // ── Clear button ───────────────────────────────────────────
    window.clearLead = function () {
        // uncheck all stage radios
        document.querySelectorAll('.stage-radio').forEach(function (r) { r.checked = false; });
        document.querySelectorAll('.stage-chip').forEach(function (chip) {
            chip.style.borderColor = '#e9ebec';
            chip.style.background  = '#fff';
            chip.querySelector('svg').setAttribute('stroke', '#adb5bd');
            chip.querySelector('span').style.color      = '#6c757d';
            chip.querySelector('span').style.fontWeight = '500';
        });
        currentScore = 0;
        scoreInput.value = '';
        paintStars(0, false);

        // add hidden inputs to send null values
        var form = document.querySelector('form[action*="lead"]');
        ['lead_stage','lead_score'].forEach(function (name) {
            var existing = form.querySelector('input[name="'+name+'"][type="hidden"][data-clear]');
            if (!existing) {
                var h = document.createElement('input');
                h.type = 'hidden'; h.name = name; h.value = ''; h.dataset.clear = '1';
                form.appendChild(h);
            }
        });
        form.submit();
    };
})();
</script>
@endpush
