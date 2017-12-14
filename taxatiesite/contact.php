<?php
session_start();
include "pdf-taxatie.php";
require $_SERVER['DOCUMENT_ROOT']."../lib/mail/mail.php";

// Definier captchaError leeg.
$pdfHTContactArray["firstnameErr"] = "";
$pdfHTContactArray["lastnameErr"] = "";
$pdfHTContactArray["emailErr"] = "";
$pdfHTContactArray["telnoErr"] = "";
$pdfHTContactArray["messageErr"] = "";
$pdfHTContactArray["captchaErr"] = "";
$pdfHTContactArray["result"] = "";
$pdfHTContactArray["message"] = "";

// Als het knopje ingedrukt is.
if ( isset( $_POST["submit"] ) ){ 
    include_once "lib/securimage/securimage.php";
    $secureImage = new Securimage();
    
    // Voer pdfFunc uit.
    $pdfHTContactArray = pdfHTContactFunc($_POST["firstname"], $_POST["insertion"], $_POST["surname"], $_POST["email"], $_POST["telno"], $_POST["street"], $_POST["city"], $_POST["houseno"], $_POST["zip"], $_POST["message"], $secureImage, $_POST["captchaCode"]);
    if ( $pdfHTContactArray["result"] === TRUE ) {
        // Voor testing wanneer je geen mail win ontvangen zet comments bij sendContactMail en geen comments bij de ->Output() functie.
        $pdfHTContactArray["pdf"]->Output();
        /*if ( sendContactMail ( $pdfHTContactArray["pdf"]->Output("contactformulier.pdf", 'S'), "Contact", $_POST["firstname"], $_POST["surname"] ) ) {
            $pdfHTContactArray["success"] = TRUE;
            $pdfHTContactArray["message"] = "Wij hebben uw contactverzoek ontvangen en zullen hem zo spoedig mogelijk afhandelen!";
        }
        else {
            $pdfHTContactArray["success"] = FALSE;
            $pdfHTContactArray["message"] = "Er is een probleem opgetreden, probeer het later nogmaals.";
        }*/
    }
    else {
        $pdfHTContactArray["success"] = FALSE;
        $pdfHTContactArray["message"] = "Er zijn errors opgetreden, los deze op en probeer het nogmaals.";
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

    <title>Taxatie</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet">
  </head>

  <body>

    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
     <div class="container">
       <a class="navbar-brand" href="index.php">
    <img src="img/hoksbergen.gif" width="160" height="90" class="d-inline-block align-top" alt=""></a>
       <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon fa fa-bars"></span>
       </button>
       <div class="collapse navbar-collapse" id="navbarResponsive">
         <ul class="navbar-nav ml-auto">
           <li class="nav-item">
             <a class="nav-link" href="index.php">Home
             </a>
           </li>
           <li class="nav-item">
             <a class="nav-link" href="taxatie.php">Taxatie</a>
           </li>
           <li class="nav-item">
             <a class="nav-link" href="onskantoor.php">Ons kantoor</a>
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
         <h1>Contacteer ons hieronder</h1>
         <p>In dit veld hieronder kunt u met ons contact maken.</p>
       </div>
     </div>

     <div class="row">
       <div class="col-sm">
         <form id="contact-form" method="post" action="contact.php" role="form">

             <div class="messages"></div>

             <div class="controls">

                 <div class="row">
                     <div class="col-md-6">
                         <div class="form-group">
                             <label for="form_name">Voornaam*</label>
                             <input id="form_name" type="text" name="name" class="form-control" placeholder="Voornaam" required="required" data-error="Voornaam is verplicht.">
                             <?php
                             if ( !empty($pdfHTContactArray["firstnameErr"])) {
                                echo "<span class='error'>" . $pdfHTContactArray["firstnameErr"] . "</span><br>";
                             ?>
                             <div class="help-block with-errors"></div>
                         </div>
                     </div>
                     <div class="col-md-6">
                         <div class="form-group">
                             <label for="form_lastname">Achternaam*</label>
                             <input id="form_lastname" type="text" name="surname" class="form-control" placeholder="Achternaam" required="required" data-error="Achternaam is verplicht">
                             <?php
                              if ( !empty($pdfHTContactArray["surnameErr"])) {
                                echo "<span class='error'>" . $pdfHTContactArray["surnameErr"] . "</span><br>";
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
                             <input id="form_email" type="email" name="email" class="form-control" placeholder="Email adres" required="required" data-error="Een geldige email is verplicht">
                             <?php
                              if ( !empty($pdfHTContactArray["emailErr"])) {
                                echo "<span class='error'>" . $pdfHTContactArray["emailErr"] . "</span><br>";
                              }
                              ?>
                             <div class="help-block with-errors"></div>
                         </div>
                     </div>
                     <div class="col-md-6">
                         <div class="form-group">
                             <label for="form_phone">Telefoonnummer*</label>
                             <input id="form_phone" type="tel" name="phone" class="form-control" placeholder="Telefoonnummer">
                             <?php
                              if ( !empty($pdfHTContactArray["telnoErr"])) {
                                echo "<span class='error'>" . $pdfHTContactArray["telnoErr"] . "</span><br>";
                              }
                              ?>
                             <div class="help-block with-errors"></div>
                         </div>
                     </div>
                 </div>
                 <div class="row">
                   <div class="form-group col-md-6">
                     <label for="inputCity">Straatnaam*</label>
                     <input type="text" class="form-control" id="inputCity" placeholder="Straatnaam">
                   <?php
                      if ( !empty($pdfHTContactArray["streetErr"])) {
                        echo "<span class='error'>" . $pdfHTContactArray["streetErr"] . "</span><br>";
                      }
                      ?>
                   </div>
                     
                    <div class="form-group col-md-6">
                      <label for="inputCity">Plaatsnaam*</label>
                      <input type="text" class="form-control" id="inputCity" placeholder="Plaatsnaam">
                    <?php
                       if ( !empty($pdfHTContactArray["cityErr"])) {
                        echo "<span class='error'>" . $pdfHTContactArray["cityErr"] . "</span><br>";
                       }
                       ?>
                    </div>
                     
                    <div class="form-group col-md-6">
                      <label for="inputZip">Huisnummer*</label>
                      <input type="text" class="form-control" id="inputZip" placeholder="Huisnummer">
                    <?php
                       if ( !empty($pdfHTContactArray["housenoErr"])) {
                         echo "<span class='error'>" . $pdfHTContactArray["housenoErr"] . "</span><br>";
                       }
                       ?>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="inputZip">Postcode*</label>
                      <input type="text" class="form-control" id="inputZip" placeholder="Postcode">
                     <?php
                       if ( !empty($pdfHTContactArray["zipErr"])) {
                         echo "<span class='error'>" . $pdfHTContactArray["zipErr"] . "</span><br>";
                       }
                       ?>
                    </div>
                  </div>
                 <div class="row">
                     <div class="col-md-12">
                         <div class="form-group">
                             <label for="form_message">Bericht*</label>
                             <textarea id="form_message" name="message" class="form-control" placeholder="Bericht" rows="4" required="required" data-error="Laat in dit veld een bericht achter."></textarea>
                             <?php
                              if ( !empty($pdfHTContactArray["messageErr"])) {
                                echo "<span class='error'>" . $pdfHTContactArray["messageErr"] . "</span><br>";
                              }
                              ?>
                             <div class="help-block with-errors"></div>
                         </div>
                     </div>
                     <div class="col-md-12">
                        <img id="captcha" src="../lib/securimage/securimage_show.php" alt="CAPTCHA Image" /><br>
                        <a href="#" onclick="document.getElementById('captcha').src = '../lib/securimage/securimage_show.php?' + Math.random(); return false">[ Andere Afbeelding ]</a><br>
                        <input type="text" name="captchaCode" size="10" maxlength="6" /><span class="error">  <?php echo $pdfHTContactArray["captchaErr"]; ?><span><br><br>
                      </div>
                     <br>
                     <br>
                     <div class="col-md-12">
                         <input type="submit" class="btn btn-success btn-send" value="Verzend bericht">
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

   <footer class="py-5 footer-custom">
     <div class="container">
       <div class="row ">
          <div class="col vastgoed-img">
              <h3>Certificaten</h3>
                <a href="https://www.vastgoedpro.nl/"><img src="img/vgp.jpg" alt=""></a>
                <br>
                <br>
                <a href="https://www.vastgoedcert.nl/"><img src="img/vastgoedcert.jpg" alt=""></a>
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

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>
