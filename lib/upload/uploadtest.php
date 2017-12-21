<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>

    <?php
    session_start();

    //Check of de form gesubmit is.
    if (isset($_POST["submit"])) {
        include_once "upload.php";

        $id = autoUpload();

        if ($id == false) {
            echo $_SESSION['error'];
        } else {
            echo $id;
        }
    }
    ?>
</head>
<body>
<form action="uploadtest.php" method="post" enctype="multipart/form-data">
    Select images to upload:
    <input id='upload' name="upload[]" type="file" multiple="multiple">
    <input type="submit" value="Upload Images" name="submit">
</form>
</body>
</html>