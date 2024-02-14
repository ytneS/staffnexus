<?php
require_once("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $taskId = $_POST["task_id"];
    $taskName = $_POST["task_name"];
    $priority = $_POST["priority"];
    $description = $_POST["description"];

    // Zde provedete aktualizaci úkolu v databázi pomocí UPDATE statementu
    $stmt = $conn->prepare("UPDATE todo SET task = ?, priority = ?, description = ? WHERE task_id = ?");
    $stmt->bind_param("sssi", $taskName, $priority, $description, $taskId);

    if ($stmt->execute()) {
        echo "Task updated successfully";
    } else {
        echo "Error updating task: " . $stmt->error;
    }

    $stmt->close();
}
?>