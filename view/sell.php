<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['status']) || $_SESSION['status'] !== true) {
    header('location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sell Your Cow | CowKino.com</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="../Asset/style/style.css" />
</head>

<body>
    <?php
    include "./header.php";
    ?>
    <main class="login-section">
        <div class="login-container">

            <div class="login-image sell-image-side">
                <div class="overlay"></div>
                <div class="content-text">
                    <h2>Get the Best Price.</h2>
                    <p>Reach thousands of buyers instantly.</p>

                    <ul class="sell-tips">
                        <li><i class="ph-fill ph-check-circle"></i> Upload clear photos</li>
                        <li><i class="ph-fill ph-check-circle"></i> State the correct weight</li>
                        <li><i class="ph-fill ph-check-circle"></i> Verify vaccination history</li>
                    </ul>
                </div>
                <img src="https://images.unsplash.com/photo-1596733430284-f7437764b1a9?q=80&w=1920&auto=format&fit=crop"
                    alt="Farmer with Cow"
                    onerror="this.style.display='none'">
            </div>

            <div class="login-form-wrapper">
                <div class="form-content" style="max-width: 450px;">
                    <div class="form-header">
                        <h1>List Your Cattle</h1>
                        <p>Fill in the details below to post your ad.</p>
                    </div>

                    <?php if (isset($_SESSION['error_msg'])): ?>
                        <div style="background-color: #fee2e2; color: #991b1b; padding: 12px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-size: 0.9rem; border: 1px solid #fca5a5;">
                            <?php 
                                echo $_SESSION['error_msg']; 
                                unset($_SESSION['error_msg']); 
                            ?>
                        </div>
                    <?php endif; ?>
                    <form id="sellForm" action="../controller/sell_check.php" method="POST" enctype="multipart/form-data">

                        <div class="input-group">
                            <label for="cowName">Cow Name / Title</label>
                            <div class="input-field">
                                <i class="ph ph-tag input-icon"></i>
                                <input type="text" id="cowName" name="cowName" placeholder="e.g. Healthy Australian Friesian" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="input-group">
                                <label for="breed">Breed</label>
                                <div class="input-field">
                                    <i class="ph ph-paw-print input-icon"></i>
                                    <select id="breed" name="breed" required>
                                        <option value="" disabled selected>Select Breed</option>
                                        <option value="Holstein">Holstein Friesian</option>
                                        <option value="Brahman">Brahman</option>
                                        <option value="Jersey">Jersey</option>
                                        <option value="Sahiwal">Sahiwal</option>
                                        <option value="RedChittagong">Red Chittagong</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <i class="ph ph-caret-down select-arrow"></i>
                                </div>
                            </div>

                            <div class="input-group">
                                <label for="price">Price (BDT)</label>
                                <div class="input-field">
                                    <i class="ph ph-currency-dollar input-icon"></i>
                                    <input type="number" id="price" name="price" placeholder="1200" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="input-group">
                                <label>Weight (kg)</label>
                                <div class="input-field">
                                    <input type="number" name="weight" placeholder="450" style="padding-left: 1rem;" required>
                                </div>
                            </div>
                            <div class="input-group">
                                <label>Age (Yrs)</label>
                                <div class="input-field">
                                    <input type="number" name="age" placeholder="3.5" step="0.1" style="padding-left: 1rem;" required>
                                </div>
                            </div>
                        </div>

                        <div class="input-group">
                            <label>Upload Photos</label>
                            <div class="file-upload-box">
                                <input type="file" id="cowImage" name="cowImage" accept="image/*" hidden required>
                                <div class="upload-content" onclick="document.getElementById('cowImage').click()">
                                    <i class="ph ph-cloud-arrow-up"></i>
                                    <p>Click to upload or drag images here</p>
                                    <span>Max 5MB per image</span>
                                </div>
                            </div>
                        </div>

                        <div class="input-group">
                            <label for="description">Description (Optional)</label>
                            <textarea id="description" name="description" rows="3" placeholder="Describe health, food habits, location..."></textarea>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary btn-full btn-lg">Post Ad Now</button>

                    </form>
                </div>
            </div>
        </div>
    </main>

    <?php include "./footer.php"; ?>

    <script src="/Asset/Js/script.js"></script>
</body>

</html>