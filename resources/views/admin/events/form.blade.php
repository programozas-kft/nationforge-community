@extends('admin.layouts.app')

@section('title', $event->exists ? __('events.edit_title') : __('events.create_title'))
@section('header', $event->exists ? __('events.edit_title') : __('events.create_title'))
@section('breadcrumb')
    <a href="{{ route('admin.events.index') }}">{{ __('events.title') }}</a>
    <span class="breadcrumb-sep">/</span>
    <span class="text-gray-700">{{ $event->exists ? __('common.edit') : __('common.new') }}</span>
@endsection

@section('content')
<div class="max-w-2xl">
    <form method="POST"
          action="{{ $event->exists ? route('admin.events.update', $event) : route('admin.events.store') }}">
        @csrf
        @if($event->exists) @method('PUT') @endif

        <div class="nf-card p-6 space-y-5">
            <div>
                <label class="nf-label">{{ __('common.title_label') }} <span style="color:#f06548">*</span></label>
                <input type="text" name="title" value="{{ old('title', $event->title) }}"
                       class="nf-input {{ $errors->has('title') ? 'error' : '' }}">
                @error('title') <p class="nf-error">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="nf-label">{{ __('common.type') }} <span style="color:#f06548">*</span></label>
                    <select name="type" class="nf-select">
                        @foreach(['meetup','rally','webinar','fundraiser','volunteer','conference','other'] as $t)
                        <option value="{{ $t }}" @selected(old('type', $event->type) === $t)>{{ __('events.type.' . $t) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="nf-label">{{ __('common.status') }} <span style="color:#f06548">*</span></label>
                    <select name="status" class="nf-select">
                        @foreach(['draft','published','cancelled','completed'] as $s)
                        <option value="{{ $s }}" @selected(old('status', $event->status) === $s)>{{ __('events.status.' . $s) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="nf-label">{{ __('events.col_start') }} <span style="color:#f06548">*</span></label>
                    <input type="datetime-local" name="starts_at"
                           value="{{ old('starts_at', $event->starts_at?->format('Y-m-d\TH:i')) }}"
                           class="nf-input {{ $errors->has('starts_at') ? 'error' : '' }}">
                    @error('starts_at') <p class="nf-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="nf-label">{{ __('events.col_end') }}</label>
                    <input type="datetime-local" name="ends_at"
                           value="{{ old('ends_at', $event->ends_at?->format('Y-m-d\TH:i')) }}"
                           class="nf-input">
                </div>
            </div>

            <div>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="hidden" name="is_online" value="0">
                    <input type="checkbox" name="is_online" value="1"
                           @checked(old('is_online', $event->is_online))
                           class="w-4 h-4 rounded" style="accent-color:#405189">
                    <span class="nf-label mb-0">{{ __('events.is_online') }}</span>
                </label>
            </div>

            <div>
                <label class="nf-label">{{ __('events.online_url') }}</label>
                <input type="url" name="online_url" value="{{ old('online_url', $event->online_url) }}" class="nf-input">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="nf-label">{{ __('events.venue_name') }}</label>
                    <input type="text" name="venue_name" value="{{ old('venue_name', $event->venue_name) }}" class="nf-input">
                </div>
                <div>
                    <label class="nf-label">{{ __('common.city') }}</label>
                    <input type="text" name="city" value="{{ old('city', $event->city) }}" class="nf-input">
                </div>
            </div>

            <div>
                <label class="nf-label">{{ __('events.address') }}</label>
                <input type="text" name="address" value="{{ old('address', $event->address) }}" class="nf-input">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="nf-label">{{ __('events.capacity') }}</label>
                    <input type="number" name="capacity" min="1" value="{{ old('capacity', $event->capacity) }}" class="nf-input">
                </div>
                <div>
                    <label class="nf-label">{{ __('events.ticket_price') }}</label>
                    <input type="number" name="ticket_price" min="0" step="0.01" value="{{ old('ticket_price', $event->ticket_price) }}" class="nf-input">
                </div>
            </div>

            <div>
                <label class="nf-label">{{ __('common.description') }}</label>
                <textarea name="description" rows="4" class="nf-input resize-none">{{ old('description', $event->description) }}</textarea>
            </div>
        </div>

        <div class="flex items-center gap-3 mt-5">
            <button type="submit" class="btn-primary">
                {{ $event->exists ? __('common.save_changes') : __('events.new') }}
            </button>
            <a href="{{ $event->exists ? route('admin.events.show', $event) : route('admin.events.index') }}"
               class="btn-ghost">{{ __('common.cancel') }}</a>
        </div>
    </form>
</div>
@endsection
