<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/header.css" />
    <link rel="stylesheet" href="CSS/download.css" />
    <link rel="icon" href="IMG/logo2.png">
    <title>Stiahnuť</title>
</head>
<body>
    <?php 
        require_once("header.php");
    ?>
    <div class="home">
        <div class="text">
            <div class="text1">
            <h1>Stiahnite si teraz</h1>
            <p>Vitajte na stiahovacej stránke našej aplikácie na správu zamestnancov. Prosím, vyberte verziu pre váš operačný systém:</p>
            
            <div class="download-options">
                <div class="download-option">
                        <h2>Pre Windows</h2>
                        <a href="link-to-windows" class="download-button">Stiahnuť pre Windows</a>
                        <p>Postupujte podľa inštrukcií na inštaláciu pre Windows:</p><br>
                        <ol class="instructions">
                            <li>Kliknite na odkaz na stiahnutie pre Windows.</li>
                            <li>Stiahnite si súbor EXE.</li>
                            <li>Spustite inštalátor a postupujte podľa pokynov na obrazovke.</li>
                        </ol>
                    </div>

                    <div class="download-option">
                        <h2>Pre Android</h2>
                        <a href="link-to-android" class="download-button">Stiahnuť pre Android</a>
                        <p>Postupujte podľa inštrukcií na inštaláciu pre Android:</p><br>
                        <ol class="instructions">
                            <li>Kliknite na odkaz na stiahnutie pre Android.</li>
                            <li>Stiahnite si súbor APK.</li>
                            <li>Povoľte inštaláciu z neznámych zdrojov v nastaveniach zariadenia.</li>
                            <li>Otvorte súbor APK a dokončite inštaláciu.</li>
                        </ol>
                    </div>
                </div>
                <br>
                <p>Ak máte nejaké otázky alebo problémy, kontaktujte našu <br> technickú podporu na <a href="mailto:staffnexuss@gmail.com">staffnexuss@gmail.com</a></p>

                <p>Ďakujeme, že používate našu aplikáciu!</p>
            </div>
        </div>
    </div>
</body>
</html>
