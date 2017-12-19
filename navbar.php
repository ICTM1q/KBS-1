<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
        <link href="css/navbar.css" rel="stylesheet">
        <link href="css/huurenbeheer.css" rel="stylesheet">
        <script defer src="https://use.fontawesome.com/releases/v5.0.1/js/all.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
     <div class="container">
       <a class="navbar-brand" href="index.php">
           <img src="css/img/logo_groot.png" width="214" height="90" class="d-inline-block align-top" alt=""></a>
       <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon fa fa-bars"></span>
       </button>
       <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li>
                <a class="nav-link <?php if ($_SERVER['PHP_SELF'] == "index.php"){echo "active";};?>" href="home.php">Home</a>
            </li>
            <li>
                <a class="nav-link <?php if ($_SERVER['PHP_SELF'] == "kantoor.php"){echo "active";};?>" href="kantoor.php">Kantoor</a>
            </li>
            <li>
                <a class="nav-link <?php if ($_SERVER['PHP_SELF'] == "aanod.php"){echo "active";};?>" href="aanbod.php">Aanbod</a>
            </li>
            <li>
                <a class="nav-link <?php if ($_SERVER['PHP_SELF'] == "huurvoorwaarden.php"){echo "active";};?>" href="huurvoorwaarden.php">Huurvoorwaarden</a>
            </li>
            <li>
                <a class="nav-link <?php if ($_SERVER['PHP_SELF'] == "formulieren.php"){echo "active";};?>" href="formulieren.php">Formulieren</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    </body>
</html>
