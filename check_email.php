<?php
require_once("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $checkEmailQuery = "SELECT * FROM users WHERE email=:email";
    $stmt = $conn->prepare($checkEmailQuery);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response = array();

    if (count($result) > 0) {
        $response['emailExists'] = true;
    } else {
        $response['emailExists'] = false;
    }

    echo json_encode($response);
}
?>
