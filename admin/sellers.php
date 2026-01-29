<?php
require_once 'auth.php';
require_once '../model/admin.php';

$msg = "";

// Handle actions
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'ban') {
        AdminSetUserBanned($_POST['id'], 1);
        $msg = "User banned.";
    }

    if ($action === 'unban') {
        AdminSetUserBanned($_POST['id'], 0);
        $msg = "User unbanned.";
    }

    if ($action === 'delete') {
        AdminDeleteUser($_POST['id']);
        $msg = "User deleted.";
    }
}

$users = AdminGetUsersByType('seller');
?>
<?php include 'layout/header.php'; ?>
<div class="app">
  <?php include 'layout/sidebar.php'; ?>

  <div class="main">
    <div class="topbar">
      <h1>Seller List</h1>
      <div class="badge">Admin: <?= htmlspecialchars($_SESSION['user_name']) ?></div>
    </div>

    <?php if (!empty($msg)): ?>
      <div class="notice"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Banned</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $u): ?>
          <tr>
            <td><?= (int)$u['id'] ?></td>
            <td><?= htmlspecialchars($u['name']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td><?= htmlspecialchars((string)$u['phone']) ?></td>
            <td><?= ((int)$u['is_banned'] === 1) ? 'Yes' : 'No' ?></td>
            <td>
              <div class="actions">
                <?php if ((int)$u['is_banned'] === 1): ?>
                  <form method="POST" style="margin:0;">
                    <input type="hidden" name="action" value="unban">
                    <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
                    <button class="btn btn-ghost" type="submit">Unban</button>
                  </form>
                <?php else: ?>
                  <form method="POST" style="margin:0;">
                    <input type="hidden" name="action" value="ban">
                    <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
                    <button class="btn btn-danger" type="submit">Ban</button>
                  </form>
                <?php endif; ?>

                <form method="POST" style="margin:0;" onsubmit="return confirm('Delete this seller permanently? This will also remove their cow food items.');">
                  <input type="hidden" name="action" value="delete">
                  <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
                  <button class="btn btn-outline" type="submit">Delete</button>
                </form>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>

  </div>
</div>
<?php include 'layout/footer.php'; ?>
