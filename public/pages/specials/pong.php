<div id="pongtable" class="overlay-menu physics-fixed">
    <div class="pong-header">
        <h2>Pong</h2>
        <input type="range" min="1" max="5" step="0.1" value="1" class="slider" id="speedslider">
        <button class="close-button" onclick="
                localStorage.setItem('pong', 'false');
                document.getElementById('pong').checked = false;
                document.getElementById('pong-container').remove();
            ">&times;</button>
    </div>
    <div class="game-container">
        <canvas id="pongcanvas" width="1000" height="600"></canvas>
    </div>
    <div class="onmibile">
        <div class="touch-controls left overlay-menu">
            <div class="touch-up" id="left-up"></div>
            <div class="touch-down" id="left-down"></div>
        </div>
        <div class="touch-controls right overlay-menu">
            <div class="touch-up" id="right-up"></div>
            <div class="touch-down" id="right-down"></div>
        </div>
    </div>
</div>

<style>
    .slidecontainer {
        width: 100%;
    }

    .onmibile {
        display: none;
    }

    .slider {
        -webkit-appearance: none;
        width: 100%;
        height: 25px;
        background: #d3d3d3;
        outline: none;
        opacity: 0.7;
        -webkit-transition: .2s;
        transition: opacity .2s;
        /* pointer-events: none; */
        overflow: hidden;
    }

    .slider:hover {
        opacity: 1;
    }

    .slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 1rem;
        height: 25px;
        background: #04AA6D;
        transform: translateX(-96rem) scaleX(200);
        cursor: pointer;
    }

    .slider::-moz-range-thumb {
        width: 25px;
        height: 25px;
        background: #04AA6D;
        cursor: pointer;
    }


    #pongtable {
        position: fixed;
        width: 70vw;
        max-height: 80vh;
        height: fit-content;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
        background-color: rgba(21, 76, 23, 0.9);
        z-index: 1000;
        opacity: 1 !important;
        color: white;
        border-radius: 10px;
        border: 2px solid rgb(35, 117, 38);
    }

    .pong-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 4vh;
        border-bottom: 1px solid rgb(46, 162, 50);
    }

    .game-container {
        max-height: calc(100% - 4vh);
        display: flex;
        flex: 1;
        justify-content: space-around;
        flex-direction: row;
        border: 2px solid rgb(46, 162, 50);
    }

    canvas {
        width: 100%;
        max-height: calc(80vh - 8vh);

        background: black;
        display: block;
        margin: auto;
    }

    .touch-controls {
        position: absolute;
        width: 100px;
        height: 100px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        opacity: 1;
    }

    .touch-up,
    .touch-down {
        width: 100%;
        height: 50%;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        font-size: 2rem;
        color: white;
        border-radius: 10px;
        border: 2px solid rgb(46, 162, 50);
    }

    /* Mobile styles: rotate pongtable for landscap mode */
    @media only screen and (max-width: 900px) {
        .onmibile {
            display: unset !important;
        }

        #pongtable {

            width: 100vw;
            transform: rotate(90deg);
            transform-origin: center center;
            /* adjust width/height as needed */
        }

        /* Left/right touch zones */
        .touch-controls {
            top: 0;
            bottom: 0;
            width: 60vw;
            height: 100%;
            z-index: 1100;
            gap: 2rem;
        }

        .touch-controls.left {
            left: 0;
            transform: translateX(-100%) scaleY(1.4);
        }

        .touch-controls.right {
            right: 0;
            transform: translateX(100%) scaleY(1.4);
        }

        /* Divide each side into an upper and lower half,
         whose height (or background from semitransparent overlay)
         can give visual feedback of the current input value */
        .touch-controls .touch-up,
        .touch-controls .touch-down {
            flex: 1;
            background: rgba(0, 0, 0, 0.2);
        }

        .touch-controls {
            display: flex;
            flex-direction: column;
        }

        /* Optional: provide a visual cue when touched */
        .touch-controls.touched {
            background: rgba(0, 0, 0, 0.4);
        }
    }
</style>


<script>
    const canvas = document.getElementById("pongcanvas");
    if (!canvas) {
        console.error("pongCanvas element not found. Aborting game and deleting pong container.");
        const pongContainer = document.getElementById("pong-container");
        if (pongContainer) {
            pongContainer.remove();
        }
    } else {
        console.log("pongCanvas element found, initializing game...");
        const ctx = canvas.getContext("2d");
        const speedslider = document.getElementById("speedslider");
        const bounceSound = new Audio('sounds/bounceoffwall.mp3');
        const deathSound = new Audio('sounds/hit.mp3');
        const keys = {};
        let canvasHovered = false;
    
        canvas.addEventListener("mouseenter", () => {
            canvasHovered = true;
        });
        canvas.addEventListener("mouseleave", () => {
            canvasHovered = false;
        });
    
        window.addEventListener("keydown", (e) => {
            if (canvasHovered && ["ArrowUp", "ArrowDown", "ArrowLeft", "ArrowRight"].includes(e.key)) {
                e.preventDefault();
            }
            keys[e.key] = true;
        });
    
        window.addEventListener("keyup", (e) => {
            keys[e.key] = false;
        });
    
        const maxBounceAngle = Math.PI / 4;

        const paddleWidth = 10;
        const basePaddleHeight = 75;
        const ballSize = 10;

        const leftPaddle = {
            x: 10,
            y: canvas.height / 2 - basePaddleHeight / 2,
            speed: 5,
            height: basePaddleHeight,
        },
            rightPaddle = {
                x: canvas.width - paddleWidth - 10,
                y: canvas.height / 2 - basePaddleHeight / 2,
                speed: 5,
                height: basePaddleHeight,
            },
            ball = {
                x: canvas.width / 2,
                y: canvas.height / 2,
                vx: 3,
                vy: 3,
            };

        function update() {
            const speedMultiplier = parseFloat(speedslider.value);

            leftPaddle.speed = 2 * speedMultiplier + 3;
            rightPaddle.speed = 2 * speedMultiplier + 3;

            leftPaddle.height = basePaddleHeight * (speedMultiplier / 3 + 1);
            rightPaddle.height = basePaddleHeight * (speedMultiplier / 3 + 1);

            const speed = Math.sqrt(ball.vx * ball.vx + ball.vy * ball.vy);
            const angle = Math.atan2(ball.vy, ball.vx);
            const baseSpeed = 3;  // base unit speed
            const newSpeed = baseSpeed * speedMultiplier;
            ball.vx = newSpeed * Math.cos(angle);
            ball.vy = newSpeed * Math.sin(angle);

            if (keys["w"] || keys["W"]) {
                leftPaddle.y -= leftPaddle.speed;
                if (leftPaddle.y < 0) leftPaddle.y = 0;
            }
            if (keys["s"] || keys["S"]) {
                leftPaddle.y += leftPaddle.speed;
                if (leftPaddle.y + leftPaddle.height > canvas.height)
                    leftPaddle.y = canvas.height - leftPaddle.height;
            }
            if (keys["ArrowUp"]) {
                rightPaddle.y -= rightPaddle.speed;
                if (rightPaddle.y < 0) rightPaddle.y = 0;
            }
            if (keys["ArrowDown"]) {
                rightPaddle.y += rightPaddle.speed;
                if (rightPaddle.y + rightPaddle.height > canvas.height)
                    rightPaddle.y = canvas.height - rightPaddle.height;
            }

            ball.x += ball.vx;
            ball.y += ball.vy;

            // Bounce off top/bottom walls and play bounce sound
            if (ball.y < 0 || ball.y + ballSize > canvas.height) {
                ball.vy = -ball.vy;
                bounceSound.play();
            }

            // Left paddle collision using dynamic height
            if (
                ball.x <= leftPaddle.x + paddleWidth &&
                ball.y + ballSize >= leftPaddle.y &&
                ball.y <= leftPaddle.y + leftPaddle.height
            ) {
                const paddleCenter = leftPaddle.y + leftPaddle.height / 2;
                const ballCenter = ball.y + ballSize / 2;
                const relativeIntersectY = ballCenter - paddleCenter;
                const normalizedRelativeIntersectionY = relativeIntersectY / (leftPaddle.height / 2);
                const bounceAngle = normalizedRelativeIntersectionY * maxBounceAngle;

                const speedMultiplier = parseFloat(speedslider.value);
                const speed = Math.sqrt(ball.vx * ball.vx + ball.vy * ball.vy) * speedMultiplier;
                ball.vx = Math.abs(speed * Math.cos(bounceAngle));
                ball.vy = speed * Math.sin(bounceAngle);

                // Play bounce sound when hitting paddle
                bounceSound.play();

                speedslider.value = Math.min(parseFloat(speedslider.value) + 0.1, 4);

                ball.x = leftPaddle.x + paddleWidth;
            }

            // Right paddle collision using dynamic height
            if (
                ball.x + ballSize >= rightPaddle.x &&
                ball.y + ballSize >= rightPaddle.y &&
                ball.y <= rightPaddle.y + rightPaddle.height
            ) {
                const paddleCenter = rightPaddle.y + rightPaddle.height / 2;
                const ballCenter = ball.y + ballSize / 2;
                const relativeIntersectY = ballCenter - paddleCenter;
                const normalizedRelativeIntersectionY = relativeIntersectY / (rightPaddle.height / 2);
                const bounceAngle = normalizedRelativeIntersectionY * maxBounceAngle;

                const speedMultiplier = parseFloat(speedslider.value);
                const speed = Math.sqrt(ball.vx * ball.vx + ball.vy * ball.vy) * speedMultiplier;
                ball.vx = -Math.abs(speed * Math.cos(bounceAngle));
                ball.vy = speed * Math.sin(bounceAngle);

                // Play bounce sound when hitting paddle
                bounceSound.play();

                speedslider.value = Math.min(parseFloat(speedslider.value) + 0.1, speedslider.max);

                ball.x = rightPaddle.x - ballSize;
            }

            // Ball goes off screen: play death sound
            if (ball.x < 0 || ball.x > canvas.width) {
                deathSound.play();
                ball.x = canvas.width / 2;
                ball.y = canvas.height / 2;
                ball.vx = -ball.vx; // reverse direction for new serve
            }
        }

        function computeTrajectory() {
            // Clone current ball state
            let simBall = { x: ball.x, y: ball.y, vx: ball.vx, vy: ball.vy };
            const trajectory = [];
            trajectory.push({ x: simBall.x, y: simBall.y });
            let predictedBounce = null;

            // Use the current speedslider value in simulation
            const currentSpeedMultiplier = parseFloat(speedslider.value);
            for (let i = 0; i < 200; i++) {
                simBall.x += simBall.vx;
                simBall.y += simBall.vy;
                // Bounce off top and bottom walls
                if (simBall.y < 0) {
                    simBall.y = -simBall.y;
                    simBall.vy = -simBall.vy;
                } else if (simBall.y + ballSize > canvas.height) {
                    simBall.y = 2 * canvas.height - simBall.y - ballSize;
                    simBall.vy = -simBall.vy;
                }

                // If no bounce prediction yet, check for paddle collision
                if (!predictedBounce) {
                    // Left paddle collision check
                    if (
                        simBall.x <= leftPaddle.x + paddleWidth &&
                        simBall.y + ballSize >= leftPaddle.y &&
                        simBall.y <= leftPaddle.y + leftPaddle.height
                    ) {
                        const paddleCenter = leftPaddle.y + leftPaddle.height / 2;
                        const ballCenter = simBall.y + ballSize / 2;
                        const relIntersect = ballCenter - paddleCenter;
                        const normalized = relIntersect / (leftPaddle.height / 2);
                        const bounceAngle = normalized * maxBounceAngle;
                        predictedBounce = {
                            angle: bounceAngle,
                            collisionPoint: { x: simBall.x, y: simBall.y },
                            left: true
                        };
                        // Update velocity as in update() collision for left paddle
                        const speedNow = Math.sqrt(simBall.vx * simBall.vx + simBall.vy * simBall.vy);
                        simBall.vx = Math.abs(speedNow * Math.cos(bounceAngle));
                        simBall.vy = speedNow * Math.sin(bounceAngle);
                    }
                    // Right paddle collision check
                    else if (
                        simBall.x + ballSize >= rightPaddle.x &&
                        simBall.y + ballSize >= rightPaddle.y &&
                        simBall.y <= rightPaddle.y + rightPaddle.height
                    ) {
                        const paddleCenter = rightPaddle.y + rightPaddle.height / 2;
                        const ballCenter = simBall.y + ballSize / 2;
                        const relIntersect = ballCenter - paddleCenter;
                        const normalized = relIntersect / (rightPaddle.height / 2);
                        const bounceAngle = normalized * maxBounceAngle;
                        predictedBounce = {
                            angle: bounceAngle,
                            collisionPoint: { x: simBall.x, y: simBall.y },
                            left: false
                        };
                        const speedNow = Math.sqrt(simBall.vx * simBall.vx + simBall.vy * simBall.vy);
                        simBall.vx = -Math.abs(speedNow * Math.cos(bounceAngle));
                        simBall.vy = speedNow * Math.sin(bounceAngle);
                    }
                }
                trajectory.push({ x: simBall.x, y: simBall.y });
                if (simBall.x < 0 || simBall.x > canvas.width) break;
            }
            return { trajectory, predictedBounce };
        }

        function draw() {
            ctx.fillStyle = "black";
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            if (window.devMode) {
                const { trajectory, predictedBounce } = computeTrajectory();
                const offsetX = ballSize / 2;
                const offsetY = ballSize / 2;

                ctx.beginPath();
                ctx.strokeStyle = "red";
                ctx.lineWidth = 2;
                ctx.moveTo(trajectory[0].x + offsetX, trajectory[0].y + offsetY);
                for (let i = 1; i < trajectory.length; i++) {
                    ctx.lineTo(trajectory[i].x + offsetX, trajectory[i].y + offsetY);
                }
                ctx.stroke();

                if (predictedBounce) {
                    let arrowAngle = predictedBounce.left
                        ? predictedBounce.angle
                        : Math.PI - predictedBounce.angle;
                    const startX = predictedBounce.collisionPoint.x + offsetX;
                    const startY = predictedBounce.collisionPoint.y + offsetY;
                    const arrowLength = 50;
                    const endX = startX + arrowLength * Math.cos(arrowAngle);
                    const endY = startY + arrowLength * Math.sin(arrowAngle);
                }
            }

            ctx.fillStyle = "white";
            ctx.fillRect(leftPaddle.x, leftPaddle.y, paddleWidth, leftPaddle.height);
            ctx.fillRect(rightPaddle.x, rightPaddle.y, paddleWidth, rightPaddle.height);
            ctx.fillRect(ball.x, ball.y, ballSize, ballSize);
        }

        function gameLoop() {
            update();
            draw();
            requestAnimationFrame(gameLoop);
        }

        gameLoop();


        // if you read this, I vibe coded most if pong in one sitting, so if you see any bugs, please just go to bed

        // Add event listeners for touch events to simulate key presses.
        function addTouchControl(controlEl, key, pressedValue) {
            controlEl.addEventListener("touchstart", e => {
                e.preventDefault();
                keys[key] = true;
                controlEl.classList.add("touched");
            });
            controlEl.addEventListener("touchend", e => {
                e.preventDefault();
                keys[key] = false;
                controlEl.classList.remove("touched");
            });
        }

        // For left paddle: use "w" for up and "s" for down
        let leftUp = document.getElementById("left-up");
        let leftDown = document.getElementById("left-down");
        addTouchControl(leftUp, "w");
        addTouchControl(leftDown, "s");

        // For right paddle: use "ArrowUp" for up and "ArrowDown" for down
        let rightUp = document.getElementById("right-up");
        let rightDown = document.getElementById("right-down");
        addTouchControl(rightUp, "ArrowUp");
        addTouchControl(rightDown, "ArrowDown");
    }
</script>