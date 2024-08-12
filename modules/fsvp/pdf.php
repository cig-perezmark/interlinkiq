<?php

require_once __DIR__ . '/../../assets/TCPDF/tcpdf.php';
include_once __DIR__ .'/utils.php';
include_once __DIR__ .'/pdf-layouts.php';

error_reporting(E_ALL);

define('MARGIN_LEFT', 54);
define('MARGIN_RIGHT', 54);
define('MARGIN_TOP', 54);
// define('MARGIN_TOP', 72);
define('MARGIN_BOTTOM', 54);

define('DEBUG', false);

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

    $title = 'FSVP';
    switch($pdfView) {
        case 'importer_information': {
            $data = $conn->execute("SELECT 
                    i.id, 
                    i.duns_no, 
                    i.fda_registration, 
                    i.evaluation_date,
                    imp.name AS importer_name, 
                    imp.address AS importer_address,
                    i.fsvpqi_id, 
                    CONCAT(TRIM(emp.first_name), ' ', TRIM(emp.last_name)) AS fsvpqi_name,
                    emp.email,
                    i.supplier_id,
                    sup.name AS supplier_name
                FROM 
                    tbl_fsvp_importers i 
                    LEFT JOIN tbl_fsvp_suppliers fsup ON i.supplier_id = fsup.id 
                    LEFT JOIN tbl_supplier imp ON imp.ID = i.importer_id
                    LEFT JOIN tbl_supplier sup ON sup.ID = fsup.supplier_id
                    LEFT JOIN tbl_fsvp_qi qi ON qi.id = i.fsvpqi_id
                    LEFT JOIN tbl_hr_employee emp ON emp.ID = qi.employee_id
                WHERE MD5(i.id) = ?
            ", $recordId)->fetchAssoc(function($d) {
                $d['importer_address' ] = formatSupplierAddress($d['importer_address']);
                return $d;
            });

            debugger($data, DEBUG);

            $data['products'] = $conn->execute("SELECT 
                        GROUP_CONCAT(mat.material_name SEPARATOR ', ') AS `all`
                    FROM tbl_fsvp_ipr_imported_by iby
                    LEFT JOIN tbl_fsvp_ingredients_product_register ipr ON ipr.id = iby.product_id
                    LEFT JOIN tbl_supplier_material mat ON mat.ID = ipr.product_id
                    WHERE iby.importer_id = ?
                        AND ipr.supplier_id = ?
                        AND iby.user_id = ?
                        AND iby.deleted_at IS NULL
                    GROUP BY iby.importer_id
                ", 
                $data['id'],
                $data['supplier_id'],
                $user_id
            )->fetchAssoc()['all'];

            debugger($data['products'], DEBUG);
            
            $title = 'Foreign Supplier Importer Information Form';
            $html = $css . getLayout($pdfView, $title, $data);
            break;
        }
        case 'evaluation_form': {
            $data = $conn->execute("SELECT 
                    REC.*,
                    IF(REC.import_alerts = 1, 'Yes', 'No') AS import_alerts,
                    IF(REC.recalls = 1, 'Yes', 'No') AS recalls,
                    IF(REC.warning_letters = 1, 'Yes', 'No') AS warning_letters,
                    IF(REC.other_significant_ca = 1, 'Yes', 'No') AS other_significant_ca,
                    IF(REC.suppliers_corrective_actions = 1, 'Yes', 'No') AS suppliers_corrective_actions,
                    IMP.name as importer_name,
                    IMP.address as importer_address,
                    SUPP.name as supplier_name,
                    SUPP.address as supplier_address,
                    EVAL.assessment,
                    EVAL.description,
                    F_IMP.id AS importer_id,
                    F_SUPP.id AS supplier_id
                FROM tbl_fsvp_evaluation_records REC
                LEFT JOIN tbl_fsvp_evaluations EVAL ON EVAL.id = REC.evaluation_id
                -- importer
                LEFT JOIN tbl_fsvp_importers F_IMP ON F_IMP.id = EVAL.importer_id
                LEFT JOIN tbl_supplier IMP ON IMP.ID = F_IMP.importer_id
                -- supplier
                LEFT JOIN tbl_fsvp_suppliers F_SUPP ON F_SUPP.id = EVAL.supplier_id
                LEFT JOIN tbl_supplier SUPP ON SUPP.ID = F_SUPP.supplier_id
                WHERE MD5(REC.id) = ?
            ", $recordId)->fetchAssoc(function($d) {
                $d['importer_address' ] = formatSupplierAddress($d['importer_address']);
                $d['supplier_address' ] = formatSupplierAddress($d['supplier_address']);
                return $d;
            });
            
            debugger($data, DEBUG);
            
            $data['products'] = $conn->execute("SELECT 
                        GROUP_CONCAT(mat.material_name SEPARATOR ', ') AS `all`
                    FROM tbl_fsvp_ipr_imported_by iby
                    LEFT JOIN tbl_fsvp_ingredients_product_register ipr ON ipr.id = iby.product_id
                    LEFT JOIN tbl_supplier_material mat ON mat.ID = ipr.product_id
                    WHERE iby.importer_id = ?
                        AND ipr.supplier_id = ?
                        AND iby.user_id = ?
                        AND iby.deleted_at IS NULL
                    GROUP BY iby.importer_id
                ", 
                $data['importer_id'],
                $data['supplier_id'],
                $user_id
            )->fetchAssoc()['all'];
            
            debugger($data['products'], DEBUG);

            $title = '(FSVP) Foreign Supplier Evaluation Form';
            $html = $css . getLayout($pdfView, $title, $data);
            break;
        }
        case 'cbp': {
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
                return $d;
            });

            debugger($data, DEBUG);

            $title = 'FSVP CBP Filing Form';
            $html = $css . getLayout($pdfView, $title, $data);

            break;
        }
        case 'ipr': {   
            $data = $conn->execute("SELECT 
                    mat.material_name AS product_name,
                    mat.description,
                    iby2.brand_name,
                    iby2.ingredients_list,
                    iby2.intended_use,
                    sup.ID as importer_id,
                    sup.name AS importer_name
                FROM tbl_fsvp_ipr_imported_by iby
                RIGHT JOIN tbl_fsvp_ipr_imported_by iby2 ON iby.importer_id = iby2.importer_id
                LEFT JOIN tbl_fsvp_ingredients_product_register ipr ON ipr.id = iby.product_id
                LEFT JOIN tbl_supplier_material mat ON mat.ID = ipr.product_id
                LEFT JOIN tbl_fsvp_importers imp ON imp.id = iby2.importer_id
                LEFT JOIN tbl_supplier sup ON sup.ID = imp.importer_id
                WHERE MD5(iby.id) = ?
            ", $recordId)->fetchAll(function($d) {
                return $d;
            });

            debugger($data, DEBUG);

            $title = 'FSVP Ingredient Product Register';

            $pdf->SetTitle($title);
            $pdf->AddPage();
            
            $pdf->writeHTML($css . getLayout('ipr-1', $title, $data));
            $pdf->writeHTML(getLayout('ipr-2', $title, $data));
            $pdf->writeHTML($css . getLayout('ipr-3', $title, $data));

            break;
        }
        case 'activities-worksheet': {
            $data = $conn->execute("SELECT 
                    imp.name AS importer_name,
                    imp.address AS importer_address,
                    sup.name AS supplier_name,
                    sup.address AS supplier_address,
                    
                    -- worksheet data
                    aw.*,

                    CONCAT(TRIM(emp.first_name), ' ', TRIM(emp.last_name)) AS qi_approval,
                    GROUP_CONCAT(sm.material_name SEPARATOR ', ') AS products
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
                    AND ipr.deleted_at IS NULL
                    
                -- other clauses
                GROUP BY aw.id
            ", $recordId)->fetchAssoc(function($d) {
                $d['importer_address' ] = formatSupplierAddress($d['importer_address']);
                $d['supplier_address' ] = formatSupplierAddress($d['supplier_address']);
                return $d;
            });

            debugger($data, DEBUG);
            
            $title = 'FOREIGN SUPPLIER VERIFICATION ACTIVITY(IES) WORKSHEET';
            $html = $css . getLayout($pdfView, $title, $data);

            break;
        }
        case 'report': {
            createFSVPReport($conn, $pdf, $recordId, $css);
            break;
        }
        default: 
            exit('FSVP PDF Default Page.');
    }

    if($pdfView !== 'ipr' && $pdfView !== 'report') {
        $pdf->SetTitle($title);
        $pdf->AddPage();
        $pdf->writeHTML($html);
    }

    $pdf->Output($title .'.pdf', 'I');
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