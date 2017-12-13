<?php
require ("fpdf.php");

// Funcite om contactverzoeken af te handelen.
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
        $pdfHBContactArray["telnoErr"] = "Telefoonnummer is vereist.";
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
        $pdfHBContactArray["messageErr"] = "Voer A.U.B. uw bericht in.";
        $pdfHBContactMessageFlag = FALSE;
    }
    // Kijk of captchacode leeg is.
    if ( empty ( $captchaCode ) ) {
        $pdfHBContactArray["captchaErr"] = "Captcha is vereist.";
        $pdfHBContactCaptchaFlag = FALSE;
    }
    // Kijk of alles nog op TRUE staat.
    if ( $pdfHBContactFirstnameFlag === TRUE && $pdfHBContactSurnameFlag === TRUE && $pdfHBContactEmailFlag == TRUE && $pdfHBContactTelnoFlag == TRUE 
            && $pdfHBContactStreetFlag === TRUE && $pdfHBContactCityFlag = TRUE && $pdfHBContactMessageFlag == TRUE && $pdfHBContactCaptchaFlag == TRUE 
            && $pdfHBContactHousenoFlag === TRUE && $pdfHBContactZipFlag === TRUE ) {
        
        // Zet flags voor validatie email en telefoonnummer. 
        $pdfHBContactArrayEmailIsValidFlag = TRUE;
        $pdfHBContactArrayTelnoIsValidFlag = TRUE;
        // Kijk of email valid is.
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $pdfHBContactArray["emailErr"] = "Email is ongeldig.";
            $pdfHBContactArrayEmailIsValidFlag = FALSE;
        }
        // Kijk of telefoonnummer alleen cijfers bevat.
        if (!is_numeric($telno)) {
            $pdfHBContactArray["telnoErr"] = "Telefoon nummer is ongeldig.";
            $pdfHBContactArrayTelnoIsValidFlag = FALSE;
        }
        // Als alles klopt ga door.
        if ( $pdfHBContactArrayEmailIsValidFlag === TRUE && $pdfHBContactArrayTelnoIsValidFlag === TRUE ) {
            // Kijk of captcha fout is.
            if ($secureImage->check($captchaCode) == FALSE) {
                $pdfHBContactArray["captchaErr"] = "Captcha is fout!";
            }
            // Als alles ingevuld is en de captcha goed is maak de pdf.
            else {
                class PDF extends FPDF {
                    function Header() {
                    $this->Image("../lib/fpdf/logo_groot.png",10,5,65);
                    $this->SetFont("Arial","B",15);
                    $this->Cell(80);
                    $this->Cell(35,18,"Contactformulier",0,0,"C");
                    $this->Line(20, 35, 210-20, 35);
                    $this->Ln(30);
                    }
                }
                $pdf = new PDF();
                $pdf->AliasNbPages();
                $pdf->SetLeftMargin(10);
                $pdf->AddPage();
                
                $pdf->SetFont("Arial","",10);
                $pdf->SetLeftMargin(10);
                
                $pdf->SetXY(23, 40);
                $pdf->Cell(35,10,"Voornaam: ");
                $pdf->SetXY(60, 40);
                $pdf->Cell(35,10,$firstname);
                
                $pdf->SetXY(23, 45);
                if (empty($insertion)) {
                    $pdf->Cell(35,10,"Achternaam: ");
                    $pdf->SetXY(60, 45);
                    $pdf->Cell(35,10,$surname);
                }
                else {
                    $pdf->Cell(35,10,"Achternaam: ");
                    $pdf->SetXY(60, 45);
                    $pdf->Cell(35,10,$surname . ", " . $insertion);
                }
                
                $pdf->SetXY(23, 50);
                $pdf->Cell(35,10,"Email: ");
                $pdf->SetXY(60, 50);
                $pdf->Cell(35,10,$email);
                
                $pdf->SetXY(23, 55);
                $pdf->Cell(35,10,"Telefoonnummer: ");
                $pdf->SetXY(60, 55);
                $pdf->Cell(35,10,$telno);
                
                $pdf->SetXY(23, 60);
                $pdf->Cell(35,10,"Woonplaats: ");
                $pdf->SetXY(60, 60);
                $pdf->Cell(35,10,$city);
                
                $pdf->SetXY(23, 65);
                $pdf->Cell(35,10,"Adres: ");
                $pdf->SetXY(60, 65);
                $pdf->Cell(35,10,$street . " " . $houseno);
                
                $pdf->SetXY(23, 70);
                $pdf->Cell(35,10,"Postcode: ");
                $pdf->SetXY(60, 70);
                $pdf->Cell(35,10,$zip);
                
                $pdf->SetXY(23, 75);
                $pdf->Line(20, 85, 210-20, 85);
                $pdf->SetXY(23, 90);
                $pdf->Multicell(165,4.5,"Bericht: \n" . $message);
                
                $pdfHBContactArray["pdf"] = $pdf;
                $pdfHBContactArray["result"] = TRUE;
            }
        }
    }
    return $pdfHBContactArray;
}

// Functie om meldingen af te handelen.
function pdfHBComplaintFunc ( $firstname, $insertion, $surname, $email, $telno, $street, $city, $houseno, $zip, $complaint, $secureImage, $captchaCode ) {
    // Alles definieren.
    $pdfHBComplaintArray = array();
    $pdfHBComplaintArray["result"] = FALSE;
    
    $pdfHBComplaintFirstnameFlag = TRUE;
    $pdfHBComplaintSurnameFlag = TRUE;
    $pdfHBComplaintEmailFlag = TRUE;
    $pdfHBComplaintTelnoFlag = TRUE;
    $pdfHBComplaintTelnoFlag = TRUE;
    $pdfHBComplaintStreetFlag = TRUE;
    $pdfHBComplaintCityFlag = TRUE;
    $pdfHBComplaintHousenoFlag = TRUE;
    $pdfHBComplaintZipFlag = TRUE;
    $pdfHBComplaintComplaintFlag = TRUE;
    $pdfHBComplaintCaptchaFlag = TRUE;
    
    $pdfHBComplaintArray["firstnameErr"] = "";
    $pdfHBComplaintArray["surnameErr"] = "";
    $pdfHBComplaintArray["emailErr"] = "";
    $pdfHBComplaintArray["telnoErr"] = "";
    $pdfHBComplaintArray["streetErr"] = "";
    $pdfHBComplaintArray["cityErr"] = "";
    $pdfHBComplaintArray["housenoErr"] = "";
    $pdfHBComplaintArray["zipErr"] = "";
    $pdfHBComplaintArray["ComplaintErr"] = "";
    $pdfHBComplaintArray["captchaErr"] = "";
    
    // Kijk of email leeg is.
    if ( empty ( $firstname ) ) {
        $pdfHBComplaintArray["firstnameErr"] = "Voornaam is vereist.";
        $pdfHBComplaintFirstnameFlag = FALSE;
    }
    if ( empty ( $surname ) ) {
        $pdfHBComplaintArray["surnameErr"] = "Achternaam is vereist.";
        $pdfHBComplaintSurnameFlag = FALSE;
    }
    if ( empty ( $email ) ) {
        $pdfHBComplaintArray["emailErr"] = "Email is vereist.";
        $pdfHBComplaintEmailFlag = FALSE;
    }
    if ( empty ( $telno ) ) {
        $pdfHBComplaintArray["telnoErr"] = "Telefoonnummer is vereist.";
        $pdfHBComplaintTelnoFlag = FALSE;
    }
    if ( empty ( $street ) ) {
        $pdfHBComplaintArray["streetErr"] = "Straat is vereist.";
        $pdfHBComplaintStreetFlag = FALSE;
    }
    if ( empty ( $city ) ) {
        $pdfHBComplaintArray["cityErr"] = "Plaats is vereist.";
        $pdfHBComplaintCityFlag = FALSE;
    }
    if ( empty ( $houseno ) ) {
        $pdfHBComplaintArray["housenoErr"] = "Huisnummer is vereist.";
        $pdfHBComplaintHousenoFlag = FALSE;
    }
    if ( empty ( $zip ) ) {
        $pdfHBComplaintArray["zipErr"] = "Postcode is vereist.";
        $pdfHBComplaintZipFlag = FALSE;
    }
    // Kijk of complaint leeg is.
    if ( empty ( $complaint ) ) {
        $pdfHBComplaintArray["complaintErr"] = "Voer A.U.B. uw klacht in.";
        $pdfHBComplaintComplaintFlag = FALSE;
    }
    // Kijk of captchacode leeg is.
    if ( empty ( $captchaCode ) ) {
        $pdfHBComplaintArray["captchaErr"] = "Captcha is vereist.";
        $pdfHBComplaintCaptchaFlag = FALSE;
    }
    // Kijk of alles nog op TRUE staat.
    if ( $pdfHBComplaintFirstnameFlag === TRUE && $pdfHBComplaintSurnameFlag === TRUE && $pdfHBComplaintEmailFlag == TRUE && $pdfHBComplaintTelnoFlag == TRUE 
            && $pdfHBComplaintStreetFlag === TRUE && $pdfHBComplaintCityFlag = TRUE && $pdfHBComplaintComplaintFlag == TRUE && $pdfHBComplaintCaptchaFlag == TRUE 
            && $pdfHBComplaintHousenoFlag === TRUE && $pdfHBComplaintZipFlag === TRUE ) {
        
        // Zet flags voor validatie email en telefoonnummer. 
        $pdfHBComplaintArrayEmailIsValidFlag = TRUE;
        $pdfHBComplaintArrayTelnoIsValidFlag = TRUE;
        // Kijk of email valid is.
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $pdfHBComplaintArray["emailErr"] = "Email is ongeldig.";
            $pdfHBComplaintArrayEmailIsValidFlag = FALSE;
        }
        // Kijk of telefoonnummer alleen cijfers bevat.
        if (!is_numeric($telno)) {
            $pdfHBComplaintArray["telnoErr"] = "Telefoon nummer is ongeldig.";
            $pdfHBComplaintArrayTelnoIsValidFlag = FALSE;
        }
        // Als alles klopt ga door.
        if ( $pdfHBComplaintArrayEmailIsValidFlag === TRUE && $pdfHBComplaintArrayTelnoIsValidFlag === TRUE ) {
            // Kijk of captcha fout is.
            if ($secureImage->check($captchaCode) == FALSE) {
                $pdfHBComplaintArray["captchaErr"] = "Captcha is fout!";
            }
            // Als alles ingevuld is en de captcha goed is maak de pdf.
            else {
                class PDF extends FPDF {
                    function Header() {
                    $this->Image("../lib/fpdf/logo_groot.png",10,5,65);
                    $this->SetFont("Arial","B",15);
                    $this->Cell(80);
                    $this->Cell(35,18,"Meldingformulier",0,0,"C");
                    $this->Line(20, 35, 210-20, 35);
                    $this->Ln(30);
                    }
                }
                $pdf = new PDF();
                $pdf->AliasNbPages();
                $pdf->SetLeftMargin(10);
                $pdf->AddPage();
                
                $pdf->SetFont("Arial","",10);
                $pdf->SetLeftMargin(10);
                
                $pdf->SetXY(23, 40);
                $pdf->Cell(35,10,"Voornaam: ");
                $pdf->SetXY(60, 40);
                $pdf->Cell(35,10,$firstname);
                
                $pdf->SetXY(23, 45);
                if (empty($insertion)) {
                    $pdf->Cell(35,10,"Achternaam: ");
                    $pdf->SetXY(60, 45);
                    $pdf->Cell(35,10,$surname);
                }
                else {
                    $pdf->Cell(35,10,"Achternaam: ");
                    $pdf->SetXY(60, 45);
                    $pdf->Cell(35,10,$surname . ", " . $insertion);
                }
                
                $pdf->SetXY(23, 50);
                $pdf->Cell(35,10,"Email: ");
                $pdf->SetXY(60, 50);
                $pdf->Cell(35,10,$email);
                
                $pdf->SetXY(23, 55);
                $pdf->Cell(35,10,"Telefoonnummer: ");
                $pdf->SetXY(60, 55);
                $pdf->Cell(35,10,$telno);
                
                $pdf->SetXY(23, 60);
                $pdf->Cell(35,10,"Woonplaats: ");
                $pdf->SetXY(60, 60);
                $pdf->Cell(35,10,$city);
                
                $pdf->SetXY(23, 65);
                $pdf->Cell(35,10,"Adres: ");
                $pdf->SetXY(60, 65);
                $pdf->Cell(35,10,$street . " " . $houseno);
                
                $pdf->SetXY(23, 70);
                $pdf->Cell(35,10,"Postcode: ");
                $pdf->SetXY(60, 70);
                $pdf->Cell(35,10,$zip);
                
                $pdf->SetXY(23, 75);
                $pdf->Line(20, 85, 210-20, 85);
                $pdf->SetXY(23, 90);
                $pdf->Multicell(165,4.5,"Melding: \n" . $complaint);
                
                $pdfHBComplaintArray["pdf"] = $pdf;
                $pdfHBComplaintArray["result"] = TRUE;
            }
        }
    }
    return $pdfHBComplaintArray;
}

?>