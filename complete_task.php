<?php
require_once("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $taskId = $_POST["task_id"];

    try {
        // Získání údajů o úkolu
        $selectQuery = "SELECT task, priority, description FROM todo WHERE task_id = ?";
        $stmtSelect = $conn->prepare($selectQuery);
        $stmtSelect->execute([$taskId]);
        $taskData = $stmtSelect->fetch(PDO::FETCH_ASSOC);
        $stmtSelect->closeCursor();

        // Přidání úkolu do completedtodo
        $insertQuery = "INSERT INTO completedtodo (task, priority, description) VALUES (?, ?, ?)";
        $stmtInsert = $conn->prepare($insertQuery);
        $stmtInsert->execute([$taskData["task"], $taskData["priority"], $taskData["description"]]);

        // Úkol byl úspěšně přesunut do completedtodo, nyní jej odstraňte z todo
        $deleteQuery = "DELETE FROM todo WHERE task_id = ?";
        $stmtDelete = $conn->prepare($deleteQuery);
        $stmtDelete->execute([$taskId]);

        echo "Task completed successfully";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
