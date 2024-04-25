<?php

include_once __DIR__ ."/../../alt-setup/setup.php";

// fetching supplier for dropdown
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

// new supplier list, submit
if(isset($_GET["newSupplierToList"])) {
    try {
        $supplierId = $_POST["supplier"];
        
        
        send_response($_POST);
    } catch(Throwable $e) {
        send_response([
            "info"=> $e->getMessage(),
            "message" => 'Error occured',
        ], 500);
    }
}