<?php
/**
 * Created by PhpStorm.
 * User: Tristan Willems
 * Date: 18-11-2017
 * Time: 12:11
 */

include "../header.php";
include_once "menu.php";
include_once "../alert.php";
require_once "residenceFunctions.php";

?>
<form class="form-horizontal" method="post" action="overview.php" enctype="multipart/form-data">
    <fieldset>
        <legend>Maak een woning aan: </legend>
        <div class="form-group row">
            <label class="col-md-5 control-label" for="straat">Adres</label>
            <div class="col-md-5">
                <input id="adres" name="adres" type="text" placeholder="" class="form-control input-md" required="required">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-5 control-label" for="postcode">Postcode</label>
            <div class="col-md-5">
                <input id="postcode" name="postcode" type="text" placeholder="" class="form-control input-md" required="required">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-5 control-label" for="plaats">Plaats</label>
            <div class="col-md-5">
                <input id="plaats" name="plaats" type="text" placeholder="" class="form-control input-md" required="required">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-5 control-label" for="beschrijving">Beschrijving</label>
            <div class="col-md-5">
                <textarea class="form-control" id="beschrijving" name="beschrijving" rows="5"></textarea required="required">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-5 control-label" for="filebutton">File Button</label>
            <div class="col-md-5">
                <input id="filebutton" name="upload[]" type="file"  class="input-file" multiple="multiple">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-5 control-label" for="prijs">Prijs</label>
            <div class="col-md-5">
                <input id="prijs" name="prijs" type="number" min="0" step="1" placeholder="" class="form-control input-md" required="required">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-5 control-label" for="gwe_prijs">G/W/E Prijs</label>
            <div class="col-md-5">
                <input id="gwe_prijs" name="gwe_prijs" type="number" min="0" step="1" placeholder="" class="form-control input-md" required="required">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-5 control-label" for="actief">actief</label>
            <div class="col-md-5">
                <div class="radio">
                    <label for="actief-0">
                            <input type="radio" name="actief" id="actief-0" value=1>
                        Ja
                    </label>
                </div>
                <div class="radio">
                    <label for="actief-1">
                            <input type="radio" name="actief" id="actief-1" value=0 checked="checked">
                        Nee
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="offset-6 col-md-2">
                <a href="/adminComponents/residence/overview" class="form-control input-md btn btn-danger">Terug</a>
            </div>
            <div class="col-md-2">
                <input type="submit" placeholder="" class="form-control input-md btn btn-primary">
            </div>
        </div>
    </fieldset>
</form>

<?php include "../footer.php"; ?>
