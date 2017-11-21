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
<!-- content here -->

<h1>Woningoverzicht:</h1>
<table class="table-hover table table-responsive">
    <tr>
        <th>Straat</th>
        <th>Huisnummer</th>
        <th>Postcode</th>
        <th>Plaats</th>
        <th>Beschrijving</th>
        <th>Prijs</th>
        <th>Afbeelding</th>
        <th>Verwijderen</th>
    </tr>
    <!-- Below we must fill the table with the content from the database -->
    <tr>
        <td>Binnenstraat</td>
        <td>32</td>
        <td>1337LT</td>
        <td>Buitenstad</td>
        <td>Hier staat een beschrijving</td>
        <td>999.98</td>
        <td><!--<img src="uploads/woning.png">--></td>
        <td><img src="/images/delete.svg" class="custom-icon"></td>
    </tr>
    <tr>
        <td>De oudste straat in Nederland</td>
        <td>1</td>
        <td>7001AA</td>
        <td>Amsterdam</td>
        <td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui.</td>
        <td>1500</td>
        <td><!--<img src="uploads/woning.png">--></td>
        <td><img src="/images/delete.svg" class="custom-icon"></td>
    </tr>
</table>
<?php include "../admin-components/footer.php"; ?>
