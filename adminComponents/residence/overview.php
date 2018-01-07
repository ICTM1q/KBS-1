<?php
/**
 * Created by PhpStorm.
 * User: Tristan Willems
 * Date: 18-11-2017
 * Time: 12:11
 */

include "../header.php";
include_once "menu.php";
require_once "residenceFunctions.php";
include "../../lib/upload/upload.php";
$functions = new residenceFunctions();

if (isset($_POST) && $_POST != null && !isset($_POST['delete'])){

    $id = autoUpload($functions->conn);
    $id= $id[0]+1;
    if ($id == false) {
        $_SESSION['error'] = $UPLOAD_ERROR;
    }
    $adres          = htmlspecialchars ($_POST['adres'] , ENT_QUOTES, 'UTF-8');
    $plaats         = htmlspecialchars ($_POST['plaats'] , ENT_QUOTES, 'UTF-8');
    $postcode       = htmlspecialchars ($_POST['postcode'] , ENT_QUOTES, 'UTF-8');
    $beschrijving   = htmlspecialchars ($_POST['beschrijving'] , ENT_QUOTES, 'UTF-8');
    $prijs          = htmlspecialchars ($_POST['prijs'] , ENT_QUOTES, 'UTF-8');
    $gwe_prijs      = htmlspecialchars ($_POST['gwe_prijs'] , ENT_QUOTES, 'UTF-8');
    $active         = htmlspecialchars ($_POST['actief'] , ENT_QUOTES, 'UTF-8');
    if ($id == false){
        $id = 'null';
    }
    $functions->insertNewResidence($adres, $plaats, $postcode, $beschrijving, $prijs, $gwe_prijs, $id, $active);

}else{
    if (isset($_POST) && $_POST != null){
        $functions->deleteResidence($_POST['delete']);
    }
}
$result = $functions->getAllResidence();
if($result != null){
    $total = count($result);
}else{
    $total = 0;
}
$limit = 10;
if(isset($_GET['page'])){
    $result = $functions->getAllResidencePaginated($limit , $_GET['page']);
}else{
    $result = $functions->getAllResidencePaginated($limit , 1);
}


?>
<!-- content here -->

<h2>Woningoverzicht:</h2>
<?php include_once "../alert.php"; ?>
<table class="table-hover table">
    <tr>
        <th>ID</th>
        <th>Adres</th>
        <th>Postcode</th>
        <th>Plaats</th>
        <th>Beschrijving</th>
        <th>Prijs</th>
        <th>G/W/E</th>
        <th>Actief</th>
        <th class="custom-col">Wijzigen</th>
        <th class="custom-col">Verwijderen</th>
    </tr>
    <!-- Below we must fill the table with the content from the database -->
    <!-- doormiddel van een forloop moeten we de data laten zien in een tabel nadat we alles hebben opgehaald. -->
    <?php
    if($result != null && $result!= false){
        foreach($result as $row){ ?>
            <tr>
                <td><?php echo $row['pandid'] ?></td>
                <td><?php echo $row['adres'] ?></td>
                <td><?php echo $row['postalcode'] ?></td>
                <td><?php echo $row['city'] ?></td>
                <td><?php echo $row['description'] ?></td>
                <td><?php echo $row['price'] ?></td>
                <td><?php echo $row['gwe_price'] ?></td>
                <td><?php if ($row['active'] == 1) { echo "Ja"; } else{ echo "Nee"; }?></td>
                <td class="custom-col">
                    <form method="post" action="/adminComponents/residence/edit.php">
                        <input  type="hidden" name="edit" datatype="int" value="<?php echo $row['pandid'] ?>">
                        <input type="hidden" value="<?php echo $row['picturesid'] ?>" name="picturesid">
                        <button type="submit" class="btn fa fa-edit fa-2x"></button>
                    </form>
                </td>
                <td class="custom-col">
                    <form method="post" action="/adminComponents/residence/overview.php<?php if (isset($_GET['page'])){ echo "?page=".$_GET['page'];}?>">
                        <input  type="hidden" name="delete" value="<?php echo $row['pandid'] ?>">
                        <button type="submit" class="delete btn fa fa-trash-o fa-2x"></button>
                    </form>
                </td>
            </tr>
        <?php }
        } ?>
</table>
<?php include_once "../pagination.php"; ?>
<script>
    $(function() {
        $('.delete').click(function() {
            return window.confirm("Weet u het zeker?");
        });
    });
</script>
<?php include "../footer.php"; ?>
