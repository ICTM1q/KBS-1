<!DOCTYPE html>
<html lang="en">
  <head>
    <link href="css/home.css" rel="stylesheet">
  </head>

  <body>
      <?php
        include_once 'navbar.php';
      ?>

    <!-- Page Content -->
    <div class="content">

      <!-- Carousel -->
      <div class="row my-4 carousel-div">
        <div class="col-lg-8">
            <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner sliderbox">
                  <div class="carousel-item active">
                    <img class="d-block w-100 img-fluid" src="css/img/slider-01.jpg" alt="First slide">
                  </div>
                  <div class="carousel-item">
                    <img class="d-block w-100" src="css/img/slider-02.jpg" alt="Second slide">
                  </div>
                  <div class="carousel-item">
                    <img class="d-block w-100" src="css/img/slider-03.jpg" alt="Third slide">
                  </div>
                </div>
              </div>
        </div>
      </div>
        <!-- /.col-lg-8 -->
        <!-- Call to Action Well -->
      <div class="card tag-bg my-4 text-center">
        <div class="card-body">
          <p class="m-0 tag-tekst"><h1 class="title">Welkom op de website van Huur & Beheer Hoksbergen</h1></p>
        </div>
      </div>
        
        <div>
          <p>U bent bij ons op het juiste adres voor:</p>
          <ul>
              <li>het bemiddelen bij de verhuur van uw woning of bedrijfspand.</li>
              <li>het zoeken naar een huurwoning / bedrijfspand.</li>
              <li>het uitbesteden van beheer van uw particulier of bedrijfsmatig vastgoed.</li>
          </ul>
          <p>Bel of mail ons voor een persoonlijk gesprek!</p>
        </div>
      <!-- /.row -->


      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->

    <?php
    include_once 'footer.php';
    ?>
  </body>
</html>