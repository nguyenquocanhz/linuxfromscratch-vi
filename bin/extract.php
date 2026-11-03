<?php
// Write i18n/source/<page>.json with every English segment of the book.
// Usage: php bin/extract.php
declare(strict_types=1);
require __DIR__ . '/lib.php';

$all = [];
foreach (book_pages() as $rel) {
    $doc = load_page($rel);
    $segs = [];
    $titleEl = $doc->querySelector('title');
    if ($titleEl) {
        $segs[] = norm($titleEl->textContent);
    }
    foreach (segments(page_body($doc)) as $el) {
        $segs[] = inner_html($el);
    }
    $segs = array_values(array_unique($segs));
    $out = ROOT . '/i18n/source/' . preg_replace('/\.html$/', '.json', $rel);
    @mkdir(dirname($out), 0755, true);
    file_put_contents($out, json_encode($segs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n");
    foreach ($segs as $s) {
        $all[$s] = ($all[$s] ?? 0) + 1;
    }
}
$words = 0;
foreach (array_keys($all) as $s) {
    $words += str_word_count(strip_tags($s));
}
printf("pages=%d unique=%d words=%d repeated=%d\n", count(book_pages()), count($all), $words, count(array_filter($all, fn($n) => $n > 1)));
