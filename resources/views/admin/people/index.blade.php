@extends('admin.layouts.app')

@section('title', __('people.title'))
@section('header', __('people.title'))
@section('breadcrumb') <span style="color:#495057">{{ __('people.title') }}</span> @endsection

@section('header-actions')
    {{-- Export dropdown --}}
    <div style="position:relative;display:inline-block" id="export-wrap">
        <button onclick="toggleExportMenu()" class="btn-ghost">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Export
            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
        </button>
        <div id="export-menu" style="display:none;position:absolute;right:0;top:calc(100% + 4px);background:#fff;border:1px solid #e9ebec;border-radius:6px;box-shadow:0 4px 16px rgba(0,0,0,0.1);min-width:150px;z-index:100">
            <a href="{{ route('admin.people.export', ['format'=>'csv']) }}"
               style="display:flex;align-items:center;gap:8px;padding:9px 14px;font-size:0.8125rem;color:#495057;text-decoration:none"
               onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background=''">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                CSV letöltés
            </a>
            <a href="{{ route('admin.people.export', ['format'=>'xlsx']) }}"
               style="display:flex;align-items:center;gap:8px;padding:9px 14px;font-size:0.8125rem;color:#495057;text-decoration:none;border-top:1px solid #f3f3f9"
               onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background=''">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                Excel letöltés
            </a>
        </div>
    </div>
    <a href="{{ route('admin.people.duplicates') }}" class="btn-ghost">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
        Duplikátumok
    </a>
    <button onclick="openModal('modal-import')" class="btn-ghost">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
        Import
    </button>
    <a href="#" class="btn-primary" onclick="openModal('modal-create');return false;">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        {{ __('people.new') }}
    </a>
@endsection

@section('content')

{{-- ── FILTER PANEL ──────────────────────────────────── --}}
@php
    $hasFilter = collect($filters)->filter(fn($v) => $v !== null && $v !== '' && $v !== [])->isNotEmpty();
    $statusLabels = ['prospect'=>__('people.status.prospect'),'supporter'=>__('people.status.supporter'),'member'=>__('people.status.member'),'volunteer'=>__('people.status.volunteer'),'donor'=>__('people.status.donor'),'vip'=>__('people.status.vip'),'inactive'=>__('people.status.inactive')];
@endphp

<form id="filter-form" method="GET" action="{{ route('admin.people.index') }}">
<div class="nf-card" style="margin-bottom:16px">
    {{-- Header row --}}
    <div style="padding:12px 16px;display:flex;align-items:center;gap:10px;border-bottom:1px solid #e9ebec;flex-wrap:wrap">
        <button type="button" onclick="toggleFilterPanel()" id="filter-toggle-btn"
            style="display:inline-flex;align-items:center;gap:6px;padding:5px 12px;border:1px solid #ced4da;border-radius:5px;background:#fff;font-size:0.8rem;font-weight:500;color:#495057;cursor:pointer">
            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/></svg>
            Szűrők
            <svg id="filter-chevron" width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition:transform 0.2s"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
        </button>

        {{-- Saved filters dropdown --}}
        @if($savedFilters->isNotEmpty())
        <div style="position:relative" id="saved-wrap">
            <button type="button" onclick="toggleSavedMenu()"
                style="display:inline-flex;align-items:center;gap:6px;padding:5px 12px;border:1px solid #ced4da;border-radius:5px;background:#fff;font-size:0.8rem;font-weight:500;color:#405189;cursor:pointer">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                Mentett szűrők
                <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div id="saved-menu" style="display:none;position:absolute;left:0;top:calc(100% + 4px);background:#fff;border:1px solid #e9ebec;border-radius:6px;box-shadow:0 4px 16px rgba(0,0,0,0.1);min-width:200px;z-index:200;max-height:280px;overflow-y:auto">
                @foreach($savedFilters as $sf)
                <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 12px;border-bottom:1px solid #f3f3f9"
                     onmouseover="this.style.background='#f8f9ff'" onmouseout="this.style.background=''">
                    <button type="button" onclick="applySavedFilter({{ json_encode($sf->filters) }})"
                        style="background:none;border:none;padding:0;font-size:0.8125rem;color:#343a40;cursor:pointer;text-align:left;flex:1">
                        {{ $sf->name }}
                    </button>
                    <form method="POST" action="{{ route('admin.people.filters.destroy', $sf) }}" style="display:inline" onsubmit="return confirm('Törlöd ezt a szűrőt?')">
                        @csrf @method('DELETE')
                        <button type="submit" style="background:none;border:none;color:#f06548;cursor:pointer;padding:0 0 0 8px">
                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Active filter chips --}}
        @if($hasFilter)
        <div style="display:flex;align-items:center;gap:6px;flex-wrap:wrap;flex:1">
            @if(!empty($filters['q']))
                <span class="filter-chip">Keresés: {{ $filters['q'] }} <a href="{{ request()->fullUrlWithoutQuery(['q','page']) }}" style="color:inherit;text-decoration:none;margin-left:4px">×</a></span>
            @endif
            @foreach((array)($filters['status'] ?? []) as $st)
                <span class="filter-chip">{{ $statusLabels[$st] ?? $st }} <a href="{{ request()->fullUrlWithoutQuery(['status','page']) }}" style="color:inherit;text-decoration:none;margin-left:4px">×</a></span>
            @endforeach
            @if(!empty($filters['city']))
                <span class="filter-chip">Város: {{ $filters['city'] }} <a href="{{ request()->fullUrlWithoutQuery(['city','page']) }}" style="color:inherit;text-decoration:none;margin-left:4px">×</a></span>
            @endif
            @if(!empty($filters['source']))
                <span class="filter-chip">Forrás: {{ $filters['source'] }} <a href="{{ request()->fullUrlWithoutQuery(['source','page']) }}" style="color:inherit;text-decoration:none;margin-left:4px">×</a></span>
            @endif
            @if(isset($filters['subscribed']) && $filters['subscribed'] !== '')
                <span class="filter-chip">Hírlevél: {{ $filters['subscribed'] ? 'Igen' : 'Nem' }} <a href="{{ request()->fullUrlWithoutQuery(['subscribed','page']) }}" style="color:inherit;text-decoration:none;margin-left:4px">×</a></span>
            @endif
            @if(!empty($filters['group_id']))
                @php $gName = $groups->firstWhere('id', $filters['group_id'])?->name ?? $filters['group_id']; @endphp
                <span class="filter-chip">Csoport: {{ $gName }} <a href="{{ request()->fullUrlWithoutQuery(['group_id','page']) }}" style="color:inherit;text-decoration:none;margin-left:4px">×</a></span>
            @endif
            @if(!empty($filters['date_from']))
                <span class="filter-chip">Tól: {{ $filters['date_from'] }} <a href="{{ request()->fullUrlWithoutQuery(['date_from','page']) }}" style="color:inherit;text-decoration:none;margin-left:4px">×</a></span>
            @endif
            @if(!empty($filters['date_to']))
                <span class="filter-chip">Ig: {{ $filters['date_to'] }} <a href="{{ request()->fullUrlWithoutQuery(['date_to','page']) }}" style="color:inherit;text-decoration:none;margin-left:4px">×</a></span>
            @endif
            @if(!empty($filters['lead_stage']))
                @php $lsLabels = ['new'=>'Új érdeklődő','contacted'=>'Kapcsolatba lépve','qualified'=>'Minősített','proposal'=>'Ajánlat küldve','converted'=>'Megnyert','lost'=>'Elveszett']; @endphp
                <span class="filter-chip">Fázis: {{ $lsLabels[$filters['lead_stage']] ?? $filters['lead_stage'] }} <a href="{{ request()->fullUrlWithoutQuery(['lead_stage','page']) }}" style="color:inherit;text-decoration:none;margin-left:4px">×</a></span>
            @endif
            @if(!empty($filters['lead_score_min']))
                <span class="filter-chip">Min. pont: {{ $filters['lead_score_min'] }}★ <a href="{{ request()->fullUrlWithoutQuery(['lead_score_min','page']) }}" style="color:inherit;text-decoration:none;margin-left:4px">×</a></span>
            @endif
        </div>
        <a href="{{ route('admin.people.index') }}" style="margin-left:auto;font-size:0.78rem;color:#f06548;text-decoration:none;white-space:nowrap">× Szűrők törlése</a>
        @endif

        {{-- Total count --}}
        <span style="margin-left:auto;font-size:0.78rem;color:#adb5bd;white-space:nowrap">{{ $people->total() }} kapcsolat</span>
    </div>

    {{-- Collapsible filter fields --}}
    <div id="filter-panel" style="display:{{ $hasFilter ? 'block' : 'none' }}">
        <div style="padding:16px;display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px">

            {{-- Search --}}
            <div style="grid-column:span 3">
                <label style="font-size:0.75rem;font-weight:600;color:#6c757d;letter-spacing:0.05em;text-transform:uppercase;display:block;margin-bottom:6px">Keresés</label>
                <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" class="nf-input"
                       placeholder="Név, email, telefon…" style="font-size:0.8125rem">
            </div>

            {{-- Status chips --}}
            <div style="grid-column:span 3">
                <label style="font-size:0.75rem;font-weight:600;color:#6c757d;letter-spacing:0.05em;text-transform:uppercase;display:block;margin-bottom:8px">Státusz</label>
                <div style="display:flex;flex-wrap:wrap;gap:6px">
                    @foreach(['prospect','supporter','member','volunteer','donor','vip','inactive'] as $st)
                    <label style="display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border:1.5px solid #dee2e6;border-radius:20px;cursor:pointer;font-size:0.78rem;font-weight:500;color:#6c757d;background:#fff;transition:all 0.15s"
                           id="sc-{{ $st }}">
                        <input type="checkbox" name="status[]" value="{{ $st }}"
                               {{ in_array($st, (array)($filters['status'] ?? [])) ? 'checked' : '' }}
                               style="display:none"
                               onchange="updateStatusChip('{{ $st }}',this.checked)">
                        {{ $statusLabels[$st] }}
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- City --}}
            <div>
                <label style="font-size:0.75rem;font-weight:600;color:#6c757d;letter-spacing:0.05em;text-transform:uppercase;display:block;margin-bottom:6px">Város</label>
                <input type="text" name="city" value="{{ $filters['city'] ?? '' }}" class="nf-input" placeholder="pl. Budapest" style="font-size:0.8125rem">
            </div>

            {{-- Source --}}
            <div>
                <label style="font-size:0.75rem;font-weight:600;color:#6c757d;letter-spacing:0.05em;text-transform:uppercase;display:block;margin-bottom:6px">Forrás</label>
                <input type="text" name="source" value="{{ $filters['source'] ?? '' }}" class="nf-input" placeholder="pl. facebook" style="font-size:0.8125rem">
            </div>

            {{-- Subscribed --}}
            <div>
                <label style="font-size:0.75rem;font-weight:600;color:#6c757d;letter-spacing:0.05em;text-transform:uppercase;display:block;margin-bottom:8px">Hírlevél</label>
                <div style="display:flex;gap:8px">
                    @foreach(['' => 'Mind', '1' => 'Igen', '0' => 'Nem'] as $val => $label)
                    <label style="display:inline-flex;align-items:center;gap:5px;font-size:0.8rem;cursor:pointer;color:#495057">
                        <input type="radio" name="subscribed" value="{{ $val }}"
                               {{ ($filters['subscribed'] ?? '') === (string)$val ? 'checked' : '' }}
                               style="accent-color:#405189">
                        {{ $label }}
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Group --}}
            <div>
                <label style="font-size:0.75rem;font-weight:600;color:#6c757d;letter-spacing:0.05em;text-transform:uppercase;display:block;margin-bottom:6px">Csoport</label>
                <select name="group_id" class="nf-select" style="font-size:0.8125rem">
                    <option value="">— Összes —</option>
                    @foreach($groups as $g)
                    <option value="{{ $g->id }}" {{ ($filters['group_id'] ?? '') == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Date from --}}
            <div>
                <label style="font-size:0.75rem;font-weight:600;color:#6c757d;letter-spacing:0.05em;text-transform:uppercase;display:block;margin-bottom:6px">Regisztrálva (tól)</label>
                <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}" class="nf-input" style="font-size:0.8125rem">
            </div>

            {{-- Date to --}}
            <div>
                <label style="font-size:0.75rem;font-weight:600;color:#6c757d;letter-spacing:0.05em;text-transform:uppercase;display:block;margin-bottom:6px">Regisztrálva (ig)</label>
                <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}" class="nf-input" style="font-size:0.8125rem">
            </div>

            {{-- Lead stage filter --}}
            <div>
                <label style="font-size:0.75rem;font-weight:600;color:#6c757d;letter-spacing:0.05em;text-transform:uppercase;display:block;margin-bottom:6px">Fázis</label>
                <select name="lead_stage" class="nf-select" style="font-size:0.8125rem">
                    <option value="">Mind</option>
                    <option value="new"       {{ ($filters['lead_stage'] ?? '') === 'new'       ? 'selected' : '' }}>Új érdeklődő</option>
                    <option value="contacted" {{ ($filters['lead_stage'] ?? '') === 'contacted' ? 'selected' : '' }}>Kapcsolatba lépve</option>
                    <option value="qualified" {{ ($filters['lead_stage'] ?? '') === 'qualified' ? 'selected' : '' }}>Minősített</option>
                    <option value="proposal"  {{ ($filters['lead_stage'] ?? '') === 'proposal'  ? 'selected' : '' }}>Ajánlat küldve</option>
                    <option value="converted" {{ ($filters['lead_stage'] ?? '') === 'converted' ? 'selected' : '' }}>Megnyert</option>
                    <option value="lost"      {{ ($filters['lead_stage'] ?? '') === 'lost'      ? 'selected' : '' }}>Elveszett</option>
                </select>
            </div>

            {{-- Lead score min filter --}}
            <div>
                <label style="font-size:0.75rem;font-weight:600;color:#6c757d;letter-spacing:0.05em;text-transform:uppercase;display:block;margin-bottom:6px">Min. pontszám</label>
                <select name="lead_score_min" class="nf-select" style="font-size:0.8125rem">
                    <option value="">Mind</option>
                    @foreach([1,2,3,4,5] as $s)
                    <option value="{{ $s }}" {{ ($filters['lead_score_min'] ?? '') == $s ? 'selected' : '' }}>{{ $s }}★ vagy több</option>
                    @endforeach
                </select>
            </div>

            {{-- Action buttons --}}
            <div style="grid-column:span 3;display:flex;align-items:center;gap:8px;border-top:1px solid #f3f3f9;padding-top:12px">
                <button type="submit" class="btn-primary" style="padding:7px 20px">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/></svg>
                    Szűrés
                </button>
                <button type="button" class="btn-ghost" onclick="openModal('modal-save-filter')" style="padding:7px 16px">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                    Mentés
                </button>
                @if($hasFilter)
                <a href="{{ route('admin.people.index') }}" class="btn-ghost" style="padding:7px 16px;color:#f06548;border-color:#f06548">
                    Szűrők törlése
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
</form>

{{-- ── SAVE FILTER MODAL ──────────────────────────────── --}}
<div id="modal-save-filter" class="nf-overlay" onclick="if(event.target===this)closeModal('modal-save-filter')">
    <div class="nf-modal" style="max-width:380px">
        <div class="nf-modal-header">
            <span class="nf-modal-title">Szűrő mentése</span>
            <button class="nf-modal-close" onclick="closeModal('modal-save-filter')">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.people.filters.store') }}" id="save-filter-form">
            @csrf
            <input type="hidden" name="filters" id="save-filter-data">
            <div class="nf-modal-body">
                <label class="nf-label">Szűrő neve <span style="color:#f06548">*</span></label>
                <input type="text" name="name" class="nf-input" placeholder="pl. Budapest tagok" required maxlength="100">
                <p style="font-size:0.75rem;color:#adb5bd;margin-top:6px">A jelenlegi szűrőbeállítások kerülnek mentésre.</p>
            </div>
            <div class="nf-modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('modal-save-filter')">Mégse</button>
                <button type="submit" class="btn-primary">Mentés</button>
            </div>
        </form>
    </div>
</div>

<div class="nf-card" style="overflow:hidden">
    <table class="nf-table">
        <thead>
            <tr>
                <th style="width:40px"></th>
                <th>{{ __('people.col_name') }}</th>
                <th>{{ __('people.col_email') }}</th>
                <th>{{ __('people.col_phone') }}</th>
                <th>{{ __('common.status') }}</th>
                <th>Értékelés</th>
                <th>{{ __('people.col_city') }}</th>
                <th>{{ __('people.col_registered') }}</th>
                <th style="width:80px"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($people as $person)
            @php
                $editArgs = implode(',', [
                    $person->id,
                    json_encode($person->first_name),
                    json_encode($person->last_name),
                    json_encode($person->email ?? ''),
                    json_encode($person->phone ?? ''),
                    json_encode($person->city ?? ''),
                    "'{$person->status}'",
                    $person->is_subscribed ? 'true' : 'false',
                    json_encode($person->source ?? ''),
                    json_encode($person->notes ?? ''),
                    json_encode($person->photo ? asset('storage/' . $person->photo) : ''),
                    json_encode($person->groups->pluck('id')->toArray()),
                ]);
            @endphp
            <tr onclick="openEdit({{ $editArgs }})"
                style="cursor:pointer"
                onmouseover="this.style.background='#f8f9ff'"
                onmouseout="this.style.background=''">
                <td onclick="event.stopPropagation()">
                    <div style="width:34px;height:34px;border-radius:50%;overflow:hidden;flex-shrink:0;background:linear-gradient(135deg,#405189,#7a5af8);display:flex;align-items:center;justify-content:center;">
                        @if($person->photo)
                            <img src="{{ asset('storage/' . $person->photo) }}" style="width:34px;height:34px;object-fit:cover;display:block;flex-shrink:0">
                        @else
                            <span style="color:#fff;font-size:0.75rem;font-weight:700">{{ strtoupper(substr($person->first_name,0,1)) }}</span>
                        @endif
                    </div>
                </td>
                <td style="font-weight:500;color:#343a40">{{ $person->last_name }} {{ $person->first_name }}</td>
                <td style="color:#6c757d">{{ $person->email ?? '—' }}</td>
                <td style="color:#6c757d">{{ $person->phone ?? '—' }}</td>
                <td>
                    @php
                        $sc=['member'=>'badge-primary','supporter'=>'badge-success','donor'=>'badge-warning','volunteer'=>'badge-info','vip'=>'badge-purple','prospect'=>'badge-secondary','inactive'=>'badge-secondary'];
                    @endphp
                    <span class="nf-badge {{ $sc[$person->status] ?? 'badge-secondary' }}">{{ __('people.status.' . $person->status, [], null) ?: $person->status }}</span>
                </td>
                <td style="white-space:nowrap">
                    @if($person->lead_score)
                    <span style="color:#f7b84b;letter-spacing:-1px;font-size:0.85rem">
                        {{ str_repeat('★', $person->lead_score) }}<span style="color:#dee2e6">{{ str_repeat('★', 5 - $person->lead_score) }}</span>
                    </span>
                    @endif
                    @if($person->lead_stage)
                    @php
                        $stageBadgeColors = ['new'=>'#6c757d','contacted'=>'#299cdb','qualified'=>'#7a5af8','proposal'=>'#f7b84b','converted'=>'#0ab39c','lost'=>'#f06548'];
                        $stageLabels = ['new'=>'Új','contacted'=>'Kapcsolatba lépve','qualified'=>'Minősített','proposal'=>'Ajánlat','converted'=>'Megnyert','lost'=>'Elveszett'];
                        $stageColor = $stageBadgeColors[$person->lead_stage] ?? '#6c757d';
                    @endphp
                    <span style="display:block;font-size:0.7rem;color:{{ $stageColor }};font-weight:600;margin-top:2px">{{ $stageLabels[$person->lead_stage] ?? $person->lead_stage }}</span>
                    @endif
                    @if(!$person->lead_score && !$person->lead_stage)
                    <span style="color:#dee2e6;font-size:0.78rem">—</span>
                    @endif
                </td>
                <td style="color:#6c757d">{{ $person->city ?? '—' }}</td>
                <td style="color:#adb5bd">{{ $person->created_at->format('d M, Y') }}</td>
                <td style="text-align:right" onclick="event.stopPropagation()">
                    <button onclick="openEdit({{ $editArgs }})"
                            style="background:none;border:none;cursor:pointer;color:#405189;margin-right:6px" title="{{ __('common.edit') }}">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </button>
                    <form method="POST" action="{{ route('admin.people.destroy', $person) }}" style="display:inline" onsubmit="return confirm('{{ __('common.confirm_delete') }}')">
                        @csrf @method('DELETE')
                        <button type="submit" style="background:none;border:none;cursor:pointer;color:#f06548" title="{{ __('common.delete') }}">
                            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="9" style="text-align:center;padding:40px;color:#adb5bd">{{ __('people.empty') }}</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($people->hasPages())
    <div style="padding:12px 16px;border-top:1px solid #e9ebec">{{ $people->links() }}</div>
    @endif
</div>

{{-- ── CREATE MODAL ─────────────────────────────────── --}}
<div id="modal-create" class="nf-overlay" onclick="if(event.target===this)closeModal('modal-create')">
    <div class="nf-modal">
        <div class="nf-modal-header">
            <span class="nf-modal-title">{{ __('people.create_title') }}</span>
            <button class="nf-modal-close" onclick="closeModal('modal-create')">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.people.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="nf-modal-body" style="display:grid;grid-template-columns:1fr 1fr;gap:14px">

                <div style="grid-column:span 2;display:flex;align-items:center;gap:16px">
                    <div id="c-preview-wrap" style="width:64px;height:64px;border-radius:50%;overflow:hidden;background:linear-gradient(135deg,#405189,#7a5af8);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <svg id="c-preview-icon" width="28" height="28" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <img id="c-preview-img" src="" style="width:100%;height:100%;object-fit:cover;display:none">
                    </div>
                    <div>
                        <label class="nf-label" style="margin-bottom:6px">{{ __('people.photo') }}</label>
                        <label style="display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border:1px solid #ced4da;border-radius:5px;cursor:pointer;font-size:0.8rem;color:#495057;background:#fff">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            {{ __('people.upload_photo') }}
                            <input type="file" name="photo" accept="image/*" style="display:none" onchange="previewPhoto(this,'c-preview-img','c-preview-icon')">
                        </label>
                        <p style="font-size:0.7rem;color:#adb5bd;margin-top:4px">{{ __('people.photo_hint') }}</p>
                    </div>
                </div>

                <div>
                    <label class="nf-label">{{ __('people.last_name') }} <span style="color:#f06548">*</span></label>
                    <input type="text" name="last_name" class="nf-input" required>
                </div>
                <div>
                    <label class="nf-label">{{ __('people.first_name') }} <span style="color:#f06548">*</span></label>
                    <input type="text" name="first_name" class="nf-input" required>
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">{{ __('common.email') }}</label>
                    <input type="email" name="email" class="nf-input">
                </div>
                <div>
                    <label class="nf-label">{{ __('common.phone') }}</label>
                    <input type="text" name="phone" class="nf-input">
                </div>
                <div>
                    <label class="nf-label">{{ __('people.city') }}</label>
                    <input type="text" name="city" class="nf-input">
                </div>
                <div>
                    <label class="nf-label">{{ __('common.status') }} <span style="color:#f06548">*</span></label>
                    <select name="status" class="nf-select">
                        @foreach(['prospect','supporter','member','volunteer','donor','vip','inactive'] as $val)
                        <option value="{{ $val }}">{{ __('people.status.' . $val) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="nf-label">{{ __('people.source') }}</label>
                    <input type="text" name="source" class="nf-input">
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">{{ __('people.groups') }}</label>
                    <div class="group-chip-wrap">
                        @forelse($groups as $group)
                            <label class="group-chip">
                                <input type="checkbox" name="groups[]" value="{{ $group->id }}" onchange="this.closest('.group-chip').classList.toggle('active',this.checked)">
                                {{ $group->name }}
                            </label>
                        @empty
                            <span style="font-size:0.78rem;color:#adb5bd">{{ __('people.no_groups') }}</span>
                        @endforelse
                    </div>
                </div>
                <div style="grid-column:span 2">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                        <input type="hidden" name="is_subscribed" value="0">
                        <input type="checkbox" name="is_subscribed" value="1" style="width:15px;height:15px;accent-color:#405189">
                        <span class="nf-label" style="margin:0">{{ __('people.subscribed') }}</span>
                    </label>
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">{{ __('common.notes') }}</label>
                    <textarea name="notes" rows="2" class="nf-input" style="resize:none"></textarea>
                </div>
            </div>
            <div class="nf-modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('modal-create')">{{ __('common.cancel') }}</button>
                <button type="submit" class="btn-teal">{{ __('common.create') }}</button>
            </div>
        </form>
    </div>
</div>

{{-- ── EDIT MODAL ───────────────────────────────────── --}}
<div id="modal-edit" class="nf-overlay" onclick="if(event.target===this)closeModal('modal-edit')">
    <div class="nf-modal">
        <div class="nf-modal-header">
            <span class="nf-modal-title">{{ __('people.edit_title') }}</span>
            <button class="nf-modal-close" onclick="closeModal('modal-edit')">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="edit-form" method="POST" action="" enctype="multipart/form-data"
              data-base="{{ url('admin/people') }}">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="nf-modal-body" style="display:grid;grid-template-columns:1fr 1fr;gap:14px">

                <div style="grid-column:span 2;display:flex;align-items:center;gap:16px">
                    <div style="width:64px;height:64px;border-radius:50%;overflow:hidden;background:linear-gradient(135deg,#405189,#7a5af8);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <svg id="e-preview-icon" width="28" height="28" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <img id="e-preview-img" src="" style="width:100%;height:100%;object-fit:cover;display:none">
                    </div>
                    <div>
                        <label class="nf-label" style="margin-bottom:6px">{{ __('people.photo_change') }}</label>
                        <label style="display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border:1px solid #ced4da;border-radius:5px;cursor:pointer;font-size:0.8rem;color:#495057;background:#fff">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            {{ __('people.upload_new') }}
                            <input type="file" name="photo" accept="image/*" style="display:none" onchange="previewPhoto(this,'e-preview-img','e-preview-icon')">
                        </label>
                        <p style="font-size:0.7rem;color:#adb5bd;margin-top:4px">{{ __('people.photo_keep') }}</p>
                    </div>
                </div>

                <div>
                    <label class="nf-label">{{ __('people.last_name') }} <span style="color:#f06548">*</span></label>
                    <input type="text" name="last_name" id="e_last" class="nf-input" required>
                </div>
                <div>
                    <label class="nf-label">{{ __('people.first_name') }} <span style="color:#f06548">*</span></label>
                    <input type="text" name="first_name" id="e_first" class="nf-input" required>
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">{{ __('common.email') }}</label>
                    <input type="email" name="email" id="e_email" class="nf-input">
                </div>
                <div>
                    <label class="nf-label">{{ __('common.phone') }}</label>
                    <input type="text" name="phone" id="e_phone" class="nf-input">
                </div>
                <div>
                    <label class="nf-label">{{ __('people.city') }}</label>
                    <input type="text" name="city" id="e_city" class="nf-input">
                </div>
                <div>
                    <label class="nf-label">{{ __('common.status') }}</label>
                    <select name="status" id="e_status" class="nf-select">
                        @foreach(['prospect','supporter','member','volunteer','donor','vip','inactive'] as $val)
                        <option value="{{ $val }}">{{ __('people.status.' . $val) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="nf-label">{{ __('people.source') }}</label>
                    <input type="text" name="source" id="e_source" class="nf-input">
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">{{ __('people.groups') }}</label>
                    <div class="group-chip-wrap" id="e_groups">
                        @forelse($groups as $group)
                            <label class="group-chip">
                                <input type="checkbox" name="groups[]" value="{{ $group->id }}" onchange="this.closest('.group-chip').classList.toggle('active',this.checked)">
                                {{ $group->name }}
                            </label>
                        @empty
                            <span style="font-size:0.78rem;color:#adb5bd">{{ __('people.no_groups') }}</span>
                        @endforelse
                    </div>
                </div>
                <div style="grid-column:span 2">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                        <input type="hidden" name="is_subscribed" value="0">
                        <input type="checkbox" name="is_subscribed" id="e_subscribed" value="1" style="width:15px;height:15px;accent-color:#405189">
                        <span class="nf-label" style="margin:0">{{ __('people.subscribed') }}</span>
                    </label>
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">{{ __('common.notes') }}</label>
                    <textarea name="notes" id="e_notes" rows="2" class="nf-input" style="resize:none"></textarea>
                </div>
            </div>
            <div class="nf-modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('modal-edit')">{{ __('common.cancel') }}</button>
                <button type="submit" class="btn-teal">{{ __('common.save') }}</button>
            </div>
        </form>
    </div>
</div>

{{-- ── IMPORT MODAL ──────────────────────────────────── --}}
<div id="modal-import" class="nf-overlay" onclick="if(event.target===this)closeModal('modal-import')">
    <div class="nf-modal">
        <div class="nf-modal-header">
            <span class="nf-modal-title">Kapcsolatok importálása</span>
            <button class="nf-modal-close" onclick="closeModal('modal-import')">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.people.import') }}" enctype="multipart/form-data">
            @csrf
            <div class="nf-modal-body" style="display:flex;flex-direction:column;gap:16px">
                <div style="background:#f8f9fa;border:1px solid #e9ebec;border-radius:6px;padding:12px 14px;font-size:0.8rem;color:#6c757d;line-height:1.6">
                    <strong style="color:#343a40">Elfogadott formátumok:</strong> CSV (.csv) és Excel (.xlsx, .xls)<br>
                    <strong style="color:#343a40">Kötelező oszlopok:</strong> Vezetéknév, Keresztnév<br>
                    <strong style="color:#343a40">Opcionális:</strong> Email, Telefon, Mobil, Város, Megye, Irányítószám, Státusz, Hírlevél (0/1), Forrás, Megjegyzés<br>
                    <strong style="color:#343a40">Duplikátum:</strong> Ha az email cím már szerepel a rendszerben, a sor kimarad.<br>
                    <span style="margin-top:4px;display:inline-block">
                        Sablon letöltése:
                        <a href="{{ route('admin.people.export', ['format'=>'csv']) }}" style="color:#405189">CSV</a> /
                        <a href="{{ route('admin.people.export', ['format'=>'xlsx']) }}" style="color:#405189">Excel</a>
                        (meglévő adatokkal)
                    </span>
                </div>
                <div>
                    <label class="nf-label">Fájl kiválasztása <span style="color:#f06548">*</span></label>
                    <label id="import-label" style="display:flex;align-items:center;gap:8px;padding:10px 14px;border:2px dashed #ced4da;border-radius:6px;cursor:pointer;transition:border-color 0.2s"
                           onmouseover="this.style.borderColor='#405189'" onmouseout="this.style.borderColor='#ced4da'">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        <span id="import-filename" style="font-size:0.8125rem;color:#6c757d">Kattints a fájl kiválasztásához…</span>
                        <input type="file" name="file" accept=".csv,.xlsx,.xls" required style="display:none"
                               onchange="document.getElementById('import-filename').textContent = this.files[0]?.name || 'Kattints a fájl kiválasztásához…'">
                    </label>
                </div>
            </div>
            <div class="nf-modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('modal-import')">Mégse</button>
                <button type="submit" class="btn-primary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    Importálás
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<style>
.filter-chip {
    display:inline-flex;align-items:center;padding:3px 10px;border-radius:20px;
    background:rgba(64,81,137,0.1);color:#405189;font-size:0.75rem;font-weight:500;
}
</style>
<script>
// ── Filter panel toggle ──────────────────────────────────
function toggleFilterPanel() {
    const panel = document.getElementById('filter-panel');
    const chevron = document.getElementById('filter-chevron');
    const open = panel.style.display !== 'none';
    panel.style.display = open ? 'none' : 'block';
    chevron.style.transform = open ? '' : 'rotate(180deg)';
}

// Auto-open panel if filters are active
document.addEventListener('DOMContentLoaded', () => {
    const panel = document.getElementById('filter-panel');
    if (panel.style.display !== 'none') {
        document.getElementById('filter-chevron').style.transform = 'rotate(180deg)';
    }
    // Init status chips visual state
    document.querySelectorAll('input[name="status[]"]').forEach(cb => {
        updateStatusChip(cb.value, cb.checked);
    });
});

function updateStatusChip(val, checked) {
    const label = document.getElementById('sc-' + val);
    if (!label) return;
    if (checked) {
        label.style.background = '#405189';
        label.style.borderColor = '#405189';
        label.style.color = '#fff';
    } else {
        label.style.background = '#fff';
        label.style.borderColor = '#dee2e6';
        label.style.color = '#6c757d';
    }
}

// ── Saved filters dropdown ──────────────────────────────
function toggleSavedMenu() {
    const m = document.getElementById('saved-menu');
    m.style.display = m.style.display === 'block' ? 'none' : 'block';
}
document.addEventListener('click', e => {
    const wrap = document.getElementById('saved-wrap');
    if (wrap && !wrap.contains(e.target)) {
        const m = document.getElementById('saved-menu');
        if (m) m.style.display = 'none';
    }
});

function applySavedFilter(filters) {
    const form = document.getElementById('filter-form');
    // Clear existing filter inputs
    ['q','city','source','date_from','date_to','group_id'].forEach(name => {
        const el = form.querySelector('[name="' + name + '"]');
        if (el) el.value = filters[name] ?? '';
    });
    // Subscribed radio
    const subVal = filters.subscribed ?? '';
    form.querySelectorAll('[name="subscribed"]').forEach(r => {
        r.checked = (r.value === String(subVal));
    });
    // Status checkboxes
    const statuses = filters.status ?? [];
    form.querySelectorAll('[name="status[]"]').forEach(cb => {
        cb.checked = statuses.includes(cb.value);
        updateStatusChip(cb.value, cb.checked);
    });
    // Open panel and submit
    document.getElementById('filter-panel').style.display = 'block';
    document.getElementById('filter-chevron').style.transform = 'rotate(180deg)';
    document.getElementById('saved-menu').style.display = 'none';
    form.submit();
}

// ── Save filter — serialize current form state ──────────
document.getElementById('modal-save-filter')?.addEventListener('click', () => {
    const form = document.getElementById('filter-form');
    const data = {};
    const q = form.querySelector('[name="q"]')?.value;
    if (q) data.q = q;
    const city = form.querySelector('[name="city"]')?.value;
    if (city) data.city = city;
    const source = form.querySelector('[name="source"]')?.value;
    if (source) data.source = source;
    const dateFrom = form.querySelector('[name="date_from"]')?.value;
    if (dateFrom) data.date_from = dateFrom;
    const dateTo = form.querySelector('[name="date_to"]')?.value;
    if (dateTo) data.date_to = dateTo;
    const groupId = form.querySelector('[name="group_id"]')?.value;
    if (groupId) data.group_id = groupId;
    const sub = form.querySelector('[name="subscribed"]:checked')?.value;
    if (sub !== undefined && sub !== '') data.subscribed = sub;
    const statuses = [...form.querySelectorAll('[name="status[]"]:checked')].map(c => c.value);
    if (statuses.length) data.status = statuses;
    document.getElementById('save-filter-data').value = JSON.stringify(data);
});

function toggleExportMenu() {
    const m = document.getElementById('export-menu');
    m.style.display = m.style.display === 'block' ? 'none' : 'block';
}
document.addEventListener('click', e => {
    if (!document.getElementById('export-wrap').contains(e.target)) {
        document.getElementById('export-menu').style.display = 'none';
    }
});

function previewPhoto(input, imgId, iconId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const img  = document.getElementById(imgId);
            const icon = document.getElementById(iconId);
            img.src = e.target.result;
            img.style.display = 'block';
            if (icon) icon.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function openEdit(id, first, last, email, phone, city, status, subscribed, source, notes, photoUrl, groupIds = []) {
    const form = document.getElementById('edit-form');
    form.action = form.dataset.base + '/' + id;
    document.getElementById('e_first').value      = first;
    document.getElementById('e_last').value       = last;
    document.getElementById('e_email').value      = email;
    document.getElementById('e_phone').value      = phone;
    document.getElementById('e_city').value       = city;
    document.getElementById('e_status').value     = status;
    document.getElementById('e_source').value     = source;
    document.getElementById('e_notes').value      = notes;
    document.getElementById('e_subscribed').checked = subscribed;

    document.querySelectorAll('#e_groups .group-chip input[type=checkbox]').forEach(cb => {
        const active = groupIds.includes(parseInt(cb.value));
        cb.checked = active;
        cb.closest('.group-chip').classList.toggle('active', active);
    });

    const img  = document.getElementById('e-preview-img');
    const icon = document.getElementById('e-preview-icon');
    if (photoUrl) {
        img.src = photoUrl;
        img.style.display = 'block';
        icon.style.display = 'none';
    } else {
        img.style.display = 'none';
        icon.style.display = 'block';
    }

    openModal('modal-edit');
}
</script>
@endpush
@endsection
