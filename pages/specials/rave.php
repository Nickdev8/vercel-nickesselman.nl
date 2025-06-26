<link rel="stylesheet" href="/css/rave.css">
<audio id="audio" controls src="sounds/sponcebob.mp3"></audio>

<div class="overlay-menu physics-fixed" id="discoball1" data-aos="fall-down" data-aos-duration="2000">
    <img class="dicoimage" src="images/specials/discoball.gif" alt="">
</div>
<div class="overlay-menu physics-fixed" id="discoball2" data-aos="fall-down" data-aos-duration="3000">
    <img class="dicoimage" src="images/specials/discoball.gif" alt="">
</div>

<div class="dancefloor"></div>

<div class="cone" id="cone1"></div>
<div class="cone" id="cone2"></div>


<script>
    const audio = document.getElementById('audio');
    const visuals = document.querySelectorAll('.card:not(a)');

    const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    const analyser = audioCtx.createAnalyser();
    analyser.fftSize = 64;

    const source = audioCtx.createMediaElementSource(audio);
    source.connect(analyser);
    analyser.connect(audioCtx.destination);

    const dataArray = new Uint8Array(analyser.frequencyBinCount);

    // Variables for smoothing the average over a shorter period
    const smoothingBuffer = [];
    const smoothingWindow = 10;

    // Save the base transform from the CSS for each visual element
    visuals.forEach(visual => {
        const computed = window.getComputedStyle(visual).transform;
        visual.dataset.baseTransform = computed === 'none' ? '' : computed;
    });

    function animate() {
        requestAnimationFrame(animate);

        analyser.getByteFrequencyData(dataArray);
        const instantaneousAvg = dataArray.reduce((a, b) => a + b, 0) / dataArray.length;

        // Add current avg to the buffer
        smoothingBuffer.push(instantaneousAvg);
        if (smoothingBuffer.length > smoothingWindow) {
            smoothingBuffer.shift();
        }
        const avg = smoothingBuffer.reduce((a, b) => a + b, 0) / smoothingBuffer.length;

        // Increase the scale multiplier for a more extreme effect
        let scale = 1 + (avg / 256) * 2;

        // At exactly 12.9 seconds, further adjust the scale
        if (audio.currentTime >= 12.9) {
            scale *= 1.2;
        }

        // Combine the base transform (from your CSS) with the new scale transform
        visuals.forEach(visual => {
            const base = visual.dataset.baseTransform;
            visual.style.transform = `${base} scale(${scale})`;
        });
    }

    // Start analyzing when audio plays
    audio.onplay = () => {
        if (audioCtx.state === 'suspended') {
            audioCtx.resume();
        }
        animate();
    };

    // When audio ends, revert transforms to the base values and execute commands
    audio.onended = () => {
        visuals.forEach(visual => {
            const base = visual.dataset.baseTransform;
            visual.style.transform = base || 'none';
        });

        localStorage.setItem('rave', 'false');
        document.getElementById('ravemode').checked = false;
        const raveContainer = document.getElementById('ravemode-container');
        if (raveContainer) raveContainer.remove();
    };
</script>