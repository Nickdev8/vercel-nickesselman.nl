<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.1/ModifiersPlugin.min.js"></script>
<style>
    /* ============= Lava Container (full-screen) ============= */
    .lava-container {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        overflow: hidden;
        pointer-events: none;
        z-index: 1000;
    }

    .lava-svg {
        display: block;
        width: 100%;
        height: 100%;
    }
</style>

<div class="lava-container">
    <svg class="lava-svg" viewBox="0 0 1000 200" preserveAspectRatio="none">
        <path id="lavaPath" d="M0,200 L0,190 L1000,190 L1000,200 Z" fill="#e74c3c"></path>
    </svg>
</div>

<script>
    // ──────────────────────────────────────────────────
    // RISING LAVA (5s), REMOVE .physics, THEN RELOAD
    // ──────────────────────────────────────────────────

    const lavaPath = document.getElementById('lavaPath');
    const svgWidth = 1000;
    const svgHeight = 200;
    const wavePoints = 50;
    const amplitude = 5;
    const waveFreq = 0.06;
    const waveSpeed = 1;

    const INITIAL_BASELINE = 190;
    const FINAL_BASELINE = 0;
    const state = { baseline: INITIAL_BASELINE };

    // (A) Tween baseline: 190 → 0 over 5 seconds
    gsap.to(state, {
        duration: 5,
        baseline: FINAL_BASELINE,
        ease: "power1.inOut",
        onComplete: () => {
            location.reload();
        }
    });

    // (B) Every tick: rebuild the wavy path at the current baseline
    function buildWavePath(phase, baseline) {
        const step = svgWidth / (wavePoints - 1);
        let path = "M0,200 ";
        const y0 = baseline + Math.sin(phase + 0 * waveFreq) * amplitude;
        path += `L0,${y0.toFixed(2)} `;
        for (let i = 1; i < wavePoints; i++) {
            const x = i * step;
            const y = baseline + Math.sin(phase + i * waveFreq) * amplitude;
            path += `L${x.toFixed(2)},${y.toFixed(2)} `;
        }
        path += `L${svgWidth},200 Z`;
        return path;
    }

    gsap.ticker.add((time) => {
        const phase = time * waveSpeed;
        const d = buildWavePath(phase, state.baseline);
        lavaPath.setAttribute('d', d);
        removeTouchedPhysics();
    });

    function removeTouchedPhysics() {
        const viewportHeight = window.innerHeight;
        const baselinePixel = (state.baseline / svgHeight) * viewportHeight;
        document.querySelectorAll('.physics').forEach(el => {
            if (!document.body.contains(el)) return;
            const rect = el.getBoundingClientRect();
            if (rect.bottom >= baselinePixel) {
                el.remove();
            }
        });
    }
</script>