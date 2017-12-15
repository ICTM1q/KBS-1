<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Huur en beheer</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link href="css/huurenbeheer.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
    
  </head>

  <body>
      <?php
        include 'navbar.php';
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
        <div>
            <h1 class="title">Welkom op de website van Huur & Beheer Hoksbergen</h1>
          <p>U bent bij ons op het juiste adres voor:</p>
          <ul>
              <li>het bemiddelen bij de verhuur van uw woning of bedrijfspand.</li>
              <li>het zoeken naar een huurwoning / bedrijfspand.</li>
              <li>het uitbesteden van beheer van uw particulier of bedrijfsmatig vastgoed.</li>
          </ul>
          <p>Bel of mail ons voor een persoonlijk gesprek!</p>
        </div>
      <!-- /.row -->

      <!-- Call to Action Well -->
      <div class="card tag-bg my-4 text-center">
        <div class="card-body">
          <p class="m-0 tag-tekst">Hier kan een tag line komen te staan.</p>
        </div>
      </div>

      <!-- Content Row -->
      <div class="row">
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <div class="card-body">
              <h2 class="card-title">Card 1</h2>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod tenetur ex natus at dolorem enim! Nesciunt pariatur voluptatem sunt quam eaque, vel, non in id dolore voluptates quos eligendi labore.</p>
            </div>
            <div class="card-footer">
              <a href="#" class="btn btn-primary">Meer Informatie</a>
            </div>
          </div>
        </div>
        <!-- /.col-md-4 -->
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <div class="card-body">
              <h2 class="card-title">Card 2</h2>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod tenetur ex natus at dolorem enim! Nesciunt pariatur voluptatem sunt quam eaque, vel, non in id dolore voluptates quos eligendi labore.</p>
            </div>
            <div class="card-footer">
              <a href="#" class="btn btn-primary">Meer Informatie</a>
            </div>
          </div>
        </div>
        <!-- /.col-md-4 -->
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <div class="card-body">
              <h2 class="card-title">Card 3</h2>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod tenetur ex natus at dolorem enim! Nesciunt pariatur voluptatem sunt quam eaque, vel, non in id dolore voluptates quos eligendi labore.</p>
            </div>
            <div class="card-footer">
              <a href="#" class="btn btn-primary">Meer Informatie</a>
            </div>
          </div>
        </div>
        <!-- /.col-md-4 -->

      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->

    <?php
    include 'footer.php';
    ?>

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