//This program makes a PDF
<?php
downloadPdf('2', 'graph.jpg', 'Me');
function downloadPdf ($id,$image,$author)
{
$idFile = $id; 
$imageUrl = $image; 
$auhorUrl = $author;
$date = new DateTime(date('d-m-Y')); 

require 'fpdf/fpdf.php';

// Set some document variables
$x = 50;

//variables go in here

$text = <<<EOT
Details about the visualisation, graph/user details etc.
Based on the the query, this action is assigned to a button!.
EOT;

// Create fpdf object
$pdf = new FPDF('P', 'pt', 'Letter');
// Set base font to start
$pdf->SetFont('Times', 'B', 24);
// Add a new page to the document
$pdf->addPage();
// Set the x,y coordinates of the cursor
$pdf->SetXY($x,50);
// Write 'Simple PDF' with a line height of 1 at the current position
$pdf->Write(25,'VisuCosmos.info');
// Reset the font
$pdf->SetFont('Courier','I',10);
// Set the font color
$pdf->SetTextColor(255,0,0);
// Reset the cursor, write again.
$pdf->SetXY($x, 75);
$pdf->Cell(0,11, "By: $authorUrl", 'B', 2, 'L', false);

// Place an image on the pdf document
$pdf->Image($imageUrl, $x, 100, 150, 112.5, 'JPG');

// Reset font, color, and coordinates
$pdf->SetFont('Arial','',12);
$pdf->SetTextColor(0,0,0);
$pdf->SetXY($x, 250);

// Write out a long text blurb.
$pdf->write(13, $text);

// Close the document and save to the filesystem with the name simple.pdf
$filename = $idFile . '.pdf';
$pdf->Output($filename,'F');
}
?>