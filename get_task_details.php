<?php

require_once("connect.php");

if (isset($_GET["task_id"])) {
    $taskId = $_GET["task_id"];

    try {
        $pdo = new PDO("mysql:host={$host};dbname={$database}", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT * FROM todo WHERE task_id = ?");
        $stmt->bindParam(1, $taskId, PDO::PARAM_INT);
        $stmt->execute();

        $taskDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($taskDetails) {
            echo json_encode($taskDetails);
        } else {
            echo json_encode(["error" => "Task not found"]);
        }

    } catch (PDOException $e) {
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    } finally {
        $pdo = null;
    }
}
?>
