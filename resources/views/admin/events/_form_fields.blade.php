<div class="nf-modal-body" style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
    <div style="grid-column:span 2">
        <label class="nf-label">{{ __('common.title_label') }} <span style="color:#f06548">*</span></label>
        <input type="text" name="title" class="nf-input" required>
    </div>
    <div>
        <label class="nf-label">{{ __('common.type') }} <span style="color:#f06548">*</span></label>
        <select name="type" class="nf-select">
            @foreach(['meetup','rally','webinar','fundraiser','volunteer','conference','other'] as $t)
            <option value="{{ $t }}">{{ __('events.type.' . $t) }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="nf-label">{{ __('common.status') }} <span style="color:#f06548">*</span></label>
        <select name="status" class="nf-select">
            @foreach(['draft','published','cancelled','completed'] as $s)
            <option value="{{ $s }}">{{ __('events.status.' . $s) }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="nf-label">{{ __('events.col_start') }} <span style="color:#f06548">*</span></label>
        <input type="datetime-local" name="starts_at" class="nf-input" required>
    </div>
    <div>
        <label class="nf-label">{{ __('events.col_end') }}</label>
        <input type="datetime-local" name="ends_at" class="nf-input">
    </div>
    <div style="grid-column:span 2">
        <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
            <input type="hidden" name="is_online" value="0">
            <input type="checkbox" name="is_online" value="1" style="width:15px;height:15px;accent-color:#405189">
            <span class="nf-label" style="margin:0">{{ __('events.is_online') }}</span>
        </label>
    </div>
    <div style="grid-column:span 2">
        <label class="nf-label">{{ __('events.online_url') }}</label>
        <input type="url" name="online_url" class="nf-input">
    </div>
    <div>
        <label class="nf-label">{{ __('events.venue_name') }}</label>
        <input type="text" name="venue_name" class="nf-input">
    </div>
    <div>
        <label class="nf-label">{{ __('common.city') }}</label>
        <input type="text" name="city" class="nf-input">
    </div>
    <div style="grid-column:span 2">
        <label class="nf-label">{{ __('events.address') }}</label>
        <input type="text" name="address" class="nf-input">
    </div>
    <div>
        <label class="nf-label">{{ __('events.capacity') }}</label>
        <input type="number" name="capacity" min="1" class="nf-input">
    </div>
    <div>
        <label class="nf-label">{{ __('events.ticket_price') }}</label>
        <input type="number" name="ticket_price" min="0" step="0.01" class="nf-input">
    </div>
    <div style="grid-column:span 2">
        <label class="nf-label">{{ __('common.description') }}</label>
        <textarea name="description" rows="2" class="nf-input" style="resize:none"></textarea>
    </div>
</div>
