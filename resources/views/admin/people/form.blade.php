@extends('admin.layouts.app')

@section('title', $person->exists ? 'Kapcsolat szerkesztése' : 'Új kapcsolat')
@section('header', $person->exists ? 'Kapcsolat szerkesztése' : 'Új kapcsolat')
@section('breadcrumb')
    <a href="{{ route('admin.people.index') }}">Kapcsolatok</a>
    <span class="breadcrumb-sep">/</span>
    <span class="text-gray-700">{{ $person->exists ? 'Szerkesztés' : 'Új' }}</span>
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
                    <label class="nf-label">Vezetéknév <span style="color:#f06548">*</span></label>
                    <input type="text" name="last_name" value="{{ old('last_name', $person->last_name) }}"
                           class="nf-input {{ $errors->has('last_name') ? 'error' : '' }}">
                    @error('last_name') <p class="nf-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="nf-label">Keresztnév <span style="color:#f06548">*</span></label>
                    <input type="text" name="first_name" value="{{ old('first_name', $person->first_name) }}"
                           class="nf-input {{ $errors->has('first_name') ? 'error' : '' }}">
                    @error('first_name') <p class="nf-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="nf-label">Email</label>
                <input type="email" name="email" value="{{ old('email', $person->email) }}"
                       class="nf-input {{ $errors->has('email') ? 'error' : '' }}">
                @error('email') <p class="nf-error">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="nf-label">Telefon</label>
                    <input type="text" name="phone" value="{{ old('phone', $person->phone) }}" class="nf-input">
                </div>
                <div>
                    <label class="nf-label">Város</label>
                    <input type="text" name="city" value="{{ old('city', $person->city) }}" class="nf-input">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="nf-label">Státusz <span style="color:#f06548">*</span></label>
                    <select name="status" class="nf-select">
                        @foreach(['prospect'=>'Érdeklődő','supporter'=>'Támogató','member'=>'Tag','volunteer'=>'Önkéntes','donor'=>'Adományozó','vip'=>'VIP','inactive'=>'Inaktív'] as $val=>$label)
                        <option value="{{ $val }}" @selected(old('status', $person->status) === $val)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="nf-label">Forrás</label>
                    <input type="text" name="source" value="{{ old('source', $person->source) }}" class="nf-input">
                </div>
            </div>

            <div>
                <label class="nf-label">Csoportok</label>
                <select name="groups[]" class="nf-input" multiple size="4" style="padding: 8px;">
                    @foreach($groups as $group)
                        <option value="{{ $group->id }}" 
                            {{ collect(old('groups', $person->exists ? $person->groups->pluck('id')->toArray() : []))->contains($group->id) ? 'selected' : '' }}>
                            {{ $group->name }}
                        </option>
                    @endforeach
                </select>
                <p class="text-[11px] text-gray-500 mt-1">Több csoport kiválasztásához tartsd lenyomva a Ctrl (Windows) vagy Cmd (Mac) gombot.</p>
            </div>

            <div>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="hidden" name="is_subscribed" value="0">
                    <input type="checkbox" name="is_subscribed" value="1"
                           @checked(old('is_subscribed', $person->is_subscribed))
                           class="w-4 h-4 rounded" style="accent-color:#405189">
                    <span class="nf-label mb-0">Hírlevél feliratkozó</span>
                </label>
            </div>

            <div>
                <label class="nf-label">Megjegyzés</label>
                <textarea name="notes" rows="3" class="nf-input resize-none">{{ old('notes', $person->notes) }}</textarea>
            </div>
        </div>

        <div class="flex items-center gap-3 mt-5">
            <button type="submit" class="btn-primary">
                {{ $person->exists ? 'Változtatások mentése' : 'Kapcsolat létrehozása' }}
            </button>
            <a href="{{ $person->exists ? route('admin.people.show', $person) : route('admin.people.index') }}"
               class="btn-ghost">Mégse</a>
        </div>
    </form>
</div>
@endsection
