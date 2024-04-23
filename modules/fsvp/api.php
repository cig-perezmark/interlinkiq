<?php

include_once __DIR__ ."/../../alt-setup/setup.php";

if(isset($_GET["getProductsBySupplier"]) && !empty($_GET["getProductsBySupplier"])) {
    $materials = $conn->select("tbl_supplier", "material", ["ID" => $_GET["getProductsBySupplier"]])->fetchAssoc();
    $mIds = $materials['material'];
    $data = [];
    
    if(!empty($mIds)) {
        $data = $conn->select("tbl_supplier_material", "material_name AS name, ID as id, description", "ID in ($mIds) AND active = 1")->fetchAll();
    }
    
    send_response([
        "materials"=> $data
    ]);
}