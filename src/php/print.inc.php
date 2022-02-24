<?php
$pdf = new \GameZone\src\classes\PDF();
$pdf->writeTemplate('./mainTable.tpl.php');
$pdf->Output()

// $pdf_data = generatePdf();
// $path = '/GameZone/pdf/newly_created_file.pdf';
// file_put_contents( $path, $pdf_data );
?>

<?php
require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new mPDF();

// Write some HTML code:

$mpdf->WriteHTML('<h1>Hello World</h1><br><p>My first PDF with mPDF</p>');

// Output a PDF file directly to the browser
$mpdf->Output();
?>

<?php
$mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp']);
?>