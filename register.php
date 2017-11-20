<?php
session_start();
include "lib\login\account.php";
include "lib\login\sql.php";

// Variabelen leeg definieren.
$createArray = array();
$createArray["usernameErr"] = "";
$createArray["passwordErr"] = "";
$createArray["emailErr"] = "";
$createArray["result"] = "";

// Als het knopje ingedrukt is.
if ( isset ( $_POST["createuser"] ) ) {
    
    // Voer alles door aan createFunc en step de uitkomst in create. Daarna wordt alles uitgeprint in de form.
    $createArray = createFunc ( trim($_POST["createUsername"] ), trim($_POST["createPassword"]), trim($_POST["createEmail"]) );
}
?>

Create <br>
<form method="POST" action=""> 
    Username: <input type="text" name="createUsername" value="<?php if ( isset( $_POST["createUsername"] ) ) { print $_POST["createUsername"]; } ?>">
    <span class="error"><?php echo $createArray["usernameErr"];?></span><br>
    Password: <input type="password" name="createPassword">
    <span class="error"><?php echo $createArray["passwordErr"];?></span><br>
    Email: <input type="text" name="createEmail">
    <span class="error"><?php echo $createArray["emailErr"];?></span><br>
    <input type="submit" name="createuser" value="Query"><br>
    <span class="result"><?php echo $createArray["result"];?></span>  
</form>

<p><a href="index.php">Index</a></p>