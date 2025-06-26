<audio id="bounceSound" src="sounds/bounce.mp3" preload="auto">
    Your browser does not support the audio element.
</audio>

<div id="muteicon" class="card physics-fixed overlay-menu specials">
    <img id="muteiconimg" src="images/specials/mute.png" unselectable="on" draggable="false" alt="">
</div>

<div class="card overlay-menu physics-fixed specials" id="open-specials-menu" style="opacity:1;">
    <input id="checkbox" type="checkbox">
    <label class="toggle" for="checkbox">
        <div id="bar1" class="bars"></div>
        <div id="bar2" class="bars"></div>
        <div id="bar3" class="bars"></div>
    </label>
</div>

<div class="card overlay-menu physics-fixed specials" id="specials-menu">
    <h3 class="headline">Super Secret Settings</h3>
    <div>
        <label class="special-switch">
            <input id="enablephysics" type="checkbox">
            <span class="special-slider"></span>
        </label>
        <h2>Enable physics</h2>
    </div>
    <div>
        <label class="special-switch">
            <input id="blindmode" type="checkbox">
            <span class="special-slider"></span>
        </label>
        <h2>Blind mode</h2>
    </div>
    <div>
        <label class="special-switch">
            <input id="" type="checkbox">
            <span class="special-slider"></span>
        </label>
        <h2>This does nothing</h2>
    </div>
    <div>
        <label class="special-switch">
            <input id="ravemode" type="checkbox">
            <span class="special-slider"></span>
        </label>
        <h2>Party mode</h2>
    </div>
    <div>
        <label class="special-switch">
            <input id="pong" type="checkbox">
            <span class="special-slider"></span>
        </label>
        <h2>Pong</h2>
    </div>
    <div>
        <label class="special-switch">
            <input id="devModeToggle" type="checkbox">
            <span class="special-slider"></span>
        </label>
        <h2>Dev Mode</h2>
    </div>
    <div>
        <label class="special-switch">
            <input id="unnecessaryToggle" type="checkbox">
            <span class="special-slider"></span>
        </label>
        <h2>Unnecessary Mode</h2>
    </div>
    <div>
        <label class="special-switch">
            <input id="unnecessaryToggleStory" type="checkbox">
            <span class="special-slider"></span>
        </label>
        <h2>Story Mode</h2>
    </div>
    <div>
        <label class="special-switch">
            <input id="triggerbirdpoop" type="checkbox">
            <span class="special-slider"></span>
        </label>
        <h2>Trigger birdpoop</h2>
    </div>
</div>

<!-- <div class="overlay-menu" id="bigpointyarrow">
    <img src="images/arrow.png" alt="">
</div> -->

<div class="card overlay-menu physics-fixed specials" id="morephysics-menu">
    <h3 class="headline">Physics Options</h3>
    <div>
        <label class="special-switch">
            <input id="arrowgravity" type="checkbox">
            <span class="special-slider"></span>
        </label>
        <h2>Arrows => Gravity</h2>
    </div>
    <div>
        <label class="special-switch">
            <input id="roofcollision" checked type="checkbox">
            <span class="special-slider"></span>
        </label>
        <h2>Roof collision</h2>
    </div>
    <div>
        <label class="special-switch">
            <input id="sleepToggle" type="checkbox" <?php if ($_GET['page'] == "about")
                echo 'checked' ?>>
                <span class="special-slider"></span>
            </label>
            <h2>Obj Sleep</h2>
            <button style="height:1.5em;" id="wakingbutton"> wake</button>
        </div>

    </div>



    <style>
        .specials .headline {
            margin: unset;
        }

        .specials>div {
            display: flex;
            gap: 1.5rem;
            margin-top: 1rem;
        }

        #muteicon {
            color: white;
        }

        #muteicon img {
            -moz-user-select: none;
            -webkit-user-select: none;
            user-select: none;
            user-select: none;
            width: 6rem;
            height: 6rem;
        }

        #muteicon:hover {
            cursor: pointer;
        }

        #open-specials-menu {
            /* padding: 0 !important; */
            height: max-content;
        }

        /* #open-specials-menu label>div {
            margin: var(--spacing-3);
        } */

        #morephysics-menu {
            padding: 1rem;
            overflow: unset;
            height: max-content;
        }

        #specials-menu {
            padding: 1rem;
            overflow: unset;
            height: max-content;
        }

        #specials-menu .button {
            display: flex;
            gap: 1rem;
        }

        #checkbox {
            display: none;
        }

        .toggle {
            position: relative;
            width: 40px;
            height: 40px;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition-duration: .3s;
        }

        .bars {
            width: 100%;
            height: 4px;
            background-color: black;
            border-radius: 5px;
            transition-duration: .3s;
        }


        #checkbox:checked+.toggle #bar2 {
            transform: translateY(14px) rotate(60deg);
            margin-left: 0;
            transform-origin: right;
            transition-duration: .3s;
            z-index: 2;
        }

        #checkbox:checked+.toggle #bar1 {
            transform: translateY(28px) rotate(-60deg);
            transition-duration: .3s;
            transform-origin: left;
            z-index: 1;
        }

        #checkbox:checked+.toggle {
            transform: rotate(-90deg);
        }



        /* The switch - the box around the slider */
        .special-switch {
            font-size: 1rem !important;
            position: relative;
            width: 4em;
        }

        /* The slider */
        .special-slider {
            font-size: 1rem !important;
            position: absolute;
            cursor: pointer;
            inset: 0;
            background-color: var(--smoke);
            border-radius: 0.5em;
        }

        .special-slider:before {
            position: absolute;
            content: "";
            height: 2em;
            width: 1.4em;
            border-radius: 0.3em;
            left: 0.3em;
            bottom: 0.3em;
            background-color: var(--orange);
            transition: 0.4s;
        }

        input:checked+.special-slider:before {
            transform: translateX(2em);
            background: var(--green);
        }
    </style>