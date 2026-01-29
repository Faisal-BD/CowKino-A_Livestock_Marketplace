<?php
session_start();

// Check login
if (!isset($_SESSION['status']) || $_SESSION['status'] !== true) {
    header("Location: login.php");
    exit();
}

// DB connection
require_once __DIR__ . '/../model/DataBase.php';
// ✅ Ensure cow_foods table exists (prevents errors if SQL dump didn't include it)
$createFoodsTable = "CREATE TABLE IF NOT EXISTS `cow_foods` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(120) NOT NULL,
    `description` TEXT NOT NULL,
    `price` INT UNSIGNED NOT NULL,
    `quantity` INT UNSIGNED NOT NULL,
    `image` VARCHAR(255) NOT NULL,
    `seller_id` INT UNSIGNED NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_seller_id` (`seller_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
$conn->query($createFoodsTable);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $name        = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price       = (int)($_POST['price'] ?? 0);
    $quantity    = (int)($_POST['quantity'] ?? 0);
    $seller_id   = (int)($_SESSION['user_id'] ?? 0);

    if ($name === '' || $description === '' || $price <= 0 || $quantity <= 0 || $seller_id <= 0) {
        $_SESSION['error_msg'] = "Please fill all fields correctly!";
        header("Location: add_food.php");
        exit();
    }

    // Upload folder
    $uploadDir = __DIR__ . '/../upload/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {

        // Max 5MB
        if ($_FILES['image']['size'] > 5 * 1024 * 1024) {
            $_SESSION['error_msg'] = "Image size must be under 5MB!";
            header("Location: add_food.php");
            exit();
        }

        // Get next sequential number
        $files = glob($uploadDir . '*.*');
        $max_num = 0;
        foreach ($files as $f) {
            $base = pathinfo($f, PATHINFO_FILENAME);
            if (is_numeric($base) && (int)$base > $max_num) {
                $max_num = (int)$base;
            }
        }
        $next_num = $max_num + 1;

        // Get original extension
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($ext, $allowed, true)) {
            $_SESSION['error_msg'] = "Only JPG, JPEG, PNG, or WEBP images are allowed.";
            header("Location: add_food.php");
            exit();
        }

        // Extra validation: ensure it's a real image
        $imgInfo = @getimagesize($_FILES['image']['tmp_name']);
        if ($imgInfo === false) {
            $_SESSION['error_msg'] = "Invalid image file.";
            header("Location: add_food.php");
            exit();
        }
$image_name = $next_num . '.' . $ext;
        $upload_path = $uploadDir . $image_name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {

            // ✅ Make sure this table exists: cow_foods
            $sql = "INSERT INTO cow_foods (name, description, price, quantity, image, seller_id)
                    VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                $_SESSION['error_msg'] = "Prepare failed: " . $conn->error;
                header("Location: add_food.php");
                exit();
            }

            // ✅ Correct types:
            // name(s), description(s), price(i), quantity(i), image(s), seller_id(i)
            $stmt->bind_param("ssiisi", $name, $description, $price, $quantity, $image_name, $seller_id);

            if ($stmt->execute()) {
                echo "<script>
                        alert('Food uploaded successfully!');
                        window.location.href='../food.php';
                      </script>";
                exit();
            } else {
                $_SESSION['error_msg'] = "DB error: " . $stmt->error;
                header("Location: add_food.php");
                exit();
            }

        } else {
            $_SESSION['error_msg'] = "Failed to move uploaded file! Check upload folder permission.";
            header("Location: add_food.php");
            exit();
        }

    } else {
        $_SESSION['error_msg'] = "Please select an image!";
        header("Location: add_food.php");
        exit();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sell Cow Food | CowKino.com</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="../Asset/style/style.css" />
</head>
<body>
    <?php include "./header.php"; ?>

    <main class="login-section">
        <div class="login-container">

            <div class="login-image sell-image-side">
                <div class="overlay"></div>
                <div class="content-text">
                    <h2>Sell Your Cow Food</h2>
                    <p>Reach thousands of buyers instantly.</p>

                    <ul class="sell-tips">
                        <li><i class="ph-fill ph-check-circle"></i> Upload clear photos</li>
                        <li><i class="ph-fill ph-check-circle"></i> Enter accurate quantity</li>
                        <li><i class="ph-fill ph-check-circle"></i> Set a reasonable price</li>
                    </ul>
                </div>
                <img src="https://images.unsplash.com/photo-1596733430284-f7437764b1a9?q=80&w=1920&auto=format&fit=crop"
                    alt="Cow Food Image"
                    onerror="this.style.display='none'">
            </div>

            <div class="login-form-wrapper">
                <div class="form-content" style="max-width: 450px;">
                    <div class="form-header">
                        <h1>List Your Food</h1>
                        <p>Fill in the details below to post your food item.</p>
                    </div>

                    <?php if (isset($_SESSION['error_msg'])): ?>
                        <div style="background-color: #fee2e2; color: #991b1b; padding: 12px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-size: 0.9rem; border: 1px solid #fca5a5;">
                            <?php
                                echo $_SESSION['error_msg'];
                                unset($_SESSION['error_msg']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <form id="foodForm" action="add_food.php" method="POST" enctype="multipart/form-data">

                        <div class="input-group">
                            <label for="foodName">Food Name</label>
                            <div class="input-field">
                                <i class="ph ph-tag input-icon"></i>
                                <input type="text" id="foodName" name="name" placeholder="e.g. Organic Cow Feed" required>
                            </div>
                        </div>

                        <div class="input-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" rows="3" placeholder="Describe quality, ingredients, storage instructions..." required></textarea>
                        </div>

                        <div class="form-row">
                            <div class="input-group">
                                <label for="price">Price (USD)</label>
                                <div class="input-field">
                                    <i class="ph ph-currency-dollar input-icon"></i>
                                    <input type="number" id="price" name="price" placeholder="50" required>
                                </div>
                            </div>

                            <div class="input-group">
                                <label for="quantity">Quantity</label>
                                <div class="input-field">
                                    <!-- Packets (1,2,3...) with native number stepper arrows -->
                                    <input type="number" id="quantity" name="quantity" placeholder="1" min="1" step="1" style="padding-left: 1rem;" required>
                                </div>
                            </div>
                        </div>

                        <div class="input-group">
                            <label>Upload Image</label>
                            <div class="file-upload-box">
                                <input type="file" id="foodImage" name="image" accept="image/*" hidden required>
                                <div class="upload-content" onclick="document.getElementById('foodImage').click()">
                                    <i class="ph ph-cloud-arrow-up"></i>
                                    <p>Click to upload or drag image here</p>
                                    <span>Max 5MB per image</span>
                                </div>
                            </div>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary btn-full btn-lg">Post Food Now</button>

                    </form>
                </div>
            </div>
        </div>
    </main>

    <?php include "./footer.php"; ?>
    <script src="/Asset/Js/script.js"></script>
</body>
</html>
