<?php
/**
 * Created by PhpStorm.
 * User: Tristan Willems
 * Date: 18-11-2017
 * Time: 12:11
 */

include "../header.php";
include "menu.php";
require_once "residenceFunctions.php";
$functions = new residenceFunctions();
$conn = $functions->connectDB();

if (isset($_POST) && $_POST != null && !isset($_POST['delete'])){
    $conn = $functions->connectDB();
    $result2 = $functions->insertNewResidence($conn, $_POST['adres'], $_POST['plaats'], $_POST['postcode'], $_POST['beschrijving'], $_POST['prijs'] );
}else{
    if (isset($_POST) && $_POST != null){
        $conn = $functions->connectDB();
        $functions->deleteResidence($conn, $_POST['delete']);
    }
}

$result = $functions->getAllResidence($conn);
$total = $result->num_rows;

if(isset($_GET['page'])){
    $result = $functions->getAllResidencePaginated($conn, 10 , $_GET['page']);
}
$conn->close();
include "../alert.php";
?>
<!-- content here -->

<h2>Woningoverzicht:</h2>
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
                    <form method="post" action="/admin/residence/edit.php">
                        <input  type="hidden" name="edit" value="<?php echo $row['pandid'] ?>">
                        <button type="submit" class="btn fa fa-edit fa-2x"></button>
                    </form>
                </td>
                <td class="custom-col">
                    <form method="post" action="/admin/residence/overview.php">
                        <input  type="hidden" name="delete" value="<?php echo $row['pandid'] ?>">
                        <button type="submit" class="delete btn fa fa-trash-o fa-2x"></button>
                    </form>
                </td>
            </tr>
        <?php }
        } ?>
</table>
<div class="row">
    <div class="offset-5 col-md-5">
        <ul class="pagination">
            <?php $count = 0;
            for($i = 0;$i < $total; $i += 10){  $count++;?>

                <li class="page-item <?php if($_GET['page'] == $count) { echo "active";} ?>">
                    <a class="page-link" href="?page=<?php echo ($count); ?>"><?php echo $count; ?></a></li>
            <?php } ?>
        </ul>
    </div>
</div>
<script>
    $(function() {
        $('.delete').click(function() {
            return window.confirm("Weet u het zeker?");
        });
    });
</script>
<?php include "../footer.php"; ?>
