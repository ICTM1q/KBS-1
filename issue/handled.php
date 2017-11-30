<?php
/**
 * Created by PhpStorm.
 * User: Tristan Willems
 * Date: 18-11-2017
 * Time: 12:11
 */

include "../admin-components/header.php";
include "menu.php";
require_once "../residence/residenceFunctions.php";
//retrieve data before the alert.php include in case of errors.
$dbFunctions = new residenceFunctions();
$conn = $dbFunctions->connectDB();

require_once "IssueFunctions.php";
$functions = new issueFunctions();
$result = $functions->getAllHandledIssues($conn);

//show messages
include "../admin-components/alert.php";
?>
    <!-- content here -->
    <h2>Klachten:</h2>
    <table class="table-hover table">
        <tr>
            <th>ID</th>
            <th>Customer name</th>
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
                    <td><?php echo $row['customername'] ?></td>
                    <td><?php echo $row['description'] ?></td>
                    <td><a href="/residence/edit?pand=<?php echo $row['pand']; ?>"><?php echo $row['pand'] ?></a></td>
                    <td><?php echo $row['date'] ?></td>
                    <td><?php if($row['handled'] == 0) {echo "Nee";}else{echo "Ja";} ?></td>
                    <td class="custom-col">
                        <form method="post" action="/issue/edit">
                            <input  type="hidden" name="edit" value="<?php echo $row['issueid'] ?>">
                            <button type="submit" class="btn fa fa-edit fa-2x"></button>
                        </form>
                    </td>
                </tr>
            <?php }
        } ?>
    </table>

<?php include "../admin-components/footer.php"; ?>