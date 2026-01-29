<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CowKino Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
  <!-- Load main site design tokens so admin matches the website -->
  <link rel="stylesheet" href="../Asset/style/style.css" />
  <!-- Admin-specific layout overrides -->
  <link rel="stylesheet" href="assets/admin.css" />
</head>
<body>
  <!-- Mobile controls: sidebar toggle + theme toggle -->
  <div class="admin-mobilebar">
    <div class="mobilebar-inner">
      <button class="sidebar-toggle" id="sidebarToggle" type="button" aria-label="Open sidebar">☰</button>
      <button class="theme-toggle" id="themeToggle" type="button" aria-label="Toggle theme">
        <span data-icon>🌙</span>
        <span data-text>Dark</span>
      </button>
    </div>
  </div>
  <div class="sidebar-overlay" id="sidebarOverlay"></div>
