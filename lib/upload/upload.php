<?php

require $_SERVER['DOCUMENT_ROOT'] . "/lib/account/sql.php";

//Upload een foto naar het mapje ./uploads
//Returnt false als er geen file geupload is of als er een error is
//Returnt het path van de foto als de upload geslaagd is.
function uploadFile()
{
    try {
        $id = getId();

        if (isset($_POST['submit'])) {
            if (count($_FILES['upload']['name']) > 0) {
                //Loop through each file
                for ($i = 0; $i < count($_FILES['upload']['name']); $i++) {
                    //Get the temp file path
                    $tmpFilePath = $_FILES['upload']['tmp_name'][$i];

                    //Make sure we have a filepath
                    if ($tmpFilePath != "") {

                        //save the url and the file
                        $filePath = $_SERVER['DOCUMENT_ROOT'] . "/uploads/" . date('d-m-Y-H-i-s') . '-' . $_FILES['upload']['name'][$i];

                        //Upload the file into the temp dir
                        if (move_uploaded_file($tmpFilePath, $filePath)) {

                            $files[] = $filePath;

                            insertPictureInDB($filePath, $id);
                        }
                    }
                }
            }

            return $id;
        }

        return false;

    } catch (RuntimeException $ex) {
        global $UPLOAD_ERROR;
        $UPLOAD_ERROR = "Bestand uploaden mislukt: " . $ex->getMessage();
        return false;
    }
}

function insertPictureInDB($path, $id)
{
    $conn = connectToDatabase();

    $stmt = $conn->prepare("INSERT INTO picture (picturesId, path) VALUES (?, ?)");
    $stmt->execute(array($id, $path));
}

function getId()
{
    $conn = connectToDatabase();

    $statement = $conn->prepare("SELECT max(picturesId) FROM picture");
    $statement->execute();

    return $statement->fetch()[0] + 1;
}

function getPictures($id)
{
    $conn = connectToDatabase();

    $statement = $conn->prepare("SELECT path FROM picture WHERE picturesId = ?");
    $statement->execute(array($id));

    return $statement->fetchAll();
}

?>