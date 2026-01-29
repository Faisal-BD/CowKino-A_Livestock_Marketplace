<?php
// Start Session at the very top to read error messages
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register | CowKino.com</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="../Asset/style/style.css" />
</head>
<body>

    <?php include "./header.php"; ?>

    <main class="login-section">
        <div class="login-container">
            
            <div class="login-image">
                <div class="overlay"></div>
                <div class="content-text">
                    <h2>Join the Largest Cattle Market.</h2>
                    <p>Create an account to start selling your livestock or find the best breeds near you.</p>
                </div>
                <img src="https://images.unsplash.com/photo-1595304958318-7b44e05b1842?q=80&w=1920&auto=format&fit=crop" 
                     alt="Cattle Herd"
                     onerror="this.style.display='none'">
            </div>

            <div class="login-form-wrapper">
                <div class="form-content">
                    <div class="form-header">
                        <h1>Create Account</h1>
                        <p>Join us today! It takes less than a minute.</p>
                    </div>

                    <?php if (isset($_SESSION['error_msg'])): ?>
                        <div style="background-color: #fee2e2; color: #991b1b; padding: 12px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-size: 0.9rem; border: 1px solid #fca5a5;">
                            <?php 
                                echo $_SESSION['error_msg']; 
                                unset($_SESSION['error_msg']); // Clear message after showing
                            ?>
                        </div>
                    <?php endif; ?>

                    <form id="registerForm" method="POST" action="../controller/createUserController.php">
                        
                        <div class="input-group">
                            <label for="fullname">Full Name</label>
                            <div class="input-field">
                                <i class="ph ph-user input-icon"></i>
                                <input type="text" id="fullname" name="fullname" placeholder="e.g. Rahim Uddin" required>
                            </div>
                        </div>

                        <div class="input-group">
                            <label for="email">Email Address</label>
                            <div class="input-field">
                                <i class="ph ph-envelope input-icon"></i>
                                <input type="email" id="email" name="email" placeholder="farmer@example.com" required>
                            </div>
                        </div>

                        <div class="input-group">
                            <label for="phone">Phone Number</label>
                            <div class="input-field">
                                <i class="ph ph-phone input-icon"></i>
                                <input type="tel" id="phone" name="phone" placeholder="+880 1XXX XXXXXX" required>
                            </div>
                        </div>

                       
                        <div class="input-group">
                            <label for="user_type">User Type</label>
                            <div class="input-field">
                                <i class="ph ph-identification-card input-icon"></i>
                                <select id="user_type" name="user_type" required style="width:100%; border:none; outline:none; background:transparent;">
                                    <option value="" disabled selected>Select user type</option>
                                    <option value="buyer">Buyer</option>
                                    <option value="seller">Seller</option>
                                     <option value="admin">Admin</option>
                                </select>
                            </div>
                        </div>

                        <div class="input-group">
                            <label for="password">Password</label>
                            <div class="input-field">
                                <i class="ph ph-lock-key input-icon"></i>
                                <input type="password" id="password" name="password" class="pass-input" required>
                                <i class="ph ph-eye-slash toggle-pass" onclick="toggleOnePass(this, 'password')"></i>
                            </div>
                        </div>

                        <div class="input-group">
                            <label for="confirm-password">Confirm Password</label>
                            <div class="input-field">
                                <i class="ph ph-check-circle input-icon"></i>
                                <input type="password" id="confirm-password" name="confirm_password" class="pass-input" required>
                                <i class="ph ph-eye-slash toggle-pass" onclick="toggleOnePass(this, 'confirm-password')"></i>
                            </div>
                        </div>

                        <div class="form-actions" style="justify-content: flex-start; gap: 0.5rem;">
                            <input type="checkbox" id="terms" required style="width: auto; margin-top: 3px;">
                            <label for="terms" style="font-size: 0.85rem; color: #4B5563; font-weight: 400; margin:0;">
                                I agree to the <a href="#" style="color:var(--primary); font-weight:600;">Terms & Privacy</a>
                            </label>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary btn-full btn-lg">Create Account</button>

                        <p class="signup-link">Already have an account? <a href="login.php">Log In</a></p>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <?php include "./footer.php"; ?>

    <script src="../Asset/Js/script.js"></script>
    <script>
        function toggleOnePass(icon, inputId) {
            const input = document.getElementById(inputId);
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);

            if(type === 'text') {
                icon.classList.remove('ph-eye-slash');
                icon.classList.add('ph-eye');
            } else {
                icon.classList.remove('ph-eye');
                icon.classList.add('ph-eye-slash');
            }
        }
    </script>
</body>
</html>
