<?php

require_once __DIR__ . '/../../assets/TCPDF/tcpdf.php';
include_once __DIR__ .'/utils.php';

define('MARGIN_LEFT', 54);
define('MARGIN_RIGHT', 54);
define('MARGIN_TOP', 54);
// define('MARGIN_TOP', 72);
define('MARGIN_BOTTOM', 54);

if(isset($_GET['pdf'])) {
    $pdfView = $_GET['pdf'];
    $recordId = $_GET['r'] ?? null;
    
    if(empty($recordId)) {
        die('Incorrect parameter(s).');
    }

    $title = 'DOCUMENT TITLE';
    $css = '
        <style>
            table { width: 100%; padding: 5px; }
            td, th { border: 1px solid black;}
        </style>
    ';

    // fetching company logo

    $company = $conn->execute("SELECT BrandLogos as logo from tblEnterpiseDetails WHERE users_entities = ?", $user_id)->fetchAssoc();
    $logo = !empty($company['logo']) ? ('companyDetailsFolder/' . $company['logo']) : 'https://via.placeholder.com/150x150/EFEFEF/AAAAAA.png?text=no+image';

    // custom TCPDF class
    class TCPDF2 extends TCPDF {
        public function __construct() {
            parent::__construct('P', 'pt', 'Letter');
        }
        // auto cleaning 
        public function __destruct() {
            $this->endPage();
            $this->close();
            parent::__destruct();
        }
        // override header 
        public function Header() {
            global $logo;
            // $pageNo = $this->getAliasNumPage();
            // $totalPage = $this->getAliasNbPages();
            // $this->SetY(20);
            $html = '
                <table style="width:100%; padding:5px 5px 5px 5px">
                    <tr>
                        <td style="text-align:center;">
                            <img src="'.$logo.'" height="50" border="0">
                        </td>
                    </tr>
                </table>
            ';
            $this->writeHTML($html);
        }
    }

    $pdf = new TCPDF2();
    $pdf->SetCreator('Consultare Inc.');
    $pdf->SetAuthor('InterlinkIQ.com');
    $pdf->SetSubject('Foreign Supplier Verification Program');
    $pdf->SetPrintHeader(true);
    $pdf->SetMargins(MARGIN_LEFT, MARGIN_TOP, MARGIN_RIGHT, MARGIN_BOTTOM);
    $pdf->SetFont('helvetica', '', 10);
    $pdf->setAutoPageBreak(true, MARGIN_BOTTOM);

    include_once __DIR__ . match($pdfView) {
        'evaluation_form'       => '/pdfs/evaluation_form.php',
        'cbp'                   => '/pdfs/cbp_filing_form.php',
        'importer_information'  => '/pdfs/importer_info.php',
        'ipr'                   => '/pdfs/ingredient_product_register.php',
        'activities-worksheet'  => '/pdfs/activities_worksheet.php',
        default                 => '/pdfs/default.php',
    };
}

function debugger($data, $mode = false) {
    global $debugging;

    if(empty($data)) {
        exit('Record not found.');
    }
    
    if($mode || (isset($debugging) && $debugging)) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
}

function txt($value, $default = 'N/A') {
    return empty($value) ? $default : $value;
}