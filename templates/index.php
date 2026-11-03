<?php
$title = 'Linux From Scratch tiếng Việt — tự dựng hệ điều hành Linux từ mã nguồn';
$desc = 'Bản dịch tiếng Việt sách Linux From Scratch ' . $ver . ': tự biên dịch một hệ thống Linux hoàn chỉnh từ mã nguồn, kèm trick lỏ thực chiến của cộng đồng.';
$first = [
    ['prologue/preface.html', 'Lời nói đầu', 'LFS là gì, tại sao nên tự dựng Linux.'],
    ['chapter02/hostreqs.html', 'Yêu cầu hệ thống chủ', 'Kiểm tra máy của bạn đủ đồ nghề chưa.'],
    ['chapter05/chapter05.html', 'Dựng toolchain chéo', 'Phần khó nhất — và hay nhất.'],
    ['chapter08/chapter08.html', 'Cài phần mềm hệ thống', 'Hơn 80 gói, từng cái một.'],
    ['chapter10/kernel.html', 'Biên dịch kernel', 'Cấu hình và dựng nhân Linux.'],
    ['chapter11/reboot.html', 'Khởi động lại', 'Khoảnh khắc LFS của bạn tự boot.'],
];
?>
<section class="hero">
  <p class="eyebrow">Sách Linux From Scratch <?= e($ver) ?> · bản System V · tiếng Việt</p>
  <h1>Tự tay dựng một hệ điều hành Linux, <span>từng dòng lệnh một.</span></h1>
  <p class="lead">Linux From Scratch (LFS) hướng dẫn bạn biên dịch toàn bộ hệ thống Linux từ mã nguồn — từ trình biên dịch, thư viện C cho tới kernel. Đây là bản dịch tiếng Việt cho cộng đồng, kèm <a href="/trick-lo/">trick lỏ</a> để bạn đỡ vấp những cái hố mà ai cũng từng rơi vào.</p>
  <div class="cta">
    <a class="btn primary" href="/<?= e($ver) ?>/prologue/preface.html">Bắt đầu đọc</a>
    <a class="btn" href="/<?= e($ver) ?>/">Xem mục lục</a>
  </div>
  <dl class="stats">
    <div><dt><?= e((string) $pages) ?></dt><dd>trang sách</dd></div>
    <div><dt><?= e((string) $pct) ?>%</dt><dd>đã dịch</dd></div>
    <div><dt><?= count($tricks) ?></dt><dd>trick lỏ</dd></div>
  </dl>
</section>

<section class="term" aria-label="Ví dụ lệnh">
<pre><span class="c"># Một ngày bình thường của người làm LFS</span>
<b>lfs:~$</b> tar -xf binutils-2.45.tar.xz &amp;&amp; cd binutils-2.45
<b>lfs:~$</b> mkdir -v build &amp;&amp; cd build
<b>lfs:~$</b> ../configure --prefix=$LFS/tools --with-sysroot=$LFS --target=$LFS_TGT
<b>lfs:~$</b> make &amp;&amp; make install   <span class="c"># ~1 SBU, đo thời gian cho các gói sau</span></pre>
</section>

<section class="grid-sec">
  <h2>Lộ trình</h2>
  <div class="cards">
<?php foreach ($first as $i => [$href, $name, $text]): ?>
    <a class="card" href="/<?= e($ver) ?>/<?= e($href) ?>"><span class="num"><?= $i + 1 ?></span><b><?= e($name) ?></b><span><?= e($text) ?></span></a>
<?php endforeach; ?>
  </div>
</section>

<section class="grid-sec">
  <h2>Trick lỏ nổi bật</h2>
  <div class="cards tricks-cards">
<?php foreach (array_slice($tricks, 0, 6) as $t): ?>
    <a class="card" href="/trick-lo/#<?= e($t['slug']) ?>"><span class="trick-badge">Trick lỏ</span><b><?= e($t['title']) ?></b></a>
<?php endforeach; ?>
  </div>
  <p><a href="/trick-lo/">Xem tất cả <?= count($tricks) ?> trick →</a></p>
</section>

<section class="grid-sec two">
  <div>
    <h2>Trước khi bắt đầu</h2>
    <ul class="checks">
      <li>Biết dùng shell Linux cơ bản: <code>cd</code>, <code>tar</code>, sửa file bằng <code>vim</code>/<code>nano</code>.</li>
      <li>Một máy Linux làm hệ thống chủ (khuyên dùng máy ảo), khoảng 30 GB trống.</li>
      <li>Thời gian: vài buổi tối đến vài tuần, tùy máy và độ kiên nhẫn.</li>
      <li>Tinh thần đọc kỹ: <strong>đừng copy lệnh khi chưa hiểu nó làm gì.</strong></li>
    </ul>
  </div>
  <div>
    <h2>Về bản dịch</h2>
    <p>Dịch từ LFS <?= e($ver) ?> (System V). Lệnh, tên gói, đường dẫn được giữ nguyên để bạn chạy y như sách gốc. Mỗi trang có link tới bản tiếng Anh để đối chiếu.</p>
    <p>Thấy chỗ dịch chưa ổn hoặc có trick hay? <a href="/dong-gop/">Góp sức cùng cộng đồng</a>.</p>
  </div>
</section>
