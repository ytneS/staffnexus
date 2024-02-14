<?php
    $host = 'localhost';
    $username = 'username';
    $password = 'password';
    $database = 'staff_nexus';

    $conn = mysqli_connect($host, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>