<?php
$title = 'Trick lỏ — mẹo thực chiến khi làm Linux From Scratch';
$desc = 'Tổng hợp mẹo, đường tắt và lỗi kinh điển khi làm Linux From Scratch, viết bằng tiếng Việt.';
$allTags = [];
foreach ($tricks as $t) {
    foreach ($t['tags'] as $tag) {
        $allTags[$tag] = true;
    }
}
?>
<div class="prose wide">
  <h1>Trick lỏ</h1>
  <p class="lead">Mẹo "lỏ" nhưng chạy được: đường tắt, thói quen an toàn và những lỗi kinh điển mà người làm LFS hay gặp. Đây là mẹo của cộng đồng, <strong>không phải nội dung sách gốc</strong> — đọc hiểu trước khi dùng.</p>
  <p class="tag-filter" id="tag-filter"><button class="tag active" data-tag="">Tất cả</button><?php foreach (array_keys($allTags) as $tag): ?><button class="tag" data-tag="<?= e($tag) ?>"><?= e($tag) ?></button><?php endforeach; ?></p>
<?php foreach ($tricks as $t): ?>
  <section class="trick-card" id="<?= e($t['slug']) ?>" data-tags="<?= e(implode('|', $t['tags'])) ?>">
    <h2><a href="#<?= e($t['slug']) ?>"><?= e($t['title']) ?></a></h2>
    <?= $t['html'] ?>
    <p class="trick-meta"><?php foreach ($t['tags'] as $tag): ?><span class="tag"><?= e($tag) ?></span><?php endforeach; ?>
      Dùng ở: <?php foreach ($t['pages'] as $i => $p): ?><?= $i ? ', ' : '' ?><a href="/<?= e($ver) ?>/<?= e($p) ?>"><?= e($GLOBALS['titles'][$p] ?? $p) ?></a><?php endforeach; ?></p>
  </section>
<?php endforeach; ?>
</div>
