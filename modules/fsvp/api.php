<?php

include_once __DIR__ ."/utils.php";
// include_once __DIR__ ."/../../alt-setup/setup.php";

// note: no filter for foreign suppliers yet
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
            [$a1, $a2, $a3, $a4, $a5] = preg_split("/\||,/", $d["address"]);
            $address = implode(', ', array_filter(array_map(function ($a) {
                return htmlentities(trim($a));
            }, [ $a2, $a3, $a4, $a1, $a5 ]), function($a) { return !empty($a); }));
            
            return [
                'address' => $address,
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

if(isset($_POST['search-employee'])) {
    try {
        $myEmployees = [];
        $search = mysqli_real_escape_string($conn, $_POST['search-employee']);
        // $result = $conn->query("SELECT 
        //     p.ID AS id,
        //     p.image,
        //     p.code,
        //     p.name,
        //     p.description,
        //     c.name AS category
        //     FROM tbl_products AS p
        //     LEFT JOIN tbl_products_category AS c ON p.category = c.ID
        //     WHERE p.user_id=$user_id ANzD (p.code like '%$search%' OR p.name like '%$search%') AND p.deleted=0 AND NOT JSON_CONTAINS(CAST('{$_POST['products']}' AS JSON), CAST(p.ID AS CHAR))");

        // store result ids
        $employeeIds = [];

        $result = $conn->execute("SELECT CONCAT(TRIM(first_name), ' ', TRIM(last_name)) AS name, ID as id, email, job_description_id 
            FROM tbl_hr_employee WHERE user_id = ? AND (first_name LIKE '%$search%' OR last_name LIKE '%$search%') AND status = 1 
            ORDER BY first_name ASC
        ", $user_id)->fetchAll(function($d) use($employeeIds) {
            $employeeIds[] = $d["id"];
            return $d;
        });

        $userAvatars = [];
        if(count($employeeIds) > 0) {
            $employeeIds = implode(',', $employeeIds);
            $conn->execute("SELECT ui.avatar, u.employee_id AS id FROM tbl_user_info ui JOIN tbl_user u ON u.ID = ui.user_id WHERE u.employee_id IN (?)", $employeeIds)
                ->fetchAll(function($data) use(&$userAvatars) {
                    $userAvatars[$data['id']] = $data["avatar"];
                    return $data;
                });
        } 

        $roster = [];
        foreach($result as $row) {
            $row['avatar'] = $userAvatars[$row['id']] ?? 'https://via.placeholder.com/150x150/EFEFEF/AAAAAA.png?text=no+image';
            $roster[] = $row;
        }
        
        return send_response([
            'results' => $roster,
            'count' => count($roster),
        ]);
    } catch(Throwable $e) {
        http_response_code(500);
        return $e->getMessage();
    }
}