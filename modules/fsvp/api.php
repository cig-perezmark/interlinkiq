<?php

include_once __DIR__ ."/utils.php";
// include_once __DIR__ ."/../../alt-setup/setup.php";

date_default_timezone_set('America/Chicago');
$currentTimestamp = date('Y-m-d H:i:s');

if(empty($user_id)) {
    exit('Invalid session.');
}

if(isset($_GET["getProductsByForeignSupplier"]) && !empty($_GET["getProductsByForeignSupplier"])) {
    $foreignSupplierId = $_GET["getProductsByForeignSupplier"] ?? 0;
    $fsvpSupplierId = $_GET["fsvpSupplier"] ??0;

    $materials = [];
    $address = "";
    $data = array();

    if(isset($_GET['raw']) && $_GET['raw'] == 'true') {
        $materials = $conn->select("tbl_supplier", "material, address", ["ID" => $foreignSupplierId])->fetchAssoc();
        $mIds = $materials['material'];

        if(!empty($mIds)) {
            if(!empty($fsvpSupplierId)) {
                $data = $conn->execute("SELECT 
                        mat.material_name AS name, 
                        mat.ID as id, description,
                        IF(ipr.id IS NULL, 'false', 'true') AS selected,
                        IF(iby.id IS NULL, 'false', 'true') AS locked
                    FROM tbl_supplier_material mat
                    LEFT JOIN tbl_fsvp_ingredients_product_register ipr ON ipr.product_id = mat.ID AND ipr.supplier_id = ? AND ipr.user_id = ? AND ipr.deleted_at IS NULL
                    LEFT JOIN tbl_fsvp_ipr_imported_by iby ON iby.product_id = ipr.id AND iby.deleted_at IS NULL
                    WHERE mat.ID in ($mIds) AND mat.active = 1", $fsvpSupplierId, $user_id
                )->fetchAll();
            } else{
                $data = $conn->select("tbl_supplier_material", "material_name AS name, ID as id, description", "ID in ($mIds) AND active = 1")->fetchAll();
            }
        }
        
        $address = formatSupplierAddress($materials['address']);
    } else {
        $materials = $conn->execute("SELECT ipr.id,
            mat.material_name AS name,
            mat.description,
            sup.address
            FROM tbl_fsvp_ingredients_product_register ipr
            LEFT JOIN tbl_supplier_material mat ON mat.ID = ipr.product_id
            LEFT JOIN tbl_fsvp_suppliers fsup ON fsup.id = ipr.supplier_id
            LEFT JOIN tbl_supplier sup ON sup.ID = fsup.supplier_id
            WHERE mat.active = 1 AND ipr.user_id = ? AND ipr.supplier_id = ? AND ipr.deleted_at IS NULL
        ", $user_id, $foreignSupplierId)->fetchAll();

        foreach($materials as $material) {
            $address = $material["address"];
            $data[] = [
                'id' => $material['id'],
                'name' => $material['name'],
                'description' => $material['description'],
            ];
        }
    }
    
    send_response([
        "materials"=> $data,
        'address' => formatSupplierAddress($address),
    ]);
}

// new supplier list, submit
if(isset($_GET["newSupplierToList"])) {
    try {
        $conn->begin_transaction();
        $conn->escapeString = false;

        $fsvpSupplierId = $_POST['fsvp_supplier_id'] ?? null;
        
        $supplierId = $_POST["supplier"];
        $supplierData = $conn->select("tbl_supplier", "address, name", ["ID" => $supplierId])->fetchAssoc(function ($d) {
            return [
                'address' => formatSupplierAddress($d["address"]),
                'name' => $d['name']
            ];
        });

        $foodImported = $_POST['food_imported'] ?? [];
        $id = null;

        if(empty($fsvpSupplierId)) {
            // initializing record
            $conn->execute("INSERT INTO tbl_fsvp_suppliers (user_id, portal_user, supplier_id, supplier_agreement, compliance_statement) VALUE (?,?,?,?,?)", [
                $user_id,
                $portal_user,
                $supplierId,
                $_POST['supplier_agreement'] ?? 0,
                $_POST['compliance_statement'] ?? 0,
            ]);

            $id = $conn->getInsertId();
            $foodParams = [];
            $foodValues = [];

            // register products/food imported data
            foreach($foodImported as $food) {
                $foodValues = array_merge($foodValues, [$user_id, $portal_user, $id, $food]);
                $foodParams[] = "(?,?,?,?)";
            }

            if(count($foodParams)) {
                $sql = "INSERT INTO tbl_fsvp_ingredients_product_register(user_id, portal_user, supplier_id, product_id ) VALUES " . implode(',', $foodParams);
                $conn->execute($sql, $foodValues);
            }
        } else {
            // updating fsvp supplier
            
            $id = $fsvpSupplierId;
            $sqlParams = [$user_id];
            $sql = "UPDATE tbl_fsvp_suppliers SET portal_user = ?";

            $sa = $_POST['supplier_agreement'] ?? null;
            $cs = $_POST['compliance_statement'] ?? null;

            if($sa != null) {
                $sql .= ", supplier_agreement = ?";
                $sqlParams[] = $sa;
            }

            if($cs != null) {
                $sql .= ", compliance_statement = ?";
                $sqlParams[] = $cs;
            }

            $sql .= " WHERE id = ?";
            $sqlParams[] = $id;

            $conn->execute($sql , $sqlParams);
            
            if(count($foodImported)) {
                $oldProducts = $conn->execute("SELECT product_id as id from tbl_fsvp_ingredients_product_register WHERE supplier_id = ?", $id)->fetchAll(function ($d) { return $d['id']; });
                $newProducts = [];
                $removedProducts = [];
                $fp = [];

                // removed products
                foreach($oldProducts as $opId) {
                    if(!in_array($opId, $foodImported)) {
                        $removedProducts[] = $opId;
                    }
                }
                
                if(count($removedProducts)) {
                    $p = implode(',', $removedProducts);
                    $conn->execute("UPDATE tbl_fsvp_ingredients_product_register SET deleted_at = CURRENT_TIMESTAMP() WHERE product_id IN ($p) AND user_id = ? AND deleted_at IS NULL", $user_id);
                }

                // new products
                foreach($foodImported as $f) {
                    if(!in_array($f, $oldProducts)) {
                        $newProducts = array_merge($newProducts, [$user_id, $portal_user, $id, $f]);
                        $fp[] = "(?,?,?,?)";
                    }
                }

                if(count($newProducts)) {
                    $sql = "INSERT INTO tbl_fsvp_ingredients_product_register(user_id, portal_user, supplier_id, product_id ) VALUES " . implode(',', $fp);
                    $conn->execute($sql, $newProducts);
                }
            }
        }
        
        $fileInsertQuery = "INSERT tbl_fsvp_files(record_id, record_type, filename, path, document_date, expiration_date, note, uploaded_at) VALUES (?,?,?,?,?,?,?,?)";
        $filesRecords = [];
        $params = [];

        // process uploads
        $csFile = null;
        $uploadPath = getUploadsDir('fsvp/supplier_lists');
        
        // file details has been updated
        if(isset($_POST['compliance_statement_file'])) {
            $recordType = 'supplier-list:compliance-statement';
            $fileId = $_POST['compliance_statement_file'];
            
            $conn->execute(
                "UPDATE tbl_fsvp_files SET document_date = ?, expiration_date = ?, note = ? WHERE id = ?",
                $_POST['csf_date'] ?? null, $_POST["csf_exp"] ?? null, $_POST["csf_note"] ?? null, $fileId
            );
        } 
        // for new uploads
        else if(isset($_POST['compliance_statement']) && $_POST['compliance_statement'] == 1 && ($csFile = uploadFile($uploadPath, $_FILES['compliance_statement_file']))) {
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
        // removed/not existing
        else {
            $conn->execute("UPDATE tbl_fsvp_files SET deleted_at = ? WHERE record_id = ? AND record_type = ? AND deleted_at IS NULL",[
                $currentTimestamp, $id, "supplier-list:compliance-statement",
            ]);
        }

        $saFiles = null;
        $hasSAParam = false; // used for checking no-file entry (removed by user)

        /**
         * existing file records stores the ID only
         * so $_POST body is checked instead
         */
        if(isset($_POST['supplier_agreement_file'])){
            // perhaps it's an array of IDs
            $fileIds = $_POST['supplier_agreement_file'];

            if(!empty($fileIds)) {
                // soft delete file records that are not present in the current request (removed by the user)
                $conn->execute(
                    "UPDATE tbl_fsvp_files SET deleted_at = ? WHERE deleted_at IS NULL AND id NOT IN (". implode(',', $fileIds) .")",
                    $currentTimestamp
                );
            }
            
            // update present data
            foreach($fileIds as $index => $fileId) {
                $conn->execute(
                    "UPDATE tbl_fsvp_files SET document_date = ?, expiration_date = ?, note = ? WHERE id =?",
                    $_POST['saf_date'][$index] ?? null, $_POST["saf_exp"][$index] ?? null, $_POST["saf_note"][$index] ?? null, $fileId
                );
            }

            $hasSAParam = true;
        } 
        
        // check for new uploads, save it 
        if(isset($_POST['supplier_agreement']) && $_POST['supplier_agreement'] == 1 && isset($_FILES['supplier_agreement_file'])) {
            // saving new files
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
            $hasSAParam = true;
        } 
        
        // delete existing records if request data is not present
        if(!$hasSAParam) {
            $conn->execute("UPDATE tbl_fsvp_files SET deleted_at = ? WHERE record_id = ? AND record_type = ? AND deleted_at IS NULL",[
                $currentTimestamp, $id, "supplier-list:supplier-agreement",
            ]);
        }
        
        // food imported names
        if(count($foodImported)) {
            $mIds = implode(', ', $foodImported);
            $materialData = $conn->select("tbl_supplier_material", "material_name AS name, ID as id", "ID in ($mIds)")->fetchAll();
        }

        $conn->commit();
        send_response([
            'data' => [
                "address" => $supplierData['address'],
                "name" => $supplierData['name'],
                "id" => $id,
                "food_imported" => $materialData ?? null,
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

if(isset($_GET['evaluationsByUser'])) {
    send_response([
        'data' => getEvaluationsPerSupplierAndImporter($conn, $user_id),
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
            $conn->insert('tbl_fsvp_files', array_merge([
                'record_id' => $id,
                'record_type' => "$type:pcqi-certificate",
            ], $d));
            $d['id'] = $conn->getInsertId();
            $d['filename'] = embedFileUrl($d['filename'], $d['path']);
            $filesData['pcqi-certificate'] = $d;
        }

        if(isset($_POST['c_food_quality_auditing']) && $_POST['c_food_quality_auditing'] == 'true') {
            $d = saveFSVPQICertificate($_POST, 'c_food_quality_auditing');
            $conn->insert('tbl_fsvp_files', array_merge([
                'record_id' => $id,
                'record_type' => "$type:food-quality-auditing",
            ], $d));
            $d['id'] = $conn->getInsertId();
            $d['filename'] = embedFileUrl($d['filename'], $d['path']);
            $filesData['food-quality-auditing'] = $d;
        }
        
        if(isset($_POST['c_haccp_training']) && $_POST['c_haccp_training'] == 'true') {
            $d = saveFSVPQICertificate($_POST, 'c_haccp_training');
            $conn->insert('tbl_fsvp_files', array_merge([
                'record_id' => $id,
                'record_type' => "$type:haccp-training",
            ], $d));
            $d['id'] = $conn->getInsertId();
            $d['filename'] = embedFileUrl($d['filename'], $d['path']);
            $filesData['haccp-training'] = $d;
        }

        if(isset($_POST['c_fs_training_certificate']) && $_POST['c_fs_training_certificate'] == 'true') {
            $d = saveFSVPQICertificate($_POST, 'c_fs_training_certificate');
            $conn->insert('tbl_fsvp_files', array_merge([
                'record_id' => $id,
                'record_type' => "$type:food-safety-training-certificate",
            ], $d));
            $d['id'] = $conn->getInsertId();
            $d['filename'] = embedFileUrl($d['filename'], $d['path']);
            $filesData['food-safety-training-certificate'] = $d;
        }

        if(isset($_POST['c_gfsi_certificate']) && $_POST['c_gfsi_certificate'] == 'true') {
            $d = saveFSVPQICertificate($_POST, 'c_gfsi_certificate');
            $conn->insert('tbl_fsvp_files', array_merge([
                'record_id' => $id,
                'record_type' => "$type:gfsi-certificate",
            ], $d));
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
    send_response([
        'result' => myFSVPQIs($conn, $user_id),
    ]);
}

// adding new importer
if(isset($_GET['newImporter']) ) {
    try {
        $conn->begin_transaction();

        if(!isset($_POST['importer']) || !isset($_POST['fsvpqi']) || !isset($_POST['evaluation_date'])) {
            throw new Exception('Incomplete fields.');
        }

        $supplierId = $_POST['supplier'] ?? null;
        $importerId = $_POST['importer'];

        $isExisting = $conn->execute("SELECT 
                IF(COUNT(*) > 0, 'true', 'false') AS hasRecords 
            FROM tbl_fsvp_importers
            WHERE user_id =  ?
                AND supplier_id = ? 
                AND importer_id = ?
                AND deleted_at IS NULL
        ", $user_id, $supplierId, $importerId)->fetchAssoc()['hasRecords'] == 'true';

        if($isExisting) {
            throw new Exception('Error: Importer and foreign supplier data already exist.');
        }

        $insertData = [
            'user_id' => $user_id,
            'portal_user' => $portal_user,
            'importer_id' => $importerId,
            'supplier_id' => $supplierId,
            'fsvpqi_id' =>  $_POST['fsvpqi'],
            'evaluation_date' =>  $_POST['evaluation_date'],
            'duns_no' =>  $_POST['duns_no'],
            'fda_registration' =>  $_POST['fda_registration'],
            'signature' =>  $_POST['signature'] ?? null,
            'comments' =>  $_POST['comments'] ?? null,
            'date_signed' =>  $_POST['date_signed'] ?? null,
        ];
        $conn->insert("tbl_fsvp_importers", $insertData);

        // automatically insert initial evaluation data
        
        $id = $conn->getInsertId();
        $conn->execute("INSERT INTO tbl_fsvp_evaluations(user_id, portal_user, importer_id, supplier_id) VALUE(?,?,?,?)", $user_id, $portal_user, $id, $supplierId);

        if(count($_POST['importer_products'])) {
            $productsParams = [];
            $productsValues = [];
            $importerId = $id;

            
            foreach($_POST['importer_products'] as $productId) {
                $productsParams[] = '(?,?,?,?)';
                $productsValues = array_merge($productsValues, [
                    $user_id,
                    $portal_user,
                    $importerId,
                    $productId,
                ]);
            }
            
            // store imported products
            if(count($productsValues)) {
                $sql = "INSERT INTO tbl_fsvp_ipr_imported_by(user_id,portal_user,importer_id,product_id) VALUES ";
                $sql .= implode(', ', $productsParams);
                $conn->execute($sql, $productsValues);
            }
        }
        
        $importerName = $conn->select("tbl_supplier", 'name', "ID = " . $insertData['importer_id'])->fetchAssoc()['name'] ?? null;
        $fsvpqiName = $conn->execute("SELECT CONCAT(TRIM(emp.first_name), ' ', TRIM(emp.last_name)) as name FROM tbl_fsvp_qi qi JOIN tbl_hr_employee emp ON emp.ID = qi.employee_id WHERE qi.id = ?", $insertData['fsvpqi_id'])->fetchAssoc()['name'] ?? null;
        
        if(isset($insertData['supplier_id'])) {
            // $supplierName = $conn->select("tbl_supplier", 'name', "ID = " . $insertData['supplier_id'])->fetchAssoc()['name'] ?? null;
            $supplierName = $conn->execute("SELECT sup.name 
                FROM tbl_fsvp_suppliers fsup 
                LEFT JOIN tbl_supplier sup ON fsup.supplier_id = sup.ID
                WHERE fsup.id = ?
            ", $insertData['supplier_id'])->fetchAssoc()['name'] ?? null;
        }

        $conn->commit();
        send_response([
            'message' => 'Saved successfully.',
            'data' => [
                'id' => $id,
                'rhash' => md5($id),
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
            cbp.created_at AS cbp_date,

            -- added
            cbp.approved_by,
            cbp.approved_by_sign,
            cbp.approve_date,
            cbp.reviewed_by,
            cbp.reviewed_by_sign,
            cbp.review_date,
            cbp.comments
        FROM 
            tbl_fsvp_importers i 
            LEFT JOIN tbl_supplier imp ON imp.ID = i.importer_id
            LEFT JOIN tbl_fsvp_suppliers fsup ON fsup.id = i.supplier_id
            LEFT JOIN tbl_supplier sup ON sup.ID = fsup.supplier_id    
            LEFT JOIN tbl_fsvp_qi qi ON qi.id = i.fsvpqi_id
            LEFT JOIN tbl_hr_employee emp ON emp.ID = qi.employee_id
            LEFT JOIN (
                SELECT 
                    cbp_inner.importer_id, 
                    MAX(cbp_inner.created_at) AS latest_cbp_date
                FROM 
                    tbl_fsvp_cbp_records cbp_inner
                GROUP BY 
                    cbp_inner.importer_id
            ) cbp_max ON cbp_max.importer_id = i.id
            LEFT JOIN tbl_fsvp_cbp_records cbp ON cbp.importer_id = i.id AND cbp.created_at = cbp_max.latest_cbp_date
        WHERE 
            i.deleted_at IS NULL AND i.user_id = ?",
        $user_id
    )->fetchAll(function($data) {
        $cbpData = null;

        if(!empty($data["cbp_id"])) {
            $cbpData = [
                'id' => $data['cbp_id'],
                'ihash' => md5($data['cbp_id']),
                'prev_id' => $data['previous_cbp_record_id'],
                'foods_info' => $data['foods_info'],
                'supplier_info' => $data['supplier_info'],
                'determining_importer' => $data['determining_importer'],
                'designated_importer' => $data['designated_importer'],
                'cbp_entry_filer' => $data['cbp_entry_filer'],
                'comments' => $data['comments'],
                'date' => date('Y-m-d', strtotime($data['cbp_date'])),
                'reviewer' => [
                    'name' => $data['reviewed_by'],
                    'sign' => $data['reviewed_by_sign'],
                    'date' => $data['review_date'],
                ],
                'approver' => [
                    'name' => $data['approved_by'],
                    'sign' => $data['approved_by_sign'],
                    'date' => $data['approve_date'],
                ],
            ];
        }
        
        return [
            'id' => $data['id'],
            'rhash' => md5($data['id']),
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
            'cbp' => $cbpData
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
        $evalId = $_POST['eval'] ?? null;

        if(empty($_POST['supplier'])) {
            throw new Exception('No foreign supplier is acquired.');
        }

        if(empty($evalId)) {
            throw new Exception('No matching record found.');
        }

        $params = [
            $portal_user,
            emptyIsNull($_POST['description']),
            emptyIsNull($_POST['evaluation']),
            emptyIsNull($_POST['info_related']),
            emptyIsNull($_POST['rejection_date']),
            emptyIsNull($_POST['approval_date']),
            emptyIsNull($_POST['assessment']),            
            $evalId,
            $user_id,
        ];

        $conn->execute("UPDATE tbl_fsvp_evaluations SET 
                portal_user = ?,
                description = ?,
                evaluation = ?,
                info_related = ?,
                rejection_date = ?,
                approval_date = ?,
                assessment = ?
            WHERE id = ? AND user_id = ?
        ", $params);
        $evalData = saveNewEvaluationRecord($conn, $_POST, $evalId);
        
        $conn->commit();
        send_response([
            'data' => getEvaluationRecordID($conn, $evalId, $evalData['id']),
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

        if(!count($isValid) || ($isValid["evaluation_id"] != ($_POST['eval'] ?? 0))) {
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

            // new fields
            'approved_by'           => emptyIsNull($_POST['approved_by']),
            'approved_by_sign'      => emptyIsNull($_POST['approver_sign']),
            'approve_date'          => emptyIsNull($_POST['approve_date']),
            'reviewed_by'           => emptyIsNull($_POST['reviewed_by']),
            'reviewed_by_sign'      => emptyIsNull($_POST['reviewer_sign']),
            'review_date'           => emptyIsNull($_POST['review_date']),
            'comments'              => emptyIsNull($_POST['comments']),
        ];

        $conn->insert("tbl_fsvp_cbp_records", $values);
        $id = $conn->getInsertId();

        $conn->commit();
        send_response([
            'message' => 'Successfully saved.',
            'data' => [
                'id' => $id,
                'ihash' => md5($id),
                'prev_id' => null,
                'foods_info' => $values['foods_info'],
                'supplier_info' => $values['supplier_info'],
                'determining_importer' => $values['determining_importer'],
                'designated_importer' => $values['designated_importer'],
                'cbp_entry_filer' => $values['cbp_entry_filer'],
                'comments' => $values['comments'],
                'reviewer' => [
                    'name' => $values['reviewed_by'],
                    'sign' => $values['reviewed_by_sign'],
                    'date' => $values['review_date'],
                ],
                'approver' => [
                    'name' => $values['approved_by'],
                    'sign' => $values['approved_by_sign'],
                    'date' => $values['approve_date'],
                ],
            ]
        ]);
    } catch(Throwable $e) {
        $conn->rollback();
        send_response([
            'error' => $e->getMessage(),
        ], 500);
    }
}

if(isset($_GET['updateCBPRecord'])) {
    try {
        $recordId = $_GET['updateCBPRecord'] ?? null;

        if(empty($recordId)) {
            throw new Exception('Unable to proceed.');
        }

        $conn->begin_transaction();

        $values = [
            $portal_user,
            $_POST['foods_info'],
            $_POST['supplier_info'],
            $_POST['determining_importer'],
            $_POST['designated_importer'],
            $_POST['cbp_entry_filer'],

            // new fields
            $_POST['approved_by'],
            $_POST['approve_date'],
            $_POST['reviewed_by'],
            $_POST['review_date'],
            $_POST['comments'],
        ];

        $setQuery = [
            'portal_user = ?',
            'foods_info = ?',
            'supplier_info = ?',
            'determining_importer = ?',
            'designated_importer = ?',
            'cbp_entry_filer = ?',
            'approved_by = ?',
            'approve_date = ?',
            'reviewed_by = ?',
            'review_date = ?',
            'comments = ?'
        ];

        // update approver sign if acquired
        if(!empty($_POST['approver_sign']) && $_POST['approver_sign'] != 'null') {
            $values[] = $_POST['approver_sign'];
            $setQuery[] = 'approved_by_sign = ?';
        }

        // update reviewer sign if acquired
        if(!empty($_POST['reviewer_sign']) && $_POST['reviewer_sign'] != 'null') {
            $values[] = $_POST['reviewer_sign'];
            $setQuery[] = 'reviewed_by_sign = ?';
        }

        // apppend the ids
        $values[] = $recordId;
        $values[] = $user_id;

        $setQuery = implode(', ', $setQuery);
        $conn->execute("UPDATE tbl_fsvp_cbp_records SET $setQuery WHERE id = ? AND user_id = ?", $values);

        $data = $conn->execute("SELECT * FROM tbl_fsvp_cbp_records WHERE id = ? AND user_id = ?", $recordId, $user_id)->fetchAssoc(function ($d) {
            return [
                'id' => $d['id'],
                'ihash' => md5($d['id']),
                'prev_id' => $d['prev_record_id'],
                'foods_info' => $d['foods_info'],
                'supplier_info' => $d['supplier_info'],
                'determining_importer' => $d['determining_importer'],
                'designated_importer' => $d['designated_importer'],
                'cbp_entry_filer' => $d['cbp_entry_filer'],
                'comments' => $d['comments'],
                'reviewer' => [
                    'name' => $d['reviewed_by'],
                    'sign' => $d['reviewed_by_sign'],
                    'date' => $d['review_date'],
                ],
                'approver' => [
                    'name' => $d['approved_by'],
                    'sign' => $d['approved_by_sign'],
                    'date' => $d['approve_date'],
                ],
            ];
        });

        $conn->commit();
        send_response([
            'message' => 'Successfully updated.',
            'data' => $data,
        ]);
    } catch(Throwable $e) {
        $conn->rollback();
        send_response([
            'error' => $e->getMessage(),
        ], 500);
    }
}

if(isset($_GET['foreignSuppliersMaterials'])) {
    $fsClause = ForeignSupplierSQLClause();
    
    $result = $conn->execute("SELECT
            MAT.ID AS id,
            MAT.material_name,
            SUPP.name AS supplier_name
        FROM tbl_supplier SUPP
        RIGHT JOIN tbl_supplier_material MAT
            ON MAT.ID IN (SUPP.material)
        WHERE
            1 = 1
            $fsClause
    ")->fetchAll();

    send_response([
        'data' => $result,
    ]);
}

if(isset($_POST['search-foreignMaterials'])) {
    $fsClause = ForeignSupplierSQLClause();
    $search = mysqli_real_escape_string($conn, $_POST['search-foreignMaterials']);
    
    $sql = "SELECT
                ipr.id,
                MAT.material_name,
                MAT.description,
                SUPP.name AS supplier_name,
                SUPP.ID as supplier_id
            FROM tbl_fsvp_ingredients_product_register ipr 
            LEFT JOIN tbl_fsvp_suppliers fsup ON fsup.id = ipr.supplier_id
            LEFT JOIN tbl_supplier SUPP ON SUPP.ID = fsup.supplier_id
            LEFT JOIN tbl_supplier_material MAT ON MAT.ID = ipr.product_id
            WHERE
                MAT.material_name LIKE '%$search%'
                AND ipr.user_id = ?
                AND fsup.deleted_at IS NULL
                AND ipr.deleted_at IS NULL
    ";
    
    $result = $conn->execute($sql
        // $fsClause, 
        ,$user_id
    )->fetchAll();

    send_response([
        'results' => $result,
        'count' => count($result),
    ]);
}

if(isset($_GET['ingredientProductRegister'])) {
    try {
        $conn->begin_transaction();
        $returnData = [];

        if(!empty($_POST['product_id'])) {
            // for update (edit details form)

            $isProductIdExist = $conn->execute("SELECT id FROM tbl_fsvp_ipr_imported_by WHERE id = ?", $_POST['product_id'])->fetchAll();
            if(count($isProductIdExist) == 0) {
                throw new Exception('Imported product does not exists.');
            }

            $setQuery = [
                'portal_user = ?',
                'importer_id = ?',
                'brand_name = ?',
                'ingredients_list = ?',
                'intended_use = ?',

                // newly added
                'approved_by = ?',
                'approve_date = ?',
                'reviewed_by = ?',
                'review_date = ?',
                'comments = ?'
            ];
            
            $values = [
                $portal_user,
                emptyIsNull($_POST['importer']),
                emptyIsNull($_POST['brand_name']),
                emptyIsNull($_POST['ingredients']),
                emptyIsNull($_POST['intended_use']),
                emptyIsNull($_POST['approved_by']),
                emptyIsNull($_POST['approve_date']),
                emptyIsNull($_POST['reviewed_by']),
                emptyIsNull($_POST['review_date']),
                emptyIsNull($_POST['comments']),
            ];

            // update approver sign if acquired
            if(!empty($_POST['approver_sign']) && $_POST['approver_sign'] != 'null') {
                $values[] = $_POST['approver_sign'];
                $setQuery[] = 'approved_by_sign = ?';
            }

            // update reviewer sign if acquired
            if(!empty($_POST['reviewer_sign']) && $_POST['reviewer_sign'] != 'null') {
                $values[] = $_POST['reviewer_sign'];
                $setQuery[] = 'reviewed_by_sign = ?';
            }

            // apppend the ids
            $values[] = $_POST['product_id'];
            $values[] = $user_id;

            $setQuery = implode(', ', $setQuery);
            $conn->execute("UPDATE tbl_fsvp_ipr_imported_by SET $setQuery WHERE id = ? AND user_id = ?", $values);
            
            $returnData = [
                'message' => 'Successfully updated.'
            ];
        } else {
            $iprId = emptyIsNull($_POST['ipr_id']);
            $importerId = emptyIsNull($_POST['importer']);

            $existingRecord = $conn->execute("SELECT iby.id FROM tbl_fsvp_ipr_imported_by iby WHERE iby.importer_id = ? AND iby.product_id = ?", $importerId, $iprId)->fetchAll();

            if(count($existingRecord)) {
                throw new Exception("The selected product has already been added to the importer.");
            }

            $mySupplier = $conn->execute("SELECT ipr.id
                FROM tbl_fsvp_importers imp
                JOIN tbl_fsvp_ingredients_product_register ipr ON ipr.id = ?
                WHERE imp.user_id = ? AND imp.id = ? AND imp.deleted_at IS NULL
                AND imp.supplier_id = ipr.supplier_id
            ", $iprId, $user_id, $importerId)->fetchAll();

            if(!count($mySupplier)) {
                throw new Exception("The foreign supplier of the selected product is not linked with the current importer.");
                
            }
            
            $conn->execute("INSERT INTO tbl_fsvp_ipr_imported_by(
                    user_id,
                    portal_user,
                    product_id,
                    importer_id,
                    brand_name,
                    ingredients_list,
                    intended_use,

                    -- new
                    'approved_by'
                    'approved_by_sign'
                    'approve_date'
                    'reviewed_by'
                    'reviewed_by_sign'
                    'review_date'
                    'comments'
                ) VALUE(".implode(',', array_fill(0, 12, '?')).")",
                $user_id,
                $portal_user,
                $iprId,
                $importerId,
                emptyIsNull($_POST['brand_name']),
                emptyIsNull($_POST['ingredients']),
                emptyIsNull($_POST['intended_use']),
                emptyIsNull($_POST['approved_by']),
                emptyIsNull($_POST['approver_sign']),
                emptyIsNull($_POST['approve_date']),
                emptyIsNull($_POST['reviewed_by']),
                emptyIsNull($_POST['reviewer_sign']),
                emptyIsNull($_POST['review_date']),
                emptyIsNull($_POST['comments']),
            );

            $id = $conn->getInsertId();
            $returnData = [
                'message' => 'Successfully registered.',
                'data' => [
                    'id'=> $id,
                ],
            ];
        }

        $conn->commit();
        send_response($returnData);
    } catch(Throwable $e) {
        $conn->rollback();
        send_response([
            'error' => $e->getMessage(),
        ], 500);
    }
}

// verified or imported products (with importer id)
if(isset($_GET['ingredientProductsRegisterData'])) {
    $results = $conn->execute("SELECT 
            iby.id,
            MD5(iby.id) as rhash,
            ipr.id AS ipr_id, -- ingredient product registry record id
            mat.material_name AS product_name,
            mat.description,
            iby.brand_name,
            iby.ingredients_list,
            iby.intended_use,
            iby.approved_by,            
            iby.approved_by_sign,
            iby.approve_date,
            iby.reviewed_by,            
            iby.reviewed_by_sign,
            iby.review_date,
            iby.comments,
            iby.importer_id,
            isup.name AS importer_name
        FROM tbl_fsvp_ipr_imported_by iby
        LEFT JOIN tbl_fsvp_ingredients_product_register ipr ON ipr.id = iby.product_id
        LEFT JOIN tbl_fsvp_importers imp ON imp.id = iby.importer_id
        LEFT JOIN tbl_fsvp_suppliers fsup ON ipr.supplier_id = fsup.id
        LEFT JOIN tbl_supplier_material mat ON mat.ID = ipr.product_id
        LEFT JOIN tbl_supplier isup ON isup.ID = imp.importer_id
        WHERE iby.user_id = ? 
            AND iby.deleted_at IS NULL 
            AND ipr.deleted_at IS NULL 
            AND fsup.deleted_at IS NULL
            AND imp.deleted_at IS NULL
        ORDER BY iby.created_at DESC
    ", $user_id)->fetchAll();

    send_response([
        'results' => $results,
        'importers' => getImportersByUser($conn, $user_id),
    ]);
}

if(isset($_GET['newActivityWorksheet'])) {
    try {
        $importerId = $_POST['importer_id'] ?? null;
        $supplierId = $_POST['supplier_id'] ?? null;
        $fsvpqiId = $_POST['fsvpqi_id'] ?? null;

        if(empty($importerId) || empty($supplierId) || empty($fsvpqiId)) {
            throw new Exception("Error: Incomplete data provided.");
        }

        $conn->begin_transaction();
        
         if(isset($_POST['editawid']) && !empty($_POST['editawid'])) {
            updateAWData($conn, $_POST, $portal_user, $_POST['editawid'], $importerId, $fsvpqiId, $supplierId);
        } 
        else {
             $isValid = $conn->execute("SELECT IF(COUNT(*) = 1, 'true', 'false') AS isValid
                FROM tbl_fsvp_importers 
                WHERE supplier_id = ?
                    AND id = ?
                    AND fsvpqi_id = ?
                    AND user_id = ? 
                    AND deleted_at IS NULL", 
                $supplierId, $importerId, $fsvpqiId, $user_id
            )->fetchAssoc()['isValid'] == 'true';
    
            if(!$isValid) {
                throw new Exception('Incorrect details.');
            }
            
            $sql = "INSERT INTO tbl_fsvp_activities_worksheets (
                    user_id,
                    portal_user,
                    importer_id,
                    fsvpqi_id,
                    supplier_id,
                    verification_date,
                    supplier_evaluation_date,
                    approval_date,
                    fdfsc,
                    pdipm,
                    fshc,
                    dfsc,
                    vaf,
                    justification_vaf,
                    verification_records,
                    assessment_results,
                    corrective_actions,
                    reevaluation_date,
                    comments
                ) VALUE (" . (implode(',', array_fill(0, 19, '?'))) . ")
            ";
            $values = [
                $user_id,
                $portal_user,
                $importerId,
                $fsvpqiId,
                $supplierId,
                emptyIsNull($_POST['verification_date']),
                emptyIsNull($_POST['supplier_evaluation_date']),
                emptyIsNull($_POST['approval_date']),
                emptyIsNull($_POST['fdfsc']),
                emptyIsNull($_POST['pdipm']),
                emptyIsNull($_POST['fshc']),
                emptyIsNull($_POST['dfsc']),
                emptyIsNull($_POST['vaf']),
                emptyIsNull($_POST['justification_vaf']),
                emptyIsNull($_POST['verification_records']),
                emptyIsNull($_POST['assessment_results']),
                emptyIsNull($_POST['corrective_actions']),
                emptyIsNull($_POST['reevaluation_date']),
                emptyIsNull($_POST['comments']),
            ];
    
            $conn->execute($sql, $values);
            $id = $conn->getInsertId();
        }
        
        
        $conn->commit();
        send_response([
            'message' => 'Recorded successfully!',
        ]);
    } catch(Throwable $e) {
        $conn->rollback();
        send_response([
            'error'=> $e->getMessage(),
        ], 500);
    }    
}

if(isset($_GET['activitiesWorksheetsInitialData'])) {
    $results = $conn->execute("SELECT 
            aw.id,
            MD5(aw.id) AS rhash,
            imp.name AS importer_name,
            sup.name AS supplier_name,
            CONCAT(TRIM(emp.first_name), ' ', TRIM(emp.last_name)) AS qi_name,
            aw.approval_date,
            aw.reevaluation_date AS evaluation_date,
            aw.comments,
            GROUP_CONCAT(sm.material_name SEPARATOR ', ') AS products
        FROM tbl_fsvp_activities_worksheets aw

        -- fsvp tables
        LEFT JOIN tbl_fsvp_importers fimp ON fimp.id = aw.importer_id
        LEFT JOIN tbl_fsvp_suppliers fsup ON fsup.id = aw.supplier_id
        LEFT JOIN tbl_fsvp_qi fqi ON fqi.id = aw.fsvpqi_id

        -- products
        LEFT JOIN tbl_fsvp_ipr_imported_by iby ON aw.importer_id = iby.importer_id
        LEFT JOIN tbl_fsvp_ingredients_product_register ipr ON ipr.id = iby.product_id
        LEFT JOIN tbl_supplier_material sm ON sm.ID = ipr.product_id

        -- references
        LEFT JOIN tbl_supplier imp ON imp.ID = fimp.importer_id
        LEFT JOIN tbl_supplier sup ON sup.ID = fsup.supplier_id
        LEFT JOIN tbl_hr_employee emp ON emp.ID = fqi.employee_id

        -- conditions
        WHERE aw.user_id = ?
            AND aw.deleted_at IS NULL
            AND ipr.deleted_at IS NULL
            
        -- other clauses
        GROUP BY aw.id
    ", $user_id)->fetchAll();

    send_response([
        'results' => $results,
    ]);
}

if(isset($_GET['fetchImporterBySupplier'])) {
    try {
        $supplierId = $_GET['fetchImporterBySupplier'] ?? null;

        if(empty($supplierId)) {
            throw new Exception("No supplier data has been acquired.");
        }

        $mySuppliers = $conn->execute("SELECT imp.id, sup.name, sup.address
            FROM tbl_fsvp_importers imp 
            LEFT JOIN tbl_fsvp_suppliers fsup ON fsup.id = imp.supplier_id
            LEFT JOIN tbl_supplier sup ON imp.importer_id = sup.ID
            WHERE imp.user_id = ? 
                AND imp.deleted_at IS NULL
                AND fsup.deleted_at IS NULL
                AND imp.supplier_id = ?
        ", $user_id, $supplierId)->fetchAll(function($data) {
            $data['address'] = formatSupplierAddress($data['address']);
            return $data;
        });

        send_response([
            'result' => $mySuppliers,
        ]);
    } catch(Throwable $e) {
        send_response([
            'error' => $e->getMessage(), 
        ], 500);
    }
}

if(isset($_GET['fetchProductsBySupplierAndImporter'])) {
    try {
        $supplierId = emptyIsNull($_POST['supplier']);
        $importerId = emptyIsNull($_POST['importer']);
    
        if(empty($supplierId)) {
            throw new Exception("You must select a foreign supplier.");
        }
        
        if(empty($importerId) || !$importerId) {
            throw new Exception("You must select an importer.");
        }
        
        $results = $conn->execute("SELECT
                GROUP_CONCAT(mat.material_name SEPARATOR ', ') AS products
            FROM tbl_fsvp_ipr_imported_by iby
            LEFT JOIN tbl_fsvp_ingredients_product_register ipr ON ipr.id = iby.product_id
            LEFT JOIN tbl_supplier_material mat ON mat.ID = ipr.product_id
            WHERE iby.importer_id = ?
                AND ipr.supplier_id = ?
                AND iby.user_id = ?
                AND iby.deleted_at IS NULL
                AND ipr.deleted_at IS NULL
            GROUP BY iby.importer_id
        ", $importerId, $supplierId, $user_id)->fetchAssoc();

        send_response([
            'results' => $results['products']
        ]);
            
    } catch(Throwable $e) {
        send_response([
            'error' => $e->getMessage(),
        ], 500);
    }
}


if(isset($_GET['getActivitiesWorksheet']) && !empty($_GET['getActivitiesWorksheet'])) {
    $id = $_GET['getActivitiesWorksheet'] ?? 0;
    
    $data = $conn->execute("SELECT 
            aw.*
        FROM tbl_fsvp_activities_worksheets aw
        WHERE aw.user_id = ?
            AND aw.deleted_at IS NULL
            AND aw.id = ?
            
    ", $user_id, $id)->fetchAssoc();

    send_response([
        'data' => $data,
    ]);
}