<head>
    <title>Nick Esselman - Resume</title>
</head>

<div class="container">
    <!-- Header: Personal Info (top left) and Profile Image (top right) -->
    <div class="header">
        <div class="personal-info">
            <h1>Nick Esselman</h1>
            <p>Age: <?= floor((time() - strtotime('2008-08-08')) / (365.25 * 24 * 60 * 60) * 10) / 10; ?></p>
            <p>Full Name: Nick Alec Esselman</p>
            <p>Birthdate: 08-08-08</p>
        </div>
        <div class="profile-pic">
            <img src="images/me.png" alt="Nick Esselman">
        </div>
    </div>

    <!-- CV Section -->
    <div class="cv">
        <div class="cv-section">
            <h2>Education</h2>
            <p>Software Developer Student at Media College Amsterdam - Second Year.</p>
        </div>
        <div class="cv-section">
            <h2>Skills</h2>
            <ul>
                <li>7 years of programming experience</li>
                <li>Web Development: HTML, CSS, PHP, JavaScript</li>
                <li>Currently learning: .NET, React, Tailwind CSS</li>
                <li>Game Development in Unity with C#</li>
            </ul>
        </div>
        <div class="cv-section">
            <h2>Experience</h2>
            <p>Bartender for almost 1 year.</p>
            <p>Started programming on my own when I was 9. I am now learning more in college.</p>
        </div>
        <div class="cv-section projects">
            <h2>Projects</h2>
            <ul>
                <li><strong>HackClub: <a href="/?project=juice">Juice</a></strong> – A 12-day hackathon project in
                    Shanghai.</li>
                <li><strong>Collection: <a href="/?project=stickers">My Sticker</a></strong> – A personal project
                    showcasing my HackClub sticker collection.</li>
                <li><strong>HackClub: <a href="/?project=neighborhood">Neighborhood</a></strong> – A 3-month housing
                    program project in San Francisco.</li>
                <li><strong>Game: <a href="/?project=monkeyswing">Monkey Swing</a></strong> – My introduction to game
                    development using Unity and C#.</li>
                <li><strong>HackClub: <a href="/?project=highseas">HighSeas</a></strong> – A team event project centered
                    around innovative project deployment.</li>
                <a href="?page=projects"><button>See more</button></a>
            </ul>
        </div>
        <div class="cv-section iconholder">
            <h2>Info</h2>
            <a href="https://www.linkedin.com/in/nick-esselman/">
                <img class="icon physics physics-nested"
                    src="https://img.icons8.com/?size=100&id=8808&format=png&color=000000">
                nick-esselman</a>
            <a href="https://discordapp.com/users/452409871300558848">
                <img class="icon physics physics-nested"
                    src="https://img.icons8.com/?size=100&id=30888&format=png&color=000000">
                @nikkcc.nick</a>
            <a href="https://github.com/Nickdev8">
                <img class="icon physics physics-nested"
                    src="https://img.icons8.com/?size=100&id=3tC9EQumUAuq&format=png&color=000000">
                Nickdev8</a>
            <a href="https://www.instagram.com/nick.esselman/">
                <img class="icon physics physics-nested"
                    src="https://img.icons8.com/?size=100&id=32309&format=png&color=000000">
                @nick.esselman</a>
            <a href="mailto:info@nickesselman.nl">
                <img class="icon physics physics-nested"
                    src="https://img.icons8.com/?size=100&id=qRMmG0Arw19N&format=png&color=000000">
                info@nickesselman.nl</a>
            <a href="mailto:nick.esselman@gmail.com">
                <img class="icon physics physics-nested"
                    src="https://img.icons8.com/?size=100&id=zVhqEPoFFZ89&format=png&color=000000">
                nick.esselman@gmail.com</a>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('a[href^="mailto:"]').forEach(function (link) {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const email = this.getAttribute('href').replace("mailto:", "");
            navigator.clipboard.writeText(email)
                .then(function () {
                    alert('Copied email: ' + email);
                })
                .catch(function (err) {
                    console.error('Failed to copy email: ', err);
                });
        });
    });
</script>

<style>
    main {
        font-family: "Times New Roman", Times, serif;
        color: #333;
        padding: 20px;
        font-size: 2rem;
    }

    .container {
        max-width: 800px;
        margin: auto;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid #ccc;
        padding-bottom: 20px;
        margin-bottom: 20px;
    }

    button {
        background-color: black;
        border: none;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
    }

    .personal-info {
        max-width: 60%;
    }

    .personal-info h1 {
        margin: 0;
        font-size: 2.5em;
    }

    .personal-info p {
        margin: 5px 0;
        font-size: 1.2em;
    }

    .profile-pic {
        max-width: 35%;
    }

    .profile-pic img {
        width: 100%;
        filter: grayscale(100%);
        border: 1px solid #ccc;
    }

    /* CV section */
    .cv {
        font-size: 1.1em;
        line-height: 1.6;
    }

    .cv-section {
        margin-bottom: 20px;
    }

    .cv-section h2 {
        border-bottom: 1px solid #ccc;
        padding-bottom: 5px;
        margin-bottom: 10px;
    }

    .icon {
        width: 4rem;
        height: 4rem;
    }

    .iconholder {
        display: grid;
        grid-template-columns: 1fr;
        grid-gap: 2px;
        margin-bottom: 1rem;
    }

    .iconholder a {
        display: flex;
        align-items: center;
        gap: 2rem;
        text-decoration: none;
        color: black;
        border-radius: 2rem;
        padding: 0 1rem;
        transition: transform 130ms ease-in-out;
    }

    .iconholder a:hover {
        transform: translateX(1.1rem);
    }

    :root {
        --myblue: #222 !important;
    }
</style>