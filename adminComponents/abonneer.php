<?php

include $_SERVER['DOCUMENT_ROOT']."/lib/mail/mail.php";

if ( isset( $_POST["submit"] ) ) {
    insertIntoMaillist($_POST["email"]);
}

?>

<form method="post">
Email:<br>
<input type="text" name="email" value="<?php if ( isset ( $_POST["email"] ) ) { echo $_POST["email"]; } ?>">
<input type="submit" value="Verstuur" name="submit" class="knop">

