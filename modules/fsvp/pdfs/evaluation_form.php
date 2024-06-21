<?php

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

debugger($data);

$products = $conn->execute("SELECT 
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

debugger($products, false);

$title = '(FSVP) Foreign Supplier Evaluation Form';
$pdf->SetTitle($title);

$pdf->AddPage('L');
$html = $css . '
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
            <td colspan="3" style="width: 28%;">'.txt($products).'</td>
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
';
$pdf->writeHTML($html);

$pdf->Output('test.pdf', 'I');