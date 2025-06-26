<div class="main-top">
    <!-- <div id="particles-js" style="position:absolute;top:0;left:0;width:100%;height:auto;z-index:1;overflow:hidden;"></div> -->
    <div style="margin:auto; width: fit-content;">
        <h1 class="sawarabi-mincho-regular ultratitle physics"
            style="background-color: var(--myblue); padding: 1rem; border-radius: 0.5rem">
            Nick Esselman</h1>
    </div>

    <div class="physics"
        style="margin:auto; width: fit-content; background-color: var(--myblue); padding: 1rem; border-radius: 0.5rem">
        <span id="typed-text"></span><span class="cursor" data-aos="fade-up">&nbsp;</span>
    </div>
</div>

<div class="container split physics separator card" matter data-aos="fade-up">
    <div>
        <h2 class="headline">Hi!</h2>
        <p>
            This is a place where I share my projects, ideas, and experiences.<br>
            I'm a creative soul with a passion for building, learning, and exploring new ideas.
            Every project and every line of code tells a story about my journey.
        </p>
    </div>
    <img src="images/me.png" alt="Nick Esselman" class="img-cropped-wide">
</div>

<div class="physics container narrow card separator" matter data-aos="fade-up">
    <div class="card-3d">
        <link rel="stylesheet" href="css/luanguagesamination.css">
        <?php include 'pages/specials/alltheprogramingluangages.html'; ?>
    </div>
</div>

<!-- <div class="parallax-section">
  <div class="parallax-text">
    <h1 class="physics" id="randomemiji" style="background-color: var(--white); padding: 1rem; border-radius: 0.5rem">:></h1>
  </div>
</div> -->
<!-- <link rel="stylesheet" href="css/projects.css"> -->
<div class="card objectToMoreToTheBackClasses container" data-aos="fade-up">
    <h2 class="headline">My best: <a href="?page=projects">Projects</a></h2>

    <div class="projectgrid">
        <?php
        $homeprojects = array_slice($projects, 0, 4);

        foreach ($homeprojects as $project) {
            // extract everything after the ":" (or use full title if no colon)
            $title = $project['title'];
            if (($pos = strpos($title, ':')) !== false) {
                $badge = trim(substr($title, $pos + 1));
            } else {
                $badge = $title;
            }

            echo '<a href="?project=' . $project['link'] . '" class="card projecttilt physics project project-link">';
            echo '  <div class="img-ratio">';
            echo '    <img src="/images/projectsimages/' . $project['image'] . '" alt="' . htmlspecialchars($title) . '" />';
            // echo '    <span class="overlay-text">' . htmlspecialchars($badge) . '</span>';
            echo '  </div>';
            echo '  <div class="card-content">';
            echo '    <h3>' . htmlspecialchars($title) . '</h3>';
            echo '    <p>' . htmlspecialchars($project['description']) . '</p>';
            echo '  </div>';
            echo '</a>';
        }
        ?>
    </div>

    <div style="margin-top:2rem;">
        <a href="?page=projects"><button>See more</button></a>
    </div>
</div>

<script>
    VanillaTilt.init(document.querySelectorAll(".projecttilt"), {
        max: 15,
        speed: 400,
        glare: false,
        gyroscope: false,
        scale: 1.02
    });
</script>

<div class="wide objectToMoreToTheBackClasses container separator" data-aos="fade-up">

    <!-- ─── IMAGE GALLERY SECTION ─────────────────────────────────────────────────── -->
    <section id="gallery-section">
        <?php
        // This pull in both:
        // 1) the definition of `outputMedia()` and the `if(isset($_GET['offset'])) { … } exit; }` block
        // 2) the <div class="card…">…</script> portion that renders the initial batch + JS
        include 'projects/gallery-section.php';
        ?>
    </section>
</div>


<script>
    const texts = [
        "Web Developer.",
        "Designer.",
        "Fullstack Developer.",
        "Problem Solver.",
        "Student."
    ];

    const TYPING_SPEED = 100;   // ms per character
    const ERASING_SPEED = 50;   // ms per character on erase
    const NEW_TEXT_DELAY = 1500; // pause before typing next text

    const typedTextSpan = document.getElementById("typed-text");
    const cursorSpan = document.querySelector(".cursor");

    let textIndex = 0;
    let charIndex = 0;
    let isErasing = false;

    function type() {
        const currentText = texts[textIndex];

        if (!isErasing) {
            // typing
            typedTextSpan.textContent = currentText.slice(0, charIndex + 1);
            charIndex++;

            if (charIndex === currentText.length) {
                // done typing, pause before erasing
                isErasing = true;
                setTimeout(type, NEW_TEXT_DELAY);
            } else {
                setTimeout(type, TYPING_SPEED);
            }

        } else {
            // erasing
            typedTextSpan.textContent = currentText.slice(0, charIndex - 1);
            charIndex--;

            if (charIndex === 0) {
                // done erasing, move to next text
                isErasing = false;
                textIndex = (textIndex + 1) % texts.length;
                setTimeout(type, TYPING_SPEED);
            } else {
                setTimeout(type, ERASING_SPEED);
            }
        }
    }

    // kick it off on DOM load
    document.addEventListener("DOMContentLoaded", function () {
        if (texts.length) setTimeout(type, NEW_TEXT_DELAY);
    });


    gsap.from(".ultratitle", {
        duration: 1.5,
        y: -50,
        opacity: 0,
        ease: "bounce.out",
        delay: 0.5
    });

    // VanillaTilt.init(document.querySelectorAll(".img-cropped-wide"), {
    //     max: 15,
    //     speed: 400,
    //     glare: true,
    //     "max-glare": 0.2,
    // });

    /* after Particles.js is loaded */
    // particlesJS("particles-js", {
    //     "particles": {
    //         "number": { "value": 60 },
    //         "size": { "value": 3 },
    //         "move": { "speed": 1.5 },
    //         "line_linked": { "enable": true }
    //     }
    // });
</script>