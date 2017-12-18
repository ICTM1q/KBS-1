<?php
session_start();
include "lib/fpdf/pdf.php";
require $_SERVER['DOCUMENT_ROOT']."/lib/mail/mail.php";

// Definier captchaError leeg.
$pdfHBContactArray["firstnameErr"] = "";
$pdfHBContactArray["lastnameErr"] = "";
$pdfHBContactArray["emailErr"] = "";
$pdfHBContactArray["telnoErr"] = "";
$pdfHBContactArray["messageErr"] = "";
$pdfHBContactArray["captchaErr"] = "";
$pdfHBContactArray["result"] = "";
$pdfHBContactArray["message"] = "";

// Als het knopje ingedrukt is.
if ( isset( $_POST["submit"] ) ) {
    include_once "lib/securimage/securimage.php";
    $secureImage = new Securimage();
    
    // Voer pdfFunc uit.
    $pdfHBContactArray = pdfHBContactFunc($_POST["firstname"], $_POST["insertion"], $_POST["surname"], $_POST["email"], $_POST["telno"], $_POST["street"], $_POST["city"], $_POST["houseno"], $_POST["zip"], $_POST["message"], $secureImage, $_POST["captchaCode"]);
    if ( $pdfHBContactArray["result"] === TRUE ) {
        // Voor testing wanneer je geen mail win ontvangen zet comments bij sendContactMail en geen comments bij de ->Output() functie.
        //$pdfHBContactArray["pdf"]->Output();
        $pdfHBContactArray["success"] = sendContactMail ( $pdfHBContactArray["pdf"]->Output("contactformulier.pdf", 'S'), "Contact", $_POST["firstname"], $_POST["surname"]);
        if ( $pdfHBContactArray["success"] === TRUE ) {
            $pdfHBContactArray["message"] = "Wij hebben uw melding ontvangen en zullen hem zo spoedig mogelijk afhandelen!";
        }
        if ( $pdfHBContactArray["success"] === "EMPTY" ) {
            $pdfHBContactArray["message"] = "Er is momenteel niemand bereikbaar, probeer het later nogmaals.";
        }
        if ( $pdfHBContactArray["success"]  === FALSE ) {
            $pdfHBContactArray["message"] = "Er is een probleem opgetreden, probeer het later nogmaals.";
        }
    }
    else {
        $pdfHBContactArray["success"] = FALSE;
        $pdfHBContactArray["message"] = "Er zijn errors opgetreden, los deze op en probeer het nogmaals.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Huur en beheer</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link href="css/huurenbeheer.css" rel="stylesheet">
  </head>

  <body>

    <!-- Navigation -->
    <?php
    include 'navbar.php';
    ?>

    <!-- Page Content -->
    <div class="content">

      <div class="row">
        <div class="col-sm">
          <br>
          <h1>Contacteer ons hieronder</h1>
          <p>In dit veld hieronder kunt u met ons contact maken.</p>
          <?php
          if ( !empty($pdfHBContactArray["message"])) {
              if ( $pdfHBContactArray["success"] === TRUE ) {
                echo "<span class='success'>" . $pdfHBContactArray["message"] . "</span><br>";
              }
              else {
                echo "<span class='error'>" . $pdfHBContactArray["message"] . "</span><br>";
              }
          }
          ?>
        </div>
      </div>

      <div class="row">
        <div class="col-sm">
          <form id="Contact-form" method="post">

              <div class="messages"></div>

              <div class="controls">

                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="form_name">Voornaam*</label>
                              <input id="form_name" type="text" name="firstname" class="form-control" placeholder="Voornaam" value="<?php if ( isset ( $_POST["firstname"] ) ) { echo $_POST["firstname"]; } ?>">
                              <?php
                              if ( !empty($pdfHBContactArray["firstnameErr"])) {
                                echo "<span class='error'>" . $pdfHBContactArray["firstnameErr"] . "</span><br>";
                              }
                              ?>
                              <div class="help-block with-errors"></div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="form_name">Tussenvoegsel</label>
                              <input id="form_name" type="text" name="insertion" class="form-control" placeholder="Tussenvoegsel" value="<?php if ( isset ( $_POST["insertion"] ) ) { echo $_POST["insertion"]; } ?>">
                              <div class="help-block with-errors"></div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="form_lastname">Achternaam*</label>
                              <input id="form_lastname" type="text" name="surname" class="form-control" placeholder="Achternaam" value="<?php if ( isset ( $_POST["surname"] ) ) { echo $_POST["surname"]; } ?>">
                              <?php
                              if ( !empty($pdfHBContactArray["surnameErr"])) {
                                echo "<span class='error'>" . $pdfHBContactArray["surnameErr"] . "</span><br>";
                              }
                              ?>
                              <div class="help-block with-errors"></div>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="form_email">Email adres*</label>
                              <input id="form_email" type="text" name="email" class="form-control" placeholder="Email adres" value="<?php if ( isset ( $_POST["email"] ) ) { echo $_POST["email"]; } ?>">
                              <?php
                              if ( !empty($pdfHBContactArray["emailErr"])) {
                                echo "<span class='error'>" . $pdfHBContactArray["emailErr"] . "</span><br>";
                              }
                              ?>
                              <div class="help-block with-errors"></div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="form_phone">Telefoonnummer*</label>
                              <input id="form_phone" type="text" name="telno" class="form-control" placeholder="Telefoonnummer" value="<?php if ( isset ( $_POST["telno"] ) ) { echo $_POST["telno"]; } ?>">
                              <?php
                              if ( !empty($pdfHBContactArray["telnoErr"])) {
                                echo "<span class='error'>" . $pdfHBContactArray["telnoErr"] . "</span><br>";
                              }
                              ?>
                              <div class="help-block with-errors"></div>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label for="inputCity">Straatnaam*</label>
                      <input type="text" class="form-control" name="street" id="inputCity" placeholder="Straatnaam" value="<?php if ( isset ( $_POST["street"] ) ) { echo $_POST["street"]; } ?>">
                      <?php
                      if ( !empty($pdfHBContactArray["streetErr"])) {
                        echo "<span class='error'>" . $pdfHBContactArray["streetErr"] . "</span><br>";
                      }
                      ?>
                    </div>
                     <div class="form-group col-md-6">
                       <label for="inputCity">Plaatsnaam*</label>
                       <input type="text" class="form-control" name="city" id="inputCity" placeholder="Plaatsnaam" value="<?php if ( isset ( $_POST["city"] ) ) { echo $_POST["city"]; } ?>">
                       <?php
                       if ( !empty($pdfHBContactArray["cityErr"])) {
                        echo "<span class='error'>" . $pdfHBContactArray["cityErr"] . "</span><br>";
                       }
                       ?>
                     </div>
                     <div class="form-group col-md-6">
                       <label for="inputZip">Huisnummer*</label>
                       <input type="text" class="form-control" name="houseno" id="inputZip" placeholder="Huisnummer" value="<?php if ( isset ( $_POST["houseno"] ) ) { echo $_POST["houseno"]; } ?>">
                       <?php
                       if ( !empty($pdfHBContactArray["housenoErr"])) {
                         echo "<span class='error'>" . $pdfHBContactArray["housenoErr"] . "</span><br>";
                       }
                       ?>
                     </div>
                     <div class="form-group col-md-6">
                       <label for="inputZip">Postcode*</label>
                       <input type="text" class="form-control" name="zip" id="inputZip" placeholder="Postcode" value="<?php if ( isset ( $_POST["zip"] ) ) { echo $_POST["zip"]; } ?>">
                       <?php
                       if ( !empty($pdfHBContactArray["zipErr"])) {
                         echo "<span class='error'>" . $pdfHBContactArray["zipErr"] . "</span><br>";
                       }
                       ?>
                     </div>
                   </div>
                  <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label for="form_message">Bericht*</label>
                              <textarea id="form_message" name="message" class="form-control" placeholder="Bericht" rows="4"><?php if ( isset ( $_POST["message"] ) ) { echo $_POST["message"]; } ?></textarea>
                              <?php
                              if ( !empty($pdfHBContactArray["messageErr"])) {
                                echo "<span class='error'>" . $pdfHBContactArray["messageErr"] . "</span><br>";
                              }
                              ?>
                              <div class="help-block with-errors"></div>
                          </div>
                      </div>
                      <div class="col-md-12">
                        <img id="captcha" src="../lib/securimage/securimage_show.php" alt="CAPTCHA Image" /><br>
                        <a href="#" onclick="document.getElementById('captcha').src = '../lib/securimage/securimage_show.php?' + Math.random(); return false">[ Andere Afbeelding ]</a><br>
                        <input type="text" name="captchaCode" size="10" maxlength="6" /><span class="error">  <?php echo $pdfHBContactArray["captchaErr"]; ?><span><br><br>
                      </div>
                      <br>
                      <br>
                      <div class="col-md-12">
                          <input type="submit" class="btn btn-success btn-send" name="submit" value="Verzend bericht">
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12">
                        <br>
                          <p class="text-muted">Velden met een * zijn verplicht. </p>
                      </div>
                  </div>
              </div>

          </form>

        </div>
      </div>

      <div class="row">
        <div class="col-sm">
          <center>
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2425.5411569166!2d5.9132473156257745!3d52.559824241029794!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c87883431521b5%3A0x9589572588a7b0f1!2sHoksbergen+Makelaardij+V.O.F.!5e0!3m2!1snl!2snl!4v1511431328721" width="1125" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
        </center>
        </div>
      </div>
      <br>
    </div>
    <br>

    <?php
        include 'footer.php';
    ?>
    
    <!-- Bootstrap core JavaScript -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script>
        $('.carousel').carousel({
            interval: 5000
        })
    </script>
  </body>
</html>
