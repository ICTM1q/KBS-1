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
                    <a class="nav-link <?php if($_SERVER['PHP_SELF'] == "/issue/overview.php") { echo "active";} ?>" href="overview">overzicht</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($_SERVER['PHP_SELF'] == "/issue/create.php") { echo "active";} ?>" href="create">Placeholder klacht menu item</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($_SERVER['PHP_SELF'] == "/issue/edit.php") { echo "active";} ?>" href="edit">Placeholder klacht menu item</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($_SERVER['PHP_SELF'] == "/issue/delete.php") { echo "active";} ?>" href="delete">Placeholder klacht menu item</a>
                </li>
            </ul>
        </nav>
        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">