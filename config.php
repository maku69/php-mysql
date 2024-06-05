<?php
// config.php
$host = 'localhost';
$db = 'muusikapood';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Andmebaasi ühenduse viga: ' . $e->getMessage());
}

?>
