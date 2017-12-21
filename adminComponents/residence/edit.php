<?php
/**
 * Created by PhpStorm.
 * User: Tristan Willems
 * Date: 18-11-2017
 * Time: 12:11
 */

if(isset($_POST['edit'])){
    $pandID = $_POST['edit'];
}
elseif(isset($_GET['pand'])){
    $pandID = $_GET['pand'];
}

include "../header.php";
include_once "menu.php";
require_once("residenceFunctions.php");
$functions = new residenceFunctions();
$conn = $functions->connectDB();
if (isset($pandID) && $pandID != null){
    $result = $functions->getSingleResidence($conn, $pandID);
    $result = $result->fetch_object();
}
if (isset($_POST['editRecord']) && $_POST != null){


    include "../../lib/upload/upload.php";
    $id = uploadFile();
    if ($id == false) {
        $_SESSION['error'] = $UPLOAD_ERROR;
    }

    $adres          = htmlspecialchars($_POST['adres'] , ENT_QUOTES, 'UTF-8');
    $plaats         = htmlspecialchars($_POST['plaats'] , ENT_QUOTES, 'UTF-8');
    $postcode       = htmlspecialchars($_POST['postcode'] , ENT_QUOTES, 'UTF-8');
    $beschrijving   = htmlspecialchars($_POST['beschrijving'] , ENT_QUOTES, 'UTF-8');
    $prijs          = htmlspecialchars($_POST['prijs'] , ENT_QUOTES, 'UTF-8');

    $functions->updateResidence($conn, $_POST['editRecord'], $adres, $postcode, $plaats, $beschrijving, $prijs, $id);
    $result = $functions->getSingleResidence($conn, $_POST['editRecord']);
    $result = $result->fetch_object();
}

include_once "../alert.php";
if($result != null){?>

<form class="form-horizontal" method="post" action="edit.php" enctype="multipart/form-data">
    <fieldset>

        <!-- Form Name -->
        <legend>Pas een woning aan: </legend>

        <!-- Text input-->
        <div class="form-group row">
            <label class="col-md-3 control-label" for="straat">Adres</label>
            <div class="col-md-5">
                <input id="adres" name="adres" type="text" value="<?php echo $result->adres ?>" class="form-control input-md" require_onced="require_onced">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 control-label" for="postcode">Postcode</label>
            <div class="col-md-5">
                <input id="postcode" name="postcode" type="text" value="<?php echo $result->postalcode ?>" class="form-control input-md" require_onced="require_onced">

            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 control-label" for="plaats">Plaats</label>
            <div class="col-md-5">
                <input id="plaats" name="plaats" type="text" value="<?php echo $result->city ?>" class="form-control input-md" require_onced="require_onced">

            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 control-label" for="beschrijving">Beschrijving</label>
            <div class="col-md-5">
                <textarea class="form-control" id="beschrijving" name="beschrijving" rows="5"><?php echo $result->description ?></textarea require_onced="require_onced">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-3 control-label" for="filebutton">File Button</label>
            <div class="col-md-5">
                <input id="filebutton" name="upload[]" type="file"  class="input-file" multiple="multiple">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-3 control-label" for="prijs">Prijs</label>
            <div class="col-md-5">
                <input id="prijs" name="prijs" type="number" min="0" step=".01" value="<?php echo $result->price ?>" class="form-control input-md" require_onced="require_onced">
            </div>
        </div>
        <div class="row"><?php

            $images = $functions->getResidencePictures($conn, $result->picturesid);
            $row = $images->fetch_object();
            var_dump("PicturesID: ".$result->picturesid);
            echo "<pre>";
            var_dump($row);
            echo "</pre>";

        ?></div>
        <div class="form-group row">
            <div class="offset-3 col-md-2">
                <a href="/adminComponents/residence/overview" class="form-control input-md btn btn-danger">Terug</a>
            </div>
            <div class="col-md-2">
                <input type="hidden" value="<?php echo $result->pandid ?>" name="editRecord">
                <input type="submit" class="form-control input-md btn btn-primary">
            </div>
        </div>
    </fieldset>
</form>

<?php }
include "../footer.php"; ?>
