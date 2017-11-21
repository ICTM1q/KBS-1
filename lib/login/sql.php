<?php

// Functie om ingevoerde wachtwoord to matchen met wat in de database staat. 
function isCorrectPassword ( $username, $password ) {
    include "config.php";
    try {
        $conn = new PDO ( "mysql:host=localhost;dbname=kbs", $user );
    
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
    catch ( PDOException $e ) {
        return "Error!: " . $e->getMessage() . "<br/>";
        die();
    
    }   
}

// Functie om username op te halen uit database. Kan gebruikt worden om te checken.
function getUser ( $conn, $username ) {
    $stmt = $conn->prepare ( "SELECT username FROM user WHERE username LIKE ?" );
    $stmt->execute ( array ( $username ) );
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
function createUser ( $username, $password, $email ) {
    include "config.php";
    
    try {
        $conn = new PDO ( "mysql:host=localhost;dbname=kbs", $user );
    
        // Kijken of gebruker al bestaat.
        if ( getUser ( $conn, $username ) == $username ) {
            return "Gebruikersnaam bestaat al.<br>";
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
            $stmt = $conn->prepare ( "INSERT INTO user(username, password, salt, role, email, create_date) VALUES (?, ?, ?, ?, ?, NOW())" );
            $stmt->execute( array ( $username, $hash, $salt, "Gebruiker", $email ) );
        
            return $username . " aangemaakt." . "<br>";
        }      
    }
    catch ( PDOException $e ) {
        return "Error!: " . $e->getMessage() . "<br/>";
        die();
    }   
}

// Rol van de user ophalen.
function GetRole ( $username ) {
    include "config.php";
    try {
        $conn = new PDO ( "mysql:host=localhost;dbname=kbs", $user );
        $stmt = $conn->prepare ( "SELECT role FROM user WHERE username LIKE ?" );
        $stmt->execute ( array ( $username ) );
        $row = $stmt->fetch();
        return $row[0];
    }
    catch ( PDOException $e ) {
        return "Error!: " . $e->getMessage() . "<br/>";
        die();
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
    include "config.php";
    try {
        $conn = new PDO ( "mysql:host=localhost;dbname=kbs", $user );
        $stmt = $conn->prepare ( "INSERT INTO login_try(date, ip) VALUES(NOW(),?)");
        $stmt->execute ( array ( $ip ) );
        
    }
    catch ( PDOException $e ) {
        return "Error!: " . $e->getMessage() . "<br/>";
        die();
    }   
}

// Inlog-pogingen ophalen van specifiek IP.
function getTries ( $ip ) {
    include "config.php";
    
    try {
        $conn = new PDO ( "mysql:host=localhost;dbname=kbs", $user );
        $stmt = $conn->prepare ( "SELECT count(ip) FROM login_try WHERE ip = ? AND date > DATE_SUB(NOW(), INTERVAL 24 HOUR)" );
        $stmt->execute ( array ( $ip ) );
        $row = $stmt->fetch();
        return $row[0];
    }
    catch ( PDOException $e ) {
        return "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}

// Inloge-pogingen verwijderen van specifiek IP. 
function deleteTries ( $ip ) {
    include "config.php";
    
    try {
        $conn = new PDO ( "mysql:host=localhost;dbname=kbs", $user );
        $stmt = $conn->prepare ( "DELETE FROM login_ty WHERE ip = ?" );
        $stmt->execute ( array ( $ip ) );
    }
    catch ( PDOException $e ) {
        return "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}

