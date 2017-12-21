<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        require "adminComponents/residence/residenceFunctions.php";
        $functions = new residenceFunctions();
        $conn = $functions->connectDB();
        $residences = $functions->getAllResidence($conn);
        $conn->close();
    ?>
</head>

<body>
    <?php
        include_once 'navbar.php';
    ?>

    <!-- Page Content -->
    <div class="container py-3 top-tekst">
            <h2>Huuraanbood aangeboden door Hoksbergen Huurenbeheer</h2>
    </div>
<div class="container py-3">
    <?php
    if (isset($_GET['page'])) {
        $index = ($_GET['page'] - 1) * 10;
    } else {
        $_GET['page'] = 1;
        $index = 0;
    }

    if ($residences != null && $residences->num_rows > 0) {
        $conn = $functions->connectDB();

        $skip = $index;
        foreach ($residences as $residence) {
            if ($_GET['page'] > 1 && $skip > 0) {
                $skip--;
                continue;
            }
            $pictures = $functions->getResidencePictures($conn, $residence['picturesid']);

            if ($index != ($_GET['page'] - 1) * 10 && $index % 10 == 0) {
                global $current;
                $current = $index;
                break;
            }
            ?>
            <div id="pand-<?= $residence['pandid'] ?>" class="pand">
                <div class="row">
                    <div class="col-md-4">
                        <img src="<?= $pictures == null ? "https://via.placeholder.com/350x260" : "uploads/" . $pictures->fetch_array()['path'] ?>"
                             class="w-100  pand-pic">
                    </div>
                    <div class="col-md-8 px-3">
                        <div class="card-block px-3 pand-tekst">
                            <h4 class="card-title"><?= $residence['adres'] . ", " . $residence['postalcode'] . " " . $residence['city'] ?></h4>
                            <p class="card-text"><?php
                                $desc = $residence['description'];

                                if (strlen($desc) > 300)
                                {
                                    $offset = (300 - 3) - strlen($desc);
                                    $desc = substr($desc, 0, strrpos($desc, ' ', $offset)) . '...';
                                }

                                echo $desc;
                                ?></p>
                            <p class="card-text">€<?= $residence['price'] ?></p>
                            <a href="woning.php?pandid=<?= $residence['pandid'] ?>" class="btn btn-primary">Lees
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
            $currentpage = $_GET['page'];
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