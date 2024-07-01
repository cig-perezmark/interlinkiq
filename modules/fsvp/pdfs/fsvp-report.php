<?php

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
        
    -- other clauses
    GROUP BY aw.id
", $recordId)->fetchAssoc(function($d) {
    $d['importer_address' ] = formatSupplierAddress($d['importer_address']);
    $d['supplier_address' ] = formatSupplierAddress($d['supplier_address']);
    return $d;
});

debugger($data);

$title = 'FOREIGN SUPPLIER VERIFICATION ACTIVITY(IES) WORKSHEET';
$pdf->SetTitle($title);

$pdf->AddPage('L');
$html = $css . '
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
';
$pdf->writeHTML($html);

$pdf->Output('test.pdf', 'I');