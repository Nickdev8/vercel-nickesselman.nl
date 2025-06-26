<?php
$projects = [
    [
        'title' => 'HackClub: Juice',
        'description' => 'This was a 12-day hackathon in Shanghai with Hack Club.',
        'image' => 'juice.png',
        'link' => 'juice',
        'basiclayout' => 'false'
    ],
    [
        'title' => 'Game: Monkey Swing',
        'description' => 'A game I made to learn C# and Unity.',
        'image' => 'monkeyswing.gif',
        'link' => 'monkeyswing',
        'basiclayout' => 'true',
        'blocks' => [
            [
                'image' => [
                    'images/projectsimages/monkeyswing.gif',
                ]
            ],
            [
                'title' => 'Overview',
                'content' => '
                <p>
                    The first time I sat down at my desk with a nice warm cup of tea,
                    Unity’s interface glowing on my screen, I knew MonkeySwing would be more than
                    “just another 2D rage game.” I typed my first line of C# and felt my heart race:
                </p>
                <pre><code class="language-csharp">
                    public class MonkeyController : MonoBehaviour {<br>
                        // …here be bananas (and probably a few bugs)…<br>
                    }
                </code></pre>
                <p>
                    Each swing of the monkey’s arm became a tiny victory; each unexpected face-plant
                    a lesson learned. When my simple prototype—swinging vines
                    and one very impatient monkey—finally came together,
                    I wrote a cheeky description and hit “Publish” on <a href="https://nikkcc.itch.io/ms">itch.io</a>.
                </p>
                <p>
                    Although it began as a simple prototype, MonkeySwing opened
                    the door to countless new ideas, and it’s still the project I
                    point to when people ask where my game-making journey started.
                </p>',

                'split' => '
                <iframe frameborder="2"
                        src="https://itch.io/embed/2254225?border_width=2"
                        width="550" height="165">
                <a href="https://nikkcc.itch.io/ms">MonkeySwing by Nick</a>
                </iframe>
                <p>
                    I love showing MonkeySwing as my very first project. It still looks polished, and its simple style shows exactly what I set out to learn.
                </p>',
            ],
            [
                'image' => [
                    'images/innerprojects/monkeyswing/gamepllay.png',
                ]
            ],
        ],
    ],
    [
        'title' => 'HackClub: HackPad',
        'description' => 'I designed, soldered, and programmed a macropad.',
        'image' => 'hackpad.png',
        'link' => 'hackpad',
        'basiclayout' => 'true',
        'blocks' => [
            [
                'image' => [
                    'images/innerprojects/hackpad/pcbfront.png',
                ]
            ],
            [
                'title' => 'Overview',
                'content' => '
                <p>
                    This was a project I made with Hack Club.<br>
                    The event was: “Design a PCB for a macropad and receive the parts for it.”<br>
                    I made a PCB with a 4×4 matrix of Cherry MX switches.<br>
                    Find more information in my GitHub repo <a href="https://github.com/Nickdev8/macropad">here</a>.<br><br>
                    I also made a case for it in Fusion 360; this all took me only one day of work.<br><br>
                    I soldered this together with my grandpa; he taught me how to solder, and after only an hour or two, I had a finished board.<br>
                    Then came the programming, and with support from ChatGPT, I had it working in no time.
                </p>
                ',
                'image' => [
                    'images/innerprojects/hackpad/fusion.png',
                ]
            ],
            [
                'title' => 'BOM',
                'content' => '
                <ul>
                    <li>2× SK6812 mini LEDs</li>
                    <li>1× XIAO RP2040</li>
                    <li>16× blank DSA keycaps</li>
                    <li>4× M3×16 mm bolts</li>
                    <li>4× M3 heat-set inserts</li>
                    <li>16× 1N4148 diodes</li>
                </ul>
                <p>Feel free to copy the files, modify them, and make your own.</p>',
                'image' => [
                    'images/innerprojects/hackpad/schematic.png',
                ]
            ],
            [
                'image' => [
                    'images/innerprojects/hackpad/pcbback.png',
                ]
            ],
        ],
    ],
    /*[
        'title' => 'HackClub: Neighborhood',
        'description' => 'A three-month housing program in San Francisco.',
        'image' => 'neighborhood.png',
        'link' => 'neighborhood',
        'basiclayout' => 'true',
        'blocks' => [
            [
                'image' => [
                    'images/innerprojects/neighborhood/top.png',
                ]
            ],
            [
                'title' => 'Overview',
                'content' => '
                    <p>
                        Ready for a summer hackathon adventure in sunny San Francisco? In May 2025, Hack Club launched an exclusive housing program for programmers, running from June through August—it’s not your average meet-up.
                    </p>
                    <p>
                        Here’s the deal: you pick a passion project, sink at least 100 hours of code into it, and we’ve got you covered—flight, housing, meals, you name it! Imagine debugging with a view of the Golden Gate Bridge and jamming on your project poolside.
                    </p>
                    <p>
                        For my contribution, I built this very website—<a href="https://NickEsselman.nl" target="_blank" rel="noopener">NickEsselman.nl</a>—to showcase all the wild ideas and late-night coding sessions.
                        Oh, and to keep us honest, every week in San Francisco you must clock a minimum of 40 coding hours, tracked effortlessly through <a href="https://hackatime.hackclub.com/" target="_blank" rel="noopener">Hackatime</a>.
                    </p>
                ',
            ],
            [
                'title' => 'Can I Join?',
                'content' => '
                    <p>
                        Think you’ve got what it takes? If you’re 18 or younger and you’re reading this before <strong>August 11, 2025</strong>, you’re in the right place!
                    </p>
                    <p>
                        Just dream up a brand-new project and commit at least <strong>100 hours</strong> of coding before the deadline, and we’ll cover everything—flights, housing, meals, the whole shebang.
                        <a href="https://neighborhood.hackclub.com/desktop" target="_blank" rel="noopener">
                            <button class="cta">Join Now!</button>
                        </a>
                    </p>
                    <p>
                        There’s one golden rule: while you’re living the San Francisco coder life, you must log <strong>40 hours of code each week</strong>. We’ll keep track via <a href="https://hackatime.hackclub.com/" target="_blank" rel="noopener">Hackatime</a>.
                        Miss the weekly quota, and it’s back home you go. So code hard and make every keystroke count!
                    </p>
                ',
            ],
            [
                'title' => 'Follow My Journey',
                'content' => '
                    <p>
                        Crave insider access to my San Francisco summer? I’m launching a live blog to show you every twist and turn—sunrise stand-ups, late-night bug hunts, and all the caffeine-powered breakthroughs in between.
                    </p>
                    <p>
                        I’ll drop the blog link right here as soon as it’s live, so keep your eyes peeled and your browser refreshed. Get ready for real-time updates straight from the Bay!
                    </p>
                ',
            ]
        ]
    ],*/
    [
        'title' => 'Game: Gamejams',
        'description' => 'Some games I made.',
        'image' => 'gamejams.png',
        'link' => 'gamejams',
        'basiclayout' => 'true',
        'blocks' => [
            [
                'title' => 'GMTK Game Jam 2024',
                'content' => '
            <p>
                In August 2024, I dove head-first into my very first game jam: the <a href="https://itch.io/jam/gmtk-2024" target="_blank" rel="noopener">GMTK Game Jam</a>!  
                Theme: <strong>Built to Scale</strong>. My creation? <a href="https://nikkcc.itch.io/carsizer" target="_blank" rel="noopener">Car Sizer</a>—a quirky little driver where you continuously resize your car to dodge obstacles.  
                Was it perfect? Far from it. But it was my launchpad into the wild world of rapid-fire game creation.
            </p>
        ',
                'image' => 'images/innerprojects/gamejams/gmtk2024.png',
            ],
            [
                'title' => 'Brackeys Game Jam 2024.2',
                'content' => '
            <p>
                Next up: the <a href="https://itch.io/jam/brackeys-12" target="_blank" rel="noopener">Brackeys Game Jam 2024.2</a>, themed <em>Calm Before the Storm</em>.  
                I hopped onto Discord, pitched my pixel art skills, and suddenly I was on Team Zeus:
            </p>
            <ul>
                <li><strong>Lead Programmer:</strong> Nan</li>
                <li><strong>3D & Level Design:</strong> Mithostropic</li>
                <li><strong>Sound Design:</strong> Berukkula</li>
                <li><strong>Game Designer & UI:</strong> RAMIXANG</li>
            </ul>
            <p>
                Together, we built <a href="https://nikkcc.itch.io/zeuswrath" target="_blank" rel="noopener">Zeus Wrath</a>: sabotage the village, then call down lightning for phase two!  
                Demo hiccups aside, every thunderclap taught me something new.
            </p>
        ',
                'image' => 'images/innerprojects/gamejams/brackeys2024_2.png',
            ],
            [
                'title' => 'Fisherman’s Storm',
                'content' => '
            <p>
                While brainstorming for Zeus Wrath, I also jumped into RAMIXANG’s side project:  
                <a href="https://ramixang.itch.io/fishermans-storm" target="_blank" rel="noopener">Fisherman’s Storm</a>.  
                I crafted seaside sprites and stormy backdrops—nothing beats pixel waves crashing under a moody sky!
            </p>
        ',
                'image' => 'images/innerprojects/gamejams/fishermans_storm.png',
            ],
            [
                'title' => 'Boss Rush Jam 2025',
                'content' => '
            <p>
                Then came the month-long <a href="https://itch.io/jam/boss-rush-jam-2025" target="_blank" rel="noopener">Boss Rush Jam 2025</a>.  
                Our team aimed to build <a href="https://fcolor04.itch.io/witchlight-woods" target="_blank" rel="noopener">Witchlight Woods</a>, a spooky boss-battle romp.  
                Teammates went MIA, so we never finished—but I still designed eerie forest tiles and kicked off the first level.  
                Every pixel sharpened my skills, jams or no jams!
            </p>',
                'image' => 'images/innerprojects/gamejams/bossrush2025.png',
            ],
            [
                'title' => 'Let’s Team Up!',
                'content' => '
            <p>
                Got a game jam squad that needs an extra hand? Whether you’re hunting for a code ninja or craving fresh pixel art magic, I’m ready to jump in!  
                Drop me a line and let’s turn your wildest game ideas into reality.
            </p>
        ',
            ],
        ]
    ],
    [
        'title' => 'Project: 3D Printing Journey',
        'description' => 'From an off-brand clearance printer to a fully upgraded Ender 3 V2',
        'image' => '3dprinter.png',
        'link' => '3dprinting',
        'basiclayout' => 'true',
        'blocks' => [
            [
                'image' => [
                    'images/projectsimages/3dprinter.png',
                ],
            ],
            [
                'title' => 'Humble Beginnings',
                'content' => '
                <p>
                    I started with a mystery clearance printer whose specs were laughable, the rails rattled, and the hotend jammed more often than it extruded. I spent hours scraping failed prints from the bed and tweaking questionable firmware—every successful print felt like a major victory.
                </p>
            ',
            ],
            [
                'title' => 'Upgrading to Ender 3 V2',
                'content' => '
                <p>
                    Tired of filament waste, I invested in a Creality Ender 3 V2. Its rigid frame, smooth motion, and surprisingly reliable default prints made it clear this was a significant upgrade.
                </p>
                <ul>
                    <li>Installed <strong>OctoPrint</strong> for remote slicing and live webcam monitoring.</li>
                    <li>Added a <strong>BLTouch</strong> sensor to automate bed leveling and eliminate manual adjustments.</li>
                    <li>Mounted a <strong>Pi Camera</strong> to catch print failures in real time.</li>
                    <li>Replaced the stock nozzle with a high-precision <strong>0.4 mm brass nozzle</strong> for finer detail.</li>
                    <li>Upgraded springs, dampers, and feet to reduce vibration and noise.</li>
                </ul>
                <p>
                    These modifications transformed the printer into a dependable workhorse, delivering first-layer adhesion and consistent results.
                </p>
            ',
            ],
            [
                'title' => 'Print Projects',
                'content' => '
                <p>
                    With my Ender 3 V2 tuned to perfection, I tackled ambitious builds:
                </p>
                <ul>
                    <li><strong>Hadley Telescope:</strong> I designed, printed, and assembled a fully functional refractor telescope, complete with focus adjustment and lens housing.</li>
                    <li><strong>Functional Jigs & Fixtures:</strong> Custom brackets and tool holders to optimize my workshop setup.</li>
                    <li><strong>Miniature Sculptures:</strong> Detailed busts and topographical models using custom slicer profiles.</li>
                    <li><strong>Enclosure Mods:</strong> A custom, clip-together enclosure with built-in dust filter and LED strip mounts.</li>
                </ul>
                <div class="split">
                    <img src="images/innerprojects/3dprint/old.png" class="img-cropped" alt="">
                    <img src="images/innerprojects/3dprint/camera.png" class="img-cropped" alt="">
                </div>',
                'split' => '
                <div class="split">
                <img src="images/innerprojects/3dprint/germo.png" class="img-cropped-small" alt="">
                <img src="images/innerprojects/3dprint/telesoo.png" class="img-cropped-small" alt="">
                <img src="images/innerprojects/3dprint/camera2.png" class="img-cropped-small" alt="">
                </div>
                <p>
                    Every print pushed my skills further and turned this Ender 3 V2 into a versatile fabrication station.
                    I still have a long mod list and small projects I want to make.
                </p>',
            ],
        ],
    ],
    [
        'title' => 'My Sticker Collection',
        'description' => 'These are all the stickers I received from Hack Club.',
        'image' => 'stickers.png',
        'link' => 'stickers',
        'basiclayout' => 'false',
    ],
    [
        'title' => 'Project: Discord Minecraft Server Bot',
        'description' => 'I made a Discord bot for a multiplayer Minecraft server.',
        'image' => 'discord.png',
        'link' => 'dcmcbot',
        'basiclayout' => 'true',
        'blocks' => [
            [
                'image' => 'images/projectsimages/discord.png'
            ],
            [
                'title' => 'What?',
                'content' => '<p>
                It’s a bot on Discord so I can send commands like /serverOn or /serverReboot for easy distributed management.  
                If a user wants to boot the server, they can! This was back in 2024.
                </p>
                <a href="https://github.com/Nickdev8/minercaftbot">The Repo!</a>
                ',
            ]
        ]
    ],
    [
        'title' => 'HackClub: HighSeas',
        'description' => 'A winter-long Hack Club event where participants earned rewards by publishing projects.',
        'image' => 'highseas.png',
        'link' => 'highseas',
        'basiclayout' => 'true',
        'blocks' => [
            [
                'title' => 'Overview',
                'content' => '<p>
                    <a href="https://highseas.hackclub.com/">HighSeas</a> was a winter-long Hack Club event where we tracked our hours on projects and “set sail” by publishing them.<br>
                    We received doubloons (points) based on votes from other Hack Clubbers. With these doubloons, you could redeem prizes: a Raspberry Pi 5, a 3D printer, a soldering kit, a Blahaj, a System76 keyboard, and many more!<br><br>
                    You should definitely take a look at <a href="https://highseas.hackclub.com/">highseas.hackclub.com</a>, but unfortunately it’s over now.
                </p>'
            ],
            [
                'title' => 'What I Claimed',
                'content' => '<div style="display:grid; grid-template-columns: repeat(3, 1fr);">
                <p>GitHub Stanley tumbler<br><img src="images/innerprojects/highseas/stanly.png" class="img-cropped"></p>
                <p>Logitech MX Master 3S mouse<br><img src="images/innerprojects/highseas/mouse.png" class="img-cropped"></p>
                <p>Raspberry Pi Zero<br><img src="images/innerprojects/highseas/rasp.png" class="img-cropped"></p>
                <p>And many, many stickers. See the <a href="/?project=stickers">My Sticker Collection</a> for more info.</p>
                </div>'
            ],
            [
                'title' => 'Mystic Tavern',
                'content' => '
                <p>After HighSeas was over, they organized an event for everyone who took part to meet up with other Hack Clubbers in their area.<br>
                So I went to Utrecht to meet with 13 Hack Clubbers, of whom six showed up (including me). We walked around the city, talking about our projects and what we do.
                </p>
                <img src="images/innerprojects/highseas/group2.png" class="img">
                <img src="images/innerprojects/highseas/group1.png" class="img">'
            ]
        ]
    ],
    [
        'title' => 'Website: JazzDesign',
        'description' => 'I made the website for my sister’s company.',
        'image' => 'jazzdesign.png',
        'link' => 'jazzdesign',
        'basiclayout' => 'true',
        'blocks' => [
            [
                'image' => 'images/innerprojects/jazzdesign/mainpage.png'
            ],
            [
                'title' => 'What’s JazzDesign?',
                'content' => '
                <div class="split">
                    <div>
                        <p>
                            <a href="https://jazzdesign.nl">JazzDesign</a> is my sister Jessie’s fashion design studio, specializing in custom clothing for businesses and individuals. When she approached me in 2024 to create her website, I jumped at the opportunity!
                        </p>
                        <h3 class="subheadline">The Challenge</h3>
                        <p>
                            While I had built websites before, this was my first time creating one for a real client. 
                            Working with my sister meant balancing:
                            <ul>
                              <li>Professional needs vs. creative freedom</li>
                              <li>Fashion-forward design vs. usability</li>
                              <li>Client expectations vs. technical constraints</li>
                            </ul>
                        </p>
                    </div>
                    <div>
                        <img src="images/innerprojects/jazzdesign/mobile.png" alt="Mobile view" class="img-cropped-small">
                    </div>
                </div>

                <h3 class="subheadline">Behind The Scenes</h3>
                <p>
                    My favorite part was setting up the infrastructure—configuring hosting, managing SSL certificates, and ensuring everything runs smoothly behind the scenes. The design process was equally rewarding, translating Jessie’s fashion aesthetic into a digital experience.
                </p>

                <h3 class="subheadline">Outcome</h3>
                <p>
                    The site has helped Jessie showcase her work to potential clients and streamline her booking process. It’s been a great learning experience in client communication and real-world web development.
                </p>',
            ],
            [
                'image' => 'images/innerprojects/jazzdesign/about.png'
            ]
        ]
    ],
    [
        'title' => 'Game: Weird Chess',
        'description' => 'A hilarious chess variant that breaks all the rules',
        'image' => 'chess.png',
        'link' => 'chess',
        'basiclayout' => 'true',
        'blocks' => [
            [
                'title' => 'Overview',
                'content' => '
                <p>
                    Ever thought chess needed more chaos? During Hack Club’s Shipwrecked challenge, I set out to reinvent the classic game in just 30 hours—and make one of my three projects go viral with 2,000+ views!
                </p>
                <p>
                    Inspired by a wild suggestion from my brother, I built <strong>Weird Chess</strong>: a browser-based 3D board where every piece obeys its own hilarious rule set. It’s chess… but not as you know it.
                </p>
            ',
            ],
            [
                'title' => 'Behind the Madness',
                'content' => '
                <p>
                    The secret sauce is a JSON-driven engine. Want a <em>teleporting pawn</em>? Done. An <em>exploding rook</em>? Easy. Just tweak the JSON file and watch your custom rules explode into action.
                </p>
                <ul>
                    <li><strong>3D Board in Browser:</strong> Built with Three.js for smooth zooms and rotations</li>
                    <li><strong>Instant Rule Tweaks:</strong> Edit JSON to add or modify piece behavior on the fly</li>
                    <li><strong>Share the Madness:</strong> Invite friends to try your wildest variants</li>
                </ul>
            ',
            ],
            [
                'title' => 'Try It Yourself!',
                'content' => '
                <p>
                    Curious to see the code behind the chaos? Peek at the repo on 
                    <a href="https://github.com/Nickdev8/weirdChess" target="_blank" rel="noopener">GitHub</a>. 
                    Fork it, craft your own bizarre pieces, and let the mayhem unfold!
                </p>
            ',
            ],
        ],
    ],
    [
        'title' => 'School: EcoNest',
        'description' => 'Arduino project for a school assignment',
        'image' => 'econest.png',
        'link' => 'econest',
        'basiclayout' => 'true',
        'blocks' => [
            [
                'title' => 'Overview',
                'content' => '<p>For school, I got the assignment named “Duurzaam huis.”<br>
                It was about building a breadboard with LEDs, LDRs, and TH11 sensors.<br>
                I did this together with Bram & Jesper, and we created <a href="https://38406.hosts2.ma-cloud.nl/EcoNest/index.php">EcoNest.com</a>.<br><br>
                Although I handled almost all of the Arduino work and the website, I had a blast doing it.<br>
                I made a single-page website with multiple include statements in PHP.
                </p>',
                'image' => 'images/innerprojects/econest/image.png',
            ],
        ]
    ],
    [
        'title' => 'Project: My Tree',
        'description' => 'This is an idea I had for visualizing the projects I’ve made.',
        'image' => 'mytree.png',
        'link' => 'mytree',
        'basiclayout' => 'false',
    ],
    [
        'title' => 'Project: Party VR',
        'description' => 'This is the game I made for Juice.',
        'image' => 'partyvr.png',
        'link' => 'partyvr',
        'basiclayout' => 'false',
    ],
    [
        'title' => 'Template',
        'description' => 'Description of template',
        'image' => 'template.png',
        'link' => 'template',
        'basiclayout' => 'true',
        'blocks' => [
            [
                'title' => 'Overview',
                'content' => '<p>This is a simple overview of Project 2.</p>',
            ],
            [
                'title' => 'Features',
                'content' => '<ul><li>Feature 1</li><li>Feature 2</li></ul>',
            ],
            [
                'title' => 'Gallery',
                'content' => '<p>Here is a screenshot from Project 2.</p>',
                'image' => 'images/innerprojects/project2-1.png',
            ],
        ],
    ],
];
