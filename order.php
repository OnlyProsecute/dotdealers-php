<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['user_id'])) {
    echo 'You must be logged in to place an order.';
    exit;
}

$userId = $_SESSION['user_id'];

$sql = "SELECT * FROM shopping_cart WHERE user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$userId]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($cartItems)) {
    echo 'Your cart is empty.';
    exit;
}

try {
    $pdo->beginTransaction();

    $totalPrice = 0;
    foreach ($cartItems as $item) {
        $totalPrice += $item['price'];
    }

    $sql = "INSERT INTO orders (user_id, total_price) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId, $totalPrice]);

    $orderId = $pdo->lastInsertId();

    foreach ($cartItems as $item) {
        $sql = "INSERT INTO order_items (order_id, domain_url, extension, price) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$orderId, $item['domain_url'], $item['extension'], $item['price']]);
    }

    $sql = "DELETE FROM shopping_cart WHERE user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId]);

    $pdo->commit();

    echo 'Your order has been placed successfully!';
} catch (Exception $e) {
    $pdo->rollBack();
    echo 'Error placing order: ' . $e->getMessage();
}
?>
