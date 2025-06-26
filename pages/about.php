<div class="split objectToMoreToTheBackClasses separator" style="margin: 0 10rem;">
    <div class="card container physics radibarcontainer small">
        <h2 class="headline">Nick Esselman</h2> <br><br>
        <div class="radial-bar">
            <svg viewBox="0 0 100 100">
                <circle class="bg" cx="50" cy="50" r="45"></circle>
                <circle class="progress" cx="50" cy="50" r="45" stroke-dasharray="282.6" stroke-dashoffset="282.6">
                </circle>
            </svg>
            <div class="radial-text"><span id="years-old">0.00</span> yrs</div>
        </div>
        <ul class="age-list">
            <li><span>Months:</span><span id="months-old">0</span></li>
            <li><span>Days:</span><span id="days-old">0</span></li>
            <li><span>Hours:</span><span id="hours-old">0</span></li>
            <li><span>Minutes:</span><span id="minutes-old">0</span></li>
            <li><span>Seconds:</span><span id="seconds-old">0</span></li>
            <li><span>Millisec:</span><span id="miliseconds-old">0</span></li>
        </ul>
        <div class="separator"></div>
        <h4 class="caption">*Orange circle is time till next birthday</h4>
    </div>


    <div class="card wide objectToMoreToTheBackClasses container">
        <div class="physics physics-add-card" style="!important;width:fit-content; align-items:start;">
            <h2 class="headline parentonlypaddingwhenphysicsisactive">My story</h2>
        </div>
        <div class="split">
            <!-- class="physics physics-add-card" -->
            <div class="onlyspans">
                <p class="objectToMoreToTheBackClasses onlyspans">
                    I am
                    <span class="physics">Coding for
                        <?= floor((time() - strtotime('2017-09-02')) / (365.25 * 24 * 60 * 60) * 100) / 100; ?> years
                        now.</span>
                    I started back when I was 9.
                    <span class="physics">I learned on my own.</span>
                    by trial and error and did this for a few years.
                    <br><br>
                    After high school I went to <span class="physics">Media College Amsterdam.</span> to <span
                        class="physics">Study: full stack development.</span><br>
                    And in the first year <span class="physics">I joined HackClub, now
                        <?= floor((time() - strtotime('2024-12-18')) / ((365.25 / 12) * 24 * 60 * 60) * 100) / 100; ?>
                        months
                        ago.</span>
                    where I experienced a lot of fun new things. For example,
                    <a href="?project=juice">juice</a>!
                    <br><br>
                    it’s worth your time to read if you are someone or know someone that has even the slightest interest
                    in
                    coding. (and is below <strong>18</strong>)
                    <br>
                    At HackClub, I met some incredible people and I went on trips to places like ShanghaI and San
                    Francisco.
                    Everything was paid for by HackClub.
                </p>
                <span class="physics">
                    <img src="https://github-readme-stats.vercel.app/api?username=nickdev8&theme=graywhite&show_icons=true&hide_border=true&count_private=true"
                        alt="nickdev8's GitHub Stats" />
                </span>
            </div>

            <div class="right objectToMoreToTheBackClasses card sunken iconholingholder">
                <?php
                include 'pages/specials/alltheprogramingluangages.html';
                ?><br><br><br><?php
                include 'pages/specials/aextralltheprogramingluangages.html';
                ?>

                <style>
                </style>
            </div>
        </div>
    </div>
</div>


<style>
    .PLIK {
        margin: 5px;
        transition: transform 0.2s;
    }

    .PLIKS {
        filter:
            grayscale(40%)
            /* sepia(100%) hue-rotate(200deg) saturate(500%); */
    }

    .PLIK:hover {
        transform: scale(1.1);
    }

    .radibarcontainer {
        max-width: 300px;
        overflow: unset !important;
    }

    .radibarcontainer * {
        overflow: unset !important;
        padding-inline-start: unset !important;
    }

    .age-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        padding: 24px;
        max-width: 320px;
        text-align: center;
    }

    .age-card h2 {
        margin-bottom: 16px;
        font-size: 1.5rem;
        color: #333;
    }

    .radial-bar {
        position: relative;
        width: 200px;
        height: 200px;
        margin: 0 auto 24px;
    }

    .radial-bar svg {
        transform: rotate(-90deg);
        width: 100%;
        height: 100%;
    }

    .radial-bar circle {
        fill: none;
        stroke-width: 16;
    }

    .radial-bar .bg {
        stroke: #eee;
    }

    .radial-bar .progress {
        stroke: var(--orange);
        stroke-linecap: round;
        transition: stroke-dashoffset 0.5s ease;
    }

    .radial-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 2rem;
        color: var(--orange);
    }

    .age-list {
        list-style: none;
        text-align: left;
        font-size: 0.9rem;
        color: #555;
    }

    .age-list li {
        margin: 8px 0;
        display: flex;
        justify-content: space-between;
    }

    .age-list li span:first-child {
        font-weight: bold;
    }

    .iconholingholder {
        max-width: 60rem;
        width: fit-content;
    }

    @media screen and (max-width: 1200px) {
        .radibarcontainer {
            display: none;
        }

        .iconholingholder {
            max-width: 30rem;
        }
    }

    @media screen and (max-width: 900px) {
        .radibarcontainer {
            display: none;
        }

        .iconholingholder {
            max-width: unset;
        }

        .split {
            display: block;
        }
    }
</style>

<script src="scripts/updateage.js"></script>