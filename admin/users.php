<?php
require_once 'auth.php';
require_once '../model/admin.php';

$msg = "";

// Handle actions
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'role') {
        $id = $_POST['id'];
        $type = $_POST['user_type'];
        $allowed = ['buyer','seller','admin'];

        if (in_array($type, $allowed, true)) {
            AdminUpdateUserType($id, $type);
            $msg = "User role updated.";
        }
    }

    if ($action === 'ban') {
        AdminSetUserBanned($_POST['id'], 1);
        $msg = "User banned.";
    }

    if ($action === 'unban') {
        AdminSetUserBanned($_POST['id'], 0);
        $msg = "User unbanned.";
    }
}

$users = AdminGetUsers();
?>
<?php include 'layout/header.php'; ?>
<div class="app">
  <?php include 'layout/sidebar.php'; ?>

  <div class="main">
    <div class="topbar">
      <h1>Users</h1>
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
            <th>Role</th>
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
            <td>
              <form method="POST" style="margin:0;">
                <input type="hidden" name="action" value="role">
                <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
                <select name="user_type" onchange="this.form.submit()">
                  <?php
                    $roles = ['buyer'=>'Buyer','seller'=>'Seller','admin'=>'Admin'];
                    foreach ($roles as $k=>$label):
                  ?>
                    <option value="<?= $k ?>" <?= strtolower($u['user_type'])===$k?'selected':'' ?>>
                      <?= $label ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </form>
            </td>
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
