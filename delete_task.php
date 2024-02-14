<?php
    require_once("connect.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $taskId = $_POST["task_id"];

        // Perform the task deletion
        $stmt = $conn->prepare("DELETE FROM todo WHERE task_id = ?");
        $stmt->bind_param("i", $taskId);

        if ($stmt->execute()) {
            echo "Task deleted successfully";
        } else {
            echo "Error deleting task: " . $stmt->error;
        }

        $stmt->close();
    }
?>
