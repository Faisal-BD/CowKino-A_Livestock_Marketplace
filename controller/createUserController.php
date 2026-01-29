<?php
session_start();
require_once '../model/DataBase.php';
require_once '../model/users.php';

if (isset($_POST['submit'])) {

    $fullname = trim($_POST['fullname']);
    $email = strtolower(trim($_POST['email']));
    $phone = trim($_POST['phone']);
    $user_type = trim($_POST['user_type']); // ✅ NEW
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($fullname) || empty($email) || empty($phone) || empty($user_type) || empty($password)) {
        $_SESSION['error_msg'] = "All fields are required!";
        header('location: ../view/register.php');
        exit;
    }

    // Optional strict validation (prevents random values)
    $allowed_types = ['buyer', 'seller'];
    if (!in_array($user_type, $allowed_types, true)) {
        $_SESSION['error_msg'] = "Invalid user type selected!";
        header('location: ../view/register.php');
        exit;
    }

    if (strlen($password) < 6) {
        $_SESSION['error_msg'] = "Password must be at least 6 characters.";
        header('location: ../view/register.php');
        exit;
    }

    if ($password !== $confirm_password) {
        $_SESSION['error_msg'] = "Passwords do not match!";
        header('location: ../view/register.php');
        exit;
    }

    // ✅ PASS user_type into model
    $status = InsertUser($fullname, $password, $email, $phone, $user_type);

    if ($status === true) {
        $_SESSION['success_msg'] = "Account created successfully! Please login.";
        header('location: ../view/login.php');
        exit;
    } elseif ($status === "email_exists") {
        $_SESSION['error_msg'] = "This email is already registered!";
        header('location: ../view/register.php');
        exit;
    } else {
        $_SESSION['error_msg'] = "System error. Could not create account.";
        header('location: ../view/register.php');
        exit;
    }
} else {
    header('location: ../view/register.php');
    exit;
}
