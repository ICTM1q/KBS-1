<?php
/**
 * Created by PhpStorm.
 * User: Tristan Willems
 * Date: 18-11-2017
 * Time: 12:11
 */


include "../header.php";
include_once "menu.php";
require_once "../residence/residenceFunctions.php";
//retrieve data before the alert.php include_once in case of errors.
$dbFunctions = new residenceFunctions();
$conn = $dbFunctions->connectDB();

require_once "issueFunctions.php";
$functions = new issueFunctions();
$result = $functions->getAllIssues($conn);
if($result != null){
    $total = $result->num_rows;
}else{
    $total = 0;
}
$limit = 10;
if(isset($_GET['page'])){
    $result = $functions->getAllIssuesPaginated($conn, 10 , $_GET['page']);
}else{
    $result = $functions->getAllIssuesPaginated($conn, 10 , 1);
}
//show messages
include_once "../alert.php";
?>
<!-- content here -->
<h2>Klachten:</h2>
    <table class="table-hover table">
        <tr>
            <th>ID</th>
            <th>Firstname</th>
            <th>Prefix</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Description</th>
            <th>Pand</th>
            <th>Date</th>
            <th>Behandeld</th>
            <th>Afhandelen</th>
        </tr>
        <?php
        if($result != null && $result->num_rows > 0){
            foreach($result as $row){ ?>
                <tr>
                    <td><?php echo $row['issueid'] ?></td>
                    <td><?php echo $row['firstname'] ?></td>
                    <td><?php echo $row['insertion'] ?></td>
                    <td><?php echo $row['surname'] ?></td>
                    <td><?php echo $row['email'] ?></td>
                    <td><?php echo $row['description'] ?></td>
                    <td><a href="/adminComponents/residence/edit?pand=<?php echo $row['pand']; ?>"><?php echo $row['pand'] ?></a></td>
                    <td><?php echo $row['date'] ?></td>
                    <td><?php if($row['handled'] == 0) {echo "Nee";}else{echo "Ja";} ?></td>
                    <td class="custom-col">
                        <form method="post" action="/adminComponents/issue/edit">
                            <input  type="hidden" name="edit" value="<?php echo $row['issueid'] ?>">
                            <button type="submit" class="btn fa fa-edit fa-2x"></button>
                        </form>
                    </td>
                </tr>
            <?php }
        } ?>
    </table>
<?php
include_once "../pagination.php";
include "../footer.php"; ?>