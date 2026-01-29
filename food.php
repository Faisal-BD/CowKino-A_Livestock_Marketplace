<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/model/DataBase.php';
// ✅ Ensure cow_foods table exists (prevents fatal error if the SQL dump didn't include it)
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

mysqli_query($conn, $createFoodsTable);

$sql = "SELECT id, name, price, quantity, image, seller_id FROM cow_foods ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

$foods = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $foods[] = $row;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>CowKino.com | Cow Food Marketplace</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet" />
<script src="https://unpkg.com/@phosphor-icons/web"></script>
<link rel="stylesheet" href="./Asset/style/style.css?v2.3" />
</head>
<body>

<header class="navbar" id="navbar">
    <div class="container nav-container">
        <a href="./index.php" class="logo"><i class="ph-fill ph-cow"></i>CowKino<span class="highlight">.com</span></a>
        <nav class="nav-menu" id="navMenu">
            <ul class="nav-links">
                <li><a href="./index.php" class="nav-link">Home</a></li>
                <li><a href="./index.php#about" class="nav-link">About</a></li>
                <li><a href="./index.php#contact" class="nav-link">Contact</a></li>
                <li><a href="./food.php" class="nav-link active">Food</a></li>
            </ul>
        </nav>
        <div class="nav-actions">
            <div class="auth-buttons">
                <?php if (isset($_SESSION['status']) && $_SESSION['status'] === true): ?>
                    <span style="font-weight:600; margin-right:10px;">
                        Hi, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!
                    </span>
                    <a href="./controller/logout.php" class="btn btn-outline">Logout</a>
                <?php else: ?>
                    <a href="./view/login.php" class="btn btn-text">Login</a>
                    <a href="./view/register.php" class="btn btn-dark">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

<section class="hero small-hero">
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        <h1>Cow Food Marketplace</h1>
        <p>Buy quality cow food directly from verified sellers.</p>
    </div>
</section>

<section class="section featured">
    <div class="container">

        <div class="section-header">
            <h2>Available Cow Foods</h2>

            <?php if (isset($_SESSION['status'], $_SESSION['role']) && $_SESSION['status'] === true && $_SESSION['role'] === 'seller'): ?>
                <a href="./view/add_food.php" class="btn btn-primary">
                    <i class="ph ph-plus"></i> Add Food
                </a>
            <?php endif; ?>
        </div>

        <div class="listings-grid">

            <?php if (count($foods) === 0): ?>
                <p style="padding: 20px; background: #fff; border-radius: 12px;">No food items found.</p>
            <?php endif; ?>

            <?php foreach ($foods as $food): ?>
                <article class="cow-card">
                    <div class="card-image">
                        <span class="tag-price">$<?php echo (int)$food['price']; ?></span>
                        <img src="upload/<?php echo htmlspecialchars($food['image']); ?>"
                             alt="<?php echo htmlspecialchars($food['name']); ?>"
                             style="width:100%; height:200px; object-fit:cover;"
                             onerror="this.src='https://via.placeholder.com/400x200?text=No+Image';">
                    </div>

                    <div class="card-body">
                        <h3><?php echo htmlspecialchars($food['name']); ?></h3>
                        <p class="location">
                            <i class="ph ph-package"></i> Packets: <?php echo (int)$food['quantity']; ?>
                        </p>

                        <?php if (isset($_SESSION['status'], $_SESSION['role']) && $_SESSION['status'] === true): ?>

                            <?php if ($_SESSION['role'] === 'seller'): ?>
                                <!-- Seller food deletion disabled -->
                                <button class="btn btn-sm btn-outline" disabled>Deletion disabled</button>

                            <?php elseif ($_SESSION['role'] === 'buyer'): ?>
                                <button class="btn btn-sm btn-primary" onclick="buyNow()">Buy Now</button>
                            <?php endif; ?>

                        <?php else: ?>
                            <button class="btn btn-sm btn-primary" onclick="window.location.href='./view/login.php'">Buy Now</button>
                        <?php endif; ?>

                    </div>
                </article>
            <?php endforeach; ?>

        </div>
    </div>
</section>

<?php include "./view/footer.php"; ?>

<script>
function buyNow() {
    alert("Order Done!");
}
</script>
<script src="./Asset/Js/script.js"></script>
</body>
</html>
