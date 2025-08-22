<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
        $stmt->execute([$username, $password]);
        if ($stmt->fetch()) {
            $_SESSION['admin_logged_in'] = true;
            header('Location: admin.php');
            exit;
        } else {
            $error = "Invalid credentials";
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Admin Login - Shop Mela</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container mt-4">
            <h2>Admin Login</h2>
            <?php if (isset($error)) echo '<div class="alert alert-danger">' . $error . '</div>'; ?>
            <form method="POST">
                <div class="mb-3"><label>Username</label><input type="text" name="username" class="form-control" required></div>
                <div class="mb-3"><label>Password</label><input type="password" name="password" class="form-control" required></div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </body>
    </html>
    <?php
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Shop Mela</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Admin Dashboard</h2>
        <a href="logout.php" class="btn btn-danger mb-3">Logout</a>

        <!-- Manage Products -->
        <h3>Manage Products</h3>
        <form method="POST" action="admin_actions.php">
            <input type="hidden" name="action" value="add_product">
            <div class="mb-3"><label>Name</label><input type="text" name="name" class="form-control" required></div>
            <div class="mb-3"><label>Description</label><textarea name="description" class="form-control"></textarea></div>
            <div class="mb-3"><label>Price</label><input type="number" step="0.01" name="price" class="form-control" required></div>
            <div class="mb-3"><label>Image URL</label><input type="text" name="image" class="form-control"></div>
            <button type="submit" class="btn btn-success">Add Product</button>
        </form>
        <table class="table mt-3">
            <thead><tr><th>ID</th><th>Name</th><th>Price</th><th>Actions</th></tr></thead>
            <tbody>
                <?php
                $stmt = $pdo->query("SELECT * FROM products");
                while ($row = $stmt->fetch()) {
                    echo '<tr>
                        <td>' . $row['id'] . '</td>
                        <td>' . $row['name'] . '</td>
                        <td>$' . $row['price'] . '</td>
                        <td>
                            <form method="POST" action="admin_actions.php" style="display:inline;">
                                <input type="hidden" name="action" value="edit_product">
                                <input type="hidden" name="id" value="' . $row['id'] . '">
                                <input type="text" name="name" value="' . $row['name'] . '" required>
                                <input type="number" step="0.01" name="price" value="' . $row['price'] . '" required>
                                <button type="submit" class="btn btn-sm btn-warning">Edit</button>
                            </form>
                            <form method="POST" action="admin_actions.php" style="display:inline;">
                                <input type="hidden" name="action" value="delete_product">
                                <input type="hidden" name="id" value="' . $row['id'] . '">
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>';
                }
                ?>
            </tbody>
        </table>

        <!-- Manage Orders -->
        <h3>Manage Orders</h3>
        <table class="table">
            <thead><tr><th>ID</th><th>Product ID</th><th>Customer</th><th>Address</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead>
            <tbody>
                <?php
                $stmt = $pdo->query("SELECT * FROM orders");
                while ($row = $stmt->fetch()) {
                    echo '<tr>
                        <td>' . $row['id'] . '</td>
                        <td>' . $row['product_id'] . '</td>
                        <td>' . $row['customer_name'] . '</td>
                        <td>' . $row['customer_address'] . '</td>
                        <td>' . $row['status'] . '</td>
                        <td>' . $row['order_date'] . '</td>
                        <td>
                            <form method="POST" action="admin_actions.php" style="display:inline;">
                                <input type="hidden" name="action" value="update_order">
                                <input type="hidden" name="id" value="' . $row['id'] . '">
                                <select name="status">
                                    <option value="Pending" ' . ($row['status'] == 'Pending' ? 'selected' : '') . '>Pending</option>
                                    <option value="Shipped" ' . ($row['status'] == 'Shipped' ? 'selected' : '') . '>Shipped</option>
                                    <option value="Delivered" ' . ($row['status'] == 'Delivered' ? 'selected' : '') . '>Delivered</option>
                                    <option value="Cancelled" ' . ($row['status'] == 'Cancelled' ? 'selected' : '') . '>Cancelled</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            </form>
                        </td>
                    </tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
