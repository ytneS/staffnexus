<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zabudnuté heslo</title>
    <link rel="stylesheet" href="CSS/forgot_password.css">
    <link rel="icon" href="IMG/logo2.png">
</head>

<body>
<?php
require_once("connect.php");
require_once("PHPMailer.php");
require_once("SMTP.php");
require_once("Exception.php");

if (isset($_POST['resetbtn'])) {
    $email = $_POST['email'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Generate a random password reset token
        $token = bin2hex(random_bytes(3));

        $hashedPassword = hash('sha256', $token);

        // Update the user's record with the reset token
        $updateSql = "UPDATE users SET password='$hashedPassword' WHERE email='$email'";
        $conn->query($updateSql);

        // Send a password reset email to the user using PHPMailer
        $mail = new PHPMailer\PHPMailer\PHPMailer;

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true; // Set this to true
        $mail->Username = 'staffnexuss@gmail.com'; // Replace with your Gmail email address
        $mail->Password = 'ffsb lbiu txvg csxk'; // Replace with your Gmail password
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('staffnexuss@gmail.com', 'Staff Nexus');
        $mail->addAddress($email);

        $mail->Subject = 'Resetovanie hesla';
        $mail->Body = "Vaše heslo bolo resetované na: $token";

        if (!$mail->send()) {
            echo "<script>
                setTimeout(function() {
                    window.alert('Chyba pri posielaní mailu: " . $mail->ErrorInfo . "');
                }, 100);
              </script>";
        } else {
            echo "<script>
                setTimeout(function() {
                    window.alert('Email na obnovenie hesla bol odoslaný. Prosím, skontrolujte si svoj email pre ďalšie pokyny.');
                }, 100);
                var formSubmitted = true; // Set the variable to true when the form is submitted
              </script>";
        }
    } else {
        echo "<script>
            setTimeout(function() {
                window.alert('Email nebol nájdený v databáze.');
            }, 100);
          </script>";
    }
}
?>



    <div class="container">
        <div class="form-container reset-container">
            <form method="post">
                <h1>Zabudnuté heslo</h1>
                <div class="form-control">
                    <input type="text" id="email" name="email" placeholder="Zadaj svoj email">
                    <small id="email-error"></small>
                    <span></span>
                </div>
                <br>
                <button type="submit" name="resetbtn">Resetovať</button>
            </form>
            
            <!-- Change the button to an anchor tag for "Back to Login" -->
            <div class="form-container reset-container with-back-link">
    <!-- ... existing code ... -->
        <a href="login.php" class="back-link">vrátiť sa späť</a>
        </div>
        </div>
        
    </div>
    <script src="forgot.js"></script> 
</body>
</html>
