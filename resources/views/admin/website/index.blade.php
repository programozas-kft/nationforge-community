@extends('admin.layouts.app')

@section('title', 'Weboldal')
@section('header', 'Weboldal')
@section('breadcrumb')
    <span style="color:#495057">{{ __('common.admin') }}</span>
    <span style="color:#dee2e6">/</span>
    <span style="color:#495057">Weboldal</span>
@endsection

@section('content')

@if(session('success'))
<div style="background:#f0fff8;border:1px solid #c3f0e0;border-radius:8px;padding:12px 16px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:0.82rem;color:#0ab39c">
    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    {{ session('success') }}
</div>
@endif

<div class="nf-card">
    <div class="nf-card-header" style="display:flex;align-items:center;justify-content:space-between">
        <h2 class="nf-card-title">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="vertical-align:-3px;margin-right:6px"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
            Nyilvános főoldal tartalma
        </h2>
        <a href="{{ url('/') }}" target="_blank" class="btn-ghost" style="display:inline-flex;align-items:center;gap:6px;font-size:0.8rem">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            Weboldal megtekintése
        </a>
    </div>
    <div class="nf-card-body" style="padding:24px">
        <form method="POST" action="{{ route('admin.settings.website') }}" enctype="multipart/form-data">
            @csrf
            <div style="max-width:860px">

                {{-- Főüzenetek --}}
                <div style="margin-bottom:20px">
                    <label class="nf-label">Főcím (hero üzenet) <span style="color:#f06548">*</span></label>
                    <input type="text" name="hero_title" class="nf-input" value="{{ old('hero_title', $websiteConfig['hero_title']) }}" placeholder="pl. Találd meg önmagad útját" required>
                </div>

                <div style="margin-bottom:20px">
                    <label class="nf-label">Alcím / mottó</label>
                    <input type="text" name="hero_subtitle" class="nf-input" value="{{ old('hero_subtitle', $websiteConfig['hero_subtitle']) }}" placeholder="pl. Lélekközpontú coaching és tanácsadás">
                </div>

                {{-- Hero kép --}}
                <div style="margin-bottom:20px">
                    <label class="nf-label">Háttérkép a főoldalon (hero szekció)</label>
                    @if($websiteConfig['hero_image'])
                    <div style="margin-bottom:10px;position:relative;display:inline-block">
                        <img id="hero-preview" src="{{ asset('storage/'.$websiteConfig['hero_image']) }}"
                             style="max-width:100%;max-height:180px;border-radius:8px;border:1px solid #dee2e6;display:block">
                        <span style="position:absolute;top:6px;right:6px;background:rgba(0,0,0,.45);color:#fff;font-size:0.7rem;padding:2px 8px;border-radius:4px">Jelenlegi kép</span>
                    </div>
                    @else
                    <div id="hero-preview-wrap" style="display:none;margin-bottom:10px">
                        <img id="hero-preview" style="max-width:100%;max-height:180px;border-radius:8px;border:1px solid #dee2e6;display:block">
                    </div>
                    @endif
                    <input type="file" name="hero_image" accept="image/jpeg,image/png,image/webp"
                           style="font-size:0.82rem;color:#495057"
                           onchange="previewHero(this)">
                    <div style="font-size:0.72rem;color:#adb5bd;margin-top:4px">JPG, PNG, WEBP · max 4 MB · Ajánlott méret: 1400×600 px</div>
                    @if($websiteConfig['hero_image'])
                    <label style="display:flex;align-items:center;gap:6px;margin-top:8px;font-size:0.78rem;color:#f06548;cursor:pointer">
                        <input type="checkbox" name="remove_hero_image" value="1" style="accent-color:#f06548">
                        Kép törlése
                    </label>
                    @endif
                </div>

                <div style="margin-bottom:20px">
                    <label class="nf-label">Rövid bemutatkozás</label>
                    <textarea name="intro" class="nf-input" rows="4" placeholder="2-3 mondatos bemutatkozó szöveg...">{{ old('intro', $websiteConfig['intro']) }}</textarea>
                </div>

                <hr style="border:none;border-top:1px solid #e8eaf2;margin:24px 0">

                {{-- Kinek segítesz --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px">
                    <div>
                        <label class="nf-label">„Kinek segítesz?" – cím</label>
                        <input type="text" name="who_title" class="nf-input" value="{{ old('who_title', $websiteConfig['who_title']) }}" placeholder="pl. Neked szól ez az oldal, ha...">
                    </div>
                    <div>
                        <label class="nf-label">„Kinek segítesz?" – leírás</label>
                        <textarea name="who_text" class="nf-input" rows="4" placeholder="Írj 3-5 sort arról, kinek ajánlod a szolgáltatásod...">{{ old('who_text', $websiteConfig['who_text']) }}</textarea>
                    </div>
                </div>

                {{-- Problémák + Szolgáltatások --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px">
                    <div>
                        <label class="nf-label">Problémák <span style="color:#6c757d;font-weight:400">(soronként 1)</span></label>
                        <textarea name="problems" class="nf-input" rows="6" placeholder="Elveszettnek érzed magad&#10;Párkapcsolati nehézségek&#10;Önbizalomhiány&#10;Burnout, kiégés">{{ old('problems', $websiteConfig['problems']) }}</textarea>
                        <div class="nf-hint">Minden sor egy kártya lesz a weboldalon</div>
                    </div>
                    <div>
                        <label class="nf-label">Szolgáltatások <span style="color:#6c757d;font-weight:400">(Cím | Leírás)</span></label>
                        <textarea name="services" class="nf-input" rows="6" placeholder="Egyéni coaching | 60 perces személyes ülések&#10;Páros tanácsadás | Kapcsolati harmónia&#10;Online konzultáció | Bárhonnan elérhető">{{ old('services', $websiteConfig['services']) }}</textarea>
                        <div class="nf-hint">Formátum: Cím | Leírás (cső karakterrel elválasztva)</div>
                    </div>
                </div>

                <hr style="border:none;border-top:1px solid #e8eaf2;margin:24px 0">

                {{-- Időpontfoglalás + Megjelenítési beállítások --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px">
                    <div>
                        <label class="nf-label">Időpontfoglalás gomb felirata</label>
                        <input type="text" name="booking_label" class="nf-input" value="{{ old('booking_label', $websiteConfig['booking_label']) }}" placeholder="Időpontfoglalás">
                    </div>
                    <div>
                        <label class="nf-label">Időpontfoglalás URL <span style="color:#6c757d;font-weight:400">(pl. Calendly)</span></label>
                        <input type="url" name="booking_url" class="nf-input" value="{{ old('booking_url', $websiteConfig['booking_url']) }}" placeholder="https://calendly.com/...">
                    </div>
                    <div style="display:flex;flex-direction:column;gap:12px;justify-content:flex-end;padding-bottom:4px">
                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                            <input type="checkbox" name="show_events" value="1" {{ $websiteConfig['show_events'] ? 'checked' : '' }}>
                            <span class="nf-label" style="margin:0">Közelgő események megjelenítése</span>
                        </label>
                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                            <input type="checkbox" name="show_testimonials" value="1" {{ $websiteConfig['show_testimonials'] ? 'checked' : '' }}>
                            <span class="nf-label" style="margin:0">Visszajelzések megjelenítése</span>
                        </label>
                    </div>
                </div>

                <div style="display:flex;align-items:center;gap:12px;margin-top:8px">
                    <button type="submit" class="btn-teal">Weboldal beállítások mentése</button>
                </div>

            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function previewHero(input) {
    if (!input.files || !input.files[0]) return;
    const wrap = document.getElementById('hero-preview-wrap');
    const img  = document.getElementById('hero-preview');
    const reader = new FileReader();
    reader.onload = e => {
        if (img) img.src = e.target.result;
        if (wrap) wrap.style.display = 'block';
    };
    reader.readAsDataURL(input.files[0]);
}
</script>
@endpush
