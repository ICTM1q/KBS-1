<?php
session_start();
include "lib/fpdf/pdf.php";
require $_SERVER['DOCUMENT_ROOT']."/lib/mail/mail.php";

// Definier captchaError leeg.
$pdfHBComplaintArray["firstnameErr"] = "";
$pdfHBComplaintArray["lastnameErr"] = "";
$pdfHBComplaintArray["emailErr"] = "";
$pdfHBComplaintArray["telnoErr"] = "";
$pdfHBComplaintArray["complaintErr"] = "";
$pdfHBComplaintArray["captchaErr"] = "";
$pdfHBComplaintArray["result"] = "";
$pdfHBComplaintArray["complaint"] = "";


// Als het knopje ingedrukt is.
if ( isset( $_POST["submit"]) ) {
    include_once "lib/securimage/securimage.php";
    $secureImage = new Securimage();

    include "lib/upload/upload.php";
    $id = uploadFile();
    
    // Voer pdfFunc uit.
    $pdfHBComplaintArray = pdfHBComplaintFunc($_POST["firstname"], $_POST["insertion"], $_POST["surname"], $_POST["email"], $_POST["telno"], $_POST["street"], $_POST["city"], $_POST["houseno"], $_POST["zip"], $_POST["complaint"], $secureImage, $_POST["captchaCode"]);
    if ( $pdfHBComplaintArray["result"] === TRUE ) {
        if ($id == false) {
            $pdfHBComplaintArray["success"] = FALSE;
            $pdfHBComplaintArray["message"] = $UPLOAD_ERROR;
        } else {
            $pictures = getPictures($id);

            // Voor testing wanneer je geen mail win ontvangen zet comments bij sendComplaintMail en geen comments bij de ->Output() functie.
            //$pdfHBComplaintArray["pdf"]->Output();
            if ( sendComplaintMail ( $pdfHBComplaintArray["pdf"]->Output("meldingformulier.pdf", 'S'), "Melding", $_POST["firstname"], $_POST["surname"] ) ) {
                $pdfHBComplaintArray["success"] = TRUE;
                $pdfHBComplaintArray["message"] = "Wij hebben uw melding ontvangen en zullen hem zo spoedig mogelijk afhandelen!";
            }
            else {
                $pdfHBComplaintArray["success"] = FALSE;
                $pdfHBComplaintArray["message"] = "Er is een probleem opgetreden, probeer het later nogmaals.";
            }
        }
    }
    else {
        $pdfHBComplaintArray["success"] = FALSE;
        $pdfHBComplaintArray["message"] = "Er zijn errors opgetreden, los deze op en probeer het nogmaals.";
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
    <link href="../css/huurenbeheer.css" rel="stylesheet">
  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
     <div class="container">
       <a class="navbar-brand" href="index.php">
           <img src="../css//img/logo.jpg" width="160" height="90" class="d-inline-block align-top" alt=""></a>
       <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
       </button>
       <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="kantoor.php">Kantoor</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="aanbod.php">Aanbod</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="huurvoorwaarden.php">Huurvoorwaarden</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="inschrijven.php">Inschrijven</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="formulieren.php">Formulieren
                    <span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="beheer.php">Beheer</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact.php">Contact</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container">

      <div class="row">
        <div class="col-sm">
          <br>
          <h1>Meldingen</h1>
          <p>In dit veld hieronder kunt u meldingen naar ons doorsturen.</p>
          <?php
          if ( !empty($pdfHBComplaintArray["message"])) {
              if ( $pdfHBComplaintArray["success"] === TRUE ) {
                echo "<span class='success'>" . $pdfHBComplaintArray["message"] . "</span><br>";
              }
              else {
                echo "<span class='error'>" . $pdfHBComplaintArray["message"] . "</span><br>";
              }
          }
          ?>
        </div>
      </div>

      <div class="row">
        <div class="col-sm">
          <form id="Complaint-form" method="post" action="" role="form" enctype="multipart/form-data">

              <div class="Complaints"></div>


              <div class="controls">

                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="form_name">Voornaam*</label>
                              <input id="form_name" type="text" name="firstname" class="form-control" placeholder="Voornaam" value="<?php if ( isset ( $_POST["firstname"] ) ) { echo $_POST["firstname"]; } ?>">
                              <?php
                              if ( !empty($pdfHBComplaintArray["firstnameErr"])) {
                                echo "<span class='error'>" . $pdfHBComplaintArray["firstnameErr"] . "</span><br>";
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
                              if ( !empty($pdfHBComplaintArray["surnameErr"])) {
                                echo "<span class='error'>" . $pdfHBComplaintArray["surnameErr"] . "</span><br>";
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
                              if ( !empty($pdfHBComplaintArray["emailErr"])) {
                                echo "<span class='error'>" . $pdfHBComplaintArray["emailErr"] . "</span><br>";
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
                              if ( !empty($pdfHBComplaintArray["telnoErr"])) {
                                echo "<span class='error'>" . $pdfHBComplaintArray["telnoErr"] . "</span><br>";
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
                      if ( !empty($pdfHBComplaintArray["streetErr"])) {
                        echo "<span class='error'>" . $pdfHBComplaintArray["streetErr"] . "</span><br>";
                      }
                      ?>
                    </div>
                     <div class="form-group col-md-6">
                       <label for="inputCity">Plaatsnaam*</label>
                       <input type="text" class="form-control" name="city" id="inputCity" placeholder="Plaatsnaam" value="<?php if ( isset ( $_POST["city"] ) ) { echo $_POST["city"]; } ?>">
                       <?php
                       if ( !empty($pdfHBComplaintArray["cityErr"])) {
                        echo "<span class='error'>" . $pdfHBComplaintArray["cityErr"] . "</span><br>";
                       }
                       ?>
                     </div>
                     <div class="form-group col-md-6">
                       <label for="inputZip">Huisnummer*</label>
                       <input type="text" class="form-control" name="houseno" id="inputZip" placeholder="Huisnummer" value="<?php if ( isset ( $_POST["houseno"] ) ) { echo $_POST["houseno"]; } ?>">
                       <?php
                       if ( !empty($pdfHBComplaintArray["housenoErr"])) {
                         echo "<span class='error'>" . $pdfHBComplaintArray["housenoErr"] . "</span><br>";
                       }
                       ?>
                     </div>
                     <div class="form-group col-md-6">
                       <label for="inputZip">Postcode*</label>
                       <input type="text" class="form-control" name="zip" id="inputZip" placeholder="Postcode" value="<?php if ( isset ( $_POST["zip"] ) ) { echo $_POST["zip"]; } ?>">
                       <?php
                       if ( !empty($pdfHBComplaintArray["zipErr"])) {
                         echo "<span class='error'>" . $pdfHBComplaintArray["zipErr"] . "</span><br>";
                       }
                       ?>
                     </div>
                   </div>
                  <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label for="form_message">Bericht*</label>
                              <textarea id="form_message" name="complaint" class="form-control" placeholder="Melding" rows="4"><?php if ( isset ( $_POST["complaint"] ) ) { echo $_POST["complaint"]; } ?></textarea>
                              <?php
                              if ( !empty($pdfHBComplaintArray["complaintErr"])) {
                                echo "<span class='error'>" . $pdfHBComplaintArray["complaintErr"] . "</span><br>";
                              }
                              ?>
                              <div class="help-block with-errors"></div>
                          </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Fotos invoegen</label>
                            <input id='upload' name="upload[]" type="file" multiple="multiple">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <img id="captcha" src="../lib/securimage/securimage_show.php" alt="CAPTCHA Image" /><br>
                        <a href="#" onclick="document.getElementById('captcha').src = '../lib/securimage/securimage_show.php?' + Math.random(); return false">[ Andere Afbeelding ]</a><br>
                        <input type="text" name="captchaCode" size="10" maxlength="6" /><span class="error">  <?php echo $pdfHBComplaintArray["captchaErr"]; ?><span><br><br>
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
              </div>
            </div>
          </div>
   <footer class="py-5 footer-custom">
     <div class="container">
       <div class="row ">
          <div class="col vastgoed-img">
              <h3>Certificaten</h3>
                <a href="https://www.vastgoedpro.nl/"><img src="../css/img/vgp.jpg" alt=""></a>
                <br>
                <br>
                <a href="https://www.vastgoedcert.nl/"><img src="../css/img/vastgoedcert.jpg" alt=""></a>
                <br>
                <br>
            </div>
            <div class="col">
              <h3>KVK/BTW</h3>
              <ul class="ulfooter">
                <li>KvK: 05059210</li>
                <li>BTW nr.: 810305628</li>
              </ul>
            </div>
            <div class="col">
              <h3>Adres</h3>
                  <ul class="ulfooter"><li>Oudestraat 172</li>
                  <li>8261 CW Kampen</li>
                  <li>Tel.: 038-33 88 341</li>
                  <li>info@hoksbergen.nl</li></ul>
            </div>
            <div class="col">
              <h3>Locatie</h3>
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2425.5411569166!2d5.9132473156257745!3d52.559824241029794!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c87883431521b5%3A0x9589572588a7b0f1!2sHoksbergen+Makelaardij+V.O.F.!5e0!3m2!1snl!2snl!4v1511426183418" width="400" height="200" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
          </div>
          <br>
         <div class="row">
           <div class="col-sm-12 col-md-12 text-center">
             <span>Hoksbergen Makelaardij &copy; 2017 </span>
             <div class="blank-gap-10"></div>
             <p><p>
             </div>
         </div>
    </div>
   </footer>


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
