<?php

require $_SERVER['DOCUMENT_ROOT'] . "/lib/account/sql.php";

//Upload een foto naar het mapje ./uploads
//Returnt false als er geen file geupload is of als er een error is
//Returnt het path van de foto als de upload geslaagd is.
function uploadFile()
{
    try {
        //Get the next availabe id
        $id = getId();

        if (isset($_POST['submit'])) {

            //Allowed extentions
            $EXTENTIONS = array("jpg", "jpeg", "png", "gif");

            if (count($_FILES['upload']['name']) > 0) {

                //Loop through each file
                for ($i = 0; $i < count($_FILES['upload']['name']); $i++) {

                    //Get the temp file path
                    $tmpFilePath = $_FILES['upload']['tmp_name'][$i];

                    //Check if the file is an image
                    $ext = pathinfo($_FILES['upload']['name'][$i], PATHINFO_EXTENSION);
                    if (!in_array($ext, $EXTENTIONS)) {
                        throw new RuntimeException("Alleen foto's zijn toegestaan!");
                    }

                    //Make sure we have a filepath
                    if ($tmpFilePath != "") {

                        //save the url and the file
                        $filePath =
                            $_SERVER['DOCUMENT_ROOT'] . "/uploads/" .
                            date('d-m-Y-H-i-s') . '-' .
                            random_string(8) . '-' .
                            $_FILES['upload']['name'][$i];

                        //Upload the file into the temp dir
                        if (move_uploaded_file($tmpFilePath, $filePath)) {

                            $files[] = $filePath;

                            //Insert the file into the database
                            insertPictureInDB(str_replace($_SERVER['DOCUMENT_ROOT'] . "/uploads/", "", $filePath), $id);
                        }
                    }
                }
            }

            return $id;
        }

        throw new RuntimeException("Form niet gesubmit, probeer opnieuw!");

    } catch (RuntimeException $ex) {
        global $UPLOAD_ERROR;
        $UPLOAD_ERROR = "Bestand uploaden mislukt: " . $ex->getMessage();
        return false;
    }
}

//Insert a picture into the database with a specific id.
function insertPictureInDB($path, $id)
{
    $conn = connectToDatabase();

    $stmt = $conn->prepare("INSERT INTO picture (picturesId, path) VALUES (?, ?)");
    $stmt->execute(array($id, $path));
}

//Get the next available id for a picture set.
function getId()
{
    $conn = connectToDatabase();

    $statement = $conn->prepare("SELECT max(picturesId) FROM picture");
    $statement->execute();

    return $statement->fetch()[0] + 1;
}

//Get all the pictures with this id.
function getPictures($id)
{
    $conn = connectToDatabase();

    $statement = $conn->prepare("SELECT path FROM picture WHERE picturesId = ?");
    $statement->execute(array($id));

    return $statement->fetchAll();
}

function random_string($length)
{
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return $key;
}

?>