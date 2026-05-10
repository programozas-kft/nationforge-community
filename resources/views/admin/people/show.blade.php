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
