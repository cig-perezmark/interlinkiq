<?php

include_once __DIR__ ."/utils.php";
// include_once __DIR__ ."/../../alt-setup/setup.php";

date_default_timezone_set('America/Chicago');
$currentTimestamp = date('Y-m-d H:i:s');

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

        // initializing record
        $conn->execute("INSERT INTO tbl_fsvp_suppliers (user_id, portal_user, supplier_id, food_imported, supplier_agreement, compliance_statement) VALUE (?,?,?,?,?,?)", [
            $user_id,
            $portal_user,
            $supplierId,
            $foodImported,
            $_POST['supplier_agreement'] ?? 0,
            $_POST['compliance_statement'] ?? 0,
        ]);

        $id = $conn->getInsertId();
        $fileInsertQuery = "INSERT tbl_fsvp_files(record_id, record_type, filename, path, document_date, expiration_date, note, uploaded_at) VALUES (?,?,?,?,?,?,?,?)";
        $filesRecords = [];
        $params = [];

        // process uploads
        $csFile = null;
        $uploadPath = getUploadsDir('fsvp/supplier_lists');
        if($_POST['compliance_statement'] == 1 && ($csFile = uploadFile($uploadPath, $_FILES['compliance_statement_file']))) {
            $csFile = [
                "filename" => $csFile,
                "path" => $uploadPath,
                "document_date" => $_POST['csf_date'] ?? null,
                "expiration_date" => $_POST["csf_exp"] ?? null,
                "note" => $_POST["csf_note"] ?? null,
                "uploaded_at" => $currentTimestamp,
            ];

            $conn->execute($fileInsertQuery, [$id, 'supplier-list:compliance-statement', ...array_values($csFile)]);
            $csFile['id'] = $conn->getInsertId();
            $csFile = prepareFileInfo($csFile);
        }

        $saFiles = null;
        if($_POST['supplier_agreement'] == 1) {
            $saFiles = [];            
            $files = uploadFile($uploadPath, $_FILES['supplier_agreement_file']);
            foreach($files as $index => $file) {
                $info = [
                    "filename" => $file,
                    "path" => $uploadPath,
                    "document_date" => $_POST['saf_date'][$index] ?? null,
                    "expiration_date" => $_POST["saf_exp"][$index] ?? null,
                    "note" => $_POST["saf_note"][$index] ?? null,
                    "uploaded_at" => $currentTimestamp,
                ];
                
                $conn->execute($fileInsertQuery, [$id, 'supplier-list:supplier-agreement', ...array_values($info)]);
                $info['id'] = $conn->getInsertId();
                $saFiles[] = prepareFileInfo($info);
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
            "message" => 'Error occured.',
        ], 500);
    }
}

// suppliers list
if(isset($_GET['suppliersByUser'])) {
    send_response([
        'data' => getSupplierList($conn, $user_id),
    ]);
}

// searching employee
if(isset($_POST['search-employee'])) {
    try {
        $search = mysqli_real_escape_string($conn, $_POST['search-employee']);
        // store result ids
        $employeeIds = [];
        $jdIds = [];

        $result = $conn->execute("SELECT CONCAT(TRIM(first_name), ' ', TRIM(last_name)) AS name, ID as id, email, job_description_id as jd 
            FROM tbl_hr_employee WHERE user_id = ? AND (first_name LIKE '%$search%' OR last_name LIKE '%$search%') AND status = 1 
            ORDER BY first_name ASC
        ", $user_id)->fetchAll(function($d) use(&$employeeIds, &$jdIds) {
            $jds = explode(', ', $d["jd"]);
            $d['jd'] = $jds[0];

            if(!in_array($jds[0], $jdIds))  {
                $jdIds[] = $jds[0];
            }

            if(!in_array($d['id'], $employeeIds)) {
                $employeeIds[] = $d["id"];
            }

            return $d;
        });

        $info = getEmployeesInfo($conn, $employeeIds, $jdIds);
        $employeeInfo = $info['employees_info'];
        $jds = $info['job_descriptions'];

        $roster = [];
        foreach($result as $row) {
            $row['avatar'] = $employeeInfo[$row['id']] ?? 'https://via.placeholder.com/100x100/EFEFEF/AAAAAA.png?text=no+image';
            $avatar = !empty($employeeInfo[$row['id']]) ? $employeeInfo[$row['id']]['avatar'] ?? null : null;
            $phone = !empty($employeeInfo[$row['id']]) ? $employeeInfo[$row['id']]['mobile'] ?? null : null;
            $roster[] = [
                'id' => $row['id'],
                'avatar'=> $avatar ?? 'https://via.placeholder.com/100x100/EFEFEF/AAAAAA.png?text=no+image',
                'name' => $row['name'],
                'email'=> $row['email'],
                'phone'=> $phone ?? '',
                'position'=> $jds[$row['jd']] ?? '',
            ];
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

// adding team roster
if(isset($_GET['newFSVPTeamMember'])) {
    try {
        $conn->begin_transaction();

        $employee = $_POST['employee'];
        $conn->insert('tbl_fsvp_team_roster', [
            'employee_id'=> $employee,
            'type'=> $_POST['member_type'] ?? 'primary',
            'user_id' => $user_id,
            'portal_user' => $portal_user,
        ]);

        $id  = $conn->getInsertId();
    
        $conn->commit();
        send_response([
            'message' => 'Successfully saved!',
            'id' => $id,
        ]);
    } catch(Throwable $e) {
        $conn->rollback();
        http_response_code(500);
        echo $e->getMessage();
    }
}

// initializing fsvp team table
if(isset($_GET['getFSVPRoster'])) {
    try {
        $empIds = [];
        $jdIds = [];
        $members = $conn->execute("SELECT 
                    tr.id, 
                    tr.type,
                    tr.employee_id,
                    he.email, 
                    he.job_description_id as jd,
                    CONCAT(TRIM(he.first_name), ' ', TRIM(he.last_name)) AS name
                FROM tbl_fsvp_team_roster tr
                LEFT JOIN tbl_hr_employee he ON he.ID = tr.employee_id 
                WHERE tr.user_id = ? AND tr.deleted_at IS NULL 
                ORDER BY tr.created_at DESC
            ", $user_id)->fetchAll(function($d) use(&$empIds, &$jdIds) {
                $jds = explode(', ', $d["jd"]);
                $d['jd'] = $jds[0];

                if(!in_array($jds[0], $jdIds))  {
                    $jdIds[] = $jds[0];
                }

                if(!in_array($d['id'], $empIds)) {
                    $empIds[] = $d["employee_id"];
                }
                
                return $d;
            });
            
        $roster = [];
        $info = getEmployeesInfo($conn, $empIds, $jdIds);

        if($info) {
            $employeeInfo = $info['employees_info'];
            $jds = $info['job_descriptions'];
    
            foreach($members as $row) {
                $row['avatar'] = $employeeInfo[$row['id']] ?? 'https://via.placeholder.com/100x100/EFEFEF/AAAAAA.png?text=no+image';
                $avatar = !empty($employeeInfo[$row['id']]) ? $employeeInfo[$row['id']]['avatar'] ?? null : null;
                $phone = !empty($employeeInfo[$row['id']]) ? $employeeInfo[$row['id']]['mobile'] ?? null : null;
                $roster[] = [
                    'id' => $row['id'],
                    'avatar'=> $avatar ?? 'https://via.placeholder.com/100x100/EFEFEF/AAAAAA.png?text=no+image',
                    'name' => $row['name'],
                    'email'=> $row['email'],
                    'type'=> $row['type'],
                    'phone'=> $phone ?? '',
                    'position'=> $jds[$row['jd']] ?? '',
                ];
            }
        }
            
        send_response([
            'data' => $roster,
        ]);
    } catch(Throwable $e) {
        http_response_code(500);
        echo $e->getMessage();
    }
}

// updating fsvp team table
if(isset($_GET['updateFSVPTeamRoster'])) {
    try {
        $updates = json_decode($_POST['updates'] ?? '[]', true);
    
        $forRemoval = [];
        $toAlternate = [];
        $toPrimary = [];
        foreach($updates as $id => $d) {
            if(isset($d['remove']) && $d['remove'] == true) {
                $forRemoval[] = $id;
            } else if(isset($d['type'])) {
                if($d['type'] == 'alternate')
                    $toAlternate[] = $id;
                else if($d['type'] == 'primary')
                    $toPrimary[] = $id;
            }
        }

        $conn->begin_transaction();

        if(count($forRemoval) > 0) {
            $forRemoval = implode(',', $forRemoval);
            $conn->execute("UPDATE tbl_fsvp_team_roster SET deleted_at = ? WHERE id IN ($forRemoval)", $currentTimestamp);
        }

        if(count($toPrimary) > 0) {
            $toPrimary = implode(",", $toPrimary);
            $conn->execute("UPDATE tbl_fsvp_team_roster SET type = 'primary' WHERE id IN ($toPrimary)");
        }

        if(count($toAlternate) > 0) {
            $toAlternate = implode(",", $toAlternate);
            $conn->execute("UPDATE tbl_fsvp_team_roster SET type = 'alternate' WHERE id IN ($toAlternate)");
        }

        $conn->commit();
        send_response([
            'message' => 'Saved successfully!',
        ]);
    } catch(Throwable $e) {
        $conn->rollback();
        http_response_code(500);
        echo $e->getMessage();
    }
}

// fetching fsvpqi employees
if(isset($_GET['getFSVPQIs'])) {
    $fsvpId = fsvpqiJDId($conn, $user_id);
    $employees = [];

    if(!empty($fsvpId)) {
        $result = $conn->select('tbl_hr_employee', "ID AS id, CONCAT(TRIM(first_name), ' ', TRIM(last_name)) AS name, job_description_id", "user_id = $user_id AND status = 1")->fetchAll(function ($data) use($fsvpId) {
            $jds = array_map(function($d) { return intval($d); }, explode(', ', $data['job_description_id']));
    
            if(in_array($fsvpId, $jds)){
                unset($data['job_description_id']);
                return $data;
            }
    
            return null;
        });
    
        foreach($result as $row) {
            if(isset($row) && !empty($row)) {
                $employees[] = $row;   
            }
        }
    }
        
    send_response([
        'result' => $employees,
    ]);
}

if(isset($_GET['newFSVPQI'])) {
    try {
        $conn->begin_transaction();

        $fsvpqi = $_POST['fsvpqi'] ?? null;
        $ces = $_POST['ces'] ?? null;

        if(empty($fsvpqi)) {
            throw new Exception('FSVPQI is required.');
        }
        
        $conn->insert('tbl_fsvp_qi', [
            'employee_id' => $fsvpqi,
            'c_e_s' => $ces,
            'user_id' => $user_id,
            'portal_user' => $portal_user,
        ]);

        $id = $conn->getInsertId();
        $type = 'fsvpqi-certifications';
        $uploadPath = getUploadsDir('fsvp/qi_certifications');
        $filesData = [];

        if(isset($_POST['c_pcqi_certified']) && $_POST['c_pcqi_certified'] == 'true') {
            $d = saveFSVPQICertificate($_POST, 'c_pcqi_certified');
            $conn->insert('tbl_fsvp_files', [
                'record_id' => $id,
                'record_type' => "$type:pcqi-certificate",
                ...$d,
            ]);
            $d['id'] = $conn->getInsertId();
            $d['filename'] = embedFileUrl($d['filename'], $d['path']);
            $filesData['c_pcqi_certified'] = $d;
        }

        if(isset($_POST['c_food_quality_auditing']) && $_POST['c_food_quality_auditing'] == 'true') {
            $d = saveFSVPQICertificate($_POST, 'c_food_quality_auditing');
            $conn->insert('tbl_fsvp_files', [
                'record_id' => $id,
                'record_type' => "$type:food-quality-auditing",
                ...$d,
            ]);
            $d['id'] = $conn->getInsertId();
            $d['filename'] = embedFileUrl($d['filename'], $d['path']);
            $filesData['c_food_quality_auditing'] = $d;
        }
        
        if(isset($_POST['c_haccp_training']) && $_POST['c_haccp_training'] == 'true') {
            $d = saveFSVPQICertificate($_POST, 'c_haccp_training');
            $conn->insert('tbl_fsvp_files', [
                'record_id' => $id,
                'record_type' => "$type:haccp-training",
                ...$d,
            ]);
            $d['id'] = $conn->getInsertId();
            $d['filename'] = embedFileUrl($d['filename'], $d['path']);
            $filesData['c_haccp_training'] = $d;
        }

        if(isset($_POST['c_fs_training_certificate']) && $_POST['c_fs_training_certificate'] == 'true') {
            $d = saveFSVPQICertificate($_POST, 'c_fs_training_certificate');
            $conn->insert('tbl_fsvp_files', [
                'record_id' => $id,
                'record_type' => "$type:food-safety-training-certificate",
                ...$d,
            ]);
            $d['id'] = $conn->getInsertId();
            $d['filename'] = embedFileUrl($d['filename'], $d['path']);
            $filesData['c_fs_training_certificate'] = $d;
        }

        if(isset($_POST['c_gfsi_certificate']) && $_POST['c_gfsi_certificate'] == 'true') {
            $d = saveFSVPQICertificate($_POST, 'c_gfsi_certificate');
            $conn->insert('tbl_fsvp_files', [
                'record_id' => $id,
                'record_type' => "$type:gfsi-certificate",
                ...$d,
            ]);
            $d['id'] = $conn->getInsertId();
            $d['filename'] = embedFileUrl($d['filename'], $d['path']);
            $filesData['c_gfsi_certificate'] = $d;
        }

        $name = $conn->select('tbl_hr_employee', "CONCAT(TRIM(first_name), ' ', TRIM(last_name)) AS name", "ID = $fsvpqi")->fetchAssoc()['name'];
        
        $conn->commit();
        send_response([
            'data' => [
                'certifications'=> $filesData,
                'id' => $id,
                'ces' => $ces,
                'name' => $name,
            ],
            'message' => "Saved successfully."
        ]);
    } catch(Throwable $e) {
        $conn->rollback();
        send_response([
            "info"=> $e->getMessage(),
            "message" => 'Error occured.',
        ], 500);
    }
}