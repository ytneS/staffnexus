<?php
require_once("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $taskId = $_POST["task_id"];

    try {
        $stmt = $conn->prepare("DELETE FROM todo WHERE task_id = :taskId");
        $stmt->bindParam(":taskId", $taskId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "Task deleted successfully";
        } else {
            echo "Error deleting task";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
