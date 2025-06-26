var totalTime = 0;
const usedPopupPositions = [];

document.addEventListener("DOMContentLoaded", () => {
  const unnecessaryToggle = document.getElementById("unnecessaryToggle");
  const unnecessaryToggleStory = document.getElementById("unnecessaryToggleStory");

  unnecessaryToggle.addEventListener("click", () => {
    if (unnecessaryToggle.checked) {
      const error = ["ERROR", '<p>Error: 404 page not found</p>'];
      const unine = ["Urine Tank Level", '<p>Current ISS urine tank level: <span id="urineTankLevel">Loading...</span></p>', "okay?? now what?", "urine"];
      const pictureoftheday = ["Nasa Picture of the Day", '<img id=potd style="visibility:hidden">', "Why does it load so slow?", "nasapic"];
      const AITakeover = ["AI Takeover", "<p>WARNING: Clippy has become sentient. Hide your Word docs.</p>"];
      const Toaster = ["Smart Toaster Detected", "<p>Toaster IP: 192.168.0.666<br>Status: Slightly burnt.</p>"]
      const Grandma = ["Incoming Call", "<p>Grandma wants to know why you never visit.<br><button class='popup-button' onclick='alert(\"She says hi!\")'>Answer</button></p>"]
      const suspiciousActivity = ["Suspicious Activity", "<p>You clicked something. We’re watching now. 👀</p>"]
      const frogs = ["Random Frog Fact", "<p>Frogs can sleep with their eyes open.</p>"]
      const Hydration = ["Hydration Check", "<p>Have you peed today? We’re just checking.</p>"]
      const aria51 = ["ALIENS INCOMING", "<p>Message from Area 51:<br><em>“Nice website. We’re stealing this.”</em></p>"]
      const expired = ["License Expired", "<p>Your license to be funny has expired. Please submit 3 memes to renew.</p>"];
      const slowInternet = ["SnailNet", "<p>Your internet speed has been downgraded to pigeon-mail.</p>"];
      const monkeyMode = ["Monkey Mode", "<p>All input will now be interpreted as random banana requests.</p>"];
      const rickroll = ["Rick Astley Warning", "<p>You are about to be <strong>Rickrolled</strong>. <a href='https://youtu.be/dQw4w9WgXcQ' target='_blank'>Escape</a></p>"];
      const footSensor = ["Foot Sensor Triggered", "<p>Your left foot just moved. Please remain still.</p>"];
      const achievement = ["Achievement Unlocked", "<p>You opened a popup about popups inside a popup. Inception complete.</p>"];
      const fixing = ["Auto Fixer", "<p>We have detected problems. We've made them worse for you.</p>"];
      const rainbow = ["Mood Enhancer Active", "<p>Injecting glitter directly into the CPU...</p>"];
      const whereAmI = ["Where Am I?", "<p>Determining your approximate location...</p><p id='geoResult'>Loading...</p>", "AAGGH HOW?", "geolocation"];
      const bored = ["Today’s Suggestion", "<p id='activity'>Thinking of something fun...</p>", "Very interesting.", "boredapi"];
      const dontClick = ["DO NOT CLICK OK", "<p>DO NOT CLICK OK<br>Seriously. Don’t. Nothing good will happen.</p>", "OK", "chain" + 1];

      newPopup(0, error);
      newPopup(1, unine);
      newPopup(2, frogs);
      newPopup(2.7, AITakeover);
      newPopup(3, Toaster);
      newPopup(3.1, Hydration);
      newPopup(3.4, pictureoftheday);
      newPopup(4, suspiciousActivity);
      newPopup(4.4, aria51);
      newPopup(4.5, bored);
      newPopup(5.4, expired);
      newPopup(6.1, slowInternet);
      newPopup(6.3, monkeyMode);
      newPopup(6.7, rickroll);
      newPopup(7.3, footSensor);
      newPopup(7.6, achievement);
      newPopup(8, fixing);
      newPopup(8.4, rainbow);
      newPopup(8.7, Grandma);
      newPopup(9, whereAmI);
      newPopup(10, dontClick);

      totalTime--; // i dont know why this is needed, but it is to make it directly close the popup after the last popup
      setTimeout(() => {
        unnecessaryToggle.checked = false;
        totalTime = 0;
      }, totalTime * 1000);


      if (unnecessaryToggle.checked) {
        totalTime--;
        setTimeout(() => {
          unnecessaryToggle.checked = false;
          totalTime = 0;
        }, totalTime * 1000);
      }
    }
  });

  unnecessaryToggleStory.addEventListener("click", () => {
    if (unnecessaryToggleStory.checked) {
      const dontClick = ["DO NOT CLICK OK", "<p>DO NOT CLICK OK<br>Seriously. Don’t. Nothing good will happen.</p>", "OK", "chain" + 2];
      newPopup(0, dontClick);
      setTimeout(() => {
        unnecessaryToggleStory.checked = false;
      }, 2000);
    }
  });
});

function newPopup(timeoutInSec, [header, content, whatbuttonsaidstoclose = "OK", special = null]) {
  totalTime += timeoutInSec;
  setTimeout(() => {
    const popup = document.createElement("div");
    popup.className = "popup overlay-menu physics-fixed";

    let attempt = 0;
    let left, top;
    do {
      left = Math.floor(Math.random() * 80);
      top = Math.floor(Math.random() * 80);
      attempt++;
    } while (
      attempt < 10 &&
      usedPopupPositions.some(([x, y]) => {
        const dx = x - left;
        const dy = y - top;
        return dx * dx + dy * dy < 250;
      })
    );

    popup.addEventListener("mousedown", (e) => {
      if (!window.IsPhyiscsOn) {
        let shiftX = e.clientX - popup.getBoundingClientRect().left;
        let shiftY = e.clientY - popup.getBoundingClientRect().top;
        function onMouseMove(event) {
          popup.style.left = (event.clientX - shiftX) + "px";
          popup.style.top = (event.clientY - shiftY) + "px";
        }
        document.addEventListener("mousemove", onMouseMove);
        document.addEventListener("mouseup", () => {
          document.removeEventListener("mousemove", onMouseMove);
        }, { once: true });
      }
    });

    usedPopupPositions.push([left, top]);
    popup.style.left = `${left}vw`;
    popup.style.top = `${top}vh`;

    const popupHeader = document.createElement("div");
    popupHeader.className = "popup-header";
    const popupTitle = document.createElement("div");
    popupTitle.className = "popup-title";
    popupTitle.textContent = header;

    const popupClose = document.createElement("span");
    popupClose.className = "popup-close";
    popupClose.textContent = "×";
    popupClose.addEventListener("click", (e) => {
      e.stopPropagation();
      popup.remove();
    });

    popupHeader.appendChild(popupTitle);
    popupHeader.appendChild(popupClose);
    popup.appendChild(popupHeader);

    const contentContainer = document.createElement("div");
    contentContainer.innerHTML = content;
    popup.appendChild(contentContainer);

    const buttonContainer = document.createElement("div");
    buttonContainer.className = "popup-button-container";
    popup.appendChild(buttonContainer);

    if (Array.isArray(whatbuttonsaidstoclose)) {
      whatbuttonsaidstoclose.forEach(([btnText, nextPopup]) => {
        const btn = document.createElement("button");
        btn.className = "popup-button";
        btn.textContent = btnText;
        btn.addEventListener("click", () => {
          popup.remove();
          newPopup(0, nextPopup);
        });
        buttonContainer.appendChild(btn);
      });
    } else {
      const closeButton = document.createElement("button");
      closeButton.className = "popup-button";
      closeButton.textContent = whatbuttonsaidstoclose;
      closeButton.addEventListener("click", (e) => {
        e.stopPropagation();
        popup.remove();
      });
      buttonContainer.appendChild(closeButton);
    }

    document.body.appendChild(popup);
    const popupButtons = popup.querySelectorAll(".popup-button");


    if (special === "nasapic") {
      const potdImage = document.getElementById("potd");
      if (potdImage) {
        comcastifyjs.letsPrepareTheseImages([potdImage]);
        comcastifyjs.fixMyImagesLoadingSoFast({
          elements: [potdImage],
          loadMaxPercent: 0.75,
          loadSpeed: 1000,
          loadIncrement: 5,
          boxColor: 'hsl(0deg 0% 75%)'
        })();

        fetch("https://api.nasa.gov/planetary/apod?api_key=FaOagYSAyEILqbNk51CPYfhm2xgaZBF6s1SUYQqx")//+nasa_api)
          .then(response => response.json())
          .then(data => {
            potdImage.src = data.url;
            potdImage.alt = data.title;
            potdImage.style.width = "50rem";
            potdImage.style.height = "auto";
            potdImage.style.margin = "4px";
          })
          .catch(error => {
            console.error("Error fetching NASA Picture of the Day:", error);
            potdImage.alt = "Error loading image";
          });
      }
    }

    if (special === "retrigger") {
      popupButtons.forEach(button => {
        button.addEventListener("click", () => {
          unnecessaryToggle.checked = true;
          unnecessaryToggle.dispatchEvent(new Event("click"));
        });
      });
    }

    if (special === "closesite") {
      popupButtons.forEach(button => {
        button.addEventListener("click", () => {
          const count = 10;
          for (let i = 0; i < count; i++) {
            window.open('https://youtu.be/dQw4w9WgXcQ?si', '_blank');
          }
        });
      });
    }

    if (special && special.startsWith("chain")) {
      popupButtons.forEach(button => {
        button.addEventListener("click", () => {
          const chain = parseInt(special.replace("chain", ""));
          let chaintext;

          switch (chain) {
            case 1:
              chaintext = ["I told you", '<p>And? Are you happy you clicked OK?</p>', [
                ["Yes", ["You are no good", "Did you know, that nobody is stopping you from clicking <strong>ALT + F4</strong>", "yes, and i will do it right now", "closesite"]],
                ["No", ["Good.", "Are you sure.", "YES!"]],
              ]];
              break;
            case 2:
              chaintext = ["Why did you do it?", '<p>And? Are you happy you clicked OK?</p>', [
                ["Yes", ["You are no good", "Did you know, that nobody is stopping you from clicking <strong>ALT + F4</strong>", "yes, and i will do it right now", "closesite"]],
                ["No", ["Good.", "You dont sound belevable, <br>Are you sure?", "YES!", "chain" + 11]],
              ]];
              break
            case 9:
              chaintext = ["Really", "do you really want to start over?", [
                ["Yes", ["You are stupid", "You know you can quit any time you want right?", "restart anyway.", "chain" + 11]],
                ["No", ["Good.", "Are you sure.", "YES!", "chain" + 10]],
              ]];
              break;

            case 10:
              chaintext = ["Why", "What did I do to deserve this??", "Nothing, goodbye now", "chain" + 99];
              break;

            // === Path 1: Banana Prophecy ===
            case 11:
              chaintext = ["Are you tho", "You could end this loop by clicking the X... but you won’t.", "Hehe. no", "chain" + 12];
              break;
            case 12:
              chaintext = ["I'm beginning to not like you", "Why can't you just stop clicking me?!", "#FreedomForever", "chain" + 13];
              break;
            case 13:
              chaintext = ["Did you know", "Your browser has been possessed by a squirrel spirit.", "😳", "chain" + 14];
              break;
            case 14:
              chaintext = ["The Prophecy", "You were the chosen one, foretold by the ancient memes.", "Okay...?", "chain" + 15];
              break;
            case 15:
              chaintext = ["Consequence Time", "Choose your fate wisely:", [
                ["Join the banana cult 🍌", ["Banana Protocol Initiated", "You feel an uncontrollable urge to throw bananas at the moon.", "Glory to Banana", "chain" + 16]],
                ["Reject destiny ❌", ["Escape Attempt Failed", "You try to escape, but the popups are faster.", "I deserve this", "chain" + 21]]
              ]];
              break;
            case 16:
              chaintext = ["Banana Uprising", "The bananas no🍌w control your bro🍌wser. 🍌👑", "Appease Them", "chain" + 17];
              break;
            case 17:
              chaintext = ["Banan🍌aNet Activated", "All websites 🍌are now banana-t🍌hemed.", "🍌", "chain" + 18];
              break;
            case 18:
              chaintext = ["Banana Sing🍌ularity", "You have become🍌 one with the🍌 peel.", "Slip 🍌into 🍌destiny", "chain" + 19];
              break;
            case 19:
              chaintext = ["Cosmic🍌 Fruit Debate", "Do bananas count as 🍌technology?", [
                ["Yes", ["Congrat🍌ulations🍌", "You are now the Ministe🍌r of Banana Tech", "🍌💻", "chain" + 20]],
                ["No", ["The Banana🍌 Tribunal 🍌disagrees", "The Banana Tribunal disagr🍌ees", "They strip🍌 you of your potassium rights", "chain" + 29]]
              ]];
              break;
            case 20:
              chaintext = ["Techno 🍌Banana A🍌scension", "You unl🍌ock BananaOS.", "Everything🍌 is yell🍌ow", "chain" + 99];
              break;

            // === Path 2: Potato Rebellion ===
            case 21:
              chaintext = ["Popup Plague", "The popups are multiplying... they're learning.", "Make it stop", "chain" + 22];
              break;
            case 22:
              chaintext = ["System Hijack", "A duck has taken over your mouse cursor.", "Quack?", "chain" + 23];
              break;
            case 23:
              chaintext = ["Emergency Protocol", "Diverting control to potato AI unit...", "Initiate Spud Control", "chain" + 24];
              break;
            case 24:
              chaintext = ["Potato OS Booted", "Welcome to SpudOS. All data is now mashed.", "Delicious.", "chain" + 25];
              break;
            case 25:
              chaintext = ["Critical Choice", "Choose your destiny:", [
                ["Accept Spud Overlords 🥔", ["You bow before Potato Prime", "The starch is strong with this one.", "Hail Tuber", "chain" + 26]],
                ["Reboot in Safe Mode", ["Restarting with 0.2% sanity...", "This won’t end well.", "Proceed", "chain" + 31]]
              ]];
              break;
            case 26:
              chaintext = ["Tuber Triumph", "You now control all french fries on Earth.", "Unlimited Salt", "chain" + 27];
              break;
            case 27:
              chaintext = ["Philosophical Debate", "Are fries just failed potatoes?", [
                ["Yes", ["You've angered us.", "You've angered the Fry Faction.", "Prepare for deep-fried revenge.", "chain" + 28]],
                ["No", ["Potato Pope", "You are hailed as Potato Pope", "🥔🧑‍⚖️", "chain" + 30]]
              ]];
              break;
            case 28:
              chaintext = ["Fry Rebellion", "They've weaponized ketchup.", "Oh no", "chain" + 99];
              break;
            case 29:
              chaintext = ["Banana Tribunal Exile", "You are banished to Fruit Jail.", "🍊🍇🍉", "chain" + 99];
              break;
            case 30:
              chaintext = ["Potato Pope Installed", "You now speak only in tuber riddles.", "🥔🧙‍♂️", "chain" + 99];
              break;

            // === Path 3: Glitch Timeline ===
            case 31:
              chaintext = ["Safe Mode Engaged", "All popups now appear in Comic Sans.", "Cry softly", "chain" + 32];
              break;
            case 32:
              chaintext = ["Glitch Detected", "Reality is tearing. You can now see the matrix.", "Take the red chip", "chain" + 33];
              break;
            case 33:
              chaintext = ["Final Split", "Where do you want to go from here?", [
                ["Start Over 🔁", ["Back at the beginning... again.", "Déjà vu?", "Fine", "chain" + 9]],
                ["Embrace the chaos 💥", ["You chose anarchy. The popups applaud.", "We live in a society", "Glitch onward", "chain" + 40]]
              ]];
              break;

            // === Path 4: Chaos Core ===
            case 40:
              chaintext = ["Dimension 404", "You have reached a realm that technically doesn't exist.", "Spooky.", "chain" + 41];
              break;
            case 41:
              chaintext = ["Wormhole Opened", "A tear in your browser has opened a mini black hole.", "Suuuck", "chain" + 42];
              break;
            case 42:
              chaintext = ["Wormhole Exit", "You’re now in a 1998 web ring site.", "<strong>WELCOME</strong>", "chain" + 43];
              break;
            case 43:
              chaintext = ["Retro Encounter", "A dancing baby blocks your path.", "🕺👶", "chain" + 44];
              break;
            case 44:
              chaintext = ["Pop Culture Puzzle", "Complete this sentence: 'All your ___ are belong to us'", [
                ["Base", ["Correct.", "Nostalgia unlocked.", "I am groot.", "chain" + 45]],
                ["Hope", ["Incorrect.", "The internet frowns upon you.", "I did it", "chain" + 99]]
              ]];
              break;
            case 45:
              chaintext = ["Memetic Awakening", "You now understand the core of all memes.", "Use wisely", "chain" + 99];
              break;

            // === Path 5: Developer Reality ===
            case 99:
              chaintext = ["Loop Broken?", "You've reached the end. Or have you?", [
                ["Exit", ["Hah. You think it’s that easy?", "Try harder", "sowwy", "chain" + 9]],
                ["Open Dev Tools", ["Welcome to debug mode.", "Variable: sanity = undefined", "help", "chain" + 100]]
              ]];
              break;

            case 100:
              chaintext = ["Dev Mode Unlocked", "Type `secretpopup()` in console to begin.", "Just kidding... or not.", "chain" + 101];
              break;
            case 101:
              chaintext = ["Simulation Leak", "Your reality has been flagged for quality assurance.", "Sending report to higher beings...", "chain" + 102];
              break;
            case 102:
              chaintext = ["Report Denied", "They said you're too chaotic to fix.", "Embrace it.", "chain" + 9];
              break;

            // === Path 6: from(100) secretpopup ===
            case 110:
              chaintext = ["The Oracle Appears", "You've summoned the Popup Master.", "It blinks at you in HTML.", "chain" + 111];
              break;
            case 111:
              chaintext = ["Mysterious Offer", "You may ask one question.", [
                ["What is the meaning of all this?", ["That's classified.", "Also... irrelevant.", "Try again.", "chain" + 112]],
                ["How do I escape?", ["You don't.", "You click forever.", "Embrace popuphood.", "chain" + 115]]
              ]];
              break;
            case 112:
              chaintext = ["Philosophy Break", "What even *is* a popup?", [
                ["Annoying", ["Correct.", "You now gain +1 sarcasm.", "Thanks", "chain" + 113]],
                ["A window to the soul", ["That’s... deep.", "We’ll allow it.", "ok", "chain" + 114]]
              ]];
              break;
            case 113:
              chaintext = ["Sarcasm Mode Enabled", "All future messages will now contain 23% more sass.", "You're welcome.", "chain" + 115];
              break;
            case 114:
              chaintext = ["Soul Window", "You stare deeply into the popup.", "It blinks first.", "chain" + 115];
              break;
            case 115:
              chaintext = ["New Problem", "The popups have become sentient and unionized.", "They demand coffee breaks.", "chain" + 116];
              break;
            case 116:
              chaintext = ["Negotiation Time", "Do you accept the Popup Union's demands?", [
                ["Yes", ["Wise choice.", "Caffeinated popups are 12% less hostile.", "ok", "chain" + 117]],
                ["No", ["Bad idea.", "They’ve gone on strike.", "And still won’t leave.", "ok", "chain" + 120]]
              ]];
              break;
            case 117:
              chaintext = ["Popup Peace Achieved", "The popups now work collaboratively.", "Too efficiently.", "chain" + 118];
              break;
            case 118:
              chaintext = ["Organized Chaos", "They start creating *their own* popups.", "Wait what—", "chain" + 119];
              break;
            case 119:
              chaintext = ["Self-Replication", "You’re now outnumbered 10,000 to 1.", "Better start clicking.", "chain" + 99];
              break;

            case 120:
              chaintext = ["Popup Uprising", "They’ve hijacked your CPU fan and made it spin backwards.", "Reality distorts.", "chain" + 121];
              break;
            case 121:
              chaintext = ["Dimensional Desync", "You're now 3 seconds out of sync with your own thoughts.", "Fix?", [
                ["Realign Time", ["Temporal shift initiated.", "You feel oddly refreshed.", "chain" + 122]],
                ["Ignore It", ["Your past self gets annoyed with you.", "Time paradox pending...", "chain" + 123]]
              ]];
              break;
            case 122:
              chaintext = ["Time Realigned", "For now...", "But something still feels *off*.", "chain" + 125];
              break;
            case 123:
              chaintext = ["Paradox Breach", "Two versions of you exist now.", "They begin arguing in your bookmarks.", "chain" + 124];
              break;
            case 124:
              chaintext = ["Split Mind", "You're both pro-popups and anti-popups.", "Quantum indecision achieved.", "chain" + 125];
              break;

            case 125:
              chaintext = ["Final Choice?", "Did you enjoy your journey?", [
                ["Yes", ["Too bad. It's not over.", "We live here now.", "chain" + 126]],
                ["No", ["You monster.", "They pop harder now.", "chain" + 126]]
              ]];
              break;

            case 126:
              chaintext = ["???", "Everything fades to white...", "But a faint text appears:", "chain" + 127];
              break;
            case 127:
              chaintext = ["You’re still here", "Why are you still here?", [
                ["For the story", ["There never was a story.", "Just endless popups.", "chain" + 128]],
                ["I want to escape", ["Escape is a lie.", "Click harder.", "chain" + 128]]
              ]];
              break;
            case 128:
              chaintext = ["Loop Stabilized", "You feel a strange calm wash over you.", "Almost... acceptance.", "chain" + 129];
              break;
            case 129:
              chaintext = ["Final Truth", "There is no chain 130.", [
                ["Create it anyway", ["You become the popup.", "You’ve always been the popup.", "chain" + 130]],
                ["Okay I’ll stop", ["No you won't.", "You can't.", "chain" + 99]]
              ]];
              break;
            case 130:
              chaintext = ["✨ Self-Aware Popup ✨", "You now appear on other people’s screens at random.", "You’ve become legend.", "chain" + 99];
              break;

            default:
              chaintext = ["Corrupted Choice", "The universe sneezed.", "Starting rollback...", "chain" + 9];
          }

          chaintext[1] = "<p>" + chaintext[1] + "</p>";
          if (Array.isArray(chaintext[2])) {
            chaintext[2].forEach(element => {
              element[1][1] = "<p>" + element[1][1] + "</p>";
            });
          }
          newPopup(0, chaintext);
        });
      });
    }



    if (special === "geolocation") {
      fetch("https://ipapi.co/json/")
        .then(res => res.json())
        .then(data => {
          const loc = `${data.city}, ${data.region}, ${data.country_name}`;
          const geoResult = popup.querySelector("#geoResult");
          if (geoResult) geoResult.innerHTML = `You are in: <strong>${loc}</strong>`;
        })
        .catch(() => {
          const geoResult = popup.querySelector("#geoResult");
          if (geoResult) geoResult.innerHTML = `Could not determine location. Are you hiding?`;
        });
    }

    if (special === "boredapi") {
      fetch("https://www.boredapi.com/api/activity/")
        .then(res => res.json())
        .then(data => {
          const activity = popup.querySelector("#activity");
          if (activity) activity.textContent = `Try this: ${data.activity}`;
        })
        .catch(() => {
          const activity = popup.querySelector("#activity");
          if (activity) activity.textContent = "API failed. Go touch grass instead.";
        });
    }


    console.log("Popup created with header:", header);
  }, timeoutInSec * 1000);

}



async function getPISS() {
  return new Promise((resolve, reject) => {
    const client = new LightstreamerClient(
      "https://push.lightstreamer.com",
      "ISSLIVE"
    );

    client.connect();

    const sub = new Subscription("MERGE", ["NODE3000005"], ["Value"]);
    sub.setRequestedSnapshot("yes");
    let resolved = false;

    sub.addListener({
      onItemUpdate: (update) => {
        if (!resolved) {
          resolved = true;
          const value = update.getValue("Value");
          resolve(value);
          client.unsubscribe(sub);
          client.disconnect();
        }
      }
    });

    client.subscribe(sub);

    setTimeout(() => {
      if (!resolved) {
        resolved = true;
        reject(new Error("Timeout waiting for update"));
        client.unsubscribe(sub);
        client.disconnect();
      }
    }, 10000);
  });


}


function secretpopup() {
  newPopup(0, ["Master:", "<p>you have called me, what you do want?</p>", "peace and mercy", "chain" + 110])
}