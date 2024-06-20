<?php

$data = $conn->execute("SELECT 
    REC.*,
    IMP.name as importer_name,
    IMP.address as importer_address,
    SUPP.name as supplier_name,
    SUPP.address as supplier_address,
    EVAL.assessment
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

$title = '(FSVP) Foreign Supplier Evaluation Form PDF';
$pdf->SetTitle($title);

$pdf->AddPage('L');
$html = $css . '
    <h3 style="text-align:center;">'.$title.'</h3>
    <table>
        <tr>
            <td colspan="4" style="width: 50%;">IMPORTER NAME: '.($data['importer_name'] ?? '').'</td>
            <td colspan="5" style="width: 50%;">DATE: '.($data['evaluation_date'] ?? '').'</td>
        </tr>
        <tr>
            <td colspan="4" style="width: 50%;">ADDRESS: '.($data['importer_address'] ?? '').'</td>
            <td colspan="5" style="width: 50%;">QUALIFIED INDIVIDUAL (QI) APPROVAL: </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 25%;">Foreign Supplier Name</td>
            <td colspan="3" style="width: 25%;">'.($data['supplier_name'] ?? '').'</td>
            <td colspan="2" style="width: 25%;">Foreign Supplier Address (location) </td>
            <td colspan="2" style="width: 25%;">'.($data['supplier_address'] ?? '').'</td>
        </tr>
        <tr>
            <td colspan="2" style="width: 25%;">Food Product(s) Imported</td>
            <td colspan="3" style="width: 25%;"></td>
            <td colspan="2" style="width: 25%;">Food Product(s) Description(s), including Important Food Safety Characteristics</td>
            <td colspan="2" style="width: 25%;"></td>
        </tr>
        <tr>
            <td colspan="9" style="text-align:center;">Evaluation Considerations and Results</td>
        </tr>
        <tr>
            <td>Supplier\'s Procedures, Practices, and Processes</td>
            <td>Import Alerts</td>
            <td>Recalls</td>
            <td>Warning Letters</td>
            <td>Other Significant Compliance Action</td>
            <td>Supplier\'s Corrective Actions</td>
            <td>Information related to the Safety of the food</td>
            <td>Rejection Date <br> (if applicable)</td>
            <td>Approval Date <br> (if applicable)</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="4" style="width: 50%; font-style: italic;">Assessment of Results of Foreign Supplier Evaluation*** <br><span style="color:gray;">[Note: If the evaluation was performed by another entity (other than the foreign supplier) include Entity’s name, address, email, and date of evaluation.]</span>
            </td>
            <td colspan="5" style="width: 50%;">'.($data['assessment'] ?? 'none').'</td>
        </tr>
        <tr>
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
    <span style="color:gray;">Note:  Review and return this form to the Quality Personnel within 24 hours. If the document is not approved, state the reason in the comment section below.</span>
    <p></p>Comments:
    <br /><table>
        <tr>
            <td></td>
        </tr>
    </table>
';
$pdf->writeHTML($html);

$pdf->Output('test.pdf', 'I');