<?php

	require_once 'dompdf/autoload.inc.php';

	// reference the Dompdf namespace
	use Dompdf\Dompdf;
	use Dompdf\Options;

	$options = new Options();
	$options->set('defaultFont', 'Courier');

	// instantiate and use the dompdf class
	// $dompdf = new Dompdf();
	$dompdf = new Dompdf($options);
	$dompdf->loadHtml('hello world', LIBXML_NOERROR);

	// (Optional) Setup the paper size and orientation
	$dompdf->setPaper('A4', 'landscape');

	// Render the HTML as PDF
	$dompdf->render();

	// Output the generated PDF to Browser
	// $dompdf->stream();
    $dompdf->stream('PDF -'.date('Ymd'), array("Attachment" => 0));
    
?>