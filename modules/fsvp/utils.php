<?php

include_once __DIR__ ."/../../alt-setup/setup.php";
date_default_timezone_set('America/Chicago');

function getSuppliersByUser($conn, $userId) {
    return $conn->select("tbl_supplier", "ID as id, name", [ 'user_id'=> $userId, 'status'=>1, 'page'=>1])->fetchAll();
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

function getSupplierList($conn, $userId) {
    try {
        $recordType = 'supplier-list:';

        $list = $conn->execute("SELECT fs.*, s.name, s.address FROM tbl_fsvp_suppliers fs 
            JOIN tbl_supplier s ON s.ID = fs.supplier_id
            WHERE fs.user_id = ? AND fs.deleted_at IS NULL
            ORDER BY fs.created_at DESC
        ", $userId)->fetchAll();
    
        $data = [];
        foreach ($list as $d) {
            $address = formatSupplierAddress($d["address"]);
            $mIds = implode(', ', json_decode($d['food_imported']));
            $materialData = $conn->select("tbl_supplier_material", "material_name AS name, ID as id", "ID in ($mIds)")->fetchAll();
    
            // fetching stored files
            $mFiles = $conn->select("tbl_fsvp_files","*", "deleted_at IS NULL AND record_type LIKE '$recordType%' AND record_id = " . $d['id'])->fetchAll();
    
            $saFiles = [];
            $csFile = [];
    
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
    
            $evalData = getCurrentEvaluation($conn, $d['id']);
            $evalStatus = null;

            if(!count($evalData)) {
                $evalStatus = 'none';
            } else {
                $evalDueDate = strtotime($evalData['evaluation_due_date']);
                $current = strtotime(date('Y-m-d'));
                
                if($evalDueDate <= $current) {
                    $evalStatus = 'due';
                } else {
                    $evalStatus = 'done';
                }
            }
                        
            $data[] = [
                'address' => $address,
                'name' => $d['name'],
                'id' => $d['id'],
                'evaluation_id' => $evalData['id'] ?? null,
                'evaluation_date' => $evalData['evaluation_date'] ?? null,
                'evaluation_status' => $evalStatus,
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

function getCurrentEvaluation($conn, $supplierId) {
    return $conn->execute("SELECT * FROM tbl_fsvp_evaluations WHERE supplier_id = ? AND deleted_at IS NULL ORDER BY created_at DESC LIMIT 1", $supplierId)->fetchAssoc();
}

// evaluation data for every supplier in the supplier list page
function getEvaluationData($conn, $supplierId) {
    $data = $conn->execute("SELECT * FROM tbl_fsvp_evaluations WHERE status = 'current' AND supplier_id = ? AND deleted_at IS NULL ORDER BY created_at DESC LIMIT 1", $supplierId)->fetchAssoc();

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
        $embed = '&embedded=true&isIframe=true';
        
        return $src.$pageUrl.'/'.$url.'/'.rawurlencode($file).$embed;
        // return [
        //     'isIframe' => true,
        //     'url' => $src.$url.rawurlencode($file).$embed,
        // ];
    }

    return $url.'/'.rawurlencode($file);
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


// schedule
function 