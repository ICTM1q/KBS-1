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
include "../../lib/upload/upload.php";
$functions = new residenceFunctions();
$conn = $functions->connectDB();
if (isset($_POST['picturesid'])){
    $_SESSION['picturesid'] = $_POST['picturesid'];
}
if (isset($_GET['path']) && isset($_GET['delete']) && $_GET != null){
    //Delete image based on picturesid and path
    removePicture($_GET['path'], $_GET['delete'], $conn);
    $_SESSION['message'] = "Afbeelding is verwijderd.";
    $pandID = $_SESSION['pandid'];
    unset($_SESSION['pandid']);
}
if (isset($pandID) && $pandID != null){
    $result = $functions->getSingleResidence($conn, $pandID);
    if ($result!= null && $result->num_rows > 0){
    $result = $result->fetch_object();
    $_SESSION['pandid'] = $result->pandid;
    }
}
if (isset($_POST['editRecord']) && $_POST != null){
    if ($_POST['picturesid'] != null){
        $var = uploadFile($_POST['picturesid']);
    }
    else{
        $_POST['picturesid'] = autoUpload();
    }
    if (isset($var) && $var != null){
        insertPictures($var, $_POST['picturesid'] , $conn);
    }

    $adres          = htmlspecialchars($_POST['adres'] , ENT_QUOTES, 'UTF-8');
    $plaats         = htmlspecialchars($_POST['plaats'] , ENT_QUOTES, 'UTF-8');
    $postcode       = htmlspecialchars($_POST['postcode'] , ENT_QUOTES, 'UTF-8');
    $beschrijving   = htmlspecialchars($_POST['beschrijving'] , ENT_QUOTES, 'UTF-8');
    $prijs          = htmlspecialchars($_POST['prijs'] , ENT_QUOTES, 'UTF-8');
    $gwe_prijs      = htmlspecialchars($_POST['gwe_prijs'], ENT_QUOTES, 'UTF-8');
    if ($_POST['picturesid'] == false){
        $_POST['picturesid'] = 'null';
    }

    $functions->updateResidence($conn, $_POST['editRecord'], $adres, $postcode, $plaats, $beschrijving, $prijs, $gwe_prijs, $_POST['picturesid']);
    $result = $functions->getSingleResidence($conn, $_POST['editRecord']);
    $result = $result->fetch_object();
}
$images = $functions->getResidencePictures($conn, $result->picturesid);
include_once "../alert.php";
if(isset($result) && $result != null){?>

<form class="form-horizontal" method="post" action="edit.php" enctype="multipart/form-data">
    <fieldset>

        <!-- Form Name -->
        <legend>Pas een woning aan: </legend>

        <!-- Text input-->
        <div class="form-group row">
            <label class="col-md-4 control-label" for="straat">Adres</label>
            <div class="col-md-6">
                <input id="adres" name="adres" type="text" value="<?php echo $result->adres ?>" class="form-control input-md" require_onced="require_onced">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 control-label" for="postcode">Postcode</label>
            <div class="col-md-6">
                <input id="postcode" name="postcode" type="text" value="<?php echo $result->postalcode ?>" class="form-control input-md" require_onced="require_onced">

            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 control-label" for="plaats">Plaats</label>
            <div class="col-md-6">
                <input id="plaats" name="plaats" type="text" value="<?php echo $result->city ?>" class="form-control input-md" require_onced="require_onced">

            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 control-label" for="beschrijving">Beschrijving</label>
            <div class="col-md-6">
                <textarea class="form-control" id="beschrijving" name="beschrijving" rows="5"><?php echo $result->description ?></textarea require_onced="require_onced">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-4 control-label" for="filebutton">File Button</label>
            <div class="col-md-6">
                <input id="filebutton" name="upload[]" type="file"  class="input-file" multiple="multiple">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-4 control-label" for="prijs">Prijs</label>
            <div class="col-md-6">
                <input id="prijs" name="prijs" type="number" min="0" step="1" value="<?php echo $result->price ?>" class="form-control input-md" require_onced="require_onced">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 control-label" for="gwe_prijs">G/W/E Prijs</label>
            <div class="col-md-6">
                <input id="gwe_prijs" name="gwe_prijs" type="number" min="0" step="1" value="<?php echo $result->gwe_price ?>" class="form-control input-md" require_onced="require_onced">
            </div>
        </div>
        <?php if($images != null) {?>
        <div class="form-group row">
            <label class="col-md-12 control-label">Verwijder een afbeelding door er op te klikken:</label>
            <?php
                $first = 0;
                foreach ($images as $image) { ?>
                    <div class="<?php if ($first == 0) {
                        $first = 1;
                        echo "offset-4 ";
                    } else {
                        $first--;
                    } ?>col-md-3">
                        <a href="edit.php?delete=<?php echo $image['picturesid'] ?>&path=<?php echo $image['path'] ?>"
                           class="delete">
                            <img src="<?php echo "/uploads/" . $image['path']; ?>" class="thumbnail mx-auto">
                        </a>
                    </div>
                <?php }?>
        </div>
        <?php }?>
        <div class="form-group row">
            <div class="offset-4 col-md-3">
                <a href="/adminComponents/residence/overview" class="form-control input-md btn btn-danger">Terug</a>
            </div>
            <div class="col-md-3">
                <input type="hidden" value="<?php echo $result->pandid ?>" name="editRecord">
                <input type="hidden" value="<?php echo $result->picturesid ?>" name="picturesid">
                <input type="submit" class="form-control input-md btn btn-primary">
            </div>
        </div>
    </fieldset>
</form>
<script>
    $(function() {
        $('.delete').click(function() {
            return window.confirm("Weet u het zeker?");
        });
    });
</script>
<?php }
include "../footer.php"; ?>
