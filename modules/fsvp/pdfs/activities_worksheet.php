<?php

$data = $conn->execute("SELECT 
        imp.name AS importer_name,
        imp.address AS importer_address,
        sup.name AS supplier_name,
        sup.address AS supplier_address,
        
        -- worksheet data
        aw.*,

        CONCAT(TRIM(emp.first_name), ' ', TRIM(emp.last_name)) AS qi_approval,
        aw.approval_date,
        aw.reevaluation_date AS evaluation_date,
        GROUP_CONCAT(sm.material_name) AS products
    FROM tbl_fsvp_activities_worksheets aw

    -- fsvp tables
    LEFT JOIN tbl_fsvp_importers fimp ON fimp.id = aw.importer_id
    LEFT JOIN tbl_fsvp_suppliers fsup ON fsup.id = aw.supplier_id
    LEFT JOIN tbl_fsvp_qi fqi ON fqi.id = aw.fsvpqi_id

    -- products
    LEFT JOIN tbl_fsvp_ipr_imported_by iby ON aw.importer_id = iby.importer_id
    LEFT JOIN tbl_fsvp_ingredients_product_register ipr ON ipr.id = iby.product_id
    LEFT JOIN tbl_supplier_material sm ON sm.ID = ipr.product_id

    -- references
    LEFT JOIN tbl_supplier imp ON imp.ID = fimp.importer_id
    LEFT JOIN tbl_supplier sup ON sup.ID = fsup.supplier_id
    LEFT JOIN tbl_hr_employee emp ON emp.ID = fqi.employee_id

    -- conditions
    WHERE MD5(aw.id) = ?
        AND aw.deleted_at IS NULL
        
    -- other clauses
    GROUP BY iby.importer_id
", $recordId)->fetchAssoc(function($d) {
    $d['importer_address' ] = formatSupplierAddress($d['importer_address']);
    $d['supplier_address' ] = formatSupplierAddress($d['supplier_address']);
    return $d;
});

if(empty($data)) {
    die('Record not found.');
}

// header('Content-Type: application/json');
// echo json_encode($data);
// exit();

require_once __DIR__ . '/../../../assets/TCPDF/tcpdf.php';

$title = 'FOREIGN SUPPLIER VERIFICATION ACTIVITY(IES) WORKSHEET';
$css = '
    <style>
        table { width: 100%; padding: 5px; }
        td, th { border: 1px solid black; }
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
            <td style="width:25%;font-weight:bold;">Importer Name:</td>
            <td style="width:75%"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">Verification Date:</td>
            <td></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">Supplier Evaluation Date:</td>
            <td></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">Address:</td>
            <td></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">QI Approval:</td>
            <td></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">Approval Date:</td>
            <td></td>
        </tr>
    </table>
    <p></p>
    <table>
        <tr>
            <td style="width:25%;font-weight:bold;">Foreign Supplier Name:</td>
            <td style="width:75%"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">Foreign Supplier Address:</td>
            <td></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">Food Product Imported:</td>
            <td></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">Food Product Description(s), including Important Food Safety Characteristics:</td>
            <td></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">Process Description (Ingredients/Packaging Materials):</td>
            <td></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">Food Safety Hazard(s) Controlled by Foreign Supplier:</td>
            <td></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">Description of Foreign Supplier Control(s):</td>
            <td></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">Verification Activity(ies) and Frequency:</td>
            <td></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">Justification for Verification Activity(ies) and Frequency:</td>
            <td></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">Verification Records (i.e audit summaries, test results):</td>
            <td></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">Assessment of Results of Verification Activity(ies):</td>
            <td></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">Corrective Action(s), if needed:</td>
            <td></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">Re-evaluation Date:</td>
            <td></td>
        </tr>
    </table>
    <p></p>Comments:
    <br><table>
        <tr>
            <td></td>
        </tr>
    </table>
';
$pdf->writeHTML($html);

$pdf->Output('test.pdf', 'I');