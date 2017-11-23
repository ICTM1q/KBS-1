<?php
/**
 * Created by PhpStorm.
 * User: Tristan Willems
 * Date: 18-11-2017
 * Time: 12:11
 */


include "../admin-components/header.php";
include "menu.php";
require_once("functions.php");
$functions = new functions();
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

if (isset($_SESSION['message']) &&$_SESSION['message'] != null){ ?>
    <div class="alert alert-success custom-col" role="alert">
        <?php echo $_SESSION['message']; $_SESSION['message'] = null; ?>
    </div>
<?php }
if (isset($_SESSION['error']) && $_SESSION['error'] != null){ ?>
    <div class="alert alert-danger custom-col" role="alert">
        <?php echo $_SESSION['error']; $_SESSION['error'] = null; ?>
    </div>
<?php }
if (isset($_SESSION['warning']) && $_SESSION['warning'] != null){ ?>
    <div class="alert alert-warning custom-col" role="alert">
        <?php echo $_SESSION['warning']; $_SESSION['warning'] = null; ?>
    </div>
<?php }
?>

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

<?php include "../admin-components/footer.php"; ?>
