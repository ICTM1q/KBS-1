<?php

include_once $_SERVER['DOCUMENT_ROOT']."/lib/mail/mail.php";
$insertArray["success"] = FALSE;
$insertArray["emailErr"] = "";

if ( isset( $_POST["submit"] ) ) {
    $insertArray = insertIntoMaillist($_POST["email"]);
}

?>
<head>
    <title>Huur en beheer</title>
</head>

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

