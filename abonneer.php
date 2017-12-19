<?php

include_once $_SERVER['DOCUMENT_ROOT']."/lib/mail/mail.php";
include 'navbar.php';
if ( isset( $_POST["submit"] ) ) {
    insertIntoMaillist($_POST["email"]);
}

?>
<head>
    <title>Huur en beheer</title>
</head>    

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
