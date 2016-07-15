<?php

// Nasumican naziv dokumenta
function nasumicanString($length = 3) {
    $characters = '0123456789';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}


$ime_strane =  $_GET["ime_strane"];
$sadrzaj = $_GET["sadrzaj"];
  
require('tcpdf/fpdf.php'); 
class PDF extends FPDF {
 
function Header() {
    $this->SetFont('Times','',12);
	$this->Image("images/head.jpg", 0, 0, 8.267, 11.693, "JPG", FALSE);
   
    
    $this->SetY(1.9);
}
 
function Footer() {
	$this->SetY(10.74);
	$this->Cell(0, .25, "Strana ".$this->PageNo(), 'B', 0, "R");
    $this->Image("images/logo.jpg", (8.5/2)-1.5, 9.7, 3, 1, "JPG", "http://www.deltafox.rs");
}
 
}
 
$pdf=new PDF("P","in","A4");
 
$pdf->SetMargins(1,1,1);
 
$pdf->AddPage();
$pdf->SetFont('Times','',12);
 

  
$pdf->SetFillColor(220, 220, 220);
$pdf->SetFont('Times','BU',12);
  
$pdf->Cell(0, .25, "{$ime_strane}", 1, 2, "C", 1);
  
$pdf->SetFont('Times','',12);
$pdf->MultiCell(0, 0.5, $sadrzaj, 'LR', "L");
$pdf->MultiCell(0, 0.25, 'MOJ CMS', 1, "R");

  
$pdf->Output("dokument_".nasumicanString()."_".date('d-m-Y') . '.pdf', 'I');
?>