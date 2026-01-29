<?php
// Build correct project base URL from filesystem (works even if this file is included from index.php)
$docRoot = realpath($_SERVER['DOCUMENT_ROOT']);
$projectRoot = realpath(__DIR__ . '/../Cowkino'); // Cowkino folder
$BASE = str_replace('\\', '/', str_replace($docRoot, '', $projectRoot)); // -> /Cowkino
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>COWkino — Query & Support</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Internal CSS -->
   <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    :root{
      --bg: #000000; /* PURE BLACK */
      --card: rgba(255,255,255,0.04);
      --text: #eaf0ff;
      --muted: rgba(234,240,255,0.72);
      --accent: #f5b301; /* premium gold */
      --accentBorder: rgba(245,179,1,0.35);
      --stroke: rgba(255,255,255,0.10);
      --shadow: 0 12px 28px rgba(0,0,0,.55);
      --radius: 18px;
    }

    *{ margin:0; padding:0; box-sizing:border-box; }
    html,body{ height:100%; }

    body{
      font-family: "Poppins", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
      background: var(--bg);
      color: var(--text);
    }

    a{ color: inherit; text-decoration:none; }

    /* NAVBAR */
    .navbar{
      position: sticky;
      top: 0;
      z-index: 999;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
      padding: 14px 20px;
      background: rgba(0,0,0,0.75);
      backdrop-filter: blur(14px);
      border-bottom: 1px solid var(--stroke);
    }

    .logo{
      font-weight: 800;
      letter-spacing: 1px;
      font-size: 20px;
    }

    .logo::after{
      content: "";
      display: inline-block;
      width: 8px;
      height: 8px;
      border-radius: 999px;
      background: var(--accent);
      margin-left: 8px;
      box-shadow: 0 0 0 4px rgba(245,179,1,0.12);
    }

    #searchBox{
      flex: 1;
      max-width: 420px;
      min-width: 180px;
      padding: 12px 14px;
      border-radius: 999px;
      border: 1px solid var(--stroke);
      background: rgba(255,255,255,0.05);
      color: var(--text);
      outline: none;
      transition: .2s ease;
    }

    #searchBox::placeholder{ color: rgba(234,240,255,0.55); }
    #searchBox:focus{
      border-color: rgba(245,179,1,0.55);
      box-shadow: 0 0 0 4px rgba(245,179,1,0.12);
    }

    .nav-actions{
      display: flex;
      align-items: center;
      gap: 10px;
      flex-wrap: wrap;
    }

    /* BUTTONS */
    .btn-outline, .btn-fill{
      border: none;
      cursor: pointer;
      font-weight: 700;
      transition: transform .15s ease, box-shadow .2s ease, background .2s ease, border-color .2s ease;
      border-radius: 999px;
    }

    .btn-outline{
      padding: 10px 14px;
      background: transparent;
      border: 1px solid rgba(245,179,1,0.35);
      color: var(--text);
    }

    .btn-outline:hover{
      transform: translateY(-1px);
      background: rgba(245,179,1,0.08);
      box-shadow: var(--shadow);
      border-color: rgba(245,179,1,0.65);
    }

    .btn-fill{
      padding: 10px 14px;
      background: linear-gradient(135deg, var(--accent), #ffd36a);
      color: #121212;
      box-shadow: 0 10px 22px rgba(245,179,1,0.18);
    }

    .btn-fill:hover{
      transform: translateY(-1px);
      box-shadow: 0 14px 28px rgba(245,179,1,0.26);
    }

    .active-link{
      outline: 2px solid rgba(245,179,1,0.35);
    }

    /* LAYOUT */
    .container{
      max-width: 980px;
      margin: 0 auto;
      padding: 0 14px;
    }

    .market{
      padding: 38px 0 60px;
    }

    .market h2{
      text-align: center;
      font-size: 28px;
      margin-bottom: 18px;
    }

    .market h2::after{
      content: "";
      display: block;
      width: 90px;
      height: 3px;
      margin: 10px auto 0;
      border-radius: 999px;
      background: linear-gradient(90deg, transparent, rgba(245,179,1,0.9), transparent);
    }

    /* CARD */
    .cow-card{
      background: var(--card);
      border: 1px solid var(--stroke);
      border-radius: var(--radius);
      padding: 16px;
      box-shadow: var(--shadow);
    }

    /* FOOTER */
    /* Modify .market to make the content fill the height */
    .market {
      padding: 38px 0 60px;
      min-height: 100vh; /* Ensures the content takes at least 100% of the screen height */
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    /* Make the footer sticky at the bottom */
    .footer {
      position: relative;
      bottom: 0;
      width: 100%;
      border-top: 1px solid var(--stroke);
      padding: 18px;
      text-align: center;
      color: rgba(234, 240, 255, 0.70);
      background: rgba(255, 255, 255, 0.02);
    }

    /* QUERY PAGE */
    .query-card{ margin-top: 14px; }

    .query-actions{
      display: flex;
      gap: 12px;
      flex-wrap: wrap;
      margin-top: 12px;
    }

    .query-head{
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 12px;
      flex-wrap: wrap;
      margin-bottom: 10px;
    }

    .small-btn{
      padding: 8px 12px;
      font-size: 14px;
    }

    .hidden{ display: none !important; }

    .question-list{
      display: grid;
      gap: 10px;
      margin: 12px 0 14px;
    }

    .label{
      display: block;
      font-size: 13px;
      color: var(--muted);
      margin-bottom: 6px;
    }

    .form-row{
      margin: 10px 0;
    }

    input, textarea{
      width: 100%;
      padding: 12px 12px;
      border-radius: 12px;
      border: 1px solid var(--stroke);
      background: rgba(255,255,255,0.04);
      color: var(--text);
      outline: none;
      transition: .2s ease;
      font-family: inherit;
    }

    input:focus, textarea:focus{
      border-color: rgba(245,179,1,0.60);
      box-shadow: 0 0 0 4px rgba(245,179,1,0.10);
    }

    textarea{ resize: vertical; }

    /* COW BUTTON */
    .cow-btn{
      width: 100%;
      padding: 10px 12px;
      background: rgba(245,179,1,0.12);
      border: 1px solid var(--accentBorder);
      color: var(--text);
      cursor: pointer;
      border-radius: 14px;
      font-weight: 700;
      transition: transform .15s ease, box-shadow .2s ease, background .2s ease;
      text-align: left;
    }

    .cow-btn:hover{
      transform: translateY(-1px);
      background: rgba(245,179,1,0.18);
      box-shadow: 0 12px 26px rgba(245,179,1,0.10);
    }

    .cow-btn:disabled{
      opacity: 0.5;
      cursor: not-allowed;
      transform: none;
      box-shadow: none;
    }

    /* SELECTED QUESTION */
    .q-btn.selected{
      outline: 2px solid rgba(245,179,1,0.70);
      background: rgba(245,179,1,0.20);
    }

    /* MESSAGES */
    .form-msg{
      margin-top: 10px;
      font-size: 14px;
      color: rgba(234,240,255,0.75);
    }

    .form-msg.ok{ color: rgba(34,197,94,0.95); }
    .form-msg.error{ color: rgba(239,68,68,0.95); }

    /* BADGE */
    .badge{
      display: inline-block;
      padding: 6px 10px;
      border-radius: 999px;
      font-size: 12px;
      font-weight: 800;
      background: rgba(245,179,1,0.14);
      border: 1px solid rgba(245,179,1,0.30);
      margin-bottom: 10px;
    }

    /* RESPONSIVE */
    @media (max-width: 640px){
      #searchBox{ max-width: 100%; }
      .navbar{ padding: 12px 14px; }
    }
  </style>
</head>

<body>
  <!-- NAVBAR -->
  <nav class="navbar">
    <div class="logo">
       <a href="/Cowkino/index.php">COWkino</a>
    </div>
      my query & cow delivary button

    <input type="text" id="searchBox" placeholder="Search questions..." onkeyup="filterQuestions()" aria-label="Search questions" disabled title="Select a role first to search questions" />

    <div class="nav-actions">
      <button class="btn-outline" type="button" onclick="goBack()">Back</button>
      <button class="btn-outline" id="resetBtn" type="button">Reset</button>
    </div>
  </nav>

  <!-- QUERY ONLY PAGE -->
  <section class="market">
    <div class="container">
      <h2>Query & Support</h2>

      <!-- STEP 1: ROLE -->
      <div class="cow-card" id="stepRole">
        <h3>Are you a Buyer or a Seller?</h3>
        <p style="color: var(--muted); margin-top: 6px;">Choose one to see the questionnaire.</p>

        <div class="row">
          <button class="btn-fill" id="buyerBtn" type="button">I’m a Buyer</button>
          <button class="btn-outline" id="sellerBtn" type="button">I’m a Seller</button>
        </div>
      </div>

      <!-- STEP 2: BUYER FORM -->
      <div class="cow-card hidden" id="buyerForm" style="margin-top:14px;">
        <h3>Buyer Questionnaire</h3>

        <!-- Buyer Form -->
        <form id="buyerRealForm" action="/Cowkino/controller/submit_buyer.php" method="POST">
          <!-- Email Input -->
          <input type="email" name="email" placeholder="Enter your email" required>

          <!-- Selected Questions (Checkboxes) -->
          <label><input type="checkbox" name="questions[]" value="Are the breeds authentic?"> Are the breeds authentic?</label>
          <label><input type="checkbox" name="questions[]" value="Do we have personal contact with the seller?"> Do we have personal contact with the seller?</label>
          <label><input type="checkbox" name="questions[]" value="How to report a bad seller?"> How to report a bad seller?</label>

          <!-- Extra Details -->
          <textarea name="extra_details" placeholder="Enter any extra details..."></textarea>

          <button type="submit">Submit</button>
        </form>
      </div>

      <!-- STEP 2: SELLER FORM -->
      <div class="cow-card hidden" id="sellerForm" style="margin-top:14px;">
        <h3>Seller Questionnaire</h3>

        <!-- Seller Form -->
        <form id="sellerRealForm" action="/Cowkino/controller/submit_seller.php" method="POST">
          <!-- Email Input -->
          <input type="email" name="email" placeholder="Enter your email" required>

          <!-- Selected Questions (Checkboxes) -->
          <label><input type="checkbox" name="questions[]" value="Are we cutting commissions?"> Are we cutting commissions?</label>
          <label><input type="checkbox" name="questions[]" value="Do we infiltrate fake buyers?"> Do we infiltrate fake buyers?</label>
          <label><input type="checkbox" name="questions[]" value="Do we assure their cow to be sold?"> Do we assure their cow to be sold?</label>

          <!-- Extra Details -->
          <textarea name="extra_details" placeholder="Enter any extra details..."></textarea>

          <button type="submit">Submit</button>
        </form>
      </div>

      <div class="cow-card hidden" id="stepThanks" style="margin-top:14px;">
    <div class="badge">Received</div>
    <h3>Thank you ✅</h3>
    <p id="thanksText" style="color: var(--muted); margin-top: 6px;">
        We have received your query. Please be patient while our team reviews it.
    </p>
    <div style="margin-top: 12px;">
        <div style="color: var(--muted); font-size: 14px; margin-bottom: 8px;">Your selected questions:</div>
        <ul id="selectedList" style="padding-left: 18px; line-height: 1.8;"></ul>
    </div>
    <div class="row">
        <button class="btn-fill" id="newQueryBtn" type="button">Send Another Query</button>
    </div>
   </div>
   </div>
  </section>

  <footer class="footer">
    <p>© 2025 BabyBird Cow Market — Trusted • Secure • Premium</p>
  </footer>
<script>
  function goBack(){
    if (window.history.length > 1) {
      window.history.back();
    } else {
      window.location.href = '/Cowkino/index.php';
    }
  }

  // Buttons
  const buyerBtn = document.getElementById('buyerBtn');
  const sellerBtn = document.getElementById('sellerBtn');
  const resetBtn = document.getElementById('resetBtn');
  const newQueryBtn = document.getElementById('newQueryBtn');

  // Sections (DIVs)
  const buyerForm = document.getElementById('buyerForm');
  const sellerForm = document.getElementById('sellerForm');
  const stepRole = document.getElementById('stepRole');
  const stepThanks = document.getElementById('stepThanks');

  // Real FORMS (must exist in HTML)
  const buyerRealForm = document.getElementById('buyerRealForm');
  const sellerRealForm = document.getElementById('sellerRealForm');

  function clearStatusFromUrl() {
    const url = new URL(window.location.href);
    url.searchParams.delete('status');
    window.history.replaceState({}, '', url.pathname + url.search);
  }

  function resetAll() {
    // reset forms safely
    if (buyerRealForm) buyerRealForm.reset();
    if (sellerRealForm) sellerRealForm.reset();

    // show role, hide everything else
    if (buyerForm) buyerForm.classList.add('hidden');
    if (sellerForm) sellerForm.classList.add('hidden');
    if (stepThanks) stepThanks.classList.add('hidden');
    if (stepRole) stepRole.classList.remove('hidden');

    clearStatusFromUrl();
  }

  // Buyer click
  if (buyerBtn) {
    buyerBtn.addEventListener('click', () => {
      stepRole.classList.add('hidden');
      sellerForm.classList.add('hidden');
      stepThanks.classList.add('hidden');
      buyerForm.classList.remove('hidden');
    });
  }

  // Seller click
  if (sellerBtn) {
    sellerBtn.addEventListener('click', () => {
      stepRole.classList.add('hidden');
      buyerForm.classList.add('hidden');
      stepThanks.classList.add('hidden');
      sellerForm.classList.remove('hidden');
    });
  }

  // Reset button
  if (resetBtn) {
    resetBtn.addEventListener('click', resetAll);
  }

  // Send another query button
  if (newQueryBtn) {
    newQueryBtn.addEventListener('click', resetAll);
  }

  // On load: show thank you if redirected with success
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('status') === 'success') {
    stepRole.classList.add('hidden');
    buyerForm.classList.add('hidden');
    sellerForm.classList.add('hidden');
    stepThanks.classList.remove('hidden');
  }
</script>
</body>
</html>
