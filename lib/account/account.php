<?php


// Functie om login informatie te verwerken en terug te sturen. Je kan binnen PHP maar een ding returning vandaar dat het een associative array is die wordt gereturned. 
// Binnen deze functie wordt ook de functie aangeroepen die kijkt of het wachtwoord wat ingevoerd is klopt met de ingevoerde username.
function loginFunc ( $username, $password ) {
    include_once $_SERVER['DOCUMENT_ROOT']."/lib/config/sqlconfig.php";

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
        try {
            $conn = new PDO ( "mysql:host=localhost;dbname=$dbname;", $user, $dbpassword);
            
            $loginArray["result"] = isCorrectPassword( $conn, $username, $password );
            $loginArray["try"] = TRUE;
        }
        catch ( PDOException $e ) {
            $loginArray["result"] =  "Er is een fout opgetreden, probeer het later nogmaals.";
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/logs/errorlog.txt", date("Y-m-d H:i:s") . " - " . $_SESSION['error'] . "\r\n", FILE_APPEND);
            return $loginArray;
        }  
    }
    return $loginArray;
}

// Functie om login informatie te verwerken en terug te sturen als iemand een captcha moet maken. Je kan binnen PHP maar een ding returning vandaar dat het een associative array is die wordt gereturned. 
// Binnen deze functie wordt ook de functie aangeroepen die kijkt of het wachtwoord wat ingevoerd is klopt met de ingevoerde username.
function loginCaptchaFunc ( $username, $password, $secureImage, $captchaCode ) {
    include_once $_SERVER['DOCUMENT_ROOT']."/lib/config/sqlconfig.php";

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
            try {
                $conn = new PDO ( "mysql:host=localhost;dbname=$dbname;", $user, $dbpassword );
                
                $loginArray["result"] = isCorrectPassword( $conn, $username, $password );
                $loginArray["try"] = TRUE;
            }
            catch ( PDOException $e ) {
                $loginArray["result"] =  "Er is een fout opgetreden, probeer het later nogmaals.";
                file_put_contents($_SERVER['DOCUMENT_ROOT']."/logs/errorlog.txt", date("Y-m-d H:i:s") . " - " . $_SESSION['error'] . "\r\n", FILE_APPEND);
                return $loginArray;
            }  
        }
    }
    return $loginArray;
}

// Functie om create informatie te verwerken en terug te sturen. Je kan binnen PHP maar een ding returning vandaar dat het een associative array is die wordt gereturned. 
// Binnen deze functie wordt ook de functie aangeroepen om een account aan te maken. 
function createFunc ( $username, $password, $email ) {
    include_once $_SERVER['DOCUMENT_ROOT']."/lib/config/sqlconfig.php";

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
        $createEmailFlag = FALSE;
    }
    // Als password, username en email allebij gevuld zijn, voer dit uit. 
    if ( $createPasswordFlag === TRUE && $createUsernameFlag === TRUE && $createEmailFlag = TRUE ) {
        // Kijk of email geldig is.
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $createArray["result"] = "Email is ongeldig.";
        }
        else {
            try {
                $conn = new PDO ( "mysql:host=localhost;dbname=$dbname;", $user, $dbpassword );
            
                $createArray["result"] = createUser( $conn, $username, $password, $email );
            }
            catch ( PDOException $e ) {
                $createArray["result"] =  "Er is een fout opgetreden, probeer het later nogmaals.";
                file_put_contents($_SERVER['DOCUMENT_ROOT']."/logs/errorlog.txt", date("Y-m-d H:i:s") . " - " . $_SESSION['error'] . "\r\n", FILE_APPEND);
                return $createArray;
            }   
        }
    }
    return $createArray;
}

// Kijk alle input na en maakt vervolgens een wachtwoord reset token aan.
function createToken ( $email, $secureImage, $captchaCode ) {
    include_once $_SERVER['DOCUMENT_ROOT']."/lib/mail/mail.php";
    include_once $_SERVER['DOCUMENT_ROOT']."/lib/config/sqlconfig.php";

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
                $conn = new PDO ( "mysql:host=localhost;dbname=$dbname;", $user, $dbpassword );

                if ( getEmail ( $conn, $email ) == $email ) {
                    
                    // Eventuele oude token verwijderen.
                    deleteToken($conn, $email);
                    echo gettype($email);
                    // Random token aanmaken.
                    $token = bin2hex(random_bytes(25));
                    echo gettype($token);

                    // Toevoegen aan database.
                    insertToken($conn, $token, $email);

                    // Emailt stuuren naar gebruiker met de code.
                    if (sendTokenMail($token, $email) ) {
                        $createTokenArray["result"] = "Een code is opgestuurd naar " . $email;
                    }
                    else {
                        $createTokenArray["result"] = "Er is een probleem met het verstuuren van de code, probeer het nogmaals.";
                    }
                }
                else {
                    $createTokenArray["result"] = "Email is ongeldig.";
                }
            }
            catch ( PDOException $e ) {
                $createTokenArray["result"] =  "Er is een fout opgetreden, probeer het later nogmaals.";
                file_put_contents($_SERVER['DOCUMENT_ROOT']."/logs/errorlog.txt", date("Y-m-d H:i:s") . " - " . $_SESSION['error'] . "\r\n", FILE_APPEND);
                return $createTokenArray;
            }
        }
    }
    return $createTokenArray;
}

// Kijk na of de ingevoerde token klopt. Zo ja, reset het wachtwoord met de gegeven input.
function checkToken ( $token, $email, $password1, $password2 ) {
    include_once $_SERVER['DOCUMENT_ROOT']."/lib/config/sqlconfig.php";
    
    $resetArray["tokenErr"] = "";
    $resetArray["emailErr"] = "";
    $resetArray["passwordErr1"] = "";
    $resetArray["passwordErr2"] = "";
    $resetArray["result"] = "";
            
    $resetTokenFlag = TRUE;
    $resetEmailFlag = TRUE;
    $resetPasswordFlag1 = TRUE;
    $resetPasswordFlag2 = TRUE;
    
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
    if ( empty ( $password1 ) ) {
        $resetArray["passwordErr1"] = "Wachtwoord is vereist.";
        $resetPasswordFlag1 = FALSE;
    }
    if ( empty ( $password2 ) ) {
        $resetArray["passwordErr2"] = "Wachtwoord is vereist.";
        $resetPasswordFlag2 = FALSE;
    }
    if ( $resetTokenFlag === TRUE && $resetEmailFlag === TRUE && $resetPasswordFlag1 === TRUE && $resetPasswordFlag2 === TRUE ) {
        // Kijken of bevestiging wachtwoord overeenkomt.
        if ( $password1 === $password2 ) {
            try {
                $conn = new PDO ( "mysql:host=localhost;dbname=$dbname;", $user, $dbpassword );

                // Kijken of ingevoerde token gelijk is aan taken in de database.
                if ( getToken ( $conn, $email ) == $token ) {
                    // Nieuw wachtwoord in de database opnemen.
                    newPassword($conn, $password1, $email);
                    $resetArray["result"] = "Wachtwoord successvol gereset.";
                    // Token verwijderen.
                    deleteToken($conn, $email);
                }
                else {
                    $resetArray["result"] = "Code klopt niet of is niet geldig.";
                }
            }
            catch ( PDOException $e ) {
                $resetArray["result"] =  "Er is een fout opgetreden, probeer het later nogmaals.";
                file_put_contents($_SERVER['DOCUMENT_ROOT']."/logs/errorlog.txt", date("Y-m-d H:i:s") . " - " . $_SESSION['error'] . "\r\n", FILE_APPEND);
                return $resetArray;
            }   
        }
        else {
            $resetArray["result"] = "Wachtwoorden komen niet overeen.";
        }
 
    }
    return $resetArray;
}

?>

