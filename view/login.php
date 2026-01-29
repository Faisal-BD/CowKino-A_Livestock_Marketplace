<?php
// Start Session at the very top to read error/success messages
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | CowKino.com</title>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Poppins:wght@600;700;800&display=swap"
    rel="stylesheet" />
  <script src="https://unpkg.com/@phosphor-icons/web"></script>
  <link rel="stylesheet" href="../Asset/style/style.css" />
</head>

<body>
  <?php
  include "./header.php";
  ?>
  <main class="login-section">
    <div class="login-container">
      <div class="login-image">
        <div class="overlay"></div>
        <div class="content-text">
          <h2>Welcome back to the farm.</h2>
          <p>Track your cattle sales and connect with buyers instantly.</p>
        </div>
        <img
          src="https://images.stockcake.com/public/1/7/d/17d3ac65-91b4-48c0-83c0-b97528deaf6d_large/cow-eating-grass-stockcake.jpg"
          alt="Cow Grazing"
          onerror="this.style.display='none'" />
      </div>

      <div class="login-form-wrapper">
        <div class="form-content">
          <div class="form-header">
            <h1>Sign In</h1>
            <p>Enter your details to access your account.</p>
          </div>

          <?php if (isset($_SESSION['success_msg'])): ?>
            <div style="background-color: #dcfce7; color: #166534; padding: 12px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-size: 0.9rem; border: 1px solid #86efac;">
                <?php 
                    echo $_SESSION['success_msg']; 
                    unset($_SESSION['success_msg']); 
                ?>
            </div>
          <?php endif; ?>

          <?php if (isset($_SESSION['error_msg'])): ?>
            <div style="background-color: #fee2e2; color: #991b1b; padding: 12px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-size: 0.9rem; border: 1px solid #fca5a5;">
                <?php 
                    echo $_SESSION['error_msg']; 
                    unset($_SESSION['error_msg']); 
                ?>
            </div>
          <?php endif; ?>

          <form id="loginForm" method="POST" action="../controller/login_check.php">

            <div class="input-group">
              <label for="email">Email Address</label>
              <div class="input-field">
                <i class="ph ph-envelope input-icon"></i>
                <input
                  type="email"
                  id="email"
                  name="email"
                  placeholder="farmer@example.com"
                  required />
              </div>
            </div>

            <div class="input-group">
              <label for="password">Password</label>
              <div class="input-field">
                <i class="ph ph-lock-key input-icon"></i>
                <input
                  type="password"
                  id="password"
                  name="password"
                  placeholder="••••••••"
                  required />
                <i
                  class="ph ph-eye-slash toggle-pass"
                  id="togglePassword"></i>
              </div>
            </div>

            <div class="form-actions">
              <label class="remember-me">
                <input type="checkbox" name="remember" /> <span>Remember me</span>
              </label>
              <a href="#" class="forgot-pass">Forgot Password?</a>
            </div>

            <button type="submit" name="submit" class="btn btn-primary btn-full btn-lg">
              Sign In
            </button>

            <div class="divider"><span>Or continue with</span></div>
            <div class="social-btns">
              <button type="button" class="social-btn">
                <i class="ph-bold ph-google-logo"></i> Google
              </button>
              <button type="button" class="social-btn">
                <i class="ph-bold ph-facebook-logo"></i> Facebook
              </button>
            </div>

            <p class="signup-link">
              Don't have an account? <a href="register.php">Register here</a>
            </p>
          </form>
        </div>
      </div>
    </div>
  </main>
  <?php include "./footer.php"; ?>

  <script src="../Asset/Js/script.js"></script>
  <script>
    // Password toggle script
    const toggleBtn = document.getElementById("togglePassword");
    const passInput = document.getElementById("password");
    if (toggleBtn) {
      toggleBtn.addEventListener("click", () => {
        const type =
          passInput.getAttribute("type") === "password" ? "text" : "password";
        passInput.setAttribute("type", type);
        toggleBtn.classList.toggle("ph-eye-slash");
        toggleBtn.classList.toggle("ph-eye");
      });
    }
  </script>
</body>

</html>