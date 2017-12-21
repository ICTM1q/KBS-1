<!DOCTYPE html>
<html>
<head>
    <title>Huur en beheer</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
          integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous"
          rel="stylesheet">
    <link href="css/huurenbeheer.css" rel="stylesheet">
    <link href="css/navbar.css" rel="stylesheet">
    <script defer src="https://use.fontawesome.com/releases/v5.0.1/js/all.js"></script>

    <?php include_once "lib/vars.php" ?>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-custom fixed-top">

    <div class="container">

        <a class="navbar-brand" href="index.php">

            <img src="css/img/logo_groot.png" width="214" height="90" class="d-inline-block align-top" alt=""></a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon fa fa-bars"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">

            <ul class="navbar-nav ml-auto">
                <li>
                    <a class="nav-link <?php if ($_SERVER[$GLOBAL_PHP_SELF] == $HEADER_HOME) {
                        print "active";
                    }; ?>" href="home.php">Home</a>
                </li>
                <li>
                    <a class="nav-link <?php if ($_SERVER[$GLOBAL_PHP_SELF] == $HEADER_KANTOOR) {
                        echo "active";
                    }; ?>" href="kantoor.php">Kantoor</a>
                </li>
                <li>
                    <a class="nav-link <?php if ($_SERVER[$GLOBAL_PHP_SELF] == $HEADER_AANBOD || $_SERVER[$GLOBAL_PHP_SELF] == $HEADER_WONING) {
                        echo "active";
                    }; ?>" href="aanbod.php">Aanbod</a>
                </li>
                <li>
                    <a class="nav-link <?php if ($_SERVER[$GLOBAL_PHP_SELF] == $HEADER_VOORWAARDEN) {
                        echo "active";
                    }; ?>" href="huurvoorwaarden.php">Huurvoorwaarden</a>
                </li>
                <li>
                    <a class="nav-link <?php if ($_SERVER[$GLOBAL_PHP_SELF] == $HEADER_FORMS || $_SERVER[$GLOBAL_PHP_SELF] == $HEADER_MELDING || $_SERVER[$GLOBAL_PHP_SELF] == $HEADER_CONTACT) {
                        echo "active";
                    }; ?>" href="formulieren.php">Formulieren</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
</body>
</html>
