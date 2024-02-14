<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="CSS/index.css" />
    <link rel="icon" href="IMG/logo2.png">
    <title>Prihlásenie</title>
  </head>

<body>
    <?php
        require_once("connect.php");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['registerbtn'])) {  
                $username = $_POST['username']; 
                $email = $_POST['email'];
                $password = $_POST['password'];
            
                // Kontrola, či e-mail už existuje
                $checkEmailQuery = "SELECT * FROM users WHERE email='$email'";
                $result = $conn->query($checkEmailQuery);
            
                if ($result->num_rows > 0) {
                    echo "<script>
                            document.getElementById('email').classList.add('error');
                            document.getElementById('email-error').innerText = 'Tento e-mail sa už používa. Prosím, zvoľte iný e-mail.';
                          </script>";
                } else {
                    // E-mail nie je v databáze, môžeme pokračovať s registráciou
                    $hashedPassword = hash('sha256', $password);
            
                    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";
                    $isInserted = $conn->query($sql);
            
                    if ($isInserted) {
                        header("Location: index.php");     
                        exit();                             
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                }
            }
            else if(isset($_POST['loginbtn'])) {
                $lgEmail = $_POST['email-2'];
                $lgPassword = $_POST['password-2'];
                $rememberMe = isset($_POST['checkbox']);
                $loginError = false;

                $hashedPassword = hash('sha256', $lgPassword);

                $sql = "SELECT * FROM users WHERE email='$lgEmail' AND password='$hashedPassword'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    session_start(); 
                    $row = $result->fetch_assoc();
                    $_SESSION['username'] = $row['username'];

                    if ($rememberMe) {
                        setcookie('remember_email', $lgEmail, time() + (86400 * 30), "/"); // 30 days
                        setcookie('remember_password', $lgPassword, time() + (86400 * 30), "/"); // 30 days
                    } else {
                        setcookie('remember_email', '', time() - 3600, "/");
                        setcookie('remember_password', '', time() - 3600, "/");
                    }

                    header("Location: dashboard.php"); 
                    exit();
                }
                else {
                    $loginError = true;
                }
            }
        }

    ?>
    <div class="container" id="container">
        <div class="form-container register-container">
            <form method="post">
                <h1>Zaregistruj sa</h1>
                <div class="form-control">
                    <input type="text" id="username" name="username" placeholder="Meno" />
                    <small id="username-error"></small>
                    <span></span>
                </div>
                <div class="form-control">
                    <input type="text" id="email" name="email" placeholder="Email" />
                    <small id="email-error"></small>
                    <span></span>
                </div>
                <div class="form-control">
                    <input type="password" id="password" name="password" placeholder="Heslo" />
                    <i class="toggle-password fas fa-eye" onclick="togglePasswordVisibility()"></i>
                    <small id="password-error"></small>
                    <span></span>
                </div>
                    <button type="submit" name="registerbtn" value="submit">Zaregistrovať</button>
            </form>
        </div>
        <div class="form-container login-container">
            <form method="post" class="form-lg">
                <h1>Prihlás sa</h1>
                <div class="form-control2">
                    <input type="text" name="email-2" class="email-2" placeholder="Email">
                    <small class="email-error-2"><?php echo (isset($loginError) && $loginError) ? "*Nesprávne meno alebo heslo." : ""; ?></small>
                    <span></span>
                </div>
                <div class="form-control2">
                    <input type="password" name="password-2" class="password-2" placeholder="Heslo">
                    <small class="password-error-2"><?php echo (isset($loginError) && $loginError) ? "*Nesprávne meno alebo heslo." : ""; ?></small>
                    <span></span>
                </div>

                <div class="content">
                    <div class="checkbox">
                        <input type="checkbox" name ="checkbox" id="checkbox" />
                        <label for="">Zapamätaj si ma</label>
                    </div>
                    <div class="pass-link">
                        <a href="forgot_password.php">Zabudnuté heslo?</a>
                    </div>
                </div>
                <button type="submit" name="loginbtn" value="submit">Prihlásiť</button>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1 class="title">
                        Vitajte <br />
                        užívatelia
                    </h1>
                    <p>Ak už vlastníte účet, prihláste sa tu</p>
                    <button class="ghost" id="login">
                        Prihlásiť
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                </div>

                <div class="overlay-panel overlay-right">
                    <h1 class="title">
                        Začnite svoju <br />
                        cestu teraz
                    </h1>
                    <p>Ak ešte nemáte účet, pridajte sa k nám a zaregistrujte sa</p>
                    <button class="ghost" id="register">
                        Zaregistrovať
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>        
    </div>
<script src="main.js"></script> 
</body>

</html>
