<?php

function getLayout($type, $title, $data) {
    if($type === 'ipr-1') {
        $html = '
            <h3 style="text-align:center;">'.$title.'</h3>
            <table>
                <tr style="font-weight:bold; text-align:center;">
                    <th>FSVP Importer Name</th>
                    <th>Product Name</th>
                    <th>Product Description</th>
                    <th>Ingredient Name</th>
                    <th>Finished Product Brand Name</th>
                    <th>Intended Use</th>
                </tr>';

        foreach($data as $d) {
            $html .= '
                <tr style="text-align:center;">
                    <td>'.txt($d['importer_name']).'</td>
                    <td>'.txt($d['product_name']).'</td>
                    <td>'.txt($d['description']).'</td>
                    <td>'.txt($d['ingredients_list']).'</td>
                    <td>'.txt($d['brand_name']).'</td>
                    <td>'.txt($d['intended_use']).'</td>
                </tr>
            ';
        }

        $html .= '</table>';
        return $html;
    } else if($type === 'ipr-2') {
        return '
            <style>
                table { width: 100%; padding: 5px 0 5px 0; }
            </style>
            <br>
            <br><table class="borderless">
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
            <p style="display:none;">Note: Review and return this form to the Quality Personnel within 24 hours. If the document is not approved, state the reason in the comment section below.</p>

        ';
    } else if($type === 'ipr-3') {
        return '
            <br>
            <br><strong>Comments:</strong>
            <br><table>
                <tr>
                    <td></td>
                </tr>
            </table>
        ';
    }

    
    return match ($type) {
        'evaluation_form'       => '
            <h3 style="text-align:center;">'.$title.'</h3>
            <table>
                <tr>
                    <td colspan="4" style="width: 50%;"><strong>IMPORTER NAME:</strong> '.txt($data['importer_name']).'</td>
                    <td colspan="5" style="width: 50%;"><strong>DATE:</strong> '.txt($data['evaluation_date']).'</td>
                </tr>
                <tr>
                    <td colspan="4" style="width: 50%;"><strong>ADDRESS:</strong> '.txt($data['importer_address']).'</td>
                    <td colspan="5" style="width: 50%;"><strong>QUALIFIED INDIVIDUAL (QI) APPROVAL:</strong> </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 22%; font-weight:bold;">Foreign Supplier Name</td>
                    <td colspan="3" style="width: 28%;">'.txt($data['supplier_name']).'</td>
                    <td colspan="2" style="width: 25%; font-weight:bold;">Foreign Supplier Address (location) </td>
                    <td colspan="2" style="width: 25%;">'.txt($data['supplier_address']).'</td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 22%; font-weight:bold;">Food Product(s) Imported</td>
                    <td colspan="3" style="width: 28%;">'.txt($data['products']).'</td>
                    <td colspan="2" style="width: 25%; font-weight:bold;">Food Product(s) Description(s), including Important Food Safety Characteristics</td>
                    <td colspan="2" style="width: 25%;">'.txt($data['description']).'</td>
                </tr>
                <tr>
                    <td colspan="9" style="text-align:center; font-weight:bold;">Evaluation Considerations and Results</td>
                </tr>
                <tr style="text-align:center; font-weight:bold;">
                    <td style="width:12%;">Supplier\'s Procedures, Practices, and Processes</td>
                    <td style="width:10%;">Import Alerts</td>
                    <td>Recalls</td>
                    <td>Warning Letters</td>
                    <td>Other Significant Compliance Action</td>
                    <td>Supplier\'s Corrective Actions</td>
                    <td>Information related to the Safety of the food</td>
                    <td>Rejection Date <br> (if applicable)</td>
                    <td>Approval Date <br> (if applicable)</td>
                </tr>
                <tr>
                    <td>'.txt($data['sppp']).'</td>
                    <td>'.txt($data['import_alerts']).'</td>
                    <td>'.txt($data['recalls']).'</td>
                    <td>'.txt($data['warning_letters']).'</td>
                    <td>'.txt($data['other_significant_ca']).'</td>
                    <td>'.txt($data['suppliers_corrective_actions']).'</td>
                    <td>'.txt($data['info_related']).'</td>
                    <td>'.txt($data['rejection_date']).'</td>
                    <td>'.txt($data['approval_date']).'</td>
                </tr>
                <tr>
                    <td colspan="4" style="width: 50%; font-weight:bold;">Assessment of Results of Foreign Supplier Evaluation<span style="color:gray; display:none;">[Note: If the evaluation was performed by another entity (other than the foreign supplier) include Entity’s name, address, email, and date of evaluation.]</span></td>
                    <td colspan="5" style="width: 50%;">'.txt($data['assessment']).'</td>
                </tr>
                <tr style="display:none;">
                    <td colspan="9" style="font-style: italic; color:gray;">*All supporting documentation should be appended to this form.
                        <br>**Includes previous and recent experience with the supplier (e.g., rejected shipments, lab results, audit results, or other food safety information you may have outside of the government oversight context).
                        <br>***If another entity (other than the foreign supplier) performs the foreign supplier evaluation, you may meet your evaluation requirements by having your QI review and assess the entity’s evaluation. Your review/assessment of the evaluation must include documentation that the evaluation was conducted by a QI.
                    </td>
                </tr>
            </table>
            <br>
            <br><table>
                <tr>
                    <td>Importer Approval: </td>
                    <td>Date: </td>
                </tr>
                <tr>
                    <td>Reviewed By: </td>
                    <td>Date: </td>
                </tr>
            </table>
            <span style="color:gray; display:none;">Note:  Review and return this form to the Quality Personnel within 24 hours. If the document is not approved, state the reason in the comment section below.</span>
            <br>Comments:
            <br /><table>
                <tr>
                    <td></td>
                </tr>
            </table>
        ',
    
        'importer_information'  => '
            <h3 style="text-align:center;">'.$title.'</h3>
            <table>
                <tr>
                    <td style="width: 20%; font-weight:bold;">FSVP Importer:</td>
                    <td style="width: 80%;">'.txt($data['importer_name']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">DUNS No.:</td>
                    <td>'.txt($data['duns_no']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Food Registration No.</td>
                    <td>'.(txt($data['fda_registration'])).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Supplier:</td>
                    <td>'. txt($data['supplier_name']) .'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Product(s):</td>
                    <td>'.txt($data['products']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Qualifying Individual:</td>
                    <td>'. txt($data['fsvpqi_name']) .'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Name:</td>
                    <td></td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Email:</td>
                    <td>'.txt($data['email']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Address:</td>
                    <td>'.txt($data['importer_address']).'</td>
                </tr>
            </table>
            <br>
            <br><strong>Importer Name and Signature:</strong>
            <br><table>
                <tr>
                    <td>Name and Signature:
                        <p style="text-align:center;">'.txt($data['importer_name']).'</p>
                    </td>
                    <td>Date:</td>
                </tr>
            </table>
            <br>
            <br>Comments:
            <br><table>
                <tr>
                    <td></td>
                </tr>
            </table>
        ',

        'cbp'                   => '
            <h3 style="text-align:center;">'.$title.'</h3>
            <table>
                <tr>
                    <td><strong>Importer Name:</strong> '.($data['importer_name'] ?? '').'</td>
                    <td><strong>Date:</strong> '.(date('Ymd', strtotime($data['created_at']))).'</td>
                </tr>
                <tr>
                    <td colspan="2"><strong>Address:</strong> '.($data['importer_address']).'</td>
                </tr>
            </table>
            <p style="display:none;">Supplier information for FSVP importer
                <br>This Evaluation is to help the Supplier, the entity who received imported food, to ensure that an appropriate FSVP importer has been designated by parties involved in the importation of the food and that the U.S. Customs and Border Protection (CBP).
            </p>
            <br>
            <br><table>
                <tr style="text-align:center; font-weight:bold;">
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
                <tr style="display:none;">
                    <td colspan="5">*The Supplier identified as the FSVP “importer” in the CBP entry filing. FDA will see as responsible for complying with the FSVP rule.
                        <br>** The definition of FSVP importer is if there is no U.S. owner or consignee at the time of entry and you are the U.S. agent or representative of the foreign owner or consignee.
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="width: 50%;"><strong>Reviewed By:</strong></td>
                    <td colspan="2" style="width: 50%;"><strong>Date:</strong></td>
                </tr>
                <tr>
                    <td colspan="3" style="width: 50%;"><strong>Approved By:</strong></td>
                    <td colspan="2" style="width: 50%;"><strong>Date:</strong></td>
                </tr>
            </table>
            <span style="display:none;">Note: Review and return this form to the Quality Personnel within 24 hours. If the document is not approved, state the reason in the comment section below.</span>
            <br><br><strong>Comments:</strong>
            <br><table>
                <tr>
                    <td></td>
                </tr>
            </table>
        ',

        'activities-worksheet'  => '
            <h3 style="text-align:center;">'.$title.'</h3>
            <table>
                <tr>
                    <td style="width:25%;font-weight:bold;">Importer Name:</td>
                    <td style="width:75%">'.txt($data['importer_name']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Verification Date:</td>
                    <td>'.txt($data['verification_date']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Supplier Evaluation Date:</td>
                    <td>'.txt($data['supplier_evaluation_date']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Address:</td>
                    <td>'.txt($data['importer_address']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">QI Approval:</td>
                    <td>'.txt($data['qi_approval']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Approval Date:</td>
                    <td>'.txt($data['approval_date']).'</td>
                </tr>
            </table>
            <p></p>
            <table>
                <tr>
                    <td style="width:25%;font-weight:bold;">Foreign Supplier Name:</td>
                    <td style="width:75%">'.txt($data['supplier_name']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Foreign Supplier Address:</td>
                    <td>'.txt($data['supplier_address']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Food Product Imported:</td>
                    <td>'.txt($data['products']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Food Product Description(s), including Important Food Safety Characteristics:</td>
                    <td>'.txt($data['fdfsc']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Process Description (Ingredients/Packaging Materials):</td>
                    <td>'.txt($data['pdipm']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Food Safety Hazard(s) Controlled by Foreign Supplier:</td>
                    <td>'.txt($data['fshc']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Description of Foreign Supplier Control(s):</td>
                    <td>'.txt($data['dfsc']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Verification Activity(ies) and Frequency:</td>
                    <td>'.txt($data['vaf']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Justification for Verification Activity(ies) and Frequency:</td>
                    <td>'.txt($data['justification_vaf']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Verification Records (i.e audit summaries, test results):</td>
                    <td>'.txt($data['verification_records']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Assessment of Results of Verification Activity(ies):</td>
                    <td>'.txt($data['assessment_results']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Corrective Action(s), if needed:</td>
                    <td>'.txt($data['corrective_actions']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Re-evaluation Date:</td>
                    <td>'.txt($data['reevaluation_date']).'</td>
                </tr>
            </table>
            <p></p>Comments:
            <br><table>
                <tr>
                    <td></td>
                </tr>
            </table>
        ',
        
        'report'                => '',

        default                 => '',
    };
}

function createPageBreak($pdf, $content) {
    $pdf->AddPage('P');
    $pdf->writeHTML($content);
}

function createFSVPReport($conn, &$pdf, $supplierHashId, $css) {
    global $user_id;

    // fetching basic fsvp supplier info
    $supplierInfo = $conn->execute("SELECT sup.name, sup.address, fsup.id
        FROM tbl_fsvp_suppliers fsup
        LEFT JOIN tbl_supplier sup ON fsup.supplier_id = sup.ID
        WHERE MD5(fsup.id) = ?
    ", $supplierHashId)->fetchAssoc(function ($d) {
        $d['address'] = formatSupplierAddress($d['address']);
        return $d;
    });
    
 
    $title = (($supplierInfo['name'] . ' - ') ?? '') . "FSVP Report";
    $basicInfo = [
        'supplier_name' => $supplierInfo['name'],
        'supplier_address' => $supplierInfo['address'],
    ];

    $pdf->SetTitle($title);
    createPageBreak($pdf, '
        <h1 style="text-align:center; font-size:42px;">
            <br><br><br>'.$supplierInfo['name'].'<br><br>FSVP Report</h1>
    ');

    // fetching all importers connected to the supplier
    $importersInfo = $conn->execute("SELECT
            i.id,
            i.duns_no, 
            i.fda_registration, 
            i.evaluation_date,
            imp.name AS importer_name, 
            imp.address AS importer_address,
            i.fsvpqi_id, 
            CONCAT(TRIM(emp.first_name), ' ', TRIM(emp.last_name)) AS fsvpqi_name,
            emp.email,
            (
                SELECT 
                    GROUP_CONCAT(mat.material_name SEPARATOR ', ')
                FROM tbl_fsvp_ipr_imported_by iby
                LEFT JOIN tbl_fsvp_ingredients_product_register ipr ON ipr.id = iby.product_id
                LEFT JOIN tbl_supplier_material mat ON mat.ID = ipr.product_id
                WHERE iby.importer_id = i.id
                    AND ipr.supplier_id = i.supplier_id
                    AND iby.deleted_at IS NULL
            ) AS products
        FROM 
            tbl_fsvp_importers i 
            LEFT JOIN tbl_supplier imp ON imp.ID = i.importer_id
            LEFT JOIN tbl_fsvp_qi qi ON qi.id = i.fsvpqi_id
            LEFT JOIN tbl_hr_employee emp ON emp.ID = qi.employee_id
        WHERE i.supplier_id = ? AND i.deleted_at IS NULL
    ", $supplierInfo['id'])->fetchAll(function ($d) {
        $d['importer_address'] = formatSupplierAddress($d['importer_address']);

        return $d;
    });

    foreach($importersInfo as &$imp) {
        $pdf->AddPage();
        $pdf->writeHTML($css . getLayout('importer_information', 'Foreign Supplier Importer Information Form', array_merge($imp, $basicInfo)));

        $basicInfo = array_merge($basicInfo, [
            'importer_name' => $imp['importer_name'],
            'importer_address' => $imp['importer_address'],
        ]);
        
        // evaluation data
        $imp['evaluation'] = $conn->execute("SELECT 
                REC.*,
                IF(REC.import_alerts = 1, 'Yes', 'No') AS import_alerts,
                IF(REC.recalls = 1, 'Yes', 'No') AS recalls,
                IF(REC.warning_letters = 1, 'Yes', 'No') AS warning_letters,
                IF(REC.other_significant_ca = 1, 'Yes', 'No') AS other_significant_ca,
                IF(REC.suppliers_corrective_actions = 1, 'Yes', 'No') AS suppliers_corrective_actions,
                EVAL.assessment,
                EVAL.description,
                (
                    SELECT 
                        GROUP_CONCAT(mat.material_name SEPARATOR ', ')
                    FROM tbl_fsvp_ipr_imported_by iby
                    LEFT JOIN tbl_fsvp_ingredients_product_register ipr ON ipr.id = iby.product_id
                    LEFT JOIN tbl_supplier_material mat ON mat.ID = ipr.product_id
                    WHERE iby.importer_id = EVAL.importer_id
                        AND ipr.supplier_id = EVAL.supplier_id
                        AND iby.deleted_at IS NULL
                ) AS products
            FROM tbl_fsvp_evaluation_records REC
            LEFT JOIN tbl_fsvp_evaluations EVAL ON EVAL.id = REC.evaluation_id
            -- Join with subquery to get the latest evaluation record
            INNER JOIN (
                SELECT evaluation_id, MAX(id) AS latest_record_id
                FROM tbl_fsvp_evaluation_records
                GROUP BY evaluation_id
            ) AS latest_rec ON latest_rec.latest_record_id = REC.id
            WHERE EVAL.importer_id = ? AND EVAL.supplier_id = ? AND EVAL.deleted_at IS NULL
        ", $imp['id'], $supplierInfo['id'])->fetchAll(function ($d) use ($pdf, $basicInfo, $css) {
            $pdf->AddPage();
            $pdf->writeHTML($css . getLayout('evaluation_form', '(FSVP) Foreign Supplier Evaluation Form', array_merge($d, $basicInfo)));
        });

        // cbp
        $imp['cbp'] = $conn->execute("SELECT *
                FROM tbl_fsvp_cbp_records
                WHERE importer_id = ? AND deleted_at IS NULL
        ", $imp['id'])->fetchAssoc(function ($d) use ($pdf, $basicInfo, $css)  {
            $pdf->AddPage();
            $pdf->writeHTML($css . getLayout('cbp', 'FSVP CBP Filing Form', array_merge($d, $basicInfo)));
        });

        // worksheets
        $imp['worksheets'] = $conn->execute("SELECT 
                aw.*,
                CONCAT(TRIM(emp.first_name), ' ', TRIM(emp.last_name)) AS qi_approval
            FROM tbl_fsvp_activities_worksheets aw
            LEFT JOIN tbl_fsvp_qi fqi ON fqi.id = aw.fsvpqi_id
            LEFT JOIN tbl_hr_employee emp ON emp.ID = fqi.employee_id
            WHERE aw.importer_id = ? 
                AND aw.supplier_id = ?
                AND aw.deleted_at IS NULL
        ", $imp['id'], $supplierInfo['id'])->fetchAll(function ($d) use ($pdf, $basicInfo, $css, $imp) {
            $pdf->AddPage();
            $pdf->writeHTML($css . getLayout('activities-worksheet', 'FOREIGN SUPPLIER VERIFICATION ACTIVITY(IES) WORKSHEET', array_merge($d, $basicInfo, ['products' => $imp['products'] ?? ''])));
        });
    }

    $productRegistry = $conn->execute("SELECT 
            mat.material_name AS product_name,
            mat.description,
            iby.brand_name,
            iby.ingredients_list,
            iby.intended_use,
            sup.name AS importer_name
        FROM tbl_fsvp_ipr_imported_by iby
        LEFT JOIN tbl_fsvp_ingredients_product_register ipr ON ipr.id = iby.product_id
        LEFT JOIN tbl_supplier_material mat ON mat.ID = ipr.product_id
        LEFT JOIN tbl_fsvp_importers imp ON imp.id = iby.importer_id
        LEFT JOIN tbl_supplier sup ON sup.ID = imp.importer_id
        WHERE ipr.supplier_id = ? AND ipr.deleted_at IS NULL AND iby.deleted_at IS NULL
    ", $supplierInfo['id'])->fetchAll();

    $title = 'FSVP Ingredient Product Register';
    // $data = array_merge($d, $basicInfo);
    
    $pdf->AddPage();
    $pdf->writeHTML($css . getLayout('ipr-1', $title, $productRegistry));
    $pdf->writeHTML(getLayout('ipr-2', $title, $productRegistry));
    $pdf->writeHTML($css . getLayout('ipr-3', $title, $productRegistry));

    debugger([
        'supplier info', $supplierInfo,
        'importers', $importersInfo,
        'ipr', $productRegistry
    ], !true);
}