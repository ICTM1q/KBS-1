<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Huur en beheer</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
          integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link href="css/huurenbeheer.css" rel="stylesheet">

    <?php
    require "adminComponents/residence/residenceFunctions.php";
    $functions = new residenceFunctions();
    $conn = $functions->connectDB();
    $result = $functions->getSingleResidence($conn, $_GET['pandid']);
    $residence = $result->fetch_array();
    $pictures = $functions->getResidencePictures($conn, $residence['picturesid']);
    $conn->close();
    ?>
</head>

<body>

<?php
        include 'navbar.php';
      ?>

<!-- Page Content -->
<div class="container top-tekst-woning">
    <div class="row">
        <div class="col">
            <h1 class=" top-tekst"><?= $residence['adres'] . ", " . $residence['postalcode'] . " " . $residence['city'] ?></h1>
        </div>
    </div>
</div>

<div class="row body-woning row-woning">
    <div class="col-md-8">
        <?php
        if ($pictures != null) {
            ?>
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
                            <img class="d-block w-100 carousel" src="<?= $picture['path'] ?>" alt="<?= $picture['path'] ?>">
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
            <?php
        }
        ?>
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
        <a href="contact.php" class="btn btn-space btn-primary">Contacteer ons</a><a href="#" class="btn btn-space btn-primary">Andere optie</a>
    </div>

</div>

<div class="row row-woning">
    <div class="col-md-12 beschrijving">
        <h3 class="my-3">Beschrijving</h3>
        <p><?= $residence['description'] ?></p>
    </div>
</div>
</div>
<?php
    include 'footer.php';
    ?>

<!-- Bootstrap core JavaScript -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"
        integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"
        integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ"
        crossorigin="anonymous"></script>
<script>
    $('.carousel').carousel({
        interval: 5000
    })
</script>
</body>
</html>