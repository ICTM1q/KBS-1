<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "PHPMailer/src/Exception.php";
require "PHPMailer/src/PHPMailer.php";
require "PHPMailer/src/SMTP.php";
require "sql.php";

function sendTokenMail ( $token, $email ) {
    include $_SERVER['DOCUMENT_ROOT']."/lib/config/mailconfig.php";
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

function sendContactMail ( $attachment, $type, $firstname, $surname ) {
    include $_SERVER['DOCUMENT_ROOT']."/lib/config/mailconfig.php";
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
    $mail->Body = "Inkomend contactformulier.";
    $toEmails = getFormEmails($type);
    foreach ($toEmails as $addr) {
        $mail->addAddress($addr);
    }
    //$mail->AddAddress("remcostoelwinder@hotmail.com");
    $mail->AddStringAttachment($attachment, "contactformulier" . "-" . date("y-m-d" ) . "-" . $firstname . "." . $surname . ".pdf");
    if ( $mail->Send() ) {
        return TRUE;
    }
    else {
        return FALSE;
    }
}

function sendComplaintMail ( $attachment, $type, $firstname, $surname, $images ) {
    include $_SERVER['DOCUMENT_ROOT']."/lib/config/mailconfig.php";
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
    $mail->Body = "Inkomend meldingformulier.";
    $toEmails = getFormEmails($type);
    foreach ($toEmails as $addr) {
        $mail->addAddress($addr);
    }
    foreach ($images as $image ) {
        $mail->addAttachment("uploads/" . $image[0], $image[0]);
    }
    $mail->AddStringAttachment($attachment, "meldingformulier" . "-" . date("y-m-d" ) . "-" . $firstname . "." . $surname . ".pdf");
    if ( $mail->Send() ) {
        return TRUE;
    }
    else {
        return FALSE;
    }
}

