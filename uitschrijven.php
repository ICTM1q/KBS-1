<?php
include_once $_SERVER['DOCUMENT_ROOT']."/lib/mail/sql.php";
$unsubscribeResult = "";
if(isset($_GET["token"])) {
    if ( empty($_GET["token"]) ) {
        $unsubscribeResult = FALSE;
    }
    else {
        $unsubscribeResult = unsubscribe($_GET["token"], $_GET["email"]);  
    }
}
?>

<head>
    <link href="css/uitschrijven.css" rel="stylesheet">
    <meta http-equiv="refresh" content="5;url=index.php" />
</head>

<body>
    <div>
        <h1><?php   if ( $unsubscribeResult === TRUE ) {
                        echo "U bent uitgeschreven.";
                        }
                    else {
                        echo "De link is niet geldig.";
                    }
        ?></h1>
    <p>U wordt over 5 seconden doorverwezen naar de home pagina.</p>
    </div>
    
    
</body>