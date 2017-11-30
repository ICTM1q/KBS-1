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

if(isset($_POST['edit'])){
    $pandID = $_POST['edit'];
}
elseif(isset($_GET['pand'])){
    $pandID = $_GET['pand'];
}

include "../admin-components/header.php";
include "menu.php";
require_once("residenceFunctions.php");
$functions = new residenceFunctions();
$conn = $functions->connectDB();
if (isset($pandID) && $pandID != null){
    $result = $functions->getSingleResidence($conn, $pandID);
    $result = $result->fetch_object();
}
if (isset($_POST['editRecord']) && $_POST != null){
    $functions->updateResidence($conn, $_POST['editRecord'], $_POST['adres'], $_POST['postcode'], $_POST['plaats'], $_POST['beschrijving'], $_POST['prijs']);
    $result = $functions->getSingleResidence($conn, $_POST['editRecord']);
    $result = $result->fetch_object();
}

include "../admin-components/alert.php";
if($result != null){?>

<form class="form-horizontal" method="post" action="/residence/edit">
    <fieldset>

        <!-- Form Name -->
        <legend>Pas een woning aan: </legend>

        <!-- Text input-->
        <div class="form-group row">
            <label class="col-md-5 control-label" for="straat">Adres</label>
            <div class="col-md-5">
                <input id="adres" name="adres" type="text" value="<?php echo $result->adres ?>" class="form-control input-md" required="" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-5 control-label" for="postcode">Postcode</label>
            <div class="col-md-5">
                <input id="postcode" name="postcode" type="text" value="<?php echo $result->postalcode ?>" class="form-control input-md" readonly>

            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-5 control-label" for="plaats">Plaats</label>
            <div class="col-md-5">
                <input id="plaats" name="plaats" type="text" value="<?php echo $result->city ?>" class="form-control input-md" readonly>

            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-5 control-label" for="beschrijving">Beschrijving</label>
            <div class="col-md-5">
                <textarea class="form-control" id="beschrijving" name="beschrijving" rows="5"><?php echo $result->description ?></textarea >
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-5 control-label" for="prijs">Prijs</label>
            <div class="col-md-5">
                <input id="prijs" name="prijs" type="text" class="form-control input-md" value="<?php echo $result->price ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="offset-8 col-md-2">
                <input type="hidden" value="<?php echo $result->pandid ?>" name="editRecord">
                <input type="submit" class="form-control input-md btn btn-primary">
            </div>
        </div>
    </fieldset>
</form>

<?php }
include "../admin-components/footer.php"; ?>
