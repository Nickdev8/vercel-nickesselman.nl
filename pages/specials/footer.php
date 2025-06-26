<footer class="site-footer" matter static>

    <?php if ($page != "cv"){
      // include_once 'pages/specials/cat.php'; 
    }
      ?>
  <div class="footer-content container">
    <div class="footer-left">
      <img src="/images/logo_transparent.png" alt="Nick Esselman Logo" class="logo footer-logo">
      <span>&copy; <?php echo date('Y'); ?> Nick Esselman</span>
      <a href="?page=contact" class="footer-contact">Contact</a>
    </div>
    <div class="footer-right">
      <span>Made for <a href="https://hackclub.com/" target="_blank" rel="noopener">Hack Club Neighborhood</a></span>
      <!-- GitHub Star Button -->
      <button class="star-button" type="button">
        <span class="star-button__shine"></span>
        <div class="star-button__primary">
          <!-- star icon SVG -->
          <span class="star-button__text">Star on GitHub</span>
        </div>
        <div class="star-button__counter">
          <!-- counter icon SVG -->
          <span class="star-button__count">…</span>
        </div>
      </button>
    </div>
  </div>
</footer>

<script>
  const owner = 'nickdev8';
  const repo = 'nickesselman.nl';
  const repoUrl = `https://github.com/${owner}/${repo}`;

  async function updateStarCount() {
    const res = await fetch(`https://api.github.com/repos/${owner}/${repo}`);
    if (!res.ok) throw new Error('Failed to fetch count');
    const { stargazers_count } = await res.json();
    document.querySelector('.star-button__count').textContent = stargazers_count;
  }

  document.querySelector('.star-button').addEventListener('click', async e => {
    const btn = e.currentTarget;
    btn.disabled = true;

    // 1) fire the star API
    const res = await fetch('/api/star', { method: 'POST' });

    // 2) open the repo page in a new tab
    window.open(repoUrl, '_blank');

    // 3) update the count & UI
    if (res.ok) {
      await updateStarCount();
      btn.classList.add('starred');
    } else {
      console.error('Star failed');
    }

    btn.disabled = false;
  });

  // On page load, show the live count
  updateStarCount();

</script>

<style>
  /* Footer base styles */
  .site-footer {
    background: var(--myblue);
    color: #fff;
    padding: 2rem 0 1rem;
    font-size: 1.5rem;
    position: relative;
    z-index: 10;
  }

  .footer-content {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    max-width: 1200px;
    margin: 0 auto;
    gap: 2rem;
  }

  .footer-left {
    display: flex;
    align-items: center;
    gap: 1rem;
  }

  .footer-logo {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    background: var(--myblue);
    object-fit: cover;
  }

  .footer-contact {
    color: #ff8c37;
    text-decoration: none;
    transition: color 0.2s;
  }

  .footer-contact:hover {
    color: #fff;
    text-decoration: underline;
  }

  .footer-right {
    font-size: 1.3rem;
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 1rem;
  }

  .footer-right>span {
    min-width: 28rem;
  }

  .footer-right a {
    color: #ff8c37;
    text-decoration: none;
  }

  .footer-right a:hover {
    text-decoration: underline;
  }

  @media (max-width: 700px) {
    .footer-content {
      flex-direction: column;
      align-items: flex-start;
      gap: 1rem;
    }

    .footer-left,
    .footer-right {
      font-size: 1.2rem;
    }
  }

  /* Star button */
  .star-button {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    width: 100%;
    max-width: 20rem;
    height: 2.25rem;
    padding: 0 1rem;
    background: #000;
    color: #fff;
    font-weight: 500;
    border: none;
    border-radius: 0.375rem;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    cursor: pointer;
    overflow: hidden;
    transition: background 0.3s ease-out, box-shadow 0.3s ease-out, transform 0.3s ease-out;
  }

  .star-button:focus-visible {
    outline: none;
    box-shadow: 0 0 0 2px #000, 0 0 0 4px rgba(0, 0, 0, 0.1);
  }

  .star-button:hover {
    background: rgba(0, 0, 0, 0.9);
    box-shadow: 0 0 0 2px #000, 0 0 0 4px rgba(0, 0, 0, 0.1);
  }

  .star-button:disabled {
    pointer-events: none;
    opacity: 0.5;
  }

  .star-button__shine {
    position: absolute;
    top: 50%;
    right: 0;
    width: 2rem;
    height: 8rem;
    margin-top: -4rem;
    background: #fff;
    opacity: 0.1;
    transform: translateX(3rem) rotate(12deg);
    transition: transform 1s ease-out;
  }

  .star-button:hover .star-button__shine {
    transform: translateX(-10rem) rotate(12deg);
  }

  .star-button__primary,
  .star-button__counter {
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .star-button__icon,
  .star-button__counter-icon {
    width: 1rem;
    height: 1rem;
    fill: currentColor;
  }

  .star-button__counter-icon {
    color: #78716c;
    transition: color 0.3s;
  }

  .star-button:hover .star-button__counter-icon {
    color: #fbbf24;
  }

  .star-button__text {
    margin-left: 0.25rem;
  }

  .star-button__count {
    font-variant-numeric: tabular-nums;
  }
</style>