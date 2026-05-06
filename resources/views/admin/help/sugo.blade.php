<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('help.page_title') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: #f3f3f9; margin: 0; padding: 0; }

        /* ── SIDEBAR ─────────────────────────────────── */
        #sidebar {
            width: 280px;
            min-width: 280px;
            background: linear-gradient(180deg, #405189 0%, #364474 100%);
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,0.08) transparent;
        }
        #sidebar::-webkit-scrollbar { width: 4px; }
        #sidebar::-webkit-scrollbar-track { background: transparent; }
        #sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.08); border-radius: 4px; }

        .sb-brand {
            display: flex; align-items: center; gap: 10px;
            padding: 22px 20px 18px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            text-decoration: none;
        }
        .sb-logo-icon {
            width: 30px; height: 30px; border-radius: 6px;
            background: #fff;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
            color: #405189;
        }
        .sb-brand-name { color: #fff; font-size: 1.1rem; font-weight: 700; letter-spacing: 0.02em; }

        .sb-section {
            font-size: 0.625rem; font-weight: 700;
            letter-spacing: 0.1em; text-transform: uppercase;
            color: #8c98cc; padding: 20px 20px 10px;
        }

        .help-tab {
            display: block; width: 100%; text-align: left;
            padding: 12px 20px;
            border: none; background: transparent;
            color: #c8cedf; font-size: 0.85rem; font-weight: 400;
            cursor: pointer; transition: all 0.2s;
            border-left: 3px solid transparent;
        }
        .help-tab:hover { background: rgba(255,255,255,0.05); color: #fff; }
        .help-tab.active { background: rgba(255,255,255,0.1); color: #fff; border-left-color: #fff; font-weight: 500; }

        /* ── TOPBAR ──────────────────────────────────── */
        #topbar {
            height: 60px;
            background: #fff;
            border-bottom: 1px solid #e9ebec;
            box-shadow: 0 1px 10px rgba(58,53,65,0.06);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 24px; flex-shrink: 0;
        }
        .tb-title { font-size: 0.95rem; font-weight: 600; color: #343a40; }

        .btn-ghost {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 7px 16px; background: transparent; color: #6c757d; border: 1px solid #ced4da;
            border-radius: 5px; font-size: 0.8125rem; font-weight: 500; cursor: pointer; text-decoration: none; transition: all 0.2s;
        }
        .btn-ghost:hover { background: #f8f9fa; color: #343a40; }

        /* Typography for parsed Markdown */
        .help-content h1, .help-content h2, .help-content h3 { color: #2a2f45; font-weight: 700; margin-top: 1.5em; margin-bottom: 0.5em; }
        .help-content h1 { font-size: 1.5rem; }
        .help-content h2 { font-size: 1.3rem; }
        .help-content h3 { font-size: 1.1rem; }
        .help-content p { margin-bottom: 1em; }
        .help-content ul { list-style-type: disc; padding-left: 1.5em; margin-bottom: 1em; }
        .help-content ol { list-style-type: decimal; padding-left: 1.5em; margin-bottom: 1em; }
        .help-content strong { font-weight: 700; color: #1e293b; }
        
        /* ── IMAGE VIEWER ────────────────────────────── */
        .img-viewer-overlay {
            display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.85); z-index: 2000;
            align-items: center; justify-content: center; padding: 20px; cursor: zoom-out;
        }
        .img-viewer-overlay.active { display: flex; }
        .img-viewer-img { width: 90vw; height: 90vh; object-fit: contain; border-radius: 8px; filter: drop-shadow(0 10px 30px rgba(0,0,0,0.3)); }
        .help-content img { cursor: zoom-in; max-width: 100%; height: auto; border-radius: 6px; border: 1px solid #e9ebec; transition: opacity 0.2s; }
        .help-content img:hover { opacity: 0.9; }
    </style>
</head>
<body class="flex h-screen overflow-hidden">

<aside id="sidebar">
    <div class="sb-brand">
        <div class="sb-logo-icon">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <span class="sb-brand-name">{{ __('help.brand') }}</span>
    </div>

    <div class="sb-section">{{ __('help.topics') }}</div>
    
    <div id="help-tabs">
        @forelse($help_articles as $i => $art)
        <button onclick="showHelpTab({{ $art->id }})"
            id="htab-{{ $art->id }}"
            class="help-tab {{ $i === 0 ? 'active' : '' }}">
            {{ ($locale === 'en' && $art->title_en) ? $art->title_en : $art->title }}
        </button>
        @empty
        <div class="px-5 py-4 text-sm text-gray-400 italic">{{ __('help.no_articles') }}</div>
        @endforelse
    </div>
</aside>

<div style="flex:1;display:flex;flex-direction:column;height:100vh;overflow:hidden">
    <header id="topbar">
        <div class="tb-title">{{ __('help.guide_title') }}</div>
        <div class="flex gap-3">
            @if(auth()->check() && auth()->user()->isAdmin())
            <a href="{{ route('admin.help.index') }}" class="btn-ghost">{{ __('help.edit_link') }}</a>
            @endif
            <button onclick="window.close()" class="btn-ghost">{{ __('help.back_btn') }}</button>
        </div>
    </header>

    <main id="help-main" style="height:calc(100vh - 60px);overflow-y:auto;padding:30px 40px;background:#fff">
        <div class="max-w-4xl mx-auto">
            @forelse($help_articles as $i => $art)
            <div id="hcontent-{{ $art->id }}" style="display:{{ $i===0 ? 'block' : 'none' }}">
                @php
                    $displayTitle   = ($locale === 'en' && $art->title_en)   ? $art->title_en   : $art->title;
                    $displayContent = ($locale === 'en' && $art->content_en) ? $art->content_en : $art->content;
                @endphp
                <h1 class="text-3xl font-bold text-gray-800 mb-8" style="color:#2a2f45">{{ $displayTitle }}</h1>
                <div class="prose prose-blue max-w-none text-gray-600 leading-relaxed help-content" style="font-size:0.95rem;">
                    {!! Str::markdown($displayContent) !!}
                </div>
            </div>
            @empty
            <div class="text-center py-20">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <h3 class="text-lg font-medium text-gray-700">{{ __('help.no_content') }}</h3>
            </div>
            @endforelse
        </div>
    </main>
</div>

<script>
const helpArticleIds = @json($help_articles->pluck('id'));

function showHelpTab(id) {
    helpArticleIds.forEach(aid => {
        const tab = document.getElementById('htab-' + aid);
        const content = document.getElementById('hcontent-' + aid);
        
        if (aid === id) {
            tab.classList.add('active');
            content.style.display = 'block';
            document.getElementById('help-main').scrollTo({ top: 0, behavior: 'smooth' });
        } else {
            tab.classList.remove('active');
            content.style.display = 'none';
        }
    });
}

// Képnézegető (fullscreen)
const overlay = document.createElement('div');
overlay.className = 'img-viewer-overlay';
const imgViewerEl = document.createElement('img');
imgViewerEl.className = 'img-viewer-img';
overlay.appendChild(imgViewerEl);
document.body.appendChild(overlay);

overlay.addEventListener('click', () => {
    overlay.classList.remove('active');
    document.body.style.overflow = '';
});

document.querySelectorAll('.help-content img').forEach(img => {
    img.addEventListener('click', () => {
        imgViewerEl.src = img.src;
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    });
});
</script>
</body>
</html>
