<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/adminComponents/residence/residenceFunctions.php";

function uploadFile($id)
{
    try {
        $files = array();

        //Allowed extentions
        $EXTENTIONS = array("jpg", "jpeg", "png", "gif");

        //Get the amount of uploaded files
        $count = count($_FILES['upload']['name']);

        //Check if there are any images at all
        if ($count == 0 || !file_exists($_FILES['upload']['tmp_name'][0]) || !is_uploaded_file($_FILES['upload']['tmp_name'][0])) {
            return $id;
        }

        //Make sure there aren't more than 8 files
        if ($count > 8) {
            throw new RuntimeException("Niet meer dan 8 plaatjes uploaden!");
        }

        //Loop over all files
        for ($i = 0; $i < $count; $i++) {

            //Get the original filename
            $filename = $_FILES['upload']['name'][$i];

            //Check if the file is an image
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if (!in_array($ext, $EXTENTIONS)) {
                throw new RuntimeException("Alleen foto's zijn toegestaan!");
            }

            //Check if the file is not too big
            if ($_FILES['upload']['size'][$i] > 5000000) {
                throw new RuntimeException(sprintf("Bestand %s is te groot!", $filename));
            }
        }

        //Check if there are any images at all
        if ($count > 0) {

            //Loop through each file
            for ($i = 0; $i < $count; $i++) {

                //Get the temp file path
                $tmpFilePath = $_FILES['upload']['tmp_name'][$i];

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

                        $files[] = str_replace($_SERVER['DOCUMENT_ROOT'] . "/uploads/", "", $filePath);
                    }
                }
            }
        }

        return $files;

    } catch (RuntimeException $ex) {
        $_SESSION['error'] = "Bestand uploaden mislukt: " . $ex->getMessage();
        return "error";
    }
}

function autoUpload() {
    $func = new residenceFunctions();
    $conn = $func->connectDB();
    $id = getId($conn);
    $pictures = uploadFile($id);
    if ($pictures != "error" && !$pictures){
        return $id;
    }
    if ($pictures == "error") {
        return FALSE;
    }
    insertPictures($pictures, $id, $conn);
    return $id;
}

function removePicture($path, $id, $conn)
{
    unlink($_SERVER['DOCUMENT_ROOT'] . "/uploads/" . $path);
    $statement = $conn->prepare("DELETE FROM picture WHERE path = ? AND picturesid = ?");
    $statement->bind_param("ss", $path, $id);
    $statement->execute();
}

function insertPictures($pictures, $id, $conn)
{
    foreach ($pictures as $picture) {
        insertPictureInDB($picture, $id, $conn);
    }
}

//Insert a picture into the database with a specific id
function insertPictureInDB($path, $id, $conn)
{
    $statement = $conn->prepare("INSERT INTO picture (picturesId, path) VALUES (?, ?)");
    $statement->bind_param("ss", $id, $path);
    $statement->execute();
}

//Get the next available id for a picture set
function getId($conn)
{
    $statement = $conn->prepare("SELECT max(picturesId) FROM picture");
    $statement->execute();
    $statement->bind_result($max);
    $statement->fetch();

    return $max + 1;
}

//Get all the pictures with this id
function getPictures($id, $conn)
{
    $statement = $conn->prepare("SELECT path FROM picture WHERE picturesId = ?");
    $statement->bind_param("s", $id);
    $statement->execute();
    $statement->bind_result($path);

    $pictures = array();
    $index = 0;
    while ($statement->fetch()) {
        $pictures[$index] = $path;
        $index++;
    }

    return $pictures;
}

//Generate a random ascii string of the given lenth
function random_string($length)
{
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return strtoupper($key);
}

?>