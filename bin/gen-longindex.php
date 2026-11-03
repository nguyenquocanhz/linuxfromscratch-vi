<?php
// The index page is names plus section titles: build its translation from
// the translated section titles instead of by hand. Re-run after editing them.
// Usage: php bin/gen-longindex.php
declare(strict_types=1);
require __DIR__ . '/lib.php';

$tm = [];
foreach (glob(ROOT . '/i18n/vi/{,*/}*.json', GLOB_BRACE) as $f) {
    if (!str_ends_with($f, '/longindex.json')) {
        $tm += json_decode((string) file_get_contents($f), true) ?: [];
    }
}
// "9.7.&nbsp;Configuring X" => "Cấu hình X" (numbers stripped on both sides)
$titles = [];
$strip = fn(string $s) => trim(preg_replace('/^([A-Z]\.|\d+\.)(\d+\.)*(\s|&nbsp;|\x{00A0})*/u', '', html_entity_decode(strip_tags($s), ENT_QUOTES | ENT_HTML5, 'UTF-8')));
foreach ($tm as $en => $vi) {
    $k = $strip($en);
    if ($k !== '' && !isset($titles[$k])) {
        $titles[$k] = $strip($vi);
    }
}
$labels = [
    'tools:' => 'công cụ tạm:', 'tools, pass 1:' => 'công cụ tạm, lượt 1:', 'tools, pass 2:' => 'công cụ tạm, lượt 2:',
    'tools, libstdc++ pass 1:' => 'công cụ tạm, libstdc++ lượt 1:', 'tools, API headers:' => 'công cụ tạm, header API:',
    'configuring:' => 'cấu hình:', 'usage:' => 'cách dùng:', 'temporary:' => 'tạm thời:',
];
$heads = ['Index' => 'Chỉ mục', 'Packages' => 'Gói', 'Programs' => 'Chương trình', 'Libraries' => 'Thư viện', 'Scripts' => 'Script', 'Others' => 'Khác'];

$src = json_decode((string) file_get_contents(ROOT . '/i18n/source/longindex.json'), true);
$out = [];
$miss = 0;
foreach ($src as $en) {
    $vi = preg_replace_callback('/(<strong class="secitem">)([^<]*)(<\/strong>)/', fn($m) => $m[1] . ($labels[$m[2]] ?? $m[2]) . $m[3], $en);
    $vi = preg_replace_callback('/(<a href="[^"]*">)([^<]*)(<\/a>)/', function ($m) use ($titles, &$miss) {
        if (!str_contains($m[2], ' ')) {
            return $m[0];
        }
        $plain = html_entity_decode($m[2], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        if (isset($titles[$plain])) {
            return $m[1] . htmlspecialchars($titles[$plain], ENT_NOQUOTES, 'UTF-8') . $m[3];
        }
        $miss++;
        return $m[0];
    }, $vi);
    $vi = preg_replace_callback('/(<\/a>|^)(Index|Packages|Programs|Libraries|Scripts|Others)$/', fn($m) => $m[1] . $heads[$m[2]], $vi);
    $vi = preg_replace('/(<\/a>|^)(\w[^<]*?) - Pass (\d)$/', '$1$2 - Lượt $3', $vi);
    $vi = str_replace(">description</a>", ">mô tả</a>", $vi);
    $out[$en] = $vi;
}
file_put_contents(ROOT . '/i18n/vi/longindex.json', json_encode($out, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n");
echo "entries=" . count($out) . " titles_not_found=$miss\n";
