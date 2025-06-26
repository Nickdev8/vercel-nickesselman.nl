<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'null';
?>

<header class="site-header" id="site--header-main">
  <div class="navbar container wide"
     <?php
       if ($page === 'home') {
         echo 'data-aos="fade-down" data-aos-once="true"';
       }
     ?>>
    <a href="index.php" class="logo">
      <img src="./images/logo_transparent.png" class="logo" alt="Logo" />
    </a>
    <ul class="nav-links">
      <li><a href="?page=neighborhoodblog"><span>⦿ LIVE </span>Blog</a></li>
      <li><a href="?page=home">Home</a></li>
      <li><a href="?page=about">Skills & About</a></li>
      <li><a href="?page=projects">Projects</a></li>
      <li><a href="?page=contact">Contact</a></li>
      <li><a href="?page=cv">CV</a></li>
    </ul>
  </div>
</header>

<style>
  /* Header/Navbar Styles */
  .site-header {
    position: sticky;
    width: 100%;
    background: var(--myblue);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    top: 0;
    z-index: 10;
  }

  .nav-links span{
    color: red;
    font-weight: 700;
    font-size: 0.9em;
  }

  .navbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 2rem;
  }

  .logo img {
    height: 4rem;
    width: auto;
    vertical-align: middle;
  }

  .nav-links {
    list-style: none;
    display: flex;
    gap: 2.5rem;
  }

  .nav-links li {
    display: inline-block;
  }

  .nav-links a {
    color: #fff;
    text-decoration: none;
    font-size: 1.8rem;
    font-weight: 500;
    transition: color 0.2s;
    padding: 0.5rem 1rem;
    border-radius: 0.4rem;
    position: relative;
    z-index: 1010;
  }

  .nav-links a:hover,
  .nav-links a:focus {
    background: var(--myblue);
    color: var(--orange);
  }

  /* Responsive: Stack nav links on small screens */
  @media (max-width: 600px) {
    .navbar .contain {
      flex-direction: column;
      align-items: flex-start;
    }

    .nav-links {
      flex-direction: column;
      gap: 1.2rem;
      width: 100%;
      margin-top: 1rem;
    }
  }

  /* Make sure it can wrap */
  .navbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    /* <-- allow wrapping */
    padding: 0 2rem;
  }

  /* Mobile tweaks */
  @media (max-width: 600px) {
    .navbar {
      flex-direction: column;
      /* stack logo + links */
      align-items: center;
      /* center everything */
      padding: 1rem;
      /* smaller side padding */
    }

    .logo {
      margin-bottom: 0.8rem;
      /* space below the logo */
      display: none;
    }

    .nav-links {
      display: flex;
      flex-direction: row;
      /* keep links in a row */
      flex-wrap: wrap;
      /* wrap to the next line if needed */
      gap: 0.8rem;
      /* smaller gap */
      justify-content: center;
      width: 100%;
      overflow-x: auto;
      /* allow horizontal scroll if really tight */
      margin: 0;
      /* reset any previous margins */
      padding: 0;
      /* reset padding */
    }

    .nav-links li {
      /* optionally let each link grow if you want equal width:
       flex: 1 1 auto;
    */
    }

    .nav-links a {
      font-size: 1.6rem;
      /* slightly smaller text */
      padding: 0.4rem 0.8rem;
      /* tighter padding */
    }
  }







  .nav-links a {
    color: #fff;
    text-decoration: none;
    font-size: 1.8rem;
    font-weight: 500;
    padding: 0.5rem 1rem;
    border-radius: 0.4rem;
    position: relative;
    overflow: hidden;
    transition: color 0.2s;
  }

  .nav-links a::after {
    content: "";
    position: absolute;
    left: 50%;
    bottom: 0.2rem;
    width: 0;
    height: 2px;
    background: #ff8c37;
    transition: width 0.3s ease, left 0.3s ease;
  }

  .nav-links a:hover,
  .nav-links a:focus {
    background: var(--myblue);
    color: #ff8c37;
  }

  .nav-links a:hover::after,
  .nav-links a:focus::after {
    width: 80%;
    left: 10%;
  }

  .nav-links a .ripple {
    position: absolute;
    border-radius: 50%;
    transform: scale(0);
    background: rgba(255, 140, 55, 0.4);
    animation: ripple 0.6s linear;
    pointer-events: none;
  }

  @keyframes ripple {
    to {
      transform: scale(4);
      opacity: 0;
    }
  }
</style>