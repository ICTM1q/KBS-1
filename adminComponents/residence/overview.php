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
    $functions->insertNewResidence($conn, $_POST['adres'], $_POST['plaats'], $_POST['postcode'], $_POST['beschrijving'], $_POST['prijs'], $id);


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
                <td><!--<img src="uploads/woning.png">--></td>
                <td class="custom-col">
                    <form method="post" action="/adminComponents/residence/edit.php">
                        <input  type="hidden" name="edit" value="<?php echo $row['pandid'] ?>">
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
