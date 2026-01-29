<?php
require_once 'auth.php';
require_once '../model/admin.php';

$msg = "";

// Actions
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'approve') {
        AdminSetCowApproved($_POST['id'], 1);
        $msg = "Cow approved.";
    }
    if ($action === 'unapprove') {
        AdminSetCowApproved($_POST['id'], 0);
        $msg = "Cow moved to pending.";
    }
    if ($action === 'delete') {
        AdminDeleteCow($_POST['id']);
        $msg = "Cow deleted.";
    }
}

$cows = AdminGetCows();
?>
<?php include 'layout/header.php'; ?>
<div class="app">
  <?php include 'layout/sidebar.php'; ?>

  <div class="main">
    <div class="topbar">
      <h1>Cows</h1>
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
            <th>Breed</th>
            <th>Price</th>
            <th>Age</th>
            <th>Weight</th>
            <th>Approved</th>
            <th>Photo</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($cows as $c): ?>
          <tr>
            <td><?= (int)$c['id'] ?></td>
            <td><?= htmlspecialchars($c['name']) ?></td>
            <td><?= htmlspecialchars($c['breed']) ?></td>
            <td><?= htmlspecialchars((string)$c['price']) ?></td>
            <td><?= htmlspecialchars((string)$c['age']) ?></td>
            <td><?= htmlspecialchars((string)$c['weight']) ?></td>
            <td><?= ((int)$c['is_approved'] === 1) ? 'Yes' : 'No' ?></td>
            <td>
              <?php if (!empty($c['photo_url'])): ?>
                <a class="btn btn-ghost" target="_blank" href="../upload/<?= htmlspecialchars($c['photo_url']) ?>">View</a>
              <?php endif; ?>
            </td>
            <td>
              <div class="actions">

                <?php if ((int)$c['is_approved'] === 1): ?>
                  <form method="POST" style="margin:0;">
                    <input type="hidden" name="action" value="unapprove">
                    <input type="hidden" name="id" value="<?= (int)$c['id'] ?>">
                    <button class="btn btn-ghost" type="submit">Unapprove</button>
                  </form>
                <?php else: ?>
                  <form method="POST" style="margin:0;">
                    <input type="hidden" name="action" value="approve">
                    <input type="hidden" name="id" value="<?= (int)$c['id'] ?>">
                    <button class="btn btn-primary" type="submit">Approve</button>
                  </form>
                <?php endif; ?>

                <form method="POST" style="margin:0;" onsubmit="return confirm('Delete this cow listing?');">
                  <input type="hidden" name="action" value="delete">
                  <input type="hidden" name="id" value="<?= (int)$c['id'] ?>">
                  <button class="btn btn-danger" type="submit">Delete</button>
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
