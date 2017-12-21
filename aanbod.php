<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    require "adminComponents/residence/residenceFunctions.php";
    require_once "lib/vars.php";
    $functions = new residenceFunctions();
    $conn = $functions->connectDB();
    $residences = $functions->getAllResidence($conn);
    $conn->close();
    ?>
    <link href="css/aanbod.css" rel="stylesheet">
</head>

<body>
    <?php
        include_once 'navbar.php';
    ?>

    <!-- Page Content -->
    <div class="container py-3 top-tekst">
        <h3 class="titel">Huuraanbood aangeboden door Hoksbergen Huurenbeheer</h3>
    </div>
    <h6 class="nieuwsbrief">Meld je <a href="abonneer.php">hier</a> aan voor onze nieuwsbrief om op hoogte te blijven van onze laatste woningen.</h6>
<div class="container py-3">
    <?php
    if (isset($_GET[$RESIDENCE_PAGE])) {
        $index = ($_GET[$RESIDENCE_PAGE] - 1) * 10;
    } else {
        $_GET[$RESIDENCE_PAGE] = 1;
        $index = 0;
    }

    if ($residences != null && $residences->num_rows > 0) {
        $conn = $functions->connectDB();

        $skip = $index;
        foreach ($residences as $residence) {
            if ($_GET[$RESIDENCE_PAGE] > 1 && $skip > 0) {
                $skip--;
                continue;
            }
            $pictures = $functions->getResidencePictures($conn, $residence[$RESIDENCE_PICTURES_ID]);

            if ($index != ($_GET[$RESIDENCE_PAGE] - 1) * 10 && $index % 10 == 0) {
                global $current;
                $current = $index;
                break;
            }
            ?>
            <div id="pand-<?= $residence[$RESIDENCE_ID] ?>" class="pand">
                <div class="row">
                    <div class="col-md-4">
                        <img src="<?= $pictures == null ? "https://via.placeholder.com/350x260" : "uploads/" . $pictures->fetch_array()[$PICTURE_PATH] ?>"
                             class="pand-pic w-100">
                    </div>
                    <div class="col-md-8 px-3">
                        <div class="card-block px-3 pand-tekst">
                            <h4 class="card-title"><?= $residence[$RESIDENCE_ADRES] . ", " . $residence[$RESIDENCE_POSTALCODE] . " " . $residence[$RESIDENCE_CITY] ?></h4>
                            <p class="card-text"><?php
                                $desc = $residence[$RESIDENCE_DESC];

                                if (strlen($desc) > 300)
                                {
                                    $offset = (300 - 3) - strlen($desc);
                                    $desc = substr($desc, 0, strrpos($desc, ' ', $offset)) . '...';
                                }

                                echo $desc;
                                ?></p>
                            <p class="card-text">€<?= $residence[$RESIDENCE_PRICE] ?></p>
                            <a href="woning.php?pandid=<?= $residence[$RESIDENCE_ID] ?>" class="btn btn-primary">Lees
                                meer</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $index++;
        }
        $conn->close();
    }
    ?>
    <br>
</div>

<br>

<div class="container">
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <?php
            if ($residences == null || $residences->num_rows == 0) {
                $pages = 1;
            } else {
                $pages = ceil($residences->num_rows / 10);
            }
            $currentpage = $_GET[$RESIDENCE_PAGE];
            ?>
            <ul class="pagination mx-auto">
                <li class="page-item <?= $currentpage == 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="aanbod.php?page=<?= $currentpage - 1 ?>" aria-label="Previous">
                        <span aria-hidden="true">«</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
                <?php
                for ($i = 0; $i < $pages; $i++) {
                    ?>
                    <li class="page-item <?= $i + 1 == $currentpage ? 'active' : '' ?>"><a class="page-link" href="aanbod.php?page=<?= $i + 1 ?>"><?= $i + 1 ?></a>
                    </li>
                    <?php
                }
                ?>
                <li class="page-item <?= $currentpage == $pages ? 'disabled' : '' ?>">
                    <a class="page-link" href="aanbod.php?page=<?= $currentpage + 1 ?>" aria-label="Next">
                        <span aria-hidden="true">»</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

</div>
<!-- Footer -->

<?php
    include_once 'footer.php';
    ?>
</body>
</html>