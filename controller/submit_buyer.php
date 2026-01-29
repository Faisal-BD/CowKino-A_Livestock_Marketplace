<?php
// controller/submit_buyer.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../model/DataBase.php'; // creates $conn

// If someone opens this file directly in browser (GET), send them back
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /Cowkino/view/query.php");
    exit();
}

// Optional cookie (not used in DB because your buyer table has no client_id column)
if (!isset($_COOKIE['cowkino_client_id'])) {
    $newId = bin2hex(random_bytes(16));
    setcookie('cowkino_client_id', $newId, time() + (86400 * 365), "/");
    $_COOKIE['cowkino_client_id'] = $newId;
}

// Collect inputs
$email = trim($_POST['email'] ?? '');
$questions = $_POST['questions'] ?? [];
$extra_details = trim($_POST['extra_details'] ?? '');

// Basic validation
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: /Cowkino/view/query.php?status=invalid");
    exit();
}

if (!is_array($questions) || count($questions) === 0) {
    // You can allow empty questions if you want, but usually it's required
    header("Location: /Cowkino/view/query.php?status=invalid");
    exit();
}

$selected_questions = implode(", ", $questions);

// Insert using prepared statement (safe)
$stmt = $conn->prepare("INSERT INTO buyer (email, selected_questions, extra_details) VALUES (?, ?, ?)");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("sss", $email, $selected_questions, $extra_details);

if ($stmt->execute()) {
    $stmt->close();
    header("Location: /Cowkino/view/query.php?status=success");
    exit();
} else {
    $err = $stmt->error;
    $stmt->close();
    die("DB Insert failed: " . $err);
}
?>
