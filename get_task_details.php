<?php
// get_task_details.php

require_once("connect.php");

if (isset($_GET["task_id"])) {
    $taskId = $_GET["task_id"];

    $stmt = $conn->prepare("SELECT * FROM todo WHERE task_id = ?");
    $stmt->bind_param("i", $taskId);
    $stmt->execute();
    $result = $stmt->get_result();
    $taskDetails = $result->fetch_assoc();

    echo json_encode($taskDetails);

    $stmt->close();
    $conn->close();
}
?>