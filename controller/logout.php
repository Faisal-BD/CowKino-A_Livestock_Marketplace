<?php
session_start();

// 1. Unset all session variables
session_unset();

// 2. Destroy the session
session_destroy();

// 3. Redirect back to Home Page (or Login page)
header("location: ../index.php"); 
exit();
?>