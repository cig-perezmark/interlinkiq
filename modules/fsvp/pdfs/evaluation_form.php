<?php

$data = $conn->execute("SELECT *
    FROM tbl_fsvp_evaluation_records REC
    WHERE MD5(REC.id) = ?
", $recordId)->fetchAssoc();

require_once __DIR__ . '/../../../assets/TCPDF/tcpdf.php';

$pdf = new TCPDF();
$pdf->SetCreator('Consultare Inc.');
$pdf->SetAuthor('InterlinkIQ.com');
// $pdf->SetTitle($haccpResource['description'] . ' - PDF');
// $pdf->SetSubject('HACCP Plan');
// $pdf->SetPrintHeader(true);
// $pdf->SetMargins(MARGIN_LEFT, MARGIN_TOP, MARGIN_RIGHT, MARGIN_BOTTOM);
// $pdf->SetFont('helvetica', '', 10);
// $pdf->setAutoPageBreak(true, MARGIN_BOTTOM);

$pdf->AddPage('P');
$pdf->writeHTML('hello world');

$pdf->Output('test.pdf', 'I');