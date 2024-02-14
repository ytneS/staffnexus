<?php
require_once("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $checkEmailQuery = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($checkEmailQuery);

    $response = array();

    if ($result->num_rows > 0) {
        $response['emailExists'] = true;
    } else {
        $response['emailExists'] = false;
    }

    echo json_encode($response);
}
?>
