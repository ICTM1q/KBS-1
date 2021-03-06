<?php session_start();
$allowed = false;
if ($_SESSION['role'] == "Admin"){
    $allowed = true;
}
if ( $_SESSION["role"] == "Beheer") {
    $allowed = true;
}
if ($allowed != true){
    $_SESSION['error'] = "U mag deze pagina niet bezoeken.";
    header( "Location: /login.php" );
} ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!--<link rel="icon" href="../../../../favicon.ico">-->

    <title>Dashboard Template for Bootstrap</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

    <!-- Bootstrap core CSS -->
    <link href="/adminComponents/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/adminComponents/css/dashboard.css" rel="stylesheet">
    <!-- font awesome -->
    <script src="https://use.fontawesome.com/4b9f613b5e.js"></script>
</head>

<body>
<header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand navbar-brand-custom" href="/admin.php"><img src="/images/logo_groot.png"></a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item <?php if($_SERVER['PHP_SELF'] == "/adminComponents/issue/overview.php" || $_SERVER['PHP_SELF'] == "/adminComponents/issue/unhandled.php" || $_SERVER['PHP_SELF'] == "/adminComponents/issue/handled.php" || $_SERVER['PHP_SELF'] == "/adminComponents/issue/edit.php") { echo "active";} ?>">
                    <a class="nav-link" href="/adminComponents/issue/overview">Klachten / Meldingen</a>
                </li>
                <li class="nav-item <?php if($_SERVER['PHP_SELF'] == "/adminComponents/residence/overview.php" || $_SERVER['PHP_SELF'] == "/adminComponents/residence/create.php" || $_SERVER['PHP_SELF'] == "/adminComponents/residence/edit.php" || $_SERVER['PHP_SELF'] == "/adminComponents/residence/delete.php") { echo "active";} ?>">
                    <a class="nav-link" href="/adminComponents/residence/overview">Woningaanbod</a>
                </li>
                <li class="nav-item <?php if($_SERVER['PHP_SELF'] == "/adminComponents/user/overview.php" || $_SERVER['PHP_SELF'] == "/adminComponents/user/create.php" || $_SERVER['PHP_SELF'] == "/adminComponents/user/edit.php" || $_SERVER['PHP_SELF'] == "/adminComponents/user/delete.php") { echo "active";} ?>">
                    <a class="nav-link" href="/adminComponents/user/overview">Gebruikers</a>
                </li>
                <!--<li class="nav-item <?php //if($_SERVER['PHP_SELF'] == "/adminComponents/site/overview.php" || $_SERVER['PHP_SELF'] == "/adminComponents/site/create.php" || $_SERVER['PHP_SELF'] == "/adminComponents/site/edit.php" || $_SERVER['PHP_SELF'] == "/adminComponents/site/delete.php") { echo "active";} ?>">
                    <a class="nav-link" href="#">Site</a>
                </li>-->
            </ul>
            <a class="btn nav-link" href="/logout">Uitloggen</a>
        </div>
    </nav>
</header>