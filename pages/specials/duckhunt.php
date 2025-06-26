<style>
    #duckhunt-card {
        max-width: 7.6rem;
        max-height: 15rem;
        position: fixed;
        z-index: 999;
        opacity: 0;
        padding: var(--spacing-3) !important;

        border-radius: var(--radii-extra);
        box-shadow: var(--shadow-card);
        padding: var(--spacing-2) !important;
        background-color: var(--white);
    }

    #duckbox {
        /* left: calc(50% - 3rem); */
        background-color: var(--muted);
        padding: 1rem;
        border-radius: 0.5rem;
        display: inline-block;
        box-shadow: inset 0 -2.1rem var(--slate);
    }

    #duckbutton {
        width: 4rem;
        height: 4rem;
        margin-bottom: 2rem;
        background-color: var(--orange);
        border: none;
        border-radius: 50%;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3),
            inset 0 -0.8rem var(--red);
        color: transparent;
        font-size: 0;

    }

    #duckbutton:hover {
        transform: scale(1);
    }

    #duckbutton:active {
        box-shadow: inset 0 1rem var(--red);
    }

    .duckhunt-duck {
        position: fixed;
        z-index: 99;
        width: 32px;
        height: 32px;
        transform-origin: center center;
        transform: scale(2, 2);
        user-select: none;
        -webkit-user-drag: none;
        -moz-user-select: none;
        -ms-user-select: none;
        image-rendering: pixelated;
        image-rendering: crisp-edges;
        -ms-interpolation-mode: nearest-neighbor;
    }

    .duckhunt-duck:hover {
        cursor: pointer;
    }
</style>

<div id="duckhunt-card" class="sp-rave physics-fixed">
    <h2>Duck</h2>
    <div id="duckbox">
        <button id="duckbutton"></button>
    </div>
    <h2>Hunt</h2>
</div>

<div id="duck-container"></div>

<script>
    let activeDuckCount = 0;
    const flappingAudio = new Audio("/sounds/duckhunt/duck-flapping.mp3");
    flappingAudio.loop = true;
    const baseSpeed = 120;
    const duckFrames = {
        upRight: [
            "/images/duckhunt/duck_upRight_1.png",
            "/images/duckhunt/duck_upRight_2.png",
            "/images/duckhunt/duck_upRight_3.png"
        ],
        side: [
            "/images/duckhunt/duck_side_1.png",
            "/images/duckhunt/duck_side_2.png",
            "/images/duckhunt/duck_side_3.png"
        ]
    };

    document.getElementById("duckbutton").addEventListener("click", () => {
        const duckCount = 5;
        const container = document.getElementById("duck-container");

        if (activeDuckCount === 0) {
            flappingAudio.currentTime = 0;
            flappingAudio.play().catch(() => { });
        }

        for (let i = 0; i < duckCount; i++) {
            let duck = document.createElement("img");
            duck.draggable = false;
            duck.classList.add("physics-fixed", "specials", "duckhunt-duck");
            duck.src = duckFrames.upRight[0];
            container.appendChild(duck);
            activeDuckCount++;
            startDuckAnimation(duck, baseSpeed);
        }
    });

    function startDuckAnimation(duck, SPEED) {
        let frameIntervalID = null;
        let frameIndex = 0;
        let currentFrames = duckFrames.upRight;
        let animationID = null;
        let fallFrameIntervalID = null;
        let fallFrameIndex = 0;
        const fallFrames = [
            "/images/duckhunt/duck_fall_1.png",
            "/images/duckhunt/duck_fall_2.png"
        ];
        const quackAudio = new Audio("/sounds/duckhunt/duck-quack.mp3");
        const dropAudio = new Audio("/sounds/duckhunt/duck-drop.mp3");
        const fallingAudio = new Audio("/sounds/duckhunt/duck-falling.mp3");
        const gunshotAudio = new Audio("/sounds/duckhunt/gunshot.mp3");
        quackAudio.play().catch(() => { });
        const angleDeg = 20 + Math.random() * 140;
        const angleRad = (angleDeg * Math.PI) / 180;
        let dirX = Math.cos(angleRad); // mutable, so we can update it later
        let dirY = -Math.sin(angleRad); // mutable, so we can update it later

        if (Math.abs(dirY) > Math.abs(dirX)) {
            currentFrames = duckFrames.upRight;
        } else {
            currentFrames = duckFrames.side;
        }

        if (dirX < 0) {
            duck.style.transform = "scale(-2, 2)";
        } else {
            duck.style.transform = "scale(2, 2)";
        }

        // Use a faster initial frame interval (150 ms)
        frameIntervalID = setInterval(() => {
            frameIndex = (frameIndex + 1) % currentFrames.length;
            duck.src = currentFrames[frameIndex];
        }, 200);

        function placeDuckBelowView() {
            const winW = window.innerWidth;
            const winH = window.innerHeight;
            const duckRect = duck.getBoundingClientRect();
            const duckW = duckRect.width;
            const startX = Math.floor(Math.random() * (winW - duckW));
            duck.style.left = startX + "px";
            duck.style.top = winH + "px";
        }

        placeDuckBelowView();

        // After 5 seconds, flip the duck's horizontal direction (keep vertical direction)
        // and increase animation speed (do this only once per duck)
        let hasFlipped = false;
        setTimeout(() => {
            if (!hasFlipped) {
                // Flip only horizontal movement (preventing a downward movement)
                dirX = -dirX;
                hasFlipped = true;
                // Flip horizontal scaling accordingly
                if (duck.style.transform.includes("scale(-2")) {
                    duck.style.transform = "scale(2, 2)";
                } else {
                    duck.style.transform = "scale(-2, 2)";
                }
                // Increase the frame animation speed by clearing and setting a new interval (75 ms)
                if (frameIntervalID !== null) {
                    clearInterval(frameIntervalID);
                    frameIntervalID = setInterval(() => {
                        frameIndex = (frameIndex + 1) % currentFrames.length;
                        duck.src = currentFrames[frameIndex];
                    }, 75);
                }
            }
        }, 5000);

        let lastTimestamp = null;
        let isFalling = false;
        const FALL_SPEED = 200;

        function step(timestamp) {
            if (!lastTimestamp) lastTimestamp = timestamp;
            const deltaTime = (timestamp - lastTimestamp) / 1000;
            lastTimestamp = timestamp;

            if (!isFalling) {
                const curX = parseFloat(duck.style.left);
                const curY = parseFloat(duck.style.top);
                const newX = curX + dirX * SPEED * deltaTime;
                const newY = curY + dirY * SPEED * deltaTime;
                duck.style.left = newX + "px";
                duck.style.top = newY + "px";
            } else {
                const curX = parseFloat(duck.style.left);
                const curY = parseFloat(duck.style.top);
                duck.style.left = curX + "px";
                duck.style.top = curY + FALL_SPEED * deltaTime + "px";
            }

            const winW = window.innerWidth;
            const winH = window.innerHeight;
            const rect = duck.getBoundingClientRect();
            if (
                rect.right < 0 ||
                rect.left > winW ||
                rect.bottom < 0 ||
                rect.top > winH
            ) {
                cleanupDuck();
                return;
            }

            animationID = requestAnimationFrame(step);
        }

        duck.addEventListener("click", () => {
            if (frameIntervalID !== null) {
                clearInterval(frameIntervalID);
                frameIntervalID = null;
            }
            if (animationID !== null) {
                cancelAnimationFrame(animationID);
                animationID = null;
            }

            gunshotAudio.currentTime = 0;
            gunshotAudio.play().catch(() => { });
            duck.src = "/images/duckhunt/duck_die.png";

            setTimeout(() => {
                dropAudio.currentTime = 0;
                dropAudio.play().catch(() => { });

                fallingAudio.loop = true;
                fallingAudio.currentTime = 0;
                fallingAudio.play().catch(() => { });

                fallFrameIntervalID = setInterval(() => {
                    fallFrameIndex = (fallFrameIndex + 1) % fallFrames.length;
                    duck.src = fallFrames[fallFrameIndex];
                }, 100);

                isFalling = true;
                lastTimestamp = null;
                animationID = requestAnimationFrame(step);
            }, 300);
        });

        function cleanupDuck() {
            if (frameIntervalID !== null) {
                clearInterval(frameIntervalID);
                frameIntervalID = null;
            }
            if (fallFrameIntervalID !== null) {
                clearInterval(fallFrameIntervalID);
                fallFrameIntervalID = null;
            }
            if (animationID !== null) {
                cancelAnimationFrame(animationID);
                animationID = null;
            }
            fallingAudio.pause();
            fallingAudio.currentTime = 0;
            duck.remove();
            activeDuckCount--;
            if (activeDuckCount === 0) {
                flappingAudio.pause();
                flappingAudio.currentTime = 0;
            }
        }

        animationID = requestAnimationFrame(step);
    }
</script>