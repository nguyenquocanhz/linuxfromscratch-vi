<?php
/* =========================================================
   Markdown → HTML, đủ dùng cho blog kỹ thuật, không cần thư viện ngoài.

   Hỗ trợ: tiêu đề (#..######, có id để dẫn link), đoạn văn, **đậm**, *nghiêng*, `mã`, khối mã ```ngôn-ngữ,
   danh sách (- * 1.), trích dẫn (>), đường kẻ (---), liên kết, ảnh, bảng (| a | b | và dòng |---|---|).

   An toàn trước hết: mọi chữ được mã hoá HTML TRƯỚC khi xử lý Markdown, nên HTML viết thẳng trong bài
   hiện ra dạng chữ chứ không chạy. Liên kết và ảnh chỉ nhận http(s), đường dẫn nội bộ (/...) và #neo.
   ========================================================= */

function md_escape(string $text): string
{
    return htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** "Mục hai" → "muc-hai": dùng làm id tiêu đề. */
function md_slug(string $text): string
{
    $text = mb_strtolower($text, 'UTF-8');
    $map = ['a' => 'áàảãạăắằẳẵặâấầẩẫậ', 'd' => 'đ', 'e' => 'éèẻẽẹêếềểễệ', 'i' => 'íìỉĩị', 'o' => 'óòỏõọôốồổỗộơớờởỡợ', 'u' => 'úùủũụưứừửữự', 'y' => 'ýỳỷỹỵ'];
    foreach ($map as $ascii => $chars) {
        $text = preg_replace('/[' . $chars . ']/u', $ascii, $text) ?? '';
    }
    return trim(preg_replace('/[^a-z0-9]+/', '-', $text) ?? '', '-') ?: 'muc';
}

/** Đường dẫn an toàn cho href/src, hoặc null. $url đã được mã hoá HTML. */
function md_safe_url(string $url): ?string
{
    $plain = html_entity_decode($url, ENT_QUOTES, 'UTF-8');
    return preg_match('#^(https?://[^\s]+|/[^\s]*|\#[\w-]+)$#i', $plain) ? md_escape($plain) : null;
}

/** Định dạng trong dòng. $text đã được mã hoá HTML. */
function md_inline(string $text): string
{
    // Giữ riêng đoạn `mã` để không bị xử lý đậm/nghiêng/liên kết bên trong
    $codes = [];
    $text = preg_replace_callback('/`([^`]+)`/', function ($m) use (&$codes) {
        $codes[] = '<code>' . $m[1] . '</code>';
        return "\x01" . (count($codes) - 1) . "\x01";
    }, $text) ?? $text;

    $text = preg_replace_callback('/!\[([^\]]*)\]\(([^)\s]+)\)/', function ($m) {
        $src = md_safe_url($m[2]);
        return $src ? '<img src="' . $src . '" alt="' . $m[1] . '" loading="lazy" decoding="async">' : $m[1];
    }, $text) ?? $text;

    $text = preg_replace_callback('/\[([^\]]+)\]\(([^)\s]+)\)/', function ($m) {
        $href = md_safe_url($m[2]);
        if (!$href) {
            return $m[1];
        }
        return str_starts_with($href, 'http') ? '<a href="' . $href . '" rel="noopener" target="_blank">' . $m[1] . '</a>' : '<a href="' . $href . '">' . $m[1] . '</a>';
    }, $text) ?? $text;

    $text = preg_replace('/\*\*(.+?)\*\*/u', '<strong>$1</strong>', $text) ?? $text;
    $text = preg_replace('/(?<![\w*])\*(?!\s)(.+?)(?<!\s)\*(?![\w*])/u', '<em>$1</em>', $text) ?? $text;

    return preg_replace_callback("/\x01(\d+)\x01/", fn ($m) => $codes[(int) $m[1]], $text) ?? $text;
}

function markdown(string $source): string
{
    $lines = preg_split('/\R/u', str_replace("\t", '    ', $source)) ?: [];
    $html = [];
    $paragraph = [];
    $list = null;      // ['ul'|'ol', [mục...]]
    $quote = [];
    $usedIds = [];

    $flush = function () use (&$html, &$paragraph, &$list, &$quote) {
        if ($paragraph) {
            $html[] = '<p>' . md_inline(md_escape(implode(' ', $paragraph))) . '</p>';
            $paragraph = [];
        }
        if ($list) {
            $html[] = '<' . $list[0] . '>' . implode('', array_map(fn ($item) => '<li>' . md_inline(md_escape($item)) . '</li>', $list[1])) . '</' . $list[0] . '>';
            $list = null;
        }
        if ($quote) {
            $html[] = '<blockquote><p>' . md_inline(md_escape(implode(' ', $quote))) . '</p></blockquote>';
            $quote = [];
        }
    };

    for ($i = 0, $count = count($lines); $i < $count; $i++) {
        $line = $lines[$i];

        // Khối mã: giữ nguyên từng ký tự, kể cả khoảng trắng đầu dòng
        if (preg_match('/^```\s*([\w+-]*)\s*$/', $line, $m)) {
            $flush();
            $code = [];
            for ($i++; $i < $count && !preg_match('/^```\s*$/', $lines[$i]); $i++) {
                $code[] = $lines[$i];
            }
            $lang = $m[1] !== '' ? ' class="language-' . md_escape(strtolower($m[1])) . '"' : '';
            $html[] = '<pre><code' . $lang . '>' . md_escape(implode("\n", $code)) . '</code></pre>';
            continue;
        }
        if (trim($line) === '') {
            $flush();
            continue;
        }
        if (preg_match('/^(#{1,6})\s+(.+?)\s*#*\s*$/u', $line, $m)) {
            $flush();
            $level = strlen($m[1]);
            $id = md_slug($m[2]);
            $base = $id;
            for ($n = 2; isset($usedIds[$id]); $n++) {
                $id = $base . '-' . $n;
            }
            $usedIds[$id] = true;
            $html[] = '<h' . $level . ' id="' . $id . '">' . md_inline(md_escape($m[2])) . '</h' . $level . '>';
            continue;
        }
        // Bảng: dòng tiêu đề | a | b |, ngay dưới là dòng kẻ |---|---|
        if (str_contains($line, '|') && isset($lines[$i + 1]) && preg_match('/^\s*\|?\s*:?-{3,}:?\s*(\|\s*:?-{3,}:?\s*)+\|?\s*$/', $lines[$i + 1])) {
            $flush();
            $cells = fn (string $row) => array_map('trim', explode('|', trim(trim($row), '|')));
            $head = $cells($line);
            $rows = [];
            for ($i += 2; $i < $count && str_contains($lines[$i], '|') && trim($lines[$i]) !== ''; $i++) {
                $rows[] = array_pad(array_slice($cells($lines[$i]), 0, count($head)), count($head), '');
            }
            $i--;
            $td = fn (string $tag, array $row) => '<tr>' . implode('', array_map(fn ($c) => "<$tag>" . md_inline(md_escape($c)) . "</$tag>", $row)) . '</tr>';
            $html[] = '<div class="table-wrap"><table><thead>' . $td('th', $head) . '</thead><tbody>'
                . implode('', array_map(fn ($r) => $td('td', $r), $rows)) . '</tbody></table></div>';
            continue;
        }
        if (preg_match('/^\s*([-*_])(\s*\1){2,}\s*$/', $line)) {
            $flush();
            $html[] = '<hr>';
            continue;
        }
        if (preg_match('/^>\s?(.*)$/u', $line, $m)) {
            if ($paragraph || $list) {
                $flush();
            }
            $quote[] = $m[1];
            continue;
        }
        if (preg_match('/^\s*(?:([-*+])|(\d+)[.)])\s+(.+)$/u', $line, $m)) {
            $type = $m[1] !== '' ? 'ul' : 'ol';
            if ($paragraph || $quote || ($list && $list[0] !== $type)) {
                $flush();
            }
            $list ??= [$type, []];
            $list[1][] = $m[3];
            continue;
        }
        // Dòng tiếp nối của mục danh sách (thụt đầu dòng)
        if ($list && preg_match('/^\s{2,}(\S.*)$/u', $line, $m)) {
            $list[1][count($list[1]) - 1] .= ' ' . $m[1];
            continue;
        }
        if ($list || $quote) {
            $flush();
        }
        $paragraph[] = trim($line);
    }
    $flush();
    return implode("\n", $html);
}
