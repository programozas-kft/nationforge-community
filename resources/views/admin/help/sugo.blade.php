<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('help.page_title') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icons@7.2.3/css/flag-icons.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body { background: #f3f3f9; font-family: 'Figtree', sans-serif; margin: 0; height: 100vh; overflow: hidden; display: flex; flex-direction: column; }

        /* ── TOP HEADER (Changelog stílusú) ──────────── */
        .pub-header {
            background: #fff;
            border-bottom: 1px solid #e9ebec;
            padding: 0 1.5rem;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
            z-index: 100;
            box-shadow: 0 1px 4px rgba(56,65,74,0.06);
        }
        .pub-logo {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none; font-weight: 700;
            font-size: 1.05rem; color: #2a2f45;
        }
        .pub-right { display: flex; align-items: center; gap: 6px; }
        .lang-btn {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 4px 9px; border-radius: 5px;
            font-size: 0.78rem; font-weight: 600;
            text-decoration: none; border: 1px solid #e9ebec;
            color: #495057; background: #fff; transition: background 0.15s;
        }
        .lang-btn:hover { background: #f3f3f9; }
        .lang-btn.active { background: #405189; color: #fff; border-color: #405189; }
        .pub-btn {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 6px 14px; border-radius: 6px;
            font-size: 0.8rem; font-weight: 600; text-decoration: none;
            border: 1px solid #ced4da; color: #6c757d; background: #fff;
            transition: all 0.15s; cursor: pointer;
        }
        .pub-btn:hover { background: #f8f9fa; color: #343a40; }
        .pub-btn-primary { background: #405189; color: #fff; border-color: #405189; }
        .pub-btn-primary:hover { background: #3a4878; color: #fff; }

        /* ── BODY WRAP ────────────────────────────────── */
        .help-body { display: flex; flex: 1; overflow: hidden; }

        /* ── LEFT SIDEBAR ────────────────────────────── */
        #sidebar {
            width: 272px; min-width: 272px;
            background: #fff;
            border-right: 1px solid #e9ebec;
            display: flex; flex-direction: column;
            overflow-y: auto; overflow-x: hidden;
            scrollbar-width: thin;
            scrollbar-color: #dee2e6 transparent;
        }
        #sidebar::-webkit-scrollbar { width: 4px; }
        #sidebar::-webkit-scrollbar-thumb { background: #dee2e6; border-radius: 4px; }

        /* Flat tab */
        .help-tab {
            display: flex; align-items: center; width: 100%; text-align: left;
            padding: 9px 20px;
            border: none; background: transparent;
            color: #495057; font-size: 0.82rem; font-weight: 400;
            cursor: pointer; transition: all 0.15s;
            border-left: 3px solid transparent;
        }
        .help-tab:hover { background: #f3f3f9; color: #2a2f45; }
        .help-tab.active { background: rgba(64,81,137,0.07); color: #405189; border-left-color: #405189; font-weight: 600; }

        /* Accordion */
        .acc-header {
            display: flex; align-items: center; width: 100%; text-align: left;
            padding: 9px 20px;
            border: none; background: transparent;
            color: #495057; font-size: 0.82rem; font-weight: 400;
            cursor: pointer; transition: all 0.15s;
            border-left: 3px solid transparent; gap: 0;
        }
        .acc-header:hover { background: #f3f3f9; color: #2a2f45; }
        .acc-header.active { background: rgba(64,81,137,0.07); color: #405189; border-left-color: #405189; font-weight: 600; }

        .acc-label { flex: 1; }
        .acc-chevron {
            width: 13px; height: 13px; flex-shrink: 0; margin-left: 5px;
            transition: transform 0.2s; opacity: 0.4;
        }
        .acc-group.open .acc-chevron { transform: rotate(90deg); opacity: 0.7; }
        .acc-children { display: none; border-left: 1px solid #e9ebec; margin-left: 20px; }
        .acc-group.open .acc-children { display: block; }
        .acc-child {
            display: flex; align-items: center; width: 100%; text-align: left;
            padding: 7px 12px 7px 16px;
            border: none; background: transparent;
            color: #6c757d; font-size: 0.79rem; font-weight: 400;
            cursor: pointer; transition: all 0.15s;
            border-left: 2px solid transparent;
        }
        .acc-child:hover { background: #f3f3f9; color: #495057; }
        .acc-child.active { color: #405189; border-left-color: #405189; background: rgba(64,81,137,0.06); font-weight: 500; }

        /* Section label */
        .sb-section {
            font-size: 0.6rem; font-weight: 700; letter-spacing: 0.1em;
            text-transform: uppercase; color: #adb5bd;
            padding: 18px 20px 8px;
        }

        /* PRO badge */
        .sb-pro {
            margin-left: auto; flex-shrink: 0;
            background: rgba(122,90,248,0.12); color: #7a5af8;
            font-size: 0.58rem; font-weight: 700;
            padding: 2px 6px; border-radius: 4px; letter-spacing: 0.04em;
        }

        /* ── RIGHT CONTENT ────────────────────────────── */
        #help-main {
            flex: 1; overflow-y: auto; padding: 36px 48px;
            background: #fff;
        }

        /* Markdown content */
        .help-content h1 { font-size: 1.5rem; font-weight: 700; color: #2a2f45; margin: 0 0 0.5em; }
        .help-content h2 { font-size: 1.25rem; font-weight: 700; color: #2a2f45; margin: 1.5em 0 0.5em; }
        .help-content h3 { font-size: 1.05rem; font-weight: 600; color: #344054; margin: 1.2em 0 0.4em; }
        .help-content p { margin-bottom: 0.9em; color: #495057; font-size: 0.9rem; line-height: 1.7; }
        .help-content ul { list-style: disc; padding-left: 1.5em; margin-bottom: 0.9em; }
        .help-content ol { list-style: decimal; padding-left: 1.5em; margin-bottom: 0.9em; }
        .help-content li { color: #495057; font-size: 0.9rem; line-height: 1.7; margin-bottom: 4px; }
        .help-content strong { font-weight: 700; color: #1e293b; }
        .help-content code {
            background: #f0f2f7; border-radius: 4px;
            padding: 1px 5px; font-size: 0.82rem; color: #405189;
            font-family: 'Courier New', monospace;
        }
        .help-content pre { background: #f0f2f7; border-radius: 6px; padding: 14px 16px; overflow-x: auto; margin-bottom: 1em; }
        .help-content pre code { background: none; padding: 0; font-size: 0.83rem; color: #344054; }
        .help-content blockquote {
            border-left: 3px solid #405189; padding: 10px 16px;
            background: rgba(64,81,137,0.04); border-radius: 0 6px 6px 0;
            margin: 0 0 1em; color: #495057; font-size: 0.88rem;
        }
        .help-content table { width: 100%; border-collapse: collapse; margin-bottom: 1em; font-size: 0.875rem; }
        .help-content th { background: #f8f9fa; font-weight: 600; color: #344054; padding: 8px 12px; text-align: left; border: 1px solid #e9ebec; }
        .help-content td { padding: 8px 12px; border: 1px solid #e9ebec; color: #495057; vertical-align: top; }
        .help-content tr:nth-child(even) td { background: #fafafa; }
        .help-content img { cursor: zoom-in; max-width: 100%; height: auto; border-radius: 6px; border: 1px solid #e9ebec; transition: opacity 0.2s; margin: 8px 0; }
        .help-content img:hover { opacity: 0.9; }
        .help-content a { color: #405189; }
        .help-content hr { border: none; border-top: 1px solid #e9ebec; margin: 1.5em 0; }

        /* Image viewer */
        .img-viewer-overlay {
            display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.85); z-index: 2000;
            align-items: center; justify-content: center; padding: 20px; cursor: zoom-out;
        }
        .img-viewer-overlay.active { display: flex; }
        .img-viewer-img { max-width: 92vw; max-height: 92vh; object-fit: contain; border-radius: 8px; }
    </style>
</head>
<body>

@php
    $locale = in_array(app()->getLocale(), ['hu','en','de','ro','sk']) ? app()->getLocale() : 'hu';

    $sections = [
        10  => $locale === 'en' ? 'Menu'           : ($locale === 'de' ? 'Menü' : ($locale === 'ro' ? 'Meniu' : ($locale === 'sk' ? 'Menu' : 'Menü'))),
        40  => $locale === 'en' ? 'Organizing'     : ($locale === 'de' ? 'Organisieren' : ($locale === 'ro' ? 'Organizare' : ($locale === 'sk' ? 'Organizovanie' : 'Szervező'))),
        100 => $locale === 'en' ? 'Administration' : ($locale === 'de' ? 'Administration' : ($locale === 'ro' ? 'Administrare' : ($locale === 'sk' ? 'Administrácia' : 'Adminisztráció'))),
    ];

    $proRootKeys = ['szervezetek', 'riportok', '2fa', 'api', 'dokumentumok', 'urlapok', 'peticiok', 'onkentes', 'support', 'cloud'];

    // Build accordion groups
    $accGroups = [];
    foreach ($help_articles as $art) {
        $localTitle = $art->title;
        if (in_array($locale, ['en','de','ro','sk'])) {
            $col = "title_{$locale}";
            if (!empty($art->$col)) $localTitle = $art->$col;
        }
        $dashPos = strpos($art->menu_key, '-');
        $rootKey = $dashPos !== false ? substr($art->menu_key, 0, $dashPos) : $art->menu_key;

        if (!isset($accGroups[$rootKey])) {
            $accGroups[$rootKey] = ['label' => '', 'parent' => null, 'children' => [], 'section' => null];
        }
        $sec = null;
        foreach ($sections as $threshold => $label) {
            if ($art->sort_order >= $threshold) $sec = $threshold;
        }
        if (!$accGroups[$rootKey]['section']) $accGroups[$rootKey]['section'] = $sec;

        if ($art->menu_key === $rootKey) {
            $accGroups[$rootKey]['parent'] = $art;
            $accGroups[$rootKey]['label']  = $localTitle;
        } else {
            $shortLabel = str_contains($localTitle, ' – ')
                ? mb_substr($localTitle, mb_strpos($localTitle, ' – ') + 3)
                : $localTitle;
            $accGroups[$rootKey]['children'][] = ['art' => $art, 'short' => $shortLabel, 'full' => $localTitle];
        }
    }
    // Fallback label from first child
    foreach ($accGroups as $rk => &$grp) {
        if (!$grp['label'] && !empty($grp['children'])) {
            $ft = $grp['children'][0]['full'];
            $grp['label'] = str_contains($ft, ' – ') ? substr($ft, 0, strpos($ft, ' – ')) : $ft;
        }
    }
    unset($grp);

    $shownSections = [];
    $firstArtId    = $help_articles->first()?->id;

    $langs = [
        'hu' => ['flag' => 'fi-hu', 'label' => 'HU'],
        'en' => ['flag' => 'fi-gb', 'label' => 'EN'],
        'de' => ['flag' => 'fi-de', 'label' => 'DE'],
        'ro' => ['flag' => 'fi-ro', 'label' => 'RO'],
        'sk' => ['flag' => 'fi-sk', 'label' => 'SK'],
    ];
@endphp

{{-- ── TOP HEADER ───────────────────────────────────── --}}
<header class="pub-header">
    <div style="display:flex;align-items:center;gap:12px">
        <a href="{{ route('admin.login') }}" class="pub-logo">
            <svg width="28" height="28" viewBox="0 0 32 32" fill="none">
                <polygon points="16,2 30,9 30,23 16,30 2,23 2,9" fill="#1a2456" stroke="#4a7fd4" stroke-width="1.5"/>
                <text x="16" y="22" text-anchor="middle" font-family="sans-serif" font-weight="700" font-size="16" fill="white">N</text>
            </svg>
            {{ config('app.name', 'NationForge') }}
        </a>
        <span style="color:#dee2e6;font-size:1.1rem">|</span>
        <span style="font-size:0.85rem;color:#878a99;font-weight:500">{{ __('help.guide_title') }}</span>
    </div>
    <div class="pub-right">
        @foreach($langs as $loc => $info)
        <a href="{{ route('locale.switch', $loc) }}"
           class="lang-btn {{ $locale === $loc ? 'active' : '' }}">
            <span class="fi {{ $info['flag'] }}" style="width:16px;height:12px;display:inline-block;background-size:cover;border-radius:2px"></span>
            {{ $info['label'] }}
        </a>
        @endforeach
        @if(auth()->check() && auth()->user()->isAdmin())
        <a href="{{ route('admin.help.index') }}" class="pub-btn" style="margin-left:4px">{{ __('help.edit_link') }}</a>
        @endif
        <button onclick="window.history.length>1?window.history.back():window.location='{{ route('admin.dashboard') }}'" class="pub-btn pub-btn-primary">{{ __('help.back_btn') }}</button>
    </div>
</header>

{{-- ── BODY ─────────────────────────────────────────── --}}
<div class="help-body">

    {{-- LEFT SIDEBAR --}}
    <aside id="sidebar">
        <div id="help-tabs">
            @forelse($accGroups as $rootKey => $grp)
            @php
                $sec = $grp['section'];
                $showSec = $sec && !in_array($sec, $shownSections);
                if ($showSec) $shownSections[] = $sec;
                $hasChildren = count($grp['children']) > 0;
                $parentArt   = $grp['parent'];
                $isAccordion = $hasChildren;
                $isPro       = in_array($rootKey, $proRootKeys);
            @endphp

            @if($showSec)
            <div class="sb-section">{{ $sections[$sec] }}</div>
            @endif

            @if(!$isAccordion)
                @php $art = $parentArt ?? $grp['children'][0]['art']; @endphp
                <button onclick="showHelpTab({{ $art->id }})"
                    id="htab-{{ $art->id }}"
                    class="help-tab {{ $art->id === $firstArtId ? 'active' : '' }}">
                    {{ $grp['label'] }}
                    @if($isPro)
                        <span class="sb-pro">PRO</span>
                    @endif
                </button>
            @else
                <div class="acc-group open" id="accg-{{ $rootKey }}">
                    @if($parentArt)
                    <button class="acc-header {{ $parentArt->id === $firstArtId ? 'active' : '' }}"
                        id="htab-{{ $parentArt->id }}"
                        onclick="accClick('{{ $rootKey }}', {{ $parentArt->id }})">
                        <span class="acc-label">{{ $grp['label'] }}</span>
                        @if($isPro)
                            <span class="sb-pro" style="margin-right:4px">PRO</span>
                        @endif
                        <svg class="acc-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </button>
                    @else
                    <button class="acc-header" onclick="accToggle('{{ $rootKey }}')">
                        <span class="acc-label">{{ $grp['label'] }}</span>
                        @if($isPro)
                            <span class="sb-pro" style="margin-right:4px">PRO</span>
                        @endif
                        <svg class="acc-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </button>
                    @endif

                    <div class="acc-children">
                        @foreach($grp['children'] as $child)
                        <button onclick="showHelpTab({{ $child['art']->id }})"
                            id="htab-{{ $child['art']->id }}"
                            class="acc-child {{ $child['art']->id === $firstArtId ? 'active' : '' }}">
                            {{ $child['short'] }}
                        </button>
                        @endforeach
                    </div>
                </div>
            @endif
            @empty
            <div style="padding:20px;font-size:.82rem;color:#5a6587">{{ __('help.no_articles') }}</div>
            @endforelse
        </div>

    </aside>

    {{-- RIGHT CONTENT --}}
    <main id="help-main">
        <div style="max-width:820px;margin:0 auto">
            @forelse($help_articles as $i => $art)
            <div id="hcontent-{{ $art->id }}" style="display:{{ $i===0 ? 'block' : 'none' }}">
                @php
                    $displayTitle   = $art->title;
                    $displayContent = $art->content;
                    if (in_array($locale, ['en','de','ro','sk'])) {
                        $tCol = "title_{$locale}";
                        $cCol = "content_{$locale}";
                        if (!empty($art->$tCol)) $displayTitle   = $art->$tCol;
                        if (!empty($art->$cCol)) $displayContent = $art->$cCol;
                    }
                    $embedUrl = \App\Models\HelpArticle::toEmbedUrl($art->video_url ?? null);
                @endphp
                <div class="help-content">
                    {!! str_replace('src="/img/', 'src="' . asset('img/') . '/', Str::markdown($displayContent)) !!}
                </div>
                @if($embedUrl)
                <div style="margin-top:24px;position:relative;padding-bottom:56.25%;height:0;overflow:hidden;border-radius:8px;border:1px solid #e9ebec">
                    <iframe src="{{ $embedUrl }}"
                        style="position:absolute;top:0;left:0;width:100%;height:100%;border:0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen loading="lazy"></iframe>
                </div>
                @endif
            </div>
            @empty
            <div style="text-align:center;padding:80px 0;color:#adb5bd">
                <svg style="width:56px;height:56px;margin:0 auto 16px;display:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="1.5"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.5 9a2.5 2.5 0 015 0c0 2.5-2.5 2.5-2.5 4m0 2h.01"/></svg>
                <div>{{ __('help.no_content') }}</div>
            </div>
            @endforelse
        </div>
    </main>
</div>

{{-- Image viewer --}}
<div class="img-viewer-overlay" id="imgViewer" onclick="this.classList.remove('active');document.body.style.overflow=''">
    <img class="img-viewer-img" id="imgViewerImg" src="" alt="">
</div>

<script>
const helpArticleIds = @json($help_articles->pluck('id'));

function showHelpTab(id) {
    helpArticleIds.forEach(aid => {
        const tab     = document.getElementById('htab-' + aid);
        const content = document.getElementById('hcontent-' + aid);
        if (!tab || !content) return;
        if (aid === id) {
            tab.classList.add('active');
            content.style.display = 'block';
            document.getElementById('help-main').scrollTo({ top: 0, behavior: 'smooth' });
        } else {
            tab.classList.remove('active');
            content.style.display = 'none';
        }
    });
    document.querySelectorAll('.acc-children').forEach(children => {
        if (children.querySelector('#htab-' + id)) {
            children.closest('.acc-group').classList.add('open');
        }
    });
}

function accToggle(rootKey) {
    const grp = document.getElementById('accg-' + rootKey);
    if (grp) grp.classList.toggle('open');
}

function accClick(rootKey, artId) {
    const grp = document.getElementById('accg-' + rootKey);
    if (grp && !grp.classList.contains('open')) grp.classList.add('open');
    showHelpTab(artId);
}

// Image zoom
document.querySelectorAll('.help-content img').forEach(img => {
    img.addEventListener('click', () => {
        document.getElementById('imgViewerImg').src = img.src;
        document.getElementById('imgViewer').classList.add('active');
        document.body.style.overflow = 'hidden';
    });
});
</script>
</body>
</html>
