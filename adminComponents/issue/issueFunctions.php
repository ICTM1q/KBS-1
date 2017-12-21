<?php
/**
 * Created by PhpStorm.
 * User: Tristan Willems
 * Date: 23-11-2017
 * Time: 14:10
 */

class issueFunctions
{
    function getAllIssues($conn)
    {
        $sql = "SELECT * FROM `issue`";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            return $result;
        } else {
            $_SESSION['error'] = "Er zijn geen klachten gevonden.";
            return null;
        }
    }
    function getAllIssuesPaginated($conn, $limit, $page)
    {
        $limit2 = ($page-1) * $limit;
        $sql = "SELECT * FROM `issue` LIMIT $limit2, $limit";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            return $result;
        } else {
            $_SESSION['error'] = "Er zijn geen klachten gevonden.";
            return null;
        }
    }
    function getAllUnhandledIssues($conn)
    {
        $sql = "SELECT * FROM `issue` WHERE `handled` = '0'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            return $result;
        } else {
            $_SESSION['error'] = "Er zijn geen on-afgehandelde klachten gevonden.";
            return null;
        }
    }
    function getAllUnhandledIssuesPaginated($conn, $limit, $page)
    {
        $limit2 = ($page-1) * $limit;
        $sql = "SELECT * FROM `issue` WHERE `handled` = '0' LIMIT $limit2, $limit";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            return $result;
        } else {
            $_SESSION['error'] = "Er zijn geen on-afgehandelde klachten gevonden.";
            return null;
        }
    }
    function getAllHandledIssues($conn)
    {
        $sql = "SELECT * FROM `issue` WHERE `handled` = '1'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            return $result;
        } else {
            $_SESSION['error'] = "Er zijn geen afgehandelde klachten gevonden.";
            return null;
        }
    }
    function getAllHandledIssuesPaginated($conn, $limit, $page)
    {
        $limit2 = ($page-1) * $limit;
        $sql = "SELECT * FROM `issue` WHERE `handled` = '1' LIMIT $limit2, $limit";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            return $result;
        } else {
            $_SESSION['error'] = "Er zijn geen afgehandelde klachten gevonden.";
            return null;
        }
    }

    function getSingleIssue($conn, $issueid)
    {
        $sql = "SELECT * FROM `issue` WHERE issueid ='$issueid'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0){
            return $result;
        } else {
            $_SESSION['error'] = "Er is iets mis gegaan, de klacht die u probeerde te bekijken kan niet worden gevonden.";
            return null;
        }
    }


    /** Inserts New Issue into table
     * @param $conn = Database connection
     * @param $firstname
     * @param $prefix = tussenvoegsel
     * @param $lastname
     * @param $email
     * @param $description
     * @param $picturesid
     * @param $pandid
     */
    function insertNewIssue($conn, $firstname, $prefix, $lastname, $email, $description, $picturesid){
        $sql = $conn->prepare( "INSERT INTO issue (firstname, insertion, surname, email, description, picturesid, date, handled) 
                            VALUES (?, ?, ?, ?, ?, ?, NOW(), '0')" );
        if ( $sql->execute ( array ( $firstname, $prefix, $lastname, $email, $description, $picturesid ) ) ) {
            return;
        } else {
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/logs/errorlog.txt", date("Y-m-d H:i:s") . " - " . $_SESSION['error'] . "\r\n", FILE_APPEND);
            return;
        }
    }

    function updateIssue($conn, $issueid, $firstname, $prefix, $lastname, $email, $description, $picturesid, $pandid, $date, $behandeld){
        $sql = "UPDATE issue SET issueid='$issueid', firstname='$firstname', insertion='$prefix', surname='$lastname', email='$email',  description='$description',picturesid='$picturesid', date='$date',handled='$behandeld'  WHERE issueid=$issueid";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "Record updated successfully";
            return;
        } else {
            $_SESSION['error'] = "Error updating record: " . $conn->error;
            return;
        }
    }
    
    function getPandid ( $conn, $street, $houseno, $zip ) {
        $sql = $conn->prepare("SELECT pandid FROM pand WHERE adres = ? AND postalcode = ?");
        $sql->execute ( array ( $street . " " . $houseno, $zip ) );
        $row = $sql->fetchAll();
        return $row;
    }
}