<?php
// Ensure session is started to read $_SESSION['status']
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<header class="navbar" id="navbar">
    <div class="container nav-container">
        <a href="../index.php" class="logo">
            <i class="ph-fill ph-cow"></i>CowKino<span class="highlight">.com</span>
        </a>

        <nav class="nav-menu" id="navMenu">
            <ul class="nav-links">
                <li><a href="../index.php" class="nav-link">Home</a></li>
                <li><a href="#about" class="nav-link">About</a></li>
                <li><a href="#contact" class="nav-link">Contact</a></li>
                
                <li class="mobile-only">
                    <?php if (isset($_SESSION['status']) && $_SESSION['status'] === true): ?>
                        <a href="./controller/logout.php" class="nav-link">Logout</a>
                    <?php else: ?>
                        <a href="./login.php" class="nav-link">Login</a>
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
                    echo '<a href="./buy.php" class="btn btn-primary">Buy Cow</a>';
                } elseif ($role === 'seller') {
                    echo '<a href="./sell.php" class="btn btn-outline">Sell Cow</a>';
                } else {
                    echo '<a href="./sell.php" class="btn btn-outline">Sell Cow</a>';
                    echo '<a href="./buy.php" class="btn btn-primary">Buy Cow</a>';
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
                    <a href="../controller/logout.php" class="btn btn-outline" style="border-color: #ef4444; color: #ef4444;">
                        Logout
                    </a>

                <?php else: ?>
                    <a href="./login.php" class="btn btn-text">Login</a>
                    <a href="./register.php" class="btn btn-dark">Register</a>
                <?php endif; ?>
            </div>

            <button class="hamburger" id="hamburger">
                <i class="ph ph-list"></i>
            </button>
        </div>
    </div>
</header>