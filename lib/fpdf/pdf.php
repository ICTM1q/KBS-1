<?php
require("fpdf.php");

// Functie om formulieren mee af te handelen.
function pdfTypeFunc ( $firstname, $insertion, $surname, $email, $telno, $street, $city, $houseno, $zip, $complaint, $secureImage, $captchaCode, $type ) {
    
    // Alles definieren.
    $pdfTypeArray = array();
    $pdfTypeArray["result"] = FALSE;
    
    $pdfTypeFirstnameFlag = TRUE;
    $pdfTypeSurnameFlag = TRUE;
    $pdfTypeEmailFlag = TRUE;
    $pdfTypeTelnoFlag = TRUE;
    $pdfTypeStreetFlag = TRUE;
    $pdfTypeCityFlag = TRUE;
    $pdfTypeHousenoFlag = TRUE;
    $pdfTypeZipFlag = TRUE;
    $pdfTypeComplaintFlag = TRUE;
    $pdfTypeCaptchaFlag = TRUE;
    
    $pdfTypeArray["firstnameErr"] = "";
    $pdfTypeArray["surnameErr"] = "";
    $pdfTypeArray["emailErr"] = "";
    $pdfTypeArray["telnoErr"] = "";
    $pdfTypeArray["streetErr"] = "";
    $pdfTypeArray["cityErr"] = "";
    $pdfTypeArray["housenoErr"] = "";
    $pdfTypeArray["zipErr"] = "";
    $pdfTypeArray["ComplaintErr"] = "";
    $pdfTypeArray["captchaErr"] = "";
    
    // Kijk of email leeg is.
    if ( empty ( $firstname ) ) {
        $pdfTypeArray["firstnameErr"] = "Voornaam is vereist.";
        $pdfTypeFirstnameFlag = FALSE;
    }
    if ( empty ( $surname ) ) {
        $pdfTypeArray["surnameErr"] = "Achternaam is vereist.";
        $pdfTypeSurnameFlag = FALSE;
    }
    if ( empty ( $email ) ) {
        $pdfTypeArray["emailErr"] = "Email is vereist.";
        $pdfTypeEmailFlag = FALSE;
    }
    if ( empty ( $telno ) ) {
        $pdfTypeArray["telnoErr"] = "Telefoonnummer is vereist.";
        $pdfTypeTelnoFlag = FALSE;
    }
    if ( empty ( $street ) ) {
        $pdfTypeArray["streetErr"] = "Straat is vereist.";
        $pdfTypeStreetFlag = FALSE;
    }
    if ( $type !== "Contact") {
        if ( empty ( $city ) ) {
            $pdfTypeArray["cityErr"] = "Plaats is vereist.";
            $pdfTypeCityFlag = FALSE;
        }
        if ( empty ( $houseno ) ) {
            $pdfTypeArray["housenoErr"] = "Huisnummer is vereist.";
            $pdfTypeHousenoFlag = FALSE;
        }
        if ( empty ( $zip ) ) {
            $pdfTypeArray["zipErr"] = "Postcode is vereist.";
            $pdfTypeZipFlag = FALSE;
        }
    }
    // Kijk of complaint leeg is.
    if ( empty ( $complaint ) ) {
        $pdfTypeArray["complaintErr"] = "Voer A.U.B. uw klacht in.";
        $pdfTypeComplaintFlag = FALSE;
    }
    // Kijk of captchacode leeg is.
    if ( empty ( $captchaCode ) ) {
        $pdfTypeArray["captchaErr"] = "Captcha is vereist.";
        $pdfTypeCaptchaFlag = FALSE;
    }
    // Kijk of alles nog op TRUE staat. Als het type contact is hoeft er niet veel gecheckt te worden, anders wel. Als alles goed gaat er een flag naar TRUE.
    $proceedFlag = FALSE;
    if ( $type !== "Contact") {
        if ( $pdfTypeFirstnameFlag === TRUE && $pdfTypeSurnameFlag === TRUE && $pdfTypeEmailFlag == TRUE && $pdfTypeTelnoFlag == TRUE 
                && $pdfTypeStreetFlag === TRUE && $pdfTypeCityFlag = TRUE && $pdfTypeComplaintFlag == TRUE && $pdfTypeCaptchaFlag == TRUE 
                && $pdfTypeHousenoFlag === TRUE && $pdfTypeZipFlag === TRUE ) {

            $proceedFlag = TRUE;
        }
    }      
    else {
        if ( $pdfTypeFirstnameFlag === TRUE && $pdfTypeSurnameFlag === TRUE && $pdfTypeEmailFlag == TRUE && $pdfTypeTelnoFlag == TRUE 
            && $pdfTypeComplaintFlag == TRUE && $pdfTypeCaptchaFlag == TRUE ) {

            $proceedFlag = TRUE;
        }
    }
    if ( $proceedFlag === TRUE ) {
        // Zet flags voor validatie email en telefoonnummer. 
        $pdfTypeArrayEmailIsValidFlag = TRUE;
        $pdfTypeArrayTelnoIsValidFlag = TRUE;
        // Kijk of email valid is.
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $pdfTypeArray["emailErr"] = "Email is ongeldig.";
            $pdfTypeArrayEmailIsValidFlag = FALSE;
        }
        // Kijk of telefoonnummer alleen cijfers bevat.
        if (!is_numeric($telno)) {
            $pdfTypeArray["telnoErr"] = "Telefoon nummer is ongeldig.";
            $pdfTypeArrayTelnoIsValidFlag = FALSE;
        }
        // Als alles klopt ga door.
        if ( $pdfTypeArrayEmailIsValidFlag === TRUE && $pdfTypeArrayTelnoIsValidFlag === TRUE ) {
            // Kijk of captcha fout is.
            if ($secureImage->check($captchaCode) == FALSE) {
                $pdfTypeArray["captchaErr"] = "Captcha is fout!";
            }
            // Als alles ingevuld is en de captcha goed is maak de pdf.
            else {
                $pdfTypeArray["pdf"] = createPdf($firstname, $surname, $insertion, $email, $telno, $street, $city, $houseno, $zip, $complaint, $type);
                $pdfTypeArray["result"] = TRUE;
            }
        }
    }
    return $pdfTypeArray;
}

// Functie om PDF aan te maken.
function createPdf ( $firstname, $surname, $insertion, $email, $telno, $street, $city, $houseno, $zip, $message, $type ) {
    // Kijk wat voor plaatje in het PDF bestand moet. 

    if ( $type === "Taxatie" ) {
        class PDF extends FPDF {
            function Header() {
                $this->Image($_SERVER['DOCUMENT_ROOT']."/css/img/hoksbergen_groot.jpg",10,5,65);
                $this->SetFont("Arial","B",15);
                $this->Cell(80);
                $this->Cell(35,18,"Formulier",0,0,"C");
                $this->Line(20, 35, 210-20, 35);
                $this->Ln(30);
            }
        }
    }
    else {
        class PDF extends FPDF {
            function Header() {
                $this->Image($_SERVER['DOCUMENT_ROOT']."/lib/fpdf/logo_groot.png",10,5,65);
                $this->SetFont("Arial","B",15);
                $this->Cell(80);
                $this->Cell(35,18,"Formulier",0,0,"C");
                $this->Line(20, 35, 210-20, 35);
                $this->Ln(30);
            }
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
    // Als het type contact is hoeft er alleen dit in, anders meer.
    if ( $type === "Contact") {
        $pdf->SetXY(23, 60);
        $pdf->Line(20, 68, 210-20, 68);
        $pdf->SetXY(23, 75);
        $pdf->Multicell(165,4.5,"Bericht: \n" . $message);
    }
    else {
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
        if ( $type === "Melding" ) {
            $pdf->Multicell(165,4.5,"Melding: \n" . $message);
        }
        else {
            $pdf->Multicell(165,4.5,"Bericht: \n" . $message);
        }
    }
    
    return $pdf;
}

?>