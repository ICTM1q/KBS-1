<?php

// Functie om login informatie te verwerken en terug te sturen. Je kan binnen PHP maar een ding returning vandaar dat het een associative array is die wordt gereturned. 
// Binnen deze functie wordt ook de functie aangeroepen die kijkt of het wachtwoord wat ingevoerd is klopt met de ingevoerde username.
function loginFunc ( $username, $password ) {
    // Alles leeg definieren.
    $loginArray["result"] = FALSE;
    $loginArray["try"] = FALSE;
    
    $loginUsernameFlag = TRUE;
    $loginPasswordFlag = TRUE;
    
    $loginArray["usernameErr"] = "";
    $loginArray["passwordErr"] = "";
    $loginArray["captchaErr"] = "";
    
   // Kijk of username leeg is.
    if ( empty ( $username ) ) {
        $loginArray["usernameErr"] = "Gebruikersnaam is vereist.";
        $loginUsernameFlag = FALSE;
    }
    // Kijk of password leeg is.
    if ( empty ( $password ) ) {
        $loginArray["passwordErr"] = "Wachtwoord is vereist.";
        $loginPasswordFlag = FALSE;
    }
    if ( $loginPasswordFlag === TRUE && $loginUsernameFlag === TRUE ) {
       $loginArray["result"] = isCorrectPassword( $username, $password );
       $loginArray["try"] = TRUE;
    }
    return $loginArray;
}

// Functie om login informatie te verwerken en terug te sturen als iemand een captcha moet maken. Je kan binnen PHP maar een ding returning vandaar dat het een associative array is die wordt gereturned. 
// Binnen deze functie wordt ook de functie aangeroepen die kijkt of het wachtwoord wat ingevoerd is klopt met de ingevoerde username.
function loginCaptchaFunc ( $username, $password, $secureImage, $captchaCode ) {
    // Alles leeg definieren.
    $loginArray["result"] = FALSE;
    $loginArray["try"] = FALSE;
    
    $loginUsernameFlag = TRUE;
    $loginPasswordFlag = TRUE;
    $loginCaptchaFlag = TRUE;
    
    $loginArray["usernameErr"] = "";
    $loginArray["passwordErr"] = "";
    $loginArray["captchaErr"] = "";
    
   // Kijk of username leeg is.
    if ( empty ( $username ) ) {
        $loginArray["usernameErr"] = "Gebruikersnaam is vereist.";
        $loginUsernameFlag = FALSE;
    }
    // Kijk of password leeg is.
    if ( empty ( $password ) ) {
        $loginArray["passwordErr"] = "Wachtwoord is vereist.";
        $loginPasswordFlag = FALSE;
    }
    // Kijk of captcha leeg is.
    if ( empty ( $captchaCode ) ) {
        $loginArray["captchaErr"] = "Captcha is vereist.";
        $loginCaptchaFlag = FALSE;
    }
    if ( $loginPasswordFlag === TRUE && $loginUsernameFlag === TRUE && $loginCaptchaFlag === TRUE ) {
        if ($secureImage->check($captchaCode) == FALSE) {
            $loginArray["captchaErr"] = "Captcha is fout!";
        }
        else {
            $loginArray["result"] = isCorrectPassword( $username, $password );
            $loginArray["try"] = TRUE;
        }
    }
    return $loginArray;
}

// Functie om create informatie te verwerken en terug te sturen. Je kan binnen PHP maar een ding returning vandaar dat het een associative array is die wordt gereturned. 
// Binnen deze functie wordt ook de functie aangeroepen om een account aan te maken. 
function createFunc ( $username, $password, $email ) {
    // Alles leeg definieren.
    $createArray["result"] = FALSE;
    
    $createUsernameFlag = TRUE;
    $createPasswordFlag = TRUE;
    $createEmailFlag = TRUE;
    
    $createArray["usernameErr"] = "";
    $createArray["passwordErr"] = "";
    $createArray["emailErr"] = "";
    
    // Kijk of username leeg is.
    if ( empty ( $_POST["createUsername"] ) ) {
        $createArray["usernameErr"] = "Gebruikersnaam is vereist.";
        $createUsernameFlag = FALSE;
    }
    // Kijk of password leeg is.
    if ( empty ($_POST["createPassword"] ) ) {
        $createArray["passwordErr"] = "Wachtwoord is vereist.";
        $createPasswordFlag = FALSE;
    }
    // Kijk of email leeg is.
    if ( empty ($_POST["createEmail"] ) ) {
        $createArray["emailErr"] = "Email is vereist.";
        $createPasswordFlag = FALSE;
    }
    // Als password, username en email allebij gevuld zijn, voer dit uit. 
    if ( $createPasswordFlag === TRUE && $createUsernameFlag === TRUE ) {
        $createArray["result"] = createUser( $username, $password, $email );
    }
    return $createArray;
}

// Kijk alle input na en maakt vervolgens een wachtwoord reset token aan.
function createToken ( $email, $secureImage, $captchaCode ) {
    include ("config.php");
    // Alles leeg definieren.
    $createTokenArray["emailErr"] = "";
    $createTokenArray["captchaErr"] = "";
    $createTokenArray["result"] = "";
    
    $createTokenEmailFlag = TRUE;
    $createTokenCaptchaFlag = TRUE;
    
    // Kijken of email leeg is.
    if ( empty ( $email ) ) {
        $createTokenArray["emailErr"] = "Email is vereist.";
        $createTokenEmailFlag = FALSE;
    }
    // Kijken of captcha leeg is.
    if ( empty ( $captchaCode ) ) {
        $createTokenArray["captchaErr"] = "Captcha is vereist.";
        $createTokenCaptchaFlag = FALSE;
    }

    // Als alles is ingevuld ga verder.
    if ( $createTokenEmailFlag === TRUE && $createTokenCaptchaFlag === TRUE ) {
        // Kijken of captcha goed is ingevuld.
        if ($secureImage->check($captchaCode) == FALSE) {
            $createTokenArray["captchaErr"] = "Captcha is fout!";
        }
        else {
            try {
                $conn = new PDO ( "mysql:host=localhost;dbname=kbs", $user );

                if ( getEmail ( $conn, $email ) == $email ) {
                    
                    // Eventuele oude token verwijderen.
                    deleteToken($conn, $email);

                    // Random token aanmaken.
                    $token = bin2hex(random_bytes(25));

                    // Toevoegen aan database.
                    insertToken($conn, $token, $email);

                    // DIT DIENT ALLEEN VOOR TESTEN MOMENTEEL! HIER HOORT EEN EMAIL TO TE STAAN IN PRODUCTIE!
                    print $token;
                }
                else {
                    $createTokenArray["result"] = "Email is ongeldig.";
                }
            }
            catch ( PDOException $e ) {
                return "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
        }
    }
    return $createTokenArray;
}

// Kijk na of de ingevoerde token klopt. Zo ja, reset het wachtwoord met de gegeven input.
function checkToken ( $token, $email, $password ) {
    include ("config.php");
    
    $resetArray["tokenErr"] = "";
    $resetArray["emailErr"] = "";
    $resetArray["passwordErr"] = "";
    $resetArray["result"] = "";
            
    $resetTokenFlag = TRUE;
    $resetEmailFlag = TRUE;
    $resetPasswordFlag = TRUE;
    
    // Kijken of code leeg is.
    if ( empty ( $token ) ) {
        $resetArray["tokenErr"] = "Code is vereist.";
        $resetTokenFlag = FALSE;
    }
    // Kijken of emai leeg is.
    if ( empty ( $email ) ) {
        $resetArray["emailErr"] = "Email is vereist.";
        $resetEmailFlag = FALSE;
    }
    // Kijken of password leeg is.
    if ( empty ( $password ) ) {
        $resetArray["passwordErr"] = "Wachtwoord is vereist.";
        $resetPasswordFlag = FALSE;
    }
    if ( $resetTokenFlag === TRUE && $resetEmailFlag === TRUE && $resetPasswordFlag === TRUE ) {
        try {
            $conn = new PDO ( "mysql:host=localhost;dbname=kbs", $user );
            
            // Kijken of ingevoerde token gelijk is aan taken in de database.
            if ( getToken ( $conn, $email ) == $token ) {
                // Nieuw wachtwoord in de database opnemen.
                newPassword($conn, $password, $email);
                $resetArray["result"] = "Wachtwoord successvol gereset.";
                // Token verwijderen.
                deleteToken($conn, $email);
            }
            else {
                $resetArray["result"] = "Code klopt niet of is niet geldig.";
            }
        }
        catch ( PDOException $e ) {
            return "Error!: " . $e->getMessage() . "<br/>";
            die();
        }    
    }
    return $resetArray;
}

?>

