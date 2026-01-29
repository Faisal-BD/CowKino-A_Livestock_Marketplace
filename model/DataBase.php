<?php
// Centralized MySQL connection
$server = "127.0.0.1";
$user = "root";
$password = "";
$database = "cow_kino";

// Throw exceptions for MySQLi errors (helps catch issues early)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conn = mysqli_connect($server, $user, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Use UTF-8 everywhere
mysqli_set_charset($conn, "utf8mb4");
?>