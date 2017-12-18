<?php

function getFormEmails ( $type ) {
    if ( $type === "Contact" ) {
        include_once $_SERVER['DOCUMENT_ROOT']."/lib/config/sqlconfig.php";
        $conn = new PDO ( "mysql:host=localhost;dbname=$dbname;", $user, $dbpassword);
        $stmt = $conn->prepare ( "SELECT email FROM receiver WHERE contact = 1" );
        $stmt->execute ( array ( ) );
        $row = $stmt->fetchAll();
        return $row;
    }
    if ( $type === "Taxation" ) {
        include_once $_SERVER['DOCUMENT_ROOT']."/lib/config/sqlconfig.php";
        $conn = new PDO ( "mysql:host=localhost;dbname=$dbname;", $user, $dbpassword);
        $stmt = $conn->prepare ( "SELECT email FROM receiver WHERE taxation = 1" );
        $stmt->execute ( array ( ) );
        $row = $stmt->fetchAll();
        return $row;
    }
    if ( $type === "Melding" ) {
        include_once $_SERVER['DOCUMENT_ROOT']."/lib/config/sqlconfig.php";
        $conn = new PDO ( "mysql:host=localhost;dbname=$dbname;", $user, $dbpassword);
        $stmt = $conn->prepare ( "SELECT email FROM receiver WHERE complaint = 1" );
        $stmt->execute ( array ( ) );
        $row = $stmt->fetchAll();
        return $row;
    }
}

function insertIntoMaillist ( $email ) {
    if (!isset($SQL_AVAILABLE)) {
        require $_SERVER['DOCUMENT_ROOT'] . "/lib/account/sql.php";
    }
    $token = randString(10);
    $conn = connectToDatabase();
    $stmt = $conn->prepare ( "INSERT INTO mail_list ( email, token ) VALUES ( ?, ? )" );
    $stmt->execute ( array ( $email, $token ) );
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
    if ( $token === $checkToken[0][0] ) {
        $stmt = $conn->prepare( "DELETE FROM mail_list WHERE token = ? AND email = ?");
        $stmt->execute ( array ( $token, $email ) );
    }
    else {

    }
}