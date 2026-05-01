@extends('admin.layouts.app')

@section('title', 'Beállítások')
@section('header', 'Beállítások')
@section('breadcrumb')
    <span style="color:#495057">Admin</span>
    <span style="color:#dee2e6">/</span>
    <span style="color:#495057">Beállítások</span>
@endsection

@section('content')
<div class="max-w-2xl" style="max-width:640px">
    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf

        {{-- Általános --}}
        <div class="nf-card p-6 mb-5" style="padding:24px;margin-bottom:20px">
            <h2 style="font-size:0.875rem;font-weight:600;color:#343a40;margin:0 0 16px;padding-bottom:12px;border-bottom:1px solid #e9ebec">
                Általános beállítások
            </h2>
            <div style="display:grid;gap:14px">
                <div>
                    <label class="nf-label">Rendszer neve</label>
                    <input type="text" name="app_name" value="{{ $settings['app_name'] }}" class="nf-input">
                </div>
                <div>
                    <label class="nf-label">Alkalmazás URL</label>
                    <input type="text" value="{{ $settings['app_url'] }}" class="nf-input" disabled style="background:#f8f9fa;color:#adb5bd">
                    <p style="font-size:0.72rem;color:#adb5bd;margin-top:4px">Az URL csak a .env fájlban módosítható.</p>
                </div>
                <div>
                    <label class="nf-label">Nyelv</label>
                    <input type="text" value="{{ $settings['app_locale'] }}" class="nf-input" disabled style="background:#f8f9fa;color:#adb5bd">
                </div>
            </div>
        </div>

        {{-- Email --}}
        <div class="nf-card p-6 mb-5" style="padding:24px;margin-bottom:20px">
            <h2 style="font-size:0.875rem;font-weight:600;color:#343a40;margin:0 0 16px;padding-bottom:12px;border-bottom:1px solid #e9ebec">
                Email beállítások
            </h2>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
                <div>
                    <label class="nf-label">Feladó neve</label>
                    <input type="text" name="mail_name" value="{{ $settings['mail_name'] }}" class="nf-input">
                </div>
                <div>
                    <label class="nf-label">Feladó email</label>
                    <input type="email" name="mail_from" value="{{ $settings['mail_from'] }}" class="nf-input">
                </div>
            </div>
        </div>

        {{-- Info kártyák --}}
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;margin-bottom:20px">
            <div class="nf-card" style="padding:16px;text-align:center">
                <p style="font-size:0.7rem;color:#adb5bd;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:4px">PHP verzió</p>
                <p style="font-weight:600;color:#343a40">{{ PHP_VERSION }}</p>
            </div>
            <div class="nf-card" style="padding:16px;text-align:center">
                <p style="font-size:0.7rem;color:#adb5bd;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:4px">Laravel</p>
                <p style="font-weight:600;color:#343a40">{{ app()->version() }}</p>
            </div>
            <div class="nf-card" style="padding:16px;text-align:center">
                <p style="font-size:0.7rem;color:#adb5bd;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:4px">Környezet</p>
                <p style="font-weight:600;color:#343a40">{{ app()->environment() }}</p>
            </div>
        </div>

        <div style="display:flex;gap:10px">
            <button type="submit" class="btn-teal">Beállítások mentése</button>
        </div>
    </form>
</div>
@endsection
