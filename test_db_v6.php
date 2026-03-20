<?php
$servername = "::1";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$servername", $username, $password);
    echo "Server Connected on IPv6";
} catch(PDOException $e) {
    echo "Server Connection failed on IPv6: " . $e->getMessage();
}
