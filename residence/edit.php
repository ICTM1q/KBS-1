<?php
/**
 * Created by PhpStorm.
 * User: Tristan Willems
 * Date: 18-11-2017
 * Time: 12:11
 */


include "../admin-components/header.php";
include "menu.php";

?>

<form class="form-horizontal">
    <fieldset>

        <!-- Form Name -->
        <legend>Pas een woning aan: </legend>

        <!-- Text input-->
        <div class="form-group row">
            <label class="col-md-5 control-label" for="straat">Straat</label>
            <div class="col-md-5">
                <input id="straat" name="straat" type="text" placeholder="" class="form-control input-md" required="" readonly>

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group row">
            <label class="col-md-5 control-label" for="huisnummer">Huisnummer</label>
            <div class="col-md-5">
                <input id="huisnummer" name="huisnummer" type="text" placeholder="" class="form-control input-md" readonly>

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group row">
            <label class="col-md-5 control-label" for="postcode">Postcode</label>
            <div class="col-md-5">
                <input id="postcode" name="postcode" type="text" placeholder="" class="form-control input-md" readonly>

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group row">
            <label class="col-md-5 control-label" for="plaats">Plaats</label>
            <div class="col-md-5">
                <input id="plaats" name="plaats" type="text" placeholder="" class="form-control input-md" readonly>

            </div>
        </div>

        <!-- Textarea -->
        <div class="form-group row">
            <label class="col-md-5 control-label" for="beschrijving">Beschrijving</label>
            <div class="col-md-5">
                <textarea class="form-control" id="beschrijving" name="beschrijving" rows="5"></textarea >
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group row">
            <label class="col-md-5 control-label" for="prijs">Prijs</label>
            <div class="col-md-5">
                <input id="prijs" name="prijs" type="text" placeholder="" class="form-control input-md">

            </div>
        </div>

    </fieldset>
</form>

<?php include "../admin-components/footer.php"; ?>
