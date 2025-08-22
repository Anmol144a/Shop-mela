<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Track Order - Shop Mela</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <?php
        if (isset($_GET['order_id'])) {
            $order_id = $_GET['order_id'];
            $stmt = $pdo->prepare("SELECT o.*, p.name AS product_name FROM orders o JOIN products p ON o.product_id = p.id WHERE o.id = ?");
            $stmt->execute([$order_id]);
            $order = $stmt->fetch();

            if ($order) {
                echo '
                <h2>Order Details</h2>
                <p><strong>Order ID:</strong> ' . $order['id'] . '</p>
                <p><strong>Product:</strong> ' . $order['product_name'] . '</p>
                <p><strong>Status:</strong> ' . $order['status'] . '</p>
                <p><strong>Date:</strong> ' . $order['order_date'] . '</p>
                <a href="index.php" class="btn btn-primary">Back to Shop</a>';
            } else {
                echo '<div class="alert alert-danger">Order not found.</div>';
            }
        }
        ?>
    </div>
</body>
</html>
