<div class="container physics separator header-overlay" matter>
    <img src="images/projectsimages/contact.png" alt="Contact background">
    <div class="overlay-text">
        <h1>Contact</h1>
        <p>Where to find me</p>
    </div>
</div>

<div class="container separator split">
    <div class="infocard card physics" matter>
        <h3 class="headline">Info</h3>
        <div class="iconholder">
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
    <div disabled class="card physics" matter>
        <?php include_once 'pages/specials/contactform.php'; ?>
    </div>
    <?php
    include_once 'pages/specials/cat.php';
    ?>
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
    .header-overlay {
        position: relative;
        width: 100%;
        aspect-ratio: 7 / 2;
        overflow: hidden;

    }

    .card {
        padding-top: var(--spacing-2) !important;
        padding-bottom: var(--spacing-2) !important;
    }

    .infocard {
        max-width: 400px;
    }

    .header-overlay img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: var(--radii-extra);
    }

    .header-overlay .overlay-text {
        position: absolute;
        top: 3rem;
        left: 5rem;
        color: #fff;
        z-index: 2;
        text-shadow: 0 0 4px rgba(0, 0, 0, 0.7);
    }

    .header-overlay .overlay-text h1,
    .header-overlay .overlay-text p {
        margin: 0;
        color: white;
    }

    .img-wide,
    .img-wide img,
    .img-wide>* {
        aspect-ratio: 25 / 8;
    }

    .icon {
        width: 4rem;
        height: 4rem;
    }

    .iconholder {
        display: grid;
        /* Define two columns, each taking up 1 fraction of the available space */
        grid-template-columns: 1fr;
        /* Optional: gap between items */
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
        transform: scale(1.1);
    }



    @media screen and (max-width: 1100px) {
        .iconholder {
            grid-template-columns: 1fr;
            grid-gap: 0;
        }

        .header-overlay {
            aspect-ratio: 4 / 1;

        }

        .infocard {
            max-width: unset;
        }

    }

    @media screen and (max-width: 800px) {
        .iconholder {
            grid-template-columns: 1fr 1fr;
        }

        .header-overlay {
            aspect-ratio: 5 / 1;
            /* display: none; */
        }
    }

    @media screen and (max-width: 550px) {
        .iconholder {
            grid-template-columns: 1fr;
        }
    }
</style>

<link rel="stylesheet" href="css/form.css">