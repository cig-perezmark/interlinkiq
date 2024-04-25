<?php

include_once __DIR__ ."/utils.php";
// include_once __DIR__ ."/../../alt-setup/setup.php";

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
        $conn->begin_transaction();
        
        $supplierId = $_POST["supplier"];
        $supplierData = $conn->select("tbl_supplier", "address, name", ["ID" => $supplierId])->fetchAssoc(function ($d) {
            $arr = explode(" | ", $d["address"]);
            $add = [];
            array_push($add, htmlentities(trim($arr[1])));
            array_push($add, htmlentities(trim($arr[2])));
            array_push($add, htmlentities(trim($arr[3])));
            array_push($add, trim($arr[0]));
            array_push($add, trim($arr[4]));
            return [
                'address' => implode(", ", $add),
                'name' => $d['name']
            ];
        });

        $foodImported = json_encode($_POST['food_imported'] ?? []);

        $conn->execute("INSERT INTO tbl_fsvp_suppliers (user_id, portal_user, supplier_id, food_imported, supplier_agreement, compliance_statement) VALUE (?,?,?,?,?,?)", [
            $user_id,
            $portal_user,
            $supplierId,
            $foodImported,
            $_POST['supplier_agreement'] ?? 0,
            $_POST['compliance_statement'] ?? 0,
        ]);

        $id = $conn->getInsertId();

        // process uploads
        $csFile = null;
        $uploadPath = getUploadsDir('fsvp/supplier_lists');
        if($_POST['compliance_statement'] == 1 && ($csFile = uploadFile($uploadPath, $_FILES['compliance_statement_file']))) {
            $conn->update("tbl_fsvp_suppliers", [ "cs_file" => $csFile], "id = $id");
            $csFile = [
                "path" => $uploadPath . '\\' . $csFile,
                "name" => $file, 
            ];
        }

        $saFiles = null;
        if($_POST['supplier_agreement'] == 1) {
            $saFiles = [];
            $files = uploadFile($uploadPath, $_FILES['supplier_agreement_file']);
            $conn->update("tbl_fsvp_suppliers", [ "sa_files" => json_encode($files)], "id = $id");
            foreach($files as $file) {
                $saFiles[] = [
                    "path" => $uploadPath . '\\' . $file,
                    "name" => $file, 
                ];
            }
        }
        
        // food imported names
        $mIds = implode(', ', json_decode($foodImported));
        $materialData = $conn->select("tbl_supplier_material", "material_name AS name, ID as id", "ID in ($mIds)")->fetchAll();

        $conn->commit();
        send_response([
            'data' => [
                "address" => $supplierData['address'],
                "name" => $supplierData['name'],
                "id" => $id,
                "food_imported" => $materialData,
                'supplier_agreement' => $saFiles,
                'compliance_statement' => $csFile,
            ],
            'message' => "Saved successfully."
        ]);
        
    } catch(Throwable $e) {
        $conn->rollback();
        send_response([
            "info"=> $e->getMessage(),
            "message" => 'Error occured',
        ], 500);
    }
}

// suppliers list
if(isset($_GET['suppliersByUser'])) {
    send_response([
        'data' => getSupplierList($conn, $user_id),
    ]);
}