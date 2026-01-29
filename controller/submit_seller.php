<?php
// controller/submit_seller.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../model/DataBase.php'; // creates $conn

// If someone opens this file directly (GET), send them back
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /Cowkino/view/query.php");
    exit();
}

// Collect inputs
$email = trim($_POST['email'] ?? '');
$questions = $_POST['questions'] ?? [];
$extra_details = trim($_POST['extra_details'] ?? '');

// Validate email
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: /Cowkino/view/query.php?status=invalid");
    exit();
}

// If you want to allow submitting without selecting any checkbox, remove this block.
if (!is_array($questions) || count($questions) === 0) {
    header("Location: /Cowkino/view/query.php?status=invalid");
    exit();
}

$selected_questions = implode(", ", $questions);

// Insert safely
$stmt = $conn->prepare("INSERT INTO seller (email, selected_questions, extra_details) VALUES (?, ?, ?)");
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
