<?php
/**
 * Created by PhpStorm.
 * User: Tristan Willems
 * Date: 18-11-2017
 * Time: 12:11
 */
session_start();
if ( $_SESSION["role"] != "Beheer") {
    header( "Location: login.php" );
}

include "../admin-components/header.php";
include "menu.php";
include "../admin-components/alert.php";

?>

<?php include "../admin-components/footer.php"; ?>
