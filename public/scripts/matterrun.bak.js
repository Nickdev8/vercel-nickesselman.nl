// Collision‐category constants
const CATEGORY_NONE = 0x0000;
const CATEGORY_HOOP = 0x0001;
const CATEGORY_BALL = 0x0002;
const CATEGORY_CORNER = 0x0004;
const CATEGORY_CAT = 0x0008;
const CATEGORY_PHYSICS = 0x0010;

// A helper to translate category names into bitmasks
const CATEGORY_MAP = {
    NONE: CATEGORY_NONE,
    HOOP: CATEGORY_HOOP,
    BALL: CATEGORY_BALL,
    CORNER: CATEGORY_CORNER,
    CAT: CATEGORY_CAT,
    PHYSICS: CATEGORY_PHYSICS
};

// Engine & world setup
var Engine = Matter.Engine,
    World = Matter.World,
    Bodies = Matter.Bodies,
    Body = Matter.Body,
    Runner = Matter.Runner,
    Composite = Matter.Composite,
    Constraint = Matter.Constraint,
    Mouse = Matter.Mouse,
    MouseConstraint = Matter.MouseConstraint,
    Events = Matter.Events,
    Vector = Matter.Vector,
    Sleeping = Matter.Sleeping;

Matter.use(MatterAttractors);


var engine = (page === "about")
    ? Engine.create({ enableSleeping: true })
    : Engine.create({ enableSleeping: false });
var world = engine.world;
var runner = Runner.create();

let dynamicMappings = [];
let imageMappings = [];
let constraintMappings = [];
let staticColliders = [];
let walls = [];

let originalPositions = new Map();
let fixedStyles = new Map();

let ropeConstraint1, ropeConstraint2, fixedAnchor1, fixedAnchor2;
let rectC, rectCHoop, rim, hoopSensor;
var ropedistnace = 50;
var ropeLength = 100;

// Mouse‐drag state:
let isDragging = false;
let justDragged = false;
let filterInstalled = false;

// Sound‐rate‐limiting:
let lastSensorTriggerTime = 0;
const SENSOR_COOLDOWN_MS = 1000; // 1 second
let bounceSoundLastSecond = 0;
let bounceSoundCount = 0;
const BOUNCE_SOUND_LIMIT_PER_SECOND = 1;

// Add near your other global mappings:
let colliderDivMappings = [];

// ---------- 4) PUBLIC API: enableMatter(config) & addObject(params) ----------

/**
 * Call this once (e.g. in your page‐load or when the user hits “Start Simulation”).
 * Pass in your custom `physicsConfig` object (or modify it above).
 */
function enableMatter(config) {
    // 4.0) Apply gravity from config:
    engine.world.gravity.x = config.gravity.x;
    engine.world.gravity.y = config.gravity.y;

    // 4.1) Prepare the page (same as before: fix .physics‐fixed, set <main> height, etc.)
    prepareDomForPhysics();

    // 4.2) Clear any previous state:
    dynamicMappings.length = 0;
    imageMappings.length = 0;
    constraintMappings.length = 0;
    staticColliders.length = 0;
    walls.length = 0;
    originalPositions.clear();
    fixedStyles.clear();

    // 4.3) Fix `.physics‐fixed` (unchanged from your code):
    document.querySelectorAll(".physics-fixed").forEach(elem => {
        let r = elem.getBoundingClientRect();
        fixedStyles.set(elem, {
            position: elem.style.position,
            left: elem.style.left,
            top: elem.style.top
        });
        elem.style.position = "absolute";
        // Use viewport coordinates—do not add window.scrollX/Y here
        elem.style.left = r.left + "px";
        elem.style.top = r.top + "px";
    });

    // 4.4) Record original positions for ANY selector that will become dynamic:
    config.dynamicSelectors.forEach(group => {
        document.querySelectorAll(group.selector).forEach(elem => {
            elem.classList.add("physics-active");
            elem.classList.remove("physics-inactive");
            let r = elem.getBoundingClientRect();
            originalPositions.set(elem, {
                parent: elem.parentNode,
                nextSibling: elem.nextSibling,
                x0: r.left + window.scrollX + r.width / 2,
                y0: r.top + window.scrollY + r.height / 2,
                width: r.width,
                height: r.height
            });
        });
    });

    // 4.5) Re‐parent anything that is nested or “loose” (you can keep your old logic)
    document.querySelectorAll(".physics-nested").forEach(elem => {
        let outer = elem.closest(".physics:not(.physics-nested)");
        if (outer && outer.parentNode) {
            outer.parentNode.insertBefore(elem, outer.nextSibling);
        }
    });
    let mainElem = document.querySelector("main");
    document.querySelectorAll(".physics-loose").forEach(elem => {
        mainElem && mainElem.appendChild(elem);
    });

    // 4.6) Create dynamic bodies for EVERY “dynamicSelectors” entry:
    config.dynamicSelectors.forEach(group => {
        createBodiesFromSelector(group.selector, group.options);
    });

    // 4.7) Create static colliders for EVERY “staticSelectors” entry:
    config.staticSelectors.forEach(group => {
        createStaticCollidersFromSelector(group.selector, group.options);
    });

    // 4.8) Add any custom objects (in your old code this was `addObjects()`)
    //      But now we just call: `spawnCustomDefaults(config)` to do your “two balls with spring, hoop, etc.”
    spawnCustomDefaults(config);

    // 4.9) Create page‐walls (top/bottom/left/right), same as before:
    // … inside enableMatter(), right before we create `walls` …

    // 1. Figure out how “tall” the page is, and how tall the footer is:
    let t = 60;
    let W = document.documentElement.scrollWidth;
    let H = Math.max(
        document.documentElement.scrollHeight,
        document.body.scrollHeight
    );
    // let footerElem = document.querySelector("footer");
    // let footerHeight = footerElem ? footerElem.getBoundingClientRect().height : 0;

    // 2. Build the bottom wall so that it sits directly on top of the footer:
    let bottomY = H - t / 2; // Adjust calculation to ensure proper placement
    let bottomWall = Bodies.rectangle(
        W / 2, bottomY, W, t,
        {
            isStatic: true,
            collisionFilter: {
                category: CATEGORY_MAP.PHYSICS,
                mask: CATEGORY_MAP.PHYSICS | CATEGORY_MAP.BALL | CATEGORY_MAP.CAT
            }
        }
    );

    // 3. Build two very tall side-walls. We’ll use a height = H * 5
    //    and place them at y = (H*5)/2 so they cover the entire vertical span:
    let sideHeight = H * 5;
    let sideY = sideHeight / 2;

    // Left wall
    let leftWall = Bodies.rectangle(
        -t / 2, sideY, t, sideHeight,
        {
            isStatic: true,
            collisionFilter: {
                category: CATEGORY_MAP.PHYSICS,
                mask: CATEGORY_MAP.PHYSICS | CATEGORY_MAP.BALL | CATEGORY_MAP.CAT
            }
        }
    );

    // Right wall
    let rightWall = Bodies.rectangle(
        W + t / 2, sideY, t, sideHeight,
        {
            isStatic: true,
            collisionFilter: {
                category: CATEGORY_MAP.PHYSICS,
                mask: CATEGORY_MAP.PHYSICS | CATEGORY_MAP.BALL | CATEGORY_MAP.CAT
            }
        }
    );

    // 4. Add just these three bodies (no top wall):
    walls = [bottomWall, leftWall, rightWall];
    Composite.add(world, walls);

    devLog("Walls initialized:", walls);


    // 4.10) Setup scroll filtering & mouse control & events exactly as before:
    installScrollFilter();
    setupMouseControl();

    // 4.11) Sync‐loop and collision‐handlers:
    setupAfterUpdateSync();
    setupCollisionHandlers();

    // 4.12) Finally: run the engine
    Runner.run(runner, engine);
}


/**
 * A very simple wrapper so that, at any time after enableMatter(),
 * you can spawn a new “sphere” or “hoop” or any custom object you defined
 * in physicsConfig.objectFactories.  You just say:
 *
 *   addObject({
 *     type: "sphere",
 *     image: "images/specials/ball.png",
 *     sound: "sounds/pop.wav",
 *     size: 30,
 *     position: { x: 200, y: 100 },
 *     category: "BALL",
 *     mask: ["BALL", "HOOP", "CAT"]
 *   });
 */
function addObject(params) {
    // Look up the correct factory function by type:
    let factory = physicsConfig.objectFactories[params.type];
    if (!factory) {
        console.warn(`No factory registered for type="${params.type}"`);
        return;
    }
    // Call the factory, passing (world, params). The factory should:
    //  • create a Matter.Body (with correct size, restitution, friction, category, mask)
    //  • add it to `world`
    //  • create/manage a DOM node (img/div) if needed
    //  • push to `dynamicMappings` or `imageMappings` so that sync works
    factory(world, params);
}


// ---------- 5) IMPLEMENTATION DETAILS (helpers & factories) ----------
function convertFixedElements() {
    const mainElem = document.querySelector("main");
    const mainRect = mainElem.getBoundingClientRect();
    document.querySelectorAll(".physics-fixed").forEach(elem => {
        let r = elem.getBoundingClientRect();
        // Convert from fixed to absolute relative to <main>
        elem.style.position = "absolute";
        elem.style.left = (r.left - mainRect.left) + "px";
        elem.style.top = (r.top - mainRect.top) + "px";
    });
}


// 5.1) Prepare the DOM before physics starts
function prepareDomForPhysics() {
    devLog("prepareDomForPhysics: started");
    convertFixedElements();
    // Add “.card” class to every element that matches “span.physics” or “.physics-add-card”
    document.querySelectorAll("span.physics, .physics-add-card").forEach(elem => {
        elem.classList.add("card");
        devLog("Added .card to", elem);
    });
    // In each <p.onlyspans>, remove anything that's not a <span.physics>
    document.querySelectorAll("p.onlyspans").forEach(p => {
        Array.from(p.childNodes).forEach(node => {
            if (!(node.nodeType === Node.ELEMENT_NODE && node.matches("span.physics"))) {
                devLog("Removing non-physics child:", node, "from", p);
                p.removeChild(node);
            }
        });
    });
    // Stretch <main> to fill the viewport (so bodies can drop)
    let mainElem = document.querySelector("main");
    let rect = mainElem.getBoundingClientRect();
    let header = document.querySelector("header");
    let footer = document.querySelector("footer");
    let minHeight = window.innerHeight
        - (header ? header.getBoundingClientRect().height : 0)
        - (footer ? footer.getBoundingClientRect().height : 0);
    let finalHeight = Math.max(rect.height, minHeight);
    mainElem.style.height = finalHeight + "px";
    devLog("Set <main> height to", finalHeight, "px");
    // Hide loadMoreBtn if exists
    if (document.getElementById("loadMoreBtn")) {
        document.getElementById("loadMoreBtn").style.display = "none";
    }
    // Update any classes for proper stacking
    document.querySelectorAll(".objectToMoreToTheBackClasses").forEach(elem => {
        elem.classList.add("objectToMoreToTheBackClasses-active");
        elem.classList.remove("projecttilt");
        devLog("Updated classes for", elem);
    });
    disableAllAOS();
    devLog("prepareDomForPhysics: complete");
}


// 5.2) Create dynamic bodies for every element matching selector
function createBodiesFromSelector(selector, options) {
    document.querySelectorAll(selector).forEach(elem => {
        const r = elem.getBoundingClientRect();
        const baseX = r.left + window.scrollX + r.width / 2;
        const baseY = r.top + window.scrollY + r.height / 2;
        
        // Removed attractor function here
        const defaultOptions = {
            mass: 10,
            restitution: 0.4,
            friction: 0.1,
            collisionFilter: {
                category: CATEGORY_MAP.PHYSICS,
                mask: CATEGORY_MAP.PHYSICS | CATEGORY_MAP.BALL | CATEGORY_MAP.CAT
            }
        };

        const bodyOptions = Object.assign({}, defaultOptions, options);
        const body = Bodies.rectangle(
            baseX,
            baseY,
            r.width,
            r.height,
            bodyOptions
        );
        Composite.add(world, body);
        
        dynamicMappings.push({
            elem: elem,
            body: body,
            x0: baseX,
            y0: baseY,
            offsetX: 0,
            offsetY: 0
        });
    });
}


// 5.3) Create static collider bodies for every element matching `selector`
//      `options` should include { isStatic:true, restitution:0, friction:1, collisionFilter:… }
function createStaticCollidersFromSelector(selector, options) {
    document.querySelectorAll(selector).forEach(elem => {
        let r = elem.getBoundingClientRect();
        let body = Bodies.rectangle(
            r.left + window.scrollX + r.width / 2,
            r.top + window.scrollY + r.height / 2,
            r.width,
            r.height,
            options
        );
        Composite.add(world, body);
        staticColliders.push(body);
    });
}


// 5.4) Install “scroll filter” (prevent page scroll while dragging bodies)
function installScrollFilter() {
    if (filterInstalled) return;
    const uiSelector = "button, input, select, textarea, a";
    let filter = e => {
        // Allow scrolling and touch events on UI elements.
        if (e.target.closest(uiSelector)) {
            return;
        }
        if (!mouseConstraint || !mouseConstraint.body) {
            e.stopImmediatePropagation();
        }
    };
    ["wheel", "mousewheel", "DOMMouseScroll", "touchmove", "pointermove"]
        .forEach(type => {
            window.addEventListener(type, filter, { capture: true });
        });
    filterInstalled = true;
}


// 5.5) Set up Mouse Control (same as before)
let mouseConstraint;
function setupMouseControl() {
    let mouse = Mouse.create(document.body);
    mouseConstraint = MouseConstraint.create(engine, {
        mouse: mouse,
        constraint: {
            length: 0.001,
            stiffness: 0.9,
            render: { visible: false }
        },
        collisionFilter: {
            category: CATEGORY_MAP.PHYSICS,
            mask: CATEGORY_MAP.PHYSICS | CATEGORY_MAP.BALL | CATEGORY_MAP.CAT
        }
    });
    Composite.add(world, mouseConstraint);
    Events.on(mouseConstraint, "startdrag", () => { isDragging = true; });
    Events.on(mouseConstraint, "enddrag", () => {
        isDragging = false;
        justDragged = true;
        setTimeout(() => { justDragged = false; }, 0);
    });

    const uiSelector = "button, input, select, textarea, a";
    document.addEventListener("click", e => {
        if (justDragged && !e.target.closest(uiSelector)) {
            e.stopImmediatePropagation();
            e.preventDefault();
        }
    }, true);
    document.addEventListener("mousedown", e => {
        if (isDragging && !e.target.closest(uiSelector)) {
            e.stopImmediatePropagation();
            e.preventDefault();
        }
    }, true);

    document.body.style.userSelect = "none";
    document.body.style.webkitUserSelect = "none";
    document.body.style.msUserSelect = "none";
    document.querySelectorAll("img").forEach(img => {
        img.draggable = false;
        img.style.userSelect = "none";
        img.ondragstart = () => false;
    });
    document.body.style.overflowY = "auto";
    AOS.refresh();
}


// 5.6) Sync-loop: copy physics positions back into DOM every frame
function setupAfterUpdateSync() {
    Events.on(engine, "afterUpdate", () => {
        let mainElem = document.querySelector("main");
        let mainRect = mainElem.getBoundingClientRect();
        let topOfMain = window.scrollY + mainRect.top;
        let docH = Math.max(document.documentElement.scrollHeight, document.body.scrollHeight);
        let footerElem = document.querySelector("footer");
        let footerHeight = footerElem ? footerElem.getBoundingClientRect().height : 0;
        let bottomY = docH + 50 / 2 - footerHeight;

        dynamicMappings.forEach(m => {
            // No special case for physics-fixed—treat like any other object.
            const dx = m.body.position.x - m.x0;
            const dy = m.body.position.y - m.y0;
            m.elem.style.transform = `translate(${dx}px, ${dy}px) rotate(${m.body.angle}rad)`;
        });

        imageMappings.forEach(m => {
            if (m.body.position.y > bottomY + 200) {
                let respawnY = topOfMain + 50;
                Body.setPosition(m.body, { x: m.body.position.x, y: respawnY });
                Body.setVelocity(m.body, { x: 0, y: 0 });
                Body.setAngle(m.body, 0);
                devLog("Respawned image-mapped body:", m.body);
            }
            let p = m.body.position;
            m.elem.style.left = p.x + "px";
            m.elem.style.top = p.y + "px";
            m.elem.style.transform = `translate(-50%,-50%) rotate(${m.body.angle}rad)`;
            devLog("Updated image element:", m.elem, "to position:", p);
        });

        // 3) Sync any SVG constraint lines (unchanged from before):
        constraintMappings
            .filter(m => m.constraint && (m.constraint.bodyA || m.constraint.pointA))
            .forEach(m => {
                let c = m.constraint;
                let worldA = c.bodyA
                    ? Vector.add(c.bodyA.position, Vector.rotate(c.pointA, c.bodyA.angle))
                    : c.pointA;
                let worldB = c.bodyB
                    ? Vector.add(c.bodyB.position, Vector.rotate(c.pointB, c.bodyB.angle))
                    : c.pointB;
                m.elem.setAttribute("x1", worldA.x);
                m.elem.setAttribute("y1", worldA.y);
                m.elem.setAttribute("x2", worldB.x);
                m.elem.setAttribute("y2", worldB.y);
            });

        // If dev mode is enabled, update the debug overlay with current collisions or sensor info.
        // Inside setupAfterUpdateSync, after syncing SVG constraint lines:
        if (window.devMode) {
            let lastDelta = engine.timing.lastDelta || 0;
            let fps = lastDelta > 0 ? (1000 / lastDelta).toFixed(1) : "N/A";
            let devInfo = "";
            devInfo += "Body Count: " + Composite.allBodies(world).length + "<br/>";
            devInfo += "Collision Pairs: " + engine.pairs.list.length + "<br/>";
            devInfo += "Dynamic Mappings: " + dynamicMappings.length + "<br/>";
            devInfo += "Image Mappings: " + imageMappings.length + "<br/>";
            devInfo += "Static Colliders: " + staticColliders.length + "<br/>";
            devInfo += "Constraints: " + constraintMappings.length + "<br/>";
            devInfo += "Last Delta (ms): " + lastDelta.toFixed(2) + "<br/>";
            devInfo += "FPS: " + fps + "<br/>";

            const devDiv = document.getElementById("devInfo");
            if (devDiv) {
                devDiv.innerHTML = devInfo;
            }
        }

        // Update the sensor overlay position:
        if (hoopSensor) {
            updateSensorOverlay();
        }

        // Update collider overlays:
        colliderDivMappings.forEach(mapping => {
            let p = mapping.body.position;
            mapping.elem.style.left = p.x + "px";
            mapping.elem.style.top = p.y + "px";
            mapping.elem.style.transform = `rotate(${mapping.body.angle}rad)`;
            // Optionally, adjust width/height from bounds:
            let bounds = mapping.body.bounds;
            let width = bounds.max.x - bounds.min.x;
            let height = bounds.max.y - bounds.min.y;
            mapping.elem.style.width = width + "px";
            mapping.elem.style.height = height + "px";
        });

        // Update dynamic mappings:
        for (let i = dynamicMappings.length - 1; i >= 0; i--) {
            checkAndRespawn(dynamicMappings[i], dynamicMappings, i);
        }

        // Update image mappings:
        for (let i = imageMappings.length - 1; i >= 0; i--) {
            checkAndRespawn(imageMappings[i], imageMappings, i);
        }
    });
}

function updateSensorOverlay() {
    if (!window.devMode) return;
    let sensorDiv = document.getElementById("sensorOverlay");
    if (!sensorDiv) {
        sensorDiv = document.createElement("div");
        sensorDiv.id = "sensorOverlay";
        // Style the overlay (a small red square, for instance)
        sensorDiv.style.position = "fixed";
        sensorDiv.style.width = "10px";
        sensorDiv.style.height = "10px";
        sensorDiv.style.background = "red";
        sensorDiv.style.border = "2px dashed white";
        sensorDiv.style.pointerEvents = "none";
        sensorDiv.style.zIndex = "1001";
        document.body.appendChild(sensorDiv);
    }
    // Convert sensor position to viewport coordinates (assuming no scaling)
    let pos = hoopSensor.position;
    sensorDiv.style.left = (pos.x - 5) + "px";
    sensorDiv.style.top = (pos.y - 5) + "px";
}


// 5.7) Collision handlers (e.g. play bounce sounds, detect hoop‐sensor)
function setupCollisionHandlers() {
    Events.on(engine, "collisionStart", event => {
        let now = Date.now();
        let thisSecond = Math.floor(now / 100);

        // Reset sound counter each second
        if (thisSecond !== bounceSoundLastSecond) {
            bounceSoundLastSecond = thisSecond;
            bounceSoundCount = 0;
        }

        event.pairs.forEach(pair => {

            [pair.bodyA, pair.bodyB].forEach(body => {
                if (body === hoopSensor) {
                    let other = (pair.bodyA === hoopSensor ? pair.bodyB : pair.bodyA);
                    if (
                        other === hoopSensor ||
                        other === rectC ||
                        other === rectCHoop ||
                        other === rim
                    ) return;
                    if (now - lastSensorTriggerTime < SENSOR_COOLDOWN_MS) return;
                    if (!other.isStatic && !other.isSensor && other.speed > 0.1) {
                        lastSensorTriggerTime = now;
                        ballWentThroughHoop(other);
                    }
                }
            });

            let bodyA = pair.bodyA;
            let bodyB = pair.bodyB;
            if (bodyA.isSensor || bodyB.isSensor) return;
            let relVel = Math.hypot(
                bodyA.velocity.x - bodyB.velocity.x,
                bodyA.velocity.y - bodyB.velocity.y
            );
            if (relVel < 2.5) return;
            if (bounceSoundCount >= BOUNCE_SOUND_LIMIT_PER_SECOND) return;

            let base = document.getElementById("bounceSound");
            if (base) {
                let clone = base.cloneNode();
                let computedVolume = relVel / 5;
                if (!isFinite(computedVolume)) {
                    computedVolume = 0;
                }
                clone.volume = Math.min(0.9, computedVolume);
                clone.playbackRate = 0.95 + Math.random() * 0.1;
                clone.play().catch(() => { });
                bounceSoundCount++;
            }
        });
    });
}


function spawnCustomDefaults(config) {
    let mainElem = document.querySelector("main");
    let cx = mainElem.offsetLeft + (mainElem.clientWidth / 2);
    let cy = mainElem.offsetTop + (mainElem.clientHeight / 2);

    let ballA = Bodies.circle(cx - 25, cy, 20, {
        mass: 150,
        restitution: 0.5,
        friction: 0.1,
        collisionFilter: {
            category: CATEGORY_MAP.BALL,
            mask: CATEGORY_MAP.PHYSICS | CATEGORY_MAP.BALL | CATEGORY_MAP.CORNER | CATEGORY_MAP.HOOP | CATEGORY_MAP.CAT
        },
        plugin: {
            attractors: [
                function(ballA, otherBody) {
                    if (otherBody === ballA) return;
                    const multiplier = 4e-6;
                    return {
                        x: (ballA.position.x - otherBody.position.x) * multiplier,
                        y: (ballA.position.y - otherBody.position.y) * multiplier
                    };
                }
            ]
        }
    });
    let ballB = Bodies.circle(cx + 25, cy, 20, {
        restitution: 0.5,
        friction: 0.1,
        collisionFilter: {
            category: CATEGORY_MAP.BALL,
            mask: CATEGORY_MAP.PHYSICS | CATEGORY_MAP.BALL | CATEGORY_MAP.CORNER | CATEGORY_MAP.HOOP | CATEGORY_MAP.CAT
        }
    });
    Composite.add(world, [ballA, ballB]);
    
    attachImageToBody(ballA, "images/specials/ball.png", 40, 40);
    const ballAMapping = imageMappings.find(mapping => mapping.body === ballA);
    if (ballAMapping && ballAMapping.elem) {
        // Change hue and saturation for ballA (adjust filter value as desired)
        ballAMapping.elem.style.filter = "hue-rotate(90deg) saturate(3)";
    }
    
    // Attach ballB's image normally
    attachImageToBody(ballB, "images/specials/ball.png", 40, 40);

    if (config.spawnOnPage && config.spawnOnPage.pageName === page) {
        document.querySelector("main").style.overflow = "hidden";
        addManyBalls(config.spawnOnPage.ballCount || 0);
        if (config.spawnOnPage.hoop) {
            addObject({
                type: "hoop",
                boardSize: { width: 200, height: 150 },
                rimSize: -250,
                boardScale: 0.7,
                hoopScale: 1.7,
                rimYOffset: 10
            });
        }
    }
}


// 5.9) Helper to attach an <img> overlay to a given body
function attachImageToBody(body, imagePath, widthPx, heightPx) {
    let img = document.createElement("img");
    img.src = imagePath;
    img.style.position = "absolute";
    img.style.width = widthPx + "px";
    img.style.height = heightPx + "px";
    img.style.transformOrigin = "center center";
    img.style.userSelect = "none";
    img.setAttribute("draggable", "false");
    document.body.appendChild(img);
    imageMappings.push({
        elem: img,
        body: body,
        x0: body.position.x,
        y0: body.position.y
    });
    devLog("Attached image to body:", body, "Image element:", img);
}


// 5.10) Spawns a grid of “count” extra balls (like your addManyBalls):
function addManyBalls(count) {
    const mainElem = document.querySelector("main");
    const mainRect = mainElem.getBoundingClientRect();
    // “topOfMain” in document coordinates:
    const topOfMain = window.scrollY + mainRect.top;

    // We’ll start our grid 50px below the top of <main>:
    const startY = topOfMain + 50;
    // Center horizontally (relative to viewport) −100px:
    const startX = window.innerWidth / 2 - 100;
    const spacing = 50;

    for (let i = 0; i < count; i++) {
        const col = i % 10;
        const row = Math.floor(i / 10);

        const x = startX + col * spacing;
        const y = startY + row * spacing;

        let ball = Bodies.circle(x, y, 20, {
            restitution: 0.5,
            friction: 0.1,
            collisionFilter: {
                category: CATEGORY_MAP.BALL,
                mask: CATEGORY_MAP.PHYSICS | CATEGORY_MAP.BALL | CATEGORY_MAP.CORNER | CATEGORY_MAP.HOOP | CATEGORY_MAP.CAT
            }
        });
        Composite.add(world, ball);
        devLog("Ball created:", ball);

        // Attach the sprite image the same way as before:
        const img = document.createElement("img");
        img.src = "images/specials/ball.png";
        img.style.position = "absolute";
        img.style.width = "40px";
        img.style.height = "40px";
        img.style.transformOrigin = "center center";
        img.style.userSelect = "none";
        img.setAttribute("draggable", "false");
        document.body.appendChild(img);

        imageMappings.push({
            elem: img,
            body: ball,
            x0: x,    // store these so if you ever want to “respawn at exactly this spot,” you have the data…
            y0: y
        });
    }
}


// 5.11) “Two‐part” factory for a basketball hoop.  This is what runs when 
//       you call `addObject({ type:"hoop" })` (or is invoked inside spawnCustomDefaults).
//       We’ve extracted it so you can re‐use `addObject({ type:"hoop", position:…, size:… })` easily.
function createHoopFactory(world, params = {}) {
    const isMobile = window.innerWidth < 900;
    let p1, p2;
    if (isMobile) {
        let centerX = window.scrollX + window.innerWidth / 2;
        let anchorY = window.scrollY + 50;
        p1 = { x: centerX - ropedistnace / 2, y: anchorY };
        p2 = { x: centerX + ropedistnace / 2, y: anchorY };
    } else {
        let x0 = window.scrollX + window.innerWidth - ropedistnace - 100;
        let y0 = window.scrollY + 100;
        p1 = { x: x0, y: y0 };
        p2 = { x: x0 - ropedistnace, y: y0 };
    }

    // New custom parameters:
    let boardScale = params.boardScale || 1.0;         // Scale factor for board dimensions
    let boardYOffset = params.boardYOffset || 0;         // Vertical offset for board
    let hoopScale = params.hoopScale || 1.0;             // Scale factor for hoop dimensions
    let rimYOffset = params.rimYOffset || 0;             // Additional offset for the rim

    // Use boardSize from params if provided (fall back to params.size or defaults):
    const baseRectWidth = (params.boardSize && params.boardSize.width) || (params.size && params.size.width) || 180;
    const baseRectHeight = (params.boardSize && params.boardSize.height) || (params.size && params.size.height) || 120;
    const rectWidth = baseRectWidth * boardScale;
    const rectHeight = baseRectHeight * boardScale;

    // Calculate hoop dimensions with hoopScale:
    let hoopWidth = (params.hoopWidth || (baseRectWidth / 2)) * hoopScale;
    let hoopHeight = (params.hoopHeight || (baseRectHeight / 2)) * hoopScale;

    // Use rimSize from params if provided; otherwise default to -225
    let rimHeight = params.rimSize !== undefined ? params.rimSize : (params.rimHeight !== undefined ? params.rimHeight : -225);

    // --- 1) Create backboard (adjusted by boardYOffset) ---
    rectC = Bodies.rectangle(
        (p1.x + p2.x) / 2, p1.y + boardYOffset,
        rectWidth, rectHeight,
        {
            inertia: Infinity,
            collisionFilter: { category: CATEGORY_NONE, mask: CATEGORY_NONE }
        }
    );
    Composite.add(world, rectC);

    // --- 2) Create rope constraints ---
    ropeConstraint1 = Constraint.create({
        pointA: p1,
        bodyB: rectC,
        pointB: { x: rectWidth / 2, y: -rectHeight / 2 },
        length: ropeLength,
        stiffness: 0.001,
        damping: 0.05,
        render: { visible: true, lineWidth: 2, strokeStyle: '#555' }
    });
    ropeConstraint2 = Constraint.create({
        pointA: p2,
        bodyB: rectC,
        pointB: { x: -rectWidth / 2, y: -rectHeight / 2 },
        length: ropeLength,
        stiffness: 0.001,
        damping: 0.05,
        render: { visible: true, lineWidth: 2, strokeStyle: '#555' }
    });
    Composite.add(world, [ropeConstraint1, ropeConstraint2]);

    // --- 3) Create hoop visual ---
    rectCHoop = Bodies.rectangle(
        rectC.position.x,
        rectC.position.y + rectHeight / 2 + hoopHeight / 2,
        hoopWidth, hoopHeight,
        {
            inertia: Infinity,
            collisionFilter: { category: CATEGORY_NONE, mask: CATEGORY_NONE }
        }
    );
    Composite.add(world, rectCHoop);

    // --- 4) Lock hoop to board ---
    Composite.add(world, [
        Constraint.create({
            bodyA: rectC, pointA: { x: 0, y: rectHeight / 2 },
            bodyB: rectCHoop, pointB: { x: 0, y: -hoopHeight / 2 },
            length: 0, stiffness: 1
        }),
        Constraint.create({
            bodyA: rectC, pointA: { x: -hoopWidth / 2, y: rectHeight / 2 },
            bodyB: rectCHoop, pointB: { x: -hoopWidth / 2, y: -hoopHeight / 2 },
            length: 0, stiffness: 1
        }),
        Constraint.create({
            bodyA: rectC, pointA: { x: hoopWidth / 2, y: rectHeight / 2 },
            bodyB: rectCHoop, pointB: { x: hoopWidth / 2, y: -hoopHeight / 2 },
            length: 0, stiffness: 1
        })
    ]);

    // --- 5) Add top-corner colliders for the hoop (unchanged) ---
    const cornerRadius = 8;
    const cornerOffsetY = -hoopHeight / 2;
    [{ x: -hoopWidth / 2 + cornerRadius, y: cornerOffsetY },
    { x: hoopWidth / 2 - cornerRadius, y: cornerOffsetY }]
        .forEach(offset => {
            let corner = Bodies.circle(
                rectCHoop.position.x + offset.x,
                rectCHoop.position.y + offset.y,
                cornerRadius,
                {
                    isSensor: false,
                    friction: 0,
                    restitution: 0.2,
                    collisionFilter: { category: CATEGORY_CORNER, mask: CATEGORY_BALL }
                }
            );
            Composite.add(world, [corner,
                Constraint.create({
                    bodyA: rectCHoop,
                    pointA: offset,
                    bodyB: corner,
                    pointB: { x: 0, y: 0 },
                    length: 0, stiffness: 1
                })
            ]);
        });

    // --- Attach hoop image with adjusted size ---
    attachImageToBody(rectCHoop, "images/specials/hoop.png",
        hoopWidth + "px", hoopHeight + "px");

    // --- Attach backboard image ---
    attachImageToBody(rectC, "images/specials/board.png",
        rectWidth + "px", rectHeight + "px");

    // --- Create the rim (apply rimYOffset) ---
    let rimWidth = hoopWidth;
    let rimX = rectCHoop.position.x;
    // Use rimYOffset (plus the calculated values) without a hard-coded extra offset:
    let rimY = rectCHoop.position.y + (hoopHeight / 2) + (rimHeight / 2) + rimYOffset;
    rim = Bodies.rectangle(rimX, rimY, rimWidth, rimHeight, {
        inertia: Infinity,
        collisionFilter: { category: CATEGORY_NONE, mask: CATEGORY_NONE }
    });
    Composite.add(world, rim);
    Composite.add(world, Constraint.create({
        bodyA: rectCHoop,
        pointA: { x: 0, y: hoopHeight / 2 },
        bodyB: rim,
        pointB: { x: 0, y: -rimHeight / 2 },
        length: 0, stiffness: 1
    }));
    attachImageToBody(rim, "images/specials/rim.png",
        rimWidth + "px", rimHeight + "px");

    // --- Create rim-edge colliders and set up the hoop sensor ---
    const edgeSize = 6;
    const offsetX = rimWidth / 2;
    ["left", "right"].forEach(side => {
        let sign = side === "left" ? -1 : 1;
        let edgeHeight = Math.abs(rimHeight) * 0.1;
        let edge = Bodies.rectangle(
            rim.position.x + sign * offsetX,
            rim.position.y,
            edgeSize, edgeHeight,
            {
                inertia: Infinity,
                collisionFilter: { category: CATEGORY_CORNER, mask: CATEGORY_BALL },
                restitution: 0.2
            }
        );
        Composite.add(world, [
            edge,
            Constraint.create({
                bodyA: rim,
                pointA: { x: sign * offsetX, y: 0 },
                bodyB: edge,
                pointB: { x: 0, y: 0 },
                length: 0,
                stiffness: 1
            })
        ]);
        if (window.devMode) {
            createColliderOverlay(edge, "Edge: " + side);
        }
    });

    hoopSensor = Bodies.rectangle(
        rim.position.x,
        rim.position.y,
        rimWidth * 0.7,
        6,
        {
            isSensor: true,
            isStatic: false,
            render: { visible: false }
        }
    );
    Composite.add(world, hoopSensor);
    Composite.add(world, Constraint.create({
        bodyA: rim,
        pointA: { x: 0, y: 0 },
        bodyB: hoopSensor,
        pointB: { x: 0, y: 0 },
        length: 0, stiffness: 1
    }));
}

function createSphereFactory(world, params = {}) {
    let x = params.position?.x || window.innerWidth / 2;
    let y = params.position?.y || window.scrollY + 50;
    let size = params.size || 20;

    let ball = Bodies.circle(x, y, size, {
        restitution: 0.5,
        friction: 0.1,
        collisionFilter: {
            category: CATEGORY_MAP.BALL,
            mask: CATEGORY_MAP.PHYSICS | CATEGORY_MAP.BALL | CATEGORY_MAP.CORNER | CATEGORY_MAP.HOOP | CATEGORY_MAP.CAT
        }
    });
    Composite.add(world, ball);

    if (params.image) {
        let img = document.createElement("img");
        img.src = params.image;
        img.style.position = "absolute";
        img.style.width = size * 2 + "px";
        img.style.height = size * 2 + "px";
        img.style.transformOrigin = "center center";
        img.setAttribute("draggable", "false");
        document.body.appendChild(img);
        imageMappings.push({ elem: img, body: ball });
    }

    return ball;
}


function ballWentThroughHoop(otherBody) {
    let index = imageMappings.findIndex(m => m.body === otherBody);
    if (index !== -1) {
        Composite.remove(world, otherBody);
        let elem = imageMappings[index].elem;
        if (elem && elem.parentNode) elem.parentNode.removeChild(elem);
        imageMappings.splice(index, 1);
    }
    let p = hoopSensor.position;
    createConfetti(p.x, p.y, 10, 1, 4000);
    spawnGlobalConfetti(10, 1, 4000);
    if (Math.random() < 0.5) {
        addManyBalls(Math.floor(Math.random() * 3) + 1);
    }
}


function createConfetti(x, y, count, disappearChance = 0, lifespanMs = 0) {
    const size = 8;
    for (let i = 0; i < count; i++) {
        const confBody = Bodies.rectangle(x, y, size, size, {
            restitution: 0.7,
            friction: 0.1,
            collisionFilter: {
                category: CATEGORY_MAP.BALL, // Changed category so walls (mask includes BALL) collide with confetti
                mask: 0xFFFF
            }
        });
        World.add(world, confBody);

        Body.setVelocity(confBody, {
            x: (Math.random() - 0.5) * 6,
            y: (Math.random() - 0.5) * 6
        });
        Body.setAngularVelocity(confBody, (Math.random() - 0.5) * 0.3);

        const div = document.createElement("div");
        div.style.position = "absolute";
        div.style.width = size + "px";
        div.style.height = size + "px";
        div.style.backgroundColor = `hsl(${Math.random() * 360},100%,50%)`;
        div.style.pointerEvents = "none";
        div.style.transformOrigin = "center center";
        document.body.appendChild(div);

        imageMappings.push({ elem: div, body: confBody, x0: x, y0: y });

        lifespanMs = lifespanMs + ((Math.random() - 0.5) * 1000);

        if (disappearChance > 0 && Math.random() < disappearChance) {
            setTimeout(() => {
                Matter.World.remove(world, confBody);
                div.remove();
                let idx = imageMappings.findIndex(m => m.body === confBody);
                if (idx !== -1) imageMappings.splice(idx, 1);
            }, lifespanMs);
        }
    }
}


// 5.15) If you want to drop “global confetti” anywhere:
function spawnGlobalConfetti(count, disappearChance, lifespanMs) {
    let W = document.documentElement.scrollWidth;
    let H = Math.max(
        document.documentElement.scrollHeight,
        document.body.scrollHeight
    );
    for (let i = 0; i < count; i++) {
        let x = Math.random() * W;
        let y = Math.random() * H;
        createConfetti(x, y, 1, disappearChance, lifespanMs);
    }
}

let roofBody = null;

function addRoofCollider() {
    var mainElem = document.querySelector("main");
    if (!mainElem) return console.warn("No <main> found");

    var mainRect = mainElem.getBoundingClientRect();
    var topOfMain = window.scrollY + mainRect.top;
    var W = document.documentElement.scrollWidth;
    var thickness = 60;
    var roofY = topOfMain - thickness / 2;

    roofBody = Bodies.rectangle(
        W / 2, roofY, W, thickness, {
        isStatic: true,
        collisionFilter: {
            category: CATEGORY_MAP.PHYSICS,
            mask: CATEGORY_MAP.PHYSICS | CATEGORY_MAP.BALL | CATEGORY_MAP.CAT
        }
    }
    );

    Composite.add(world, roofBody);
    walls.push(roofBody);
    staticColliders.push(roofBody);

    window.roofBody = roofBody;
    devLog("Roof added", roofBody);
}

addRoofCollider();

// After your world is created, add a floor collider based on the document body height:
const floorHeight = 50; // adjust as needed
const floorY = document.body.scrollHeight + floorHeight / 2;
const floor = Bodies.rectangle(
    document.body.scrollWidth / 2,
    floorY,
    document.body.scrollWidth,
    floorHeight,
    {
        isStatic: true,
        render: { visible: false },
        collisionFilter: { category: CATEGORY_PHYSICS }
    }
);
Composite.add(world, floor);

function devLog(...args) {
    if (window.devMode) {
        console.log(...args);
    }
}

// Create a helper to make a visible overlay for a collider body:
function createColliderOverlay(body, label = "") {
    let div = document.createElement("div");
    div.className = "collider-overlay";
    div.style.position = "absolute";
    div.style.border = "2px dashed red";
    div.style.pointerEvents = "none";
    div.style.zIndex = "1002"; // Above other elements
    if (label) {
        div.innerText = label;
        div.style.fontSize = "10px";
        div.style.color = "red";
    }
    document.body.appendChild(div);
    colliderDivMappings.push({ elem: div, body: body });
}

const roofcollision = document.getElementById('roofcollision');

function checkAndRespawn(mapping, mappingArray, index) {
    let pos = mapping.body.position;
    // Define the scene boundaries based on the document body dimensions
    const sceneLeft = 0;
    const sceneTop = 0;
    const sceneRight = document.body.scrollWidth;
    const sceneBottom = document.body.scrollHeight;

    // If the object is below the scene (e.g. past the footer), remove it.
    if (pos.y > sceneBottom) {
        Composite.remove(world, mapping.body);
        if (mapping.elem && mapping.elem.parentNode) {
            mapping.elem.parentNode.removeChild(mapping.elem);
        }
        mappingArray.splice(index, 1);
        return;
    }

    // Check if the object's center is completely outside the scene (above or on the sides):
    if (pos.x < sceneLeft || pos.x > sceneRight || pos.y < sceneTop) {
        // If the object's velocity is very low, assume it won't respawn on its own.
        if (Math.abs(mapping.body.velocity.x) < 0.1 && Math.abs(mapping.body.velocity.y) < 0.1) {
            // Remove from physics world and DOM
            Composite.remove(world, mapping.body);
            if (mapping.elem && mapping.elem.parentNode) {
                mapping.elem.parentNode.removeChild(mapping.elem);
            }
            mappingArray.splice(index, 1);
        } else {
            // If the object is above the scene and within horizontal bounds,
            // and roofCollision.checked is false, leave it as is.
            if (pos.y < sceneTop &&
                pos.x >= sceneLeft && pos.x <= sceneRight &&
                roofcollision && roofcollision.checked === false) {
                return;
            } else {
                // Otherwise, reposition it to the middle top of the scene.
                let newX = sceneRight / 2;
                let newY = sceneTop + 50;
                Body.setPosition(mapping.body, { x: newX, y: newY });
                Body.setVelocity(mapping.body, { x: 0, y: 0 });
                Body.setAngularVelocity(mapping.body, 0);
            }
        }
    }
}

