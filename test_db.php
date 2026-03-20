<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$servername", $username, $password);
    echo "Server Connected";
} catch(PDOException $e) {
    echo "Server Connection failed: " . $e->getMessage();
}
