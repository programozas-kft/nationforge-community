@extends('admin.layouts.app')

@section('title', $person->exists ? __('people.edit_title') : __('people.create_title'))
@section('header', $person->exists ? __('people.edit_title') : __('people.create_title'))
@section('breadcrumb')
    <a href="{{ route('admin.people.index') }}">{{ __('people.title') }}</a>
    <span class="breadcrumb-sep">/</span>
    <span class="text-gray-700">{{ $person->exists ? __('common.edit') : __('common.new') }}</span>
@endsection

@section('content')
<div class="max-w-2xl">
    <form method="POST"
          action="{{ $person->exists ? route('admin.people.update', $person) : route('admin.people.store') }}">
        @csrf
        @if($person->exists) @method('PUT') @endif

        <div class="nf-card p-6 space-y-5">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="nf-label">{{ __('people.last_name') }} <span style="color:#f06548">*</span></label>
                    <input type="text" name="last_name" value="{{ old('last_name', $person->last_name) }}"
                           class="nf-input {{ $errors->has('last_name') ? 'error' : '' }}">
                    @error('last_name') <p class="nf-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="nf-label">{{ __('people.first_name') }} <span style="color:#f06548">*</span></label>
                    <input type="text" name="first_name" value="{{ old('first_name', $person->first_name) }}"
                           class="nf-input {{ $errors->has('first_name') ? 'error' : '' }}">
                    @error('first_name') <p class="nf-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="nf-label">{{ __('common.email') }}</label>
                <input type="email" name="email" value="{{ old('email', $person->email) }}"
                       class="nf-input {{ $errors->has('email') ? 'error' : '' }}">
                @error('email') <p class="nf-error">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="nf-label">{{ __('common.phone') }}</label>
                    <input type="text" name="phone" value="{{ old('phone', $person->phone) }}" class="nf-input">
                </div>
                <div>
                    <label class="nf-label">{{ __('common.city') }}</label>
                    <input type="text" name="city" value="{{ old('city', $person->city) }}" class="nf-input">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="nf-label">{{ __('common.status') }} <span style="color:#f06548">*</span></label>
                    <select name="status" class="nf-select">
                        @foreach(['prospect','supporter','member','volunteer','donor','vip','inactive'] as $val)
                        <option value="{{ $val }}" @selected(old('status', $person->status) === $val)>{{ __('people.status.' . $val) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="nf-label">{{ __('people.source') }}</label>
                    <input type="text" name="source" value="{{ old('source', $person->source) }}" class="nf-input">
                </div>
            </div>

            <div>
                <label class="nf-label">{{ __('people.groups') }}</label>
                @php $selectedGroups = collect(old('groups', $person->exists ? $person->groups->pluck('id')->toArray() : [])); @endphp
                <div class="group-chip-wrap">
                    @forelse($groups as $group)
                        @php $checked = $selectedGroups->contains($group->id); @endphp
                        <label class="group-chip {{ $checked ? 'active' : '' }}">
                            <input type="checkbox" name="groups[]" value="{{ $group->id }}"
                                   {{ $checked ? 'checked' : '' }}
                                   onchange="this.closest('.group-chip').classList.toggle('active',this.checked)">
                            {{ $group->name }}
                        </label>
                    @empty
                        <span style="font-size:0.78rem;color:#adb5bd">{{ __('people.no_groups') }}</span>
                    @endforelse
                </div>
            </div>

            <div>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="hidden" name="is_subscribed" value="0">
                    <input type="checkbox" name="is_subscribed" value="1"
                           @checked(old('is_subscribed', $person->is_subscribed))
                           class="w-4 h-4 rounded" style="accent-color:#405189">
                    <span class="nf-label mb-0">{{ __('people.subscribed') }}</span>
                </label>
            </div>

            <div>
                <label class="nf-label">{{ __('common.notes') }}</label>
                <textarea name="notes" rows="3" class="nf-input resize-none">{{ old('notes', $person->notes) }}</textarea>
            </div>
        </div>

        <div class="flex items-center gap-3 mt-5">
            <button type="submit" class="btn-primary">
                {{ $person->exists ? __('common.save_changes') : __('people.new') }}
            </button>
            <a href="{{ $person->exists ? route('admin.people.show', $person) : route('admin.people.index') }}"
               class="btn-ghost">{{ __('common.cancel') }}</a>
        </div>
    </form>
</div>
@endsection
