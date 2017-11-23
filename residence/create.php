<?php
/**
 * Created by PhpStorm.
 * User: Tristan Willems
 * Date: 18-11-2017
 * Time: 12:11
 */


include "../admin-components/header.php";
include "menu.php";
require_once "functions.php";

?>
<form class="form-horizontal" method="post" action="/residence/overview">
    <fieldset>
        <legend>Maak een woning aan: </legend>
        <div class="form-group row">
            <label class="col-md-5 control-label" for="straat">Adres</label>
            <div class="col-md-5">
                <input id="adres" name="adres" type="text" placeholder="" class="form-control input-md" required="">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-5 control-label" for="postcode">Postcode</label>
            <div class="col-md-5">
                <input id="postcode" name="postcode" type="text" placeholder="" class="form-control input-md">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-5 control-label" for="plaats">Plaats</label>
            <div class="col-md-5">
                <input id="plaats" name="plaats" type="text" placeholder="" class="form-control input-md">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-5 control-label" for="beschrijving">Beschrijving</label>
            <div class="col-md-5">
                <textarea class="form-control" id="beschrijving" name="beschrijving" rows="5"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-5 control-label" for="prijs">Prijs</label>
            <div class="col-md-5">
                <input id="prijs" name="prijs" type="number" min="0" step=".01" placeholder="" class="form-control input-md">
            </div>
        </div>
        <div class="form-group row">
            <div class="offset-8 col-md-2">
                <input type="submit" placeholder="" class="form-control input-md btn btn-primary"></input>
            </div>
        </div>
    </fieldset>
</form>

<?php include "../admin-components/footer.php"; ?>
