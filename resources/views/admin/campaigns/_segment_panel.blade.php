{{--
  Variables: $prefix (c|e), $seg (array), $groups, $tags, $allStatuses, $subscriberCount
--}}
@php
    $segType     = $seg['type']      ?? 'all';
    $segGroups   = $seg['group_ids'] ?? [];
    $segTags     = $seg['tag_ids']   ?? [];
    $segStatuses = $seg['statuses']  ?? [];
@endphp

<div style="padding:14px 16px;background:#f8f9fa;border:1px solid #e9ebec;border-radius:8px;display:grid;gap:12px">
    <div>
        <label class="nf-label" style="margin-bottom:6px">{{ __('campaigns.seg_label') }}</label>
        <select name="segment_type" class="nf-select" onchange="onSegmentTypeChange(this, '{{ $prefix }}')">
            <option value="all"    @selected($segType === 'all')>{{ __('campaigns.seg_all') }}</option>
            <option value="group"  @selected($segType === 'group')>{{ __('campaigns.seg_group') }}</option>
            <option value="tag"    @selected($segType === 'tag')>{{ __('campaigns.seg_tag') }}</option>
            <option value="status" @selected($segType === 'status')>{{ __('campaigns.seg_status') }}</option>
        </select>
    </div>

    {{-- Group picker --}}
    <div id="{{ $prefix }}_seg_group" style="display:{{ $segType === 'group' ? '' : 'none' }}">
        <label class="nf-label" style="margin-bottom:4px">{{ __('campaigns.seg_groups') }}
            <span style="font-weight:400;color:#adb5bd">({{ __('campaigns.seg_multiselect_hint') }})</span>
        </label>
        @if($groups->isEmpty())
            <p style="font-size:.8rem;color:#adb5bd">{{ __('campaigns.seg_no_groups') }}</p>
        @else
            <select name="segment_group_ids[]" multiple class="nf-select" style="height:110px"
                    onchange="scheduleSegCount('{{ $prefix }}')">
                @foreach($groups as $g)
                    <option value="{{ $g->id }}" @selected(in_array($g->id, $segGroups))>{{ $g->name }}</option>
                @endforeach
            </select>
        @endif
    </div>

    {{-- Tag picker --}}
    <div id="{{ $prefix }}_seg_tag" style="display:{{ $segType === 'tag' ? '' : 'none' }}">
        <label class="nf-label" style="margin-bottom:4px">{{ __('campaigns.seg_tags') }}
            <span style="font-weight:400;color:#adb5bd">({{ __('campaigns.seg_multiselect_hint') }})</span>
        </label>
        @if($tags->isEmpty())
            <p style="font-size:.8rem;color:#adb5bd">{{ __('campaigns.seg_no_tags') }}</p>
        @else
            <select name="segment_tag_ids[]" multiple class="nf-select" style="height:110px"
                    onchange="scheduleSegCount('{{ $prefix }}')">
                @foreach($tags as $t)
                    <option value="{{ $t->id }}" @selected(in_array($t->id, $segTags))>{{ $t->name }}</option>
                @endforeach
            </select>
        @endif
    </div>

    {{-- Status checkboxes --}}
    <div id="{{ $prefix }}_seg_status" style="display:{{ $segType === 'status' ? '' : 'none' }}">
        <label class="nf-label" style="margin-bottom:6px">{{ __('campaigns.seg_statuses') }}</label>
        <div style="display:flex;flex-wrap:wrap;gap:10px 18px">
            @foreach($allStatuses as $s)
                <label style="display:flex;align-items:center;gap:5px;cursor:pointer;font-size:.82rem;color:#495057">
                    <input type="checkbox" name="segment_statuses[]" value="{{ $s }}"
                           @checked(in_array($s, $segStatuses))
                           onchange="scheduleSegCount('{{ $prefix }}')">
                    {{ __('people.status.' . $s) }}
                </label>
            @endforeach
        </div>
    </div>

    {{-- Live recipient count --}}
    <div style="display:flex;align-items:center;gap:6px;font-size:.8rem;color:#495057;padding-top:4px;border-top:1px solid #e9ebec">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#405189;flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        {{ __('campaigns.seg_estimated') }}:
        <strong id="{{ $prefix }}_seg_count_val" style="color:#405189">{{ $subscriberCount }}</strong>
        {{ __('campaigns.seg_recipients') }}
    </div>
</div>
