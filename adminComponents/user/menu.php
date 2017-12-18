<?php
/**
 * Created by PhpStorm.
 * User: Tristan Willems
 * Date: 21-11-2017
 * Time: 08:55
 */

?>

<div class="container-fluid">
    <div class="row">
        <nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a class="nav-link <?php if($_SERVER['PHP_SELF'] == "/adminComponents/user/overview.php") { echo "active";} ?>" href="overview">Overzicht</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($_SERVER['PHP_SELF'] == "/adminComponents/user/create.php") { echo "active";} ?>" href="create">Voeg een gebruiker toe</a>
                </li>
            </ul>
        </nav>
        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">