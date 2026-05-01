<div class="nf-modal-body" style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
    <div style="grid-column:span 2">
        <label class="nf-label">Cím <span style="color:#f06548">*</span></label>
        <input type="text" name="title" class="nf-input" required>
    </div>
    <div>
        <label class="nf-label">Típus <span style="color:#f06548">*</span></label>
        <select name="type" class="nf-select">
            @foreach(['meetup','rally','webinar','fundraiser','volunteer','conference','other'] as $t)
            <option value="{{ $t }}">{{ ucfirst($t) }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="nf-label">Státusz <span style="color:#f06548">*</span></label>
        <select name="status" class="nf-select">
            @foreach(['draft','published','cancelled','completed'] as $s)
            <option value="{{ $s }}">{{ ucfirst($s) }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="nf-label">Kezdés <span style="color:#f06548">*</span></label>
        <input type="datetime-local" name="starts_at" class="nf-input" required>
    </div>
    <div>
        <label class="nf-label">Befejezés</label>
        <input type="datetime-local" name="ends_at" class="nf-input">
    </div>
    <div style="grid-column:span 2">
        <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
            <input type="hidden" name="is_online" value="0">
            <input type="checkbox" name="is_online" value="1" style="width:15px;height:15px;accent-color:#405189">
            <span class="nf-label" style="margin:0">Online esemény</span>
        </label>
    </div>
    <div style="grid-column:span 2">
        <label class="nf-label">Online URL</label>
        <input type="url" name="online_url" class="nf-input">
    </div>
    <div>
        <label class="nf-label">Helyszín neve</label>
        <input type="text" name="venue_name" class="nf-input">
    </div>
    <div>
        <label class="nf-label">Város</label>
        <input type="text" name="city" class="nf-input">
    </div>
    <div style="grid-column:span 2">
        <label class="nf-label">Cím / Utca</label>
        <input type="text" name="address" class="nf-input">
    </div>
    <div>
        <label class="nf-label">Kapacitás (fő)</label>
        <input type="number" name="capacity" min="1" class="nf-input">
    </div>
    <div>
        <label class="nf-label">Jegyár (Ft)</label>
        <input type="number" name="ticket_price" min="0" step="0.01" class="nf-input">
    </div>
    <div style="grid-column:span 2">
        <label class="nf-label">Leírás</label>
        <textarea name="description" rows="2" class="nf-input" style="resize:none"></textarea>
    </div>
</div>
