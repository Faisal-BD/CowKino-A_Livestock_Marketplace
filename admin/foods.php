<?php
require_once 'auth.php';
require_once '../model/foods.php';

$msg = "";

if (isset($_POST['action']) && $_POST['action'] === 'delete') {
    AdminDeleteFood($_POST['id'] ?? 0);
    $msg = "Food deleted.";
}

$foods = AdminGetFoods();
?>
<?php include 'layout/header.php'; ?>
<div class="app">
  <?php include 'layout/sidebar.php'; ?>

  <div class="main">
    <div class="topbar">
      <h1>Cow Foods</h1>
      <div class="badge">Admin: <?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin') ?></div>
    </div>

    <?php if (!empty($msg)): ?>
      <div class="notice"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <div class="table-wrap">
      <table id="foodsTable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Seller</th>
            <th>Created</th>
            <th>Image</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($foods as $f): ?>
            <tr>
              <td><?= (int)$f['id'] ?></td>
              <td><?= htmlspecialchars($f['name']) ?></td>
              <td><?= htmlspecialchars((string)$f['price']) ?></td>
              <td><?= htmlspecialchars((string)$f['quantity']) ?></td>
              <td>
                <?= htmlspecialchars($f['seller_name'] ?? 'Unknown') ?>
                <?php if (!empty($f['seller_email'])): ?>
                  <div style="font-size:12px; opacity:.7;">(<?= htmlspecialchars($f['seller_email']) ?>)</div>
                <?php endif; ?>
              </td>
              <td><?= htmlspecialchars((string)$f['created_at']) ?></td>
              <td>
                <?php if (!empty($f['image'])): ?>
                  <a class="btn btn-ghost" target="_blank" href="../upload/<?= htmlspecialchars($f['image']) ?>">View</a>
                <?php endif; ?>
              </td>
              <td>
                <div class="actions">
                  <form method="POST" style="margin:0;" onsubmit="return confirm('Delete this food item?');">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= (int)$f['id'] ?>">
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

<script>
  // Simple search filter for admin table
  (function(){
    const table = document.getElementById('foodsTable');
    if (!table) return;

    const wrapper = table.closest('.table-wrap');
    if (!wrapper) return;

    const input = document.createElement('input');
    input.type = 'text';
    input.placeholder = 'Search foods...';
    input.style.width = '100%';
    input.style.maxWidth = '360px';
    input.style.padding = '10px 12px';
    input.style.margin = '0 0 12px 0';
    input.style.border = '1px solid rgba(17,24,39,.15)';
    input.style.borderRadius = '12px';

    wrapper.parentElement.insertBefore(input, wrapper);

    input.addEventListener('keyup', function(){
      const q = this.value.toLowerCase();
      const rows = table.querySelectorAll('tbody tr');
      rows.forEach(tr => {
        const text = tr.innerText.toLowerCase();
        tr.style.display = text.includes(q) ? '' : 'none';
      });
    });
  })();
</script>

<?php include 'layout/footer.php'; ?>
