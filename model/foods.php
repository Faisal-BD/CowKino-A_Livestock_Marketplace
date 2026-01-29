<?php
require_once __DIR__ . '/DataBase.php';

function EnsureFoodsTable()
{
    global $conn;
    $sql = "CREATE TABLE IF NOT EXISTS `cow_foods` (
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

    mysqli_query($conn, $sql);
}

function AdminGetFoods()
{
    global $conn;
    EnsureFoodsTable();

    $foods = [];
    $query = "SELECT f.id, f.name, f.price, f.quantity, f.image, f.seller_id, f.created_at,
                     u.name AS seller_name, u.email AS seller_email
              FROM cow_foods f
              LEFT JOIN users u ON u.id = f.seller_id
              ORDER BY f.id DESC";

    $res = mysqli_query($conn, $query);
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $foods[] = $row;
        }
    }

    return $foods;
}

function AdminDeleteFood($foodId)
{
    global $conn;
    EnsureFoodsTable();

    $foodId = (int)$foodId;

    // Get image first
    $img = null;
    $stmt = mysqli_prepare($conn, "SELECT image FROM cow_foods WHERE id=?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $foodId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $img);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }

    // Delete record
    $stmt = mysqli_prepare($conn, "DELETE FROM cow_foods WHERE id=?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $foodId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // Delete image file (best-effort)
    if (!empty($img)) {
        $path = __DIR__ . '/../upload/' . $img;
        if (file_exists($path)) {
            @unlink($path);
        }
    }

    return true;
}

?>
