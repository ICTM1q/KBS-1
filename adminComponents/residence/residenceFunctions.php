<?php
/**
 * Created by PhpStorm.
 * User: Tristan Willems
 * Date: 21-11-2017
 * Time: 10:13
 */

class residenceFunctions
{
    function connectDB()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "kbs";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }

    function getAllResidence($conn)
    {
        $sql = "SELECT * FROM `pand`";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            return $result;
        } else {
            $_SESSION['error'] = "Er zijn geen woningen gevonden. Voeg een nieuwe woning toe om deze in het overzicht te zien.";
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/logs/errorlog.txt", date("Y-m-d H:i:s") . " - " . $_SESSION['error'] . "\r\n", FILE_APPEND);
            return null;
        }
    }
    function getAllResidencePaginated($conn, $limit ,$page)
    {
        $limit2 = ($page-1) * $limit;
        $sql = "SELECT * FROM `pand` LIMIT $limit2, $limit";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            return $result;
        } else {
            $_SESSION['error'] = "Er zijn geen woningen gevonden. Voeg een nieuwe woning toe om deze in het overzicht te zien.";
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/logs/errorlog.txt", date("Y-m-d H:i:s") . " - " . $_SESSION['error'] . "\r\n", FILE_APPEND);
            return null;
        }
    }
    function getSingleResidence($conn, $pandid)
    {
        $sql = "SELECT * FROM `pand` WHERE pandid='$pandid'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0){
            return $result;
        } else {
            $_SESSION['error'] = "Er is iets mis gegaan, de woning die u probeerde aan te passen kan niet worden gevonden.";
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/logs/errorlog.txt", date("Y-m-d H:i:s") . " - " . $_SESSION['error'] . "\r\n", FILE_APPEND);
            return null;
        }
    }

    function insertNewResidence($conn, $adres, $city, $postalcode, $description, $price)
    {
        
        include_once $_SERVER['DOCUMENT_ROOT']."/lib/mail/mail.php";
        $sql = "INSERT INTO pand (adres, city, postalcode, description, price)
                VALUES ('$adres', '$city', '$postalcode', '$description', '$price')";

        if ($conn->query($sql) === TRUE) {
            if ( sendToMaillist ( $adres, $city, $postalcode, $description, $price ) === TRUE ) {
                $_SESSION['message'] = "Nieuwe woning succesvol toegevoegd.";
                return;    
            }
            else {
                $_SESSION['error'] = "Error.";
                file_put_contents($_SERVER['DOCUMENT_ROOT']."/logs/errorlog.txt", date("Y-m-d H:i:s") . " - " . $_SESSION['error'] . "\r\n", FILE_APPEND);
                return;
            }
            
        } else {
            $_SESSION['error'] = "Error: " . $sql . "<br>" . $conn->error;
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/logs/errorlog.txt", date("Y-m-d H:i:s") . " - " . $_SESSION['error'] . "\r\n", FILE_APPEND);
            return;
        }
    }
    
    function deleteResidence($conn, $pandid)
    {
        $sql = "DELETE FROM pand WHERE pandid=$pandid";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "Woning succesvol verwijderd.";
            return;
        } else {
            $_SESSION['error'] = "Error deleting record: " . $conn->error;
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/logs/errorlog.txt", date("Y-m-d H:i:s") . " - " . $_SESSION['error'] . "\r\n", FILE_APPEND);
            return;
        }
    }
    function updateResidence($conn, $pandid, $adres, $postcode, $plaats, $beschrijving, $prijs)
    {
        $sql = "UPDATE pand SET adres='$adres', city='$plaats', postalcode='$postcode', description='$beschrijving', price='$prijs' WHERE pandid=$pandid";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "De woning is successvol aangepast";
            return;
        } else {
            $_SESSION['error'] = "Error updating record: " . $conn->error;
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/logs/errorlog.txt", date("Y-m-d H:i:s") . " - " . $_SESSION['error'] . "\r\n", FILE_APPEND);
            return;
        }
    }
    function getResidencePictures($conn, $picturesid)
    {
        $sql = "SELECT * FROM `picture` WHERE picturesid='$picturesid'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0){
            return $result;
        } else {
            $_SESSION['error'] = "Er is iets mis gegaan, de foto's kunnen niet worden gevonden.";
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/logs/errorlog.txt", date("Y-m-d H:i:s") . " - " . $_SESSION['error'] . "\r\n", FILE_APPEND);
            return null;
        }
    }
}