<?php
session_start();

include('includes/db.php');

if (!isset($_SESSION['user_id'])) {
    echo 'You must be logged in to add items to the cart.';
    exit;
}
$userId = isset($_POST['user_id']) ? $_POST['user_id'] : '';
$domainName = isset($_POST['domain_url']) ? $_POST['domain_url'] : '';
$extension = isset($_POST['extension']) ? $_POST['extension'] : '';
$price = isset($_POST['price']) ? $_POST['price'] : 0;

if (empty($domainName) || empty($extension) || $price == 0 || empty($userId)) {
    echo $domainName;
    echo $extension;
    echo $price;
    echo $userId;
    echo 'Invalid data.';
    exit;
}

$sql = "SELECT * FROM shopping_cart WHERE user_id = ? AND domain_url = ? AND extension = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$userId, $domainName, $extension]);

if ($stmt->rowCount() > 0) {
    echo 'This domain is already in your cart.';
    exit;
}

$sql = "INSERT INTO shopping_cart (user_id, domain_url, extension, price) VALUES (?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$userId, $domainName, $extension, $price]);

echo 'Domain added to cart!';
?>
