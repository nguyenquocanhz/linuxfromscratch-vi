<?php
// Export the built Vietnamese book (public/12.4) as Markdown for GitBook Git Sync.
// Run bin/build.php first. Usage: php bin/gitbook.php
declare(strict_types=1);
require __DIR__ . '/lib.php';

const SRC = ROOT . '/public/12.4';
const GB = ROOT . '/gitbook';
const SITE = 'https://linuxfromscratch.wrenevil.tech';

$cfg = require ROOT . '/config.php';

// ---------- Markdown conversion ----------

function md_text(string $s): string
{
    $s = preg_replace('/\s+/u', ' ', $s);
    // Characters Markdown or GitBook (liquid) would otherwise interpret.
    return strtr($s, ['\\' => '\\\\', '*' => '\\*', '_' => '\\_', '`' => '\\`', '[' => '\\[', ']' => '\\]', '<' => '&lt;', '>' => '&gt;', '{%' => '{\\%', '#' => '\\#', '|' => '\\|']);
}

function md_code(string $s): string
{
    $s = trim(preg_replace('/\s+/u', ' ', $s));
    if ($s === '') {
        return '';
    }
    $fence = str_contains($s, '`') ? '`` ' : '`';
    return $fence . $s . strrev($fence);
}

// Book links are site paths (/12.4/chapter05/glibc.html#x); make them relative .md links.
function md_href(string $href, string $from): string
{
    if (preg_match('#^/trick-lo/(\#.*)?$#', $href, $tm)) {
        return (dirname(md_name($from)) === '.' ? '' : '../') . 'trick-lo.md' . ($tm[1] ?? '');
    }
    if (!str_starts_with($href, '/12.4/')) {
        return str_starts_with($href, '/') ? SITE . $href : $href;
    }
    [$path, $frag] = array_pad(explode('#', substr($href, 6), 2), 2, null);
    if (!str_ends_with($path, '.html')) {
        return SITE . $href;
    }
    $target = md_name($path);
    $fromDir = dirname(md_name($from));
    $rel = $fromDir === '.' ? $target : (str_starts_with($target, $fromDir . '/') ? substr($target, strlen($fromDir) + 1) : '../' . $target);
    return $rel . ($frag ? '#' . $frag : '');
}

function md_name(string $rel): string
{
    return $rel === 'index.html' ? 'README.md' : preg_replace('/\.html$/', '.md', $rel);
}

function inline(Dom\Node $n, string $page): string
{
    if ($n instanceof Dom\Text) {
        return md_text($n->textContent);
    }
    if (!$n instanceof Dom\Element) {
        return '';
    }
    $tag = strtolower($n->localName);
    $cls = ' ' . ($n->getAttribute('class') ?? '') . ' ';
    if (str_contains($cls, ' tag ')) {
        return ''; // trick tags are site-only filter chips
    }
    if ($tag === 'br') {
        return "  \n";
    }
    if ($tag === 'img') {
        return '![' . md_text($n->getAttribute('alt') ?? '') . '](' . md_href($n->getAttribute('src') ?? '', $page) . ')';
    }
    // Code-like spans: one backtick run around the plain text.
    if (in_array($tag, ['code', 'kbd', 'tt', 'samp'], true)
        || preg_match('/ (command|filename|literal|envar|option|systemitem|parameter|replaceable|computeroutput|userinput|application) /', $cls)) {
        if ($tag === 'a') {
            return '[' . md_code($n->textContent) . '](' . md_href($n->getAttribute('href') ?? '', $page) . ')';
        }
        return md_code($n->textContent);
    }
    $inner = '';
    foreach ($n->childNodes as $c) {
        $inner .= inline($c, $page);
    }
    if ($tag === 'a') {
        $href = $n->getAttribute('href');
        if ($href === null || trim($inner) === '') {
            return $inner; // bare anchors (<a id=…>) carry nothing in Markdown
        }
        return '[' . trim($inner) . '](' . md_href($href, $page) . ')';
    }
    $t = trim($inner);
    if ($t === '') {
        return $inner;
    }
    $wrap = fn(string $m) => (preg_match('/^\s/u', $inner) ? ' ' : '') . $m . $t . $m . (preg_match('/\s$/u', $inner) ? ' ' : '');
    return match (true) {
        in_array($tag, ['strong', 'b'], true) => str_starts_with($t, '`') && str_ends_with($t, '`') ? $inner : $wrap('**'),
        in_array($tag, ['em', 'i'], true) => str_starts_with($t, '`') && str_ends_with($t, '`') ? $inner : $wrap('*'),
        default => $inner,
    };
}

function inline_all(Dom\Element $el, string $page): string
{
    $s = '';
    foreach ($el->childNodes as $c) {
        $s .= is_block($c) ? ' ' . trim(blocks($c, $page)) . ' ' : inline($c, $page);
    }
    return trim(preg_replace('/[ \t]+/u', ' ', $s));
}

function is_block(Dom\Node $n): bool
{
    return $n instanceof Dom\Element && in_array(strtolower($n->localName), ['p', 'div', 'pre', 'ul', 'ol', 'dl', 'table', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'blockquote', 'details'], true);
}

function indent(string $s, string $pad): string
{
    return preg_replace('/^(?=.)/m', $pad, $s);
}

function blocks(Dom\Node $n, string $page): string
{
    if ($n instanceof Dom\Text) {
        $t = trim(md_text($n->textContent));
        return $t === '' ? '' : $t . "\n\n";
    }
    if (!$n instanceof Dom\Element) {
        return '';
    }
    $tag = strtolower($n->localName);
    $cls = ' ' . ($n->getAttribute('class') ?? '') . ' ';

    if (preg_match('/^h([1-6])$/', $tag, $m)) {
        return str_repeat('#', (int) $m[1]) . ' ' . inline_all($n, $page) . "\n\n";
    }
    if ($tag === 'p') {
        $t = inline_all($n, $page);
        return $t === '' ? '' : $t . "\n\n";
    }
    if ($tag === 'pre') {
        $lang = str_contains($cls, ' userinput ') ? 'bash' : 'text';
        if (preg_match('/language-([\w-]+)/', $n->querySelector('code')?->getAttribute('class') ?? '', $lm)) {
            $lang = $lm[1];
        }
        $code = rtrim(str_replace("\u{00A0}", ' ', $n->textContent));
        $code = preg_replace('/\s*(Sao chép|Đã chép ✓)$/u', '', $code); // copy button text, if any
        $fence = str_contains($code, '```') ? '````' : '```';
        return $fence . $lang . "\n" . $code . "\n" . $fence . "\n\n";
    }
    if ($tag === 'ul' || $tag === 'ol') {
        $out = '';
        $i = 1;
        foreach ($n->children as $li) {
            $mark = $tag === 'ol' ? ($i++) . '. ' : '* ';
            $body = trim(children_blocks($li, $page));
            $lines = explode("\n", $body);
            $out .= $mark . array_shift($lines) . "\n" . ($lines ? indent(implode("\n", $lines), str_repeat(' ', strlen($mark))) . "\n" : '');
        }
        return $out . "\n";
    }
    if ($tag === 'dl') {
        $out = '';
        foreach ($n->children as $c) {
            $ct = strtolower($c->localName);
            if ($ct === 'dt') {
                $out .= '**' . trim(inline_all($c, $page), '* ') . "**\n\n";
            } elseif ($ct === 'dd') {
                $out .= indent(trim(children_blocks($c, $page)), '> ') . "\n\n";
            }
        }
        return $out;
    }
    if ($tag === 'table') {
        return table_md($n, $page);
    }
    if ($tag === 'details') {
        $sum = $n->querySelector('summary');
        $body = '';
        foreach ($n->childNodes as $c) {
            if (!($c instanceof Dom\Element && strtolower($c->localName) === 'summary')) {
                $body .= blocks($c, $page);
            }
        }
        $label = preg_replace('/^Trick lỏ\s*/u', 'Trick lỏ: ', norm($sum?->textContent ?? ''));
        return '<details>' . "\n\n" . '<summary>' . htmlspecialchars($label) . "</summary>\n\n" . trim($body) . "\n\n</details>\n\n";
    }
    if (preg_match('/ admon /', $cls)) {
        $style = match (true) {
            str_contains($cls, ' warning ') || str_contains($cls, ' caution ') => 'danger',
            str_contains($cls, ' important ') => 'warning',
            str_contains($cls, ' tip ') => 'success',
            default => 'info',
        };
        $body = '';
        foreach ($n->children as $c) {
            $ct = strtolower($c->localName);
            if ($ct === 'img') {
                continue;
            }
            $body .= preg_match('/^h\d$/', $ct) ? '**' . inline_all($c, $page) . "**\n\n" : blocks($c, $page);
        }
        return '{% hint style="' . $style . '" %}' . "\n" . trim($body) . "\n{% endhint %}\n\n";
    }
    if (str_contains($cls, ' seg ')) {
        $title = $n->querySelector('.segtitle');
        $body = $n->querySelector('.segbody');
        return '* **' . trim(inline_all($title, $page), '* ') . '** ' . ($body ? inline_all($body, $page) : '') . "\n";
    }
    if (str_contains($cls, ' segmentedlist ')) {
        return children_blocks($n, $page) . "\n";
    }
    if (str_contains($cls, ' navheader ') || str_contains($cls, ' navfooter ')) {
        return '';
    }
    return children_blocks($n, $page);
}

function children_blocks(Dom\Element $el, string $page): string
{
    $out = '';
    $run = ''; // inline nodes between blocks (e.g. <li>text <code>x</code></li>)
    foreach ($el->childNodes as $c) {
        if (is_block($c)) {
            if (trim($run) !== '') {
                $out .= trim(preg_replace('/[ \t]+/u', ' ', $run)) . "\n\n";
            }
            $run = '';
            $out .= blocks($c, $page);
        } else {
            $run .= inline($c, $page);
        }
    }
    if (trim($run) !== '') {
        $out .= trim(preg_replace('/[ \t]+/u', ' ', $run)) . "\n\n";
    }
    return $out;
}

function table_md(Dom\Element $t, string $page): string
{
    $rows = [];
    foreach ($t->querySelectorAll('tr') as $tr) {
        $cells = [];
        foreach ($tr->children as $td) {
            if (in_array(strtolower($td->localName), ['td', 'th'], true)) {
                $cells[] = str_replace(["\n", '|'], [' ', '\\|'], inline_all($td, $page));
            }
        }
        if ($cells) {
            $rows[] = $cells;
        }
    }
    if (!$rows) {
        return '';
    }
    // "Short descriptions" tables: term | description → a list reads better.
    if (str_contains(' ' . $t->getAttribute('class') . ' ', ' variablelist ')) {
        $out = '';
        foreach ($rows as $r) {
            $out .= '* ' . ($r[0] ?? '') . (isset($r[1]) ? ' — ' . $r[1] : '') . "\n";
        }
        return $out . "\n";
    }
    $w = max(array_map('count', $rows));
    $line = fn(array $r) => '| ' . implode(' | ', array_pad($r, $w, '')) . " |\n";
    $hasHead = $t->querySelector('thead, th') !== null;
    $head = $hasHead ? array_shift($rows) : array_fill(0, $w, '');
    return $line($head) . '|' . str_repeat(' --- |', $w) . "\n" . implode('', array_map($line, $rows)) . "\n";
}

// ---------- export ----------

function rrmdir(string $d): void
{
    if (!is_dir($d)) {
        return;
    }
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($d, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST) as $f) {
        $f->isDir() ? rmdir($f->getPathname()) : unlink($f->getPathname());
    }
    rmdir($d);
}

function put(string $rel, string $md): void
{
    $p = GB . '/' . $rel;
    @mkdir(dirname($p), 0755, true);
    file_put_contents($p, rtrim(preg_replace("/\n{3,}/", "\n\n", $md)) . "\n");
}

if (!is_file(SRC . '/index.html')) {
    fwrite(STDERR, "public/12.4 is missing: run php bin/build.php first\n");
    exit(1);
}
rrmdir(GB);

$titles = [];
$count = 0;
foreach (book_pages() as $rel) {
    if ($rel === 'index.html') {
        continue; // README.md is written below
    }
    $doc = Dom\HTMLDocument::createFromFile(SRC . '/' . $rel, LIBXML_NOERROR);
    $title = preg_replace('/ — LFS 12\.4 tiếng Việt$/u', '', norm($doc->querySelector('title')?->textContent ?? $rel));
    $titles[$rel] = $title;
    $md = "---\ndescription: " . json_encode($doc->querySelector('meta[name=description]')?->getAttribute('content') ?? $title, JSON_UNESCAPED_UNICODE) . "\n---\n\n";
    if ($tricks = $doc->querySelector('.tricks')) {
        $md .= children_blocks($tricks, $rel);
    }
    $md .= children_blocks($doc->querySelector('article.book'), $rel);
    $md .= "\n---\n\n[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/$rel) · [Sửa bản dịch]({$cfg['repo']}/blob/main/i18n/vi/" . preg_replace('/\.html$/', '.json', $rel) . ") · [Đọc trên web](" . SITE . "/12.4/$rel)\n";
    put(md_name($rel), $md);
    $count++;
}

// Appendix D/E: bootscript and udev listings, copied untranslated from upstream.
foreach (glob(SRC . '/scripts/*.html') as $f) {
    $rel = 'scripts/' . basename($f);
    $doc = Dom\HTMLDocument::createFromFile($f, LIBXML_NOERROR);
    $md = '';
    foreach ($doc->body->children as $c) {
        $md .= blocks($c, $rel);
    }
    $md = preg_replace('#\]\((?!https?:)([^)]+?)\.html#', ']($1.md', $md);
    put(md_name($rel), $md . "\n---\n\n[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/$rel)\n");
    $count++;
}

// Images referenced by the book.
foreach (glob(SRC . '/images/*') as $f) {
    @mkdir(GB . '/images', 0755, true);
    copy($f, GB . '/images/' . basename($f));
}

// SUMMARY.md follows the book's table of contents: parts become GitBook groups.
$byTitle = array_flip($titles);
$toc = Dom\HTMLDocument::createFromFile(SRC . '/index.html', LIBXML_NOERROR)->querySelector('nav.toc > ul.toc-root');
$summary = "# Mục lục\n\n* [Linux From Scratch tiếng Việt](README.md)\n* [Trick lỏ](trick-lo.md)\n";

// The page for a chapter/part heading: same title (minus "Chương"/"Phần"/"Phụ lục"),
// else chapterNN/chapterNN.html-style index next to its first child page.
function group_page(string $name, Dom\Element $det, array $byTitle): ?string
{
    $key = fn(string $t) => preg_replace('/^(Chương|Phần|Phụ lục)\s+/u', '', $t);
    foreach ($byTitle as $title => $rel) {
        if ($key($title) === $key($name)) {
            return $rel;
        }
    }
    $a = $det->querySelector('a[href]');
    if ($a) {
        $dir = dirname(substr($a->getAttribute('href'), 6));
        if (in_array($dir . '/' . basename($dir) . '.html', $byTitle, true)) {
            return $dir . '/' . basename($dir) . '.html';
        }
    }
    return null;
}

function sum_items(Dom\Element $ul, int $depth, array $byTitle): string
{
    $out = '';
    $pad = str_repeat('  ', $depth);
    foreach ($ul->children as $li) {
        $det = null;
        $a = $ul2 = null;
        foreach ($li->children as $c) {
            $ln = strtolower($c->localName);
            if ($ln === 'a') {
                $a = $c;
            } elseif ($ln === 'details') {
                $det = $c;
            } elseif ($ln === 'ul') {
                $ul2 = $c;
            }
        }
        if ($det) {
            $name = norm($det->querySelector('summary')->textContent);
            $sub = '';
            foreach ($det->children as $c) {
                if (strtolower($c->localName) === 'ul') {
                    $sub = sum_items($c, $depth + 1, $byTitle);
                }
            }
            $page = group_page($name, $det, $byTitle);
            $out .= $pad . '* ' . ($page ? '[' . $name . '](' . md_name($page) . ')' : $name) . "\n" . $sub;
        } elseif ($a) {
            $href = substr($a->getAttribute('href'), 6);
            $out .= $pad . '* [' . str_replace(['[', ']'], ['\\[', '\\]'], norm($a->textContent)) . '](' . md_name(explode('#', $href)[0]) . ")\n";
            if ($ul2) {
                $out .= sum_items($ul2, $depth + 1, $byTitle);
            }
        }
    }
    return $out;
}

$partNo = 0;
foreach ($toc->children as $li) {
    $det = null;
    foreach ($li->children as $c) {
        if (strtolower($c->localName) === 'details') {
            $det = $c;
        }
    }
    if (!$det) {
        continue;
    }
    $name = norm($det->querySelector('summary')->textContent);
    $ul = null;
    foreach ($det->children as $c) {
        if (strtolower($c->localName) === 'ul') {
            $ul = $c;
        }
    }
    if (str_contains($det->getAttribute('class') ?? '', 'toc-part')) {
        $part = isset($GLOBALS['titles']['part' . (++$partNo) . '.html']) ? 'part' . $partNo . '.html' : null;
        $summary .= "\n## " . $name . "\n\n" . ($part ? '* [' . $name . '](' . md_name($part) . ")\n" : '') . sum_items($ul, 0, $byTitle);
    } else {
        $page = group_page($name, $det, $byTitle);
        $summary .= "\n## " . $name . "\n\n" . ($page ? '* [' . $name . '](' . md_name($page) . ")\n" : '') . sum_items($ul, 0, $byTitle);
    }
}
$summary .= "\n## Phụ lục khác\n\n* [Chỉ mục](longindex.md)\n* [Thông báo pháp lý](legalnotice.md)\n";
put('SUMMARY.md', $summary);

// README (GitBook home) and the tricks page.
$home = Dom\HTMLDocument::createFromFile(ROOT . '/public/index.html', LIBXML_NOERROR);
$readme = "---\ndescription: Bản dịch tiếng Việt sách Linux From Scratch 12.4 (System V), kèm trick lỏ của cộng đồng.\n---\n\n# Linux From Scratch tiếng Việt\n\n"
    . children_blocks($home->querySelector('.hero'), 'index.html')
    . "## Bản quyền\n\nSách LFS © 1999–2025 Gerard Beekmans, theo [CC BY-NC-SA 2.0](https://creativecommons.org/licenses/by-nc-sa/2.0/); lệnh trong sách theo [giấy phép MIT](appendices/mit.md). Bản dịch và trick lỏ cùng giấy phép CC BY-NC-SA 2.0. Đây không phải trang chính thức của dự án LFS.\n\n"
    . "Đọc trên web: " . SITE . " · Mã nguồn bản dịch: {$cfg['repo']}\n";
$readme = preg_replace('/^# (?!Linux From Scratch tiếng Việt$)(.+)$/mu', '**$1**', $readme);
$readme = preg_replace('/\[([^\]]+)\]\(https:\/\/linuxfromscratch\.wrenevil\.tech\/12\.4\/([^)]+)\.html\)/', '[$1]($2.md)', $readme);
put('README.md', $readme);

$tp = Dom\HTMLDocument::createFromFile(ROOT . '/public/trick-lo/index.html', LIBXML_NOERROR);
$tmd = "---\ndescription: Mẹo thực chiến khi làm Linux From Scratch — của cộng đồng, không thuộc sách gốc.\n---\n\n";
foreach ($tp->querySelector('.prose')->children as $c) {
    if (!str_contains(' ' . $c->getAttribute('class') . ' ', ' tag-filter ')) {
        $tmd .= blocks($c, 'trick-lo.html');
    }
}
$tmd = preg_replace('/\[([^\]]+)\]\(https:\/\/linuxfromscratch\.wrenevil\.tech\/12\.4\/([^)]+)\.html\)/', '[$1]($2.md)', $tmd);
put('trick-lo.md', $tmd);

printf("pages=%d -> %s\n", $count + 3, GB);
