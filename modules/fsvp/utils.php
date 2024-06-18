<?php

include_once __DIR__ ."/../../alt-setup/setup.php";
date_default_timezone_set('America/Chicago');

function ForeignSupplierSQLClause($firstAnd = true) {
    return ($firstAnd ? " AND " : " ") . "TRIM(SUBSTRING_INDEX(address, ',', 1)) NOT LIKE 'US' AND TRIM(SUBSTRING_INDEX(address, '|', 1)) NOT LIKE 'US'";
}

function getSuppliersByUser($conn, $userId) {
    $y = 1;
    return $conn->execute("SELECT ID as id, name, address 
        FROM tbl_supplier 
        WHERE user_id = ? AND status = 1 AND page = 1
    ", $userId)
        ->fetchAll(function($d) {
            $d['address'] = formatSupplierAddress($d['address']);
            return $d;
        });
    // return $conn->select("tbl_supplier", "ID as id, name, address", [ 'user_id'=> $userId, 'status'=> $y, 'page'=>$y])
    //     ->fetchAll();
}

function getImportersByUser($conn, $userId) {
    return $conn->execute(
        "SELECT imp.id, sup.name, sup.address FROM tbl_fsvp_importers imp 
         JOIN tbl_supplier sup ON sup.ID = imp.importer_id
         WHERE imp.user_id = ? AND deleted_at IS NULL",
        $userId
    )->fetchAll(function($data) { 
        $data['address'] = formatSupplierAddress($data['address']);
        return $data;
    });
}

function getRealFileName($fileName) {
    $fn = explode(' - ', $fileName);
    unset($fn[0]);
    return implode(' - ', $fn);
}

function formatSupplierAddress($add) {
    [$a1, $a2, $a3, $a4, $a5] = preg_split("/\||,/", $add);
    return implode(', ', array_filter(array_map(function ($a) {
        return htmlentities(trim($a));
    }, [ $a2, $a3, $a4, $a1, $a5 ]), function($a) { return !empty($a); }));
}

// foreign suppliers
function getSupplierList($conn, $userId) {
    try {
        $recordType = 'supplier-list:';

        $sql = "SELECT 
                    tbl_fsvp_suppliers.id,
                    tbl_fsvp_suppliers.supplier_id,
                    tbl_supplier.name,
                    tbl_supplier.address,
                    tbl_fsvp_suppliers.supplier_agreement,
                    tbl_fsvp_suppliers.compliance_statement,
                    'FSVP Supplier' AS source
                FROM 
                    tbl_fsvp_suppliers
                JOIN 
                    tbl_supplier ON tbl_fsvp_suppliers.supplier_id = tbl_supplier.ID
                WHERE 
                    tbl_fsvp_suppliers.user_id = ?

                UNION

                SELECT 
                    NULL,
                    tbl_supplier.ID,
                    tbl_supplier.name,
                    tbl_supplier.address,
                    NULL,
                    NULL,
                    'Foreign Supplier' AS source
                FROM 
                    tbl_supplier
                WHERE 
                    TRIM(SUBSTRING_INDEX(tbl_supplier.address, ',', 1)) NOT LIKE 'US' AND TRIM(SUBSTRING_INDEX(tbl_supplier.address, '|', 1)) NOT LIKE 'US' 
                    AND tbl_supplier.user_id = 464
                    AND tbl_supplier.is_deleted = 0
                    AND tbl_supplier.`status` = 1
                    AND tbl_supplier.ID NOT IN (
                        SELECT supplier_id 
                        FROM tbl_fsvp_suppliers
                        WHERE tbl_fsvp_suppliers.user_id = ?
                    );
        ";

        $list = $conn->execute($sql, $userId, $userId)->fetchAll();
    
        $data = [];
        foreach ($list as $d) {
            $address = formatSupplierAddress($d["address"]);

            // fetch imported products data
            $importedProducts = $conn->execute("SELECT product_id FROM tbl_fsvp_ingredients_product_register WHERE supplier_id = ? AND user_id = ? AND deleted_at IS NULL", $d["id"], $userId)->fetchAll(function ($d) { return $d['product_id']; });
            
            $materialData = [];
            if(count($importedProducts) > 0) {
                $mIds = implode(', ', $importedProducts) ?? '';
                $materialData = $conn->select("tbl_supplier_material", "material_name AS name, ID as id", "ID in ($mIds)")->fetchAll();
            }
    
            $saFiles = [];
            $csFile = [];
            
            // fetching stored files
            if(!empty($d['id'])) {
                $mFiles = $conn->select("tbl_fsvp_files","*", "deleted_at IS NULL AND record_type LIKE '$recordType%' AND record_id = " . $d['id'])->fetchAll();
                if(count($mFiles) > 0) {
                    foreach ($mFiles as $mFile) {
                        $fileData = prepareFileInfo($mFile);
                        
                        if($mFile['record_type'] == 'supplier-list:supplier-agreement') {
                            $saFiles[] = $fileData;
                        } else if($mFile['record_type'] == 'supplier-list:compliance-statement') {
                            $csFile[] = $fileData;
                        }
                    }
                }
            }
                        
            $data[] = [
                'address' => $address,
                'name' => $d['name'],
                'id' => $d['id'],
                'supplier_id' => $d['supplier_id'],
                'evaluation' => getEvaluationRecordID($conn, $d['id']),
                'food_imported' => $materialData,
                'compliance_statement' => $csFile,
                'supplier_agreement' => $saFiles,
            ];
        }
    
        return $data;
    } catch(Throwable $e) {
        send_response([
            'error' => $e->getMessage(),
        ], 500);
    }
}

/**
 * TODO:
 * re-evaluate this query if issues occur
 * specially the ORDER BY clause
 * also do the same in getEvaluationRecordID function
 */
// evaluation data for every supplier in the supplier list page
function getEvaluationData($conn, $evalId, $recordId = null) {
    $cond = "eval.id = ?" . (!empty($recordId) ? " AND rec.id = ?" : "");
    $params = [ $evalId];
    !empty($recordId) && $params[] = $recordId;     
    $eval = $conn->execute("SELECT 
                eval.id,
                eval.evaluation,
                rec.id AS record_id,
                rec.status,
                rec.evaluation_date,
                rec.evaluation_due_date,
                rec.sppp,
                rec.import_alerts,
                rec.recalls,
                rec.warning_letters,
                rec.other_significant_ca,
                rec.suppliers_corrective_actions,
                eval.info_related,
                eval.rejection_date,
                eval.approval_date,
                eval.assessment,
                eval.description,
                supp.name AS supplier_name, 
                supp.address AS supplier_address,
                imp.name AS importer_name, 
                imp.address AS importer_address,
                fsupp.food_imported
            FROM tbl_fsvp_evaluations eval
            LEFT JOIN tbl_fsvp_evaluation_records rec ON eval.id = rec.evaluation_id
            LEFT JOIN tbl_fsvp_suppliers fsupp ON eval.supplier_id = fsupp.id
            LEFT JOIN tbl_fsvp_importers fimp ON eval.importer_id = fimp.id
            -- tbl_suppliers (original)
            LEFT JOIN tbl_supplier supp ON supp.ID = fsupp.supplier_id
            LEFT JOIN tbl_supplier imp ON imp.ID = fimp.importer_id 
                WHERE $cond AND eval.deleted_at IS NULL
            ORDER BY rec.pre_record_id DESC, rec.evaluation_date DESC, rec.created_at DESC LIMIT 1",
            $params 
        )->fetchAssoc(function($d) {
            $d['supplier_address'] = formatSupplierAddress($d['supplier_address']);
            $d['importer_address'] = formatSupplierAddress($d['importer_address']);
            $d['rhash'] = md5($d['record_id']);
            return $d;
        });
        
    // files
    $evalFileCategoriesToFetch = [];
    ($eval['import_alerts'] == 1) && ($evalFileCategoriesToFetch[] = 'import-alerts');
    ($eval['recalls'] == 1) && ($evalFileCategoriesToFetch[] = 'recalls');
    ($eval['warning_letters'] == 1) && ($evalFileCategoriesToFetch[] = 'warning-letters');
    ($eval['other_significant_ca'] == 1) && ($evalFileCategoriesToFetch[] = 'other-significant-ca');
    ($eval['suppliers_corrective_actions'] == 1) && ($evalFileCategoriesToFetch[] = 'suppliers-corrective-actions');

    if(count($evalFileCategoriesToFetch) > 0) {
        $eval['files'] = fetchEvaluationFiles($conn, $eval['record_id'], $evalFileCategoriesToFetch);
    }

    $eval['food_imported'] = getSupplierFoodImported($conn, $eval['food_imported']);

    return $eval;
}

function getEvaluationRecordID($conn, $supplierId) {
    try {
        $data = $conn->execute("SELECT 
                EVAL.id,
                REC.id AS record_id,
                REC.status, 
                REC.evaluation_date, 
                REC.evaluation_due_date,
                IMP.name AS importer_name,
                IMP.address AS importer_address,
                SUPP.name AS supplier_name,
                SUPP.address AS supplier_address
            FROM tbl_fsvp_evaluations EVAL
            LEFT JOIN tbl_fsvp_evaluation_records REC ON EVAL.id = REC.evaluation_id
            LEFT JOIN tbl_fsvp_suppliers FSUPP ON FSUPP.id = EVAL.supplier_id
            LEFT JOIN tbl_fsvp_importers FIMP ON FIMP.id = EVAL.importer_id
            LEFT JOIN tbl_supplier SUPP ON SUPP.ID = FSUPP.supplier_id
            LEFT JOIN tbl_supplier IMP ON IMP.ID = FIMP.importer_id
            WHERE EVAL.supplier_id = ? AND EVAL.deleted_at IS NULL 
            ORDER BY REC.pre_record_id DESC, REC.evaluation_date DESC, REC.created_at DESC LIMIT 1",
            $supplierId)->fetchAssoc();

        if(!count($data)) {
            return null;
        } else {
            $data['supplier_address'] = formatSupplierAddress($data['supplier_address']);
            $data['importer_address'] = formatSupplierAddress($data['importer_address']);
            
            if($data['status'] == 'current') {
                $data['status'] = updateCurrentEvalStatus($conn, $data['evaluation_due_date'], $data['record_id']);
            }
        }

        return $data;
    } catch(Throwable $e) {
        throw $e;
    }
}

function updateCurrentEvalStatus($conn, $due, $id) {
    $evalDueDate = strtotime($due);
    $current = strtotime(date('Y-m-d'));
    
    // already dued
    if($evalDueDate <= $current) {
        $conn->update("tbl_fsvp_evaluation_records", ['status' => 'expired'], "id = $id");
        return 'expired';
    }

    return 'current';
}

function getSupplierFoodImported($conn, $foodIds) {
    // not: empty array  or string
    if(!empty($foodIds) && count(($foodIds = json_decode($foodIds))) > 0) {
        $ids = implode(',', $foodIds);
        return $conn->select("tbl_supplier_material", "material_name AS name, description", "ID in ($ids) AND active = 1")->fetchAll();
    }
    
    return null;
}

// fetching evaluation files
function fetchEvaluationFiles($conn, $recordId, $fileCategories) {
    $recordType = implode(',', array_map(function($c) { return "'evaluation:$c'"; }, $fileCategories));
    $sql = "SELECT * FROM tbl_fsvp_files WHERE (record_type IN ($recordType)) AND record_id = ? AND deleted_at IS NULL";
    $result = $conn->execute($sql, $recordId)->fetchAll();

    if(count($result) == 0) {
        return null;
    }

    $data = [];
    foreach($result as $d) {
        $cat = str_replace('-', '_', explode(':', $d['record_type'])[1]);
        $data[$cat] = prepareFileInfo($d);
    }

    return $data;
}

function getEmployeesInfo($conn, $employeeIds, $jdIds) {
    if(count($employeeIds) == 0)
        return;
    
    $userAvatars = [];
    $jds = [];
    $employeeIds = implode(',', $employeeIds);
    $conn->execute("SELECT ui.avatar, ui.mobile, u.employee_id AS eid FROM tbl_user_info ui JOIN tbl_user u ON u.ID = ui.user_id WHERE u.employee_id IN ($employeeIds)")
        ->fetchAll(function($data) use(&$userAvatars) {
            $userAvatars[$data['eid']] = [
                'avatar'=> 'uploads\\avatar\\' . $data['avatar'],
                'mobile' => $data['mobile'],
                'eid' => $data['eid'],
            ];
            return $data;
        });

    // fetching job descriptions
    $jdIds = implode(',', array_filter(array_map(function($x) {return intval($x) ?? null;}, $jdIds), function($x) {return $x;}));
    $conn->execute("SELECT title, ID FROM tbl_hr_job_description WHERE ID IN ($jdIds)")
        ->fetchAll(function($data) use(&$jds) {
            $jds[$data['ID']] = trim($data['title']);
            return $data;
        });

    return [
        'job_descriptions'=> $jds,
        'employees_info'=> $userAvatars,
    ];
}

function fsvpqiJDId($conn, $user_id) {
    $result = $conn->execute("SELECT ID FROM tbl_hr_job_description WHERE title LIKE '%fsvpqi%' AND status = 1 AND user_id = ? LIMIT 1", $user_id)->fetchAssoc();
    return count($result) > 0 ? $result['ID'] : null;
} 

function embedFileUrl($file, $url) {
    global $pageUrl;
    $extension = pathinfo($file, PATHINFO_EXTENSION);

    if (
        (strtolower($extension) == "doc" || strtolower($extension) == "docx") ||
        (strtolower($extension) == "ppt" || strtolower($extension) == "pptx") || 
        (strtolower($extension) == "xls" || strtolower($extension) == "xlsb" || strtolower($extension) == "xlsm" || strtolower($extension) == "xlsx" OR strtolower($extension) == "csv" OR strtolower($extension) == "xlsx")
    ) {
        $src = 'https://view.officeapps.live.com/op/embed.aspx?src=';
        $embed = '&embedded=true';
        
        return $src.$pageUrl.'/'.$url.'/'.rawurlencode($file).$embed;
        // return [
        //     'isIframe' => true,
        //     'url' => $src.$url.rawurlencode($file).$embed,
        // ];
    }

    $etc = '';
    if(strtolower($extension) == "pdf") {
        $etc = '?fancybox_type=no_iframe';
    }

    return $url.'/'.rawurlencode($file).$etc;
}

function prepareFileInfo($data) {
    if(empty($data)) {
        return null;
    }
    
    $filename = getRealFileName($data['filename']);

    return [
        'id' => $data['id'] ?? null,
        'filename' => $filename,
        'src' => embedFileUrl($data['filename'], $data['path']),
        'note' => empty($data['note']) ? '(none)': $data['note'],
        'document_date' => $data['document_date'],
        'expiration_date' => $data['expiration_date'],
        'upload_date' => date('Y-m-d', strtotime($data['uploaded_at'])),
    ];
}

function saveFSVPQICertificate($postData, $name) {
    if(isset($postData[$name]) && $postData[$name] == 'true') {
        $uploadPath = getUploadsDir('fsvp/qi_certifications');
        $currentTimestamp = date('Y-m-d H:i:s');
        
        $file = uploadFile($uploadPath, $_FILES[$name .'-file']);
        return [
            "filename" => $file,
            "path" => $uploadPath,
            "document_date" => $postData[$name . '-document_date'] ?? null,
            "expiration_date" => $postData[$name . "-expiration_date"] ?? null,
            "note" => $postData[$name . "-note"] ?? null,
            "uploaded_at" => $currentTimestamp,
        ];
    }

    throw new Exception('Unable to save file.');
}

function saveEvaluationFile($postData, $name) {
    if(isset($postData[$name]) && $postData[$name] == 1) {
        try {
            $uploadPath = getUploadsDir('fsvp/evaluation_docs');
            $currentTimestamp = date('Y-m-d H:i:s');
            
            $file = uploadFile($uploadPath, $_FILES[$name .'-file']);
            return [
                'record_type' => 'evaluation:' . str_replace('_', '-', $name),
                "filename" => $file,
                "path" => $uploadPath,
                "document_date" => $postData[$name . '-document_date'] ?? null,
                "expiration_date" => $postData[$name . "-expiration_date"] ?? null,
                "note" => $postData[$name . "-note"] ?? null,
                "uploaded_at" => $currentTimestamp,
            ];
        } catch(Throwable $e) {
            throw $e;
        }
    } else {
        return null;
    }
}

function saveEvalFiles($postData, $conn, $id) {
    return array_map(function ($fileData) use($conn, $id) {
        $conn->insert("tbl_fsvp_files", array_merge(['record_id' => $id], $fileData));
        $fileData['id'] = $conn->getInsertId();
        $fileData['filename'] = embedFileUrl($fileData['filename'], $fileData['path']);
        unset($fileData['path']);
        return $fileData;
    }, array_filter([
        saveEvaluationFile($postData, 'import_alerts'),
        saveEvaluationFile($postData, 'recalls'),
        saveEvaluationFile($postData, 'warning_letters'),
        saveEvaluationFile($postData, 'other_significant_ca'),
        saveEvaluationFile($postData, 'suppliers_corrective_actions'),
    ], function($r) { return is_array($r); }));
}

function saveNewEvaluationRecord($conn, $post, $evalId, $preRecordId = null) {
    global $user_id, $portal_user;
    try {

        /**
         * TODO:
         * add a validation if the previous evaluation record is not yet expired, do not allow saving new record
         */
        
        $conn->begin_transaction();
        $dueDate = emptyIsNull($post['evaluation_due_date']);

        $params = [
            'user_id'                       => $user_id,
            'portal_user'                   => $portal_user,
            'evaluation_id'                 => $evalId,
            'pre_record_id'                 => $preRecordId,
            'status'                        => 'current',
            'evaluation_date'               => emptyIsNull($post['evaluation_date']),
            'evaluation_due_date'           => $dueDate,
            'sppp'                          => emptyIsNull($post['sppp']),
            'import_alerts'                 => $post['import_alerts'] ?? NULL,
            'recalls'                       => $post['recalls'] ?? NULL,
            'warning_letters'               => $post['warning_letters'] ?? NULL,
            'other_significant_ca'          => $post['other_sca'] ?? NULL,
            'suppliers_corrective_actions'  => $post['supplier_corrective_actions'] ?? NULL,
        ];

        // evaluate due date if already expired
        if(isset($dueDate) && strtotime($dueDate) <= strtotime(date('Y-m-d'))) {
            $params['status'] = 'expired';
        }

        $conn->insert("tbl_fsvp_evaluation_records", $params);
        $id = $conn->getInsertId();
        saveEvalFiles($post, $conn, $id);

        $conn->commit();

        $data = $params;
        $data['record_id'] = $id;
        $data['id'] = $data['evaluation_id'];

        unset(
            $data['user_id'],
            $data['portal_user'],
            $data['evaluation_id'],
            $data['sppp'],
            $data['import_alerts'],
            $data['recalls'],
            $data['warning_letters'],
            $data['other_significant_ca'],
            $data['suppliers_corrective_actions'],
        );
        
        return $data;
    } catch(Throwable $e) {
        $conn->rollback();
        throw $e;
    }
}

// schedule
// function 