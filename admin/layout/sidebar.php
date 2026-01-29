<?php
$current = basename($_SERVER['PHP_SELF']);
function active($file, $current) {
    return $file === $current ? 'active' : '';
}
?>
<div class="sidebar">
  <div class="brand">
    <div class="logo">CK</div>
    <div>
      <h3>CowKino Admin</h3>
      <p>Manage users & cows</p>
    </div>
  </div>

  <div class="sidebar-inner">
    <div class="nav">
      <a class="<?= active('dashboard.php', $current) ?>" href="dashboard.php">
        Dashboard <span>›</span>
      </a>
      <a class="<?= active('buyers.php', $current) ?>" href="buyers.php">
        Buyer List <span>›</span>
      </a>
      <a class="<?= active('sellers.php', $current) ?>" href="sellers.php">
        Seller List <span>›</span>
      </a>
      <a class="<?= active('cows.php', $current) ?>" href="cows.php">
        Cows <span>›</span>
      </a>
      <a class="<?= active('foods.php', $current) ?>" href="foods.php">
        Cow Foods <span>›</span>
      </a>
    </div>

    <!-- Logout pinned at the bottom (red button) -->
    <div class="logout-wrap">
      <a class="logout-btn" href="../controller/logout.php">Logout</a>
    </div>
  </div>
</div>
