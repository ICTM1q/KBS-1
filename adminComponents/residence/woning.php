<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Taxatie</title>

    <link rel="stylesheet" href="https:/maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
          integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link href="../taxatiesite/css/style.css" rel="stylesheet">

    <?php
    require_once "residenceFunctions.php";
    $functions = new residenceFunctions();
    $conn = $functions->connectDB();
    $result = $functions->getSingleResidence($_GET['pandid']);
    $residence = $result->fetch_array();
    $pictures = $functions->getResidencePictures($residence['picturesid']);
    $conn->close();
    ?>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container">
        <a class="navbar-brand" href="../taxatiesite/index.php">
            <img src="../taxatiesite/img/hoksbergen.gif" width="160" height="90" class="d-inline-block align-top"
                 alt=""></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../taxatiesite/index.php">Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../taxatiesite/aanbod.php">Aanbod</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../taxatiesite/diensten.php">Diensten</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../taxatiesite/onskantoor.php">Ons kantoor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../taxatiesite/inschrijven.php">Inschrijven</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../taxatiesite/contact.php">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">

    <h1 class="my-4"><?= $residence['adres'] . ", " . $residence['postalcode'] . " " . $residence['city'] ?></h1>

    <div class="row">

        <div class="col-md-8">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <?php
                    for ($i = 0; $i < $pictures->num_rows; $i++) {
                        ?>
                        <li data-target="#carouselExampleIndicators" data-slide-to="<?= $i ?>"
                            class="<?= $i == 0 ? 'active' : '' ?>"></li>
                        <?php
                    }
                    ?>
                </ol>
                <div class="carousel-inner">
                    <?php
                    $first = true;
                    foreach ($pictures as $picture) {
                        ?>
                        <div class="carousel-item <?= $first ? 'active' : '' ?>">
                            <img class="d-block w-100" src="<?= $picture['path'] ?>" alt="<?= $picture['path'] ?>">
                        </div>
                        <?php
                        $first = false;
                    }
                    ?>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

        </div>

        <div class="col-md-4">
            <h3 class="my-3">Details</h3>
            <ul>
                <li>Adres: <?= $residence['adres'] ?></li>
                <li>Postcode: <?= $residence['postalcode'] ?></li>
                <li>Plaats: <?= $residence['city'] ?></li>
                <li>Prijs: €<?= $residence['price'] ?></li>
            </ul>
            <br>
            <a href="../taxatiesite/contact.php" class="btn btn-space btn-primary">Contacteer ons</a><a href="#"
                                                                                                        class="btn btn-space btn-primary">Andere
                optie</a>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <h3 class="my-3">Beschrijving</h3>
            <p><?= $residence['description'] ?></p>
        </div>
    </div>
</div>

<footer class="py-5 footer-custom">
    <div class="container">
        <div class="row ">
            <div class="col vastgoed-img">
                <h3>Certificaten</h3>
                <a href="https:/www.vastgoedpro.nl/"><img src="img/vgp.jpg" alt=""></a>
                <br>
                <br>
                <a href="https:/www.vastgoedcert.nl/"><img src="img/vastgoedcert.jpg" alt=""></a>
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
                <ul class="ulfooter">
                    <li>Oudestraat 172</li>
                    <li>8261 CW Kampen</li>
                    <li>Tel.: 038-33 88 341</li>
                    <li>info@hoksbergen.nl</li>
                </ul>
            </div>
            <div class="col">
                <h3>Locatie</h3>
                <iframe src="https:/www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2425.5411569166!2d5.9132473156257745!3d52.559824241029794!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c87883431521b5%3A0x9589572588a7b0f1!2sHoksbergen+Makelaardij+V.O.F.!5e0!3m2!1snl!2snl!4v1511426183418"
                        width="400" height="200" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-12 col-md-12 text-center">
                <span>Hoksbergen Makelaardij &copy; 2017 </span>
                <div class="blank-gap-10"></div>
                <p>
                <p>
            </div>
        </div>
    </div>
</footer>

<script src="https:/code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https:/cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"
        integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
        crossorigin="anonymous"></script>
<script src="https:/maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"
        integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ"
        crossorigin="anonymous"></script>
</body>
</html>
