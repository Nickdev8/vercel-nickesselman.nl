<?php
include_once 'basics.php';
?>
<?php if (!empty($selectedProject['blocks'])): ?>
    <?php foreach ($selectedProject['blocks'] as $block): ?>

        <?php
        $hasImage         = !empty($block['image']);
        $hasTitle         = !empty($block['title']);
        $hasSubtitle      = !empty($block['subtitle']);
        $hasContent       = !empty($block['content']);
        $hasContentInSplit= !empty($block['split']);
        $isOnlyImage      = $hasImage && !($hasTitle || $hasSubtitle || $hasContent);

        $wrapperClass = $isOnlyImage
            ? 'wide container separator img-wide'
            : 'card container separator';

        // normalize images into an array
        $images = [];
        if ($hasImage) {
            $images = is_array($block['image'])
                ? $block['image']
                : [ $block['image'] ];
        }
        ?>

        <div class="<?= $wrapperClass ?>">

            <?php if (!$isOnlyImage): ?>
                <?php if ($hasTitle): ?>
                    <h2 class="headline"><?= htmlspecialchars($block['title']) ?></h2>
                <?php endif; ?>
                <?php if ($hasSubtitle): ?>
                    <h3 class="lead"><?= htmlspecialchars($block['subtitle']) ?></h3>
                <?php endif; ?>
            <?php endif; ?>

            <?php
            // 1) If there's split content, always render a split layout
            if ($hasContentInSplit): ?>
                <div class="split">
                    <div>
                        <?= $block['content'] ?? '' ?>
                    </div>
                    <div>
                        <?= $block['split'] ?>
                    </div>
                </div>

            <?php
            // 2) No images at all? then just render the content
            elseif (!$hasImage): ?>
                <div>
                    <?= $block['content'] ?? '' ?>
                </div>

            <?php
            // 3) Only images (no title, subtitle, or content) => full-width images
            elseif ($isOnlyImage): ?>
                <?php foreach ($images as $img): ?>
                    <img src="<?= htmlspecialchars($img) ?>" alt="" class="img-full">
                <?php endforeach; ?>

            <?php
            // 4) images + content (but no split) => split with images on right
            else: ?>
                <div class="split">
                    <div>
                        <?= $block['content'] ?? '' ?>
                    </div>
                    <div>
                        <?php foreach ($images as $img): ?>
                            <img src="<?= htmlspecialchars($img) ?>"
                                 alt="<?= htmlspecialchars($block['title'] ?? 'Block image') ?>"
                                 style="border-radius: 2rem;">
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    <?php endforeach; ?>
<?php endif; ?>