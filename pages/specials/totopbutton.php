
<button class="totopbutton" id="backToTop">
  <svg class="svgIcon" viewBox="0 0 384 512">
    <path
      d="M214.6 41.4c-12.5-12.5-32.8-12.5-45.3 0l-160 160c-12.5 12.5-12.5 32.8
         0 45.3s32.8 12.5 45.3 0L160 141.2V448c0 17.7 14.3 32 32 32s32-14.3
         32-32V141.2L329.4 246.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8
         0-45.3l-160-160z">
    </path>
  </svg>
</button>

<style>
  .totopbutton {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background-color: var(--darkless);
    border: none;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0px 0px 0px 4px rgba(180, 160, 255, 0.253);
    overflow: hidden;
    cursor: pointer;
    position: fixed;
    bottom: 8rem;
    right: 4rem;
    z-index: 999;

    opacity: 0;
    visibility: hidden;
    transform: translateY(20px);
    pointer-events: none;

    transition: all 0.3s ease-out;
  }

  .totopbutton.visible {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
    pointer-events: auto;
  }

  .totopbutton:hover {
    transform: translateY(0) scale(1.1);
  }

  .totopbutton .svgIcon {
    width: 12px;
    transition: transform 0.3s ease-out;
  }

  .totopbutton .svgIcon path {
    fill: white;
  }

  .totopbutton:hover .svgIcon {
    transform: translateY(-30%);
  }

  .totopbutton::before {
    display: none;
  }
</style>

<script>
  (function() {
    const totopbtn   = document.getElementById('backToTop');
    const showAfter  = 0;

    window.addEventListener('scroll', () => {
      totopbtn.classList.toggle('visible', window.scrollY > showAfter);
    });

    var elevator = new Elevator({
      element: totopbtn,
      mainAudio: '/sounds/elevator.mp3',
      endAudio: '/sounds/ding.mp3',
      duration: 15500
    });
  })();
</script>
