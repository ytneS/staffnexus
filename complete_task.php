<?php
require_once("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $taskId = $_POST["task_id"];

    // Získání údajů o úkolu
    $stmtSelect = $conn->prepare("SELECT task, priority, description FROM todo WHERE task_id = ?");
    $stmtSelect->bind_param("i", $taskId);
    $stmtSelect->execute();
    $stmtSelect->bind_result($task, $priority, $description);
    $stmtSelect->fetch();
    $stmtSelect->close();

    // Přidání úkolu do completedtodo
    $stmtInsert = $conn->prepare("INSERT INTO completedtodo (task, priority, description) VALUES (?, ?, ?)");
    $stmtInsert->bind_param("sss", $task, $priority, $description);
    
    if ($stmtInsert->execute()) {
        // Úkol byl úspěšně přesunut do completedtodo, nyní jej odstraňte z todo
        $stmtDelete = $conn->prepare("DELETE FROM todo WHERE task_id = ?");
        $stmtDelete->bind_param("i", $taskId);
        
        if ($stmtDelete->execute()) {
            echo "Task completed successfully";
        } else {
            echo "Error deleting task from todo: " . $stmtDelete->error;
        }

        $stmtDelete->close();
    } else {
        echo "Error completing task: " . $stmtInsert->error;
    }

    $stmtInsert->close();
}
?>