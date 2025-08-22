<?php
include 'db.php';
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin.php');
    exit;
}

$action = $_POST['action'];

if ($action == 'add_product') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    $stmt = $pdo->prepare("INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $description, $price, $image]);
} elseif ($action == 'edit_product') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];

    $stmt = $pdo->prepare("UPDATE products SET name = ?, price = ? WHERE id = ?");
    $stmt->execute([$name, $price, $id]);
} elseif ($action == 'delete_product') {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
} elseif ($action == 'update_order') {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);
}

header('Location: admin.php');
exit;
?>
