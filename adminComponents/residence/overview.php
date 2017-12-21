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
$functions = new residenceFunctions();
$conn = $functions->connectDB();

if (isset($_POST) && $_POST != null && !isset($_POST['delete'])){
    $conn = $functions->connectDB();

    include "../../lib/upload/upload.php";
    $id = autoUpload();
    if ($id == false) {
        $_SESSION['error'] = $UPLOAD_ERROR;
    }
    $adres          = htmlspecialchars ($_POST['adres'] , ENT_QUOTES, 'UTF-8');
    $plaats         = htmlspecialchars ($_POST['plaats'] , ENT_QUOTES, 'UTF-8');
    $postcode       = htmlspecialchars ($_POST['postcode'] , ENT_QUOTES, 'UTF-8');
    $beschrijving   = htmlspecialchars ($_POST['beschrijving'] , ENT_QUOTES, 'UTF-8');
    $prijs          = htmlspecialchars ($_POST['prijs'] , ENT_QUOTES, 'UTF-8');
    $gweprijs          = htmlspecialchars ($_POST['gwe_prijs'] , ENT_QUOTES, 'UTF-8');
    if ($id == false){
        $id = 'null';
    }
    var_dump($beschrijving,$id);
    $functions->insertNewResidence($conn, $adres, $plaats, $postcode, $beschrijving, $prijs, $gweprijs, $id);


}else{
    if (isset($_POST) && $_POST != null){
        $conn = $functions->connectDB();
        $functions->deleteResidence($conn, $_POST['delete']);
    }
}

$result = $functions->getAllResidence($conn);
if($result != null){
    $total = $result->num_rows;
}else{
    $total = 0;
}
$limit = 10;
if(isset($_GET['page'])){
    $result = $functions->getAllResidencePaginated($conn, $limit , $_GET['page']);
}else{
    $result = $functions->getAllResidencePaginated($conn, $limit , 1);
}
$conn->close();

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
        <th>Afbeelding</th>
        <th class="custom-col">Wijzigen</th>
        <th class="custom-col">Verwijderen</th>
    </tr>
    <!-- Below we must fill the table with the content from the database -->
    <!-- doormiddel van een forloop moeten we de data laten zien in een tabel nadat we alles hebben opgehaald. -->
    <?php
    if($result != null && $result->num_rows > 0){
        foreach($result as $row){ ?>
            <tr>
                <td><?php echo $row['pandid'] ?></td>
                <td><?php echo $row['adres'] ?></td>
                <td><?php echo $row['postalcode'] ?></td>
                <td><?php echo $row['city'] ?></td>
                <td><?php echo $row['description'] ?></td>
                <td><?php echo $row['price'] ?></td>
                <td><?php echo $row['gwe-price'] ?></td>
                <td class="custom-col">
                    <form method="post" action="/adminComponents/residence/edit.php">
                        <input  type="hidden" name="edit" value="<?php echo $row['pandid'] ?>">
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
