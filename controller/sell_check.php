<?php
session_start();
require_once '../model/cows.php';

// 1. Check if user is logged in
if (!isset($_SESSION['status']) || $_SESSION['status'] !== true) {
    header('location: ../view/login.php?error=must_login');
    exit();
}

// 2. Check if form submitted
if (isset($_POST['submit'])) {

    // Helper: Sanitize Input
    function sanitize($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    // 3. Get & Sanitize Data
    $cowName = sanitize($_POST['cowName']);
    $breed = sanitize($_POST['breed']);
    $price = sanitize($_POST['price']);
    $weight = sanitize($_POST['weight']);
    $age = sanitize($_POST['age']);
    $description = sanitize($_POST['description']);
    
    // 4. Validate Inputs
    if (empty($cowName) || empty($breed) || empty($price) || empty($weight) || empty($age)) {
        $_SESSION['error_msg'] = "All fields (Name, Breed, Price, Weight, Age) are required.";
        header('location: ../view/sell.php');
        exit();
    }

    if (!is_numeric($price) || !is_numeric($weight) || !is_numeric($age)) {
        $_SESSION['error_msg'] = "Price, Weight, and Age must be valid numbers.";
        header('location: ../view/sell.php');
        exit();
    }

    // 5. Handle Image Upload
    $photo_url = "";

    if (isset($_FILES['cowImage']) && $_FILES['cowImage']['error'] === 0) {
        $fileName = $_FILES['cowImage']['name'];
        $fileTmpName = $_FILES['cowImage']['tmp_name'];
        $fileSize = $_FILES['cowImage']['size'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($fileExt, $allowed)) {
            if ($fileSize < 5000000) { // 5MB Limit
                
                // Generate unique name
                $newFileName = uniqid('COW_', true) . "." . $fileExt;
                $uploadDir = '../upload/';
                $uploadDest = $uploadDir . $newFileName;

                // Create 'upload' folder if it doesn't exist
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                
                // Extra validation: ensure it's a real image
                $imgInfo = @getimagesize($fileTmpName);
                if ($imgInfo === false) {
                    $_SESSION['error_msg'] = "Invalid image file.";
                    header('location: ../view/sell.php');
                    exit();
                }
// Move file
                if (move_uploaded_file($fileTmpName, $uploadDest)) {
                    $photo_url = $newFileName;
                } else {
                    $_SESSION['error_msg'] = "Failed to save the uploaded image.";
                    header('location: ../view/sell.php');
                    exit();
                }

            } else {
                $_SESSION['error_msg'] = "File size too large. Max allowed is 5MB.";
                header('location: ../view/sell.php');
                exit();
            }
        } else {
            $_SESSION['error_msg'] = "Invalid file type. Allowed: JPG, JPEG, PNG, WEBP.";
            header('location: ../view/sell.php');
            exit();
        }
    } else {
        $_SESSION['error_msg'] = "Please upload a photo of the cow.";
        header('location: ../view/sell.php');
        exit();
    }

    // 6. Call Model
    $status = InsertCow($cowName, $price, $breed, $age, $weight, $photo_url, $description);

    if ($status === true) {
        // Success: Redirect to Buy page with a success flag
        $_SESSION['success_msg'] = "Ad posted successfully!"; 
        header('location: ../view/buy.php'); 
        exit();
    } else {
        $_SESSION['error_msg'] = "Database Error: Could not post ad. Please try again.";
        header('location: ../view/sell.php');
        exit();
    }

} else {
    header('location: ../view/sell.php');
    exit();
}
?>