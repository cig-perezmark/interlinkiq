<?php

include_once __DIR__ ."/utils.php";
// include_once __DIR__ ."/../../alt-setup/setup.php";

date_default_timezone_set('America/Chicago');
$currentTimestamp = date('Y-m-d H:i:s');

if(empty($user_id)) {
    exit('Invalid session.');
}

// note: no filter for foreign suppliers yet
// fetching supplier for dropdown
if(isset($_GET["getProductsBySupplier"]) && !empty($_GET["getProductsBySupplier"])) {
    $materials = $conn->select("tbl_supplier", "material, address", ["ID" => $_GET["getProductsBySupplier"]])->fetchAssoc();
    $mIds = $materials['material'];
    $data = [];
    
    if(!empty($mIds)) {
        $data = $conn->select("tbl_supplier_material", "material_name AS name, ID as id, description", "ID in ($mIds) AND active = 1")->fetchAll();
    }
    
    send_response([
        "materials"=> $data,
        'address' => formatSupplierAddress($materials['address']),
    ]);
}

// new supplier list, submit
if(isset($_GET["newSupplierToList"])) {
    try {
        $conn->begin_transaction();
        $conn->escapeString = false;
        
        $supplierId = $_POST["supplier"];
        $supplierData = $conn->select("tbl_supplier", "address, name", ["ID" => $supplierId])->fetchAssoc(function ($d) {
            return [
                'address' => formatSupplierAddress($d["address"]),
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
        if(isset($_POST['compliance_statement']) && $_POST['compliance_statement'] == 1 && ($csFile = uploadFile($uploadPath, $_FILES['compliance_statement_file']))) {
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
        if(isset($_POST['supplier_agreement']) && $_POST['supplier_agreement'] == 1) {
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
        http_response_code(500);
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

// for populating dropdown in fsvpqi reg page
if(isset($_GET['getFSVPQIsForRegistration'])) {
    $fsvpId = fsvpqiJDId($conn, $user_id);
    $employees = [];
    $resultData = [];

    // checking existing fsvpqis
    $a = $conn->execute("SELECT DISTINCT employee_id FROM tbl_fsvp_qi WHERE user_id = ? AND deleted_at IS NULL", $user_id)->fetchAll();
    $fsvpqiIdsInRecord = implode(',', array_map(function($d) { return $d['employee_id']; }, $a));

    if(!empty($fsvpId)) {
        $cond = "user_id = $user_id AND status = 1";

        if(!empty($fsvpqiIdsInRecord)) {
            $cond .= " AND ID NOT IN ($fsvpqiIdsInRecord)";
        }
        
        $result = $conn->select('tbl_hr_employee', "ID AS id, CONCAT(TRIM(first_name), ' ', TRIM(last_name)) AS name, job_description_id", $cond)->fetchAll(function ($data) use($fsvpId) {
            $jds = array_map(function($d) { return intval($d); }, explode(', ', $data['job_description_id']));
    
            if(in_array($fsvpId, $jds)){
                unset($data['job_description_id']);
                return $data;
            }
    
            return null;
        });
    
        $resultData['result'] = [];
        foreach($result as $row) {
            if(isset($row) && !empty($row)) {
                $resultData['result'][] = $row;   
            }
        }

        if(count($resultData['result']) == 0) {
            $resultData['message'] = 'All FSVPQIs have already been added.';
        }
    } else {
        $resultData = [
            'result' => [],
            'message' => 'No data available.'
        ];
    }
        
    send_response($resultData);
}

// add fsvpqi 
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
            $filesData['pcqi-certificate'] = $d;
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
            $filesData['food-quality-auditing'] = $d;
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
            $filesData['haccp-training'] = $d;
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
            $filesData['food-safety-training-certificate'] = $d;
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
            $filesData['gfsi-certificate'] = $d;
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

// displaying fsvpqis to table
if(isset($_GET['fetchFSVPQI']) ) {
    try {
        $recordType = 'fsvpqi-certifications';
        $fsvpqis = $conn->execute("SELECT q.*, CONCAT(TRIM(e.first_name), ' ', TRIM(e.last_name)) AS name FROM tbl_fsvp_qi q JOIN tbl_hr_employee e ON e.ID = q.employee_id WHERE q.user_id = ? AND deleted_at IS NULL", $user_id)->fetchAll();
        $data = [];

        foreach($fsvpqis as $f) {
            $files = $conn->select("tbl_fsvp_files","*", "deleted_at IS NULL AND record_type LIKE '$recordType%' AND record_id = " . $f['id'])->fetchAll();
            $fd = [];
            if(count($files) > 0) {
                foreach ($files as $file) {
                    $type = explode(':', $file['record_type'])[1];
                    $fd[$type] = prepareFileInfo($file);
                }
            }
            $data[] = [
                'id' => $f['id'],
                'name' => $f['name'],
                'ces' => $f['c_e_s'],
                'certifications' => $fd,
            ];
        }

        send_response([
            'data' => $data,
        ]);
    } catch(Throwable $e) {
        http_response_code(500);
        echo $e->getMessage();
    }
}

// populating fsvpqis to dropdowns outside the fsvpqi page
if(isset($_GET['myFSVPQIInRecords']) ) {
    $result = $conn->execute("SELECT q.id, CONCAT(TRIM(e.first_name), ' ', TRIM(e.last_name)) AS name, email FROM tbl_fsvp_qi q JOIN tbl_hr_employee e ON q.employee_id = e.ID WHERE q.user_id = ? AND q.deleted_at IS NULL", $user_id)->fetchAll();
    send_response([
        'result' => $result,
    ]);
}

// adding new importer
if(isset($_GET['newImporter']) ) {
    try {
        $conn->begin_transaction();

        if(!isset($_POST['importer']) || !isset($_POST['fsvpqi']) || !isset($_POST['evaluation_date'])) {
            throw new Exception('Incomplete fields.');
        }

        $insertData = [
            'user_id' => $user_id,
            'portal_user' => $portal_user,
            'importer_id' => $_POST['importer'],
            'supplier_id' => $_POST['supplier'] ?? null,
            'fsvpqi_id' =>  $_POST['fsvpqi'],
            'evaluation_date' =>  $_POST['evaluation_date'],
            'duns_no' =>  $_POST['duns_no'],
            'fda_registration' =>  $_POST['fda_registration'],
            'products' => json_encode($_POST['importer_products'] ?? []),
        ];
        $conn->insert("tbl_fsvp_importers", $insertData);

        $id = $conn->getInsertId();
        $importerName = $conn->select("tbl_supplier", 'name', "ID = " . $insertData['importer_id'])->fetchAssoc()['name'] ?? null;
        $fsvpqiName = $conn->execute("SELECT CONCAT(TRIM(emp.first_name), ' ', TRIM(emp.last_name)) as name FROM tbl_fsvp_qi qi JOIN tbl_hr_employee emp ON emp.ID = qi.employee_id WHERE qi.id = ?", $insertData['fsvpqi_id'])->fetchAssoc()['name'] ?? null;
        
        if(isset($insertData['supplier_id'])) {
            $supplierName = $conn->select("tbl_supplier", 'name', "ID = " . $insertData['supplier_id'])->fetchAssoc()['name'] ?? null;
        }

        $conn->commit();
        send_response([
            'message' => 'Saved successfully.',
            'data' => [
                'id' => $id,
                'duns_no' => $insertData['duns_no'],
                'fda_registration' => $insertData['fda_registration'],
                'evaluation_date' => $insertData['evaluation_date'],
                'importer' => [
                    'id' => $insertData['importer_id'],
                    'name' => $importerName,
                ],
                'supplier' => [
                    'id' => $insertData['supplier_id'],
                    'name' => $supplierName ?? null,
                ],
                'fsvpqi' => [
                    'id' => $insertData['fsvpqi_id'],
                    'name' => $fsvpqiName,
                ]
            ],
        ]);
    } catch(Throwable $e) {
        $conn->rollback();
        http_response_code(500);
        echo $e->getMessage();
    }
}

// displaying importers to table
if(isset($_GET['fetchImportersForTable'])) {
    $result = $conn->execute(
        "SELECT 
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
            sup.name AS supplier_name,
            cbp.id AS cbp_id,
            cbp.foods_info,
            cbp.supplier_info,
            cbp.determining_importer,
            cbp.designated_importer,
            cbp.cbp_entry_filer,
            cbp.prev_record_id AS previous_cbp_record_id,
            cbp.created_at AS cbp_date
        FROM 
            tbl_fsvp_importers i 
            LEFT JOIN tbl_supplier imp ON imp.ID = i.importer_id
            LEFT JOIN tbl_supplier sup ON sup.ID = i.supplier_id
            LEFT JOIN tbl_fsvp_qi qi ON qi.id = i.fsvpqi_id
            LEFT JOIN tbl_hr_employee emp ON emp.ID = qi.employee_id
            LEFT JOIN tbl_fsvp_cbp_records cbp ON cbp.importer_id = i.id
            RIGHT JOIN (
                SELECT importer_id, MAX(created_at) AS max_created_at
                FROM tbl_fsvp_cbp_records
                WHERE deleted_at IS NULL
                GROUP BY importer_id
            ) latest_cbp ON cbp.importer_id = latest_cbp.importer_id AND cbp.created_at = latest_cbp.max_created_at
        WHERE 
            i.deleted_at IS NULL AND i.user_id = ?
        ORDER BY cbp.created_at DESC",
        $user_id
    )->fetchAll(function($data) {
        return [
            'id' => $data['id'],
            'duns_no' => $data['duns_no'],
            'fda_registration' => $data['fda_registration'],
            'evaluation_date' => $data['evaluation_date'],
            'importer' => [
                'id' => $data['importer_id'],
                'name' => $data['importer_name'],
                'address' => formatSupplierAddress($data['importer_address']),
            ],
            'supplier' => [
                'id' => $data['supplier_id'],
                'name' => $data['supplier_name'],
            ],
            'fsvpqi' => [
                'id' => $data['fsvpqi_id'],
                'name' => $data['fsvpqi_name'],
            ],
            'cbp' => [
                'id' => $data['cbp_id'],
                'prev_id' => $data['previous_cbp_record_id'],
                'foods_info' => $data['foods_info'],
                'supplier_info' => $data['supplier_info'],
                'determining_importer' => $data['determining_importer'],
                'designated_importer' => $data['designated_importer'],
                'cbp_entry_filer' => $data['cbp_entry_filer'],
                'date' => date('Y-m-d', strtotime($data['cbp_date'])),
            ]
        ];
    });

    send_response([
        'data' => $result,
    ]);
}

// adding supplier evaluation
if(isset($_GET['newSupplierEvaluation'])) {
    try {
        $conn->begin_transaction();

        if(empty($_POST['importer'])) {
            throw new Exception('Importer is required.');
        }

        if(empty($_POST['supplier'])) {
            throw new Exception('No foreign supplier is acquired.');
        }

        $params = [
            'user_id'                       => $user_id,
            'portal_user'                   => $portal_user,
            'supplier_id'                   => $_POST['supplier'],
            'importer_id'                   => $_POST['importer'],
            'description'                   => emptyIsNull($_POST['description']),
            'evaluation'                    => emptyIsNull($_POST['evaluation']),
            'info_related'                  => emptyIsNull($_POST['info_related']),
            'rejection_date'                => emptyIsNull($_POST['rejection_date']),
            'approval_date'                 => emptyIsNull($_POST['approval_date']),
            'assessment'                    => emptyIsNull($_POST['assessment']),
        ];

        $conn->insert("tbl_fsvp_evaluations", $params);
        $id = $conn->getInsertId();
        saveNewEvaluationRecord($conn, $_POST, $id);
        
        $conn->commit();
        send_response([
            'data' => getEvaluationRecordID($conn, $params['supplier_id']),
            'message' => 'Saved successfully.',
        ]);
    } catch(Throwable $e) {
        $conn->rollback();
        send_response([
            'error' => $e->getMessage(),
        ], 500);
    }
}

// viewing evaluation data
if(!empty($_GET['viewEvaluationData'])) {
    $id = $_GET['viewEvaluationData'];
    $recordId = emptyIsNull($_GET['r'] ?? NULL);
    send_response([
        'data' => getEvaluationData($conn, $id, $recordId),
    ]);
}

// re evaluation
if(isset($_GET['supplierReEvaluation']) && !empty($_POST['prev_record_id'])) {
    try {
        // verify evaluation id
        $recordId = intval($_POST['prev_record_id']) ?? null;
    
        if(empty($recordId)) {
            throw new Exception("Invalid previous evaluation id.");
        }

        $isValid = $conn->execute("SELECT id, evaluation_due_date, evaluation_id  FROM tbl_fsvp_evaluation_records WHERE id = ?", $recordId)->fetchAssoc();

        if(!count($isValid)) {
            throw new Exception("No matching previous record(s) found.");
        } else if(strtotime(date('Y-m-d') > strtotime($isValid['evaluation_due_date']))) {
            throw new Exception('Previous evaluation data is currently active.');
        }

        $data = saveNewEvaluationRecord($conn, $_POST, $isValid['evaluation_id'], $recordId);
        
        send_response([
            'data' => $data,
            'message' => 'Saved successfully.'
        ]);
    } catch(Throwable $e) {
        $conn->rollback();
        send_response([
            'message' => $e->getMessage(),
        ], 500);
    }
}

// add new cbp record
if(isset($_GET['newCBPRecord'])) {
    try {
        $importerId = $_POST['importer'];

        if(empty($importerId)) {
            throw new Exception('Importer is required.');
        }

        $conn->begin_transaction();

        $values = [
            'user_id'               => $user_id,
            'portal_user'           => $portal_user,
            'importer_id'           => $importerId,
            'foods_info'            => $_POST['foods_info'],
            'supplier_info'         => $_POST['supplier_info'],
            'determining_importer'  => $_POST['determining_importer'],
            'designated_importer'   => $_POST['designated_importer'],
            'cbp_entry_filer'       => $_POST['cbp_entry_filer'],
        ];

        $conn->insert("tbl_fsvp_cbp_records", $values);
        $id = $conn->getInsertId();

        $conn->commit();
        send_response([
            'message' => 'Successfully saved.',
            'data' => [
                'id' => $id,
                'prev_id' => null,
                'foods_info' => $values['foods_info'],
                'supplier_info' => $values['supplier_info'],
                'determining_importer' => $values['determining_importer'],
                'designated_importer' => $values['designated_importer'],
                'cbp_entry_filer' => $values['cbp_entry_filer'],
            ]
        ]);
    } catch(Throwable $e) {
        $conn->rollback();
        send_response([
            'error' => $e->getMessage(),
        ], 500);
    }
}