    <!DOCTYPE html>
    <!--
    To change this license header, choose License Headers in Project Properties.
    To change this template file, choose Tools | Templates
    and open the template in the editor.
    light-blue  #E0F4FB
    dark-blue   #4F73ED
    mid-blue    #05A8E1
    -->
    <html>
        <head>
            <title>Huur en beheer</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" crossorigin="anonymous">
            <link rel="stylesheet" href="admin.css">
        </head>
        <body>
            <div id="body"></div>
            <div id="lijnwit">
            <div id="lijnblauw">
            <div id="header">
                <div id="navbar">
                    <nav class="navbar navbar-expand-lg">
                        <a class="navbar-brand" href="home.php">LOGO</a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link" href="home.php">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="kantoor.php">Kantoor</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="aanbod.php">Aanbod</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="huurvoorwaarden.php">Huurvoorwaarden</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="inschrijven.php">Inschrijven</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="beheer.php">Beheer</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="contact.php">Contact</a>
                                </li>
                            </ul>
                            <a class="navbar-brand" href="home.php">LOGO</a>
                        </div>
                    </nav>      
                </div>
                <div id="tekst">
                    <h1 id="adminh1">Alleen geautoriseerde toegang!</h1>
                    <form method="post">
                        Gebruikersnaam:<br>
                        <input type="text" name="gebruikersnaam"><br>
                        Wachtwoord:<br>
                        <input type="password" name="wachtwoord"><br>
                        <a id="wachtwoord" href="home.php">Wachtwoord vergeten <br></a>
                        <input type="submit" value="Verstuur" id="knop">
                    </form>
                </div>
                </div>
            </div>
            </div>
            <div id="bot"></div>
        </body>
    </html>
