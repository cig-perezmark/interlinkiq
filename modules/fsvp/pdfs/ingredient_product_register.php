<?php

$data = $conn->execute("SELECT 
        mat.material_name AS product_name,
        mat.description,
        iby.brand_name,
        iby.ingredients_list,
        iby.intended_use,
        sup.ID as importer_id,
        sup.name AS importer_name
    FROM tbl_fsvp_ipr_imported_by iby
    LEFT JOIN tbl_fsvp_ingredients_product_register ipr ON ipr.id = iby.product_id
    LEFT JOIN tbl_supplier_material mat ON mat.ID = ipr.product_id
    LEFT JOIN tbl_supplier sup ON sup.ID = iby.importer_id
    WHERE MD5(iby.id) = ?
", $recordId)->fetchAssoc(function($d) {
    return $d;
});

debugger($data);

$title = 'FSVP Ingredient Product Register';
$pdf->SetTitle($title);

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
        table { width: 100%; padding: 5px 0 5px 0; }
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