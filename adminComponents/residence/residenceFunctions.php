<?php
/**
 * Created by PhpStorm.
 * User: Tristan Willems
 * Date: 21-11-2017
 * Time: 10:13
 */

include_once "../../lib/account/sql.php";
class residenceFunctions
{

    public $conn = null;

    public function __construct()
    {
        $this->conn = connectToDatabase();
    }
    function getAllResidence(){
        try {
            $stmt = $this->conn->prepare('SELECT * FROM pand');
            $stmt->execute();
            $pand = $stmt->fetch();

            if ($pand == false){
                $_SESSION['error'] = "Er zijn geen woningen gevonden. Voeg een nieuwe woning toe om deze in het overzicht te zien.";
                file_put_contents($_SERVER['DOCUMENT_ROOT']."/logs/errorlog.txt", date("Y-m-d H:i:s") . " - " . $_SESSION['error'] . "\r\n", FILE_APPEND);
                return $pand;
            }else {
                return $pand;
            }
        }
        catch ( PDOException $e ) {
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/logs/errorlog.txt", date("Y-m-d H:i:s") . " - " . $e . "\r\n", FILE_APPEND);
            return $e;
        }
    }
    function getAllResidencePaginated($limit1 , $page)
    {
        try{
            $limit2 = ($page-1) * $limit1;

            $stmt = $this->conn->prepare('SELECT * FROM pand LIMIT :limit2, :limit1');
            $stmt->bindParam(":limit1" , $limit1, PDO::PARAM_INT);
            $stmt->bindParam(":limit2" , $limit2, PDO::PARAM_INT);
            $stmt->execute();
            $pand = $stmt->fetchall();
            return $pand;
        }
        catch ( PDOException $e ) {
            $_SESSION['error'] = "Er zijn geen woningen gevonden. Voeg een nieuwe woning toe om deze in het overzicht te zien. PAGINATION ERROR";
        file_put_contents($_SERVER['DOCUMENT_ROOT']."/logs/errorlog.txt", date("Y-m-d H:i:s") . " - " . $e . "\r\n", FILE_APPEND);
        return $e;
        }
    }
    function getSingleResidence($pandid)
    {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM pand WHERE pandid=:pandid');
            $stmt->bindParam(':pandid', $pandid, PDO::PARAM_INT);
            $stmt->execute();
            $pand = $stmt->fetch();

            if ($pand == false){
                $_SESSION['error'] = "Er zijn geen woningen gevonden. Voeg een nieuwe woning toe om deze in het overzicht te zien.";
                file_put_contents($_SERVER['DOCUMENT_ROOT']."/logs/errorlog.txt", date("Y-m-d H:i:s") . " - " . $_SESSION['error'] . "\r\n", FILE_APPEND);
                return $pand;
            }else {
                return $pand;
            }
        }
        catch ( PDOException $e ) {
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/logs/errorlog.txt", date("Y-m-d H:i:s") . " - " . $e . "\r\n", FILE_APPEND);
            return $e;
        }
    }
    function insertNewResidence($adres, $city, $postalcode, $description, $price, $gwe, $picturesid, $active)
    {
        include $_SERVER['DOCUMENT_ROOT']."/lib/mail/mail.php";

        $stmt = $this->conn->prepare('INSERT INTO pand (adres, city, postalcode, description, price, `gwe_price`, picturesid, active) 
                                VALUES(:adres, :city, :postalcode, :description, :price, :gwe_price, :pricturesid, :active)');
        $stmt->bindParam(':adres',$adres,PDO::PARAM_STR);
        $stmt->bindParam(':city',$city,PDO::PARAM_STR);
        $stmt->bindParam(':postalcode',$postalcode,PDO::PARAM_STR);
        $stmt->bindParam(':description',$description,PDO::PARAM_STR);
        $stmt->bindParam(':price',$price,PDO::PARAM_INT);
        $stmt->bindParam(':gwe_price',$gwe,PDO::PARAM_INT);
        $stmt->bindParam(':pricturesid',$picturesid,PDO::PARAM_INT);
        $stmt->bindParam(':active',$active,PDO::PARAM_BOOL);

        $result = $stmt->execute();

        if ($result === TRUE) {
            var_dump("GOT HERE!");
            if ( sendToMaillist ($this->conn, $adres, $city, $postalcode, $description, $price ) === TRUE ) {
                $_SESSION['message'] = "Nieuwe woning succesvol toegevoegd.";
                return;    
            }
            else {
                $_SESSION['error'] = "Error: Er kan geen abonnement email worden verstuurd.";
                file_put_contents($_SERVER['DOCUMENT_ROOT']."/logs/errorlog.txt", date("Y-m-d H:i:s") . " - " . $_SESSION['error'] . "\r\n", FILE_APPEND);
                return;
            }
            
        } else {
            $_SESSION['error'] = "Error: " . $sql . "<br>" . $this->conn->error;
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/logs/errorlog.txt", date("Y-m-d H:i:s") . " - " . $_SESSION['error'] . "\r\n", FILE_APPEND);
            return;
        }
    }
    function deleteResidence($pandid)
    {
        try {
            $stmt = $this->conn->prepare('DELETE FROM pand WHERE pandid=:pandid');
            $stmt->bindParam(':pandid', $pandid, PDO::PARAM_INT);
            $result = $stmt->execute();

            if ($result == false){
                $_SESSION['error'] = "Er is iets mis gegaan tijdens het verwijderen van een woning.";
                file_put_contents($_SERVER['DOCUMENT_ROOT']."/logs/errorlog.txt", date("Y-m-d H:i:s") . " - " . $_SESSION['error'] . "\r\n", FILE_APPEND);
                return null;
            }else {
                return true;
            }
        }
        catch ( PDOException $e ) {
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/logs/errorlog.txt", date("Y-m-d H:i:s") . " - " . $e . "\r\n", FILE_APPEND);
            return $e;
        }
    }
    function updateResidence($pandid, $adres, $postcode, $plaats, $beschrijving, $prijs, $gwe, $picturesid, $active)
    {
        try{
            /*$sql = "UPDATE pand SET adres='$adres', city='$plaats', postalcode='$postcode', description='$beschrijving', price='$prijs',`gwe_price`='$gwe',picturesid=$picturesid WHERE pandid=$pandid";*/

            $stmt = $this->conn->prepare('UPDATE pand 
                                  SET 
                                      adres= :adres,
                                      city= :city,
                                      postalcode= :postalcode,
                                      description= :description,
                                      price= :price,
                                      gwe_price= :gwe_price,
                                      picturesid= :picturesid,
                                      active= :active 
                                  WHERE pandid=:pandid');
            $stmt->bindParam(':adres', $adres, PDO::PARAM_STR);
            $stmt->bindParam(':city', $plaats,PDO::PARAM_STR);
            $stmt->bindParam(':postalcode', $postcode,PDO::PARAM_STR);
            $stmt->bindParam(':description', $beschrijving,PDO::PARAM_STR);
            $stmt->bindParam(':price', $prijs,PDO::PARAM_INT);
            $stmt->bindParam(':gwe_price', $gwe,PDO::PARAM_INT);
            $stmt->bindParam(':picturesid',$picturesid,PDO::PARAM_INT);
            $stmt->bindParam(':active', $active,PDO::PARAM_INT);
            $stmt->bindParam(':pandid', $pandid,PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->rowCount();
            $SESSION['success'] = "Woning succesvol aangemaakt.";
            return $result;

        }
        catch ( PDOException $e ) {
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/logs/errorlog.txt", date("Y-m-d H:i:s") . " - " . $e . "\r\n", FILE_APPEND);
            return $e;
        }
    }
    function getResidencePictures($picturesid)
    {
        $sql = "SELECT * FROM `picture` WHERE picturesid='$picturesid'";

        $stmt= $this->conn->prepare('SELECT * FROM picture WHERE pictureid=:picid');
        $stmt->bindParam(':picid', $picturesid, PDO::PARAM_INT);

        $result = $this->conn->query($sql);

        if ($result != false){
            return $result;
        } else {
            $_SESSION['warning'] = "Er kunnen voor deze woning geen foto's worden gevonden.";
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/logs/errorlog.txt", date("Y-m-d H:i:s") . " - " . $_SESSION['warning'] . "\r\n", FILE_APPEND);
            return null;
        }
    }
}