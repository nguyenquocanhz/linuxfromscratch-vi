<?php
// Check i18n/vi/*.json against i18n/source: valid JSON, tags and links kept.
// Usage: php bin/check-vi.php [page.json ...]
declare(strict_types=1);
require __DIR__ . '/lib.php';

function tag_sig(string $html): array
{
    preg_match_all('/<(\/?)([a-z0-9]+)([^>]*)>/i', $html, $m, PREG_SET_ORDER);
    $sig = [];
    foreach ($m as $t) {
        preg_match('/href="([^"]*)"/', $t[3], $h);
        $sig[] = $t[1] . strtolower($t[2]) . ($h ? '@' . $h[1] : '');
    }
    sort($sig);
    return $sig;
}

$files = array_slice($argv, 1);
if (!$files) {
    $files = array_map(fn($f) => substr($f, strlen(ROOT . '/i18n/vi/')), glob(ROOT . '/i18n/vi/{,*/}*.json', GLOB_BRACE));
}
$bad = $missing = $done = 0;
foreach ($files as $rel) {
    $src = json_decode((string) @file_get_contents(ROOT . "/i18n/source/$rel"), true) ?? [];
    $vi = json_decode((string) @file_get_contents(ROOT . "/i18n/vi/$rel"), true);
    if (!is_array($vi)) {
        echo "$rel: invalid or missing JSON\n";
        $bad++;
        continue;
    }
    foreach ($src as $en) {
        if (!isset($vi[$en]) || trim($vi[$en]) === '') {
            $missing++;
            continue;
        }
        $done++;
        if (tag_sig($en) !== tag_sig($vi[$en])) {
            echo "$rel: tags differ: " . mb_substr(strip_tags($en), 0, 70) . "\n";
            $bad++;
        }
    }
    foreach (array_keys($vi) as $k) {
        if (!in_array($k, $src, true)) {
            echo "$rel: unknown key: " . mb_substr($k, 0, 70) . "\n";
            $bad++;
        }
    }
}
printf("translated=%d missing=%d problems=%d\n", $done, $missing, $bad);
exit($bad ? 1 : 0);
