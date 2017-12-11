<?php
require ("fpdf.php");

// Funcite om te pdf input te verwerken.
function pdfHBContactFunc ( $firstname, $insertion, $surname, $email, $telno, $street, $city, $houseno, $zip, $message, $secureImage, $captchaCode ) {
    // Alles definieren.
    $pdfHBContactArray = array();
    $pdfHBContactArray["result"] = FALSE;
    
    $pdfHBContactFirstnameFlag = TRUE;
    $pdfHBContactSurnameFlag = TRUE;
    $pdfHBContactEmailFlag = TRUE;
    $pdfHBContactTelnoFlag = TRUE;
    $pdfHBContactTelnoFlag = TRUE;
    $pdfHBContactStreetFlag = TRUE;
    $pdfHBContactCityFlag = TRUE;
    $pdfHBContactHousenoFlag = TRUE;
    $pdfHBContactZipFlag = TRUE;
    $pdfHBContactMessageFlag = TRUE;
    $pdfHBContactCaptchaFlag = TRUE;
    
    $pdfHBContactArray["firstnameErr"] = "";
    $pdfHBContactArray["surnameErr"] = "";
    $pdfHBContactArray["emailErr"] = "";
    $pdfHBContactArray["telnoErr"] = "";
    $pdfHBContactArray["streetErr"] = "";
    $pdfHBContactArray["cityErr"] = "";
    $pdfHBContactArray["housenoErr"] = "";
    $pdfHBContactArray["zipErr"] = "";
    $pdfHBContactArray["messageErr"] = "";
    $pdfHBContactArray["captchaErr"] = "";
    
    // Kijk of email leeg is.
    if ( empty ( $firstname ) ) {
        $pdfHBContactArray["firstnameErr"] = "Voornaam is vereist.";
        $pdfHBContactFirstnameFlag = FALSE;
    }
    if ( empty ( $surname ) ) {
        $pdfHBContactArray["surnameErr"] = "Achternaam is vereist.";
        $pdfHBContactSurnameFlag = FALSE;
    }
    if ( empty ( $email ) ) {
        $pdfHBContactArray["emailErr"] = "Email is vereist.";
        $pdfHBContactEmailFlag = FALSE;
    }
    if ( empty ( $telno ) ) {
        $pdfHBContactArray["telnoErr"] = "Telefoon nummer is vereist.";
        $pdfHBContactTelnoFlag = FALSE;
    }
    if ( empty ( $street ) ) {
        $pdfHBContactArray["streetErr"] = "Straat is vereist.";
        $pdfHBContactStreetFlag = FALSE;
    }
    if ( empty ( $city ) ) {
        $pdfHBContactArray["cityErr"] = "Plaats is vereist.";
        $pdfHBContactCityFlag = FALSE;
    }
    if ( empty ( $houseno ) ) {
        $pdfHBContactArray["housenoErr"] = "Huisnummer is vereist.";
        $pdfHBContactHousenoFlag = FALSE;
    }
    if ( empty ( $zip ) ) {
        $pdfHBContactArray["zipErr"] = "Postcode is vereist.";
        $pdfHBContactZipFlag = FALSE;
    }
    // Kijk of message leeg is.
    if ( empty ( $message ) ) {
        $pdfHBContactArray["messageErr"] = "Voer A.U.B. uw klacht in.";
        $pdfHBContactMessageFlag = FALSE;
    }
    // Kijk of captchacode leeg is.
    if ( empty ( $captchaCode ) ) {
        $pdfHBContactArray["captchaErr"] = "Captcha is vereist.";
        $pdfHBContactCaptchaFlag = FALSE;
    }
    // Kijk of alles nog op TRUE staat.
    if ( $pdfHBContactFirstnameFlag === TRUE && $pdfHBContactSurnameFlag === TRUE && $pdfHBContactEmailFlag == TRUE && $pdfHBContactTelnoFlag == TRUE && $pdfHBContactMessageFlag == TRUE && $pdfHBContactCaptchaFlag == TRUE ) {
        // Kijk of captcha fout is.
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $pdfHBContactArray["emailErr"] = "Email is ongeldig.";
        }
        else {
            if ($secureImage->check($captchaCode) == FALSE) {
                $pdfHBContactArray["captchaErr"] = "Captcha is fout!";
            }
            // Als alles ingevuld is en de captcha goed is maak de pdf.
            else {
                class PDF extends FPDF {
                    function Header() {
                    // Logo
                    $this->Image("../lib/fpdf/logo_groot.png",10,5,65);
                    // Arial bold 15
                    $this->SetFont("Arial","B",15);
                    // Move to the right
                    $this->Cell(80);
                    // Title
                    $this->Cell(35,18,"Contactformulier",0,0,"C");

                    $this->Line(20, 35, 210-20, 35);
                    // Line break
                    $this->Ln(30);
                    }
                }
                $pdf = new PDF();
                $pdf->AliasNbPages();
                $pdf->AddPage();
                $pdf->SetFont("Arial","",12);
                $pdf->Cell(35,10,"Voornaam: " . $firstname);
                $pdf->Ln(8);
                $pdf->Cell(35,10,"Achternaam: " . $surname);
                $pdf->Ln(8);
                $pdf->Cell(35,10,"Email: " . $email);
                $pdf->Ln(8);
                $pdf->Cell(35,10,"Telefoon nummer: " . $telno);
                $pdf->Ln(5);
                $pdf->Line(20, 78, 210-20, 78);
                $pdf->Ln(15);
                $pdf->Multicell(190,7.5,"Klacht: \n" . $message);
                $pdfHBContactArray["pdf"] = $pdf;
                $pdfHBContactArray["result"] = TRUE;
            }
        }
    }
    return $pdfHBContactArray;
}

?>