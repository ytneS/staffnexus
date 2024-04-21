<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Domovská stránka</title>
    <link rel="icon" href="IMG/logo2.png">
    <link rel="stylesheet" href="CSS/header.css" />
    <link rel="stylesheet" href="CSS/dashboard.css" />
</head>
<body>
    <?php require_once("header.php"); ?>
    <div class="home">
        <div class="text">
            <?php 
            session_start(); 
            if (isset($_SESSION['username'])) {
                $loggedInUser = $_SESSION['username'];
                ?><h1 class="greeting">Vitajte, <?php echo $loggedInUser; ?>!</h1><?php
            } 
            ?>
            
            <?php
            require_once("connect.php");

            try {
                $totalTasksQuery = "SELECT COUNT(*) AS totalTasks FROM todo";
                $totalTasksResult = $conn->query($totalTasksQuery);
                $totalTasksRow = $totalTasksResult->fetch(PDO::FETCH_ASSOC);
                $totalTasks = $totalTasksRow['totalTasks'];

                $completedTasksQuery = "SELECT COUNT(*) AS completedTasks FROM completedtodo";
                $completedTasksResult = $conn->query($completedTasksQuery);
                $completedTasksRow = $completedTasksResult->fetch(PDO::FETCH_ASSOC);
                $completedTasks = $completedTasksRow['completedTasks'];
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }

            $conn = null;
            ?>

            <div class="dashboard-section">
                <div class="dashboard-box">
                    <h2>Nedokončené úlohy</h2>
                    <img src="IMG/necom.png">
                    <p><?php echo "$totalTasks úloh"; ?></p>
                </div>

                <div class="dashboard-box">
                    <h2>Dokončené úlohy</h2>
                    <img src="IMG/com.png">
                    <p><?php echo "$completedTasks úloh"; ?></p>
                </div>
            </div>
    </div>
</body>
</html>
