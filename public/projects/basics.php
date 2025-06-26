<?php
include_once 'adddata.php';

$blocks = $selectedProject['blocks'] ?? [];
$firstBlock = $blocks[0] ?? null;
$hasOnlyImage = $firstBlock
  && !empty($firstBlock['image'])
  && empty($firstBlock['title'])
  && empty($firstBlock['subtitle'])
  && empty($firstBlock['content']);

  if ($hasOnlyImage) {
  $imgs = is_array($firstBlock['image'])
    ? $firstBlock['image']
    : [$firstBlock['image']];
  $bg = $imgs[0];
}
?>
<?php if ($hasOnlyImage): ?>
  <style>
    .header-overlay {
      position: relative;
    }

    .header-overlay .overlay-text {
      position: absolute;
      top: 3rem;
      left: 5rem;
      color: #fff;
      z-index: 2;
      text-shadow: 0 0 4px rgba(0, 0, 0, 0.7);
    }

    .header-overlay .overlay-text h1,
    .header-overlay .overlay-text p {
      color: #fff;
    }

    .header-overlay img.bg {
      display: block;
      width: 100%;
      height: auto;
    }
  </style>

  <div class="container wide separator header-overlay">
    <div class="overlay-text">
      <h1><?= htmlspecialchars($selectedProject['title']) ?></h1>
      <p><?= htmlspecialchars($selectedProject['description']) ?></p>
    </div>
  </div>
<?php else: ?>
  <div class="container separator">
    <h1><?= htmlspecialchars($selectedProject['title']) ?></h1>
    <p><?= htmlspecialchars($selectedProject['description']) ?></p>
  </div>
<?php endif; ?>

<?php
include_once './pages/specials/totopbutton.php';
?>