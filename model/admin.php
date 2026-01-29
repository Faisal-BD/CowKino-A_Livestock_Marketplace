<?php
require_once __DIR__ . '/DataBase.php';

function AdminCounts()
{
    global $conn;

    $totalUsers   = (int)mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM users"))['c'];
    $totalBuyers  = (int)mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM users WHERE user_type='buyer'"))['c'];
    $totalSellers = (int)mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM users WHERE user_type='seller'"))['c'];
    $totalAdmins  = (int)mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM users WHERE user_type='admin'"))['c'];

    $totalCows    = (int)mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM cows"))['c'];
    $approvedCows = (int)mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM cows WHERE is_approved=1"))['c'];
    $pendingCows  = (int)mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM cows WHERE is_approved=0"))['c'];

    return [
        'totalUsers'    => $totalUsers,
        'totalBuyers'   => $totalBuyers,
        'totalSellers'  => $totalSellers,
        'totalAdmins'   => $totalAdmins,
        'totalCows'     => $totalCows,
        'approvedCows'  => $approvedCows,
        'pendingCows'   => $pendingCows,
    ];
}

function AdminGetUsers()
{
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");

    $users = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
    return $users;
}

// Get only users of a specific type (buyer/seller/admin)
function AdminGetUsersByType($type)
{
    global $conn;

    $type = strtolower(trim((string)$type));
    $allowed = ['buyer', 'seller', 'admin'];
    if (!in_array($type, $allowed, true)) {
        return [];
    }

    $sql = "SELECT * FROM users WHERE user_type = ? ORDER BY id DESC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $type);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $users = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
    mysqli_stmt_close($stmt);

    return $users;
}

function AdminUpdateUserType($id, $type)
{
    global $conn;

    $id = (int)$id;
    $type = strtolower(trim((string)$type));
    $allowed = ['buyer', 'seller', 'admin'];
    if (!in_array($type, $allowed, true)) {
        return false;
    }

    $sql = "UPDATE users SET user_type = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $type, $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $ok ? true : false;
}

function AdminSetUserBanned($id, $is_banned)
{
    global $conn;

    $id = (int)$id;
    $is_banned = (int)$is_banned;

    $sql = "UPDATE users SET is_banned = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $is_banned, $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $ok ? true : false;
}

// Delete a user and clean up related rows/files where possible
function AdminDeleteUser($id)
{
    global $conn;
    $id = (int)$id;

    // Get user info (email + type) for cleanup
    $stmt = mysqli_prepare($conn, "SELECT email, user_type FROM users WHERE id = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $row = $res ? mysqli_fetch_assoc($res) : null;
    mysqli_stmt_close($stmt);

    if (!$row) {
        return false;
    }

    $email = (string)$row['email'];
    $type  = strtolower(trim((string)$row['user_type']));

    // If seller, delete their cow foods + images
    if ($type === 'seller') {
        $stmt = mysqli_prepare($conn, "SELECT image FROM cow_foods WHERE seller_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $foods = mysqli_stmt_get_result($stmt);

        if ($foods) {
            while ($f = mysqli_fetch_assoc($foods)) {
                if (!empty($f['image'])) {
                    $path = dirname(__DIR__) . '/upload/' . $f['image'];
                    if (file_exists($path)) {
                        @unlink($path);
                    }
                }
            }
        }
        mysqli_stmt_close($stmt);

        $stmt = mysqli_prepare($conn, "DELETE FROM cow_foods WHERE seller_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $stmt = mysqli_prepare($conn, "DELETE FROM seller WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // If buyer, cleanup buyer rows by email
    if ($type === 'buyer') {
        $stmt = mysqli_prepare($conn, "DELETE FROM buyer WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // Finally delete user
    $stmt = mysqli_prepare($conn, "DELETE FROM users WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $ok ? true : false;
}

function AdminGetCows()
{
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM cows ORDER BY id DESC");

    $cows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $cows[] = $row;
    }
    return $cows;
}

function AdminSetCowApproved($id, $is_approved)
{
    global $conn;
    $id = (int)$id;
    $is_approved = (int)$is_approved;

    $sql = "UPDATE cows SET is_approved = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $is_approved, $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $ok ? true : false;
}

function AdminDeleteCow($id)
{
    global $conn;
    $id = (int)$id;

    // delete photo file (if any)
    $stmt = mysqli_prepare($conn, "SELECT photo_url FROM cows WHERE id = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $row = $res ? mysqli_fetch_assoc($res) : null;
    mysqli_stmt_close($stmt);

    if ($row && !empty($row['photo_url'])) {
        $path = dirname(__DIR__) . '/upload/' . $row['photo_url'];
        if (file_exists($path)) {
            @unlink($path);
        }
    }

    $stmt = mysqli_prepare($conn, "DELETE FROM cows WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $ok ? true : false;
}
