<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Mela</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Shop Mela</a>
            <a class="btn btn-outline-primary ms-auto" href="admin.php">Admin</a>
        </div>
    </nav>
    <div class="container mt-4">
        <h2>Products</h2>
        <div class="row">
            <?php
            $stmt = $pdo->query("SELECT * FROM products");
            while ($row = $stmt->fetch()) {
                echo '
                <div class="col-md-4">
                    <div class="card product-card">
                        <img src="' . ($row['image'] ?? 'https://via.placeholder.com/300') . '" class="card-img-top" alt="' . $row['name'] . '">
                        <div class="card-body">
                            <h5 class="card-title">' . $row['name'] . '</h5>
                            <p class="card-text">' . $row['description'] . '</p>
                            <p class="card-text"><strong>$' . $row['price'] . '</strong></p>
                            <form method="POST" action="place_order.php">
                                <input type="hidden" name="product_id" value="' . $row['id'] . '">
                                <div class="mb-3">
                                    <label>Your Name</label>
                                    <input type="text" name="customer_name" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Address</label>
                                    <textarea name="customer_address" class="form-control" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Place Order</button>
                            </form>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>
        <hr>
        <h2>Track Order</h2>
        <form method="GET" action="track_order.php">
            <div class="mb-3">
                <label>Order ID</label>
                <input type="number" name="order_id" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-info">Track</button>
        </form>
    </div>
</body>
</html>
