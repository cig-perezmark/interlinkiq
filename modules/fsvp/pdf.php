<?php

include_once __DIR__ .'/utils.php';

if(isset($_GET['pdf'])) {
    $pdfView = $_GET['pdf'];

    switch ($pdfView) {
        case 'evaluation_form':
            $recordId = $_GET['r'] ?? null;

            if(empty($recordId)) {
                die('Record not found.');
            }
            
            include_once __DIR__ .'/pdfs/evaluation_form.php';
            break;
        default:
            echo 'default';
            break;
    }
}