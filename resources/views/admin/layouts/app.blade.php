<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') | NationForge</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icons@7.2.3/css/flag-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @php
        $brandPrimary = \App\Models\Setting::get('brand_primary_color', '#405189');
        $brandDark    = \App\Models\Setting::darken($brandPrimary, 15);
        $brandDeep    = \App\Models\Setting::darken($brandPrimary, 40);
        $brandOrgName = \App\Models\Setting::get('brand_org_name', config('app.name'));
        $brandLogo    = \App\Models\Setting::get('brand_logo');
    @endphp
    <style>
        *, *::before, *::after { box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: #f3f3f9; margin: 0; padding: 0; }

        /* ── SIDEBAR ─────────────────────────────────── */
        /* ── QUICK LINKS BAR ─────────────────────────── */
        #quicklinks-bar {
            height: 38px;
            background: {{ $brandDeep }};
            display: flex;
            align-items: center;
            padding: 0 16px;
            gap: 4px;
            flex-shrink: 0;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .ql-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 5px;
            text-decoration: none;
            color: rgba(255,255,255,0.65);
            font-size: 0.72rem;
            font-weight: 500;
            transition: background 0.15s, color 0.15s;
            white-space: nowrap;
        }
        .ql-link:hover { background: rgba(255,255,255,0.1); color: #fff; }
        .ql-sep { width: 1px; height: 18px; background: rgba(255,255,255,0.1); margin: 0 4px; }

        #sidebar {
            width: 250px;
            min-width: 250px;
            background: linear-gradient(180deg, {{ $brandPrimary }} 0%, {{ $brandDark }} 100%);
            display: flex;
            flex-direction: column;
            height: calc(100vh - 38px);
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,0.08) transparent;
        }
        #sidebar::-webkit-scrollbar { width: 4px; }
        #sidebar::-webkit-scrollbar-track { background: transparent; }
        #sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.08); border-radius: 4px; }

        /* Brand */
        .sb-brand {
            display: flex; align-items: center; gap: 10px;
            padding: 22px 20px 18px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .sb-logo-icon {
            width: 34px; height: 34px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .sb-brand-name { color: #fff; font-size: 1.1rem; font-weight: 700; letter-spacing: 0.02em; }

        /* Section label */
        .sb-section {
            font-size: 0.625rem; font-weight: 700;
            letter-spacing: 0.1em; text-transform: uppercase;
            color: #5a6587; padding: 20px 20px 6px;
        }

        /* Nav item (top-level) */
        .sb-item {
            display: flex; align-items: center;
            padding: 9px 12px 9px 16px;
            margin: 1px 10px;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.15s, color 0.15s;
            text-decoration: none;
            color: #8a94b8;
            font-size: 0.8125rem;
            font-weight: 500;
            user-select: none;
        }
        .sb-item:hover { background: rgba(255,255,255,0.1); color: #fff; }
        .sb-item.active { background: rgba(255,255,255,0.2); color: #fff; }
        .sb-item.open   { background: rgba(255,255,255,0.08); color: #e8e4ff; }

        .sb-item-icon {
            width: 16px; height: 16px; flex-shrink: 0;
            opacity: 0.7;
        }
        .sb-item.active .sb-item-icon { opacity: 1; color: {{ $brandPrimary }}; }
        .sb-item.active_SKIP .sb-item-icon,
        .sb-item:hover  .sb-item-icon { opacity: 1; }

        .sb-item-text { flex: 1; margin-left: 10px; }

        .sb-item-badge {
            font-size: 0.6rem; font-weight: 700; padding: 2px 6px;
            border-radius: 4px; letter-spacing: 0.04em; text-transform: uppercase;
            margin-right: 6px;
        }
        .badge-new  { background: rgba(10,179,156,0.2);  color: #0ab39c; }
        .badge-hot  { background: rgba(240,101,72,0.2);  color: #f06548; }

        .sb-arrow {
            width: 14px; height: 14px; flex-shrink: 0;
            transition: transform 0.2s;
            opacity: 0.5;
        }
        .sb-item.open .sb-arrow { transform: rotate(90deg); }

        /* Sub-menu */
        .sb-sub {
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.25s ease;
        }
        .sb-sub.open { max-height: 500px; }

        .sb-sub-item {
            display: flex; align-items: center; gap: 8px;
            padding: 7px 16px 7px 44px;
            margin: 1px 10px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 400;
            color: #7a84a8;
            text-decoration: none;
            transition: background 0.15s, color 0.15s;
        }
        .sb-sub-item::before {
            content: '';
            width: 5px; height: 5px;
            border-radius: 50%;
            background: currentColor;
            flex-shrink: 0;
            opacity: 0.4;
            transition: opacity 0.15s, background 0.15s;
        }
        .sb-sub-item:hover { background: rgba(255,255,255,0.05); color: #c8cedf; }
        .sb-sub-item:hover::before { opacity: 0.8; }
        .sb-sub-item.active { color: #fff; font-weight: 500; }
        .sb-sub-item.active::before { background: #fff; opacity: 1; }

        /* User at bottom */
        .sb-user {
            margin-top: auto;
            border-top: 1px solid rgba(255,255,255,0.08);
            padding: 12px 10px;
        }
        .sb-user-card {
            display: flex; align-items: center; gap: 10px;
            padding: 8px 10px; border-radius: 8px;
            background: rgba(255,255,255,0.1);
            margin-bottom: 4px;
        }
        .sb-avatar {
            width: 32px; height: 32px; border-radius: 50%;
            background: linear-gradient(135deg, #f97316, #ea580c);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 0.75rem; font-weight: 700; flex-shrink: 0;
        }
        .sb-user-name { color: #c8cedf; font-size: 0.8rem; font-weight: 500; }
        .sb-user-role { color: #5a6587; font-size: 0.7rem; }
        .sb-logout {
            display: flex; align-items: center; gap: 8px;
            padding: 7px 10px; border-radius: 6px; margin: 0;
            color: #7a84a8; font-size: 0.8rem; cursor: pointer;
            background: none; border: none; width: 100%;
            transition: background 0.15s, color 0.15s;
        }
        .sb-logout:hover { background: rgba(240,101,72,0.08); color: #f06548; }

        /* ── TOPBAR ──────────────────────────────────── */
        #topbar {
            height: 60px;
            background: #fff;
            border-bottom: 1px solid #e9ebec;
            box-shadow: 0 1px 10px rgba(58,53,65,0.06);
            display: flex; align-items: center; padding: 0 24px; gap: 12px; flex-shrink: 0;
        }
        .tb-breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 0.78rem; color: #adb5bd; }
        .tb-breadcrumb a { color: #adb5bd; text-decoration: none; }
        .tb-breadcrumb a:hover { color: #405189; }
        .tb-page-title { font-size: 0.875rem; font-weight: 600; color: #343a40; line-height: 1.2; }

        /* ── CARDS & TABLE ───────────────────────────── */
        .nf-card { background: #fff; border-radius: 8px; box-shadow: 0 1px 2px rgba(56,65,74,0.12); border: 1px solid #e9ebec; }
        .nf-card-header { padding: 14px 20px; border-bottom: 1px solid #e9ebec; font-size: 0.875rem; font-weight: 600; color: #343a40; display: flex; align-items: center; justify-content: space-between; }

        .nf-table { width: 100%; border-collapse: collapse; font-size: 0.8125rem; }
        .nf-table thead th { padding: 10px 16px; background: #f8f9fa; border-bottom: 1px solid #e9ebec; font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: #6c757d; text-align: left; white-space: nowrap; }
        .nf-table tbody td { padding: 12px 16px; border-bottom: 1px solid #f3f3f9; color: #495057; vertical-align: middle; }
        .nf-table tbody tr:last-child td { border-bottom: none; }
        .nf-table tbody tr:hover td { background: #fafafa; }

        /* Badges */
        .nf-badge { display: inline-flex; align-items: center; padding: 3px 8px; border-radius: 4px; font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.02em; }
        .badge-success  { background: rgba(10,179,156,0.12);  color: #0ab39c; }
        .badge-warning  { background: rgba(247,184,75,0.12);  color: #c9920a; }
        .badge-danger   { background: rgba(240,101,72,0.12);  color: #f06548; }
        .badge-info     { background: rgba(41,156,219,0.12);  color: #299cdb; }
        .badge-secondary{ background: rgba(108,117,125,0.12); color: #6c757d; }
        .badge-primary  { background: rgba(64,81,137,0.12);   color: #405189; }
        .badge-purple   { background: rgba(122,90,248,0.12);  color: #7a5af8; }

        /* Buttons */
        .btn-primary { display: inline-flex; align-items: center; gap: 5px; padding: 7px 16px; background: #405189; color: #fff; border: none; border-radius: 5px; font-size: 0.8125rem; font-weight: 500; cursor: pointer; text-decoration: none; transition: background 0.2s; }
        .btn-primary:hover { background: #374776; }
        .btn-danger  { display: inline-flex; align-items: center; gap: 5px; padding: 7px 16px; background: #f06548; color: #fff; border: none; border-radius: 5px; font-size: 0.8125rem; font-weight: 500; cursor: pointer; transition: background 0.2s; }
        .btn-danger:hover  { background: #d9533a; }
        .btn-ghost   { display: inline-flex; align-items: center; gap: 5px; padding: 7px 16px; background: transparent; color: #6c757d; border: 1px solid #ced4da; border-radius: 5px; font-size: 0.8125rem; font-weight: 500; cursor: pointer; text-decoration: none; transition: all 0.2s; }
        .btn-ghost:hover   { background: #f8f9fa; color: #343a40; }

        /* Forms */
        .nf-label  { display: block; font-size: 0.8125rem; font-weight: 500; color: #495057; margin-bottom: 5px; }
        .nf-input  { display: block; width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 5px; font-size: 0.8125rem; color: #343a40; outline: none; transition: border-color 0.2s, box-shadow 0.2s; background: #fff; }
        .nf-input:focus  { border-color: #405189; box-shadow: 0 0 0 3px rgba(64,81,137,0.1); }
        .nf-input.error  { border-color: #f06548; }
        .nf-select { display: block; width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 5px; font-size: 0.8125rem; color: #343a40; outline: none; background: #fff; cursor: pointer; }
        .nf-select:focus { border-color: #405189; box-shadow: 0 0 0 3px rgba(64,81,137,0.1); }
        .nf-error  { font-size: 0.72rem; color: #f06548; margin-top: 3px; }

        /* Alerts */
        .alert-success { background: rgba(10,179,156,0.1); border: 1px solid rgba(10,179,156,0.25); color: #0a7564; border-radius: 6px; padding: 12px 16px; font-size: 0.8125rem; display: flex; align-items: center; gap: 8px; }
        .alert-error   { background: rgba(240,101,72,0.1);  border: 1px solid rgba(240,101,72,0.25);  color: #c0432a; border-radius: 6px; padding: 12px 16px; font-size: 0.8125rem; }

        /* Stat icon circle */
        .stat-icon { width: 52px; height: 52px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }

        /* ── MODAL ───────────────────────────────────── */
        .nf-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.45); z-index: 1000;
            align-items: flex-start; justify-content: center;
            padding-top: 60px; padding-bottom: 40px;
            overflow-y: auto;
        }
        .nf-overlay.open { display: flex; }
        .nf-modal {
            background: #fff; border-radius: 10px;
            box-shadow: 0 8px 40px rgba(0,0,0,0.18);
            width: 100%; max-width: 520px;
            margin: auto;
            animation: modalIn 0.18s ease;
        }
        .nf-modal-lg { max-width: 680px; }
        @keyframes modalIn {
            from { opacity: 0; transform: translateY(-16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .nf-modal-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 20px; border-bottom: 1px solid #e9ebec;
        }
        .nf-modal-title { font-size: 0.9375rem; font-weight: 600; color: #343a40; }
        .nf-modal-close {
            width: 28px; height: 28px; border-radius: 50%;
            background: none; border: none; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            color: #6c757d; transition: background 0.15s, color 0.15s;
        }
        .nf-modal-close:hover { background: #f3f3f9; color: #343a40; }
        .nf-modal-body { padding: 20px; }
        .nf-modal-footer {
            display: flex; align-items: center; justify-content: flex-end; gap: 8px;
            padding: 14px 20px; border-top: 1px solid #e9ebec;
        }
        .btn-teal { display: inline-flex; align-items: center; gap: 5px; padding: 7px 20px; background: #0ab39c; color: #fff; border: none; border-radius: 5px; font-size: 0.8125rem; font-weight: 500; cursor: pointer; transition: background 0.2s; }
        .btn-teal:hover { background: #099d89; }

        /* ── PAGINATION ──────────────────────────────── */
        /* Pagination */
        nav[aria-label="pagination"] { display: flex; justify-content: flex-end; }
        .pagination { display: flex; gap: 3px; list-style: none; padding: 0; margin: 0; }
        .pagination li span, .pagination li a { display: flex; align-items: center; justify-content: center; min-width: 32px; height: 32px; padding: 0 8px; border-radius: 4px; font-size: 0.8rem; border: 1px solid #e9ebec; color: #495057; text-decoration: none; }
        .pagination li span[aria-current] { background: #405189; color: #fff; border-color: #405189; }
        .pagination li a:hover { background: #f3f3f9; }
        .pagination li span.cursor-default { color: #ced4da; }
        .group-chip { display:inline-flex;align-items:center;padding:5px 12px;border-radius:20px;border:1.5px solid #dee2e6;cursor:pointer;font-size:0.78rem;font-weight:500;color:#6c757d;background:#fff;user-select:none;transition:background 0.15s,color 0.15s,border-color 0.15s; }
        .group-chip input[type=checkbox] { display:none; }
        .group-chip:has(input:checked), .group-chip.active { background:#405189;border-color:#405189;color:#fff; }
        .group-chip-wrap { display:flex;flex-wrap:wrap;gap:6px;padding:4px 0; }
    </style>
</head>
<body class="flex flex-col h-screen overflow-hidden">

<!-- ── QUICK LINKS BAR ──────────────────────────────────── -->
<div id="quicklinks-bar">
    <a href="https://www.youtube.com/@programozaskft.7617" class="ql-link" title="YouTube" target="_blank" rel="noopener">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" style="color:#ff4444"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
        YouTube
    </a>
    <div class="ql-sep"></div>
    <a href="https://drive.google.com/drive/home" class="ql-link" title="Google Drive" target="_blank" rel="noopener">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M6.28 15.5L2 21h20l-4.28-5.5H6.28z" fill="#34a853"/><path d="M12 3L6.28 15.5h11.44L12 3z" fill="#4285f4"/><path d="M2 21l4.28-5.5L9.5 10.25 6 3.5 2 21z" fill="#ea4335"/><path d="M22 21l-4.28-5.5L14.5 10.25 18 3.5 22 21z" fill="#fbbc05"/></svg>
        Google Drive
    </a>
    <div class="ql-sep"></div>
    <a href="https://www.instagram.com/" class="ql-link" title="Instagram" target="_blank" rel="noopener">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><defs><linearGradient id="ig" x1="0%" y1="100%" x2="100%" y2="0%"><stop offset="0%" stop-color="#f09433"/><stop offset="25%" stop-color="#e6683c"/><stop offset="50%" stop-color="#dc2743"/><stop offset="75%" stop-color="#cc2366"/><stop offset="100%" stop-color="#bc1888"/></linearGradient></defs><rect width="24" height="24" rx="5" fill="url(#ig)"/><circle cx="12" cy="12" r="4" stroke="white" stroke-width="1.8" fill="none"/><circle cx="17.5" cy="6.5" r="1.2" fill="white"/></svg>
        Instagram
    </a>
    <div class="ql-sep"></div>
    <a href="{{ route('admin.links.index') }}" class="ql-link" title="Linkgyűjtemény">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
        Linkgyűjtemény
    </a>
    <div class="ql-sep"></div>
    <a href="https://www.google.com/search?sca_esv=251dd46310ce0ad5&sxsrf=ANbL-n6CmNz351akdfQzcO5UJULZ6sqnIQ:1778018034720&q=politika&tbm=nws&source=lnms&fbs=ADc_l-akmJ9clyHhwEynr9YRwEo_tYQUWp-_aNxOcHgKpLE-YakERkcbs6Kn6Gcb3l6NkpKNzdhKBzjJMiz30jhymdjvVskm-pN0JMxNkIz3eFGoXlKh4mWojQ-wyW8oHkvbANGh_pTu9t0VlzYEU5uSy7lVCoG8AOh8hc-akVwIGhCfgOr-8hQQ21mOm7q3J2q-7yb7xyt98J8ddCbrba6fngPkBKDfzw&sa=X&ved=2ahUKEwjllvSqkaOUAxWjLhAIHRUUJ-QQ0pQJegQIFBAB&biw=2327&bih=835&dpr=1.1" class="ql-link" title="Hírek" target="_blank" rel="noopener">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
        Hírek
    </a>
    <div class="ql-sep"></div>
    <a href="https://www.google.com/search?sca_esv=251dd46310ce0ad5&sxsrf=ANbL-n7JyXyV5Tb7Lk-02vfx5nf93qU6KA:1778018159078&udm=2&fbs=ADc_l-akmJ9clyHhwEynr9YRwEo_tYQUWp-_aNxOcHgKpLE-YUy1rF_kA3bn_mrSgXcgNhn0lG9RN80gRMxP-A2NGIg7J5gdlXV5DDIdWAtC8_mhvQnkIxyhtygqnoA_m3HeMsLSHOwfkzZM2HV80UYo_RGTOT837TXzL51f_J7HTRRFPNXaGhMgIgtGDYL0incoudsXW1kq&q=Infografika&sa=X&ved=2ahUKEwiHsprmkaOUAxVxFBAIHb3GJ3EQtKgLegQILBAB&biw=2327&bih=835&dpr=1.1" class="ql-link" title="Infografikonok" target="_blank" rel="noopener">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
        Infografikonok
    </a>
    <div class="ql-sep"></div>
    <a href="{{ route('admin.sugo') }}" class="ql-link" title="{{ __('nav.help') }}" target="_blank">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ __('nav.help') }}
    </a>
</div>

<!-- ── LAYOUT WRAPPER ────────────────────────────────────── -->
<div class="flex flex-1 overflow-hidden">

<!-- ── SIDEBAR ─────────────────────────────────────────── -->
<aside id="sidebar">

    <!-- Brand -->
    <a href="{{ route('admin.dashboard') }}" class="sb-brand" style="text-decoration:none">
        <div class="sb-logo-icon">
            @if($brandLogo)
                <img src="{{ asset('storage/' . $brandLogo) }}" alt="{{ $brandOrgName }}"
                     style="width:34px;height:34px;object-fit:contain;border-radius:4px">
            @else
                <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <polygon points="17,2 31,9.5 31,24.5 17,32 3,24.5 3,9.5" fill="#1a2a5e" stroke="#6b8cda" stroke-width="1.5"/>
                    <text x="17" y="23" text-anchor="middle" font-family="Inter,sans-serif" font-size="16" font-weight="700" fill="white">N</text>
                </svg>
            @endif
        </div>
        <span class="sb-brand-name">{{ $brandOrgName }}</span>
    </a>

    <!-- MENU section -->
    <div class="sb-section">{{ __('nav.menu') }}</div>

    <!-- Dashboard -->
    <a href="{{ route('admin.dashboard') }}"
       class="sb-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <svg class="sb-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
        <span class="sb-item-text">{{ __('nav.dashboard') }}</span>
    </a>

    <!-- Contacts -->
    <a href="{{ route('admin.people.index') }}"
       class="sb-item {{ request()->routeIs('admin.people.*') ? 'active' : '' }}">
        <svg class="sb-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        <span class="sb-item-text">{{ __('nav.contacts') }}</span>
        <span class="sb-item-badge" style="background:rgba(255,255,255,0.1); color:#c8cedf;">{{ \App\Models\Person::count() }}</span>
    </a>

    <!-- Groups -->
    <a href="{{ route('admin.groups.index') }}"
       class="sb-item {{ request()->routeIs('admin.groups.*') ? 'active' : '' }}">
        <svg class="sb-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
        <span class="sb-item-text">{{ __('nav.groups') }}</span>
        <span class="sb-item-badge" style="background:rgba(255,255,255,0.1); color:#c8cedf;">{{ \App\Models\Group::count() }}</span>
    </a>

    <!-- Organizing section -->
    <div class="sb-section">{{ __('nav.organizing') }}</div>

    <!-- Events -->
    <a href="{{ route('admin.events.index') }}"
       class="sb-item {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
        <svg class="sb-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        <span class="sb-item-text">{{ __('nav.events') }}</span>
        <span class="sb-item-badge" style="background:rgba(255,255,255,0.1); color:#c8cedf;">{{ \App\Models\Event::count() }}</span>
    </a>

    <!-- Donations -->
    <a href="{{ route('admin.donations.index') }}"
       class="sb-item {{ request()->routeIs('admin.donations.*') ? 'active' : '' }}">
        <svg class="sb-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span class="sb-item-text">{{ __('nav.donations') }}</span>
        <span class="sb-item-badge" style="background:rgba(255,255,255,0.1); color:#c8cedf;">{{ \App\Models\Donation::count() }}</span>
    </a>

    <!-- Projects -->
    <a href="{{ route('admin.projects.index') }}"
       class="sb-item {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
        <svg class="sb-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
        <span class="sb-item-text">{{ __('nav.projects') }}</span>
        <span class="sb-item-badge" style="background:rgba(255,255,255,0.1); color:#c8cedf;">{{ \App\Models\Project::count() }}</span>
    </a>

    <!-- Tasks -->
    <a href="{{ route('admin.tasks.index') }}"
       class="sb-item {{ request()->routeIs('admin.tasks.*') ? 'active' : '' }}">
        <svg class="sb-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
        <span class="sb-item-text">{{ __('nav.tasks') }}</span>
        @php $openTasks = \App\Models\Task::whereIn('status',['nyitott','folyamatban'])->count(); @endphp
        @if($openTasks > 0)
            <span class="sb-item-badge badge-new" style="margin-right:0;">{{ $openTasks }} {{ __('nav.open_tasks') }}</span>
        @endif
        <span class="sb-item-badge" style="background:rgba(255,255,255,0.1); color:#c8cedf; margin-left:6px;">{{ \App\Models\Task::count() }}</span>
    </a>

    <!-- Campaigns -->
    <a href="{{ route('admin.campaigns.index') }}"
       class="sb-item {{ request()->routeIs('admin.campaigns.*') || request()->routeIs('admin.email-templates.*') ? 'active' : '' }}">
        <svg class="sb-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        <span class="sb-item-text">{{ __('nav.campaigns') }}</span>
        <span class="sb-item-badge" style="background:rgba(255,255,255,0.1); color:#c8cedf;">{{ \App\Models\EmailCampaign::count() }}</span>
    </a>

    <!-- Drip Campaigns -->
    <a href="{{ route('admin.drip-campaigns.index') }}"
       class="sb-item {{ request()->routeIs('admin.drip-campaigns.*') ? 'active' : '' }}" style="padding-left:32px">
        <svg class="sb-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
        <span class="sb-item-text">{{ __('nav.drip_campaigns') }}</span>
        <span class="sb-item-badge" style="background:rgba(255,255,255,0.1); color:#c8cedf;">{{ \App\Models\DripCampaign::count() }}</span>
    </a>

    <!-- Administration section -->
    <div class="sb-section">{{ __('nav.administration') }}</div>

    @if(auth()->user()->isStrictAdmin())
    <!-- Users -->
    <a href="{{ route('admin.users.index') }}"
       class="sb-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <svg class="sb-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        <span class="sb-item-text">{{ __('nav.users') }}</span>
        <span class="sb-item-badge" style="background:rgba(255,255,255,0.1); color:#c8cedf;">{{ \App\Models\User::count() }}</span>
    </a>

    <!-- Audit log -->
    <a href="{{ route('admin.audit') }}"
       class="sb-item {{ request()->routeIs('admin.audit') ? 'active' : '' }}">
        <svg class="sb-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
        <span class="sb-item-text">{{ __('nav.audit') }}</span>
    </a>

    <!-- Settings -->
    <a href="{{ route('admin.settings') }}"
       class="sb-item {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
        <svg class="sb-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        <span class="sb-item-text">{{ __('nav.settings') }}</span>
    </a>
    @endif

    <!-- Changelog -->
    <a href="{{ route('admin.changelog') }}"
       class="sb-item {{ request()->routeIs('admin.changelog') ? 'active' : '' }}">
        <svg class="sb-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        <span class="sb-item-text">{{ __('nav.changelog') }}</span>
    </a>

    <!-- Help -->
    <a href="{{ route('admin.help.index') }}"
       class="sb-item {{ request()->routeIs('admin.help*') ? 'active' : '' }}">
        <svg class="sb-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span class="sb-item-text">{{ __('nav.help') }}</span>
        <span class="sb-item-badge" style="background:rgba(255,255,255,0.1); color:#c8cedf;">{{ \App\Models\HelpArticle::count() }}</span>
    </a>

    <!-- User + language switcher -->
    <div class="sb-user">
        <!-- Language switcher -->
        <div style="display:flex;gap:4px;margin-bottom:8px;padding:0 2px;flex-wrap:wrap">
            @foreach([
                'hu' => ['flag' => 'fi-hu', 'label' => 'HU'],
                'en' => ['flag' => 'fi-gb', 'label' => 'EN'],
                'de' => ['flag' => 'fi-de', 'label' => 'DE'],
                'ro' => ['flag' => 'fi-ro', 'label' => 'RO'],
                'sk' => ['flag' => 'fi-sk', 'label' => 'SK'],
            ] as $loc => $info)
            <a href="{{ route('locale.switch', $loc) }}"
               style="flex:1;min-width:28%;text-align:center;padding:5px;border-radius:5px;font-size:0.72rem;font-weight:600;text-decoration:none;
                      {{ app()->getLocale() === $loc ? 'background:rgba(255,255,255,0.2);color:#fff' : 'color:#5a6587' }}">
                <span class="fi {{ $info['flag'] }}" style="border-radius:2px"></span> {{ $info['label'] }}
            </a>
            @endforeach
        </div>

        <div class="sb-user-card">
            @if(auth()->user()->photo)
                <div class="sb-avatar" style="padding:0;overflow:hidden">
                    <img src="{{ asset('storage/' . auth()->user()->photo) }}" style="width:100%;height:100%;object-fit:cover" alt="">
                </div>
            @else
                <div class="sb-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            @endif
            <div style="min-width:0">
                <div class="sb-user-name" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ auth()->user()->name }}</div>
                <div class="sb-user-role">{{ __('common.admin') }}</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sb-logout">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                {{ __('nav.logout') }}
            </button>
        </form>
    </div>
</aside>

<!-- ── MAIN ────────────────────────────────────────────── -->
<div style="flex:1;display:flex;flex-direction:column;min-width:0;overflow:hidden;height:calc(100vh - 38px);">

    <!-- Topbar -->
    <header id="topbar">
        <div style="flex:1">
            <div class="tb-breadcrumb">
                <a href="{{ route('admin.dashboard') }}">Admin</a>
                @hasSection('breadcrumb')
                    <span style="color:#dee2e6">/</span>
                    @yield('breadcrumb')
                @endif
            </div>
            <div class="tb-page-title">@yield('header', 'Dashboard')</div>
        </div>
        <div style="display:flex;align-items:center;gap:8px">
            @yield('header-actions')
        </div>
    </header>

    <!-- Content -->
    <main style="flex:1;min-height:0;overflow-y:auto;padding:24px;">
        @if(session('success'))
            <div class="alert-success mb-5">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert-error mb-5">{{ session('error') }}</div>
        @endif
        @yield('content')
    </main>
</div>

</div>{{-- ── /LAYOUT WRAPPER ── --}}

<script>
// Modal helpers
function openModal(id) { document.getElementById(id).classList.add('open'); document.body.style.overflow='hidden'; }
function closeModal(id) { document.getElementById(id).classList.remove('open'); document.body.style.overflow=''; }
document.addEventListener('keydown', e => { if(e.key==='Escape') document.querySelectorAll('.nf-overlay.open').forEach(m=>{ m.classList.remove('open'); document.body.style.overflow=''; }); });

// Fix: prevent modal from closing when user drags text inside and releases on the backdrop.
// Track where mousedown started; the inline onclick on .nf-overlay checks __nfMdTarget===this.
var __nfMdTarget = null;
document.addEventListener('mousedown', function(e) { __nfMdTarget = e.target; });

function toggleMenu(id) {
    const sub = document.getElementById(id);
    const isOpen = sub.classList.contains('open');
    // close all
    document.querySelectorAll('.sb-sub').forEach(el => el.classList.remove('open'));
    document.querySelectorAll('.sb-item[onclick]').forEach(el => el.classList.remove('open'));
    if (!isOpen) {
        sub.classList.add('open');
        sub.previousElementSibling.classList.add('open');
    }
}
</script>
@stack('scripts')
</body>
</html>
