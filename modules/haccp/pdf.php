<?php 

include_once __DIR__ . '/../../alt-setup/setup.php';
include_once __DIR__ . '/HaccpModel.php';
include_once __DIR__ . '/api_functions.php';

include_once __DIR__ . '/init.php';
require_once __DIR__ . '/../../assets/TCPDF/tcpdf.php';

// pt unit
define('LETTER_SIZE_W', 612);
define('LETTER_SIZE_H', 792);
define('MARGIN_LEFT', 54);
define('MARGIN_RIGHT', 54);
define('MARGIN_TOP', 72);
define('MARGIN_BOTTOM', 54);

$tempDir = __DIR__ . "/temp/";
$pfdImageFile = $tempDir . 'pfd_'.time().'.png';

// writing the diagram image file
// so that we can get the dimensions
if(isset($haccpDiagramImage)) {
    $imageDataURI = $haccpDiagramImage;
    list($type, $data) = explode(';', $imageDataURI);
    list(, $data) = explode(',', $data);
    $base64Encoded = base64_decode($data);
    file_put_contents($pfdImageFile, $base64Encoded);
}

// initializing haccp team roster table
$haccpTeamTableRows = '';
$teamRoster = fetchHaccpTeamRoster($conn, $user_id);
foreach($teamRoster as $t) {
    $haccpTeamTableRows .= '<tr>
        <td style="width: 20%; font-weight: bold; text-align:center;">'.$t['primary']['position'].'</td>
        <td style="width: 30%; text-align: center;">'.($t['primary']['name'] ?? '').'</td>
        <td style="width: 20%; text-align: center;">'.$t['alternate']['position'].'</td>
        <td style="width: 30%; text-align: center;">'.($t['alternate']['name'] ?? '').'</td>
    </tr>';
}
if(!count($teamRoster)) {
    $haccpTeamTableRows .= '<tr><td colspan="4"><i>No member has been added.</i></td></tr>';
}

// initializing enterprise data
$enterpData = array();
if(isset($haccp)) {
    $enterpData = $conn->execute("SELECT BusinessPurpose,businessname,CONCAT(Bldg, ' ', city, ' ', States, ' ', ZipCode) AS address from tblEnterpiseDetails WHERE users_entities = ?", $haccp->owner_id)->fetchAssoc();
}
$enterp_name = $enterpData['businessname'] ?? null;
$enterp_address = $enterpData['address'] ?? null;
$enterp_businessPurpose = $enterpData['BusinessPurpose'] ?? null;

$signatories = $haccp->getPostDocSigns(true);
$changeHistory = $haccp->getChangeHistory();
$chLen = count($changeHistory);
$supersedes = '';
if(isset($changeHistory[$chLen - 2])) {
    $supersedes = $changeHistory[$chLen - 2]['date'] ?? '';
} else {
    $supersedes = 'ORIGINAL';
}

// css for the pdf document
function buildHtml($html, $prev = true) {
    if($prev == true) {
        $html = '<style>
            table {
                border-collapse: collapse;
                width: 100%;
                padding: 5pt 5pt 5pt 5pt;
            }
            tr.header { font-weight: bold; text-align: center; }
            td, th { border: 1px solid black; }
            td { text-align: justify !important; }
            h1 { font-size: 11pt; }
            .hazardAssessmentTable {
                width: 80%;
                margin: 0 auto;
            }
            .align-center td {
                text-align: center;
                vertical-align: middle;
            }
            .hazardAssessmentTable td {
                border: none !important;
                text-align: center;
                vertical-align: middle;
            }
            .hazardAssessmentTable .ll { font-weight: bold; }
            .hazardAssessmentTable .border { border: 1px solid #000 !important; }
            .hazardAssessmentLegend * {
                border: 1px solid #000 !important;
                font-weight: bold;
            }
            .low { background-color: #a1f1b2; }
            .significant { background-color: #f3ca8b; }
            .acceptable { background-color: #fef77d; }
            .high { background-color: #e89d9f; }
        </style>' . $html;
    }
    return (!empty($prev) && $prev != true ? $prev : '') . $html;
}

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
        global $haccpResource, $enterp_name, $enterp_address, $supersedes;
        $pageNo = $this->getAliasNumPage();
        $totalPage = $this->getAliasNbPages();
        $this->SetY(20);
        $html = '<style>
            * { font-size: 8pt; color: #888888 }
            table { border-collapse: collapse; width: 100%; padding: 2pt 3pt; }
            td { border: 1px solid #888888; }
        </style>
            <table width="100%">
                <tr>
                    <td width="12%">PRODUCT(S):</td>
                    <td width="57%">'.($haccpResource['products_name'] ?? '').'</td>
                    <td width="14%; text-align: right;">'.($haccpResource['document_code'] ?? '[DOCUMENT CODE]').'</td>
                    <td width="17%; text-align: end !important;">Page '.$pageNo.' of '.$totalPage.'</td>
                </tr>
                <tr>
                    <td>COMPANY:</td>
                    <td>'.($enterp_name ?? '[COMPANY NAME]').'</td>
                    <td>ISSUE DATE:</td>
                    <td>'.($haccpResource['issue_date'] ? date('Ymd', strtotime($haccpResource['issue_date'])) : '[ISSUE DATE]').'</td>
                </tr>
                <tr>
                    <td>ADDRESS:</td>
                    <td>'.($enterp_address ?? '[COMPANY ADDRESS]').'</td>
                    <td>SUPERSEDES:</td>
                    <td>'.($supersedes ?? '[VERSION]').'</td>
                </tr>
            </table>
        ';
        $this->writeHTML($html);
    }
}

// PDF generation
// start
$pdf = new TCPDF2();
$pdf->SetCreator('Consultare Inc.');
$pdf->SetAuthor('InterlinkIQ.com');
$pdf->SetTitle($haccpResource['description'] . ' - PDF');
$pdf->SetSubject('HACCP Plan');
$pdf->SetPrintHeader(true);
$pdf->SetMargins(MARGIN_LEFT, MARGIN_TOP, MARGIN_RIGHT, MARGIN_BOTTOM);
$pdf->SetFont('helvetica', '', 10);
$pdf->setAutoPageBreak(true, MARGIN_BOTTOM);

// title page
$developedByName = '<br />';
$developedByDate = '<br />';
$developedBySign = '<br />';

$reviewedByName = '<br />';
$reviewedByDate = '<br />';
$reviewedBySign = '<br />';

$approvedByName = '<br />';
$approvedByDate = '<br />';
$approvedBySign = '<br />';

$titleHeight = 712 - MARGIN_TOP - MARGIN_BOTTOM - 270;
$status = $haccpResource['status'];

if($status == 'Approved by CIG' || $status == 'Reviewed by Client' || $status == 'Approved by Client') {
    if(isset($signatories['developer_sign'])) {
        $developedBySign = '<img src="'.$signatories['developer_sign'].'" style="text-align:center;" border="0" height="70" align="middle" />';
    }
    
    $developedByName = $signatories['developed_by'] ;
    $developedByDate = isset($signatories['developed_at']) ? date('Y-m-d', strtotime($signatories['developed_at'])) : '';
    
    if(isset($signatories['reviewed_by'])) {
        $name = $conn->execute("SELECT CONCAT(first_name, ' ', last_name) AS name FROM tbl_hr_employee WHERE ID = ?", $signatories['reviewed_by'])->fetchAssoc()['name'] ?? '';
        $reviewedByName = $name;
        
        if(isset($signatories['reviewer_sign'])) {
            $reviewedBySign = '<img src="'.$signatories['reviewer_sign'].'" style="text-align:center;" border="0" height="70" align="middle" />';
        }
        
        if(isset($signatories['reviewed_at'])) {
            $reviewedByDate = $signatories['reviewed_at'];
        }
    }
    
    if(isset($signatories['approved_by'])) {
        $name = $conn->execute("SELECT CONCAT(first_name, ' ', last_name) AS name FROM tbl_hr_employee WHERE ID = ?", $signatories['approved_by'])->fetchAssoc()['name'] ?? '';
        $approvedByName = $name;
        
        if(isset($signatories['approver_sign'])) {
            $approvedBySign = '<img src="'.$signatories['approver_sign'].'" style="text-align:center;" border="0" height="70" align="middle" />';
        }
        
        if(isset($signatories['approved_at'])) {
            $approvedByDate = $signatories['approved_at'];
        }
    }
}

$pdf->AddPage();
$pdf->Bookmark('Title Page', 1, 0, '', 'B', array(0,0,0));
$pdf->writeHTML(buildHtml('
    <style>
    table { padding: 0; width: 100%; }
    tr, td { border: none; }
    </style>
    <table>
    <tr><td height="70"></td></tr>
    <tr>
        <td colspan="3" valign="middle" align="center" height="'.$titleHeight.'">
        <h1 style="font-size: 38pt;">'.(nl2br($haccpResource['description'])).'</h1>
        </td>
    </tr>
    <tr class="signatories">
        <td style="width: 20%;"></td>
        <td style="width: 40%; text-align:center; height:70px;">'.$developedBySign.'</td>
        <td style="width: 10%;"></td>
        <td style="width: 30%;"></td>
    </tr>
    <tr class="signatories">
        <td>Developed by:</td>
        <td style="border-bottom: 1px solid black; text-align:center;">'.$developedByName.'</td>
        <td style="text-align:center;">Date:</td>
        <td style="border-bottom: 1px solid black; text-align:center;">'.$developedByDate.'</td>
    </tr>
    <tr class="signatories">
        <td></td>
        <td style="text-align:center; height:70px;">'.$reviewedBySign.'</td>
        <td></td>
        <td></td>
    </tr>
    <tr class="signatories">
        <td>Reviewed by:</td>
        <td style="text-align:center; vertical-align:bottom;">'.$reviewedByName.'<hr /></td>
        <td style="text-align:center;">Date:</td>
        <td style="text-align:center;">'.$reviewedByDate.'<hr /></td>
    </tr>
    <tr class="signatories">
        <td></td>
        <td style="text-align:center; height:70px;">'.$approvedBySign.'</td>
        <td></td>
        <td></td>
    </tr>
    <tr class="signatories">
        <td>Approved by:</td>
        <td style="text-align:center;">'.$approvedByName.'<hr /></td>
        <td style="text-align:center;">Date:</td>
        <td style="text-align:center;">'.$approvedByDate.'<hr /></td>
    </tr>
    </table>
'));

$haccpEnterpriseId = $haccp->owner_id;
$facility = $conn->query("SELECT * FROM tblFacilityDetails where users_entities = $haccpEnterpriseId");
$facilityDetails = null;
if($facility->num_rows) {
    $facilityDetails = $facility->fetch_assoc();
    $reg = $conn->query("SELECT registration_name FROM tblFacilityDetails_registration where ownedby = $haccpEnterpriseId and table_entities = 2 and facility_id = " .$facilityDetails['facility_id']);
    if($reg->num_rows) {
        $facilityDetails['registration'] = [];
        while($regRow = $reg->fetch_assoc()) {
            $facilityDetails['registration'][] = $regRow['registration_name'];
        }
        
        $facilityDetails['registration'] = count($facilityDetails['registration']) ? implode(', ', $facilityDetails['registration']) : null;
    }
}

// Prelim pages
$pdf->AddPage();
$pdf->Bookmark('Company Overview', 0, 0, '', 'B', array(0,0,0));
$pdf->writeHTML(buildHtml('
    <h1>Company Overview</h1>
    <p style="text-align: justify;">'.$enterp_businessPurpose.'</p>
'));
$pdf->Bookmark('HACCP Team', 0, 0, '', 'B', array(0,0,0));

$pdf->writeHTML(buildHtml('
    <p></p>
    <h1>HACCP Team</h1>
    <table>
        <tr class="header">
        <td colspan="2" style="width: 50%;">Primary</td>
        <td colspan="2" style="width: 50%;">Alternate</td>
        </tr>
        '.$haccpTeamTableRows.'
    </table>
    <p></p>
    <h1>Organizational Chart</h1>
    <table style="padding:0;">
        <tr style="border:none;"><td style="border:none;">'.
                (isValid($organizationalChart) ? '<img src="'.$organizationalChart.'" border="0" width="'.(LETTER_SIZE_W - (MARGIN_LEFT + MARGIN_RIGHT)).'" align="middle" />' : "No organizational chart provided.")
            .'</td></tr>
    </table>
    <p></p>
    <h1>Facility Details</h1>'));
$pdf->Bookmark('Organizational Chart', 0, 0, '', 'B', array(0,0,0));

if($facilityDetails) {
    $pdf->writeHTML(buildHtml('<ul style="list-style-type: none;">'.
        (isValid($facilityDetails['Facility_Plant_Total_Sq']) ? "<li>Facility/Plant - {$facilityDetails['Facility_Plant_Total_Sq']}</li>" : "").
        (isValid($facilityDetails['Cooler_Chiller_Sq']) ? "<li>Cooler(s)/Chiller(s) - {$facilityDetails['Cooler_Chiller_Sq']}</li>" : "").
        (isValid($facilityDetails['Farm_Area_Sq']) ? "<li>Farm Area - {$facilityDetails['Farm_Area_Sq']}</li>" : "").
        (isValid($facilityDetails['Warehouse_Sq']) ? "<li>Warehouse - {$facilityDetails['Warehouse_Sq']}</li>" : "").
        (isValid($facilityDetails['Production_Area_Sq']) ? "<li>Production Area - {$facilityDetails['Production_Area_Sq']}</li>" : "").
        (isValid($facilityDetails['Packaging_Area_Sq']) ? "<li>Packaging Area - {$facilityDetails['Packaging_Area_Sq']}</li>" : "").
        (isValid($facilityDetails['Number_of_Employees']) ? "<li>Number of employees - {$facilityDetails['Number_of_Employees']}</li>" : "").
        (isValid($facilityDetails['Number_of_Shifts']) ? "<li>Number of Shifts - {$facilityDetails['Number_of_Shifts']}</li>" : "").
        (isValid($facilityDetails['Number_of_Lines']) ? "<li>Number of lines - {$facilityDetails['Number_of_Lines']}</li>" : "").
        (isValid($facilityDetails['registration'] ?? null) ? "<li>Registration - {$facilityDetails['registration']}</li>" : "").
    '</ul>'));
    $pdf->Bookmark('Facility Details', 0, 0, '', 'B', array(0,0,0));
}

// Product Description
$pdf->AddPage();
$pdf->Bookmark('Product Description', 0, 0, '', 'B', array(0,0,0));
function isValid($v) {
    return isset($v) && !empty(trim($v));
}
function displayAsList($arr, $emptyValue = '', $listType = 'ol') {
    $arr = array_filter($arr, function($x) { return $x !== null || isValid($x); });
    
    if(count($arr) == 0) 
        return $emptyValue;
    
    $markup = "<$listType>";
    foreach($arr as $i)  {
        $markup .= "<li style='text-align:justify;'>&nbsp;$i<br /></li>";
    }
    $markup .= "</$listType>";
    return $markup;
}
function displayWithCommas($arr, $emptyValue = '', $separator = ', ') {
    $arr = array_filter($arr, function($x) { return $x !== null || isValid($x); });
    if(count($arr) == 0) 
        return $emptyValue;
    return implode($separator, $arr);
}
function assignValue($value, $newValueFormat = null) {
    return isset($value) && (!empty(trim($value)) || (is_array($value) && count($value))) ? ($newValueFormat ?? $value) : null;
}
function displayTabularData($arr, $key, $empty = 'Not specified', $defaultvalue = 'Not specified') {
    $table = '';
    foreach($arr as $k => $d) {
        if(!assignValue($d[$key])) continue;
        $table .= '<tr>';
            $table .= '<td>'.$d['name'].'</td>';
            $table .= '<td>'.($d[$key] ?? $defaultvalue).'</td>';
        $table .= '</tr>';
    }
    
    return empty($table) ? $empty : ('<table>' . $table . '</table>');
}
$productCategory = [];
$labelRef = [];
$products = [];
$allergensPool = [
    'Milk',
    'Egg',
    'Fish (e.g., bass, flounder, cod)',
    'Crustacean shellfish (e.g., crab, lobster, shrimp)',
    'Tree nuts (e.g., almonds, walnuts, peca)',
    'Peanuts',
    'Wheat',
    'Soybeans',
    'Sesame',
    'none',
    'other',
];
if(count($haccpResource['products'])) {
    $haccpProducts = '('.implode(',', $haccpResource['products']).')';
    $productsResult = $conn->query("
        SELECT 
            tbl_products.*,
            c.name as category,
            (SELECT name FROM tbl_products_intended WHERE tbl_products_intended.ID = tbl_products.intended) AS intended_use,
            (SELECT name FROM tbl_products_category WHERE tbl_products_category.ID = tbl_products.category) AS productCategory
        FROM tbl_products 
        LEFT JOIN tbl_products_category AS c 
        ON tbl_products.category = c.ID 
        WHERE tbl_products.ID in $haccpProducts
        ORDER BY tbl_products.name ASC
    ");
    if($productsResult->num_rows) {
        while($row = $productsResult->fetch_assoc()) {
        $productCategory[] = isValid($row['productCategory']) ? ($row['productCategory'] == 'Others' ? (isValid($row['category_other']) ? $row['category_other'] :  null) : $row['productCategory']) : null;
        
        $pData = [];
        $pData['name'] = assignValue($row['name']);
        $pData['manufactured_for'] = assignValue($row['manufactured_for']);
        $pData['ingredients'] = assignValue($row['ingredient']);
        
        $pData['allergens'] = !isValid($row["allergen"]) ? [] : array_filter(array_map(function ($a) use($allergensPool, $row) {
            if($allergensPool[$a] == 'none') 
                return null;
            if($allergensPool[$a] == 'other')
                return isValid($row['allergen_other']) ? $row['allergen_other'] : null;
            return $allergensPool[$a];
        }, explode(", ", $row["allergen"])), function ($a) { return $a !== null; });
        $pData['allergens'] = implode(', ', $pData['allergens']);
        
        $pData['intended_use'] = assignValue($row['intended_use']);
        
        $pkgArr = [];
        $pkgArr[] = assignValue($row['packaging_1'], '<div><strong>Primary Packaging</strong></div>'. $row['packaging_1']);
        $pkgArr[] = assignValue($row['packaging_2'], '<div><strong>Secondary Packaging</strong></div>'. $row['packaging_2']);
        $pkgArr[] = assignValue($row['packaging_3'], '<div><strong>Tertiary Packaging</strong></div>'. $row['packaging_3']);
        
        $pData['packaging_used'] = implode('<br />', array_filter($pkgArr, function($x) { return $x != null; }));
        
        $pkgArrSz = [];
        $pkgArrSz[] = assignValue($row['count_unit_box'], $row['count_unit_box'] . ' per carton/box');
        $pkgArrSz[] = assignValue($row['count_unit_pallet'], $row['count_unit_pallet'] . ' per pallet');
        $pkgArrSz[] = assignValue($row['count_unit_carton'], $row['count_unit_carton'] . ' carton/box per pallet');
        
        $pData['packaging_sizes'] = implode(', ', array_filter($pkgArrSz, function($x) { return $x != null; }));
        
        $physical_characteristics = json_decode($row['physical_characteristics']) ?? ['Not specified'];
        $physico_chemical_characteristics = json_decode($row['physico_chemical_characteristics']) ?? ['Not specified'];
        $microbiological_characteristics = json_decode($row['microbiological_characteristics']) ?? ['Not specified'];
        
        $physical_characteristics = assignValue(implode(', ', $physical_characteristics)) ?? 'Not specified';
        $physico_chemical_characteristics = assignValue(implode(', ', $physico_chemical_characteristics)) ?? 'Not specified';
        $microbiological_characteristics = assignValue(implode(', ', $microbiological_characteristics)) ?? 'Not specified';
        
        $pData['description'] = '
            <div><strong>Physical Characteristics</strong></div>
            '.htmlspecialchars($physical_characteristics).'<br />
            <div><strong>Physico - Chemical Characteristics</strong></div>
            '.htmlspecialchars($physico_chemical_characteristics).'<br />
            <div><strong>Microbiological Characteristics</strong></div>
            '.htmlspecialchars($microbiological_characteristics).'<br />
        ';
        
        $pData['shelf_life'] = assignValue($row['shelf']);
        $pData['lcs'] = assignValue($row['lot_code']) ?? assignValue($row['mb_lot_code']) ?? assignValue($row['branded_lot_code_by_manufacturer']);
        $pData['sad'] = assignValue($row['storage'], $row['storage'] . '<br/>' . !boolval($row['export']) ? 'For local distribution only' :  (isValid($row['countries']) ? 'Internationally distributed to ' . $row['countries'] : 'Internationally distributed'));
        // [
        //      ? $row['storage'] : null,
        //     !boolval($row['export']) ? 'For local distribution only' :  (isValid($row['countries']) ? 'Internationally distributed to ' . $row['countries'] : 'Internationally distributed'),
        // ];
        $pData['label_claims'] = assignValue($row['claims'], explode(', ', $row['claims']));
        
        $claims = $pData['label_claims'] ?? [];
        $cArr = [];
        if(count($claims)) {
            $claimsString = implode(',', $claims);
            $claimsResult = $conn->query("SELECT name FROM tbl_products_claims WHERE tbl_products_claims.ID in ($claimsString)");
            $tRows = $claimsResult->num_rows;
            if($tRows) while($cR = $claimsResult->fetch_assoc()) {
                $cArr[] = $cR['name'];
            } 
            
            $cArr = implode(', ', $cArr);
        } else {
            $cArr = null;
        }
        $pData['label_claims'] = $cArr;
        
        $mainView = explode(',',$row['image'])[0];
        $labelRef[] =  assignValue($mainView, $row['name'] . '<br><br><img src="./uploads/products/' .$mainView.'" border="0" height="180" width="200" align="middle" />');
            
        $pData['intended_consumers'] = assignValue($row['intended_consumers']);
        $pData['packaging_temperature'] = assignValue($row['packaging_temperature']);
        $pData['labeling_instructions'] = assignValue($row['labeling_instructions']);
        
        $products[] = $pData;
        }
    }
}
$pdf->writeHTML(buildHtml('
    <h1>I. Product Description</h1>
    <table>
        <tr>
            <td style="font-weight: bold; width:30%;">Product Category</td>
            <td style="width:70%">'.displayWithCommas(array_unique(array_filter($productCategory, function($c) { return $c !== null; })), 'No product has been added').'</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Product Name(s)</td>
            <td>'.displayAsList(array_map(function($m) { return $m['name']; }, $products)).'</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Manufactured For</td>
            <td>'. displayTabularData($products, 'manufactured_for') .'</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Product Description, including Important Food Safety Characteristics</td>
            <td>'. displayTabularData($products, 'description') .'</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Ingredients</td>
                <td>'. displayTabularData($products, 'ingredients') .'</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Allergens</td>
                <td>'. displayTabularData($products, 'allergens') .'</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Packaging Used</td>
            <td>'. displayTabularData($products, 'packaging_used') .'</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Packaging Size(s)</td>
            <td>'. displayTabularData($products, 'packaging_sizes', 'None specified') .'</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Packaging Temperature</td>
            <td>'. displayTabularData($products, 'packaging_temperature') .'</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Intended Use</td>
            <td>'. displayTabularData($products, 'intended_use') .'</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Intended Consumers</td>
            <td>'. displayTabularData($products, 'intended_consumers') .'</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Shelf Life</td>
            <td>'. displayTabularData($products, 'shelf_life') .'</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Lot Code Specification</td>
                <td>'. displayTabularData($products, 'lcs') .'</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Labeling Instructions</td>
            <td>'. displayTabularData($products, 'labeling_instructions') .'</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Storage and Distribution</td>
            <td>'. displayTabularData($products, 'sad') .'</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Label Claims</td>
            <td>'.displayTabularData($products, 'label_claims').'</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Label Reference</td>
            <td>'.displayAsList(array_filter($labelRef, function($c) { return $c !== null; })).'</td>
        </tr>
    </table>'));

// Process Flow Diagram
$img = '';
if(!empty($haccpDiagramImage)) {
    $imageWidth = getImageSize($pfdImageFile)[0] ?? 500;
    $imageHeight = getImageSize($pfdImageFile)[1] ?? 500;
    $orientation = $imageWidth > ((LETTER_SIZE_W - (MARGIN_LEFT + MARGIN_RIGHT))) ? 'L' : 'P';
    $w = $orientation == 'L' ? LETTER_SIZE_H : LETTER_SIZE_W;
    $w -= (MARGIN_LEFT + MARGIN_RIGHT );
    
    $h = $orientation == 'L' ? LETTER_SIZE_W : LETTER_SIZE_H;
    $h -= (MARGIN_TOP + MARGIN_BOTTOM + 50);
    $img = '<img src="'.$haccpDiagramImage.'" width="'.($imageWidth < $w ? $imageWidth : $w).'" height="'.($imageHeight < $h  ? $imageHeight : $h).'" border="0" />';
}

$pdf->AddPage($orientation ?? 'L');
$pdf->setPageOrientation($orientation ?? 'L');
$pdf->Bookmark('Process Flow Diagram', 0, 0, '', 'B', array(0,0,0));
$pdf->writeHTML(buildHtml('<h1>II. Process Flow Diagram</h1>' . $img));

// Verification of Process Flow
$pdf->AddPage('P');
$pdf->setPageOrientation('P');
$pdf->Bookmark('Verification of Flow Diagram', 0, 0, '', 'B', array(0,0,0));
$html = buildHtml( '
    <h1>Verification of Flow Diagram</h1>
    <p>We, being members of the Food Safety Team have checked the process flow diagram and attest to it being correct.</p>
    <table>
        <tr class="header">
            <td style="width: 30%;">Members</td>
            <td style="width: 30%;">Position/Title</td>
            <td style="width: 40%;">Signature/Date</td>
        </tr>
');
foreach($teamSigns as $e) {
    $sign = empty($e['sign']) ? '<img src="'.$e['sign'].'" width="70" height="35" border="0">' : '';
    $html .= '
        <tr class="align-center">
            <td>'.$e['name'].'</td>
            <td>'.$e['position'] . '</td>
            <td>'.$sign.($e['date'] ?? '').'</td>
        </tr>
    ';
}
$html .= '</table>';
$pdf->writeHTML($html);

// Other tables 
$pdf->AddPage('L');
$pdf->setPageOrientation('L');
$pdf->Bookmark('Hazard Analysis', 0, 0, '', 'B', array(0,0,0));
$pdf->writeHTML(buildHtml('
    <h1>III. Hazard Analysis</h1>
    <p style="font-weight: bold;">Likelihood occurrence:</p>
    <ul>
        <li>Rarely&mdash;only one or two occurrences known historically, or has never happened</li>
        <li>Occassionally&mdash;known to occur, but less than once or twice a year</li>
        <li>Sometimes&mdash;known to occur, more frequently than a couple of times a year</li>
        <li>Frequently&mdash;known to occur on regular basis</li>
    </ul>
    <p style="font-weight: bold;">Severity of occurrence:</p>
    <ul>
        <li>Inconsequential&mdash;little to known risk to customer health or safety&mdash;nuisance or annoyance </li>
        <li>Limited&mdash;can cause some harm to a customer, but will not lead to a hospitalization clinic visit, even in a vulnerable population</li>
        <li>Moderate&mdash;will cause illness or injury to a customer, potentially leading to a hospital or clinic visit and hospitalization in a vulnerable population</li>
        <li>Catastrophic&mdash;will cause sever illness or injury with a significant chance of disability or death in all populations</li>
    </ul>
    <table class="hazardAssessmentTable">
        <tbody>
        <tr>
            <td colspan="2"></td>
            <td colspan="4" style="text-align:center;">Likelihood</td>
        </tr>
        <tr>
            <td colspan="2" style="width: 36%;">Severity</td>
            <td style="width: 16%;" class="ll border">Rarely<br>(1)</td>
            <td style="width: 16%;" class="ll border">Occassionally<br>(2)</td>
            <td style="width: 16%;" class="ll border">Sometimes<br>(3)</td>
            <td style="width: 16%;" class="ll border">Frequently<br>(4)</td>
        </tr>
        <tr>
            <td rowspan="4" style="width: 16%;"></td>
            <td class="border ll" style="width: 20%;">Inconsequential<br>(1)</td>
            <td class="border low">I&mdash;R<br>(1)</td>
            <td class="border low">I&mdash;O<br>(2)</td>
            <td class="border low">I&mdash;S<br>(3)</td>
            <td class="border low">I&mdash;F<br>(4)</td>
        </tr>
        <tr>
            <td class="border ll">Limited<br>(3)</td>
            <td class="border low">L&mdash;R<br>(3)</td>
            <td class="border acceptable">L&mdash;O<br>(6)</td>
            <td class="border acceptable">L&mdash;S<br>(9)</td>
            <td class="border significant">L&mdash;F<br>(12)</td>
        </tr>
        <tr>
            <td class="border ll">Moderate<br>(5)</td>
            <td class="border acceptable">M&mdash;R<br>(5)</td>
            <td class="border significant">M&mdash;O<br>(10)</td>
            <td class="border significant">M&mdash;S<br>(15)</td>
            <td class="border high">M&mdash;F<br>(20)</td>
        </tr>
        <tr>
            <td class="border ll">Catastrophic<br>(10)</td>
            <td class="border significant">C&mdash;R<br>(10)</td>
            <td class="border high">C&mdash;O<br>(20)</td>
            <td class="border high">C&mdash;S<br>(30)</td>
            <td class="border high">C&mdash;F<br>(40)</td>
        </tr>
        </tbody>
    </table>'));
$pdf->writeHTML(buildHtml('
    <table class="hazardAssessmentTable">
        <tbody>
        <tr>
            <td style="width: 16%;"></td>
            <td class="border low" style="width: 5%;"></td>
            <td class="border" style="width: 37%; text-align:start;font-weight:bold;">Low Risk</td>
            <td class="border significant" style="width: 5%;"></td>
            <td class="border" style="width: 37%; text-align:start;font-weight:bold;">Significant Risk (Preventive Control)</td>
        </tr>
        <tr>
            <td></td>
            <td class="border acceptable"></td>
            <td class="border" style=" text-align:start;font-weight:bold;">Acceptable Risk</td>
            <td class="border high"></td>
            <td class="border" style=" text-align:start;font-weight:bold;">High Risk (CCP)</td>
        </tr>
        </tbody>
    </table>'));

$html = buildHtml('<table>
    <tr class="header">
        <th style="width: 13%;">Process Step</th>
        <th colspan="2" style="width: 26%;">Identify potential hazards introduced, controlled, or enhanced at this step <br>
            <small> B = biological, C = chemical, P = physical</small>
        </th>
        <th style="width: 5%;">S&mdash;L</th>
        <th style="width: 10%;">Is the Potential Food Safety Hazard Reasonably Likely to Occur (RLTO)? <br>
            <small class="text-muted font-normal"> (Yes or No) </small>
        </th>
        <th style="width: 20%;">Justification/Basis for Decision</th>
        <th style="width: 18%;">What measure(s) can be applied to prevent or eliminate the hazard or reduce it to an acceptable level?</th>
        <th style="width: 8%;">PC/CCP?</th>
    </tr>');
foreach($haccpResource['processes'] as $process) {
    $ha = $process['hazardAnalysis'];
    $html .= '<tr> 
            <td rowspan="3" align="justify">('.$process['process'].') '.$process['label'].'</td>
            <td style="text-align: center !important; width: 4%; font-weight: bold;">B</td>
            <td style="width: 22%;">'.$ha['B']['potentialHazards'].'</td>
            <td class="t-center"><span class="'.($ha['B']['slRisk'] ?? '').'">'.($ha['B']['sl'] ?? '').'</span></td>
            <td>'.(yesNo($ha['B']['rlto'])).'</td>
            <td align="justify">'.$ha['B']['justification'].'</td>
            <td align="justify">'.$ha['B']['controlMeasures'].'</td>
            <td>'.$slResult($ha['B']['slRisk'] ?? '').'</td>
        </tr>
        <tr> 
            <td style="text-align: center !important; font-weight: bold;">C</td>
            <td>'.$ha['C']['potentialHazards'].'</td>
            <td class="t-center"><span class="'.($ha['C']['slRisk'] ?? '').'">'.($ha['C']['sl'] ?? '').'</span></td>
            <td>'.(yesNo($ha['C']['rlto'])).'</td>
            <td align="justify">'.$ha['C']['justification'].'</td>
            <td align="justify">'.strip_tags($ha['C']['controlMeasures']).'</td>
            <td>'.$slResult($ha['C']['slRisk'] ?? '').'</td>
        </tr>
        <tr> 
            <td style="text-align: center !important; font-weight: bold;">P</td>
            <td>'.$ha['P']['potentialHazards'].'</td>
            <td class="t-center"><span class="'.($ha['P']['slRisk'] ?? '').'">'.($ha['P']['sl'] ?? '').'</span></td>
            <td>'.(yesNo($ha['P']['rlto'])).'</td>
            <td align="justify">'.$ha['P']['justification'].'</td>
            <td align="justify">'.$ha['P']['controlMeasures'].'</td>
            <td>'.$slResult($ha['P']['slRisk'] ?? '').'</td>
        </tr>';
}
$html .= '</table>';
$pdf->writeHTML($html);

$pdf->Bookmark('CCP Determination', 0, 0, '', 'B', array(0,0,0));
$html = buildHtml(' <p></p>
    <h1>IV. CCP Determination</h1>
    <table>
        <tr class="header">
        <th style="width: 13%;">Process Step</th>
        <th style="width: 20%;" colspan="2">Significant Hazards</th>
        <th style="width: 15%;">Q1. Do preventative measures exist at this step for the identified hazard?</th>
        <th style="width: 15%;">Q2. Does this step eliminate the hazard or reduce the likelihood of its occurrence to an acceptable?</th>
        <th style="width: 15%;">Q3. Could contamination with the identified hazard occur in excess of acceptable levels or increase unacceptable levels?</th>
        <th style="width: 15%;">Q4. Will a subsequent step eliminate the hazard or reduce the likelihood of its occurrence to an acceptable level?</th>
        <th style="width: 7%;">CCP Number</th>
        </tr>');
foreach($haccpResource['processes'] as $process) {
    $ccp = $process['ccpDetermination'];
    $ha = $process['hazardAnalysis'];
    $html .= '<tr> 
            <td class="t-center" rowspan="3">('.$process['process'].') '.$process['label'].'</td>
            <td style="text-align: center !important; width: 4%; font-weight: bold;">B</td>
            <td style="width: 16%;">'.$ha['B']['potentialHazards'].'</td>
            <td class="t-center">'.(yesNo($ccp['B']['q1']) . '<br>' . $ccp['B']['control']).'</td>
            <td class="t-center">'.(yesNo($ccp['B']['q2'])).'</td>
            <td class="t-center">'.(yesNo($ccp['B']['q3'])).'</td>
            <td class="t-center">'.(yesNo($ccp['B']['q4'])).'</td>
            <td class="t-center" rowspan="3">'.(empty($ccp['ccpNumber']) ? 'Not a CCP.' : $ccp['ccpNumber']).'</td>
        </tr>
        <tr> 
            <td style="text-align: center !important; width: 4%; font-weight: bold;">C</td>
            <td style="width: 16%;">'.$ha['C']['potentialHazards'].'</td>
            <td class="t-center">'.(yesNo($ccp['C']['q1']) . '<br>' . $ccp['C']['control']).'</td>
            <td class="t-center">'.(yesNo($ccp['C']['q2'])).'</td>
            <td class="t-center">'.(yesNo($ccp['C']['q3'])).'</td>
            <td class="t-center">'.(yesNo($ccp['C']['q4'])).'</td>
        </tr>
        <tr> 
            <td style="text-align: center !important; width: 4%; font-weight: bold;">P</td>
            <td style="width: 16%;">'.$ha['P']['potentialHazards'].'</td>
            <td class="t-center">'.(yesNo($ccp['C']['q1']) . '<br>' . $ccp['C']['control']).'</td>
            <td class="t-center">'.(yesNo($ccp['P']['q2'])).'</td>
            <td class="t-center">'.(yesNo($ccp['P']['q3'])).'</td>
            <td class="t-center">'.(yesNo($ccp['P']['q4'])).'</td>
        </tr>';
}
$html .= '</table>';
$pdf->writeHTML($html);

$pdf->Bookmark('Critical Limits, Monitoring, and Corrective Actions', 0, 0, '', 'B', array(0,0,0));
$html = buildHtml(' <p></p>
    <h1>V. Critical Limits, Monitoring, and Corrective Actions</h1>
    <table>
        <tr class="header">
        <th rowspan="2" style="width: 10%;">Process Step / CCP</th>
        <th rowspan="2" style="width: 15%;">Critical Limits</th>
        <th colspan="4" width="60%;">Monitoring Procedures</th>
        <th rowspan="2" style="width: 15%;">Corrective Actions</th>
        </tr>
        <tr class="header">
        <th style="width: 15%;">What</th>
        <th style="width: 15%;">How</th>
        <th style="width: 15%;">Frequency</th>
        <th style="width: 15%;">Who</th>
        </tr>');
foreach($haccpResource['processes'] as $process) {
    if(!isCCP($process['ccpDetermination'])) continue;
    $clmca = $process['clmca'];
    $html .= '<tr> 
            <td align="justify">('.$process['process'].') '.$process['label'].'</td>
            <td align="justify">'.$clmca['criticalLimits'].'</td>
            <td align="justify">'.$clmca['monitoringProcedures']['what'].'</td>
            <td align="justify">'.$clmca['monitoringProcedures']['how'].'</td>
            <td align="justify">'.$clmca['monitoringProcedures']['when'].'</td>
            <td align="justify">'.$clmca['monitoringProcedures']['who'].'</td>
            <td align="justify">'.$clmca['correctiveAction'].'</td>
        </tr>';
}
$html .= '</table>';
$pdf->writeHTML($html);

$pdf->Bookmark('Verification and Record Keeping', 0, 0, '', 'B', array(0,0,0));
$html = buildHtml(' <p></p>
    <h1>VI. Verification and Record Keeping</h1>
    <table>
        <tr class="header">
        <th style="width: 15%;" rowspan="2"> Process Step / CCP</th>
        <th style="width: 60%;" colspan="4">Verification Procedures</th>
        <th style="width: 25%;" rowspan="2">Records</th>
        </tr>
        <tr class="header">
        <th style="width: 15%;">What</th>
        <th style="width: 15%;">How</th>
        <th style="width: 15%;">Frequency</th>
        <th style="width: 15%;">Who</th>
        </tr>');
foreach($haccpResource['processes'] as $process) {
    if(!isCCP($process['ccpDetermination'])) continue;
    $vrk = $process['vrk'];
    $html .= '<tr> 
            <td align="justify">('.$process['process'].') '.$process['label'].'</td>
            <td align="justify">'.$vrk['procedures']['what'].'</td>
            <td align="justify">'.$vrk['procedures']['how'].'</td>
            <td align="justify">'.$vrk['procedures']['when'].'</td>
            <td align="justify">'.
            (isset($vrk['procedures']['who']['performed']) 
                ? '<p>Performed by: <br> '.$vrk['procedures']['who']['performed'].'</p>' : '') .
            (isset($vrk['procedures']['who']['reviewed']) 
                ? '<p>Reviewed by: <br> '.$vrk['procedures']['who']['reviewed'].'</p>' : '') .
            (isset($vrk['procedures']['who']['note']) 
                ? $vrk['procedures']['who']['note'] : '') .'
            </td>
            <td align="justify">'.$vrk['records'].'</td>
        </tr>';
}
$html .= '</table>';
$pdf->writeHTML($html);

// HACCP Master Sheet
$pdf->AddPage('L');
$pdf->setPageOrientation('L');
$pdf->Bookmark('HACCP Master Sheet', 0, 0, '', 'B', array(0,0,0));
$html = buildHtml('
    <h1>VII. HACCP Master Sheet</h1>
    <table>
        <tr class="header">
            <th rowspan="2"
                style="width: 10%;"> Critical Control Point</th>
            <th rowspan="2"
                style="width: 10%;"> Significant Hazards</th>
            <th rowspan="2"
                style="width: 10%;"> Critical Limits for Each Control Measure</th>
            <th colspan="4">Monitoring Procedures</th>
            <th rowspan="2"
                style="width: 10%;">Corrective Action</th>
            <th rowspan="2"
                style="width: 10%;"> Verification Procedure
                <small class="text-muted font-normal">
                (What, How, Frequency, Who)
                </small>
            </th>
            <th rowspan="2"
                style="width: 10%;"> Records</th>
        </tr>
        <tr class="header">
            <th style="width: 10%;">What</th>
            <th style="width: 10%;">How</th>
            <th style="width: 10%;">Frequency</th>
            <th style="width: 10%;">Who</th>
        </tr>');
foreach($haccpResource['processes'] as $process) {
    if(!isCCP($process['ccpDetermination'])) continue;
    $vrk = $process['vrk'];
    $clmca = $process['clmca'];
    $ha = $process['hazardAnalysis'];
    $html .= '<tr> 
            <td align="justify" class="t-center">('.$process['process'].') '.$process['label'].'</td>
            <td align="justify">B - '.$ha['B']['potentialHazards'].' <br><br><br>C - '.$ha['C']['potentialHazards'].' <br><br><br>P - '.$ha['P']['potentialHazards'].'</td>
            <td align="justify">'.$clmca['criticalLimits'].'</td>
            <td align="justify">'.$clmca['monitoringProcedures']['what'].'</td>
            <td align="justify">'.$clmca['monitoringProcedures']['how'].'</td>
            <td align="justify">'.$clmca['monitoringProcedures']['when'].'</td>
            <td align="justify">'.$clmca['monitoringProcedures']['who'].'</td>
            <td align="justify">'.$clmca['correctiveAction'].'</td>
            <td align="justify">'.
            $vrk['procedures']['what'] . '<br>' .
            $vrk['procedures']['how'] . '<br>' .
            $vrk['procedures']['when'] . '<br>' .
            (isset($vrk['procedures']['who']['performed']) 
                ? '<p>Performed by: <br> '.$vrk['procedures']['who']['performed'].'</p>' : '') .
            (isset($vrk['procedures']['who']['reviewed']) 
                ? '<p>Reviewed by: <br> '.$vrk['procedures']['who']['reviewed'].'</p>' : '') .
            (isset($vrk['procedures']['who']['note']) 
                ? $vrk['procedures']['who']['note'] : '').'
            </td>
            <td align="justify">'.$vrk['records'].'</td>
        </tr>';
}
$html .= '</table>';
$pdf->writeHTML($html);

// History
$pdf->AddPage('P');
$pdf->setPageOrientation('P');
$pdf->Bookmark('Change History', 0, 0, '', 'B', array(0,0,0));
$html = buildHtml('
    <h1>VIII. Change History</h1>
    <table>
        <tr class="header">
        <th style="width: 15%;">Revision No.</th>
        <th style="width: 15%;">Revision Date</th>
        <th style="width: 30%;">Description of Change</th>
        <th style="width: 20%;">Orignator/Author Name</th>
        <th style="width: 20%;">Title/Department</th>
        </tr>');
$count = 0;
for($i=count($changeHistory)-1; $i>=0; $i--) {
    $h = $changeHistory[$i];
    $version = $h['version'] == 'draft' ? '<i>(Draft)</i>' : (!isset($h['supersedes']) ? 'Original' : ('Revision ' . ++$count));
    // observe arrangement later...
    $html .= '<tr>
        <td align="center">'.$version.'</td>
        <td align="center">'.$h['date'].'</td>
        <td align="center">'.$h['description'].'</td>
        <td align="center">'.$h['author'].'</td>
        <td align="center">'.$h['title'].'</td>
    </tr>';
}

$html .= '</table>';
$pdf->writeHTML($html);

// Table of Contents
$pdf->addTOCPage('P');
$pdf->SetFont('helvetica', 'B', 11);
$pdf->MultiCell(0, 0, 'Table of Contents', 0, 'L', 0, 1, '', '', true, 0);
$pdf->Ln();
$pdf->addTOC(2, 'helvetica', '.', 'Table of Contents', 'B', array(0,0,0));
$pdf->endTOCPage();

$pdfPath = $tempDir;
$pdf->Output($pdfPath . $haccpResource['description'] . '.pdf', 'I');
// $pdf->Output($pdfPath . 'hello.pdf', 'F');

if(isset($haccpDiagramImage)) {
    unlink($pfdImageFile);
}

exit();