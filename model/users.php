<?php
require_once __DIR__ . '/DataBase.php';

/**
 * Insert a new user.
 * - Uses prepared statements (prevents SQL injection)
 * - Hashes passwords using password_hash()
 */
function InsertUser($fullName, $pass, $email, $phone, $user_type)
{
    global $conn;

    // Check email exists
    $checkSql = "SELECT 1 FROM users WHERE email = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $checkSql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_close($stmt);
        return "email_exists";
    }
    mysqli_stmt_close($stmt);

    // Hash password (bcrypt by default)
    $hashed = password_hash($pass, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password, phone, user_type, is_banned)
            VALUES (?, ?, ?, ?, ?, 0)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $fullName, $email, $hashed, $phone, $user_type);

    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $ok ? true : false;
}

/**
 * Login:
 * - Fetches password hash and verifies using password_verify()
 * - Blocks banned users
 */
function Login($email, $pass)
{
    global $conn;

    $sql = "SELECT id, name, email, user_type, password, is_banned
            FROM users
            WHERE email = ?
            LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result || mysqli_num_rows($result) === 0) {
        mysqli_stmt_close($stmt);
        return false;
    }

    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if ((int)$row['is_banned'] === 1) {
        return false;
    }

    // Verify password
    if (!password_verify($pass, $row['password'])) {
        return false;
    }

    // Return only safe fields
    return [
        'id' => $row['id'],
        'name' => $row['name'],
        'email' => $row['email'],
        'user_type' => $row['user_type']
    ];
}
