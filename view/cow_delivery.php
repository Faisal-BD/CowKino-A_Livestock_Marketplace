<?php
// view/cow_delivery.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../model/DataBase.php';

// 1) Make a unique client id per browser (cookie)
if (!isset($_COOKIE['cowkino_client_id'])) {
  $newId = bin2hex(random_bytes(16));
  setcookie('cowkino_client_id', $newId, time() + (86400 * 365), "/");
  $_COOKIE['cowkino_client_id'] = $newId;
}
$clientId = $_COOKIE['cowkino_client_id'];

// 2) Fetch delivery history for THIS client only
$history = [];
$stmt = $conn->prepare("SELECT pickup_location, dropoff_location, distance_km, cow_count, delivery_charge, created_at
                        FROM cow_delivery
                        WHERE client_id = ?
                        ORDER BY id DESC");
$stmt->bind_param("s", $clientId);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
  $history[] = $row;
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>COWkino — Cow Delivery</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    :root{
      /* WHITE THEME */
      --bg: #f5f7f5;
      --card: #ffffff;

      /* TEXT */
      --text: #0f172a;
      --muted: rgba(15,23,42,0.65);

      /* GREEN THEME */
      --accent: #16a34a;
      --accentBorder: rgba(22,163,74,0.35);

      /* UI */
      --stroke: rgba(15,23,42,0.12);
      --shadow: 0 12px 28px rgba(15,23,42,.10);
      --radius: 18px;
    }

    *{ margin:0; padding:0; box-sizing:border-box; }
    html,body{ height:100%; }

    body{
      font-family: "Poppins", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
      background: radial-gradient(900px 500px at 20% 10%, rgba(22,163,74,0.12), transparent 60%),
                  radial-gradient(700px 400px at 80% 20%, rgba(34,197,94,0.10), transparent 55%),
                  var(--bg);
      color: var(--text);

      /* Footer stick to bottom */
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .navbar{
      position: sticky;
      top: 0;
      z-index: 999;
      display:flex;
      align-items:center;
      justify-content: space-between;
      gap: 16px;
      padding: 14px 20px;
      background: rgba(255,255,255,0.75);
      backdrop-filter: blur(14px);
      border-bottom: 1px solid var(--stroke);
    }

    .logo{
      font-weight: 800;
      letter-spacing: 1px;
      font-size: 20px;
      color: #0b1220;
    }
    .logo::after{
      content:"";
      display:inline-block;
      width: 8px;
      height: 8px;
      border-radius: 999px;
      background: var(--accent);
      margin-left: 8px;
      box-shadow: 0 0 0 4px rgba(22,163,74,0.12);
    }

    .nav-actions{
      display:flex;
      align-items:center;
      gap: 10px;
      flex-wrap: wrap;
    }

    .btn-outline{
      padding: 10px 14px;
      background: transparent;
      border: 1px solid rgba(22,163,74,0.45);
      color: #0b1220;
      cursor: pointer;
      font-weight: 700;
      border-radius: 999px;
      transition: transform .15s ease, box-shadow .2s ease, background .2s ease, border-color .2s ease;
    }
    .btn-outline:hover{
      transform: translateY(-1px);
      background: rgba(22,163,74,0.08);
      box-shadow: var(--shadow);
      border-color: rgba(22,163,74,0.75);
    }

    .container{
      max-width: 980px;
      margin: 0 auto;
      padding: 0 14px;
    }

    /* MAIN AREA */
    .market{
      flex: 1;               /* pushes footer down */
      padding: 38px 0 60px;
    }

    .market h2{
      text-align:center;
      font-size: 28px;
      margin-bottom: 18px;
      color: #0b1220;
    }
    .market h2::after{
      content:"";
      display:block;
      width: 90px;
      height: 3px;
      margin: 10px auto 0;
      border-radius: 999px;
      background: linear-gradient(90deg, transparent, rgba(22,163,74,0.9), transparent);
    }

    .cow-card{
      background: var(--card);
      border: 1px solid rgba(22,163,74,0.28);
      border-radius: var(--radius);
      padding: 16px;
      box-shadow: var(--shadow);
    }

    .muted{
      color: var(--muted);
      font-size: 14px;
      margin-top: 6px;
    }

    .label{
      display:block;
      font-size: 13px;
      color: var(--muted);
      margin: 10px 0 6px;
    }

    input{
      width: 100%;
      padding: 12px 12px;
      border-radius: 12px;
      border: 1px solid var(--stroke);
      background: #ffffff;
      color: #0b1220;
      outline:none;
      transition: .2s ease;
      font-family: inherit;
    }
    input:focus{
      border-color: rgba(22,163,74,0.75);
      box-shadow: 0 0 0 4px rgba(22,163,74,0.15);
    }

    .grid{
      display:grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
    }
    @media (max-width: 720px){
      .grid{ grid-template-columns: 1fr; }
    }

    .submit-btn{
      margin-top: 14px;
      width: 100%;
      padding: 12px 14px;
      border-radius: 999px;
      border: none;
      cursor: pointer;
      font-weight: 800;
      background: linear-gradient(135deg, #16a34a, #22c55e);
      color: #ffffff;
      box-shadow: 0 10px 22px rgba(22,163,74,0.25);
      transition: transform .15s ease, box-shadow .2s ease;
    }
    .submit-btn:hover{
      transform: translateY(-1px);
      box-shadow: 0 14px 28px rgba(22,163,74,0.28);
    }

    /* Styled popup */
    .toast{
      margin-top: 12px;
      padding: 12px 14px;
      border-radius: 14px;
      border: 1px solid rgba(22,163,74,0.40);
      background: rgba(22,163,74,0.10);
      color: #065f46;
      display:none;
    }
    .toast.show{ display:block; }

    /* History */
    .history{
      margin-top: 18px;
      margin-bottom: 20px;
    }
    table{
      width:100%;
      border-collapse: collapse;
      overflow:hidden;
      border-radius: 14px;
      border: 1px solid var(--stroke);
      background: #ffffff;
      margin-top: 10px;
    }
    th, td{
      padding: 10px 10px;
      border-bottom: 1px solid rgba(15,23,42,0.08);
      text-align: left;
      font-size: 14px;
      color: rgba(15,23,42,0.92);
      vertical-align: top;
    }
    th{
      color: rgba(15,23,42,0.70);
      font-weight: 800;
      background: rgba(15,23,42,0.03);
    }
    tr:last-child td{ border-bottom: none; }

    /* Footer */
    .footer{
      margin-top: 28px;
      border-top: 1px solid var(--stroke);
      padding: 18px;
      text-align:center;
      color: rgba(15,23,42,0.65);
      background: #ffffff;  /* solid to avoid blending */
    }
  </style>
</head>

<body>
  <nav class="navbar">
    <div class="logo">
       <a href="/Cowkino/index.php">COWkino</a>
    </div>
my query & cow delivary button
    <div class="nav-actions">
      <button class="btn-outline" type="button" onclick="goBack()">Back</button>
      <button class="btn-outline" id="resetBtn" type="button">Reset</button>
    </div>
  </nav>

  <section class="market">
    <div class="container">
      <h2>Cow Delivery</h2>

      <div class="cow-card">
        <h3>Delivery Form</h3>
        <p class="muted">Fill the details. Delivery charge is calculated automatically.</p>

        <div id="toast" class="toast">✅ Delivery duty submitted successfully.</div>

        <!-- view -> controller path -->
        <form id="deliveryForm" action="../controller/submit_delivery.php" method="POST" autocomplete="on">
          <div class="grid">
            <div>
              <label class="label" for="name">Name</label>
              <input id="name" name="name" required />
            </div>
            <div>
              <label class="label" for="email">Email</label>
              <input id="email" name="email" type="email" required />
            </div>
          </div>

          <div class="grid">
            <div>
              <label class="label" for="contact">Contact</label>
              <input id="contact" name="contact" required placeholder="01XXXXXXXXX" />
            </div>
            <div>
              <label class="label" for="cows">Number of cows</label>
              <input id="cows" name="cow_count" type="number" min="1" step="1" required />
            </div>
          </div>

          <label class="label" for="pickup">Pick-up location</label>
          <input id="pickup" name="pickup_location" required />

          <label class="label" for="dropoff">Drop-off location</label>
          <input id="dropoff" name="dropoff_location" required />

          <div class="grid">
            <div>
              <label class="label" for="distance">Distance (km)</label>
              <input id="distance" name="distance_km" type="number" min="0.01" step="0.01" required />
            </div>
            <div>
              <label class="label" for="charge">Delivery charge (BDT)</label>
              <input id="charge" name="delivery_charge" readonly value="0" />
            </div>
          </div>

          <button class="submit-btn" type="submit">Submit Delivery Duty</button>
        </form>
      </div>

      <div class="cow-card history">
        <h3>Delivery History</h3>
        <p class="muted">Only your orders from this browser/device are shown.</p>

        <?php if (count($history) === 0): ?>
          <p class="muted" style="margin-top:10px;">No deliveries yet.</p>
        <?php else: ?>
          <div style="overflow:auto;">
            <table>
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Pick-up → Drop-off</th>
                  <th>Distance</th>
                  <th>Cows</th>
                  <th>Charge</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($history as $h): ?>
                  <tr>
                    <td><?php echo htmlspecialchars($h['created_at']); ?></td>
                    <td>
                      <?php echo htmlspecialchars($h['pickup_location']); ?>
                      <span style="color:rgba(15,23,42,0.45)">→</span>
                      <?php echo htmlspecialchars($h['dropoff_location']); ?>
                    </td>
                    <td><?php echo htmlspecialchars($h['distance_km']); ?> km</td>
                    <td><?php echo htmlspecialchars($h['cow_count']); ?></td>
                    <td><?php echo htmlspecialchars($h['delivery_charge']); ?> BDT</td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <footer class="footer">
    <p>© 2025 BabyBird Cow Market — Trusted • Secure • Premium</p>
  </footer>

  <script>
    const distanceEl = document.getElementById('distance');
    const cowsEl = document.getElementById('cows');
    const chargeEl = document.getElementById('charge');
    const resetBtn = document.getElementById('resetBtn');
    const form = document.getElementById('deliveryForm');
    const toast = document.getElementById('toast');

    function goBack(){
      if (window.history.length > 1) {
        window.history.back();
      } else {
        window.location.href = '/Cowkino/index.php';
      }
    }

    // MATCHES PHP: distance * 100 * (cows * 0.75)
    function calcCharge() {
  const d = parseFloat(distanceEl.value || "0");
  const c = parseInt(cowsEl.value || "0", 10);

  if (!Number.isFinite(d) || !Number.isFinite(c) || d <= 0 || c <= 0) {
    chargeEl.value = "0";
    return;
  }

  const BASE = 100;
  const charge = BASE + (100 * d) + (50 * c);

  chargeEl.value = charge.toFixed(2);
}

    distanceEl.addEventListener('input', calcCharge);
    cowsEl.addEventListener('input', calcCharge);

    function clearStatusFromUrl() {
      const url = new URL(window.location.href);
      url.searchParams.delete('status');
      window.history.replaceState({}, '', url.pathname + url.search);
    }

    function resetFormUI(){
      form.reset();
      chargeEl.value = "0";
    }

    resetBtn.addEventListener('click', () => {
      toast.classList.remove('show');
      resetFormUI();
      clearStatusFromUrl();
    });

    // success popup after redirect
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('status') === 'success') {
      toast.classList.add('show');
      resetFormUI();
      clearStatusFromUrl();
    }
  </script>
</body>
</html>
