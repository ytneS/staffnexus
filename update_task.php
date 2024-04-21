<?php
require_once("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $taskId = $_POST["task_id"];
    $taskName = $_POST["task_name"];
    $priority = $_POST["priority"];
    $description = $_POST["description"];

    try {
        $conn->beginTransaction();

        $stmt = $conn->prepare("UPDATE todo SET task = ?, priority = ?, description = ? WHERE task_id = ?");
        $stmt->bindParam(1, $taskName);
        $stmt->bindParam(2, $priority);
        $stmt->bindParam(3, $description);
        $stmt->bindParam(4, $taskId);

        if ($stmt->execute()) {
            $conn->commit();
            echo "Uloha bola úspešne aktualizovaná";
        } else {
            $conn->rollBack();
            echo "Chyba pri aktualizovanii úlohy";
        }
    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Chyba pri aktualizovanii úlohy: " . $e->getMessage();
    } finally {
        $conn = null; 
    }
}
?>
