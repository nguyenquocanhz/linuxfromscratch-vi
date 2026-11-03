<?php
$title = 'Đóng góp bản dịch LFS tiếng Việt';
$desc = 'Cách góp sức dịch, sửa bản dịch và viết trick lỏ cho Linux From Scratch tiếng Việt.';
$left = $stats['seg'] - $stats['vi'];
?>
<div class="prose">
  <h1>Đóng góp</h1>
  <p class="lead">Bản dịch này là của cộng đồng. Hiện đã dịch <b><?= e((string) $pct) ?>%</b> (<?= number_format($stats['vi'], 0, ',', '.') ?>/<?= number_format($stats['seg'], 0, ',', '.') ?> đoạn)<?= $left > 0 ? ', còn ' . number_format($left, 0, ',', '.') . ' đoạn tiếng Anh được đánh dấu viền vàng trong từng trang' : '' ?>.</p>

  <h2>Bản dịch được lưu thế nào</h2>
  <p>Mỗi trang sách có một file JSON trong <code>i18n/vi/</code>, ánh xạ <em>câu tiếng Anh → câu tiếng Việt</em>. Lệnh và khối code không nằm trong đó nên luôn giống hệt sách gốc. Bộ build ghép bản dịch vào HTML gốc của LFS; câu nào chưa dịch thì giữ tiếng Anh.</p>
<pre><code>i18n/source/chapter05/glibc.json   # câu gốc (tự sinh, đừng sửa)
i18n/vi/chapter05/glibc.json       # bản dịch: { "English": "Tiếng Việt" }
i18n/GLOSSARY.md                   # bảng thuật ngữ — đọc trước khi dịch
tricks/*.md                        # trick lỏ, mỗi file một mẹo</code></pre>

  <h2>Quy tắc dịch</h2>
  <ul>
    <li>Giữ nguyên mọi thẻ HTML, <code>href</code>, <code>class</code>; chỉ dịch chữ hiển thị.</li>
    <li>Không dịch lệnh, tên gói, đường dẫn, tùy chọn, biến môi trường.</li>
    <li>Theo bảng thuật ngữ trong <code>GLOSSARY.md</code>; xưng "bạn", câu ngắn và rõ.</li>
    <li>Chạy <code>php bin/check-vi.php</code> trước khi gửi — nó báo câu sai thẻ hoặc còn thiếu.</li>
  </ul>

  <h2>Viết một trick lỏ</h2>
<pre><code>---
title: Tên mẹo ngắn gọn
pages: chapter05/gcc-pass1.html, chapter08/gcc.html
tags: hiệu năng, gcc
---
Nội dung Markdown. Giải thích **vì sao** mẹo chạy được và khi nào **không nên** dùng.</code></pre>
  <p>Mẹo phải đúng với LFS <?= e($ver) ?> và đã tự thử. Mẹo nào có rủi ro thì ghi rõ rủi ro.</p>

  <h2>Gửi đóng góp</h2>
<?php if ($repo): ?>
  <p>Mã nguồn và bản dịch ở <a href="<?= e($repo) ?>" rel="noopener"><?= e($repo) ?></a>. Fork, sửa file, chạy kiểm tra rồi mở pull request. Mỗi trang sách cũng có nút "Sửa bản dịch" dẫn thẳng tới file JSON của trang đó.</p>
<?php else: ?>
  <p>Kho Git công khai đang được chuẩn bị. Trong lúc chờ, bạn có thể gửi góp ý qua <a href="https://contact.nguyenquocanh.io.vn/" rel="noopener">trang liên hệ</a>, ghi rõ trang và câu cần sửa.</p>
<?php endif; ?>

  <h2>Giấy phép</h2>
  <p>Sách LFS © 1999–2025 Gerard Beekmans, phát hành theo <a href="https://creativecommons.org/licenses/by-nc-sa/2.0/" rel="noopener">Creative Commons BY-NC-SA 2.0</a>; lệnh trong sách theo giấy phép MIT. Bản dịch và trick lỏ cũng theo CC BY-NC-SA 2.0: dùng lại được, ghi nguồn, không thương mại, chia sẻ cùng giấy phép.</p>
</div>
