<?php
require_once 'auth.php';
require_once '../model/admin.php';

$counts = AdminCounts();
?>
<?php include 'layout/header.php'; ?>
<div class="app">
  <?php include 'layout/sidebar.php'; ?>

  <div class="main">
    <div class="topbar">
      <h1>Dashboard</h1>
      <div class="badge">Logged in as: <?= htmlspecialchars($_SESSION['user_name']) ?></div>
    </div>

    <div class="grid">
      <div class="card">
        <h4>Total Users</h4>
        <div class="value"><?= $counts['totalUsers'] ?></div>
      </div>
      <div class="card">
        <h4>Sellers</h4>
        <div class="value"><?= $counts['totalSellers'] ?></div>
      </div>
      <div class="card">
        <h4>Buyers</h4>
        <div class="value"><?= $counts['totalBuyers'] ?></div>
      </div>

      <div class="card">
        <h4>Total Cows</h4>
        <div class="value"><?= $counts['totalCows'] ?></div>
      </div>
      <div class="card">
        <h4>Approved Cows</h4>
        <div class="value"><?= $counts['approvedCows'] ?></div>
      </div>
      <div class="card">
        <h4>Pending Cows</h4>
        <div class="value"><?= $counts['pendingCows'] ?></div>
      </div>
    </div>

    <div class="notice" style="margin-top:14px;">
      New cows submitted from “Sell” are hidden until you approve them in <b>Cows</b>.
    </div>
  </div>
</div>
<?php include 'layout/footer.php'; ?>
