<?php
$host = 'sql12.freesqldatabase.com';
$dbname = 'sql12795716';
$user = 'sql12795716';
$pass = 'IdiQIbAA3X';
$port = 3306;

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
