<!DOCTYPE html>
<html lang="en">
  <head>
    <link href="css/kantoor.css" rel="stylesheet">
  </head>

  <body>
      <?php
        include_once 'navbar.php';
      ?>

    <!-- Page Content -->
    <div class="content">
        <h3 class="title">Het kantoor</h3>
            <p>Huur & Beheer Hoksbergen vind je in het stadscentrum van Kampen. Ons kantoor kenmerkt zich door heldere adviezen, diepgaande kennis en een persoonlijke benadering.
                Ons gemotiveerde team van medewerkers zet zich graag voor u in en is een team waarop u kunt bouwen.
                Hoksbergen heeft jarenlange ervaring in het taxeren en beheren van particuliere panden.
                Wat is begonnen als een neventak is door de tevredenheid van onze klanten uitgegroeid tot het inmiddels goed bekende Huur & Beheer Hoksbergen.
                Ons kantoor is aangesloten bij de branchevereniging VastgoedPro.
                Ook zijn wij ingeschreven in de stichting VastgoedCert voor makelaars werkzaamheden. Tevens zijn we aangesloten bij NRVT het vastgoed register.</p>

            <br>
            
            
            <h3 class="title">Openingstijden</h3>
            <p><center>Maandag t/m vrijdag van 9.00 - 12.30 uur geopend. 's Middag op afspraak.</center></p>

            <br>
            
            <h3 class="title">Medewerkers</h3>
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