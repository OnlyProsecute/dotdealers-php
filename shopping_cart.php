<?php
session_start();
include('includes/db.php');
include('components/header.php');

if (!isset($_SESSION['user_id'])) {
    echo 'You must be logged in to view your cart.';
    exit;
}

$userId = $_SESSION['user_id'];

$sql = "SELECT * FROM shopping_cart WHERE user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$userId]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

$domains = [];
foreach ($cartItems as $item) {
    $mainDomain = explode('.', $item['domain_url'])[0]; 
    if (!isset($domains[$mainDomain])) {
        $domains[$mainDomain] = [];
    }
    $domains[$mainDomain][$item['extension']] = $item['price']; 
}

$allExtensions = ["nl", "com", "org", "net", "eu", "de", "co", "be", "fr", "it"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://fonts.googleapis.com/css2?family=Geist+Mono:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="globals.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/shopping_cart.css">
</head>
<body>

<?php renderHeader(); ?>

<div class="cart-container">
    <?php if (!empty($domains)): ?>
        <?php foreach ($domains as $mainDomain => $extensionsInCart): ?>
            <div class="shopping-card">
                <div class="shopping-card-top">
                    <div class="title-column">
                        <h3 class="shopping-title"><?php echo strtoupper(htmlspecialchars($mainDomain)); ?></h3>
                    </div>
                    <div class="extensions-column">
                        <div class="extensions">
                            <?php foreach ($allExtensions as $ext): ?>
                                <?php if (isset($extensionsInCart[$ext])): ?>
                                    <div class="extension-item active">
                                        <span><?php echo '.' . htmlspecialchars($ext); ?></span>
                                        <a href="remove_from_cart.php?domain=<?php echo urlencode($mainDomain . '.' . $ext); ?>" class="remove-btn">x</a>
                                    </div>
                                <?php else: ?>
                                    <div class="extension-item inactive">
                                        <span><?php echo '.' . htmlspecialchars($ext); ?></span>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="price-list">
                    <h4>Prices:</h4>
                    <ul>
                        <?php 
                        $totalPrice = 0;
                        foreach ($extensionsInCart as $ext => $price): 
                        ?>
                            <li><?php echo '.' . htmlspecialchars($ext); ?> - $<?php echo number_format($price, 2); ?></li>
                            <?php $totalPrice += $price; ?>
                        <?php endforeach; ?>
                    </ul>
                    <p><strong>Total: $<?php echo number_format($totalPrice, 2); ?></strong></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="empty-cart">Your cart is empty.</p>
    <?php endif; ?>
</div>

</body>
</html>
