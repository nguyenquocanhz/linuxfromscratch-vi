<?php
// Shared helpers: find translatable segments in an upstream LFS page.
declare(strict_types=1);

const ROOT = __DIR__ . '/..';
const BOOK = ROOT . '/upstream/12.4';

const SEG_TAGS = ['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'dt', 'th', 'td', 'li', 'caption', 'strong.segtitle', 'span.segbody'];
const BLOCK_TAGS = ['p', 'pre', 'div', 'ul', 'ol', 'dl', 'table', 'blockquote', 'h1', 'h2', 'h3', 'h4', 'h5'];

function book_pages(): array
{
    $out = [];
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(BOOK, FilesystemIterator::SKIP_DOTS));
    foreach ($it as $f) {
        $rel = substr($f->getPathname(), strlen(BOOK) + 1);
        if (str_ends_with($rel, '.html') && !str_starts_with($rel, 'scripts/')) {
            $out[] = $rel;
        }
    }
    sort($out);
    return $out;
}

function load_page(string $rel): Dom\HTMLDocument
{
    return Dom\HTMLDocument::createFromFile(BOOK . '/' . $rel, LIBXML_NOERROR);
}

function page_body(Dom\HTMLDocument $doc): Dom\Element
{
    return $doc->body;
}

function norm(string $html): string
{
    return trim(preg_replace('/\s+/u', ' ', $html));
}

function inner_html(Dom\Element $el): string
{
    return norm($el->innerHTML);
}

function has_block_child(Dom\Element $el): bool
{
    foreach ($el->querySelectorAll('*') as $d) {
        if (in_array(strtolower($d->localName), BLOCK_TAGS, true)) {
            return true;
        }
    }
    return false;
}

// Elements whose inner HTML is one translatable unit.
function segments(Dom\Element $root): array
{
    $segs = [];
    foreach ($root->querySelectorAll(implode(',', SEG_TAGS)) as $el) {
        if ($el->closest('pre, .navheader, .navfooter') || has_block_child($el)) {
            continue;
        }
        $text = norm($el->textContent);
        if ($text === '' || !preg_match('/[A-Za-z]{2}/', $text)) {
            continue;
        }
        // Lone code, e.g. <td><code>gcc</code></td>, stays as is.
        $kids = array_filter(iterator_to_array($el->childNodes), fn($n) => !($n instanceof Dom\Text && trim($n->textContent) === ''));
        if (count($kids) === 1 && $kids[array_key_first($kids)] instanceof Dom\Element
            && in_array(strtolower($kids[array_key_first($kids)]->localName), ['code', 'kbd', 'span'], true)
            && !preg_match('/\s/', $text)) {
            continue;
        }
        $segs[] = $el;
    }
    return $segs;
}
