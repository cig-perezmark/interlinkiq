<?php

include_once __DIR__ .'/utils.php';

function txt($value, $default = 'None') {
    return empty($value) ? $default : $value;
}

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
        case 'cbp':
            $recordId = $_GET['r'] ?? null;

            if(empty($recordId)) {
                die('Record not found.');
            }
            
            include_once __DIR__ .'/pdfs/cbp_filing_form.php';
            break;
        case 'importer_information':
            $recordId = $_GET['r'] ?? null;

            if(empty($recordId)) {
                die('Record not found.');
            }
            
            include_once __DIR__ .'/pdfs/importer_info.php';
            break;
        case 'ipr':
            $recordId = $_GET['r'] ?? null;

            if(empty($recordId)) {
                die('Record not found.');
            }
            
            include_once __DIR__ .'/pdfs/ingredient_product_register.php';
            break;
        case 'activities-worksheet':
            $recordId = $_GET['r'] ?? null;

            if(empty($recordId)) {
                die('Record not found.');
            }
            
            include_once __DIR__ .'/pdfs/activities_worksheet.php';
            break;
        default:
            echo 'default';
            break;
    }
}