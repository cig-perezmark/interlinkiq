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

debugger($data);

$title = 'FSVP CBP Filing Form';
$pdf->SetTitle($title);

$pdf->AddPage('L');
$html = $css . '
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
';
$pdf->writeHTML($html);

$pdf->Output('test.pdf', 'I');