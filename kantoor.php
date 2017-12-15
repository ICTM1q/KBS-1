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
      <?php
        include 'navbar.php';
      ?>

    <!-- Page Content -->
    <div class="content">
        <h3 class="h3-tekst">Het kantoor</h3>
            <p>Huur & Beheer Hoksbergen is een kantoor welke gevestigd is in het stadscentrum van Kampen. Ons kantoor kenmerkt zich door heldere adviezen, gedegen kennis en een persoonlijke benadering.<br><br>
                Ons gemotiveerde team van medewerkers zet zich graag voor u in en is een team waarop u kunt bouwen.<br><br>
                Hoksbergen heeft jarenlange ervaring in het beheren van particuliere en bedrijfsmatige panden.<br><br>
                Wat is begonnen als een neventak is door de tevredenheid van onze klanten uitgegroeid tot het inmiddels goed bekende Huur & Beheer Hoksbergen.<br><br>
                Ons kantoor is aangesloten bij de branchevereniging VastgoedPro.<br><br>
                Tevens ingeschreven in de stichting VastgoedCert. Het VastgoedCert keurmerk duidt aan dat u van de makelaar/taxateur deskundigheid en vakbekwaamheid mag verwachten.</p>

            <h3 class="h3-tekst">Openingstijden</h3>
            <p>Maandag t/m vrijdag van 9.00 - 12.30 uur geopend. 's Middag op afspraak.</p>

            <h3 class="h3-tekst">Medewerkers</h3>
            <div class="medewerker">
                <div class="medewerker-tekst">
                    <img class="line" src="css/img/line.png"><br>
                    <h5>Jan Hoksbergen</h5>
                    <span>Register makelaar</span>
                    <p>Taxateur</p>
                </div>
                <div>
                    <img src="css/img/jan.jpg">
                </div>
                <img class="line" src="css/img/line.png"><br>
                <div>
                    <h5>Paulien Gelderloos</h5>
                        <p>Medewerker binnendienst</p>
                </div>
                <div>
                    <img src="css/img/paulien.jpg">
                </div>
                <img class="line" src="css/img/line.png"><br>
                <div>
                    <h5>Aline Zwakenberg</h5>
                        <p>Medewerker binnendienst</p>
                </div>
                <img class="line" src="css/img/line.png"><br>
        </div>
            
            <h3 class="h3-tekst">Algemene voorwaarden</h3>
            <p>U kunt onze algemene voorwaarden hier downloaden.</p>
            <form method="post">
                <input type="submit" value="Algemene voorwaarden" name="algemeenevoorwaarden" class="knop">
            </form><br>
    </div>
    
    <!-- Footer -->
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