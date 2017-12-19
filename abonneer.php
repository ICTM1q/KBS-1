<?php
include 'navbar.php';
include_once $_SERVER['DOCUMENT_ROOT']."/lib/mail/mail.php";
$insertArray["success"] = FALSE;
$insertArray["emailErr"] = "";

if ( isset( $_POST["submit"] ) ) {
    $insertArray = insertIntoMaillist($_POST["email"]);
}

?>
<head>
    <title>Huur en beheer</title>
    <link href="css/huurenbeheer.css" rel="stylesheet"
</head>    
<body>
    <div class="content">
        <h1 class="h3-tekst">Hier kunt u abonneren!</h1>
        <h5>U krijgt een mailtje als er een nieuwe woning wordt toegevoegd.</h5><br>
        
        <form method="post">
        <span class="bold">Vul hieronder uw email in om u in te schrijven.</span><br>
            Email:<br>
            <input type="text" name="email" value="<?php if ( isset ( $_POST["email"] ) ) { echo $_POST["email"]; } ?>">
                <?php 
                    if ( !empty($insertArray["emailErr"]) ) {
                        echo $insertArray["emailErr"];
                    }
                    if ( $insertArray["success"] === TRUE ) {
                        echo "U bent succesvol toegevoegd aan ons abonnement systeem!";
                    }
                    if ( $insertArray["success"] === FALSE && empty($insertArray["emailErr"])) {
                        echo "Er is iets misgegaan!";
                    }
                ?>
            <input type="submit" value="Verstuur" name="submit" class="knop"><br>
                <?php echo 'error code hier';?>
            
            <br><br>
            
            <p> Als u geen mailtjes meer wilt ontvangen, kunt u uwzelf uitschrijven doormiddel van de link in de e-mail </p>
    </div>
<?php
include 'footer.php';
?>
</body>