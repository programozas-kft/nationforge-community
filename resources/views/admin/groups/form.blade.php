@extends('admin.layouts.app')

@section('title', $group->exists ? 'Csoport szerkesztése' : 'Új csoport')
@section('header', $group->exists ? 'Csoport szerkesztése' : 'Új csoport')
@section('breadcrumb')
    <a href="{{ route('admin.groups.index') }}">Csoportok</a>
    <span class="breadcrumb-sep">/</span>
    <span class="text-gray-700">{{ $group->exists ? 'Szerkesztés' : 'Új' }}</span>
@endsection

@section('content')
<div class="max-w-2xl">
    <form method="POST"
          action="{{ $group->exists ? route('admin.groups.update', $group) : route('admin.groups.store') }}">
        @csrf
        @if($group->exists) @method('PUT') @endif

        <div class="nf-card p-6 space-y-5">
            <div>
                <label class="nf-label">Csoport neve <span style="color:#f06548">*</span></label>
                <input type="text" name="name" value="{{ old('name', $group->name) }}"
                       class="nf-input {{ $errors->has('name') ? 'error' : '' }}">
                @error('name') <p class="nf-error">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="nf-label">Típus <span style="color:#f06548">*</span></label>
                    <select name="type" class="nf-select">
                        @foreach(['community','campaign','chapter','committee','team'] as $t)
                        <option value="{{ $t }}" @selected(old('type', $group->type) === $t)>{{ ucfirst($t) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="nf-label">Láthatóság <span style="color:#f06548">*</span></label>
                    <select name="privacy" class="nf-select">
                        @foreach(['public','private','secret'] as $p)
                        <option value="{{ $p }}" @selected(old('privacy', $group->privacy) === $p)>{{ ucfirst($p) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1"
                           @checked(old('is_active', $group->exists ? $group->is_active : true))
                           class="w-4 h-4 rounded" style="accent-color:#405189">
                    <span class="nf-label mb-0">Aktív csoport</span>
                </label>
            </div>

            <div>
                <label class="nf-label">Leírás</label>
                <textarea name="description" rows="4" class="nf-input resize-none">{{ old('description', $group->description) }}</textarea>
            </div>
        </div>

        <div class="flex items-center gap-3 mt-5">
            <button type="submit" class="btn-primary">
                {{ $group->exists ? 'Változtatások mentése' : 'Csoport létrehozása' }}
            </button>
            <a href="{{ $group->exists ? route('admin.groups.show', $group) : route('admin.groups.index') }}"
               class="btn-ghost">Mégse</a>
        </div>
    </form>
</div>
@endsection
