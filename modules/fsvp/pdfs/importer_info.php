<?php

$data = $conn->execute("SELECT 
        i.id, 
        i.duns_no, 
        i.fda_registration, 
        i.evaluation_date,
        i.importer_id, 
        imp.name AS importer_name, 
        imp.address AS importer_address,
        i.fsvpqi_id, 
        CONCAT(TRIM(emp.first_name), ' ', TRIM(emp.last_name)) AS fsvpqi_name,
        i.supplier_id,
        sup.name AS supplier_name
    FROM 
        tbl_fsvp_importers i 
        LEFT JOIN tbl_supplier imp ON imp.ID = i.importer_id
        LEFT JOIN tbl_supplier sup ON sup.ID = i.supplier_id
        LEFT JOIN tbl_fsvp_qi qi ON qi.id = i.fsvpqi_id
        LEFT JOIN tbl_hr_employee emp ON emp.ID = qi.employee_id
    WHERE MD5(i.id) = ?
", $recordId)->fetchAssoc(function($d) {
    $d['importer_address' ] = formatSupplierAddress($d['importer_address']);
    // $d['supplier_address' ] = formatSupplierAddress($d['supplier_address']);
    return $d;
});

debugger($data);

$title = 'Foreign Supplier Importer Information Form';
$pdf->SetTitle($title);

$pdf->AddPage('L');
$html = $css . '
    <h3 style="text-align:center;">'.$title.'</h3>
    <table>
        <tr>
            <td style="width: 20%;">FSVP Importer:</td>
            <td style="width: 80%;">'.($data['importer_name'] ?? '').'</td>
        </tr>
        <tr>
            <td>DUNS No.</td>
            <td>'.($data['duns_no'] ?? 'none').'</td>
        </tr>
        <tr>
            <td>Food Registration No.</td>
            <td>'.(txt($data['fda_registration'])).'</td>
        </tr>
        <tr>
            <td>Supplier</td>
            <td>'. txt($data['supplier_name']) .'</td>
        </tr>
        <tr>
            <td>Product(s):</td>
            <td></td>
        </tr>
        <tr>
            <td>Qualifying Individual:</td>
            <td>'. txt($data['fsvpqi_name']) .'</td>
        </tr>
        <tr>
            <td>Name:</td>
            <td></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td></td>
        </tr>
        <tr>
            <td>Address:</td>
            <td></td>
        </tr>
    </table>
    <p></p>
    <span>Importer Name and Signature:</span>
    <br><table>
        <tr>
            <td>Name and Signature:</td>
            <td>Date:</td>
        </tr>
    </table>
    <p style="color:gray; font-style:italic;">Make certain that you understand what the FSVP requirements are and comply with those requirements and provide us with accurate data</p>
    <p style="color:gray; font-style:italic;">Note:  When reviewing, please return form within 24 hours to the Quality Specialist. “Yes” - means that revision has been approved and is okay to implement, effective date of approval.  For “No”, please enter comments.</p>
    <p></p>Comments:
    <br><table>
        <tr>
            <td></td>
        </tr>
    </table>
';
$pdf->writeHTML($html);

$pdf->Output('test.pdf', 'I');