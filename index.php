<?php
$cacheDuration = floor(86400 * 365.25); // 1 year
header("Cache-Control: public, max-age={$cacheDuration}");
header("Expires: " . gmdate("D, d M Y H:i:s", time() + $cacheDuration) . " GMT");
$versionnum = "1.1.6";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

    <!-- seo -->
    <title>
        <?php
        $page = isset($_GET['page']) ? ucfirst(htmlspecialchars($_GET['page'])) . ' | ' : '';
        echo $page;
        ?>
        Nick Esselman – Developer Portfolio & Projects
    </title>

    <meta name="description"
        content="Discover the work of Nick Esselman | a creative developer with 20+ projects and experience in Hack Club events. Explore his skills, portfolio, and programming journey." />

    <link rel="icon" type="image/png" href="./images/logo.png">

    <!-- the css.hackclub.com styling -->
    <link rel="stylesheet" href="https://css.hackclub.com/theme.css">

    <!-- libs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/particles.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanilla-tilt@1.7.2/dist/vanilla-tilt.min.js"></script>
    <!-- animaitions -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/elevator.js/elevator.min.js"></script>
    <script src="https://rawgit.com/WeiChiaChang/Easter-egg/master/easter-eggs-collection.js"></script>
    <script src="scripts/comcastify.js"></script>

    <!-- Client-side validation -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>
    <script src="https://unpkg.com/lightstreamer-client-web/lightstreamer.min.js"></script>

    <!-- Physics system + plugins -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/matter-js/0.20.0/matter.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/matter-dom-plugin@1.0.0/build/matter-dom-plugin.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/matter-attractors@0.1.6/build/matter-attractors.min.js"></script>

    <!-- basic css -->
    <link rel="stylesheet" href="css/reset.css?v=<?= $versionnum ?>">
    <link rel="stylesheet" href="css/main.css?v=<?= $versionnum ?>">
    <link rel="stylesheet" href="css/topmenuoffset.css?v=<?= $versionnum ?>">

    <!-- add css of the page Im on -->
    <?php
    $page = isset($_GET['page']) ? $_GET['page'] : 'home';
    if (isset($_GET['project']))
        $page = 'null';
    $cssFile = "css/{$page}.css";
    if (file_exists($cssFile)):
        ?>
        <link rel="stylesheet" href="<?php echo $cssFile; ?>?v=<?= $versionnum ?>">
    <?php endif;
    ?>

</head>

<body>
    <?php
    include 'projects.php';
    include 'pages/specials/header.php';
    ?>
    <main id="inner-main" class="inner-main">
        <?php
        $page = $_GET['page'] ?? null;
        $project = $_GET['project'] ?? null;

        if ($page === null && $project === null) {
            $page = 'home';
        }

        if ($page !== null) {
            if (file_exists("pages/$page.php")) {
                include "pages/$page.php";
            } else {
                include 'pages/specials/404.php';
            }
        } else if ($project !== null) {
            $selectedProject = null;
            foreach ($projects as $proj) {
                if ($proj['link'] === $project) {
                    $selectedProject = $proj;
                    break;
                }
            }

            if ($selectedProject) {
                if (isset($selectedProject['basiclayout']) && $selectedProject['basiclayout'] === 'true') {
                    include 'projects/basiclayout.php';
                } else if (file_exists("projects/$project.php")) {
                    include "projects/$project.php";
                } else {
                    include 'pages/specials/404.php';
                }
            } else {
                include 'pages/specials/404.php';
            }
        } else {
            include 'pages/home.php';
        }
        ?>
    </main>
    <!-- Modal for image preview -->
    <div id="imageModal" class="modal" style="display:none;">
        <span class="modal-close" id="modalClose">&times;</span>
        <img class="modal-content" id="modalImg" src="" alt="Preview">
    </div>
    <?php
    include 'pages/specials/footer.php';
    ?>
    <script>
        var page = "<?php echo $page; ?>"

        // your normal AOS settings
        const aosOptions = {
            offset: 120,
            duration: 400,
            easing: 'ease',
            once: false
        };

        function disableAllAOS() {
            AOS.init({ ...aosOptions, disable: true });

            document.body.classList.add('no-hover');
        }

        function enableAllAOS() {
            AOS.init({ ...aosOptions, disable: false });
            AOS.refresh();
            document.body.classList.remove('no-hover');
        }

        AOS.init(aosOptions);
    </script>



    <!-- physics engine -->
    <div id="devView">
        <strong>Dev View</strong>
        <div id="devInfo"></div>
    </div>

    <?php if ($page != "cv"): ?>
        <script src="scripts/unnecessary.js?v=<?= $versionnum ?>"></script>
        <script src="scripts/main.js?v=<?= $versionnum ?>"></script>
        <script src="scripts/special-menus.js?v=<?= $versionnum ?>"></script>
        <script src="scripts/matterrun.js?v=<?= $versionnum ?>"></script>
        <script src="scripts/physics-configs.js?v=<?= $versionnum ?>"></script>
        <script src="scripts/physics-controls.js?v=<?= $versionnum ?>"></script>
        <script src="scripts/special-menu-controls.js?v=<?= $versionnum ?>"></script>
        <?php
        include 'pages/specials/duckhunt.php';
        include 'pages/specials/specialsmenu.php';
        ?>
    <?php endif; ?>

</body>

</html>