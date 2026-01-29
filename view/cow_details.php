<?php
session_start();
require_once '../model/cows.php';

// Check ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('location: buy.php');
    exit();
}

$cowId = $_GET['id'];
$cow = GetCowById($cowId);

if (!$cow) {
    echo "Cow not found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($cow['name']); ?> | CowKino Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="../Asset/style/style.css" />
</head>
<body class="page-bg">

    <?php include "./header.php"; ?>

    <main class="product-page">
        <div class="container">
            
            <nav class="breadcrumb-clean">
                <a href="buy.php">Marketplace</a>
                <span class="divider">/</span>
                <a href="#"><?php echo htmlspecialchars($cow['breed']); ?></a>
                <span class="divider">/</span>
                <span class="current">#CK-<?php echo $cow['id']; ?></span>
            </nav>

            <div class="product-layout">
                
                <div class="product-visuals">
                    <div class="main-gallery-wrapper">
                        <img src="../upload/<?php echo htmlspecialchars($cow['photo_url']); ?>" 
                             alt="<?php echo htmlspecialchars($cow['name']); ?>"
                             class="hero-image"
                             onerror="this.src='https://via.placeholder.com/1200x800?text=No+Image+Available'">
                        
                        <div class="floating-badge">
                            <i class="ph-fill ph-check-circle"></i> Verified Listing
                        </div>
                    </div>

                    <div class="product-description-block">
                        <h3>About this Livestock</h3>
                        <div class="text-content">
                            <p><?php echo nl2br(htmlspecialchars($cow['description'])); ?></p>
                        </div>
                        
                        <div class="specs-table">
                            <div class="spec-row">
                                <span class="spec-label">Health Status</span>
                                <span class="spec-value">Vaccinated</span>
                            </div>
                            <div class="spec-row">
                                <span class="spec-label">Location</span>
                                <span class="spec-value">Farm Verified</span>
                            </div>
                            <div class="spec-row">
                                <span class="spec-label">Date Listed</span>
                                <span class="spec-value"><?php echo date('M d, Y'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <aside class="product-sidebar">
                    <div class="sidebar-card">
                        
                        <div class="sidebar-header">
                            <span class="breed-tag"><?php echo htmlspecialchars($cow['breed']); ?></span>
                            <h1 class="cow-title"><?php echo htmlspecialchars($cow['name']); ?></h1>
                            <div class="price-block">
                                <span class="amount">$<?php echo number_format($cow['price']); ?></span>
                                <span class="currency">USD</span>
                            </div>
                        </div>

                        <div class="divider-line"></div>

                        <div class="quick-stats">
                            <div class="stat-pill">
                                <i class="ph ph-scales"></i>
                                <div>
                                    <span class="lbl">Weight</span>
                                    <span class="val"><?php echo htmlspecialchars($cow['weight']); ?> kg</span>
                                </div>
                            </div>
                            <div class="stat-pill">
                                <i class="ph ph-calendar-blank"></i>
                                <div>
                                    <span class="lbl">Age</span>
                                    <span class="val"><?php echo htmlspecialchars($cow['age']); ?> Yrs</span>
                                </div>
                            </div>
                        </div>

                        <div class="sidebar-actions">
                            <button class="btn-primary-block">
                                <i class="ph-bold ph-phone"></i> 0987654
                            </button>
                            <button class="btn-outline-block">
                                <i class="ph-bold ph-chat-circle-text"></i> Message on 098776
                            </button>
                        </div>

                        <div class="safety-box">
                            <i class="ph-fill ph-shield-check"></i>
                            <p><strong>Safe Trade Guarantee:</strong> Payment is held in escrow until you verify the livestock in person.</p>
                        </div>

                    </div>
                </aside>

            </div>
        </div>
    </main>

    <?php include "./footer.php"; ?>
    <script src="../Asset/Js/script.js"></script>
</body>
</html>