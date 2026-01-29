<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CowKino.com | Modern Livestock Trading</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap"
      rel="stylesheet"
    />
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="./Asset/style/style.css?v2.2" />
  </head>
  <body>
    <header class="navbar" id="navbar">
    <div class="container nav-container">
        
        <a href="#" class="logo">
            <i class="ph-fill ph-cow"></i>CowKino<span class="highlight">.com</span>
        </a>

        <nav class="nav-menu" id="navMenu">
            <ul class="nav-links">
                <li><a href="./index.php" class="nav-link">Home</a></li>
                <li><a href="#about" class="nav-link">About</a></li>
                <li><a href="#contact" class="nav-link">Contact</a></li>
                <li><a href="./view/query.php" class="nav-link">Query</a></li>
                <li><a href="food.php" class="nav-link">Food</a></li>
                
                <li class="mobile-only">
                    <?php if (isset($_SESSION['status']) && $_SESSION['status'] === true): ?>
                        <a href="./controller/logout.php" class="nav-link">Logout</a>
                    <?php else: ?>
                        <a href="./view/login.php" class="nav-link">Login</a>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>

        <div class="nav-actions">
            <div class="trade-buttons">
                <?php
                // Role-based navigation:
                // - Buyer: can buy only (no Sell Cow)
                // - Seller: can sell only (no Buy Cow)
                // - Guest/Other roles: show both
                $isLoggedIn = (isset($_SESSION['status']) && $_SESSION['status'] === true);
                $role = $isLoggedIn && isset($_SESSION['role']) ? strtolower((string)$_SESSION['role']) : '';

                if ($role === 'buyer') {
                    echo '<a href="./view/buy.php" class="btn btn-primary">Buy Cow</a>';
                } elseif ($role === 'seller') {
                    echo '<a href="./view/sell.php" class="btn btn-outline">Sell Cow</a>';
                } else {
                    echo '<a href="./view/sell.php" class="btn btn-outline">Sell Cow</a>';
                    echo '<a href="./view/buy.php" class="btn btn-primary">Buy Cow</a>';
                }
                ?>
            </div>

            <div class="auth-buttons">
                <?php 
                // CHECK: Is the user logged in?
                if (isset($_SESSION['status']) && $_SESSION['status'] === true): 
                ?>
                    <span style="font-weight: 600; color: var(--secondary); margin-right: 10px;">
                        Hi, <?php echo htmlspecialchars($_SESSION['user_name']); ?> !
                    </span>
                    <a href="./controller/logout.php" class="btn btn-outline" style="border-color: #ef4444; color: #ef4444;">
                        Logout
                    </a>

                <?php else: ?>
                    <a href="./view/login.php" class="btn btn-text">Login</a>
                    <a href="./view/register.php" class="btn btn-dark">Register</a>
                <?php endif; ?>
            </div>

            <button class="hamburger" id="hamburger">
                <i class="ph ph-list"></i>
            </button>
        </div>
    </div>
</header>

    <section class="hero">
      <div class="hero-overlay"></div>
      <div class="container hero-content">
        <span class="badge">Trusted by 10,000+ Farmers</span>
        <h1>The Smart Way to <br />Trade Livestock</h1>
        <p>
          Connect directly with verified breeders. Transparent pricing, health
          history checks, and secure payments for every cow.
        </p>
        <div class="hero-btns">
          <a href="#market" class="btn btn-xl btn-primary">Browse Market</a>
          <a href="#sell" class="btn btn-xl btn-glass"
            >Start Selling <i class="ph ph-arrow-right"></i
          ></a>
        </div>
      </div>
    </section>

    <section class="stats">
      <div class="container stats-grid">
        <div class="stat-item">
          <h3>5,200+</h3>
          <p>Cows Sold</p>
        </div>
        <div class="stat-item">
          <h3>98%</h3>
          <p>Happy Traders</p>
        </div>
        <div class="stat-item">
          <h3>64</h3>
          <p>Districts Covered</p>
        </div>
      </div>
    </section>

    <section class="section how-it-works" id="about">
      <div class="container">
        <div class="section-header">
          <h2>How CowKino Works</h2>
          <p>Trading cattle has never been this simple and secure.</p>
        </div>
        <div class="steps-grid">
          <div class="step-card">
            <div class="icon-box"><i class="ph ph-magnifying-glass"></i></div>
            <h3>1. Search</h3>
            <p>
              Filter by breed, weight, age, and location to find the perfect
              match.
            </p>
          </div>
          <div class="step-card">
            <div class="icon-box"><i class="ph ph-chats-circle"></i></div>
            <h3>2. Connect</h3>
            <p>
              Chat directly with the seller and request video proof or health
              vet papers.
            </p>
          </div>
          <div class="step-card">
            <div class="icon-box"><i class="ph ph-handshake"></i></div>
            <h3>3. Deal</h3>
            <p>
              Agree on a price. Use our secure escrow service for safe payment.
            </p>
          </div>
        </div>
      </div>
    </section>

    <section class="section featured">
      <div class="container">
        <div class="section-header">
          <h2>Featured Cattle</h2>
          <a href="#" class="view-all"
            >View All <i class="ph ph-arrow-right"></i
          ></a>
        </div>
        <div class="listings-grid">
          <article class="cow-card">
            <div class="card-image">
              <span class="tag-price">$1,200</span>
              <img
                src="https://images.unsplash.com/photo-1545468800-85cc9bc6ecf7?auto=format&fit=crop&w=600&q=80"
                alt="Holstein Cow"
              />
            </div>
            <div class="card-body">
              <h3>Holstein Friesian (Dairy)</h3>
              <p class="location"><i class="ph ph-map-pin"></i> Rangpur, BD</p>
              <div class="card-meta">
                <span><i class="ph ph-scales"></i> 450kg</span>
                <span><i class="ph ph-calendar"></i> 3 Yrs</span>
              </div>
              <button class="btn btn-sm btn-outline-primary">
                View Details
              </button>
            </div>
          </article>

          <article class="cow-card">
            <div class="card-image">
              <span class="tag-price">$950</span>
              <img
                src="https://images.unsplash.com/photo-1570042225831-d98fa7577f1e?auto=format&fit=crop&w=600&q=80"
                alt="Jersey Cow"
              />
            </div>
            <div class="card-body">
              <h3>Red Chittagong</h3>
              <p class="location">
                <i class="ph ph-map-pin"></i> Chittagong, BD
              </p>
              <div class="card-meta">
                <span><i class="ph ph-scales"></i> 320kg</span>
                <span><i class="ph ph-calendar"></i> 2.5 Yrs</span>
              </div>
              <button class="btn btn-sm btn-outline-primary">
                View Details
              </button>
            </div>
          </article>

          <article class="cow-card">
            <div class="card-image">
              <span class="tag-price">$2,100</span>
              <img
                src="https://images.unsplash.com/photo-1500595046743-cd271d694d30?auto=format&fit=crop&w=600&q=80"
                alt="Brahman Cow"
              />
            </div>
            <div class="card-body">
              <h3>Premium Brahman Bull</h3>
              <p class="location"><i class="ph ph-map-pin"></i> Dhaka, BD</p>
              <div class="card-meta">
                <span><i class="ph ph-scales"></i> 800kg</span>
                <span><i class="ph ph-calendar"></i> 4 Yrs</span>
              </div>
              <button class="btn btn-sm btn-outline-primary">
                View Details
              </button>
            </div>
          </article>
        </div>
      </div>
    </section>

    <section class="section contact" id="contact">
      <div class="container contact-wrapper">
        <div class="contact-text">
          <h2>Ready to grow your farm?</h2>
          <p>
            Join the CowKino community today. If you have questions, our support
            team is here 24/7.
          </p>
          <div class="contact-info">
            <div class="info-item">
              <i class="ph ph-phone"></i> +880 1234 567890
            </div>
            <div class="info-item">
              <i class="ph ph-envelope"></i> support@cowkino.com
            </div>
          </div>
        </div>
        <div class="contact-form-box">
          <form>
            <input type="text" placeholder="Your Name" class="form-input" />
            <input
              type="email"
              placeholder="Email Address"
              class="form-input"
            />
            <textarea
              placeholder="Message"
              rows="3"
              class="form-input"
            ></textarea>
            <button class="btn btn-primary btn-full">Send Message</button>
          </form>
        </div>
      </div>
    </section>

    <?php include "./view/footer.php"; ?>

    <script src="/Asset/Js/script.js"></script>
  </body>
</html>
