<!DOCTYPE html>
<html>
<head>
    <?php
    //Check of de form gesubmit is.
    if ( isset( $_POST["submit"] ) ) {
        include "lib/upload.php";
        $file = uploadFile();

        //uploadFile returnt false als er geen file geupload is of als er een error is.
        if ( $file ) {
            echo "<img src='" . $file . "'>";
        }

        //Check of er errors waren tijdens het uploaden.
        if ( isset($UPLOAD_ERROR) ) {
            echo $UPLOAD_ERROR;
        }
    }
    ?>
</head>
<body>

<form action="index.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="upfile" id="upfile">
    <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>