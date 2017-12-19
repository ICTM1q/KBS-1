<?php
if (!isset($SQL_AVAILABLE)) {
    require $_SERVER['DOCUMENT_ROOT'] . "/lib/account/sql.php";
}

function getFormEmails ( $type ) {
    $conn = new PDO ( "mysql:host=localhost;dbname=$dbname;", $user, $dbpassword);
    if ( $type === "Contact" ) {
        $stmt = $conn->prepare ( "SELECT email FROM receiver WHERE contact = 1" );
    }
    if ( $type === "Taxation" ) {
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
    $token = randString(10);
    $conn = connectToDatabase();
    $stmt = $conn->prepare ( "INSERT INTO mail_list ( email, token ) VALUES ( ?, ? )" );
    $stmt->execute ( array ( $email, $token ) );
}

function getAllMallist ( ) {
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
    $conn = connectToDatabase();
    $checkToken = getMaillistToken($conn, $email);
    if ( $token === $checkToken[0][0] ) {
        $stmt = $conn->prepare( "DELETE FROM mail_list WHERE token = ? AND email = ?");
        $stmt->execute ( array ( $token, $email ) );
    }
    else {

    }
}