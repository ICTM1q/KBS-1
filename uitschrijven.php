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
?>

<head>
    <link href="css/uitschrijven.css" rel="stylesheet">
</head>

<body>
    <div>
    <h1><?php ?></h1>
    <p>U wordt doorverwezen naar de home pagina.</p>
    </div>
    
    
</body>