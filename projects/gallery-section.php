<?php
session_start();

$excludedDirs = [
    'images/innerprojects/stickers/',
    'images/innerprojects/econest/',
    'images/innerprojects/highseas/',
    'images/innerprojects/hackpad/',
    'images/innerprojects/projectsimages/',
    'images/innerprojects/gamejams/',
    'images/innerprojects/jazzdesign/',
    'images/innerprojects/neighborhood/',
    'images/innerprojects/juice/',
    'images/projectsimages/',
    'images/duckhunt/',
    'images/specials/',
];

$imageExtensions = ['png', 'jpeg', 'png', 'gif'];
$videoExtensions = ['mp4', 'webm'];
$panoExtensions = ['pano', 'PANO.png'];
$baseDirectory = './images';

if (!isset($_SESSION['gallery_images'])) {
    $allFiles = [];
    $it = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($baseDirectory, FilesystemIterator::SKIP_DOTS)
    );
    foreach ($it as $file) {
        if (!$file->isFile()) {
            continue;
        }
        $relative = substr($file->getPathname(), strlen($baseDirectory) + 1);
        if (strpos($relative, '/') === false) {
            continue;
        }
        $ext = strtolower(pathinfo($file->getFilename(), PATHINFO_EXTENSION));
        if (
            in_array($ext, $imageExtensions, true) ||
            in_array($ext, $videoExtensions, true) ||
            in_array($ext, $panoExtensions, true)
        ) {
            $webPath = $file->getPathname();
            if (strpos($webPath, './') === 0) {
                $webPath = substr($webPath, 2);
            }
            $skip = false;
            foreach ($excludedDirs as $dir) {
                if (strpos($webPath, $dir) === 0) {
                    $skip = true;
                    break;
                }
            }
            if ($skip) {
                continue;
            }
            $allFiles[] = $file->getPathname();
        }
    }
    shuffle($allFiles);
    $_SESSION['gallery_images'] = $allFiles;
}

function outputMedia(int $offset, int $limit): void
{
    global $imageExtensions, $videoExtensions, $panoExtensions;
    if (!isset($_SESSION['gallery_images'])) {
        return;
    }
    $files = $_SESSION['gallery_images'];
    $total = count($files);
    $validCount = 0;

    for ($i = $offset; $i < $total && $validCount < $limit; $i++) {
        $filePath = $files[$i];
        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $webPath = $filePath;
        if (strpos($webPath, './') === 0) {
            $webPath = substr($webPath, 2);
        }

        if (in_array($ext, $imageExtensions, true)) {
            $imageInfo = @getimagesize($filePath);
            if (!$imageInfo) {
                continue;
            }
        } elseif (in_array($ext, $videoExtensions, true) || in_array($ext, $panoExtensions, true)) {
            if (!file_exists($filePath)) {
                continue;
            }
        }

        $webPathEsc = htmlspecialchars($webPath, ENT_QUOTES);

        if (in_array($ext, $imageExtensions, true)) {
            $imageInfo = @getimagesize($filePath);
            $isLandscape = $imageInfo && ($imageInfo[0] > $imageInfo[1]);
            $class = $isLandscape ? 'landscape' : '';
            echo <<<HTML
<div data-aos="zoom-in" class="physics media {$class}">
    <img src="{$webPathEsc}" alt="Image">
</div>
HTML;
        } elseif (in_array($ext, $videoExtensions, true)) {
            echo <<<HTML
<div data-aos="zoom-in" class="physics media">
    <video controls>
        <source src="{$webPathEsc}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</div>
HTML;
        } elseif (in_array($ext, $panoExtensions, true)) {
            echo <<<HTML
<div data-aos="zoom-in" class="physics media">
    <iframe src="{$webPathEsc}" frameborder="0" allowfullscreen></iframe>
</div>
HTML;
        }
        $validCount++;
    }
}

if (isset($_GET['offset'])) {
    $offset = intval($_GET['offset']);
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 15;
    outputMedia($offset, $limit);
    exit;
}
?>
<div class="card wide objectToMoreToTheBackClasses container separator" data-aos="fade-up">
    <h2 class="headline">More images</h2>
    <div class="grid" id="imageGrid">
        <?php
        outputMedia(0, 10);
        ?>
    </div>

    <button id="loadMoreBtn" class="btn" style="display: block; margin: 1em auto;">
        Load More
    </button>
    <div id="sentinel" style="height: 1px;"></div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const excludedDirs = [
            'images/innerprojects/stickers/',
            'images/innerprojects/econest/',
            'images/innerprojects/highseas/',
            'images/innerprojects/hackpad/',
            'images/innerprojects/projectsimages/',
            'images/innerprojects/gamejams/',
            'images/innerprojects/jazzdesign/',
            'images/innerprojects/neighborhood/',
            'images/innerprojects/juice/',
            'images/projectsimages/',
            'images/duckhunt/',
            'images/specials/',
        ];

        function isInExcludedDir(imgSrc) {
            return excludedDirs.some(dir => imgSrc.startsWith(dir));
        }

        const grid = document.getElementById('imageGrid');
        const loadMoreBtn = document.getElementById('loadMoreBtn');
        if (!grid) return;

        let offset = grid.querySelectorAll('.media').length;
        const limit = 10;
        let isLoading = false;

        function loadMoreImages(trigger = 'button') {
            if (isLoading) return;
            isLoading = true;
            console.debug(`[Gallery] Loading more (offset=${offset}, limit=${limit}, trigger=${trigger})`);

            fetch(`<?php echo basename(__FILE__); ?>?offset=${offset}&limit=${limit}`)
                .then(resp => resp.text())
                .then(htmlString => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(htmlString, 'text/html');
                    const newItems = Array.from(doc.querySelectorAll('.media'));

                    let addedCount = 0;
                    newItems.forEach(item => {
                        const img = item.querySelector('img');
                        if (img) {
                            const src = img.getAttribute('src') || '';
                            if (isInExcludedDir(src)) {
                                return;
                            }
                        }
                        grid.appendChild(item);
                        addedCount++;
                    });

                    offset += addedCount;
                    isLoading = false;
                    console.debug(`[Gallery] Appended ${addedCount} items, new offset = ${offset}`);

                    if (addedCount === 0) {
                        loadMoreBtn.style.display = 'none';
                    }
                })
                .catch(err => {
                    console.error('[Gallery] Error loading images:', err);
                    isLoading = false;
                });
        }

        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', () => loadMoreImages('button'));
        }

        // Modal setup (unchanged).
        function setupModal() {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImg');
            const closeBtn = document.getElementById('modalClose');
            if (!modal || !modalImg || !closeBtn) return;

            grid.addEventListener('click', e => {
                const target = e.target;
                if (target.tagName !== 'IMG') return;
                if (!target.closest('.media')) return;

                modal.style.display = 'flex';
                modalImg.src = target.src;
                modalImg.alt = target.alt || '';
            });

            closeBtn.addEventListener('click', () => {
                modal.style.display = 'none';
            });
            modal.addEventListener('click', e => {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });
            document.addEventListener('keydown', e => {
                if (modal.style.display !== 'none' && (e.key === 'Escape' || e.key === 'Esc')) {
                    modal.style.display = 'none';
                }
            });
        }

        setupModal();
    });
</script>