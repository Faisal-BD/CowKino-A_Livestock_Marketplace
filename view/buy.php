<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


require_once '../model/cows.php';
$allCows = GetApprovedCows();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Buy Cows | CowKino.com</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="../Asset/style/style.css" />
</head>

<body>

    <?php include "./header.php"; ?>

    <main class="market-section">
        <div class="container">
            <div class="market-header">
                <h1>Browse Livestock</h1>
                <p>Find the best breeds from verified farmers.</p>
            </div>

            <div class="cow-grid">
                <?php if (count($allCows) > 0): ?>
                    <?php foreach ($allCows as $cow): ?>
                        <article class="cow-card">
                            <div class="card-image">
                                <span class="tag-price">$<?php echo number_format($cow['price']); ?></span>
                                <img src="../upload/<?php echo htmlspecialchars($cow['photo_url']); ?>"
                                    alt="<?php echo htmlspecialchars($cow['name']); ?>"
                                    style="object-fit: cover; background-color: #e5e7eb;"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">

                                <div class="fallback-placeholder" style="display:none; width:100%; height:100%; background:#f3f4f6; align-items:center; justify-content:center; color:#9ca3af; font-weight:bold;">
                                    No Image
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card-top">
                                    <h3><?php echo htmlspecialchars($cow['name']); ?></h3>
                                    <span class="breed-tag"><?php echo htmlspecialchars($cow['breed']); ?></span>
                                </div>

                                <div class="stats-row">
                                    <div class="stat">
                                        <span class="label">Weight</span>
                                        <span class="value"><?php echo htmlspecialchars($cow['weight']); ?>kg</span>
                                    </div>
                                    <div class="stat">
                                        <span class="label">Age</span>
                                        <span class="value"><?php echo htmlspecialchars($cow['age']); ?> Yrs</span>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <a class="btn btn-primary btn-sm" style="width:100%" href="cow_details.php?id=<?php echo $cow['id']; ?>">View Details</a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align:center;">No cows found.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <?php include "./footer.php"; ?>

    <script src="../Asset/Js/script.js"></script>
</body>

</html>