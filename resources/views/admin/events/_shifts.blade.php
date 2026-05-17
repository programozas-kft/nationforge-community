@php
    /** @var \App\Models\Event $event */
    /** @var \Illuminate\Support\Collection $people */
    $shifts = $event->shifts;
@endphp

<div class="nf-card overflow-hidden">
    <div class="nf-card-header" style="display:flex;align-items:center;justify-content:space-between">
        <div class="flex items-center gap-2">
            <div style="width:28px;height:28px;border-radius:7px;background:rgba(10,179,156,0.12);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <svg width="14" height="14" fill="none" stroke="#0ab39c" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <span>{{ __('shifts.title') }} ({{ $shifts->count() }})</span>
        </div>
        <button type="button" class="btn-teal text-xs" style="padding:5px 10px"
                onclick="openShiftModal()">
            <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:inline;vertical-align:-1px;margin-right:3px">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            {{ __('shifts.new') }}
        </button>
    </div>

    @if($errors->any())
        <div class="px-5 pt-3">
            @foreach($errors->all() as $err)
                <div class="nf-error">{{ $err }}</div>
            @endforeach
        </div>
    @endif

    @if($shifts->isEmpty())
        <div class="px-5 py-8 text-center">
            <svg class="mx-auto w-10 h-10 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm text-gray-400">{{ __('shifts.empty') }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ __('shifts.empty_hint') }}</p>
        </div>
    @else
        <div class="divide-y divide-gray-100">
            @foreach($shifts as $shift)
                @php
                    $confirmedCount  = $shift->signups->where('status', 'confirmed')->count();
                    $waitlistedCount = $shift->signups->where('status', 'waitlisted')->count();
                    $pct = $shift->slots > 0 ? min(100, round(($confirmedCount / $shift->slots) * 100)) : 0;
                    $isFull = $confirmedCount >= $shift->slots;
                @endphp
                <div class="p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <h4 class="font-semibold text-gray-800 text-sm">{{ $shift->title }}</h4>
                                @if($isFull)
                                    <span class="nf-badge badge-warning text-[10px]">{{ __('shifts.full') }}</span>
                                @endif
                            </div>
                            <div class="flex items-center gap-3 text-xs text-gray-500 mt-1 flex-wrap">
                                <span class="flex items-center gap-1">
                                    <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ $shift->starts_at->format('Y. m. d. H:i') }} – {{ $shift->ends_at->format('H:i') }}
                                </span>
                                @if($shift->location)
                                <span class="flex items-center gap-1">
                                    <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $shift->location }}
                                </span>
                                @endif
                            </div>
                            @if($shift->description)
                                <p class="text-xs text-gray-600 mt-1.5 whitespace-pre-wrap">{{ $shift->description }}</p>
                            @endif
                        </div>
                        <div class="flex items-center gap-1 flex-shrink-0">
                            <button type="button"
                                    onclick="openShiftEditModal({{ json_encode([
                                        'id' => $shift->id,
                                        'title' => $shift->title,
                                        'description' => $shift->description,
                                        'starts_at' => $shift->starts_at->format('Y-m-d\TH:i'),
                                        'ends_at' => $shift->ends_at->format('Y-m-d\TH:i'),
                                        'location' => $shift->location,
                                        'slots' => $shift->slots,
                                    ]) }})"
                                    class="p-1.5 rounded hover:bg-gray-100 text-gray-500" title="{{ __('common.edit') }}">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <form method="POST" action="{{ route('admin.events.shifts.destroy', [$event, $shift]) }}"
                                  onsubmit="return confirm('{{ __('common.confirm_delete') }}')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-1.5 rounded hover:bg-red-50 text-gray-400 hover:text-red-600" title="{{ __('common.delete') }}">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Capacity bar --}}
                    <div class="mt-3">
                        <div class="flex justify-between text-[11px] text-gray-500 mb-1">
                            <span>{{ __('shifts.filled') }}: {{ $confirmedCount }} / {{ $shift->slots }}</span>
                            @if($waitlistedCount > 0)
                                <span>{{ __('shifts.waitlist') }}: {{ $waitlistedCount }}</span>
                            @endif
                        </div>
                        <div class="w-full bg-gray-100 rounded-full overflow-hidden" style="height:6px">
                            <div style="width:{{ $pct }}%;height:100%;background:{{ $isFull ? '#f7b84b' : '#0ab39c' }};transition:width .3s"></div>
                        </div>
                    </div>

                    {{-- Signups list --}}
                    @if($shift->signups->isNotEmpty())
                        <div class="mt-3 space-y-1">
                            @foreach($shift->signups->sortBy('created_at') as $signup)
                                @php
                                    $statusColors = [
                                        'confirmed'  => ['bg' => '#e9f7f4', 'color' => '#0ab39c'],
                                        'waitlisted' => ['bg' => '#fff8e9', 'color' => '#f7b84b'],
                                        'cancelled'  => ['bg' => '#f8f9fa', 'color' => '#adb5bd'],
                                    ];
                                    $sc = $statusColors[$signup->status] ?? $statusColors['confirmed'];
                                @endphp
                                <div class="flex items-center gap-2 py-1.5 px-2 rounded text-xs hover:bg-gray-50">
                                    <span class="inline-block w-1.5 h-1.5 rounded-full" style="background:{{ $sc['color'] }}"></span>

                                    @if($signup->person)
                                        <a href="{{ route('admin.people.show', $signup->person) }}"
                                           class="font-medium text-gray-700 hover:text-indigo-700">
                                            {{ $signup->person->last_name }} {{ $signup->person->first_name }}
                                        </a>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif

                                    <span class="text-[10px] uppercase tracking-wide" style="color:{{ $sc['color'] }}">
                                        {{ __('shifts.status.' . $signup->status) }}
                                    </span>

                                    @if($signup->notes)
                                        <span class="text-gray-400 italic truncate" title="{{ $signup->notes }}">— {{ $signup->notes }}</span>
                                    @endif

                                    <div class="flex-1"></div>

                                    {{-- Attended toggle --}}
                                    <form method="POST" action="{{ route('admin.events.shifts.signups.attended', [$event, $shift, $signup]) }}" class="inline">
                                        @csrf @method('PATCH')
                                        <button type="submit"
                                                class="flex items-center gap-1 px-2 py-0.5 rounded {{ $signup->attended ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}"
                                                title="{{ __('shifts.toggle_attended') }}">
                                            @if($signup->attended)
                                                <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                                <span class="text-[10px] font-semibold">{{ __('shifts.attended') }}</span>
                                            @else
                                                <span class="text-[10px]">{{ __('shifts.mark_attended') }}</span>
                                            @endif
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.events.shifts.signups.destroy', [$event, $shift, $signup]) }}"
                                          onsubmit="return confirm('{{ __('common.confirm_delete') }}')" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-1 rounded hover:bg-red-50 text-gray-400 hover:text-red-600" title="{{ __('shifts.remove_signup') }}">
                                            <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="mt-2">
                        <button type="button"
                                class="text-xs text-[#405189] hover:text-[#2c3a73] font-medium flex items-center gap-1"
                                onclick="openSignupModal({{ $shift->id }}, '{{ addslashes($shift->title) }}')">
                            <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                            {{ __('shifts.add_signup') }}
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- ── NEW / EDIT SHIFT MODAL ─────────────────────────── --}}
<div id="shift-modal" class="nf-overlay" onclick="if(event.target===this&&__nfMdTarget===this)closeModal('shift-modal')">
    <div class="nf-modal">
        <div class="nf-modal-header">
            <span class="nf-modal-title" id="shift-modal-title">{{ __('shifts.new') }}</span>
            <button class="nf-modal-close" onclick="closeModal('shift-modal')">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="shift-form" method="POST" action="{{ route('admin.events.shifts.store', $event) }}"
              data-update-base="{{ url('admin/events/' . $event->id . '/shifts') }}">
            @csrf
            <input type="hidden" name="_method" id="shift-method" value="POST">
            <div class="nf-modal-body" style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
                <div style="grid-column:span 2">
                    <label class="nf-label">{{ __('shifts.field_title') }} <span style="color:#f06548">*</span></label>
                    <input type="text" name="title" id="shift-title" class="nf-input" required>
                </div>
                <div>
                    <label class="nf-label">{{ __('shifts.field_starts') }} <span style="color:#f06548">*</span></label>
                    <input type="datetime-local" name="starts_at" id="shift-starts" class="nf-input" required
                           value="{{ $event->starts_at->format('Y-m-d\TH:i') }}">
                </div>
                <div>
                    <label class="nf-label">{{ __('shifts.field_ends') }} <span style="color:#f06548">*</span></label>
                    <input type="datetime-local" name="ends_at" id="shift-ends" class="nf-input" required
                           value="{{ ($event->ends_at ?? $event->starts_at->copy()->addHours(2))->format('Y-m-d\TH:i') }}">
                </div>
                <div>
                    <label class="nf-label">{{ __('shifts.field_location') }}</label>
                    <input type="text" name="location" id="shift-location" class="nf-input">
                </div>
                <div>
                    <label class="nf-label">{{ __('shifts.field_slots') }} <span style="color:#f06548">*</span></label>
                    <input type="number" name="slots" id="shift-slots" min="1" class="nf-input" value="1" required>
                </div>
                <div style="grid-column:span 2">
                    <label class="nf-label">{{ __('shifts.field_description') }}</label>
                    <textarea name="description" id="shift-description" rows="2" class="nf-input" style="resize:none"></textarea>
                </div>
            </div>
            <div class="nf-modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('shift-modal')">{{ __('common.cancel') }}</button>
                <button type="submit" class="btn-teal" id="shift-submit">{{ __('common.create') }}</button>
            </div>
        </form>
    </div>
</div>

{{-- ── ADD SIGNUP MODAL ──────────────────────────────── --}}
<div id="signup-modal" class="nf-overlay" onclick="if(event.target===this&&__nfMdTarget===this)closeModal('signup-modal')">
    <div class="nf-modal">
        <div class="nf-modal-header">
            <span class="nf-modal-title">{{ __('shifts.add_signup_title') }} — <span id="signup-shift-title" style="color:#405189"></span></span>
            <button class="nf-modal-close" onclick="closeModal('signup-modal')">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="signup-form" method="POST" action="" data-base="{{ url('admin/events/' . $event->id . '/shifts') }}">
            @csrf
            <div class="nf-modal-body" style="display:grid;grid-template-columns:1fr;gap:14px">
                <div>
                    <label class="nf-label">{{ __('shifts.field_person') }} <span style="color:#f06548">*</span></label>
                    <select name="person_id" class="nf-select" required>
                        <option value="">— {{ __('common.search') }} —</option>
                        @foreach($people as $p)
                            <option value="{{ $p->id }}">{{ $p->last_name }} {{ $p->first_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="nf-label">{{ __('shifts.field_notes') }}</label>
                    <textarea name="notes" rows="2" class="nf-input" style="resize:none" placeholder="{{ __('shifts.notes_placeholder') }}"></textarea>
                </div>
            </div>
            <div class="nf-modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('signup-modal')">{{ __('common.cancel') }}</button>
                <button type="submit" class="btn-teal">{{ __('shifts.assign') }}</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openShiftModal() {
    document.getElementById('shift-modal-title').textContent = @json(__('shifts.new'));
    document.getElementById('shift-submit').textContent = @json(__('common.create'));
    document.getElementById('shift-method').value = 'POST';
    document.getElementById('shift-form').action = @json(route('admin.events.shifts.store', $event));
    document.getElementById('shift-title').value = '';
    document.getElementById('shift-location').value = '';
    document.getElementById('shift-description').value = '';
    document.getElementById('shift-slots').value = 1;
    document.getElementById('shift-starts').value = @json($event->starts_at->format('Y-m-d\TH:i'));
    document.getElementById('shift-ends').value = @json(($event->ends_at ?? $event->starts_at->copy()->addHours(2))->format('Y-m-d\TH:i'));
    openModal('shift-modal');
}

function openShiftEditModal(data) {
    document.getElementById('shift-modal-title').textContent = @json(__('shifts.edit'));
    document.getElementById('shift-submit').textContent = @json(__('common.save'));
    document.getElementById('shift-method').value = 'PUT';
    const base = document.getElementById('shift-form').getAttribute('data-update-base');
    document.getElementById('shift-form').action = base + '/' + data.id;
    document.getElementById('shift-title').value = data.title || '';
    document.getElementById('shift-location').value = data.location || '';
    document.getElementById('shift-description').value = data.description || '';
    document.getElementById('shift-slots').value = data.slots || 1;
    document.getElementById('shift-starts').value = data.starts_at || '';
    document.getElementById('shift-ends').value = data.ends_at || '';
    openModal('shift-modal');
}

function openSignupModal(shiftId, shiftTitle) {
    document.getElementById('signup-shift-title').textContent = shiftTitle;
    const base = document.getElementById('signup-form').getAttribute('data-base');
    document.getElementById('signup-form').action = base + '/' + shiftId + '/signups';
    document.getElementById('signup-form').reset();
    openModal('signup-modal');
}
</script>
@endpush
