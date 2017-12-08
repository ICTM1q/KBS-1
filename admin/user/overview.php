<?php
/**
 * Created by PhpStorm.
 * User: Tristan Willems
 * Date: 18-11-2017
 * Time: 12:11
 */

include "../header.php";
include "menu.php";
require_once "../residence/residenceFunctions.php";
//data generation after include issueFunctions.php but before alert.php in case of error's.
$functions = new residenceFunctions();
$conn = $functions->connectDB();
require_once "userFunctions.php";
$functions = new userFunctions();
$result = $functions->getAllUsers($conn);
$total = $result->num_rows;

if(isset($_GET['page'])){
    $result = $functions->getAllUsersPaginated($conn, 10 , $_GET['page']);
}else{
    $result = $functions->getAllUsersPaginated($conn, 10 , 1);
}

if (isset($_POST['delete']) && $_POST != null){
    $functions->deleteUser($conn, $_POST['delete']);
}

$conn->close();

include "../alert.php";
?>
<!-- content here -->
<h2>Gebruikers:</h2>
<table class="table-hover table">
    <tr>
        <th>Gebruikersnaam</th>
        <th>Email</th>
        <th>Wachtwoord</th>
        <th>Rol</th>
        <th>Aanmaakdatum</th>
        <th class="custom-col">Rol aanpassen</th>
        <th class="custom-col">Verwijderen</th>
    </tr>
    <?php
    foreach($result as $row){?>
    <tr>
        <td><?php echo $row["username"] ?></td>
        <td><?php echo $row["email"] ?></td>
        <td><?php for($i = 0;$i < 8; $i++){echo "*";}?></td>
        <td><?php echo $row["role"] ?></td>
        <td><?php echo $row["create_date"] ?></td>
        <td class="custom-col">
            <form method="post" action="/admin/user/edit.php">
                <input  type="hidden" name="edit" value="<?php echo $row['username'] ?>">
                <button type="submit" class="btn fa fa-edit fa-2x"></button>
            </form>
        </td>
        <td class="custom-col">
            <form method="post" action="/admin/user/overview.php">
                <input  type="hidden" name="delete" value="<?php echo $row['username'] ?>">
                <button type="submit" class="delete btn fa fa-trash-o fa-2x"></button>
            </form>
        </td>
    </tr><?php
    }
    ?>
</table>
<?php  include "../pagination.php"; ?>
<script>
    $(function() {
        $('.delete').click(function() {
            return window.confirm("Weet u het zeker?");
        });
    });
</script>
<?php include "../footer.php"; ?>