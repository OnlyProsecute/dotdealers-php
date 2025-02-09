<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['user_id'])) {
    echo 'You must be logged in to remove items from the cart.';
    exit;
}

$domain = isset($_GET['domain']) ? $_GET['domain'] : '';

if (empty($domain)) {
    echo 'Invalid request.';
    exit;
}

$parts = explode('.', $domain);
if (count($parts) < 2) {
    echo 'Invalid domain.';
    exit;
}
$mainDomain = $parts[0];
$extension = $parts[1];

$userId = $_SESSION['user_id'];

$sql = "DELETE FROM shopping_cart WHERE user_id = ? AND domain_url = ? AND extension = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$userId, $mainDomain, $extension]);

if ($stmt->rowCount() > 0) {
    header('Location: shopping_cart.php');
    exit;
} else {
    echo 'Item not found in the cart.';
    exit;
}
?>
