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
            <h2 class="h3-tekst">Kies een site:</h2>
            <br>
            <div class="container-div">
                <div class="klachten"><a href="#"><i class="fa fa-bell" aria-hidden="true"></i></a><p class="p-button">Huur en beheer</p></div>
                <div class="meldingen"><a href="#"><i class="fa fa-phone" aria-hidden="true"></i></a><p class="p-button">Taxatie</p></div>
            </div>
        </div>

        <!-- Footer -->
        <?php
            include 'footer.php';
        ?>
    </body>
</html>