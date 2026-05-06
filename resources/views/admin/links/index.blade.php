@extends('admin.layouts.app')

@section('title', __('links.title'))
@section('header', __('links.title'))
@section('breadcrumb') <span style="color:#495057">{{ __('links.title') }}</span> @endsection

@section('header-actions')
    <a href="{{ route('admin.settings') }}#links" class="btn-ghost" style="display:inline-flex;align-items:center;gap:6px">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/></svg>
        {{ __('links.manage') }}
    </a>
@endsection

@section('content')

@if($grouped->isEmpty())
<div class="nf-card" style="padding:60px;text-align:center">
    <svg width="40" height="40" fill="none" stroke="#dee2e6" viewBox="0 0 24 24" style="margin:0 auto 12px"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
    <p style="color:#adb5bd;font-size:0.9rem">{{ __('links.empty') }} <a href="{{ route('admin.settings') }}#links" style="color:#405189">{{ __('links.add_in_settings') }}</a></p>
</div>
@else

@foreach($grouped as $category => $catLinks)
<div style="margin-bottom:28px">
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px">
        <span style="font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:#878a99">{{ $category }}</span>
        <div style="flex:1;height:1px;background:#e9ebec"></div>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:14px">
        @foreach($catLinks->sortBy('sort_order') as $link)
        <a href="{{ $link->url }}" target="_blank" rel="noopener"
           class="nf-card"
           style="padding:18px 20px;text-decoration:none;display:flex;align-items:flex-start;gap:14px;transition:box-shadow 0.15s,transform 0.15s;cursor:pointer"
           onmouseover="this.style.boxShadow='0 4px 16px rgba(56,65,74,0.13)';this.style.transform='translateY(-1px)'"
           onmouseout="this.style.boxShadow='';this.style.transform=''">
            <div style="width:38px;height:38px;border-radius:9px;background:{{ $link->color }}1a;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <svg width="16" height="16" fill="none" stroke="{{ $link->color }}" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
            </div>
            <div style="flex:1;min-width:0">
                <p style="font-weight:600;font-size:0.875rem;color:#343a40;margin:0 0 3px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $link->title }}</p>
                @if($link->description)
                <p style="font-size:0.78rem;color:#878a99;margin:0 0 6px;line-height:1.4">{{ $link->description }}</p>
                @endif
                <span style="font-size:0.7rem;color:{{ $link->color }};background:{{ $link->color }}1a;padding:2px 8px;border-radius:20px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;display:inline-block;max-width:100%">
                    {{ parse_url($link->url, PHP_URL_HOST) ?? $link->url }}
                </span>
            </div>
            <svg width="13" height="13" fill="none" stroke="#adb5bd" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:2px"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
        </a>
        @endforeach
    </div>
</div>
@endforeach

@endif
@endsection
