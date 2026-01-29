<?php
// controller/submit_delivery.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../model/DataBase.php';

// Ensure client cookie exists
if (!isset($_COOKIE['cowkino_client_id'])) {
  $newId = bin2hex(random_bytes(16));
  setcookie('cowkino_client_id', $newId, time() + (86400 * 365), "/");
  $_COOKIE['cowkino_client_id'] = $newId;
}
$clientId = $_COOKIE['cowkino_client_id'];

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  header("Location: ../view/cow_delivery.php");
  exit();
}

// Collect inputs
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$contact = trim($_POST['contact'] ?? '');
$pickup = trim($_POST['pickup_location'] ?? '');
$dropoff = trim($_POST['dropoff_location'] ?? '');
$distanceKm = (float)($_POST['distance_km'] ?? 0);
$cowCount = (int)($_POST['cow_count'] ?? 0);

// Validation
if ($name === '' || $email === '' || $contact === '' || $pickup === '' || $dropoff === '' || $distanceKm <= 0 || $cowCount <= 0) {
  header("Location: ../view/cow_delivery.php?status=invalid");
  exit();
}

// Calculate delivery charge
$BASE = 100;
$deliveryCharge = $BASE + (100 * $distanceKm) + (50 * $cowCount);


// Prepared insert
$stmt = $conn->prepare(
  "INSERT INTO cow_delivery
   (client_id, name, email, contact, pickup_location, dropoff_location, distance_km, cow_count, delivery_charge)
   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
);

if (!$stmt) {
  // If prepare fails, show error (for debugging)
  die("Prepare failed: " . $conn->error);
}

$stmt->bind_param(
  "ssssssdid",
  $clientId,
  $name,
  $email,
  $contact,
  $pickup,
  $dropoff,
  $distanceKm,
  $cowCount,
  $deliveryCharge
);

if (!$stmt->execute()) {
  // If execute fails, show error (for debugging)
  die("Execute failed: " . $stmt->error);
}

$stmt->close();

header("Location: ../view/cow_delivery.php?status=success");
exit();
