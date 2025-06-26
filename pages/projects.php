<script src="https://cdn.jsdelivr.net/npm/three@0.150.0/build/three.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/globe.gl"></script>
<script type="module" src="scripts/globerenderer.js"></script>
<script>
    let hastriggerhintdisapearbefore = false;

    function disapeartoptext() {
        if (!hastriggerhintdisapearbefore) {
            const hint = document.getElementById('hintidpleaseremovethisdotcom');
            setTimeout(() => { hint.style.opacity = '0'; }, 3000);
            setTimeout(() => { hint.remove(); }, 4000);
            hastriggerhintdisapearbefore = true;

            window.myGlobeControls.autoRotate = false;
        }
    }
</script>

<div class="sub-top">
    <div data-aos="fade-down" style="margin:auto; width: fit-content;">
        <h1 class="ultratitle physics" style="background-color: var(--myblue); padding: 1rem; border-radius: 0.5rem">
            Projects</h1>
    </div>

    <div class="physics" data-aos="fade-down"
        style="margin:auto; width: fit-content; background-color: var(--myblue); padding: 1rem; border-radius: 0.5rem">
        <span>This is a place for me to put all kinds of projects, events and creations</span>
    </div>
</div>

<div class="objectToMoreToTheBackClasses mainthingprojects">
    <div class="weirdsplit">
        <link rel="stylesheet" href="/css/globe.css">
        <div class="conatiner objectToMoreToTheBackClasses card posfixed" data-aos="fade-left" data-aos-once="true">
            <div onmousedown="disapeartoptext();" id="globe"></div>
            <div id="lagenda">
                <ul>
                    <li>
                        <div id="red"></div>
                        <h3>Home</h3>
                    </li>
                    <li>
                        <div id="orange"></div>
                        <h3>Vacations</h3>
                    </li>
                    <li>
                        <div id="blue"></div>
                        <h3>HackClub events</h3>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card objectToMoreToTheBackClasses" style="margin-right: 2rem;" data-aos="fade-up">
            <h2 class="headline">These are most of my personal Projects! And events I've contributed in</h2>
            <div class="projectgrid">
                <?php
                foreach ($projects as $project) {
                    // extract everything after the ":" (or use full title if no colon)
                    $title = $project['title'];
                    if (($pos = strpos($title, ':')) !== false) {
                        $badge = trim(substr($title, $pos + 1));
                    } else {
                        $badge = $title;
                    }

                    echo '<a href="?project=' . $project['link'] . '" id="' . $project['link'] . '" class="card projecttilt physics project project-link" data-aos="fade-up">';
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
        </div>
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