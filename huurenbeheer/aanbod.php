<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Huur en beheer</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link href="../css/huurenbeheer.css" rel="stylesheet">
    
    <?php
    require "../residence/residenceFunctions.php";
    $functions = new residenceFunctions();
    $conn = $functions->connectDB();
    $residences = $functions->getAllResidence($conn);
    $conn->close();
    ?>
  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
     <div class="container">
       <a class="navbar-brand" href="index.php">
           <img src="../css//img/logo.jpg" width="160" height="90" class="d-inline-block align-top" alt=""></a>
       <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
       </button>
       <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="home.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="kantoor.php">Kantoor</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="aanbod.php">Aanbod
                <span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="huurvoorwaarden">Huurvoorwaarden</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="inschrijven">Inschrijven</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="formulieren">Formulieren</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="beheer">Beheer</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact">Contact</a>
            </li>
          </ul>
        </div>
      </div>    
    </nav>

    <!-- Page Content -->
    <div class="container top-tekst-aanbod">
        <div class="row">
            <div class="col">
                <h2>Huuraanbood aangeboden door Hoksbergen Huurenbeheer</h2>
            </div>
        </div>
    </div>
    
    <div class="container py-3">
    <?php
    if ($residences != null && $residences->num_rows > 0) {
        $conn = $functions->connectDB();
        $residenceArray = $residences->fetch_all();

        $index = 0;
        if (isset($_GET['page'])) {
            $index = ($_GET['page'] - 1) * 10;
        } else {
            $_GET['page'] = 1;
        }

        for (; $index < sizeof($residenceArray); $index++) {
            $residence = $residenceArray[$index];
            $pictures = $functions->getResidencePictures($conn, $residence[6]);

            if ($index != ($_GET['page'] - 1) * 10 && $index % 10 == 0) {
                global $current;
                $current = $index;
                break;
            }
            ?>
            <div id="pand-<?= $residence[0] ?>" class="card pand">
                <div class="row">
                    <div class="col-md-4">
                        <img src="<?= $pictures->fetch_array()['path'] ?>" class="w-100  pand-pic">
                    </div>
                    <div class="col-md-8 px-3">
                        <div class="card-block px-3">
                            <h4 class="card-title"><?= $residence[1] . ", " . $residence[3] . " " . $residence[2] ?></h4>
                            <p class="card-text"><?= $residence[4] ?></p>
                            <p class="card-text">€<?= $residence[5] ?></p>
                            <a href="woning.php?pandid=<?= $residence[0] ?>" class="btn btn-primary">Lees
                                meer</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
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
            $pages = ceil($residences->num_rows / 10);
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

   <footer class="py-5 footer-custom">
     <div class="container">
       <div class="row ">
          <div class="col vastgoed-img">
              <h3>Certificaten</h3>
                <a href="https://www.vastgoedpro.nl/"><img src="../css/img/vgp.jpg" alt=""></a>
                <br>
                <br>
                <a href="https://www.vastgoedcert.nl/"><img src="../css/img/vastgoedcert.jpg" alt=""></a>
                <br>
                <br>
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
                  <ul class="ulfooter"><li>Oudestraat 172</li>
                  <li>8261 CW Kampen</li>
                  <li>Tel.: 038-33 88 341</li>
                  <li>info@hoksbergen.nl</li></ul>
            </div>
            <div class="col">
              <h3>Locatie</h3>
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2425.5411569166!2d5.9132473156257745!3d52.559824241029794!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c87883431521b5%3A0x9589572588a7b0f1!2sHoksbergen+Makelaardij+V.O.F.!5e0!3m2!1snl!2snl!4v1511426183418" width="400" height="200" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
          </div>
          <br>
         <div class="row">
           <div class="col-sm-12 col-md-12 text-center">
             <span>Hoksbergen Makelaardij &copy; 2017 </span>
             <div class="blank-gap-10"></div>
             <p><p>
             </div>
         </div>
   </footer>


    <!-- Bootstrap core JavaScript -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script>
        $('.carousel').carousel({
            interval: 5000
        })
    </script>
  </body>
</html>