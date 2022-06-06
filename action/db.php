<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "series";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$db;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
