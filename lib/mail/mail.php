<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "PHPMailer/src/Exception.php";
require "PHPMailer/src/PHPMailer.php";
require "PHPMailer/src/SMTP.php";
require "sql.php";

function sendToMaillist ( $adres, $city, $postalcode, $description, $price ) {
    $emails = getAllMallist();
    if ( emailMaillist ( $adres, $city, $postalcode, $description, $price, $emails ) === TRUE ) {
        return TRUE;
    }
    else {
        return FALSE;
    }
}

function sendTokenMail ( $token, $email ) {
    include_once $_SERVER['DOCUMENT_ROOT']."/lib/config/mailconfig.php";
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPDebug = 0; // Debugging. 1 = Errors. 2 = Errors en server messsages.
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587;
    $mail->IsHTML(true);
    $mail->Username = $emailaccount;
    $mail->Password = $emailpassword;
    $mail->SetFrom($emailaccount);
    $mail->Subject = "Wachtwoord Reset Code";
    $mail->Body = "Uw code: " . $token;
    $mail->AddAddress($email);
    if ( $mail->Send() ) {
        return TRUE;
    }
    else {
        return FALSE;
    }
}

function sendTypeMail ( $attachment, $type, $firstname, $surname, $images ) {
    include_once $_SERVER['DOCUMENT_ROOT']."/lib/config/mailconfig.php";
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPDebug = 0; // Debugging. 1 = Errors. 2 = Errors en server messsages.
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587;
    $mail->IsHTML(true);
    $mail->Username = $emailaccount;
    $mail->Password = $emailpassword;
    $mail->SetFrom($emailaccount);
    $mail->Subject = "[" . date("y-m-d H:i:s") . "]" . "[" . $type . "]" . " Van: " . $firstname . " " . $surname;
    $mail->Body = "Inkomend " . $type . "formulier.";
    $toEmails = getFormEmails($type);
    if ( empty( $toEmails ) ) {
        return "EMPTY";
    }
    foreach ($toEmails as $addr) {
        $mail->addAddress($addr[0]);
    }
    if ( $type === "Melding" && !empty($images) ) {
        echo "Hier!";
        foreach ($images as $image ) {
            $mail->addAttachment("uploads/" . $image, $image);
        } 
    }
    $mail->AddStringAttachment($attachment, $type . "formulier" . "-" . date("y-m-d" ) . "-" . $firstname . "." . $surname . ".pdf");
    if ( $mail->Send() ) {
        return TRUE;
    }
    else {
        return FALSE;
    }
}

function emailMaillist ( $adres, $city, $postalcode, $description, $price, $emails ) {
    include_once $_SERVER['DOCUMENT_ROOT']."/lib/config/mailconfig.php";
    foreach ($emails as $addr) {
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug = 0; // Debugging. 1 = Errors. 2 = Errors en server messsages.
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPOptions = array(
                            'ssl' => array(
                                'verify_peer' => false,
                                'verify_peer_name' => false,
                                'allow_self_signed' => true
                            )
                        );
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587;
        $mail->IsHTML(true);
        $mail->Username = $emailaccount;
        $mail->Password = $emailpassword;
        $mail->SetFrom($emailaccount);
        $mail->Subject = "Nieuwe woning!";
        $mail->addAddress($addr[0]);
        $mail->Body = "Adres: ". $adres . "<br>" . 
                "Stad: " . $city . "<br>" . 
                "Postcode: " . $postalcode . "<br>" .
                "Beschrijving: " . $description . "<br>" . 
                "Prijs: " . $price . "<br>" . 
                 "<a href=" . "localhost/uitschrijven.php?token=" . $addr[1] . "&email=" . $addr[0] . ">Nieuwsbrief niet meer ontvangen.</a>";
        if ( !$mail->Send() ) {
            return FALSE;
        }
    }
    return TRUE;
}