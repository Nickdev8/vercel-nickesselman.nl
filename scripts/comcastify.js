var comcastifyjs = (function () {

    // setup slowload modifier callback, structure avoids some annoying timer/closure problems
    var slowloadModiferCallback = function (slowloadDiv, args) {
        return function () {
            (function (slowloadDiv, args) {
                // calculate new height for box based on args
                var img = slowloadDiv.slothifyData.img;
                var newTopClip = slowloadDiv.slothifyData.imageTopClip + args.loadIncrement;
                if (args.randomPause === 0.0 || Math.random() > args.randomPause) {
                    slowloadDiv.style.width = img.offsetWidth + 'px';
                    slowloadDiv.style.height = img.offsetHeight + 'px';
                    slowloadDiv.style.top = img.offsetTop + 'px';
                    slowloadDiv.style.left = img.offsetLeft + 'px';

                    // update slowload div
                    slowloadDiv.style.clip = 'rect(' + newTopClip + 'px auto auto auto)';

                    // check stopping conditions
                    var maxImageHeight = img.height * args.loadMaxPercent;
                }

                if (!img.complete) {
                    setTimeout(slowloadModiferCallback(slowloadDiv, args), args.loadSpeed);
                } else if (typeof img.naturalHeight !== "undefined" && img.naturalWidth === 0) {
                    setTimeout(slowloadModiferCallback(slowloadDiv, args), args.loadSpeed);
                } else if (!maxImageHeight || maxImageHeight === 0 || newTopClip < maxImageHeight) {
                    // create new update timeout
                    slowloadDiv.slothifyData.imageTopClip = newTopClip;
                    setTimeout(slowloadModiferCallback(slowloadDiv, args), args.loadSpeed);
                }
            })(slowloadDiv, args);
        };
    };

    var prepare = function (elements) {
        elements = elements || document.getElementsByTagName('img');
        for (var i = 0; i < elements.length; i++) {
            elements[i].style.visibility = 'hidden';
        }
    };

    var slowImages = function (args) {
        return function () {

            var params = {
                elements: args.elements || document.getElementsByTagName('img'),  // elements affected
                boxColor: args.boxColor || '#000000',                 // color of box overlay
                loadMaxPercent: args.loadMaxPercent || 0.0,           // max percentage to load images
                loadSpeed: args.loadSpeed || 500,                     // how often in ms to pass
                randLoadIncrement: args.randLoadIncrement || false,   // true to randomize load increment
                loadIncrement: args.loadIncrement || 1,               // pixels to load per pass
                randomPause: args.randomPause || 0.0                  // probability of skipping a pass
            };

            // make 'em load slow
            for (var i = 0; i < params.elements.length; i++) {
              var img    = params.elements[i],
                  parent = img.parentNode;
              // clone params per image
              var modParamPerImg = Object.create(params);
              if (modParamPerImg.randLoadIncrement) {
                modParamPerImg.loadIncrement =
                  Math.floor((Math.random() * 20) + 1);
              }

              // wrap all the overlay / rAF logic in a function
              function startSlowLoad() {
                var slowload = document.createElement('div');
                // initial box styling
                slowload.style.backgroundColor = modParamPerImg.boxColor;
                slowload.style.width  = img.offsetWidth  + 'px';
                slowload.style.height = img.offsetHeight + 'px';
                slowload.style.position = 'absolute';
                slowload.style.top      = img.offsetTop   + 'px';
                slowload.style.left     = img.offsetLeft  + 'px';
                slowload.style.clip     = 'rect(0 auto auto auto)';
                slowload.slothifyData = {
                  img: img,
                  imageTopClip: 0,
                  maxImageHeight: img.height * modParamPerImg.loadMaxPercent
                };

                parent.appendChild(slowload);
                slowload.style.pointerEvents = "none";

                // defer the actual “reveal + slow‐load loop” to the next frame
                requestAnimationFrame(() => {
                  img.style.visibility = 'visible';
                  if (modParamPerImg.loadMaxPercent > 0) {
                    setTimeout(
                      slowloadModiferCallback(slowload, modParamPerImg),
                      modParamPerImg.loadSpeed
                    );
                  }
                });
              }

              // **only** start once the image is fully loaded**
              if (img.complete && img.naturalWidth !== 0) {
                startSlowLoad();
              } else {
                img.addEventListener('load', startSlowLoad, { once: true });
              }
            }
        }
    };

    return {
        letsPrepareTheseImages: prepare,
        fixMyImagesLoadingSoFast: slowImages
    };

})();