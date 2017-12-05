<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "lib\account\account.php";
include "lib\account\sql.php";

// Variabelen leeg definieren.
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

<form class="form-horizontal" method="POST">
    <fieldset>
        <legend>Registreer gebruiker</legend>

        <!-- Text input-->
        <div class="form-group row">
            <label class="col-md-4 control-label" for="textinput">Gebruikersnaam:</label>
            <div class="col-md-4">
                <input id="createUsername" name="createUsername" type="text" value="<?php if ( isset( $_POST["createUsername"] ) ) { print $_POST["createUsername"]; } ?>" class="form-control input-md">
                <span class="error"><?php echo $createArray["usernameErr"];?></span>
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group row">
            <label class="col-md-4 control-label" for="password">Wachtwoord:</label>
            <div class="col-md-4">
                <input id="createPassword" name="createPassword" type="password" value="" class="form-control input-md">
                <span class="error"><?php echo $createArray["passwordErr"];?></span>
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group row">
            <label class="col-md-4 control-label" for="textinput">Email adres:</label>
            <div class="col-md-4">
                <input id="createEmail" name="createEmail" type="text" class="form-control input-md">
                <span class="error"><?php echo $createArray["emailErr"];?></span>
            </div>
        </div>

        <div class="form-group row">
            <div class="offset-4 col-md-4">
                <input class="btn btn-primary" type="submit" name="createuser">
            </div>
        </div>

        <!-- Kijk of het successvol is gedaan. -->
        <?php if ( stripos($createArray["result"], "aangemaakt") !== FALSE ) {
            echo "<span class='success'>"; echo $createArray["result"]; echo"</span>";
        }
        else {
            echo "<span class='error'>"; echo $createArray["result"]; echo"</span>";
        }
        ?>
    </fieldset>
</form>