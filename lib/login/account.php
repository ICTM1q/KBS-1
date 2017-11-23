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

?>

