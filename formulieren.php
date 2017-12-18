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
        <link href="css/formulieren.css" rel="stylesheet">
    </head>

    <body>
        <!-- Navbar -->
        <?php
            include 'navbar.php';
        ?>

        <!-- Inhoud -->
        <div class="content">
            <h2 class="h3-tekst">Formulieren</h2>
            <br>
            <div class="container-div">
                <div class="klachten"><a href="#"><i class="fa fa-bell" aria-hidden="true"></i></a><p class="p-button">Melding</p></div>
                <div class="meldingen"><a href="#"><i class="fa fa-phone" aria-hidden="true"></i></a><p class="p-button">Contact</p></div>
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
            
            <form method="post"><br>
                <input type="submit" value="Werkgeversverklaring" name="werkgeversverklaring" class="knop"><br><br>
                <input type="submit" value="Huurdersverklaring" name="huurdersverklaring" class="knop"><br><br>
                <input type="submit" value="Garantstelling" name="garantstelling" class="knop">
            </form>
        </div>
        <br>

        <!-- Footer -->
        <?php
            include 'footer.php';
        ?>
    </body>
</html>