@php
    /** @var \Carbon\Carbon $month */
    /** @var \Illuminate\Support\Collection $events grouped by Y-m-d */
    $prevMonth   = $month->copy()->subMonthNoOverflow()->format('Y-m');
    $nextMonth   = $month->copy()->addMonthNoOverflow()->format('Y-m');
    $thisMonth   = now()->format('Y-m');
    $today       = now()->format('Y-m-d');
    $weekdays    = __('group_calendar.weekdays');
    $monthName   = __('group_calendar.months.' . (int) $month->format('n'));

    // Build a 6x7 grid starting on Monday
    $firstOfMonth = $month->copy()->startOfMonth();
    $gridStart    = $firstOfMonth->copy()->startOfWeek(\Carbon\Carbon::MONDAY);
    $cells        = [];
    for ($i = 0; $i < 42; $i++) {
        $d = $gridStart->copy()->addDays($i);
        $cells[] = [
            'date'      => $d,
            'in_month'  => $d->format('Y-m') === $month->format('Y-m'),
            'is_today'  => $d->format('Y-m-d') === $today,
            'events'    => $events[$d->format('Y-m-d')] ?? collect(),
        ];
    }

    $typeColors = [
        'meetup'     => '#405189',
        'rally'      => '#f06548',
        'webinar'    => '#7a5af8',
        'fundraiser' => '#f7b84b',
        'volunteer'  => '#0ab39c',
        'conference' => '#0d6efd',
        'other'      => '#6c757d',
    ];
@endphp

<div class="nf-card mt-5 overflow-hidden">
    <div class="nf-card-header flex justify-between items-center">
        <div class="flex items-center gap-2">
            <div style="width:28px;height:28px;border-radius:7px;background:rgba(64,81,137,0.12);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <svg width="14" height="14" fill="none" stroke="#405189" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2" stroke-width="2"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 2v4M8 2v4M3 10h18"/>
                </svg>
            </div>
            <span>{{ __('group_calendar.title') }}</span>
        </div>
        <div class="flex items-center gap-1">
            <a href="{{ route('admin.groups.show', ['group' => $group, 'cal' => $prevMonth]) }}#calendar"
               class="p-1.5 rounded hover:bg-gray-100 text-gray-500 hover:text-gray-700 transition-colors"
               title="{{ __('group_calendar.prev') }}">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <a href="{{ route('admin.groups.show', ['group' => $group, 'cal' => $thisMonth]) }}#calendar"
               class="px-2 py-1 text-xs rounded hover:bg-gray-100 text-gray-600 hover:text-gray-800 transition-colors font-medium">
                {{ __('group_calendar.today') }}
            </a>
            <a href="{{ route('admin.groups.show', ['group' => $group, 'cal' => $nextMonth]) }}#calendar"
               class="p-1.5 rounded hover:bg-gray-100 text-gray-500 hover:text-gray-700 transition-colors"
               title="{{ __('group_calendar.next') }}">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>

    <div id="calendar" class="px-4 py-3">
        <div class="flex justify-between items-center mb-3">
            <div class="text-sm font-semibold text-gray-800">
                {{ $monthName }} {{ $month->format('Y') }}
            </div>
            <button type="button" class="btn-teal text-xs" style="padding:5px 10px"
                    onclick="openGroupEventModal('{{ $month->format('Y-m-d') }}')">
                <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:inline;vertical-align:-1px;margin-right:3px">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('group_calendar.new_event') }}
            </button>
        </div>

        <div class="grid grid-cols-7 gap-px bg-gray-100 rounded-md overflow-hidden border border-gray-100">
            @foreach($weekdays as $wd)
                <div class="bg-gray-50 py-1.5 text-center text-[10px] font-semibold uppercase tracking-wide text-gray-500">
                    {{ $wd }}
                </div>
            @endforeach

            @foreach($cells as $cell)
                @php
                    $dayEvents = $cell['events'];
                    $bg = $cell['in_month'] ? 'bg-white' : 'bg-gray-50';
                    $dateText = $cell['in_month'] ? 'text-gray-700' : 'text-gray-400';
                @endphp
                <div class="{{ $bg }} relative cursor-pointer hover:bg-indigo-50 transition-colors group/cell"
                     style="min-height:64px;padding:4px"
                     onclick="openGroupEventModal('{{ $cell['date']->format('Y-m-d') }}')">
                    <div class="flex justify-between items-start">
                        @if($cell['is_today'])
                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-[#405189] text-white text-[10px] font-bold">
                                {{ $cell['date']->day }}
                            </span>
                        @else
                            <span class="text-[11px] font-medium {{ $dateText }} px-1">{{ $cell['date']->day }}</span>
                        @endif

                        @if($dayEvents->count() > 0 && $cell['in_month'])
                            <span class="text-[9px] text-gray-400 mt-0.5">{{ $dayEvents->count() }}</span>
                        @endif
                    </div>

                    <div class="mt-1 space-y-0.5">
                        @foreach($dayEvents->take(2) as $ev)
                            <a href="{{ route('admin.events.show', $ev) }}"
                               onclick="event.stopPropagation()"
                               class="block px-1 py-0.5 rounded text-[10px] font-medium text-white truncate hover:opacity-80"
                               style="background:{{ $typeColors[$ev->type] ?? '#6c757d' }}"
                               title="{{ $ev->title }} — {{ $ev->starts_at->format('H:i') }}">
                                <span class="opacity-80">{{ $ev->starts_at->format('H:i') }}</span> {{ $ev->title }}
                            </a>
                        @endforeach
                        @if($dayEvents->count() > 2)
                            <div class="px-1 text-[9px] text-gray-500 font-medium">
                                +{{ trans_choice('group_calendar.more', $dayEvents->count() - 2, ['count' => $dayEvents->count() - 2]) }}
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ── QUICK-ADD EVENT MODAL ──────────────────────────── --}}
<div id="group-event-modal" class="nf-overlay" onclick="if(event.target===this&&__nfMdTarget===this)closeModal('group-event-modal')">
    <div class="nf-modal nf-modal-lg">
        <div class="nf-modal-header">
            <span class="nf-modal-title">{{ __('group_calendar.modal_title') }}</span>
            <button class="nf-modal-close" onclick="closeModal('group-event-modal')">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.groups.events.store', $group) }}">
            @csrf
            <div class="nf-modal-body" style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
                <div style="grid-column:span 2">
                    <label class="nf-label">{{ __('group_calendar.event_title') }} <span style="color:#f06548">*</span></label>
                    <input type="text" name="title" class="nf-input" required>
                </div>
                <div>
                    <label class="nf-label">{{ __('group_calendar.type') }} <span style="color:#f06548">*</span></label>
                    <select name="type" class="nf-select">
                        @foreach(['meetup','rally','webinar','fundraiser','volunteer','conference','other'] as $t)
                            <option value="{{ $t }}">{{ __('events.type.' . $t) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="nf-label">{{ __('group_calendar.starts_at') }} <span style="color:#f06548">*</span></label>
                    <input type="datetime-local" id="gev_starts" name="starts_at" class="nf-input" required>
                </div>
                <div>
                    <label class="nf-label">{{ __('group_calendar.ends_at') }}</label>
                    <input type="datetime-local" name="ends_at" class="nf-input">
                </div>
                <div>
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;margin-top:24px">
                        <input type="hidden" name="is_online" value="0">
                        <input type="checkbox" name="is_online" value="1" style="width:15px;height:15px;accent-color:#0ab39c">
                        <span class="nf-label" style="margin:0">{{ __('group_calendar.is_online') }}</span>
                    </label>
                </div>
                <div>
                    <label class="nf-label">{{ __('group_calendar.online_url') }}</label>
                    <input type="url" name="online_url" class="nf-input" placeholder="https://...">
                </div>
                <div>
                    <label class="nf-label">{{ __('group_calendar.venue') }}</label>
                    <input type="text" name="venue_name" class="nf-input">
                </div>
                <div>
                    <label class="nf-label">{{ __('group_calendar.city') }}</label>
                    <input type="text" name="city" class="nf-input">
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">{{ __('group_calendar.description') }}</label>
                    <textarea name="description" rows="2" class="nf-input" style="resize:none"></textarea>
                </div>
            </div>
            <div class="nf-modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('group-event-modal')">{{ __('group_calendar.cancel') }}</button>
                <button type="submit" class="btn-teal">{{ __('group_calendar.create') }}</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openGroupEventModal(dateStr) {
    const startsInput = document.getElementById('gev_starts');
    if (startsInput) {
        // Default time 18:00 on the picked day
        startsInput.value = dateStr + 'T18:00';
    }
    openModal('group-event-modal');
}
</script>
@endpush
