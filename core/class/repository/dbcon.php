<?php
header("Access-Control-Allow-Origin: *");
$dsn = 'mysql:dbname=sams;host=localhost';
$user = 'root';
$password = '';

try {
    $conn = new PDO($dsn, $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
