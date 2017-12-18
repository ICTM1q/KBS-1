<?php

if (!isset($SQL_AVAILABLE)) {
    global $SQL_AVAILABLE;
    $SQL_AVAILABLE = true;

// Functie om te connecten met de database.
    function connectToDatabase() {
        include_once_once $_SERVER['DOCUMENT_ROOT']."/lib/config/sqlconfig.php";
        return new PDO ( "mysql:host=localhost;dbname=$dbname;", $user, $dbpassword);
    }

// Functie om ingevoerde wachtwoord to matchen met wat in de database staat.
    function isCorrectPassword ( $conn, $username, $password ) {
        // Salt opvragen en klaarmaken voor password hashing.
        $algo = 6;
        $rounds = 5000;
        $salt = getSalt( $conn, $username );
        $cryptsalt = '$' . $algo . '$rounds=' . $rounds . '$' . $salt;

        // Ingevoerde password matchen en kijken of hij klopt met wat in de databse staat.
        $hash = crypt( $password, $cryptsalt);
        $password = getPassword( $conn, $username );
        if ( $password == $hash ) {
            return TRUE;
        }
        else {
            return "Wachtwoord is fout.";
        }
    }

// Functie om username op te halen uit database. Kan gebruikt worden om te checken.
    function getUser ( $conn, $username ) {
        $stmt = $conn->prepare ( "SELECT username FROM user WHERE username LIKE ?" );
        $stmt->execute ( array ( $username ) );
        $row = $stmt->fetch();
        return $row[0];
    }

// Functie om email op te halen uit database. Kan gebruikt worden om te checken.
    function getEmail ( $conn, $email ) {
        $stmt = $conn->prepare ( "SELECT email FROM user WHERE email LIKE ?" );
        $stmt->execute ( array ( $email ) );
        $row = $stmt->fetch();
        return $row[0];
    }

// Functie om salt op te halen uit database.
    function getSalt ( $conn, $username ) {
        $stmt = $conn->prepare ( "SELECT salt FROM user WHERE username LIKE ?" );
        $stmt->execute ( array ( $username ) );
        $row = $stmt->fetch();
        return $row[0];
    }

// Functie om password hash op te halen uit database.
    function getPassword ( $conn, $username ) {
        $stmt = $conn->prepare ( "SELECT password FROM user WHERE username LIKE ?" );
        $stmt->execute ( array ( $username ) );
        $row = $stmt->fetch();
        return $row[0];
    }

// Functie om een random string aan te maken als salt.
    function randString ( $length ) {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz@#$&*";
        $size = strlen( $chars );
        $str = "";
        for( $i = 0; $i < $length; $i++ ) {
            $str = $str . $chars[ rand ( 0, $size - 1 ) ];
        }
        return $str;
    }

// Functie om gebruiker aan te maken.
    function createUser ( $conn, $username, $password, $email ) {
        // Kijken of gebruker al bestaat.
        if ( getUser ( $conn, $username ) == $username ) {
            return "Gebruikersnaam bestaat al.<br>";
        }
        // Kijken of email al bestaat.
        if ( getEmail ( $conn, $email ) == $email ) {
            return "Email is al gebruikt.";
        }
        else {
            // Salt genereren en klaarmaken voor opslaan in database.
            $salt = randString ( 16 );
            $algo = 6;
            $rounds = 5000;
            $cryptsalt = '$' . $algo . '$rounds=' . $rounds . '$' . $salt;

            // Password hash maken.
            $hash = crypt ( $password, $cryptsalt );

            // Informatie opslaan in database.
            $stmt = $conn->prepare (" SET FOREIGN_KEY_CHECKS=0" );
            $stmt->execute( array ( ) );
            $stmt = $conn->prepare ( "INSERT INTO receiver( email ) VALUES ( ? )");
            $stmt->execute( array ( $email ) );
            $stmt = $conn->prepare ( "INSERT INTO user(username, password, salt, role, email, create_date) VALUES (?, ?, ?, ?, ?, NOW())" );
            $stmt->execute( array ( $username, $hash, $salt, "Gebruiker", $email ) );
            $stmt = $conn->prepare (" SET FOREIGN_KEY_CHECKS=1 " );
            $stmt->execute( array ( ) );

            return $username . " aangemaakt." . "<br>";
        }
    }

// Rol van de user ophalen.
    function GetRole ( $username ) {
        try {
            $conn = connectToDatabase();
            $stmt = $conn->prepare ( "SELECT role FROM user WHERE username LIKE ?" );
            $stmt->execute ( array ( $username ) );
            $row = $stmt->fetch();
            return $row[0];
        }
        catch ( PDOException $e ) {
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/logs/errorlog.txt", date("Y-m-d H:i:s") . " - " . $_SESSION['error'] . "\r\n", FILE_APPEND);
            return;
        }
    }

// Functie om IP van gebruiker op te halen.
    function getRealIpAddr() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

// Functie om een foute inlog-poging te inserten. Hoort alleen gedaan te worden als alle input ingevoerd is en het wachtwoord fout is.
    function insertTry ( $ip ) {
        try {
            $conn = connectToDatabase();
            $stmt = $conn->prepare ( "INSERT INTO login_try(date, ip) VALUES(NOW(),?)");
            $stmt->execute ( array ( $ip ) );

        }
        catch ( PDOException $e ) {
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/logs/errorlog.txt", date("Y-m-d H:i:s") . " - " . $_SESSION['error'] . "\r\n", FILE_APPEND);
            return;
        }
    }

// Inlog-pogingen ophalen van specifiek IP.
    function getTries ( $ip ) {
        try {
            $conn = connectToDatabase();
            $stmt = $conn->prepare ( "SELECT count(ip) FROM login_try WHERE ip = ? AND date > DATE_SUB(NOW(), INTERVAL 24 HOUR)" );
            $stmt->execute ( array ( $ip ) );
            $row = $stmt->fetch();
            return $row[0];
        }
        catch ( PDOException $e ) {
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/logs/errorlog.txt", date("Y-m-d H:i:s") . " - " . $_SESSION['error'] . "\r\n", FILE_APPEND);
            return;
        }
    }

// Inloge-pogingen verwijderen van specifiek IP.
    function deleteTries ( $ip ) {
        try {
            $conn = connectToDatabase();
            $stmt = $conn->prepare ( "DELETE FROM login_try WHERE ip = ?" );
            $stmt->execute ( array ( $ip ) );
        }
        catch ( PDOException $e ) {
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/logs/errorlog.txt", date("Y-m-d H:i:s") . " - " . $_SESSION['error'] . "\r\n", FILE_APPEND);
            return;
        }
    }

    function deleteToken ( $conn, $email ) {
        $stmt = $conn->prepare ( "DELETE FROM reset_token WHERE email = ?" );
        $stmt->execute( array ( $email ) );
    }

    function newPassword ( $conn, $password, $email ) {
        $salt = randString ( 16 );
        $algo = 6;
        $rounds = 5000;
        $cryptsalt = '$' . $algo . '$rounds=' . $rounds . '$' . $salt;
        $hash = crypt ( $password, $cryptsalt );

        $stmt = $conn->prepare ( "UPDATE user SET password = ?, salt = ? WHERE email = ?");
        $stmt->execute ( array ( $hash, $salt, $email ) );
    }

    function getToken ( $conn, $email ) {
        $stmt = $conn->prepare ( "SELECT token FROM reset_token WHERE email LIKE ? AND date > DATE_SUB(NOW(), INTERVAL '00:30' HOUR_MINUTE)" );
        $stmt->execute ( array ( $email ) );
        $row = $stmt->fetch();
        return $row[0];
    }

    function insertToken ( $conn, $token, $email ) {
        $stmt = $conn->prepare ( "INSERT INTO reset_token ( email, token, date ) VALUES ( ?, ?, NOW() )");
        $stmt->execute ( array ( $email, $token ) );
    }
}

