<?php

function getFormEmails ( $type ) {
    include $_SERVER['DOCUMENT_ROOT'] . "/lib/config/sqlconfig.php";
    $conn = new PDO ( "mysql:host=localhost;dbname=$dbname;", $user, $dbpassword);
    if ( $type === "Contact" ) {
        $stmt = $conn->prepare ( "SELECT email FROM receiver WHERE contact = 1" );
    }
    if ( $type === "Taxatie" ) {
        $stmt = $conn->prepare ( "SELECT email FROM receiver WHERE taxation = 1" );
    }
    if ( $type === "Melding" ) {
        $stmt = $conn->prepare ( "SELECT email FROM receiver WHERE complaint = 1" );
    }
    $stmt->execute ( array ( ) );
    $row = $stmt->fetchAll();
    return $row;
}

function insertIntoMaillist ( $email ) {
    $insertArray["success"] = FALSE;
    $insertArray["emailErr"] = "";
    
    if (!isset($SQL_AVAILABLE)) {
        require $_SERVER['DOCUMENT_ROOT'] . "/lib/account/sql.php";
    }
    $token = randString(10);
    $conn = connectToDatabase();
    
    $stmt = $conn->prepare ( "SELECT email FROM mail_list WHERE email = ?" );
    $stmt->execute( array ( $email ) );
    $row = $stmt->fetch();
    if ( empty($email) ) {
        $insertArray["emailErr"] = "Voer A.U.B. een email adres in!";
        return $insertArray;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $insertArray["emailErr"] = "Email is ongeldig.";
        return $insertArray;
    }
    if ( $row[0] === $email ){
        $insertArray["emailErr"] = "Dit email adres bestaat al!";
        return $insertArray;
    }
    else {
        $stmt = $conn->prepare ( "INSERT INTO mail_list ( email, token ) VALUES ( ?, ? )" );
        if ( $stmt->execute ( array ( $email, $token ) ) ) {
            $insertArray["success"] = TRUE;
            return $insertArray;
        }
        else {
            return $insertArray;
        }
    }
}

function getAllMallist ( ) {
    if (!isset($SQL_AVAILABLE)) {
        require $_SERVER['DOCUMENT_ROOT'] . "/lib/account/sql.php";
    }
    $conn = connectToDatabase();
    $stmt = $conn->prepare ( "SELECT * FROM mail_list" );
    $stmt->execute();
    $row = $stmt->fetchAll();
    return $row;
}

function getMaillistToken ( $conn, $email) {
    $stmt = $conn->prepare ( "SELECT token FROM mail_list WHERE email = ?" );
    $stmt->execute ( array ( $email ) );
    $row = $stmt->fetchAll();
    return $row;
}

function unsubscribe ( $token, $email ) {
    if (!isset($SQL_AVAILABLE)) {
        require $_SERVER['DOCUMENT_ROOT'] . "/lib/account/sql.php";
    }
    $conn = connectToDatabase();
    $checkToken = getMaillistToken($conn, $email);
    if ( empty($checkToken) ) {
        return FALSE;
    }
    if ( $token === $checkToken[0][0] ) {
        $stmt = $conn->prepare( "DELETE FROM mail_list WHERE token = ? AND email = ?");
        if ( $stmt->execute ( array ( $token, $email ) ) ) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }
    else {

    }
}