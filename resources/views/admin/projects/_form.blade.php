<div class="nf-modal-body" style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
    <div style="grid-column:1/-1">
        <label class="nf-label">{{ __('projects.project_name') }} <span style="color:#f06548">*</span></label>
        <input type="text" name="title" id="{{ isset($edit) ? 'ep-title' : 'cp-title' }}" class="nf-input"
               value="{{ old('title', $project?->title) }}" required>
    </div>
    <div style="grid-column:1/-1">
        <label class="nf-label">{{ __('common.description') }}</label>
        <textarea name="description" id="{{ isset($edit) ? 'ep-description' : 'cp-description' }}"
                  class="nf-input" rows="3">{{ old('description', $project?->description) }}</textarea>
    </div>
    <div>
        <label class="nf-label">{{ __('common.status') }}</label>
        <select name="status" id="{{ isset($edit) ? 'ep-status' : 'cp-status' }}" class="nf-select">
            <option value="tervezes"      {{ old('status', $project?->status) === 'tervezes'      ? 'selected' : '' }}>{{ __('projects.status.planning') }}</option>
            <option value="aktiv"         {{ old('status', $project?->status) === 'aktiv'         ? 'selected' : '' }}>{{ __('projects.status.active') }}</option>
            <option value="felfuggesztve" {{ old('status', $project?->status) === 'felfuggesztve' ? 'selected' : '' }}>{{ __('projects.status.on_hold') }}</option>
            <option value="lezart"        {{ old('status', $project?->status) === 'lezart'        ? 'selected' : '' }}>{{ __('projects.status.completed') }}</option>
        </select>
    </div>
    <div>
        <label class="nf-label">{{ __('projects.col_priority') }}</label>
        <select name="priority" id="{{ isset($edit) ? 'ep-priority' : 'cp-priority' }}" class="nf-select">
            <option value="alacsony" {{ old('priority', $project?->priority) === 'alacsony' ? 'selected' : '' }}>{{ __('projects.priority.low') }}</option>
            <option value="kozepes"  {{ old('priority', $project?->priority ?? 'kozepes') === 'kozepes' ? 'selected' : '' }}>{{ __('projects.priority.medium') }}</option>
            <option value="magas"    {{ old('priority', $project?->priority) === 'magas'    ? 'selected' : '' }}>{{ __('projects.priority.high') }}</option>
        </select>
    </div>
    <div>
        <label class="nf-label">{{ __('projects.start_date') }}</label>
        <input type="date" name="start_date" id="{{ isset($edit) ? 'ep-start' : 'cp-start' }}" class="nf-input"
               value="{{ old('start_date', $project?->start_date?->format('Y-m-d')) }}">
    </div>
    <div>
        <label class="nf-label">{{ __('projects.deadline') }}</label>
        <input type="date" name="end_date" id="{{ isset($edit) ? 'ep-end' : 'cp-end' }}" class="nf-input"
               value="{{ old('end_date', $project?->end_date?->format('Y-m-d')) }}">
    </div>
    <div style="grid-column:1/-1">
        <label class="nf-label">{{ __('projects.responsible') }}</label>
        <select name="responsible_id" id="{{ isset($edit) ? 'ep-responsible' : 'cp-responsible' }}" class="nf-select">
            <option value="">{{ __('projects.no_assignee') }}</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ old('responsible_id', $project?->responsible_id) == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>
