<?php

$data = $conn->execute("SELECT 
        ipr.id,
        ipr.product_id,
        mat.material_name AS product_name,
        mat.description,
        ipr.brand_name,
        ipr.ingredients_list,
        ipr.intended_use,
        sup.ID as importer_id,
        sup.name AS importer_name
    FROM tbl_fsvp_ingredients_product_register ipr
    LEFT JOIN tbl_supplier_material mat ON mat.ID = ipr.product_id
    LEFT JOIN tbl_supplier sup ON sup.ID = ipr.importer_id
    WHERE MD5(ipr.id) = ?
", $recordId)->fetchAssoc(function($d) {
    return $d;
});

if(empty($data)) {
    die('Record not found (empty set).');
}

// header('Content-Type: application/json');
// echo json_encode($data);
// exit();

require_once __DIR__ . '/../../../assets/TCPDF/tcpdf.php';

$title = 'FSVP Ingredient Product Register';
$css = '
    <style>
        table { width: 100%; padding: 5px; }
        td, th { border: 1px solid black; text-align: justify; }
    </style>
';


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
        // global $haccpResource, $enterp_name, $enterp_address, $supersedes;
        // $pageNo = $this->getAliasNumPage();
        // $totalPage = $this->getAliasNbPages();
        // $this->SetY(20);
        $html = '
            <table width="100%">
                <tr>
                    <td style="color:gray;">Header</td>
                </tr>
            </table>
        ';
        $this->writeHTML($html);
    }
}

$pdf = new TCPDF2();
$pdf->SetCreator('Consultare Inc.');
$pdf->SetAuthor('InterlinkIQ.com');
$pdf->SetTitle($title);
$pdf->SetSubject('Foreign Supplier Verification Program');
$pdf->SetPrintHeader(true);
// $pdf->SetMargins(MARGIN_LEFT, MARGIN_TOP, MARGIN_RIGHT, MARGIN_BOTTOM);
$pdf->SetFont('helvetica', '', 10);
// $pdf->setAutoPageBreak(true, MARGIN_BOTTOM);

$pdf->AddPage('L');
$html = $css . '
    <h3 style="text-align:center;">'.$title.'</h3>
    <table>
        <tr>
            <th>FSVP Importer Name</th>
            <th>Product Name</th>
            <th>Product Description</th>
            <th>Ingredient Name</th>
            <th>Finished Product Brand Name</th>
            <th>Intended Use</th>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <p></p>
';
$pdf->writeHTML($html);
$pdf->writeHTML('
    <style>
        table { width: 100%; padding: 5px; }
    </style>
    <table class="borderless">
        <tr>
            <td class="borderless">Reviewed By:</td>
            <td>Approved By:</td>
        </tr>
        <tr>
            <td>Signature:</td>
            <td>Signature:</td>
        </tr>
        <tr>
            <td>Date:</td>
            <td>Date:</td>
        </tr>
    </table>
    <p style="">Note: Review and return this form to the Quality Personnel within 24 hours. If the document is not approved, state the reason in the comment section below.</p>
');
$pdf->writeHTML($css . '
    <p></p>Comments:
    <br><table>
        <tr>
            <td></td>
        </tr>
    </table>
');

$pdf->Output('test.pdf', 'I');