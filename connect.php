<?php
$host = 'localhost';
$username = 'username';
$password = 'password';
$database = 'staff_nexus';

try {
    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    // Set PDO to throw exceptions on error
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
