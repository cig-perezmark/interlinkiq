<?php

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
    // $d['supplier_address' ] = formatSupplierAddress($d['supplier_address']);
    return $d;
});

debugger($data, 0);

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
    $data['id'],
    $data['supplier_id'],
    $user_id
)->fetchAssoc()['all'];

debugger($products, 0);

$title = 'Foreign Supplier Importer Information Form';
$pdf->SetTitle($title);

$pdf->AddPage('L');
$html = $css . '
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
            <td>'.txt($products).'</td>
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
';
$pdf->writeHTML($html);

$pdf->Output('test.pdf', 'I');