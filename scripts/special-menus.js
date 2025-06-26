document.addEventListener('DOMContentLoaded', () => {
  const specialPhysics = document.getElementById('morephysics-menu');
  const physToggle = document.getElementById('enablephysics');
  const blindmode = document.getElementById('blindmode');
  const duckbox = document.getElementById('duckhunt-card');
  const checkbox = document.getElementById('checkbox');
  const menu = document.getElementById('specials-menu');
  const ravemode = document.getElementById('ravemode');
  const devmode = document.getElementById('devModeToggle');
  const pong = document.getElementById('pong');
  const audio = document.getElementById('bounceSound');
  const mutebutton = document.getElementById('muteicon');
  const muteimg = document.getElementById('muteiconimg');
  const birdpoop = document.getElementById('triggerbirdpoop');

  // Add any other objects that should be toggled with the main menu checkbox
  const whatobjects = [menu, duckbox];
  // const allmenuitems = document.querySelectorAll('.overlay-menu');

  // Objects that should add what class whesn rave is on
  whattochangetowhat = [
    { from: 'sp-rave', to: 'raveactive' },
    { from: 'card', to: 'raveactive' }
  ];

  const toggledCheckboxes = [
    {
      element: checkbox,
      storageKey: 'mainmenucheckbox',
      remember: false,
      updateUI: (checked) => {
        if (checked) {
          whatobjects.forEach(obj => {
            gsap.to(obj, {
              duration: 0.2,
              autoAlpha: 1,
              onStart: () => { obj.classList.remove('inactive'); }
            });
          });
        } else if (physToggle.checked) {
          whatobjects.forEach(obj => {
            gsap.to(obj, {
              duration: 0.2,
              autoAlpha: 0.5,
              onStart: () => { obj.classList.remove('inactive'); }
            });
          });
        } else {
          mutebutton.style.display = 'none';
          whatobjects.forEach(obj => {
            gsap.to(obj, {
              duration: 0.2,
              autoAlpha: 0,
              onComplete: () => {
                obj.classList.add('overlay-menu', 'inactive');
              }
            });
          });
        }
      }
    },
    {
      element: mutebutton,
      storageKey: 'mutebutton',
      remember: false,
      updateUI: (checked) => {
        if (checked) {
          audio.muted = true;
          muteimg.src = 'images/specials/mute.png';
          audio.src = '';
        } else {
          audio.muted = false;
          muteimg.src = 'images/specials/notmute.png';
          audio.src = 'sounds/bounce.mp3';
        }
      }
    },
    {
      element: birdpoop,
      storageKey: 'birdpoop',
      remember: false,
      updateUI: (checked) => {
        if (checked) {
            poop = document.createElement('div');
            poop.className = 'poop';
            poop.classList.add("overlay-menu");
            poop.style.top = (Math.random()*100)+"vh";
            poop.style.left = (Math.random()*100)+"vw";
            document.body.appendChild(poop);
        }
      }
    },
    {
      element: physToggle,
      storageKey: 'physToggle',
      remember: false,
      updateUI: (checked) => {
        if (checked) {
          specialPhysics.style.opacity = 1;
          mutebutton.style.opacity = 1;
          mutebutton.style.display = 'unset';
          specialPhysics.classList.remove('inactive');
          mutebutton.classList.remove('inactive');
          enableMatter(physicsConfig);

          // Disable AOS animations:
          AOS.init({ disable: true });
          document.querySelectorAll('[data-aos]').forEach(el => {
            el.removeAttribute('data-aos');
            el.classList.remove('aos-init', 'aos-animate');
          });
        } else {
          let lavaContainer = document.getElementById('lava-container');
          if (!lavaContainer) {
            lavaContainer = document.createElement('div');
            lavaContainer.id = 'lava-container';
            document.body.insertAdjacentElement('afterbegin', lavaContainer);
          }
          fetch('/pages/specials/lavatodestroyphysics.php')
            .then(response => response.text())
            .then(text => {
              lavaContainer.innerHTML = text;
              const scripts = lavaContainer.querySelectorAll('script');
              scripts.forEach(oldScript => {
                const newScript = document.createElement('script');
                newScript.text = oldScript.text;
                document.body.appendChild(newScript);
                document.body.removeChild(newScript);
              });
            })
            .catch(error => console.error('Error loading lavatodestroyphysics.php:', error));
        }
      }
    },
    {
      element: devmode,
      storageKey: 'devModeToggle',
      remember: false,
      updateUI: (checked) => {
        document.querySelectorAll('*').forEach(el => {
          if (checked) {
            el.classList.add('dev-border');
          } else {
            el.classList.remove('dev-border');
          }
        });
      }
    },
    {
      element: ravemode,
      storageKey: 'ravemode',
      remember: true,
      updateUI: (checked) => {
        whattochangetowhat.forEach(change => {
          document.querySelectorAll(`.${change.from}`).forEach(el => {
            if (checked) {
              el.classList.add(change.to);
            } else {
              el.classList.remove(change.to);
            }
          });
        });
        if (checked) {
          let raveContainer = document.getElementById('ravemode-container');
          if (!raveContainer) {
            raveContainer = document.createElement('div');
            raveContainer.id = 'ravemode-container';
            document.body.insertAdjacentElement('afterbegin', raveContainer);
          }
          fetch('/pages/specials/rave.php')
            .then(response => response.text())
            .then(text => {
              raveContainer.innerHTML = text;
              // Find and run inline scripts
              const scripts = raveContainer.querySelectorAll('script');
              scripts.forEach(oldScript => {
                const newScript = document.createElement('script');
                newScript.text = oldScript.text;
                document.body.appendChild(newScript);
                document.body.removeChild(newScript);
              });
            })
            .catch(error => console.error('Error loading pong.php:', error));
        } else {
          const raveContainer = document.getElementById('ravemode-container');
          if (raveContainer) {
            raveContainer.remove();
          }
        }
      }
    },
    {
      element: blindmode,
      storageKey: 'blindmode',
      remember: true,
      updateUI: (checked) => {
        const body = document.querySelector('body');
        body.style.fontFamily = checked ? 'Braille, sans-serif' : '';
      }
    },
    {
      element: pong,
      storageKey: 'pong',
      remember: false,
      updateUI: (checked) => {
        if (checked) {
          let pongContainer = document.getElementById('pong-container');
          if (!pongContainer) {
            pongContainer = document.createElement('div');
            pongContainer.id = 'pong-container';
            document.body.insertAdjacentElement('afterbegin', pongContainer);
          }
          fetch('/pages/specials/pong.php')
            .then(response => response.text())
            .then(text => {
              pongContainer.innerHTML = text;
              const scripts = pongContainer.querySelectorAll('script');
              scripts.forEach(oldScript => {
                const newScript = document.createElement('script');
                newScript.text = oldScript.text;
                document.body.appendChild(newScript);
                document.body.removeChild(newScript);
              });
            })
            .catch(error => console.error('Error loading pong.php:', error));
        } else {
          const pongContainer = document.getElementById('pong-container');
          if (pongContainer) {
            pongContainer.innerHTML = '';
            pongContainer.remove();
          }
        }
      }
    }
  ];

  toggledCheckboxes.forEach(toggle => {
    let state;
    if (toggle.remember && localStorage.getItem(toggle.storageKey) !== null) {
      state = localStorage.getItem(toggle.storageKey) === "true";
      if (toggle.element.tagName === 'INPUT') {
        toggle.element.checked = state;
      }
    } else {
      if (toggle.element.tagName === 'INPUT') {
        state = toggle.element.checked;
      } else {
        state = toggle.element.dataset.checked === "true";
      }
    }

    if (toggle.remember) {
      toggle.updateUI(state);
    }

    toggle.element.addEventListener('click', () => {
      if (toggle.element.tagName === 'INPUT') {
        state = toggle.element.checked;
      } else {
        state = !(toggle.element.dataset.checked === "true");
        toggle.element.dataset.checked = state;
      }
      toggle.updateUI(state);
      if (toggle.remember) {
        localStorage.setItem(toggle.storageKey, state);
        if (toggle.element.tagName === 'INPUT') {
          toggle.element.checked = state;
        }
      }
    });
  });

  toggledCheckboxes.find(toggle => toggle.element === checkbox).updateUI(false);
  toggledCheckboxes.find(toggle => toggle.element === mutebutton).updateUI(false);

  specialPhysics.classList.add('inactive');
  mutebutton.classList.add('inactive');
  menu.classList.add('inactive');
  duckbox.classList.add('inactive');

  AOS.init();

});
