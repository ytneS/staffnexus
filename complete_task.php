<?php
require_once("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $taskId = $_POST["task_id"];

    try {
        $selectQuery = "SELECT task, priority, description FROM todo WHERE task_id = ?";
        $stmtSelect = $conn->prepare($selectQuery);
        $stmtSelect->execute([$taskId]);
        $taskData = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        $insertQuery = "INSERT INTO completedtodo (task, priority, description) VALUES (?, ?, ?)";
        $stmtInsert = $conn->prepare($insertQuery);
        $stmtInsert->execute([$taskData["task"], $taskData["priority"], $taskData["description"]]);

        $deleteQuery = "DELETE FROM todo WHERE task_id = ?";
        $stmtDelete = $conn->prepare($deleteQuery);
        $stmtDelete->execute([$taskId]);

   
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
