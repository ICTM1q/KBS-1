<?php
/**
 * Created by PhpStorm.
 * User: Tristan Willems
 * Date: 18-11-2017
 * Time: 12:11
 */
include_once "../header.php";
include_once "menu.php";
require_once("../residence/residenceFunctions.php");
require_once("userFunctions.php");
$functions = new residenceFunctions();
$conn = $functions->connectDB();
$functions = new userFunctions();
if (isset($_POST['edit']) && $_POST != null){
    $result = $functions->getSingleUser($conn, $_POST['edit']);
    $result = $result->fetch_object();
    $result2 = $functions->getUserRecieverSettings($conn, $result->email);
    $result2 = $result2->fetch_object();
}
if (isset($_POST['editRecord']) && $_POST != null){
    $functions->updateUserRole($conn, $_POST['username'], $_POST['email'], $_POST['role']);
    $functions->updateUserMailSettings($conn, $_POST['email'] , $_POST['complaint'], $_POST['taxation'],$_POST['contact']);
    $result = $functions->getSingleUser($conn, $_POST['editRecord']);
    $result = $result->fetch_object();
    $result2 = $functions->getUserRecieverSettings($conn, $result->email);
    $result2 = $result2->fetch_object();
}
include_once "../alert.php";
?>
<form class="form-horizontal" method="post">
    <fieldset>
        <legend>Gebruiker bewerken:</legend>
        <div class="form-group row">
            <label class="col-md-4 control-label" for="username">Gebruikersnaam</label>
            <div class="col-md-4">
                <input type="hidden" value="<?php echo $result->username ?>" name="username">
                <input id="username" name="username" type="text" value="<?php echo $result->username ?>" class="form-control input-md" require_onced="" disabled>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 control-label" for="email">Email adres</label>
            <div class="col-md-4">

                <input id="email" name="email" type="text" value="<?php echo $result->email ?>" class="form-control input-md" >
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 control-label" for="role">Rol</label>
            <div class="col-md-4">
                <select id="role" name="role" class="form-control">
                    <option value="Admin" <?php if ($result->role == "Admin"){echo "selected"; } ?>>Admin</option>
                    <option value="Beheer" <?php if ($result->role == "Beheer"){echo "selected"; } ?>>Beheer</option>
                    <option value="Gebruiker" <?php if ($result->role == "Gebruiker"){echo "selected"; } ?>>Gebruiker</option>
                </select>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <label class="col-md-8 control-label"><h5>Gebruiker ontvangt de volgende mails:</h5></label>
        </div>
        <div class="form-group row">
            <label class="col-md-4 control-label" for="complaint">Klachtenmails:</label>
            <div class="col-md-4">
                <div class="radio">
                    <label for="complaint-0">
                        <?php if($result2->complaint == '1'){?>
                            <input type="radio" name="complaint" id="complaint-0" value=1 checked="checked">
                        <?php } else { ?>
                            <input type="radio" name="complaint" id="complaint-0" value=1>
                        <?php } ?>
                        Ja
                    </label>
                </div>
                <div class="radio">
                    <label for="complaint-1">
                        <?php if( $result2->complaint == '0'){ ?>
                            <input type="radio" name="complaint" id="complaint-1" value=0 checked="checked">
                        <?php } else { ?>
                            <input type="radio" name="complaint" id="complaint-1" value=0>
                        <?php } ?>
                        Nee
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 control-label" for="taxation">Taxatiemails:</label>
            <div class="col-md-4">
                <div class="radio">
                    <label for="taxation-0">
                        <?php if( $result2->taxation == '1'){?>
                            <input type="radio" name="taxation" id="taxation-0" value=1 checked="checked">
                        <?php } else { ?>
                            <input type="radio" name="taxation" id="taxation-0" value=1>
                        <?php } ?>
                        Ja
                    </label>
                </div>
                <div class="radio">
                    <label for="taxation-1">
                        <?php if( $result2->taxation == '0'){ ?>
                            <input type="radio" name="taxation" id="taxation-1" value=0 checked="checked">
                        <?php } else { ?>
                            <input type="radio" name="taxation" id="taxation-1" value=0>
                        <?php } ?>
                        Nee
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 control-label" for="contact">Contactmails:</label>
            <div class="col-md-4">
                <div class="radio">
                    <label for="contact-0">
                        <?php if( $result2->contact == '1'){?>
                            <input type="radio" name="contact" id="contact-0" value=1 checked="checked">
                        <?php } else { ?>
                            <input type="radio" name="contact" id="contact-0" value=1>
                        <?php } ?>
                        Ja
                    </label>
                </div>
                <div class="radio">
                    <label for="contact-1">
                        <?php if( $result2->contact == '0'){ ?>
                            <input type="radio" name="contact" id="contact-1" value=0 checked="checked">
                        <?php } else { ?>
                            <input type="radio" name="contact" id="contact-1" value=0>
                        <?php } ?>
                        Nee
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 control-label" for="editRecord"></label>
            <div class="col-md-4">
                <input type="hidden" value="<?php echo $result->username ?>" name="editRecord">
                <input type="submit" class="form-control input-md btn btn-primary">
            </div>
        </div>
    </fieldset>
</form>


<?php include_once "../footer.php"; ?>
