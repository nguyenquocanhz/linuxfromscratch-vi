<?php
// Render the Vietnamese site into public/.
// Usage: php bin/build.php
declare(strict_types=1);
require __DIR__ . '/lib.php';
require __DIR__ . '/markdown.php';

$cfg = require ROOT . '/config.php';
const VER = '12.4';
const OUT = ROOT . '/public';
const UPSTREAM_URL = 'https://www.linuxfromscratch.org/lfs/view/12.4/';

function e(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function write_out(string $rel, string $html): void
{
    $path = OUT . '/' . $rel;
    @mkdir(dirname($path), 0755, true);
    file_put_contents($path, $html);
}

// ---- translations: per page first, then any page (repeated phrases) ----
$tmPage = [];
$tmAll = [];
foreach (glob(ROOT . '/i18n/vi/{,*/}*.json', GLOB_BRACE) as $f) {
    $rel = preg_replace('/\.json$/', '.html', substr($f, strlen(ROOT . '/i18n/vi/')));
    $map = json_decode((string) file_get_contents($f), true);
    if (!is_array($map)) {
        fwrite(STDERR, "skip broken $f\n");
        continue;
    }
    $map = array_filter($map, fn($v) => is_string($v) && trim($v) !== '');
    $tmPage[$rel] = $map;
    $tmAll += $map;
}

function tr(string $rel, string $en): ?string
{
    global $tmPage, $tmAll;
    return $tmPage[$rel][$en] ?? $tmAll[$en] ?? null;
}

// ---- tricks ----
$tricks = [];
foreach (glob(ROOT . '/tricks/*.md') as $f) {
    $src = (string) file_get_contents($f);
    if (!preg_match('/^---\R(.*?)\R---\R(.*)$/s', $src, $m)) {
        continue;
    }
    $meta = [];
    foreach (preg_split('/\R/', $m[1]) as $line) {
        if (str_contains($line, ':')) {
            [$k, $v] = array_map('trim', explode(':', $line, 2));
            $meta[$k] = $v;
        }
    }
    $slug = preg_replace('/^\d+-/', '', basename($f, '.md'));
    $tricks[] = [
        'slug' => $slug,
        'title' => $meta['title'] ?? $slug,
        'pages' => array_filter(array_map('trim', explode(',', $meta['pages'] ?? ''))),
        'tags' => array_filter(array_map('trim', explode(',', $meta['tags'] ?? ''))),
        'html' => markdown($m[2]),
    ];
}
$tricksByPage = [];
foreach ($tricks as $t) {
    foreach ($t['pages'] as $p) {
        $tricksByPage[$p][] = $t;
    }
}

// ---- pass 1: titles of every page (for nav and sidebar) ----
$pages = book_pages();
$titles = [];
foreach ($pages as $rel) {
    $doc = load_page($rel);
    $en = norm($doc->querySelector('title')?->textContent ?? $rel);
    $titles[$rel] = tr($rel, $en) ?? $en;
}

function rel_href(string $from, string $to): string
{
    // both are paths inside the book; return an absolute site URL for $to
    $base = dirname($from) === '.' ? '' : dirname($from) . '/';
    $parts = [];
    foreach (explode('/', $base . $to) as $seg) {
        if ($seg === '..') {
            array_pop($parts);
        } elseif ($seg !== '.' && $seg !== '') {
            $parts[] = $seg;
        }
    }
    return '/' . VER . '/' . implode('/', $parts);
}

// ---- sidebar: the translated table of contents from index.html ----
function build_toc(): string
{
    $doc = load_page('index.html');
    foreach (segments($doc->body) as $el) {
        $vi = tr('index.html', inner_html($el));
        if ($vi !== null) {
            $el->innerHTML = $vi;
        }
    }
    $toc = $doc->querySelector('div.toc > ul');
    foreach ($toc->querySelectorAll('a[href]') as $a) {
        $a->setAttribute('href', rel_href('index.html', $a->getAttribute('href')));
        $a->removeAttribute('title');
    }
    // Every top-level entry with children becomes a collapsible <details>.
    $html = '';
    foreach ($toc->children as $li) {
        $sub = child_ul($li);
        $link = $li->querySelector('a');
        if (!$link) {
            continue;
        }
        if ($sub) {
            $html .= '<details><summary>' . $link->outerHTML . '</summary>' . nested_list($sub) . '</details>';
        } else {
            $html .= '<div class="toc-single">' . $link->outerHTML . '</div>';
        }
    }
    return $html;
}

function child_ul(Dom\Element $el): ?Dom\Element
{
    foreach ($el->children as $c) {
        if (strtolower($c->localName) === 'ul') {
            return $c;
        }
    }
    return null;
}

function nested_list(Dom\Element $ul): string
{
    $out = '<ul>';
    foreach ($ul->children as $li) {
        $a = $li->querySelector('a');
        $sub = child_ul($li);
        $out .= '<li>' . ($a ? $a->outerHTML : '') . ($sub ? nested_list($sub) : '') . '</li>';
    }
    return $out . '</ul>';
}

$tocHtml = build_toc();

function layout(array $p): string
{
    global $cfg, $tocHtml;
    $title = e($p['title']);
    $desc = e($p['desc'] ?? 'Bản dịch tiếng Việt của sách Linux From Scratch, kèm mẹo thực chiến từ cộng đồng.');
    $canon = e(rtrim($cfg['url'], '/') . $p['path']);
    $sidebar = $p['sidebar'] ?? true;
    $main = $p['main'];
    $nav = '<a href="/">Trang chủ</a><a href="/' . VER . '/">Mục lục</a><a href="/trick-lo/">Trick lỏ</a><a href="/dong-gop/">Đóng góp</a>';
    $aside = $sidebar ? '<aside class="sidebar" id="sidebar"><input type="search" id="toc-filter" placeholder="Lọc mục lục…" aria-label="Lọc mục lục"><nav class="toc">' . $tocHtml . '</nav></aside>' : '';
    $year = date('Y');
    return <<<HTML
<!doctype html>
<html lang="vi">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{$title}</title>
<meta name="description" content="{$desc}">
<link rel="canonical" href="{$canon}">
<meta property="og:title" content="{$title}">
<meta property="og:description" content="{$desc}">
<meta property="og:type" content="article">
<meta property="og:locale" content="vi_VN">
<meta name="theme-color" content="#14110f">
<link rel="icon" href="/assets/favicon.svg" type="image/svg+xml">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/assets/site.css?v={$p['v']}">
<script>try{var t=localStorage.getItem('theme');if(t)document.documentElement.dataset.theme=t}catch(e){}</script>
</head>
<body class="{$p['bodyClass']}">
<header class="topbar">
  <button class="menu-btn" id="menu-btn" aria-label="Mở mục lục" aria-controls="sidebar">☰</button>
  <a class="brand" href="/"><span class="brand-mark">\$_</span> LFS <b>Tiếng Việt</b> <small>v{$GLOBALS['ver']}</small></a>
  <nav class="topnav">{$nav}</nav>
  <button class="theme-btn" id="theme-btn" aria-label="Đổi giao diện sáng/tối">◐</button>
</header>
<div class="shell">
{$aside}
<main class="content" id="content">
{$main}
</main>
</div>
<footer class="site-footer">
  <p>Bản dịch cộng đồng của <a href="https://www.linuxfromscratch.org/lfs/" rel="noopener">Linux From Scratch</a> — Copyright © 1999–2025 Gerard Beekmans.
  Nội dung sách theo giấy phép <a href="https://creativecommons.org/licenses/by-nc-sa/2.0/" rel="noopener">CC BY-NC-SA 2.0</a>, lệnh trong sách theo <a href="/12.4/appendices/mit.html">giấy phép MIT</a>.
  Đây không phải trang chính thức của dự án LFS. Trick lỏ là mẹo của cộng đồng, không thuộc sách gốc.</p>
  <p>© {$year} <a href="https://wrenevil.tech/">wrenevil.tech</a> · <a href="/dong-gop/">Góp sức dịch</a></p>
</footer>
<script src="/assets/site.js?v={$p['v']}" defer></script>
</body>
</html>
HTML;
}

$ver = VER;
$v = substr(md5((string) filemtime(ROOT . '/assets/site.css') . filemtime(ROOT . '/assets/site.js')), 0, 8);

function trick_box(array $t, bool $open = false): string
{
    $tags = implode('', array_map(fn($x) => '<span class="tag">' . e($x) . '</span>', $t['tags']));
    return '<details class="trick" id="trick-' . e($t['slug']) . '"' . ($open ? ' open' : '') . '><summary><span class="trick-badge">Trick lỏ</span> ' . e($t['title']) . '</summary><div class="trick-body">' . $t['html'] . '<p class="trick-meta">' . $tags . ' <a href="/trick-lo/#' . e($t['slug']) . '">Tất cả trick lỏ →</a></p></div></details>';
}

// ---- pass 2: book pages ----
@mkdir(OUT, 0755, true);
$stats = ['seg' => 0, 'vi' => 0];
$search = [];
foreach ($pages as $rel) {
    $doc = load_page($rel);
    $segs = segments($doc->body);
    $n = $done = 0;
    foreach ($segs as $el) {
        $n++;
        $vi = tr($rel, inner_html($el));
        if ($vi !== null) {
            $el->innerHTML = $vi;
            $done++;
        } else {
            $el->classList->add('en');
        }
    }
    $stats['seg'] += $n;
    $stats['vi'] += $done;

    // links: point at our copy, keep external ones external
    foreach ($doc->body->querySelectorAll('a[href]') as $a) {
        $href = $a->getAttribute('href');
        if (!preg_match('#^([a-z]+:|\#|/)#i', $href)) {
            $a->setAttribute('href', rel_href($rel, $href));
        } elseif (preg_match('#^https?://#', $href)) {
            $a->setAttribute('rel', 'noopener');
        }
    }
    foreach ($doc->body->querySelectorAll('img[src]') as $img) {
        $src = $img->getAttribute('src');
        if (!preg_match('#^([a-z]+:|/)#i', $src)) {
            $img->setAttribute('src', rel_href($rel, $src));
        }
        $img->setAttribute('loading', 'lazy');
    }

    $navLinks = [];
    if ($head = $doc->querySelector('.navheader')) {
        foreach (['p' => 'prev', 'n' => 'next', 'u' => 'up'] as $key => $name) {
            $a = $head->querySelector('a[accesskey="' . $key . '"]');
            if ($a) {
                $href = $a->getAttribute('href');
                $target = ltrim(substr($href, strlen('/' . VER . '/')), '/');
                $navLinks[$name] = [$href, $titles[$target] ?? norm($a->getAttribute('title') ?? '')];
            }
        }
    }

    $body = '';
    $firstText = '';
    foreach ($doc->body->children as $c) {
        $cls = ' ' . $c->getAttribute('class') . ' ';
        if (str_contains($cls, ' navheader ') || str_contains($cls, ' navfooter ')) {
            continue;
        }
        $body .= $c->outerHTML . "\n";
        if ($firstText === '') {
            foreach ($c->querySelectorAll('p') as $pEl) {
                $t = norm($pEl->textContent);
                if (mb_strlen($t) > 60) {
                    $firstText = mb_substr($t, 0, 155);
                    break;
                }
            }
        }
    }

    $boxes = implode('', array_map('trick_box', $tricksByPage[$rel] ?? []));
    $pct = $n ? (int) floor($done * 100 / $n) : 100;
    $status = $pct >= 100
        ? '<span class="pill ok">Đã dịch</span>'
        : '<span class="pill warn">Đã dịch ' . $pct . '% — đoạn còn tiếng Anh được đánh dấu</span>';
    $tools = '<div class="page-tools">' . $status
        . '<a href="' . e(UPSTREAM_URL . $rel) . '" rel="noopener">Bản gốc tiếng Anh ↗</a>'
        . ($cfg['repo'] ? '<a href="' . e($cfg['repo'] . '/blob/main/i18n/vi/' . preg_replace('/\.html$/', '.json', $rel)) . '" rel="noopener">Sửa bản dịch</a>' : '<a href="/dong-gop/">Góp ý bản dịch</a>')
        . '</div>';
    $pager = '<nav class="pager">'
        . (isset($navLinks['prev']) ? '<a class="prev" href="' . e($navLinks['prev'][0]) . '"><small>← Trước</small>' . e($navLinks['prev'][1]) . '</a>' : '<span></span>')
        . (isset($navLinks['next']) ? '<a class="next" href="' . e($navLinks['next'][0]) . '"><small>Tiếp →</small>' . e($navLinks['next'][1]) . '</a>' : '<span></span>')
        . '</nav>';
    $crumb = isset($navLinks['up']) && $rel !== 'index.html'
        ? '<p class="crumb"><a href="' . e($navLinks['up'][0]) . '">↑ ' . e($navLinks['up'][1]) . '</a></p>' : '';

    $main = $crumb . $tools . ($boxes ? '<div class="tricks">' . $boxes . '</div>' : '') . '<article class="book">' . $body . '</article>' . $pager;
    $out = layout([
        'title' => $titles[$rel] . ' — LFS ' . VER . ' tiếng Việt',
        'desc' => $firstText ?: null,
        'path' => '/' . VER . '/' . $rel,
        'main' => $main,
        'bodyClass' => 'page-book',
        'v' => $v,
    ]);
    write_out(VER . '/' . $rel, $out);
    $search[] = ['t' => $titles[$rel], 'u' => '/' . VER . '/' . $rel];
}

// static files from the book
foreach (['images', 'scripts'] as $dir) {
    foreach (glob(BOOK . "/$dir/*") as $f) {
        @mkdir(OUT . '/' . VER . "/$dir", 0755, true);
        copy($f, OUT . '/' . VER . "/$dir/" . basename($f));
    }
}
foreach (['wget-list', 'wget-list-sysv', 'md5sums'] as $f) {
    copy(BOOK . "/$f", OUT . '/' . VER . "/$f");
}
foreach (glob(ROOT . '/assets/*') as $f) {
    @mkdir(OUT . '/assets', 0755, true);
    copy($f, OUT . '/assets/' . basename($f));
}

// ---- extra pages ----
$pct = $stats['seg'] ? floor($stats['vi'] * 1000 / $stats['seg']) / 10 : 0;
$tvars = [
    'ver' => VER,
    'pct' => $pct,
    'pages' => count($pages),
    'tricks' => $tricks,
    'repo' => $cfg['repo'],
    'stats' => $stats,
];
foreach (['index' => '', 'trick-lo' => 'trick-lo/', 'dong-gop' => 'dong-gop/'] as $tpl => $path) {
    $page = (function (string $__f, array $__v) {
        extract($__v);
        ob_start();
        require $__f;
        return ['main' => ob_get_clean(), 'title' => $title, 'desc' => $desc];
    })(ROOT . "/templates/$tpl.php", $tvars);
    write_out($path . 'index.html', layout($page + ['path' => '/' . $path, 'bodyClass' => 'page-' . $tpl, 'v' => $v, 'sidebar' => false]));
}
write_out('404.html', layout([
    'title' => 'Không tìm thấy trang — LFS tiếng Việt',
    'path' => '/404.html',
    'main' => '<div class="prose"><h1>404 — trang này không tồn tại</h1><p>Có thể đường dẫn đã đổi. Thử <a href="/' . VER . '/">mục lục</a> hoặc <a href="/trick-lo/">trick lỏ</a>.</p></div>',
    'bodyClass' => 'page-404',
    'v' => $v,
    'sidebar' => false,
]));

// sitemap + robots
$base = rtrim($cfg['url'], '/');
$urls = ['/', '/' . VER . '/', '/trick-lo/', '/dong-gop/'];
foreach ($pages as $rel) {
    if ($rel !== 'index.html') {
        $urls[] = '/' . VER . '/' . $rel;
    }
}
$xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
foreach ($urls as $u) {
    $xml .= '  <url><loc>' . e($base . $u) . "</loc></url>\n";
}
write_out('sitemap.xml', $xml . "</urlset>\n");
write_out('robots.txt', "User-agent: *\nAllow: /\nSitemap: $base/sitemap.xml\n");
write_out('search.json', json_encode($search, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

printf("pages=%d segments=%d translated=%d (%.1f%%) tricks=%d\n", count($pages), $stats['seg'], $stats['vi'], $pct, count($tricks));
