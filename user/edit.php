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
require_once("functions.php");
$functions = new residenceFunctions();
$conn = $functions->connectDB();
if (isset($_POST['edit']) && $_POST != null){
    $result = $functions->getSingleResidence($conn, $_POST['edit']);
    $result = $result->fetch_object();
}
if (isset($_POST['editRecord']) && $_POST != null){
    $functions->updateResidence($conn, $_POST['editRecord'], $_POST['adres'], $_POST['postcode'], $_POST['plaats'], $_POST['beschrijving'], $_POST['prijs']);
    $result = $functions->getSingleResidence($conn, $_POST['editRecord']);
    $result = $result->fetch_object();
}
include "../admin-components/alert.php";
?>

<?php include "../admin-components/footer.php"; ?>
