<!DOCTYPE html>
<html lang="en">
<head>
    <link href="css/woning.css" rel="stylesheet">

    <?php
    require_once "adminComponents/residence/residenceFunctions.php";
    $functions = new residenceFunctions();
    $conn = $functions->connectDB();
    if (!isset($_GET['pandid'])) {
        $_GET['pandid'] = 1;
    }
    $result = $functions->getSingleResidence($conn, $_GET['pandid']);
    $residence = $result->fetch_array();
    $pictures = $functions->getResidencePictures($conn, $residence['picturesid']);
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
            <h1 class=" top-tekst"><?= $residence['adres'] . ", " . $residence['postalcode'] . " " . $residence['city'] ?></h1>
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
                            <img class="d-block w-100 carousel" src="<?= "uploads/" . $picture['path'] ?>" alt="<?= $picture['path'] ?>">
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
            <li>Adres: <?= $residence['adres'] ?></li>
            <li>Postcode: <?= $residence['postalcode'] ?></li>
            <li>Plaats: <?= $residence['city'] ?></li>
            <li>Prijs: €<?= $residence['price'] ?></li>
        </ul>
        <br>
        <a href="contact.php" class="btn btn-space btn-primary">Contacteer ons</a>
    </div>

</div>

<div class="row row-woning">
    <div class="col-md-12 beschrijving">
        <h3 class="my-3">Beschrijving</h3>
        <p><?= $residence['description'] ?></p>
    </div>
</div>

<div class="row row-woning">
    <div class="col-md-12 beschrijving">
        <iframe width="600" height="450" frameborder="0" style="border:0"
                src="https://www.google.com/maps/embed/v1/search?q=<?= str_replace(" ", "+", $residence['city'] . "+" . $residence['adres'] . "+" . $residence['postalcode']) ?>&key=AIzaSyBTlBGgJMAjD1MibY_XKVf1amexgekuW1g" allowfullscreen></iframe>
    </div>
</div>

</div>
<?php
    include_once 'footer.php';
    ?>
</body>
</html>
