<?php
/**
 * Created by PhpStorm.
 * User: Tristan Willems
 * Date: 21-11-2017
 * Time: 10:13
 */

class functions
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
            $_SESSION['warning'] = "Er zijn geen woningen gevonden. Voeg een nieuwe woning toe om deze in het overzicht te zien.";
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
            return null;
        }
    }

    function insertNewResidence($conn, $adres, $city, $postalcode, $description, $price)
    {
        $sql = "INSERT INTO pand (adres, city, postalcode, description, price)
                VALUES ('$adres', '$city', '$postalcode', '$description', '$price')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "Nieuwe woning succesvol toegevoegd.";
            return;
        } else {
            $_SESSION['error'] = "Error: " . $sql . "<br>" . $conn->error;
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
            return;
        }
    }
    function updateResidence($conn, $pandid, $adres, $postcode, $plaats, $beschrijving, $prijs)
    {
        $sql = "UPDATE pand SET adres='$adres', city='$plaats', postalcode='$postcode', description='$beschrijving', price='$prijs' WHERE pandid=$pandid";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "Record updated successfully";
            return;
        } else {
            $_SESSION['error'] = "Error updating record: " . $conn->error;
            return;
        }

    }
    function getResidencePictures($conn, $pandid)
    {
        $sql = "SELECT * FROM `picture` WHERE pandid='$pandid'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0){
            return $result;
        } else {
            $_SESSION['error'] = "Er is iets mis gegaan, de foto's kunnen niet worden gevonden.";
            return null;
        }
    }
}