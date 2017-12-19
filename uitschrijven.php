<?php
include_once $_SERVER['DOCUMENT_ROOT']."/lib/mail/sql.php";

if(isset($_GET["token"])) {
    if ( empty($_GET["token"]) ) {
        $unsubscribeResult = FALSE;
    }
    else {
        $unsubscribeResult = unsubscribe($_GET["token"], $_GET["email"]);  
    }
}

if ( $unsubscribeResult === TRUE ) {
    echo "U bent uitgeschreven.";
}
else {
    echo "De link is niet geldig.";
}

