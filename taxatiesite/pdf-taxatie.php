<!DOCTYPE HTml>

<HTml>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
      
require ("../lib/fpdf/fpdf.php");

// Funcite om contactverzoeken af te handelen.
function pdfHTContactFunc ( $firstname, $insertion, $surname, $email, $telno, $street, $city, $houseno, $zip, $message, $secureImage, $captchaCode ) {
    // Alles definieren.
    $pdfHTContactArray = array();
    $pdfHTContactArray["result"] = FALSE;
    
    $pdfHTContactFirstnameFlag = TRUE;
    $pdfHTContactSurnameFlag = TRUE;
    $pdfHTContactEmailFlag = TRUE;
    $pdfHTContactTelnoFlag = TRUE;
    $pdfHTContactStreetFlag = TRUE;
    $pdfHTContactCityFlag = TRUE;
    $pdfHTContactHousenoFlag = TRUE;
    $pdfHTContactZipFlag = TRUE;
    $pdfHTContactMessageFlag = TRUE;
    $pdfHTContactCaptchaFlag = TRUE;
    
    $pdfHTContactArray["firstnameErr"] = "";
    $pdfHTContactArray["surnameErr"] = "";
    $pdfHTContactArray["emailErr"] = "";
    $pdfHTContactArray["telnoErr"] = "";
    $pdfHTContactArray["streetErr"] = "";
    $pdfHTContactArray["cityErr"] = "";
    $pdfHTContactArray["housenoErr"] = "";
    $pdfHTContactArray["zipErr"] = "";
    $pdfHTContactArray["messageErr"] = "";
    $pdfHTContactArray["captchaErr"] = "";
    
    // Kijk of email leeg is.
    if ( empty ( $firstname ) ) {
        $pdfHTContactArray["firstnameErr"] = "Voornaam is vereist.";
        $pdfHTContactFirstnameFlag = FALSE;
    }
    if ( empty ( $surname ) ) {
        $pdfHTContactArray["surnameErr"] = "Achternaam is vereist.";
        $pdfHTContactSurnameFlag = FALSE;
    }
    if ( empty ( $email ) ) {
        $pdfHTContactArray["emailErr"] = "Email is vereist.";
        $pdfHTContactEmailFlag = FALSE;
    }
    if ( empty ( $telno ) ) {
        $pdfHTContactArray["telnoErr"] = "Telefoonnummer is vereist.";
        $pdfHTContactTelnoFlag = FALSE;
    }
    if ( empty ( $street ) ) {
        $pdfHTContactArray["streetErr"] = "Straat is vereist.";
        $pdfHTContactStreetFlag = FALSE;
    }
    if ( empty ( $city ) ) {
        $pdfHTContactArray["cityErr"] = "Plaats is vereist.";
        $pdfHTContactCityFlag = FALSE;
    }
    if ( empty ( $houseno ) ) {
        $pdfHTContactArray["housenoErr"] = "Huisnummer is vereist.";
        $pdfHTContactHousenoFlag = FALSE;
    }
    if ( empty ( $zip ) ) {
        $pdfHTContactArray["zipErr"] = "Postcode is vereist.";
        $pdfHTContactZipFlag = FALSE;
    }
    // Kijk of message leeg is.
    if ( empty ( $message ) ) {
        $pdfHTContactArray["messageErr"] = "Voer A.U.B. uw bericfHT in.";
        $pdfHTContactMessageFlag = FALSE;
    }
    // Kijk of captchacode leeg is.
    if ( empty ( $captchaCode ) ) {
        $pdfHTContactArray["captchaErr"] = "Captcha is vereist.";
        $pdfHTContactCaptchaFlag = FALSE;
    }
    // Kijk of alles nog op TRUE staat.
    if ( $pdfHTContactFirstnameFlag === TRUE && $pdfHTContactSurnameFlag === TRUE && $pdfHTContactEmailFlag == TRUE && $pdfHTContactTelnoFlag == TRUE 
            && $pdfHTContactStreetFlag === TRUE && $pdfHTContactCityFlag = TRUE && $pdfHTContactMessageFlag == TRUE && $pdfHTContactCaptchaFlag == TRUE 
            && $pdfHTContactHousenoFlag === TRUE && $pdfHTContactZipFlag === TRUE ) {
        
        // Zet flags voor validatie email en telefoonnummer. 
        $pdfHTContactArrayEmailIsValidFlag = TRUE;
        $pdfHTContactArrayTelnoIsValidFlag = TRUE;
        // Kijk of email valid is.
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $pdfHTContactArray["emailErr"] = "Email is ongeldig.";
            $pdfHTContactArrayEmailIsValidFlag = FALSE;
        }
        // Kijk of telefoonnummer alleen cijfers bevat.
        if (!is_numeric($telno)) {
            $pdfHTContactArray["telnoErr"] = "Telefoon nummer is ongeldig.";
            $pdfHTContactArrayTelnoIsValidFlag = FALSE;
        }
        // Als alles klopt ga door.
        if ( $pdfHTContactArrayEmailIsValidFlag === TRUE && $pdfHTContactArrayTelnoIsValidFlag === TRUE ) {
            // Kijk of captcha fout is.
            if ($secureImage->check($captchaCode) == FALSE) {
                $pdfHTContactArray["captchaErr"] = "Captcha is fout!";
            }
            // Als alles ingevuld is en de captcha goed is maak de pdf.
            else {
                class PDF extends FPDF {
                    function Header() {
                    $this->Image("lib/fpdf/logo_groot.png",10,5,65);
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
                    $pdf->Cell(35,10,"AcfHTernaam: ");
                    $pdf->SetXY(60, 45);
                    $pdf->Cell(35,10,$surname);
                }
                else {
                    $pdf->Cell(35,10,"AcfHTernaam: ");
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
                $pdf->Multicell(165,4.5,"BericfHT: \n" . $message);
                
                $pdfHTContactArray["pdf"] = $pdf;
                $pdfHTContactArray["result"] = TRUE;
            }
        }
    }
    return $pdfHTContactArray;
}

// Functie om meldingen af te handelen.
function pdfHTComplaintFunc ( $firstname, $insertion, $surname, $email, $telno, $street, $city, $houseno, $zip, $complaint, $secureImage, $captchaCode ) {
    // Alles definieren.
    $pdfHTComplaintArray = array();
    $pdfHTComplaintArray["result"] = FALSE;
    
    $pdfHTComplaintFirstnameFlag = TRUE;
    $pdfHTComplaintSurnameFlag = TRUE;
    $pdfHTComplaintEmailFlag = TRUE;
    $pdfHTComplaintTelnoFlag = TRUE;
    $pdfHTComplaintTelnoFlag = TRUE;
    $pdfHTComplaintStreetFlag = TRUE;
    $pdfHTComplaintCityFlag = TRUE;
    $pdfHTComplaintHousenoFlag = TRUE;
    $pdfHTComplaintZipFlag = TRUE;
    $pdfHTComplaintComplaintFlag = TRUE;
    $pdfHTComplaintCaptchaFlag = TRUE;
    
    $pdfHTComplaintArray["firstnameErr"] = "";
    $pdfHTComplaintArray["surnameErr"] = "";
    $pdfHTComplaintArray["emailErr"] = "";
    $pdfHTComplaintArray["telnoErr"] = "";
    $pdfHTComplaintArray["streetErr"] = "";
    $pdfHTComplaintArray["cityErr"] = "";
    $pdfHTComplaintArray["housenoErr"] = "";
    $pdfHTComplaintArray["zipErr"] = "";
    $pdfHTComplaintArray["ComplaintErr"] = "";
    $pdfHTComplaintArray["captchaErr"] = "";
    
    // Kijk of email leeg is.
    if ( empty ( $firstname ) ) {
        $pdfHTComplaintArray["firstnameErr"] = "Voornaam is vereist.";
        $pdfHTComplaintFirstnameFlag = FALSE;
    }
    if ( empty ( $surname ) ) {
        $pdfHTComplaintArray["surnameErr"] = "AcfHTernaam is vereist.";
        $pdfHTComplaintSurnameFlag = FALSE;
    }
    if ( empty ( $email ) ) {
        $pdfHTComplaintArray["emailErr"] = "Email is vereist.";
        $pdfHTComplaintEmailFlag = FALSE;
    }
    if ( empty ( $telno ) ) {
        $pdfHTComplaintArray["telnoErr"] = "Telefoonnummer is vereist.";
        $pdfHTComplaintTelnoFlag = FALSE;
    }
    if ( empty ( $street ) ) {
        $pdfHTComplaintArray["streetErr"] = "Straat is vereist.";
        $pdfHTComplaintStreetFlag = FALSE;
    }
    if ( empty ( $city ) ) {
        $pdfHTComplaintArray["cityErr"] = "Plaats is vereist.";
        $pdfHTComplaintCityFlag = FALSE;
    }
    if ( empty ( $houseno ) ) {
        $pdfHTComplaintArray["housenoErr"] = "Huisnummer is vereist.";
        $pdfHTComplaintHousenoFlag = FALSE;
    }
    if ( empty ( $zip ) ) {
        $pdfHTComplaintArray["zipErr"] = "Postcode is vereist.";
        $pdfHTComplaintZipFlag = FALSE;
    }
    // Kijk of complaint leeg is.
    if ( empty ( $complaint ) ) {
        $pdfHTComplaintArray["complaintErr"] = "Voer A.U.B. uw klacfHT in.";
        $pdfHTComplaintComplaintFlag = FALSE;
    }
    // Kijk of captchacode leeg is.
    if ( empty ( $captchaCode ) ) {
        $pdfHTComplaintArray["captchaErr"] = "Captcha is vereist.";
        $pdfHTComplaintCaptchaFlag = FALSE;
    }
    // Kijk of alles nog op TRUE staat.
    if ( $pdfHTComplaintFirstnameFlag === TRUE && $pdfHTComplaintSurnameFlag === TRUE && $pdfHTComplaintEmailFlag == TRUE && $pdfHTComplaintTelnoFlag == TRUE 
            && $pdfHTComplaintStreetFlag === TRUE && $pdfHTComplaintCityFlag = TRUE && $pdfHTComplaintComplaintFlag == TRUE && $pdfHTComplaintCaptchaFlag == TRUE 
            && $pdfHTComplaintHousenoFlag === TRUE && $pdfHTComplaintZipFlag === TRUE ) {
        
        // Zet flags voor validatie email en telefoonnummer. 
        $pdfHTComplaintArrayEmailIsValidFlag = TRUE;
        $pdfHTComplaintArrayTelnoIsValidFlag = TRUE;
        // Kijk of email valid is.
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $pdfHTComplaintArray["emailErr"] = "Email is ongeldig.";
            $pdfHTComplaintArrayEmailIsValidFlag = FALSE;
        }
        // Kijk of telefoonnummer alleen cijfers bevat.
        if (!is_numeric($telno)) {
            $pdfHTComplaintArray["telnoErr"] = "Telefoon nummer is ongeldig.";
            $pdfHTComplaintArrayTelnoIsValidFlag = FALSE;
        }
        // Als alles klopt ga door.
        if ( $pdfHTComplaintArrayEmailIsValidFlag === TRUE && $pdfHTComplaintArrayTelnoIsValidFlag === TRUE ) {
            // Kijk of captcha fout is.
            if ($secureImage->check($captchaCode) == FALSE) {
                $pdfHTComplaintArray["captchaErr"] = "Captcha is fout!";
            }
            // Als alles ingevuld is en de captcha goed is maak de pdf.
            else {
                class PDF extends FPDF {
                    function Header() {
                    $this->Image("lib/fpdf/logo_groot.png",10,5,65);
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
                    $pdf->Cell(35,10,"AcfHTernaam: ");
                    $pdf->SetXY(60, 45);
                    $pdf->Cell(35,10,$surname);
                }
                else {
                    $pdf->Cell(35,10,"AcfHTernaam: ");
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
                
                $pdfHTComplaintArray["pdf"] = $pdf;
                $pdfHTComplaintArray["result"] = TRUE;
            }
        }
    }
    return $pdfHTComplaintArray;
}


        ?>
    </body>
</HTml>
