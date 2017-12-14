<?php
/**
 * Created by PhpStorm.
 * User: Tristan Willems
 * Date: 21-11-2017
 * Time: 10:13
 */

class userFunctions
{
    function getAllUsers($conn){
        $sql = "SELECT * FROM user";

        $result = $conn->query($sql);

        if($result->num_rows > 0){
            return $result;
        }
        else{
            $_SESSION['warning'] = "Er kunnen geen gebruikers worden gevonden. Probeer het later nogmaals.";
            file_put_contents("../logs/errorlog.txt", date("Y-m-d H:i:s") . " - " . $_SESSION['warning'] . "\r\n", FILE_APPEND);
            return null;
        }

    }
    function getAllUsersPaginated($conn, $limit, $page){

        $limit2 = ($page-1) * $limit;
        $sql = "SELECT * FROM user LIMIT $limit2, $limit";

        $result = $conn->query($sql);

        if($result->num_rows > 0){
            return $result;
        }
        else{
            $_SESSION['warning'] = "Er kunnen geen gebruikers worden gevonden. Probeer het later nogmaals.";
            file_put_contents("../logs/errorlog.txt", date("Y-m-d H:i:s") . " - " . $_SESSION['warning'] . "\r\n", FILE_APPEND);
            return null;
        }

    }
    function getSingleUser($conn, $username){
        $sql = "SELECT * FROM user WHERE username = '".$username."'";

        $result = $conn->query($sql);

        if($result->num_rows > 0){
            return $result;
        }
        else{
            $_SESSION['error'] = "De gebruiker die u probeerde te bewerken kan niet worden gevonden.";
            file_put_contents("../logs/errorlog.txt", date("Y-m-d H:i:s") . " - " . $_SESSION['error'] . "\r\n", FILE_APPEND);
            return null;
        }
    }
    function updateUserRole($conn, $username, $email, $role){
        $sql = "UPDATE user SET username='$username', email='$email', role='$role' WHERE username='$username'";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "De gebruiker is successvol bijgewerkt";
            return;
        } else {
            $_SESSION['error'] = "Error updating record: " . $conn->error;
            file_put_contents("../logs/errorlog.txt", date("Y-m-d H:i:s") . " - " . $_SESSION['error'] . "\r\n", FILE_APPEND);
            return;
        }
    }
    function deleteUser($conn, $username)
    {
        $sql = "DELETE FROM user WHERE username='$username'";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "Gebruiker succesvol verwijderd.";
            return;
        } else {
            $_SESSION['error'] = "Error deleting record: " . $conn->error;
            file_put_contents("../logs/errorlog.txt", date("Y-m-d H:i:s") . " - " . $_SESSION['error'] . "\r\n", FILE_APPEND);
            return;
        }
    }
}