<?php

$data = $conn->execute("SELECT 
    CBP.*,
    IMP.name as importer_name,
    IMP.address as importer_address
    FROM tbl_fsvp_cbp_records CBP
    -- importer
    LEFT JOIN tbl_fsvp_importers F_IMP ON F_IMP.id = CBP.importer_id
    LEFT JOIN tbl_supplier IMP ON IMP.ID = F_IMP.importer_id
    WHERE MD5(CBP.id) = ?
", $recordId)->fetchAssoc(function($d) {
    $d['importer_address' ] = formatSupplierAddress($d['importer_address']);
    // $d['supplier_address' ] = formatSupplierAddress($d['supplier_address']);
    return $d;
});

if(empty($data)) {
    die('Record not found.');
}

// header('Content-Type: application/json');
// echo json_encode($data);
// exit();

require_once __DIR__ . '/../../../assets/TCPDF/tcpdf.php';

$title = 'FSVP CBP Filing Form';
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
$pdf->SetSubject('Foreign Supplier Verification Program Evaluation');
$pdf->SetPrintHeader(true);
// $pdf->SetMargins(MARGIN_LEFT, MARGIN_TOP, MARGIN_RIGHT, MARGIN_BOTTOM);
$pdf->SetFont('helvetica', '', 10);
// $pdf->setAutoPageBreak(true, MARGIN_BOTTOM);

$pdf->AddPage('L');
$html = $css . '
    <h3 style="text-align:center;">'.$title.'</h3>
    <table>
        <tr>
            <td>Importer Name: '.($data['importer_name'] ?? '').'</td>
            <td>Date: '.(date('Ymd', strtotime($data['created_at']))).'</td>
        </tr>
        <tr>
            <td colspan="2">Address: '.($data['importer_address']).'</td>
        </tr>
    </table>
    <p>Supplier information for FSVP importer
        <br>This Evaluation is to help the Supplier, the entity who received imported food, to ensure that an appropriate FSVP importer has been designated by parties involved in the importation of the food and that the U.S. Customs and Border Protection (CBP).
    </p>
    <table>
        <tr>
            <td>Imported Food(s) / Food Product(s) Information</td>
            <td>Supplier Information</td>
            <td>Determining FSVP Importer</td>
            <td>Designated FSVP Importer</td>
            <td>CBP Entry Filer</td>
        </tr>
        <tr>
            <td>'.($data['foods_info'] ?? 'None').'</td>
            <td>'.($data['supplier_info'] ?? 'None').'</td>
            <td>'.($data['determining_importer'] ?? 'None').'</td>
            <td>'.($data['designated_importer'] ?? 'None').'</td>
            <td>'.($data['cbp_entry_filer'] ?? 'None').'</td>
        </tr>
        <tr>
            <td colspan="5">*The Supplier identified as the FSVP “importer” in the CBP entry filing. FDA will see as responsible for complying with the FSVP rule.
                <br>** The definition of FSVP importer is if there is no U.S. owner or consignee at the time of entry and you are the U.S. agent or representative of the foreign owner or consignee.
            </td>
        </tr>
        <tr>
            <td colspan="3" style="width: 50%;">Reviewed By:</td>
            <td colspan="2" style="width: 50%;">Date:</td>
        </tr>
        <tr>
            <td colspan="3" style="width: 50%;">Approved By:</td>
            <td colspan="2" style="width: 50%;">Date:</td>
        </tr>
    </table>
    <span>Note: Review and return this form to the Quality Personnel within 24 hours. If the document is not approved, state the reason in the comment section below.</span>
    <p></p>Comments:
    <br><table>
        <tr>
            <td></td>
        </tr>
    </table>
';
$pdf->writeHTML($html);

$pdf->Output('test.pdf', 'I');