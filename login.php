    <!DOCTYPE html>
    <!--
    To change this license header, choose License Headers in Project Properties.
    To change this template file, choose Tools | Templates
    and open the template in the editor.
    light-blue  #E0F4FB
    dark-blue   #4F73ED
    mid-blue    #05A8E1
    -->
    
    <?php
    
    session_start();
    include "lib\login\account.php";
    include "lib\login\sql.php";

    // Als tries leeg is vul hem op.
    if (empty($tries)) {
        $tries = getTries(getRealIpAddr());
    }

    // Variabelen leeg definieren.
    $loginArray = array();
    $loginArray["usernameErr"] = "";
    $loginArray["passwordErr"] = "";
    $loginArray["captchaErr"] = "";
    $loginArray["result"] = "";

    // Als het knopje ingedrukt is.
    if ( isset( $_POST["submit"] ) ) {
        // Als er 3 of meer login pogingen gedaan zijn.
        if ( $tries >= 3 ) {
            // Maak captcha aan.
            include_once "lib/securimage/securimage.php";
            $secureImage = new Securimage();

            // Roep loginCaptchaFunc aan.
            $loginArray = loginCaptchaFunc(trim( $_POST["loginUsername"] ), trim( $_POST["loginPassword"] ), $secureImage, $_POST["captcha_code"]);

            // Als het het ingevoerde wachtwoord en username klopt bind het username en de functie die bij deze user horen aan zijn sessie.
            // Hiermee kan de user bij zijn/haar dingen komen.
            if ( $loginArray["result"] === TRUE ) {
                $_SESSION["user"] = trim ( $_POST["loginUsername"] );
                $_SESSION["role"] = GetRole ( $_POST["loginUsername"] );
                deleteTries(getRealIpAddr());
                header( "Location: beheer.php" );
            }
            // Kijk of er een volledige poging gedaan is en of het wachtwoord niet klopt. Zo ja, voeg een poging toe aan de database.
            elseif ( $loginArray["try"] === TRUE ) {
                insertTry(getRealIpAddr());
            }
        }
        // Als er minder dan 3 pogingen gedaan zijn.
        else {
            // Roep loginFunc aan wat de ingevoerde informatie verwerkt.
            $loginArray = loginFunc ( trim($_POST["loginUsername"] ), trim($_POST["loginPassword"] ) );

            // Als het het ingevoerde wachtwoord en username klopt bind het username en de functie die bij deze user horen aan zijn sessie.
            // Hiermee kan de user bij zijn/haar dingen komen.
            if ( $loginArray["result"] === TRUE ) {
                $_SESSION["user"] = trim ( $_POST["loginUsername"] );
                $_SESSION["role"] = GetRole ( $_POST["loginUsername"] );
                deleteTries(getRealIpAddr());
                header( "Location: beheer.php" );
            }
            // Kijk of er een volledige poging gedaan is en of het wachtwoord niet klopt. Zo ja, voeg een poging toe aan de database.
            elseif ( $loginArray["try"] === TRUE ) {
                insertTry(getRealIpAddr());
            }
        }
    }

    // Update tries.
    $tries = getTries(getRealIpAddr());

    ?>

    <html>
        <head>
            <title>Huur en beheer</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" crossorigin="anonymous">
            <link rel="stylesheet" href="css/login.css">
        </head>
        <body>
            <div id="body"></div>
            <div id="lijnwit">
            <div id="lijnblauw">
            <div id="header">
                <div id="navbar">
                    <nav class="navbar navbar-expand-lg">
                        <a class="navbar-brand" href="home.php">LOGO</a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link" href="home.php">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="kantoor.php">Kantoor</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="aanbod.php">Aanbod</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="huurvoorwaarden.php">Huurvoorwaarden</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="inschrijven.php">Inschrijven</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="beheer.php">Beheer</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="contact.php">Contact</a>
                                </li>
                            </ul>
                            <a class="navbar-brand" href="home.php">LOGO</a>
                        </div>
                    </nav>      
                </div>
                <div id="tekst">
                    <h1 id="adminh1">Alleen geautoriseerde toegang!</h1>
                    <form method="POST">
                        Gebruikersnaam:<br>
                        <input type="text" name="loginUsername" value="<?php if ( isset ( $_POST["loginUsername"] ) ) { print $_POST["loginUsername"]; } ?>"
                        <span class="error"><?php echo $loginArray["usernameErr"];?></span><br>
                        Wachtwoord:<br>
                        <input type="password" name="loginPassword">
                        <span class="error"><?php echo $loginArray["passwordErr"];?></span>
                        <!-- Als iemand drie pogingen heeft gedaan krijgt hij/zij een captcha. De PHP code hieronder zorgt ervoor dat de captcha in beeld komt. -->
                        <?php 
                        if ( $tries >= 3 ) { 
                            echo "<br><img id='captcha' src='lib/securimage/securimage_show.php' alt='CAPTCHA Image' }; /> <br>";
                            echo "<a href='' onclick='document.getElementById('captcha').src = 'lib/securimage/securimage_show.php?' + Math.random(); return false'>[ Andere Afbeelding ]</a> <br>";
                            echo "<input type='text' name='captcha_code' size='10' maxlength='6' />";      
                        }
                        ?>
                        <span class="error"><?php echo $loginArray["captchaErr"];?></span><br>
                        <a id="wachtwoord" href="home.php">Wachtwoord vergeten <br></a>
                        <span class="error"><?php echo $loginArray["result"];?></span><br>
                        <input type="submit" value="Verstuur" name="submit" id="knop">
                    </form>
                </div>
                </div>
            </div>
            </div>
            <div id="bot"></div>
        </body>
    </html>
