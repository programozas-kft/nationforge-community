<div class="nf-modal-body" style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
    <div style="grid-column:1/-1">
        <label class="nf-label">Projekt neve <span style="color:#f06548">*</span></label>
        <input type="text" name="title" id="{{ isset($edit) ? 'ep-title' : 'cp-title' }}" class="nf-input"
               value="{{ old('title', $project?->title) }}" placeholder="pl. Kampány 2026" required>
    </div>
    <div style="grid-column:1/-1">
        <label class="nf-label">Leírás</label>
        <textarea name="description" id="{{ isset($edit) ? 'ep-description' : 'cp-description' }}"
                  class="nf-input" rows="3" placeholder="Opcionális leírás...">{{ old('description', $project?->description) }}</textarea>
    </div>
    <div>
        <label class="nf-label">Státusz</label>
        <select name="status" id="{{ isset($edit) ? 'ep-status' : 'cp-status' }}" class="nf-select">
            <option value="tervezes"      {{ old('status', $project?->status) === 'tervezes'      ? 'selected' : '' }}>Tervezés</option>
            <option value="aktiv"         {{ old('status', $project?->status) === 'aktiv'         ? 'selected' : '' }}>Aktív</option>
            <option value="felfuggesztve" {{ old('status', $project?->status) === 'felfuggesztve' ? 'selected' : '' }}>Felfüggesztve</option>
            <option value="lezart"        {{ old('status', $project?->status) === 'lezart'        ? 'selected' : '' }}>Lezárt</option>
        </select>
    </div>
    <div>
        <label class="nf-label">Prioritás</label>
        <select name="priority" id="{{ isset($edit) ? 'ep-priority' : 'cp-priority' }}" class="nf-select">
            <option value="alacsony" {{ old('priority', $project?->priority) === 'alacsony' ? 'selected' : '' }}>Alacsony</option>
            <option value="kozepes"  {{ old('priority', $project?->priority ?? 'kozepes') === 'kozepes' ? 'selected' : '' }}>Közepes</option>
            <option value="magas"    {{ old('priority', $project?->priority) === 'magas'    ? 'selected' : '' }}>Magas</option>
        </select>
    </div>
    <div>
        <label class="nf-label">Kezdési dátum</label>
        <input type="date" name="start_date" id="{{ isset($edit) ? 'ep-start' : 'cp-start' }}" class="nf-input"
               value="{{ old('start_date', $project?->start_date?->format('Y-m-d')) }}">
    </div>
    <div>
        <label class="nf-label">Határidő</label>
        <input type="date" name="end_date" id="{{ isset($edit) ? 'ep-end' : 'cp-end' }}" class="nf-input"
               value="{{ old('end_date', $project?->end_date?->format('Y-m-d')) }}">
    </div>
    <div style="grid-column:1/-1">
        <label class="nf-label">Felelős</label>
        <select name="responsible_id" id="{{ isset($edit) ? 'ep-responsible' : 'cp-responsible' }}" class="nf-select">
            <option value="">— Nincs hozzárendelve —</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ old('responsible_id', $project?->responsible_id) == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>
