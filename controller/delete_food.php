<?php
session_start();

// ✅ Only Admin can delete foods (Seller deletion is disabled)
$isAdmin = false;
if (isset($_SESSION['status']) && $_SESSION['status'] === true) {
    if (isset($_SESSION['role']) && strtolower((string)$_SESSION['role']) === 'admin') {
        $isAdmin = true;
    }
    if (isset($_SESSION['user_type']) && strtolower((string)$_SESSION['user_type']) === 'admin') {
        $isAdmin = true;
    }
}

if (!$isAdmin) {
    header("Location: ../food.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['food_id'])) {
    header("Location: ../food.php");
    exit();
}

$food_id = (int)$_POST['food_id'];

require_once __DIR__ . '/../model/DataBase.php';
// Ensure table exists
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

// Find image
$stmt = $conn->prepare("SELECT image FROM cow_foods WHERE id=?");
$stmt->bind_param("i", $food_id);
$stmt->execute();
$stmt->bind_result($image);
$found = $stmt->fetch();
$stmt->close();

if ($found && $image && file_exists(__DIR__ . "/../upload/" . $image)) {
    @unlink(__DIR__ . "/../upload/" . $image);
}

// Delete record
$stmt = $conn->prepare("DELETE FROM cow_foods WHERE id=?");
$stmt->bind_param("i", $food_id);
$stmt->execute();
$stmt->close();



// If deletion came from admin panel, they can pass redirect=admin
if (isset($_POST['redirect']) && $_POST['redirect'] === 'admin') {
    header("Location: ../admin/foods.php");
    exit();
}

header("Location: ../food.php");
exit();

?>
