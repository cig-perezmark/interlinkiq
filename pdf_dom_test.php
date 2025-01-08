<?php


// Include autoloader 
require_once 'dompdf/autoload.inc.php'; 

// reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;

// Enable HTML5 parser
$options = new Options();
$options->set('isHtml5ParserEnabled', true);

$options->set('dpi', 150);

// instantiate and use the dompdf class
$dompdf = new Dompdf($options);

// Render an HTML line containing a '<' character
$html = '<p>There is a less-than character after this word < Is it rendered?</p>';
$dompdf->loadHtml($html);
$dompdf->getErrors();

 // (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
// $dompdf->stream();
$dompdf->stream('PDF -'.date('Ymd'), array("Attachment" => 0));


?>