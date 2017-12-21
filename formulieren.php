<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="css/formulieren.css" rel="stylesheet">
    </head>

    <body>
        <!-- Navbar -->
        <?php
            include_once 'navbar.php';
        ?>

        <!-- Inhoud -->
        <div class="content">
            <h2 class="h3-tekst">Formulieren</h2>
            <br>
            <div class="container-div">
                <div class="klachten"><a href="melding.php"><i class="fa fa-bell" aria-hidden="true"></i></a><p class="p-button">Melding</p></div>
                <div class="meldingen"><a href="contact.php"><i class="fa fa-phone" aria-hidden="true"></i></a><p class="p-button">Contact</p></div>
            </div>
            <br>
            <p class="center-tekst">U kunt hier de benodigde formulieren downloaden en deze vervolgens per e-mail verzenden naar: </p>
            <a href="mailto:info@huurenbeheer.nl"> info@huurenbeheer.nl </a>
            <br>
            <br>
            <p>Of per post naar:</p>
            <span>Huur & Beheer Hoksbergen</span><br>
            <span>Oudestraat 172</span><br>
            <span>8261 CW Kampen</span>
            
            <form method="get" action="werkgeversverklaring.pdf"><br>
                <input type="submit" value="Werkgeversverklaring" name="werkgeversverklaring" class="knop"><br><br>
            </form>
            <form method="get" action="Verhuurderverklaring.pdf">
                <input type="submit" value="Huurdersverklaring" name="huurdersverklaring" class="knop"><br><br>
            </form>
            <form method="get" action="Garantstelling.pdf">
                <input type="submit" value="Garantstelling" name="garantstelling" class="knop">
            </form>
        </div>
        <br>

        <!-- Footer -->
        <?php
            include_once 'footer.php';
        ?>
    </body>
</html>