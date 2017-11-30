<?php
/**
 * Created by PhpStorm.
 * User: Tristan Willems
 * Date: 18-11-2017
 * Time: 12:11
 */
session_start();
if ( $_SESSION["role"] != "Beheer") {
    header( "Location: /login.php" );
}

include "../admin-components/header.php";
include "menu.php";
require_once "functions.php";
//data generation after include IssueFunctions.php but before alart.php in case of error's.


include "../admin-components/alert.php";
?>
<!-- content here -->

<?php include "../admin-components/footer.php"; ?>
