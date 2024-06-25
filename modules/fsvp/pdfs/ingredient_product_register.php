<?php

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

debugger($data, 0);

$title = 'FSVP Ingredient Product Register';
$pdf->SetTitle($title);

$pdf->AddPage('L');
$html = $css . '
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
$pdf->writeHTML($html);
$pdf->writeHTML('
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
');
$pdf->writeHTML($css . '
    <br>
    <br><strong>Comments:</strong>
    <br><table>
        <tr>
            <td></td>
        </tr>
    </table>
');

$pdf->Output('test.pdf', 'I');