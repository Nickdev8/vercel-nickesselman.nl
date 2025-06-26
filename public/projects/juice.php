<?php
include_once 'basicscopy.php';
?>
<style>
    .header-overlay {
        position: relative;
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
        color: #fff;
    }

    .header-overlay img.bg {
        display: block;
        width: 100%;
        height: auto;
    }
</style>
<div class="container wide separator header-overlay">
    <div class="overlay-text">
        <h1>Juice</h1>
        <p>This was a 12 day long hackathon in shanghai, with Hackclub</p>
    </div>
</div>

<div class="wide container separator img-wide">
    <img src="images/innerprojects/juice/group.png" alt="" class="img-cropped-wide">
</div>
<div class="split" style="justify-content: center;">
    <div class="card container separator narrow" style="margin:0; height: fit-content">
        <h2 class="headline">In Short</h2>
        <p>
            Juice was a event hosted by HackClub in Shanghai, China.<br>
            We had to make a Game in 100 hours,<br>
            and when we were allowed to fly to China. where we hosted a <a href="#OpenCafe" id="OpenCafeLink"> Open
                Cafe</a><br>
            and in total, there were almost 100 people that completed there 100 hours
        </p>
        <h2 class="lead">Not Quite Finished</h2>
        <div class="split">
            <p>
                Unfortunately, I wasn’t able to fully complete the game to my linkings.<br>
                There were still a few bugs left, and some features I wanted to add just didn’t make it in time.<br>
                But even with all the chaos, it was an amazing learning experience—and I’m excited to keep working
                on
                PartyVR in the future!<br>
            </p>
        </div>
    </div>

    <div class="card container copy separator" style="margin:0; height: fit-content">
        <div class="split">
            <div>
                <h2 class="headline">The Game I Made</h2>
                <p>
                    I created a game called <a
                        href="https://www.meta.com/en-gb/experiences/partyvr/9355384034552901/?require_login=true"
                        target="_blank">PartyVR</a>.<br>
                    Imagine a wild party, but in virtual reality—dodge flying cakes, dance with your friends, and
                    compete in
                    wacky
                    mini-games, all in the same virtual room!<br>
                    Building it was a blast. I used Unity and the Meta XR SDK, and spent way too many late nights
                    laughing
                    at my own
                    bugs.<br>
                </p>
            </div>
            <img src="images/innerprojects/juice/partyvr.png" alt="PartyVR gameplay screenshot"
                class="img-cropped-small">
        </div>
        <h2 class="lead">My Struggle</h2>
        <p>
            The hardest part? Networking!<br>
            Getting everyone’s avatars to move smoothly together was like herding virtual cats.<br>
            Objects would randomly fly across the room, get stuck in walls, or—most of the time—not move at all for
            other
            players because everything kept desyncing.<br>
            Sometimes, you’d throw a cake and only you would see it fly, while everyone else just saw it floating in
            midair!<br>
            But after a lot of trial and error (and some questionable dance moves in my living room), I finally got
            it
            working... at least most of the time.<br>
        </p>

        <!-- <img src="debugging-vr.png" alt="Debugging VR networking" class="img-cropped"> -->
        <a href="?project=partyvr"><button class="cta">More Here</button></a>
    </div>
</div>
<div class="card container separator" id="OpenCafe">
    <h2 class="headline">In China</h2>
    <h2 class="lead">Cultural Experiences</h2>
    <p>
        Since it was my first time traveling alone, I decided it would be best to bring my brother with
        me.<br>
        We both had a great time and made many new friends.<br>
        <br>
        When we arrived, we immediately noticed so many differences in the culture.<br>
        I especially enjoyed trying all the different foods and attempting to communicate with people who
        didn’t speak
        the same language.<br>
    </p>
    <p>
        One thing that really stood out to me was the lack of tourists.<br>
        Of course, there were some, but not nearly as many as in other countries.<br>
        There were also many people who stared at us and took pictures.<br>
        <br>
        I think this was because we were the only white people in the area.<br>
        At the “open cafe” we hosted, we all demoed our games and showed them to random people who stopped
        by.<br>
        But unfortunately, since I made a multiplayer game, I was not able to demo it.<br>
    </p>
    <img src="images/mainpagegrid/IMG-20250414-WA0309.png" alt="a buetiful lit street" class="img-cropped-wide">
    <img src="images/innerprojects/juice/firstmeal.png" alt="my first meal in china" class="img-cropped">
    <img src="images/innerprojects/juice/stanger.png" alt="Locals taking pictures" class="img-cropped">

    <div class="split">
        <div>
            <h2 class="lead">Local encounters and vibrant street scenes made every moment unforgettable.</h2>
            <p>
                We found some local people selling all kinds of fruits like melons, oranges, and mangos, which we
                made
                juice from.<br>
                Both making the juice and showing our games led to lots of laughter and fun times with all the Hack
                Clubbers
                there.<br>
                <br>
                The cultural differences that surprised me the most were the old buildings integrated with new
                technology.<br>
                Since we weren’t directly in the center of Shanghai but more in the popular downtown, we saw many
                places with
                random cabling running across the street.<br>
                <br>
                QR codes were everywhere, especially for things like restaurant menus—almost everything was done
                with a QR code.<br>
                The most popular app for this was Alipay, which is used for paying, ordering food, and even renting
                bikes.<br>
                Another app, Didi, is like the Chinese version of Uber and is used for getting around the city.<br>
            </p>
        </div>
    </div>
    <img src="images/innerprojects/juice/davemetpaolo.png" alt="Old buildings with new tech" class="img-cropped-small">
    <img src="images/innerprojects/juice/cats.png" alt="Old buildings with new tech" class="img-cropped-small">
    <img src="images/innerprojects/juice/whiteboard.png" alt="Old buildings with new tech" class="img-cropped-small">
    <img src="images/innerprojects/juice/zackdemoing.png" alt="Old buildings with new tech" class="img-cropped-small">
    <img src="images/innerprojects/juice/juiceinprogress.png" alt="Making juice with local fruits"
        class="img-cropped-small">
    <img src="images/innerprojects/juice/subwaywithmeinback.png" alt="Making juice with local fruits"
        class="img-cropped-small">
</div>

<div class="card wide container separator">
    <h2 class="headline">More images</h2>
    <div class="grid" id="imageGrid">
        <?php
        // Only load the first batch
        $dir = 'images/innerprojects/juice'; // All images in all subfolders of images/
        $_GET['limit'] = 10;
        include "./load_images.php";
        ?>
    </div>
    <button id="loadMoreBtn" class="btn" style="display:block;margin:1em auto;">Load More</button>
    <div id="sentinel" style="height: 1px;"></div>
    <!-- Modal for image preview -->
    <div id="imageModal" class="modal" style="display:none;">
        <span class="modal-close" id="modalClose">&times;</span>
        <img class="modal-content" id="modalImg" src="" alt="Preview">
    </div>
</div>