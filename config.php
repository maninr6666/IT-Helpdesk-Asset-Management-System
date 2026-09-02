<?php
// Update these values for your local MySQL installation.
$host = "127.0.0.1";
$db   = "it_helpdesk";
$user = "root";
$pass = ""; // XAMPP default is usually empty; change if your MySQL has a password.
$charset = "utf8mb4";

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    http_response_code(500);
    die("Database connection failed. Check config.php and MySQL.");
}
