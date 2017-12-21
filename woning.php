<!DOCTYPE html>
<html lang="en">
<head>
    <link href="css/woning.css" rel="stylesheet">

    <?php
    require_once "adminComponents/residence/residenceFunctions.php";
    require_once "lib/vars.php";
    $functions = new residenceFunctions();
    $conn = $functions->connectDB();
    if (!isset($_GET[$RESIDENCE_ID])) {
        $_GET[$RESIDENCE_ID] = 1;
    }
    $result = $functions->getSingleResidence($conn, $_GET[$RESIDENCE_ID]);
    $residence = $result->fetch_array();
    $pictures = $functions->getResidencePictures($conn, $residence[$RESIDENCE_PICTURES_ID]);
    $conn->close();
    ?>
</head>

<body>

<?php
        include_once 'navbar.php';
      ?>

<div class="container">
    <br>
    <div class="row">
        <div class="col">
            <h1 class=" top-tekst"><?= $residence[$RESIDENCE_ADRES] . ", " . $residence[$RESIDENCE_POSTALCODE] . " " . $residence[$RESIDENCE_CITY] ?></h1>
            <br>
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
                        <li data-target="#" data-slide-to="<?= $i ?>"
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
                            <img class="d-block carousel img-fluid" src="<?= "uploads/" . $picture[$PICTURE_PATH] ?>" alt="<?= $picture[$PICTURE_PATH] ?>">
                        </div>
                        <?php
                        $first = false;
                    }
                    ?>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <i class="fa fa-chevron-left"></i>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <i class="fa fa-chevron-right"></i>
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
            <li>Adres: <?= $residence[$RESIDENCE_ADRES] ?></li>
            <li>Postcode: <?= $residence[$RESIDENCE_POSTALCODE] ?></li>
            <li>Plaats: <?= $residence[$RESIDENCE_CITY] ?></li>
            <li>Prijs: €<?= $residence[$RESIDENCE_PRICE] ?></li>
            <li>GWE Prijs: €<?= $residence[$RESIDENCE_GWE_PRICE] ?></li>
        </ul>
        <br>
        <a href="contact.php" class="btn btn-space btn-primary">Contacteer ons</a>
    </div>

</div>

<div class="row row-woning">
    <div class="col-md-12 beschrijving">
        <h3 class="my-3">Beschrijving</h3>
        <p><?= str_replace("\n", "<br/>", $residence[$RESIDENCE_DESC]) ?></p>
    </div>
</div>

<div class="row row-woning">
    <div class="col-md-12 beschrijving">
      <div class="map-responsive-woning">
        <iframe width="600" height="450" frameborder="0" style="border:0"
                src="https://www.google.com/maps/embed/v1/search?q=<?= str_replace(" ", "+", $residence[$RESIDENCE_CITY] . "+" . $residence[$RESIDENCE_ADRES] . "+" . $residence[$RESIDENCE_POSTALCODE]) ?>&key=AIzaSyBTlBGgJMAjD1MibY_XKVf1amexgekuW1g" allowfullscreen></iframe>
        </div>
    </div>
</div>
<br>
</div>
<?php
    include_once 'footer.php';
    ?>
</body>
</html>
