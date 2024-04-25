<?php

include_once __DIR__ ."/../../alt-setup/setup.php";

function getSuppliersByUser($conn, $userId) {
    return $conn->select("tbl_supplier", "ID as id, name", [ 'user_id'=> $userId, 'status'=>1, 'page'=>1])->fetchAll();
}

function getSupplierList($conn, $userId) {
    $uploadPath = getUploadsDir('fsvp/supplier_lists');

    $list = $conn->execute("SELECT fs.*, s.name, s.address FROM tbl_fsvp_suppliers fs 
        LEFT JOIN tbl_supplier s ON s.ID = fs.supplier_id
        WHERE fs.user_id = ? AND fs.deleted_at IS NULL
    ", $userId)->fetchAll(function($d) use(&$conn, $uploadPath) {
        $arr = explode(" | ", $d["address"]);
        $add = [];
        array_push($add, htmlentities(trim($arr[1])));
        array_push($add, htmlentities(trim($arr[2])));
        array_push($add, htmlentities(trim($arr[3])));
        array_push($add, trim($arr[0]));
        array_push($add, trim($arr[4]));

        $mIds = implode(', ', json_decode($d['food_imported']));
        $materialData = $conn->select("tbl_supplier_material", "material_name AS name, ID as id", "ID in ($mIds)")->fetchAll();
        
        $saFiles = json_decode($d['sa_files'] ?? '[]');
        $data = [
            'address' => $add,
            'name' => $d['name'],
            'id' => $d['id'],
            'food_imported' => $materialData,
            'compliance_statement' => !empty($d['cs_file']) ? [
                'path' =>  $uploadPath . '\\' . $d['cs_file'],
                'name' => $d['cs_file'],
            ] : null,
            'supplier_agreement' => array_map(function ($d) use($uploadPath) {
                return [
                    'path' =>  $uploadPath . '\\' . $d,
                    'name' => $d,
                ];
            }, $saFiles),
        ];

        return $data;
    });

    return $list;
}