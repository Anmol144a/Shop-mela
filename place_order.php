<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $customer_name = $_POST['customer_name'];
    $customer_address = $_POST['customer_address'];

    $stmt = $pdo->prepare("INSERT INTO orders (product_id, customer_name, customer_address) VALUES (?, ?, ?)");
    $stmt->execute([$product_id, $customer_name, $customer_address]);
    $order_id = $pdo->lastInsertId();

    echo "<div class='container mt-4 alert alert-success'>Order placed! Your Order ID is $order_id. <a href='index.php'>Back to Shop</a></div>";
}
?>
