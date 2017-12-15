<?php

function getFormEmails ( $type ) {
    if ( $type === "Contact" ) {
        include $_SERVER['DOCUMENT_ROOT']."/lib/config/sqlconfig.php";
        $conn = new PDO ( "mysql:host=localhost;dbname=$dbname;", $user, $dbpassword);
        $stmt = $conn->prepare ( "SELECT email FROM receiver WHERE contact = 1" );
        $stmt->execute ( array ( ) );
        $row = $stmt->fetch();
        return $row;
    }
    if ( $type === "Taxation" ) {
        include $_SERVER['DOCUMENT_ROOT']."/lib/config/sqlconfig.php";
        $conn = new PDO ( "mysql:host=localhost;dbname=$dbname;", $user, $dbpassword);
        $stmt = $conn->prepare ( "SELECT email FROM receiver WHERE taxation = 1" );
        $stmt->execute ( array ( ) );
        $row = $stmt->fetch();
        return $row; 
    }
    if ( $type === "Melding" ) {
        include $_SERVER['DOCUMENT_ROOT']."/lib/config/sqlconfig.php";
        $conn = new PDO ( "mysql:host=localhost;dbname=$dbname;", $user, $dbpassword);
        $stmt = $conn->prepare ( "SELECT email FROM receiver WHERE complaint = 1" );
        $stmt->execute ( array ( ) );
        $row = $stmt->fetch();
        return $row;
    }
}
