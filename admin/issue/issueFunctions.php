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
            $_SESSION['warning'] = "Er zijn geen klachten gevonden.";
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
            $_SESSION['warning'] = "Er zijn geen klachten gevonden.";
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
            $_SESSION['warning'] = "Er zijn geen klachten gevonden.";
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
            $_SESSION['warning'] = "Er zijn geen klachten gevonden.";
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
            $_SESSION['warning'] = "Er zijn geen klachten gevonden.";
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
            $_SESSION['warning'] = "Er zijn geen klachten gevonden.";
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

    function updateIssue($conn, $issueid, $customername, $description, $pandid, $date, $behandeld){
        $sql = "UPDATE issue SET issueid='$issueid', customername='$customername', description='$description', pand='$pandid', date='$date',handled='$behandeld'  WHERE issueid=$issueid";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "Record updated successfully";
            return;
        } else {
            $_SESSION['error'] = "Error updating record: " . $conn->error;
            return;
        }
    }
}