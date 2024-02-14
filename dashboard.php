<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                echo "Welcome, $loggedInUser!"; 
            } 
            ?>
            
            <h1>toto je dashboard</h1>
        </div>
    </div>
</body>
</html>