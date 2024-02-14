<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="CSS/header.css">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="IMG/logo2.png" alt="logo">
                </span>

                <div class="text header-text">
                    <span class="name">Staff Nexus</span>
                    <span class="profession">Your connecting nexus</span>
                </div>
            </div>

            <i class='bx bx-chevron-right toggle '></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="dashboard.php">
                            <i class='bx bx-home icon'></i>
                            <span class="text nav-text">Domov</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="calendar.php">
                            <i class='bx bx-calendar icon'></i>
                            <span class="text nav-text">Kalendár</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="tasks.php">
                            <i class='bx bx-task icon'></i>
                            <span class="text nav-text">Úlohy</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="download.php">
                            <i class='bx bxs-download icon'></i>
                            <span class="text nav-text">Stiahnuť</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="bottom-content">
                <li class="">
                    <a href="index.php">
                        <i class='bx bx-log-out icon'></i>
                        <span class="text nav-text">Odhlásiť sa</span>
                    </a>
                </li>

                <li class="mode">
                    <div class="moon-sun">
                        <i class='bx bx-moon icon moon'></i>
                        <i class='bx bx-sun icon sun'></i>
                    </div>
                    <span class="mode-text text">Dark Mode</span>

                    <div class="toggle-switch">
                        <span class="switch"></span>
                    </div>
                </li>

            </div>
        </div>
    </nav>

    <script src="header.js"></script>

</body>
</html>
