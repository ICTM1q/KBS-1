<?php
require ("fpdf.php");

// Funcite om te pdf input te verwerken.
function pdfContactFunc ( $firstname, $lastname, $email, $telno, $complaint, $secureImage, $captchaCode ) {
    // Alles definieren.
    $pdfArray = array();
    $pdfArray["result"] = FALSE;
    
    $pdfFirstnameFlag = TRUE;
    $pdfLastnameFlag = TRUE;
    $pdfEmailFlag = TRUE;
    $pdfTelnoFlag = TRUE;
    $pdfComplaintFlag = TRUE;
    $pdfCaptchaFlag = TRUE;
    
    $pdfArray["firstnameErr"] = "";
    $pdfArray["lastnameErr"] = "";
    $pdfArray["emailErr"] = "";
    $pdfArray["telnoErr"] = "";
    $pdfArray["complaintErr"] = "";
    $pdfArray["captchaErr"] = "";
    
    // Kijk of email leeg is.
    if ( empty ( $firstname ) ) {
        $pdfArray["firstnameErr"] = "Voornaam is vereist.";
        $pdfFirstnameFlag = FALSE;
    }
    if ( empty ( $firstname ) ) {
        $pdfArray["lastnameErr"] = "Achternaam is vereist.";
        $pdfLastnameFlag = FALSE;
    }
    if ( empty ( $email ) ) {
        $pdfArray["emailErr"] = "Email is vereist.";
        $pdfEmailFlag = FALSE;
    }
    if ( empty ( $telno ) ) {
        $pdfArray["telnoErr"] = "Telefoon nummer is vereist.";
        $pdfTelnoFlag = FALSE;
    }
    // Kijk of complaint leeg is.
    if ( empty ( $complaint ) ) {
        $pdfArray["complaintErr"] = "Voer A.U.B. uw klacht in.";
        $pdfComplaintFlag = FALSE;
    }
    // Kijk of captchacode leeg is.
    if ( empty ( $captchaCode ) ) {
        $pdfArray["captchaErr"] = "Captcha is vereist.";
        $pdfCaptchaFlag = FALSE;
    }
    // Kijk of alles nog op TRUE staat.
    if ( $pdfFirstnameFlag === TRUE && $pdfLastnameFlag === TRUE && $pdfEmailFlag == TRUE && $pdfTelnoFlag == TRUE && $pdfComplaintFlag == TRUE && $pdfCaptchaFlag == TRUE ) {
        // Kijk of captcha fout is.
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $pdfArray["emailErr"] = "Email is ongeldig.";
        }
        else {
            if ($secureImage->check($captchaCode) == FALSE) {
                $pdfArray["captchaErr"] = "Captcha is fout!";
            }
            // Als alles ingevuld is en de captcha goed is maak de pdf.
            else {
                class PDF extends FPDF {
                    function Header() {
                    // Logo
                    $this->Image("lib/fpdf/logo_groot.png",10,5,65);
                    // Arial bold 15
                    $this->SetFont("Arial","B",15);
                    // Move to the right
                    $this->Cell(80);
                    // Title
                    $this->Cell(35,18,"Klachtformulier",0,0,"C");

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
                $pdf->Cell(35,10,"Achternaam: " . $lastname);
                $pdf->Ln(8);
                $pdf->Cell(35,10,"Email: " . $email);
                $pdf->Ln(8);
                $pdf->Cell(35,10,"Telefoon nummer: " . $telno);
                $pdf->Ln(5);
                $pdf->Line(20, 78, 210-20, 78);
                $pdf->Ln(15);
                $pdf->Multicell(190,7.5,"Klacht: \n" . $complaint);
                $pdfArray["pdf"] = $pdf;
                $pdfArray["result"] = TRUE;
            }
        }
    }
    return $pdfArray;
}

?>