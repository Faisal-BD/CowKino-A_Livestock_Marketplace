<?php
session_start();
require_once '../model/users.php';

if (!isset($_POST['submit'])) {
    header('location: ../view/login.php');
    exit();
}

function sanitize($data) {
    return trim((string)$data);
}

$email    = strtolower(sanitize($_POST['email'] ?? ''));
$password = trim((string)($_POST['password'] ?? ''));
if (empty($email) || empty($password)) {
    $_SESSION['error_msg'] = "Please enter both email and password.";
    header('location: ../view/login.php');
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error_msg'] = "Invalid email format.";
    header('location: ../view/login.php');
    exit();
}

$user = Login($email, $password);

if ($user === false) {
    $_SESSION['error_msg'] = "Invalid email/password OR your account is banned.";
    header('location: ../view/login.php');
    exit();
}

$_SESSION['status']    = true;
$_SESSION['user_id']   = $user['id'];
$_SESSION['user_name'] = $user['name'];
$_SESSION['user_type'] = $user['user_type'];
$_SESSION['role']      = strtolower($user['user_type']);

if ($_SESSION['role'] === 'admin') {
    header('location: ../admin/dashboard.php');
    exit();
}

$redirect = $_GET['redirect'] ?? '';

if ($redirect !== '') {
    if (strpos($redirect, 'http') === 0 || strpos($redirect, '//') === 0) {
        $redirect = '';
    }
}

if ($redirect !== '') {
    header('location: ../' . ltrim($redirect, '/'));
    exit();
}

header('location: ../index.php');
exit();
?>
