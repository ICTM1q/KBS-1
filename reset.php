<?php
// Session voor captcha.
session_start();
include ("lib/account/sql.php");
include ("lib/account/account.php");

$createTokenArray["emailErr"] = "";
$createTokenArray["captchaErr"] = "";
$createTokenArray["result"] = "";

if (isset($_POST["createToken"])) {
    include_once "lib/securimage/securimage.php";
    $secureImage = new Securimage();
    
    $createTokenArray = createToken ( trim($_POST["email"]), $secureImage, trim($_POST["captchaCode"]));
}

$resetArray["tokenErr"] = "";
$resetArray["emailErr"] = "";
$resetArray["passwordErr1"] = "";
$resetArray["passwordErr2"] = "";
$resetArray["result"] = "";

if (isset($_POST["reset"])) {
    $resetArray = checkToken ( trim($_POST["resetToken"]), trim($_POST["resetEmail"]), trim($_POST["resetPassword1"]), trim($_POST["resetPassword2"]) );
}
?>
        <head>
            <title>Huur en beheer</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" crossorigin="anonymous">
            <link rel="stylesheet" href="css/resetpage.css">
        </head>
        <body>
                <div class="tekst">
                    <h1 class="adminh1">Wachtwoord resetten</h1>
                    <div class="forms">
                        Stap 1: Vraag een code aan om je<br> wachtwoord te kunnen resetten.
                        <form method="POST">
                            Email:<br>
                            <input type="text" name="email" value=<?php if ( isset ( $_POST["email"] ) ) { echo $_POST["email"]; } ?>><br>
                            <span> Captcha: </span>
                            <span class="error"><?php echo $createTokenArray["emailErr"];?></span><br>
                            <img id="captcha" class="img" src="lib/securimage/securimage_show.php" alt="CAPTCHA Image"/><br>
                            <a class="ondertekst" href="#" onclick="document.getElementById('captcha').src = 'lib/securimage/securimage_show.php?' + Math.random(); return false">[ Andere Afbeelding ]</a><br>
                            <input type="text" name="captchaCode" size="10" maxlength="6" />
                            <span class="error"><?php echo $createTokenArray["captchaErr"];?></span><br>
                            <input type="submit" value="Verstuur" name="createToken" id="knop">
                            <?php if ( stripos($createTokenArray["result"], "Een code is opgestuurd naar") !== FALSE ) {
                                echo "<span class='success'>"; echo $createTokenArray["result"]; echo"</span>";
                            }
                            else {
                                echo "<span class='error'>"; echo $createTokenArray["result"]; echo"</span>";
                            }
                            ?>
                            <!--<span class="error"><?php echo $createTokenArray["result"];?></span>-->
                        </form>
                    </div>
                    <div class="captcha">
                        Stap 2: Gebruik de code om <br>je wachtwoord te resetten. 

                <form method="POST">
                    Code:<br>
                    <input type="text" name="resetToken">
                    <span class="error"><?php echo $resetArray["tokenErr"];?></span><br>
                    Email:<br>
                    <input type="text" name="resetEmail">
                    <span class="error"><?php echo $resetArray["emailErr"];?></span><br>
                    Nieuw wachtwoord:<br>
                    <input type="password" name="resetPassword1">
                    <span class="error"><?php echo $resetArray["passwordErr1"];?></span><br>
                    Wachtwoord bevestigen:<br>
                    <input type="password" name="resetPassword2">
                    <span class="error"><?php echo $resetArray["passwordErr2"];?></span><br>
                    <input type="submit" value="Verstuur" name="reset" id="knop">
                    <!-- Kijk of het successvol is gedaan. -->
                    <?php if ( $resetArray["result"] == "Wachtwoord successvol gereset." ) {
                        echo "<span class='success'>"; echo $resetArray["result"]; echo"</span>";
                    }
                    else {
                        echo "<span class='error'>"; echo $resetArray["result"]; echo"</span>";
                    }
                    ?>
                </form>
</div>
                </div>