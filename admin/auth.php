<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$timeout = 600;

if (isset($_SESSION['LAST_ACTIVITY'])) {
    if (time() - $_SESSION['LAST_ACTIVITY'] > $timeout) {
        session_unset();
        session_destroy();
        header("location: ../view/login.php?msg=Session expired");
        exit();
    }
}


if (!isset($_SESSION['status']) || $_SESSION['status'] !== true) {
    header("location: ../view/login.php");
    exit();
}

if (!isset($_SESSION['user_type']) || strtolower($_SESSION['user_type']) !== 'admin') {
    header("location: ../index.php");
    exit();
}

$_SESSION['LAST_ACTIVITY'] = time();
?>
