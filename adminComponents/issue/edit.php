<?php
/**
 * Created by PhpStorm.
 * User: Tristan Willems
 * Date: 18-11-2017
 * Time: 12:11
 */

if(isset($_POST['edit'])){
    $issueID = $_POST['edit'];
}
elseif(isset($_GET['issue'])){
    $issueID = $_GET['issue'];
}
include "../header.php";
include "menu.php";


    require_once "../residence/residenceFunctions.php";
    //retrieve data before the alert.php include in case of errors.
    $dbFunctions = new residenceFunctions();
    $conn = $dbFunctions->connectDB();

    require_once "issueFunctions.php";
    $functions = new issueFunctions();
if(isset($issueID) && $issueID != null) {
    $result = $functions->getSingleIssue($conn, $issueID);
    $result = $result->fetch_object();
}
if (isset($_POST['editRecord'])){
    $functions->updateIssue($conn, $_POST['editRecord'],$_POST['firstname'], $_POST['prefix'], $_POST['lastname'], $_POST['email'], $_POST['description'],0, $_POST['pandid'], $_POST['date'], (int)$_POST['behandeld']);
    $result = $functions->getSingleIssue($conn, $_POST['editRecord']);
    $result = $result->fetch_object();
}
include "../alert.php";
if(isset($result) && $result != null){?>
<h2>Klacht:</h2>

<form class="form-horizontal" method="post" action="edit">
    <fieldset>

        <!-- Form Name -->
        <legend>Form Name</legend>

        <!-- Text input-->
        <div class="form-group row">
            <label class="col-md-4 control-label" for="firstname">Voornaam</label>
            <div class="col-md-4">
                <input id="firstname" name="firstname" type="text" value="<?php echo $result->voornaam ?>" class="form-control input-md">

            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 control-label" for="prefix">Tussenvoegsel</label>
            <div class="col-md-4">
                <input id="prefix" name="prefix" type="text" value="<?php echo $result->tussenvoegsel ?>" class="form-control input-md">

            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 control-label" for="lastname">Achternaam</label>
            <div class="col-md-4">
                <input id="lastname" name="lastname" type="text" value="<?php echo $result->achternaam ?>" class="form-control input-md">

            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 control-label" for="email">Email</label>
            <div class="col-md-4">
                <input id="email" name="email" type="text" value="<?php echo $result->email ?>" class="form-control input-md">

            </div>
        </div>

        <!-- Textarea -->
        <div class="form-group row">
            <label class="col-md-4 control-label" for="description">Beschrijving</label>
            <div class="col-md-4">
                <textarea class="form-control" id="description" name="description" rows="5"><?php echo $result->description ?></textarea>
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group row">
            <label class="col-md-4 control-label" for="pandid">pand</label>
            <div class="col-md-4">
                <input id="pandid" name="pandid" type="text" value="<?php echo $result->pand ?>" class="form-control input-md">

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group row">
            <label class="col-md-4 control-label" for="date">Datum</label>
            <div class="col-md-4">
                <input id="date" name="date" type="text" value="<?php echo $result->date ?>" class="form-control input-md">

            </div>
        </div>

        <!-- Multiple Radios -->
        <div class="form-group row">
            <label class="col-md-4 control-label" for="behandeld">Behandeld</label>
            <div class="col-md-4">
                <div class="radio">
                    <label for="behandeld-0">
                        <?php if($result->handled == '1'){?>
                            <input type="radio" name="behandeld" id="behandeld-0" value=1 checked="checked">
                        <?php } else { ?>
                            <input type="radio" name="behandeld" id="behandeld-0" value=1>
                        <?php } ?>
                        Ja
                    </label>
                </div>
                <div class="radio">
                    <label for="behandeld-1">
                        <?php if($result->handled == '0'){ ?>
                            <input type="radio" name="behandeld" id="behandeld-1" value=0 checked="checked">
                        <?php } else { ?>
                            <input type="radio" name="behandeld" id="behandeld-1" value=0>
                        <?php } ?>
                        Nee
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="offset-4 col-md-2">
                    <a href="javascript:history.go(-1)" class="form-control input-md btn btn-danger">Terug</a>
            </div>
            <div class="col-md-2">
                <input type="hidden" value="<?php echo $result->issueid ?>" name="editRecord">
                <input type="submit" class="form-control input-md btn btn-primary">
            </div>
        </div>
    </fieldset>
</form>


<?php }
include "../footer.php"; ?>