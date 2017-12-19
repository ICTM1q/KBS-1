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
    <link href="css/kantoor.css" rel="stylesheet">
  </head>

  <body>
      <?php
        include_once 'navbar.php';
      ?>

    <!-- Page Content -->
    <div class="content">
        <h3 class="h3-tekst">Het kantoor</h3>
            <p>Huur & Beheer Hoksbergen vind je in het stadscentrum van Kampen. Ons kantoor kenmerkt zich door heldere adviezen, diepgaande kennis en een persoonlijke benadering.
                Ons gemotiveerde team van medewerkers zet zich graag voor u in en is een team waarop u kunt bouwen.
                Hoksbergen heeft jarenlange ervaring in het taxeren en beheren van particuliere panden.
                Wat is begonnen als een neventak is door de tevredenheid van onze klanten uitgegroeid tot het inmiddels goed bekende Huur & Beheer Hoksbergen.
                Ons kantoor is aangesloten bij de branchevereniging VastgoedPro.
                Ook zijn wij ingeschreven in de stichting VastgoedCert voor makelaars werkzaamheden. Tevens zijn we aangesloten bij NRVT het vastgoed register.</p>

            <h3 class="h3-tekst">Openingstijden</h3>
            <p><center>Maandag t/m vrijdag van 9.00 - 12.30 uur geopend. 's Middag op afspraak.</center></p>

            <h3 class="h3-tekst">Medewerkers</h3>
            <div class="medewerker">
                <div class="medewerker-tekst">
                    <img class="line" src="css/img/line.png"><br>
                    <h5>Jan Hoksbergen</h5>
                    <span>Register makelaar</span>
                    <p>Taxateur</p>
                </div>
                <div class="medewerker-img">
                    <img src="css/img/jan.jpg" height="350" width="216">
                </div>
                <img class="line" src="css/img/line.png"><br>
                <div>
                    <h5>Aline Zwakenberg</h5>
                        <p>Medewerker binnendienst</p>
                </div>
                <div class="medewerker-img">
                    <img src="css/img/aline.jpg" height="350" width="216">
                </div>
                <div>
                <img class="line" src="css/img/line.png"><br>
                </div>
                <div>
                    <h5>Paulien Gelderloos</h5>
                        <p>Medewerker binnendienst</p>
                </div>
                <div class="medewerker-img">
                    <img src="css/img/paulien.jpg" height="350" width="216">
                </div>
                <img class="line" src="css/img/line.png"><br>
        </div>
            
            <h3 class="h3-tekst">Algemene voorwaarden</h3>
            <center><p>U kunt onze algemene voorwaarden hier downloaden.</p>
                <form method="get" action="Algemene_Voorwaarden.pdf">
                <input type="submit" value="Algemene voorwaarden" name="algemeenevoorwaarden" class="knop"></center>
            </form><br>
    </div>
    
    <!-- Footer -->
   <?php
   include_once 'footer.php';
   ?>
  </body>
</html>