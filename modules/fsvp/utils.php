<?php

include_once __DIR__ ."/../../alt-setup/setup.php";

function getSuppliersByUser($conn, $userId) {
    return $conn->select("tbl_supplier", "ID as id, name", [ 'user_id'=> $userId, 'status'=>1, 'page'=>1])->fetchAll();
}

function getRealFileName($fileName) {
    $fn = explode(' - ', $fileName);
    unset($fn[0]);
    return implode(' - ', $fn);
}

function getSupplierList($conn, $userId) {
    $recordType = 'supplier-list:';

    $list = $conn->execute("SELECT fs.*, s.name, s.address FROM tbl_fsvp_suppliers fs 
        JOIN tbl_supplier s ON s.ID = fs.supplier_id
        WHERE fs.user_id = ? AND fs.deleted_at IS NULL
        ORDER BY fs.created_at DESC
    ", $userId)->fetchAll();

    $data = [];
    foreach ($list as $d) {
        [$a1, $a2, $a3, $a4, $a5] = preg_split("/\||,/", $d["address"]);
        $address = implode(', ', array_filter(array_map(function ($a) {
            return htmlentities(trim($a));
        }, [ $a2, $a3, $a4, $a1, $a5 ]), function($a) { return !empty($a); }));

        $mIds = implode(', ', json_decode($d['food_imported']));
        $materialData = $conn->select("tbl_supplier_material", "material_name AS name, ID as id", "ID in ($mIds)")->fetchAll();

        // fetching stored files
        $mFiles = $conn->select("tbl_fsvp_files","*", "deleted_at IS NULL AND record_type LIKE '$recordType%' AND record_id = " . $d['id'])->fetchAll();

        $saFiles = [];
        $csFile = [];

        if(count($mFiles) > 0) {
            foreach ($mFiles as $mFile) {
                $fileData = $mFile;

                // removing unwanted data
                unset(
                    $fileData['record_id'],
                    $fileData['record_type'],
                    $fileData['deleted_at'],
                    $fileData['created_at'],
                    $fileData['updated_at'],
                );

                $fileData['uploaded_at'] = date('Y-m-d', strtotime($fileData['uploaded_at'])); 

                if($mFile['record_type'] == 'supplier-list:supplier-agreement') {
                    $saFiles[] = $fileData;
                } else if($mFile['record_type'] == 'supplier-list:compliance-statement') {
                    $csFile[] = $fileData;
                }
            }
        }
        
        $data[] = [
            'address' => $address,
            'name' => $d['name'],
            'id' => $d['id'],
            'food_imported' => $materialData,
            'compliance_statement' => $csFile,
            'supplier_agreement' => $saFiles,
            'files' => $mFiles,
        ];
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
    return $result['ID'];
} 