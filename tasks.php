<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/header.css" />
    <link rel="stylesheet" href="CSS/tasks.css" />
    <title>Úlohy</title>
    <link rel="icon" href="IMG/logo2.png">
</head>
<body>
<?php
require_once("connect.php");
require_once("header.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["edit_task_id"])) {
        $edit_task_id = $_POST["edit_task_id"];
        $edit_task_name = $_POST["edit_task_name"];
        $edit_priority = isset($_POST["edit_priority"]) ? $_POST["edit_priority"] : null;
        $edit_description = isset($_POST["edit_description"]) ? $_POST["edit_description"] : null;

        try {
            $stmt = $conn->prepare("UPDATE todo SET task = ?, priority = ?, description = ? WHERE task_id = ?");
            $stmt->execute([$edit_task_name, $edit_priority, $edit_description, $edit_task_id]);
            header("Location: tasks.php");
        } catch (PDOException $e) {
            echo "Error updating task: " . $e->getMessage();
        }
    } elseif (isset($_POST["task_name"]) && !empty($_POST["task_name"])) {
        $task_name = $_POST["task_name"];
        $priority = isset($_POST["priority"]) ? $_POST["priority"] : null;
        $description = isset($_POST["description"]) ? $_POST["description"] : null;

        try {
            $stmt = $conn->prepare("INSERT INTO todo (task, priority, description) VALUES (?, ?, ?)");
            $stmt->execute([$task_name, $priority, $description]);
            header("Location: tasks.php");
        } catch (PDOException $e) {
            echo "Error adding task: " . $e->getMessage();
        }
    } else {
        echo "Meno úlohy nemôže byť prázdne.";
    }
}
?>



    <div class="home">
    <div class="text">
    <form method="post" action="" onsubmit="return validateForm()">
    <h2>Pridanie úlohy</h2>
    <label for="task_name">Úloha:</label>
    <input type="text" name="task_name" id="task_name">
    <p id="taskNameError" class="error-message"></p>

    <label for="priority">Priorita:</label>
    <select name="priority" id="priority">
        <option value="" disabled selected>Vyber si prioritu</option>
        <option value="Malá">Malá</option>
        <option value="Stredná">Stredná</option>
        <option value="Vysoká">Vysoká</option>
    </select>
    <p id="priorityError" class="error-message"></p>

    <label for="description">Popis:</label>
    <input type="text" name="description" id="description">
    <p id="descriptionError" class="error-message"></p>

    <button type="submit">Pridať úlohu</button>
</form>
<br>
<div class="task-container">
<?php
    try {
        $sql = "SELECT * FROM todo";
        $result = $conn->query($sql);

        if ($result->rowCount() > 0) {
            foreach ($result as $row) {
                echo "<div class='task-box' style='border-color: " . getPriorityColor($row['priority']) . "';>";
                echo "<h3>{$row['task']}</h3>";
                echo "<p><strong>Priorita:</strong> {$row['priority']}</p>";
                echo "<p><strong>Popis:</strong> {$row['description']}</p>";?><br><?php
                echo "<div class='task-buttons'>";
                echo "<button class='edit-btn' data-taskid='{$row['task_id']}'>Upraviť</button>";
                echo "<button class='delete-btn' data-taskid='{$row['task_id']}'>Vymazať</button>";
                echo "<button class='complete-btn' data-taskid='{$row['task_id']}'>Dokončiť</button>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>No tasks found.</p>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $result = null;

    function getPriorityColor($priority)
    {
        switch ($priority) {
            case 'Malá':
                return '#FE9900'; // Žltá pre nízku prioritu
            case 'Stredná':
                return '#0000FF'; // Modrá pre strednú prioritu
            case 'Vysoká':
                return '#FF0000'; // Červená pre vysokú prioritu
            default:
                return '#ccc'; // Predvolená farba
        }
    }
?>
    <div id="editTaskModal" class="modal">
    <div class="modal-content">
        <h2>Upraviť Úlohu</h2>
        <form id="editTaskForm" method="post" action="" onsubmit="return validateEditForm()">
            <input type="hidden" name="edit_task_id" id="editTaskId">
            <label for="editTaskName">Úloha:</label>
            <input type="text" name="edit_task_name" id="editTaskName">
            <p id="editTaskNameError" class="error-message"></p>

            <label for="editPriority">Priorita:</label>
            <select name="edit_priority" id="editPriority">
                <option value="Malá">Malá</option>
                <option value="Stredná">Stredná</option>
                <option value="Vysoká">Vysoká</option>
            </select>
            <p id="editPriorityError" class="error-message"></p>

            <label for="editDescription">Popis:</label>
            <input type="text" name="edit_description" id="editDescription">
            <p id="editDescriptionError" class="error-message"></p>

            <button type="submit" name="saveEditBtn" id="saveEditBtn">Uložiť zmeny</button>
        </form>
    </div>
</div>
  </div>
</div>

    <script src="tasks.js"></script> 
</body>
</html>
