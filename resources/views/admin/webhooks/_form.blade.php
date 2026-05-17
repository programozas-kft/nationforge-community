<div class="nf-modal-body" style="display:grid;gap:14px">

    <div>
        <label class="nf-label">{{ __('webhooks.field_name') }} <span style="color:#f06548">*</span></label>
        <input type="text" name="name" id="{{ ($edit??false)?'edit_wh_name':'wh_name' }}"
               class="nf-input" required maxlength="100"
               placeholder="{{ __('webhooks.name_placeholder') }}">
    </div>

    <div>
        <label class="nf-label">{{ __('webhooks.field_url') }} <span style="color:#f06548">*</span></label>
        <input type="url" name="url" id="{{ ($edit??false)?'edit_wh_url':'wh_url' }}"
               class="nf-input" required maxlength="500"
               placeholder="https://example.com/webhook">
    </div>

    <div>
        <label class="nf-label">{{ __('webhooks.field_secret') }}</label>
        <input type="text" name="secret" id="{{ ($edit??false)?'edit_wh_secret':'wh_secret' }}"
               class="nf-input" maxlength="200"
               placeholder="{{ __('webhooks.secret_placeholder') }}">
        <p style="font-size:0.72rem;color:#adb5bd;margin-top:4px">{{ __('webhooks.secret_hint') }}</p>
    </div>

    <div>
        <label class="nf-label">{{ __('webhooks.field_events') }} <span style="color:#f06548">*</span></label>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:6px 16px;margin-top:6px">
            @foreach($eventTypes as $ev)
            <label style="display:flex;align-items:center;gap:7px;font-size:0.8rem;color:#495057;cursor:pointer">
                <input type="checkbox" name="events[]" value="{{ $ev }}"
                       style="width:14px;height:14px;accent-color:#405189">
                <span style="font-family:monospace;font-size:0.75rem">{{ $ev }}</span>
            </label>
            @endforeach
        </div>
    </div>

</div>
