<?php
/**
 * Created by PhpStorm.
 * User: Tristan Willems
 * Date: 18-11-2017
 * Time: 12:11
 */
include "../header.php";
include "menu.php";
require_once("../residence/residenceFunctions.php");
require_once("userFunctions.php");
$functions = new residenceFunctions();
$conn = $functions->connectDB();
$functions = new userFunctions();
if (isset($_POST['edit']) && $_POST != null){
    $result = $functions->getSingleUser($conn, $_POST['edit']);
    $result = $result->fetch_object();
}
if (isset($_POST['editRecord']) && $_POST != null){
    $functions->updateUserRole($conn, $_POST['username'], $_POST['email'], $_POST['role']);
    $result = $functions->getSingleUser($conn, $_POST['editRecord']);
    $result = $result->fetch_object();
}
include "../alert.php";
?>
<form class="form-horizontal" method="post">
    <fieldset>
        <legend>Gebruiker bewerken:</legend>
        <div class="form-group row">
            <label class="col-md-4 control-label" for="username">Gebruikersnaam</label>
            <div class="col-md-4">
                <input type="hidden" value="<?php echo $result->username ?>" name="username">
                <input id="username" name="username" type="text" value="<?php echo $result->username ?>" class="form-control input-md" required="" disabled>
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
        <div class="form-group row">
            <label class="col-md-4 control-label" for="editRecord"></label>
            <div class="col-md-4">
                <input type="hidden" value="<?php echo $result->username ?>" name="editRecord">
                <input type="submit" class="form-control input-md btn btn-primary">
            </div>
        </div>
    </fieldset>
</form>


<?php include "../footer.php"; ?>
