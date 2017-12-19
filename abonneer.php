<?php

include_once $_SERVER['DOCUMENT_ROOT']."/lib/mail/mail.php";
<<<<<<< HEAD
$insertArray["success"] = FALSE;
$insertArray["emailErr"] = "";

=======
include 'navbar.php';
>>>>>>> 17f8b49e1a90ebd9e434e45fb82804b4f1469402
if ( isset( $_POST["submit"] ) ) {
    $insertArray = insertIntoMaillist($_POST["email"]);
}

?>
<head>
    <title>Huur en beheer</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link href="css/huurenbeheer.css" rel="stylesheet">
</head>    

<<<<<<< HEAD
<form method="post">
Email:<br>
<input type="text" name="email" value="<?php if ( isset ( $_POST["email"] ) ) { echo $_POST["email"]; } ?>">
<?php if ( !empty($insertArray["emailErr"]) ) {
    echo $insertArray["emailErr"];
}
if ( $insertArray["success"] === TRUE ) {
    echo "U bent succesvol toegevoegd aan ons abonnement systeem!";
}
if ( $insertArray["success"] === FALSE && empty($insertArray["emailErr"])) {
    echo "Er is iets misgegaan!";
}
?>

<input type="submit" value="Verstuur" name="submit" class="knop">

=======
<body>
    <div class="content">
        <h2 class="h3-tekst">Hier kunt u abonneren </h2>
        <h5>U krijgt een mailtje als er een nieuw huis beschikbaar is.</h5>
        <br>
        
        <form method="post">
            <span class="bold">Vul hier uw e-mail in om ingeschreven te worden</span><br>
        Email:<br>
        <input type="text" name="email" value="<?php if ( isset ( $_POST["email"] ) ) { echo $_POST["email"]; } ?>">
        <input type="submit" value="Verstuur" name="submit" class="knop"><br>
        <?php ?>
        
        <br><br>
        
        Als u uwzelf wilt uitschrijfen kunt u dat doen op de volgende pagina: <a href="uitschrijven.php" class="bold">Uitschrijven</a>
        <br><br>
    </div>
    
    <?php
        include 'footer.php';
    ?>
</body>
>>>>>>> 17f8b49e1a90ebd9e434e45fb82804b4f1469402
